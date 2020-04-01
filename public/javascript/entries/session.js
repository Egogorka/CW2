
import User, {UserJSONParser} from "Root/user/user";

import Point from "Root/map/Point";
import MapView from "Root/map/MapView";
import CellView from "Root/map/CellView";

import MapState from "Root/map/MapState";

import BudgetManager from "Root/session/budget/budgetManager";
import BudgetView from "Root/session/budget/budgetView";
import PlansView from "Root/session/plans/plans-view";
import {Plan, PlansManager} from "Root/session/plans/plans-model";

import {MakeConnections} from "Root/session/plans/di";
import {CubeCoordinate, OffsetCoordinate} from "Root/map/HexCoordinate";
import SessionSockets from "Root/session/sockets/SessionSockets";
import SocketPackage from "Root/session/sockets/SocketPackage";
import AttackView from "Root/session/plans/attack/attack-view";
import AttackArrowView from "Root/session/plans/attack/attack-arrow-view";

///////////////////////////////////////////////////////////////////////

//let mapRaw = '32|31;2;7"33|29;0;0|30;0;0|31;0;8|32;0;0|33;0;0"34|31;0;0"35|31;0;0"36|30;0;0|32;0;0"37|30;0;0|32;0;0"';
//35|30;0;0|31;4;7|32;0;0"36|29;0;0|30;5;7|31;0;8|32;3;7|33;0;0"37|30;6;7|31;1;7|32;2;7"38|30;0;0|32;0;0"

let mapRaw = serverData.mapRaw;

let user = new User();
user.getFromJson(serverData.user);

let userList = UserJSONParser(serverData.usersJSON);

console.log(user);
console.log(userList);

let mapState = new MapState(mapRaw);

let mapView = new MapView(document.getElementById("MapBoard"), {
    offsetX : -mapState.MapParams.minX*(MapView.OPTIONS.hexWidth) + 100,
    offsetY : -mapState.MapParams.minY*(MapView.OPTIONS.hexHeight - MapView.OPTIONS.hexMiddleSection) + 100,
});

let cellV = new CellView(mapView, {});

/*
console.log("MapParams");
console.log(map.MapParams);

console.log("ViewOptions");
console.log(view.options);

console.log(map.map);
*/

// Показываем карту
mapState.forEachCell(function (cell, point) {
    cellV.appendHex(cell, point);
});

// Ставим на доску eventListener для проверки кликов
mapView.board.addEventListener("click", function (e) {
    let pt = new Point(e.pageX, e.pageY);
    //alert(pt.x + " " + pt.y);
    console.log(mapView.pixelToPoint(pt));
});

let budgetManager = new BudgetManager(serverData.budget);
let budgetView = new BudgetView(budgetManager);

let plansManager = new PlansManager(budgetManager);

let plansView = new PlansView(mainJsFrame, plansManager);
let attackView = new AttackView(mainJsFrame, mapView, mapState, plansView, plansManager, userList);

//MakeConnections( mainJsFrame, view, map, plansView, plansManager, userList );

/////////////////////////////////////////////////////////////////
plansView.addPlanViewHandler( Plan.TYPES.attack , attackView);

plansView.init();
/////////////////////////////////////////////////////////////////

attackView.addHandlerCreate(function (attack) {
    plansManager.addPlan(new Plan(Plan.TYPES.attack, attack));
});
attackView.addHandlerCreate(function (attack) {
    let plan = new Plan(Plan.TYPES.attack, attack);
    sockets.sendPackage(new SocketPackage(SocketPackage.TYPES.planCreate, plan.getJson()));
});

plansView.frame.on("#plan-end-button", "click", function () {
    console.log("Planning end");
    sockets.sendPackage(new SocketPackage(SocketPackage.TYPES.planningEnd));
});

let attackArrowView = new AttackArrowView( mapView );

// PlansManager Events

plansManager.addHandlerCreate( (plansView.onCreate).bind(plansView), Plan.TYPES.attack );
plansManager.addHandlerDelete( (plansView.onDelete).bind(plansView), Plan.TYPES.attack );

plansManager.addHandlerCreate( (attackArrowView.onCreate).bind(attackArrowView), Plan.TYPES.attack);
plansManager.addHandlerDelete( (attackArrowView.onDelete).bind(attackArrowView), Plan.TYPES.attack);

///////////////////////////////////////////////////////////////////////////////////////////



console.log( plansManager );

let sockets = new SessionSockets({
    "userId" : user.id,
    "clanId" : user.clanId,
    "sessionId" : serverData.sessionId,
});

sockets.setHandler( function ( socketPackage ) {
    alert("Got a message!");
    console.log( "Got data from server : \n", socketPackage.getData(), "\n", socketPackage.getType(), "\n", socketPackage.getSenderName());
}, SocketPackage.TYPES.message);

// /** @var {Plan} plan */
// plansManager.addHandlerCreate(function (plan, id) {
//     sockets.sendPackage(new SocketPackage(SocketPackage.TYPES.planCreate, plan.getJson()));
// }, Plan.TYPES.attack);

sockets.setHandler( function (socketPackage) {
    let plan = new Plan();
    let data = socketPackage.getData();
    plan.getFromJson(data);

    alert("Got a message! New attack!");

    console.log(plan);

    if( socketPackage.getSenderName() === user.name )
        return;

    plansManager.addPlan(plan);
}, SocketPackage.TYPES.planCreate);