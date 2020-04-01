export default class BudgetManager
{
    /**
     * @param {number} budget
     */
    constructor( budget )
    {

        this.budgetTotal = budget;

        this.budgetSpend = 0;
        this.budgetEarn  = 0;

    }

    // Clan gets money only after all actions are done
    /**
     * @param {number} cost
     * @return {boolean}
     */
    canAfford( cost ){
        return ((this.budgetTotal - this.budgetSpend) >= cost);
    }

    /**
     * @param {number} cost
     */
    afford( cost ){
        if (!this.canAfford(cost))
            throw new Error("Cant afford action with this cost, low budget");

        if( cost >= 0) this.budgetSpend += cost;

        (new BudgetEvent(BudgetEvent.TYPES.afford, cost)).cast();
    }

    /**
     * @param {number} money
     */
    earn( money ){
        if( money >= 0) this.budgetEarn += money;

        (new BudgetEvent(BudgetEvent.TYPES.earn, money)).cast();
    }

    /**
     * @param {number} cost
     */
    deAfford( cost ){
        if( cost <= 0)
            throw new Error("You cant have negative cost");
        if(this.budgetSpend < cost)
            throw new Error("You cant spend negative money in total");

        this.budgetSpend -= cost;

        (new BudgetEvent(BudgetEvent.TYPES.deAfford, cost)).cast();
    }

    /**
     * @param {number} money
     */
    deEarn( money ){
        if( money <= 0){
            throw new Error("You cant have negative money");
        }
        if( this.budgetEarn - money < 0){
            throw new Error("You cant earn negative money");
        }
        this.budgetEarn -= money;

        (new BudgetEvent(BudgetEvent.TYPES.deEarn, money)).cast();
    }

}

export class BudgetEvent {

    static get TYPES() {
        return {
            afford : "afford",
            earn   : "earn",

            deAfford : "deAfford",
            deEarn   : "deEarn",
        }
    }

    constructor(type, amount) {
        this.event = new CustomEvent("BudgetEvent",{
            bubbles : true,
            detail : {
                type : type,
                amount : amount
            }
        });
    }

    cast() {
        document.dispatchEvent(this.event);
    }

    static addHandler( func ){
        document.addEventListener("BudgetEvent", func);
    }
}