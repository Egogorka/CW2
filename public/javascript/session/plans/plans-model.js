import BudgetManager from "Root/session/budget/budgetManager";
import BuildFromJson from "Root/session/plans/plan-build";

export class Plan {

    /*
    Event types:
    planCreate
    planUpdate
    planDelete
     */

    static get TYPES() {
        return {
            attack : "attack",
            build  : "build",
        }
    }

    /**
     * @param {string|null} type
     * @param {Object|null} object
     */
    constructor( type=null , object=null  ) {

        this.type = type;

        this.object = object;

        if( object == null ){
            return;
        }

        if( "budget" in object ) {
            this.budget = object.budget;
        } else
            this.budget = 0;

        // Plan-object must implement getJson method to be able to send it to server
        if((typeof object['getJson']) !== "function") { // Checking if object implements getJson() method
            console.log(object);
            throw "PLAN-MODEL ERROR : object must implement getJson method";
        }

        // Plan-object must implement getFromJson method to be able to get it from server
        if((typeof object['getFromJson']) !== "function") { // Checking if object implements getFromJson() method
            console.log(object);
            throw "PLAN-MODEL ERROR : object must implement getJson method";
        }
    }

    getJson() {
        return JSON.stringify({
            "type" : this.type,
            "budget" : this.budget,
            "object" : this.object.getJson()
        })
    }

    getFromJson(json) {
        let data = JSON.parse(json);
        this.type = data.type;
        this.budget = data.budget;
        this.object = BuildFromJson(data.object, data.type);
    }
}

export class PlansManager {

    /**
     * @param {BudgetManager} budgetManager
     */
    constructor( budgetManager ) {
        this.budgetManager = budgetManager;
        this.plans = [];

        this.handlersCreate = {};
        this.handlersUpdate = {};
        this.handlersDelete = {};

        //for( let i = 0; i<Plan.TYPES.length; i++ ){
        for( let type in Plan.TYPES) {
            this.handlersCreate[type] = [];
            this.handlersUpdate[type] = [];
            this.handlersDelete[type] = [];
        }
    }

    /**
     * @param {Plan} plan
     *
     */
    addPlan( plan ) {

        // console.log(plan.budget);
        // console.log(this.budgetManager.canAfford(plan.budget));

        if (!this.budgetManager.canAfford(plan.budget))
            throw new Error("Plan has high cost");

        this.budgetManager.afford(plan.budget);

        if( !this.plans[plan.type] ) this.plans[plan.type] = [];

        this.plans[plan.type].push(plan);
        this.onCreate(plan, plan.type);

        return (this.plans[plan.type].length-1);
    }

    /**
     * @param {number} id
     * @param {string} type
     * @return {Plan}
     */
    findPlan( id , type ) {
        return this.plans[type][id];
    }

    /**
     * @param {number} id
     * @param {string} type
     */
    removePlan( id, type ) {

        let plan = this.findPlan( id, type );

        this.budgetManager.deAfford(plan.budget);


        this.plans[type].splice( id, 1 );
        console.log("Splicing ",this.plans[type]);

        this.onDelete(plan, id);
    }

    /**
     * @param {function( Plan , number )} callback
     */
    forEachPlan(callback) {
        for( let type in this.plans )
            for( let key in this.plans[type])
                if(this.plans[type].hasOwnProperty(key) ) callback( this.plans[type][key] , key );
    }

    /**
     * @param {string} type
     * @param {function(Plan, number)} callback
     */
    forEachTypePlan(type, callback) {
        for (let key in this.plans[type])
            if(this.plans[type].hasOwnProperty(key) ) callback( this.plans[type][key] , key );
    }

    /**
     * @callback PlanHandler
     * @param {Plan} plan
     * @param {number} id
     */

    /**
     * @param {PlanHandler} handler
     * @param {string} type
     */
    addHandlerDelete( handler , type ){
        this.handlersDelete[type].push(handler);
    }

    /**
     * @param {PlanHandler} handler
     * @param {string} type
     */
    addHandlerUpdate( handler , type ){
        this.handlersUpdate[type].push(handler);
    }

    /**
     * @param {PlanHandler} handler
     * @param {string} type
     */
    addHandlerCreate( handler , type ){
        this.handlersCreate[type].push(handler);
    }

    /**
     * @param {Plan} plan
     * @param {number} id
     */
    onDelete( plan , id ){
        for(let i=0; i<this.handlersDelete[plan.type].length; i++)
            this.handlersDelete[plan.type][i]( plan, id );
    }

    /**
     * @param {Plan} plan
     * @param {number} id
     */
    onUpdate( plan , id ){
        for(let i=0; i<this.handlersUpdate[plan.type].length; i++)
            this.handlersUpdate[plan.type][i]( plan, id );
    }

    /**
     * @param {Plan} plan
     * @param {number} id
     */
    onCreate( plan, id ){
        for(let i=0; i<this.handlersCreate[plan.type].length; i++)
            this.handlersCreate[plan.type][i](plan, id);
    }
}
