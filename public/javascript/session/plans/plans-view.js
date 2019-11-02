import {Plan, PlansManager} from "Root/session/plans/plans-model";

export default class PlansView {

    static get OPTIONS() {
        return {

            "imageRoot" : "",

            "navPlans" : "nav-plans", //Button which opens the plans window

            // Window name
            "plansWindow" : "plans-window",

        }
    }

    static get WindowStyle() {
        return {
            appearanceName : "material",
            appearanceParam: {
                border: {
                    shadow: '2px 2px 10px  rgba(0, 0, 0, 0.5)',
                    width: 0,
                    radius: 6,
                },
                titleBar: {
                    color: '#c1c1c1',
                    background: '#120e18',
                    leftMargin: 20,
                    height: 30,
                    fontSize: 14,
                    buttonWidth: 36,
                    buttonHeight: 16,
                    buttonColor: 'white',
                    buttons: [ // buttons on the right
                        {
                            //Set font-awesome fonts(https://fontawesome.com/icons?d=gallery&m=free)
                            fa: 'fas fa-times',//code of font-awesome
                            name: 'hideButton',
                            visible: true // visibility when window is created.
                        },
                    ],
                },
            },
            title: 'Window',
            left: 200, top: 200, width: 320, height: 220,
            movable: true,//Enable to be moved by mouse
            resizable: true,//Enable to be resized by mouse
            style: {
                fontSize : '12em',
                backgroundColor: 'rgba(28,22,22)',
                overflow : 'auto',
            },
        }
    }

    /**
     * @param {string} name
     * @param {string} html
     * @param {Object} [addStyle]
     * @return {frame}
     */
    createFrame( name , html , addStyle ){

        let style = PlansView.WindowStyle;
        style.name = name;
        style.html = html;

        if( addStyle !== undefined) {
            for (let key in addStyle) {
                if (addStyle.hasOwnProperty(key))
                    style[key] = addStyle[key];
            }
        }

        let frame = this.jsFrame.create( style );

        frame.on("hideButton", "click", function (_frame, e) {
            _frame.hide();
        });

        return frame;
    }

    /**
     * @param {JSFrame} jsFrame
     * @param {PlansManager} plansManager
     */
    constructor( jsFrame, plansManager ){

        this.jsFrame = jsFrame;
        this.plansManager = plansManager;
        this.handlers = [];

        this.frame = this.createFrame(
            PlansView.OPTIONS.plansWindow ,
            "<div style='padding: 10px'>"+document.getElementById("plans-container").innerHTML+"</div>"
        );

        for( let i=0; i<Plan.TYPES.length; i++ ){
            this.frame.$("#plans-holder").innerHTML +=
                "<hr>" +
                "<h3>"+Plan.TYPES[i]+"</h3>" +
                "<div data-plan-id=\""+i+"\" class='typed-plans-holder'></div>";
        }

        let that = this;
        let navPlans = document.getElementById(PlansView.OPTIONS.navPlans);

        navPlans.addEventListener("click", function (){
            that.frame.show();
        });
    }

    /**
     * @param {number} type
     * @param {Object} handler
     */
    addPlanViewHandler( type , handler ) {
        if (!(type in Plan.TYPES))
            throw new Error("No such type of plan");

        this.handlers[type] = handler;
    }

    init(){
        let holder = this.frame.$("#plans-adders");

        holder.innerHTML = "";

        console.log("appearPlanAdders");

        console.log(this.handlers);

        for( let key in this.handlers )
            this.handlers[key].showAdder();
    }

    appearPlanAdder( node ){
        let holder = this.frame.$("#plans-adders");

        node.style.display = "block";

        holder.appendChild(node);
        holder.appendChild(document.createElement("hr"));
    }

    /**
     * @param {Plan} plan
     * @param {number} id
     */
    onCreate( plan, id ){

        // For different types of plans we need to do different things
        /** @type {HTMLElement} */

        console.log("PLAN-VIEW : onCreate ");
        console.log(this);

        let planElement = this.handlers[ plan.type ].makePlanElement(plan.object);

        planElement.setAttribute("planId"  , id.toString() );
        planElement.setAttribute("planType", plan.type.toString() );

        // But every plan must be placed in the list
        /** @type {HTMLElement} */
        let holder = this.frame.$("div[data-plan-id=\""+plan.type+"\"]");
        holder.appendChild(planElement);

        let delButton = document.createElement("button");
        delButton.innerText = "Remove";
        delButton.addEventListener("click", ()=>this.plansManager.removePlan(id, plan.type) );
        planElement.appendChild(delButton);

    }

    /**
     * @param {Plan} plan
     * @param {number} id
     */
    onDelete( plan, id ){

        let planElement = this.frame.$("div[planId=\""+id+"\"]");

        /** @type {HTMLElement} */
        let holder = this.frame.$("div[data-plan-id=\""+plan.type+"\"]");

        holder.removeChild(planElement);

    }

    /**
     * @param {Plan} plan
     * @param {number} id
     */
    onUpdate( plan, id ){
        this.onDelete(plan,id);
        this.onCreate(plan,id);
    }

}
//
// /**
//  * @param {number} type
//  * @param {Object} handler
//  */
// addPlanViewHandler( type , handler ) {
//     if(!(type in Plan.TYPES) )
//         throw new Error("No such type of plan");
//
//     this.handlers[type] = handler;
// }
//
// //planView( plan ) {
// //    let node = document.createElement("li");
// //
// //     node.innerHTML += "Type : "+Plan.TYPES(plan.type);
// // }