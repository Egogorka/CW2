import BudgetManager, {BudgetEvent} from "Root/session/budget/budgetManager";

export default class BudgetView {

    static get HTML() {
        return {
            'currentBudget' : "current-budget",
            'budgetSpend' : "spendings",
            'budgetEarn' : "earnings",
        };
    };

    /**
     * @param {BudgetManager} budgetManager
     */
    constructor( budgetManager ){
        this.budgetManager = budgetManager;
        BudgetEvent.addHandler(this.update.bind(this));
    }

    update(){
        let current = document.getElementById(BudgetView.HTML.currentBudget);
        let spend = document.getElementById(BudgetView.HTML.budgetSpend);
        // let earn  = document.getElementById(BudgetView.HTML.budgetEarn);

        current.innerText = "$"+this.budgetManager.budgetTotal;
        spend.innerText   = "$"+this.budgetManager.budgetSpend;
        // earn.innerText    = "$"+this.budgetManager.budgetEarn;
    }
}