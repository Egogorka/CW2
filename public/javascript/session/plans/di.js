// Import all plan-type-views to the plan-view
import JSFrame from "jsframe.js";
import MapView from "Root/map/MapView";
import MapState from "Root/map/MapState";

import {PlansManager} from "Root/session/plans/plans-model";
import PlansView from "Root/session/plans/plans-view";


import {Plan} from "Root/session/plans/plans-model";

import AttackView from "Root/session/plans/attack/attack-view";
import AttackArrowView from "Root/session/plans/attack/attack-arrow-view";

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
 *
 * @param {User[]} userList
 */

export function MakeConnections( jsFrame, mapView, mapState , plansView , plansManager, userList ) {

    // PlanView Handlers

    plansView.addPlanViewHandler( Plan.TYPES.attack , new AttackView(
        jsFrame, mapView, mapState, plansView, plansManager, userList
    ));


    let attackArrowView = new AttackArrowView( mapView );

    // PlansManager Events

    plansManager.addHandlerCreate( (plansView.onCreate).bind(plansView), Plan.TYPES.attack );
    plansManager.addHandlerDelete( (plansView.onDelete).bind(plansView), Plan.TYPES.attack );

    plansManager.addHandlerCreate( (attackArrowView.onCreate).bind(attackArrowView), Plan.TYPES.attack);
    plansManager.addHandlerDelete( (attackArrowView.onDelete).bind(attackArrowView), Plan.TYPES.attack);
}