import CellView from "Root/map/CellView";
import Cell from "Root/map/Cell";

const NO_SYMMETRY = 0;
const MIRROR_SYMMETRY = 1;
const TRIGONAL_SYMMETRY = 2;
const HEX_SYMMETRY = 3;

export default class ToolBox {

    static get OPTIONS() {
        return {
            ImgSelectId : "img_select",
            TypesArray : [
                Cell.COLORS.neutral,
                Cell.COLORS.purple,
                Cell.COLORS.blue,
                Cell.COLORS.cyan,
                Cell.COLORS.green,
                Cell.COLORS.yellow,
                Cell.COLORS.red,

                Cell.STRUCTURES.base,
                Cell.STRUCTURES.harvester,
                Cell.STRUCTURES.shipFactory,
                Cell.STRUCTURES.radar
            ],
            LeftButtonId : "img_left",
            RightButtonId : "img_right",
            PlacementTools : "placement_tools_box"

        };
    }

    constructor(){
        this.init();
    }

    init(){
        this.counter = 0;
        this.selectedSymmetry = NO_SYMMETRY;
        this.selectedSymmetryImg = null;

        this.imageSelect = document.getElementById(ToolBox.OPTIONS.ImgSelectId);
        this.symmetryHandler = function (symmetryType) {};

        //console.log("ANYBODY THERE?", this.counter);
        document.getElementById(ToolBox.OPTIONS.LeftButtonId).addEventListener("click", this.leftButtonHandler.bind(this));
        document.getElementById(ToolBox.OPTIONS.RightButtonId).addEventListener("click", this.rightButtonHandler.bind(this));
        document.getElementById(ToolBox.OPTIONS.PlacementTools).addEventListener("click", this.toolsClickHandler.bind(this));

    }

    setSymmetryHandler( func ){
        this.symmetryHandler = func;
    }

    leftButtonHandler(){
        if( this.counter <= 0 ) return;
        this.counter = this.counter - 1;
        this.imageSelect.src = CellView.IMAGE_TABLE[ToolBox.OPTIONS.TypesArray[this.counter]];
    }

    rightButtonHandler(){
        if( this.counter >= ToolBox.OPTIONS.TypesArray.length -1 ) return;
        this.counter = this.counter + 1;
        this.imageSelect.src = CellView.IMAGE_TABLE[ToolBox.OPTIONS.TypesArray[this.counter]];
    }

    toolsClickHandler(e){
        console.log("HERE WE ARE");
        let target = e.target;

        if( target.tagName !== "IMG" ) return;

        if( this.selectedSymmetryImg === target ) {
            this.selectedSymmetryImg.classList.remove("select");
            this.selectedSymmetryImg = null;
            this.selectedSymmetry = NO_SYMMETRY;
        }
        else {
            if( this.selectedSymmetryImg !== null )
                this.selectedSymmetryImg.classList.remove("select");
            this.selectedSymmetryImg = target;
            this.selectedSymmetryImg.classList.add("select");
            this.selectedSymmetry = target.dataset.symmetry;
        }
        this.symmetryHandler(this.selectedSymmetry);
    }


}