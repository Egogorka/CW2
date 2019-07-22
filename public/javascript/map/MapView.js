import Cell from "./Cell";
import Point from "./Point";

export default class MapView {

    static get OPTIONS() {
        return {

            imageRoot : "/image/mapStuff/",
            // Considering the "px"
            hexWidth : 60,
            hexHeight : 60,

            hexMiddleSection : 60/4,

            offsetX : 0,
            offsetY : 0,
        };
    }

    /**
     * A node in the DOM tree.
     *
     * @external Node
     * @see {@link https://developer.mozilla.org/en-US/docs/Web/API/Node Node}
     */

    /**
     * @param {Node} MapBoardElement
     * @param {Object} options
     */
    constructor( MapBoardElement , options ){

        this.board   = MapBoardElement;

        let standardOptions = MapView.OPTIONS;

        if( options === undefined){
            this.options = standardOptions;
            return;
        }

        let newOptions = {};
        // For each existing property in MapView.OPTIONS assign one from "options" if exists
        Object.keys(standardOptions).forEach(function (key) {
           if( key in options )
               newOptions[key] = options[key];
           else
               newOptions[key] = standardOptions[key];
        });
        
        this.options = newOptions;
    }

    // Reverse of PositionNode function, i would say
    // Most crutch'y thing
    /**
     * @return {Point}
     * @param {Point} pixelPoint
     */
    pixelToPoint( pixelPoint ){

        let width  = MapView.OPTIONS.hexWidth;
        let height = MapView.OPTIONS.hexHeight;
        let middle = MapView.OPTIONS.hexMiddleSection;

        let scale = new Point(width, (height - middle));
        let offset = new Point(this.options.offsetX, this.options.offsetY);


        let pt = Point.sub(pixelPoint, offset);

        let ptFloat = Point.scaleDown(pt ,scale);
        //let ptInt   = Point.pointFunction(ptFloat, Math.floor);
        let ptInt = Point.pointFloor(ptFloat);

        if ((ptInt.y & 1) === 1){ // Moving the row to the side.
            ptFloat.x -= 0.5;
            pt = Point.scaleUp(ptFloat, scale);
            ptInt = Point.pointFloor(ptFloat);
        }

        let ptRemainder = Point.sub( pt , Point.scaleUp(ptInt, scale) );

        // Some maths comes in;

        let x = ptRemainder.x;
        let y = ptRemainder.y;

        if( y < -2*middle/width*x + middle ) {
            ptInt.shiftPosition(Point.DIRECTIONS["ul"]);
        }

        if( y <  2*middle/width*x - middle ) {
            ptInt.shiftPosition(Point.DIRECTIONS["ur"]);
        }

        return ptInt;
    }

    /**
     *
     * @param {Node} node
     * @param {Point} point // coordinates
     * @param {Point} offsetPoint // px
     */
    addNode( node , point , offsetPoint ){

        if( offsetPoint === undefined ) offsetPoint = new Point(0,0);

        let x = this.options.offsetX; //+ this.board.clientWidth/2;
        let y = this.options.offsetY; //+ this.board.clientHeight/2;

        x +=  this.options.hexWidth*(point.x);
        y += (this.options.hexHeight - this.options.hexMiddleSection)*(point.y);

        x += this.options.hexWidth*(point.y & 1)/2;

        node.style.marginLeft = x + offsetPoint.x + "px";
        node.style.marginTop  = y + offsetPoint.y + "px";

        this.board.appendChild(node);

    }

    /**
     *
     * @param {Node} node
     */
    removeNode( node ){
        this.board.removeChild(node);
    }
}
