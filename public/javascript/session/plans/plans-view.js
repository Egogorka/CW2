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
     *
     *
     * @param {JSFrame} jsFrame
     * @param {PlansManager} plansManager
     */
    constructor( jsFrame , plansManager ) {

        this.jsFrame = jsFrame;
        this.plansManager = plansManager;

        this.handlers = [];

        this.frame = this.createFrame(
            PlansView.OPTIONS.plansWindow ,
            "<div style='padding: 10px'>"+document.getElementById("plans-container").innerHTML+"</div>"
        );

        let that = this;

        let navPlans = document.getElementById(PlansView.OPTIONS.navPlans);
        navPlans.addEventListener("click", function (){
            that.showPlansWindow();
        });
    }

    init(){
        this.appearPlanAdders(this.frame.$("#plans-adders"));
    }

    /**
     * @param {HTMLElement} holder
     */
    appearPlanAdders( holder ){

        holder.innerHTML = "";

        console.log("appearPlanAdders");

        for( let key in this.handlers ){
            let node = this.handlers[key].showAdder();
            node.style.display = "block";

            console.log(key);

            holder.appendChild(node);
            //holder.appendChild(document.createElement("hr"));

            this.handlers[key].afterAdderAdd( this.frame );
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

    showPlansWindow() {
        this.plansUpdate();
        this.frame.show();
    }

    plansUpdate() {

        let frame = this.jsFrame.getWindowByName( PlansView.OPTIONS.plansWindow );

        frame.$("#plans-holder").innerHTML = "";

        // for( let handler in this.handlers ){
        //     handler.removeAllTypedPlans();
        // }

        let that = this;
        this.plansManager.forEachPlan(function ( plan, key ) {
            let handler = that.handlers[ plan.type ];
            console.log(handler);
            let planNode = handler.getPlanElement( plan.object );
            let cont = document.createElement("li");
            cont.innerHTML += "<p> Plan type : "+ Plan.TYPES[plan.type] +"</p>";
            cont.appendChild(planNode);
            frame.$("#plans-holder").appendChild(cont);
        });

    }

    /**
     * @param {number} type
     * @param {Object} handler
     */
    addPlanViewHandler( type , handler ) {
        if(!(type in Plan.TYPES) )
            throw new Error("No such type of plan");

        this.handlers[type] = handler;
    }

    //planView( plan ) {
    //    let node = document.createElement("li");
    //
    //     node.innerHTML += "Type : "+Plan.TYPES(plan.type);
    // }

}
