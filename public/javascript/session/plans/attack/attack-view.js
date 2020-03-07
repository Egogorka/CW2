import Point from "Root/map/Point";

import Attack from "Root/session/plans/attack/attack";
import {Plan} from "Root/session/plans/plans-model";

import JSFrame from "jsframe.js";
import MapView from "Root/map/MapView";
import MapState from "Root/map/MapState";

import {PlansManager} from "Root/session/plans/plans-model";
import PlansView from "Root/session/plans/plans-view";

import {CubeCoordinate, Coordinate} from "Root/map/HexCoordinate";

import Hex from "Root/map/Hex";
import user from "Root/user/user";

export default class AttackView {

    /**
     * @param {JSFrame} jsFrame
     * @param {MapView} mapView
     * @param {MapState} mapState
     * @param {PlansManager} plansManager
     * @param {PlansView} plansView
     * @param {User[]} usersList
     */
    constructor(jsFrame, mapView, mapState, plansView, plansManager, usersList) {

        this.jsFrame = jsFrame;

        this.mapView = mapView;
        this.mapState = mapState;

        this.plansManager = plansManager;
        this.plansView = plansView;

        this.usersList = usersList;

        this.handlersCreate = [];
    }

    showAdder() {

        let that = this;

        let attack = {
            hexFrom: null,
            hexTo: null,
            budget: null,
        };

        let html1 = document.getElementById("attack-add-budget-window").innerHTML;
        let html2 = document.getElementById("attack-add-hexFrom-window").innerHTML;
        let html3 = document.getElementById("attack-add-hexTo-window").innerHTML;
        let html4 = document.getElementById("attack-add-users-window").innerHTML;

        let addWindow = this.plansView.createFrame("attack-add-window1", html1);
        let hexFromWindow = this.plansView.createFrame("attack-add-window2", html2);
        let hexToWindow = this.plansView.createFrame("attack-add-window3", html3);
        let usersWindow = this.plansView.createFrame("attack-add-window4", html4);

        console.log("usersHolder", this.usersList);
        let usersHolder = usersWindow.$("#attack-users-form");
        for( let i=0; i<this.usersList.length; i++){
            console.log("counting", i);
            console.log(this.usersList[i].name+"<input type='checkbox' name='"+i+"'><br>");
            usersHolder.innerHTML +=  this.usersList[i].name+"<input type='checkbox' name='pos"+i+"'><br>";
        }
        /////////////////////////////////////////////////////////////////////////////////////

        this.plansView.appearPlanAdder(document.getElementById("attack-add-div"));
        let frame = this.plansView.frame;
        frame.on("#attack-button", "click", function () {
            addWindow.show();
            frame.hide();
        });

        /////////////////////////////////////////////////////////////////////////////////////
        // Window for the budget of the attack (also info about all that coming stuff)
        addWindow.on("#attack-budget-form", "submit", function (_frame, e) {
            e.preventDefault();
            let form = addWindow.$("#attack-budget-form");

            attack.budget = parseInt(form.elements["budget"].value);

            addWindow.hide();
            hexFromWindow.show();

            return false;
        });

        /////////////////////////////////////////////////////////////////////////////////////
        // Window for selecting hexFrom
        hexFromWindow.on("#attack-hexFrom-form", "submit", function (_frame, e) {
            e.preventDefault();

            let lastPoint = Object.assign(that.mapView.lastPoint);
            attack.hexFrom = that.mapState.getHex(lastPoint);

            hexFromWindow.hide();
            hexToWindow.show();

            return false;
        });

        /////////////////////////////////////////////////////////////////////////////////////
        // Window for selecting hexTo
        hexToWindow.on("#attack-hexTo-form", "submit", function (_frame, e) {
            e.preventDefault();

            //console.log(attack);
            //console.log(that.mapView.lastPoint);

            //console.log(Coordinate.distance(attack.hexFrom.coordinate, that.mapView.lastPoint));

            if (!Coordinate.isNeighbor(attack.hexFrom.coordinate, that.mapView.lastPoint)) {
                that.jsFrame.showToast({
                    duration: 5000,
                    html: "The selected hex isn't a neighbor of the first one",
                    align: "center",
                });
                return false;
            }

            // Cloning Point
            let lastPoint = Object.assign(that.mapView.lastPoint);
            attack.hexTo = that.mapState.getHex(lastPoint);

            hexToWindow.hide();
            usersWindow.show();
            return false;
        });

        /////////////////////////////////////////////////////////////////////////////////////
        //Window for selecting users
        usersWindow.on("#attack-users-form", "submit", function (_frame, e) {
            e.preventDefault();

            let objAttack = new Attack(attack.hexFrom, attack.hexTo, attack.budget);

            let holder = usersWindow.$("#attack-users-form");
            for( let i=0; i<that.usersList.length; i++){
                console.log("VALUE", holder.elements, holder.elements["pos"+i].checked );
                if( holder.elements["pos"+i].checked === true) objAttack.addUser(that.usersList[i]);
            }

            try {
                //that.plansManager.addPlan(new Plan(Plan.TYPES.attack, objAttack ));
                that.onCreate(objAttack);
                console.log(that.plansManager);
            } catch (e) {
                that.jsFrame.showToast({
                    duration: 5000,
                    html: e.message,
                    align: "center",
                });
                console.log(e);
            }

            usersWindow.hide();
            return false;
        })
    }

    /**
     * @callback AttackHandler
     * @param {Attack} plan
     */

    /**
     * @param {Attack} attack
     */
    onCreate(attack){
        for( let i=0; i<this.handlersCreate.length; i++){
              this.handlersCreate[i](attack);
        }
    }

    /**
     * @param {AttackHandler} handler
     */
    addHandlerCreate(handler){
        this.handlersCreate.push(handler);
    }




    /**
     * @param {Attack} attack
     * @return {HTMLElement}
     */
    makePlanElement( attack ) {
        // Part where HTMLElement creates to show info about attack
        let node = document.createElement("div");

        node.innerHTML += "Budget : " + attack.budget + "<br>";
        node.innerHTML += "HexFrom : " + attack.hexFrom.toString() + "<br>";
        node.innerHTML += "HexTo : " + attack.hexTo.toString() + "<br>";
        node.innerHTML += "Users : <br>";
        for(let i=0; i< attack.users.length; i++){
            node.innerHTML += i+" "+attack.users[i].name+"<br>";
        }

        return node;
    }


}
