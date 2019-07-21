import Cell from "./Cell";
import Point from "./Point";

export default class MapView {

    static get OPTIONS() {
        return {

            imageRoot : "/images/mapStuff",

            // Considering the "px"
            hexWidth : 60,
            hexHeight : 60,

            hexMiddleSection : 60/4,

            structureWidth : 50,
            structureHeight : 50,

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
     * @param {Array} options
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
    /**
     * @return {Point}
     * @param {Point} pixelPoint
     */
    pixelToPoint( pixelPoint ){

        let width  = MapView.OPTIONS.hexWidth;
        let height = MapView.OPTIONS.hexHeight;
        let middle = MapView.OPTIONS.hexMiddleSection;

        let offset = Point(this.options.offsetX, this.options.offsetY);

        let pt = Point.sub(pixelPoint, offset);

        let scale = Point(width, (height - middle));

        let ptInt = Point.scaleDown(pt ,scale);
        ptInt = Point.pointFunction(pt, Math.floor);

        let ptRemainder = Point.sub( pt , Point.scaleUp(ptInt, scale) );

        // Some maths comes in;

        let x = ptRemainder.x;
        let y = ptRemainder.y;

        if( 2*middle/width*x + y < middle ) {

        }



    }

    /**
     *
     * @param {Node} node
     * @param {Point} point // coordinates
     * @param {Point} offsetPoint // px
     */
    positionNode( node , point , offsetPoint ){

        if( offsetPoint === undefined ) offsetPoint = Point(0,0);

        let x = this.options.offsetX; //+ this.board.clientWidth/2;
        let y = this.options.offsetY; //+ this.board.clientHeight/2;

        x +=  this.options.hexWidth*(point.x);
        y += (this.options.hexHeight - this.options.hexMiddleSection)*(point.y);

        x += this.options.hexWidth*(point.y & 1)/2;

        node.style.marginLeft = x + offsetPoint.x + "px";
        node.style.marginTop  = y + offsetPoint.y + "px";

    }

    /**
     * @param {Cell} cell
     * @param {Point} point
     */
    appendHex( cell , point ){

        let hexagon = document.createElement("img");
        let structure = document.createElement("img");

        hexagon.src = MapView.IMAGE_TABLE[cell.color];
        structure.src = MapView.IMAGE_TABLE[cell.structure];

        hexagon.style.width = this.options.hexWidth + "px";
        hexagon.style.height = this.options.hexHeight + "px";
        hexagon.id = point.x + ";" + point.y + ";H;" + cell.color;
        hexagon.classList.add("hexagon");

        structure.style.height = this.options.structureHeight + "px";
        structure.style.width = this.options.structureWidth + "px";
        structure.id = point.x + ";" + point.y + ";S;" + cell.structure;
        structure.classList.add("structure");

        let structureOffset = Point(
            (this.options.hexWidth - this.options.structureWidth)/2,
            (this.options.hexHeight - this.options.structureHeight)/2
        );

        this.positionNode(hexagon, point);
        this.positionNode(structure, point, structureOffset);

        this.board.appendChild(hexagon);
        if( cell.structure !== Cell.STRUCTURES.noStruct)
            this.board.appendChild(structure);
    }

    /**
     *
     */
    removeHex( point ){

    }


}

MapView.IMAGE_TABLE = {};

let STRUCTURES = Cell.STRUCTURES;
let COLORS = Cell.COLORS;
let IMAGE_TABLE = MapView.IMAGE_TABLE;

let imageRoot = MapView.OPTIONS.imageRoot;

IMAGE_TABLE[STRUCTURES.base] = imageRoot+"/structures/base.png";
IMAGE_TABLE[STRUCTURES.harvester] = imageRoot+"/structures/harvester.png";
IMAGE_TABLE[STRUCTURES.radar] = imageRoot+"/structures/radar.png";
IMAGE_TABLE[STRUCTURES.shipFactory] = imageRoot+"/structures/shipfactory.png";

IMAGE_TABLE[COLORS.neutral] = imageRoot+"/hexagons/neutral.png";
IMAGE_TABLE[COLORS.red] = imageRoot+"/hexagons/red.png";
IMAGE_TABLE[COLORS.yellow] = imageRoot+"/hexagons/yellow.png";
IMAGE_TABLE[COLORS.green] = imageRoot+"/hexagons/green.png";
IMAGE_TABLE[COLORS.cyan] = imageRoot+"/hexagons/cyan.png";
IMAGE_TABLE[COLORS.blue] = imageRoot+"/hexagons/blue.png";
IMAGE_TABLE[COLORS.purple] = imageRoot+"/hexagons/purple.png";

/*
    neutral_alias: 'hexagons/empty.png',

    purple_alias : 'hexagons/hxgonPurple.png',
    red_alias    : 'hexagons/hxgonRed.png',
    yellow_alias : 'hexagons/hxgonYellow.png',
    green_alias  : 'hexagons/hxgonGreen.png',
    cyan_alias   : 'hexagons/hxgonCyan.png',
    blue_alias   : 'hexagons/hxgonBlue.png',

// Структуры

    base         : 'upgrades/base_1.png',
    harvester    : 'upgrades/harvester_1.png',
    radar        : 'upgrades/radar_1.png',
    shipfactory  : 'upgrades/shipfactory_1.png'
    */
