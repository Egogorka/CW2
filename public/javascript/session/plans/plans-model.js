import BudgetManager from "Root/session/budget/budgetManager";

export class Plan {

    static get TYPES() {
        return {
            attack : 0,
            build  : 1,

            0 : "attack",
            1 : "build",
        }
    }

    /**
     * @param {number} type
     * @param {Object} object
     */
    constructor( type , object  ) {

        this.type = type;

        this.object = object;

        if( object.hasOwnProperty("budget") ) {
            this.budget = object.budget;
        } else
            this.budget = 0;

    }


}

export class PlansManager {

    /**
     * @param {BudgetManager} budgetManager
     */
    constructor( budgetManager ) {
        this.budgetManager = budgetManager;

        this.plans = [];
    }

    /**
     * @param {Plan} plan
     */
    addPlan( plan ) {

        console.log(plan.budget);
        console.log(this.budgetManager.canAfford(plan.budget));

        if (!this.budgetManager.canAfford(plan.budget))
            throw new Error("Plan has high cost");

        this.budgetManager.afford(plan.budget);

        this.plans.push(plan);
        return (this.plans.length-1);
    }

    /**
     * @param {number} id
     * @return {Plan}
     */
    findPlanById( id ) {
        return this.plans[id];
    }

    /**
     * @param {number} id
     */
    removePlanById( id ) {

        this.budgetManager.deAfford(this.plans[id].budget);

        this.plans = this.plans.splice( id, 1 );
    }

    /**
     * @param {function( Plan , number )} callback
     */
    forEachPlan(callback) {
        for( let key in this.plans ){
            callback( this.plans[key] , key );
        }
    }
}
