export default class BudgetManager {

    /**
     * @param {number} budget
     */
    constructor( budget ) {

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
    }

    /**
     * @param {number} money
     */
    earn( money ){
        if( money >= 0) this.budgetEarn += money;
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
    }

}