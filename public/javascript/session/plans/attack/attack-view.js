import Point from "Root/map/Point";

import Attack from "Root/session/plans/attack/attack";
import {Plan} from "Root/session/plans/plans-model";

import JSFrame from "jsframe.js";
import MapView from "Root/map/MapView";
import MapState from "Root/map/MapState";

import {PlansManager} from "Root/session/plans/plans-model";
import PlansView from "Root/session/plans/plans-view";

import iterationCopy from "Root/external/functions";
import {OffsetCoordinate} from "Root/map/HexCoordinate";

import Hex from "Root/map/Hex";

export default class AttackView {

    /**
     * @param {JSFrame} jsFrame
     * @param {MapView} mapView
     * @param {MapState} mapState
     * @param {PlansManager} plansManager
     * @param {PlansView} plansView
     */
    constructor(jsFrame, mapView, mapState, plansView, plansManager) {

        this.jsFrame = jsFrame;

        this.mapView = mapView;
        this.mapState = mapState;

        this.plansManager = plansManager;
        this.plansView = plansView;

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

        let addWindow = this.plansView.createFrame("attack-add-window1", html1);
        let hexFromWindow = this.plansView.createFrame("attack-add-window2", html2);
        let hexToWindow = this.plansView.createFrame("attack-add-window3", html3);

        // Window for the budget of the attack (also info about all that coming stuff)
        addWindow.on("#attack-budget-form", "submit", function (_frame, e) {
            e.preventDefault();
            let form = addWindow.$("#attack-budget-form");

            attack.budget = form.elements["budget"].value;

            addWindow.hide();
            hexFromWindow.show();

            return false;
        });

        // Window for selecting hexFrom
        hexFromWindow.on("#attack-hexFrom-form", "submit", function (_frame, e) {
            e.preventDefault();

            let lastPoint = Object.assign(that.mapView.lastPoint);
            attack.hexFrom = that.mapState.getHex(lastPoint);

            hexFromWindow.hide();
            hexToWindow.show();

            return false;
        });

        // Window for selecting hexTo
        hexToWindow.on("#attack-hexTo-form", "submit", function (_frame, e) {
            e.preventDefault();

            console.log(attack);
            console.log(that.mapView.lastPoint);

            console.log(OffsetCoordinate.distance(attack.hexFrom.coordinate, that.mapView.lastPoint));

            if (!OffsetCoordinate.isNeighbor(attack.hexFrom.coordinate, that.mapView.lastPoint)) {
                that.jsFrame.showToast({
                    duration: 5000,
                    html: "The selected hex isn't a neighbor of the first one",
                    align: "center",
                });
                return false;
            }

            // Cloning Point
            let lastPoint = Object.assign(that.mapView.lastPoint);
            attack.hexTo = new Hex( that.mapState.getHex(lastPoint), lastPoint ) ;

            hexToWindow.hide();
            try {
                that.plansManager.addPlan(new Plan(Plan.TYPES.attack, new Attack(attack.hexFrom, attack.hexTo, attack.budget)));
                that.plansView.plansUpdate();

            } catch (e) {
                that.jsFrame.showToast({
                    duration: 5000,
                    html: e.message,
                    align: "center",
                });
            }

            return false;
        });

        // Return HTMLElement
        return document.getElementById("attack-add-div");
    }

    /**
     * @param frame
     */
    afterAdderAdd(frame) {

        let window = this.jsFrame.getWindowByName("attack-add-window1");
        frame.on("#attack-button", "click", function () {
            window.show();
            frame.hide();
        });

    }

    /**
     * @param {Attack} attack
     * @return {HTMLElement}
     */
    getPlanElement(attack) {

        // Part where HTMLElement creates to show info about attack
        let node = document.createElement("div");

        node.innerHTML += "Budget : " + attack.budget + "<br>";
        node.innerHTML += "HexFrom : " + attack.hexFrom.toString() + "<br>";
        node.innerHTML += "HexTo : " + attack.hexTo.toString() + "<br>";

        return node;
    }

    // static get ARROW_SOURCE_FILES(){
    //     let arr = {};
    //     let root =PlansView.OPTIONS.imageRoot;
    //     arr[Point.DIRECTIONS['ur']] = root+"";
    //     arr[Point.DIRECTIONS['rr']] = root+"";
    //     arr[Point.DIRECTIONS['dr']] = root+"";
    //     arr[Point.DIRECTIONS['dl']] = root+"";
    //     arr[Point.DIRECTIONS['ll']] = root+"";
    //     arr[Point.DIRECTIONS['ul']] = root+"";
    // }

    /**
     * @param {Attack} attack
     */
    showTypedPlan(attack) {
        // Part where Attack plan shows on the screen
        let img = document.createElement('img');


    }

    /**
     * @param {Attack} attack
     */
    removeTypedPlan(attack) {
        // Part where the arrow of the attack gets removed

        // No need for HTMLElement removal because we aren't responsible here for that
    }

    removeAllTypedPlans() {
        return this.mapState;
    }


}