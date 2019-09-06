// Import all plan-type-views to the plan-view
import JSFrame from "jsframe.js";
import MapView from "Root/map/MapView";
import MapState from "Root/map/MapState";

import {PlansManager} from "Root/session/plans/plans-model";
import PlansView from "Root/session/plans/plans-view";


import {Plan} from "Root/session/plans/plans-model";

import AttackView from "Root/session/plans/attack/attack-view";

/*
 Every TypeView must have these methods
    -> showAdder -
    -> showTypedPlan - params { typedPlan (attack, build obj, etc) } must return HTMLElement with corresponding plan info
    -> removeTypedPlan - params { typedPlan }, must undo the evidence of created plan(??)
 */

/**
 * @param {JSFrame} jsFrame
 *
 * @param {PlansManager} plansManager
 * @param {PlansView} plansView
 *
 * @param {MapView} mapView
 * @param {MapState} mapState
 */
export default function ImportToPlansView( jsFrame, mapView, mapState , plansView , plansManager ) {

    plansView.addPlanViewHandler( Plan.TYPES.attack , new AttackView(
        jsFrame, mapView, mapState, plansView, plansManager
    ));



}