
import {UserJSONParser} from "Root/user/user";

import Point from "./Point.js";
import MapView from "./MapView.js";
import CellView from "./CellView.js";

import MapState from "./MapState.js";

import BudgetManager from "Root/session/budget/budgetManager";
import PlansView from "Root/session/plans/plans-view";
import {Plan, PlansManager} from "Root/session/plans/plans-model";

import {MakeConnections} from "Root/session/plans/di";
import {CubeCoordinate, OffsetCoordinate} from "Root/map/HexCoordinate";

///////////////////////////////////////////////////////////////////////

//let mapRaw = '32|31;2;7"33|29;0;0|30;0;0|31;0;8|32;0;0|33;0;0"34|31;0;0"35|31;0;0"36|30;0;0|32;0;0"37|30;0;0|32;0;0"';
//35|30;0;0|31;4;7|32;0;0"36|29;0;0|30;5;7|31;0;8|32;3;7|33;0;0"37|30;6;7|31;1;7|32;2;7"38|30;0;0|32;0;0"

let mapRaw = serverData.mapRaw;

let userList = UserJSONParser(serverData.usersJSON);

console.log(userList);

let map = new MapState(mapRaw);

let view = new MapView(document.getElementById("MapBoard"), {
    offsetX : -map.MapParams.minX*(MapView.OPTIONS.hexWidth) + 100,
    offsetY : -map.MapParams.minY*(MapView.OPTIONS.hexHeight - MapView.OPTIONS.hexMiddleSection) + 100,
});

let cellV = new CellView(view, {});

/*
console.log("MapParams");
console.log(map.MapParams);

console.log("ViewOptions");
console.log(view.options);

console.log(map.map);
*/

// Показываем карту
map.forEachCell(function (cell, point) {
    cellV.appendHex(cell, point);
});

// Ставим на доску eventListener для проверки кликов
view.board.addEventListener("click", function (e) {

    let pt = new Point(e.pageX, e.pageY);
    //alert(pt.x + " " + pt.y);
    console.log(view.pixelToPoint(pt));
    console.log(view.lastPoint);
});

let budgetManager = new BudgetManager(1000);
let plansManager = new PlansManager(budgetManager);
let plansView = new PlansView(mainJsFrame, plansManager);

MakeConnections( mainJsFrame, view, map, plansView, plansManager, userList );
plansView.init();

console.log( plansManager );