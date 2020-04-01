import Cell from "./Cell";
import MapView from  "./MapView";
import Point from "./Point";
import OffsetCoordinate from "./HexCoordinate"

import Hex from "Root/map/Hex";

export default class CellView {

    static get OPTIONS() {
        return {

            imageRoot : MapView.OPTIONS.imageRoot,

            hexWidth : MapView.OPTIONS.hexWidth,
            hexHeight : MapView.OPTIONS.hexHeight,

            hexMiddleSection : MapView.OPTIONS.hexMiddleSection,

            structureWidth : 50,
            structureHeight : 50,

        }
    }

    /**
     *
     * @param {MapView} MapView
     * @param {Object} options
     */
    constructor( MapView , options ){

        this.mapView = MapView;

        let standardOptions = CellView.OPTIONS;

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

    /**
     * @param {Hex} hex
     */
    appendHex( hex ){

        let cell = hex.cell;
        let point = hex.coordinate;

        let hexagon = document.createElement("img");
        let structure = document.createElement("img");

        hexagon.src = CellView.IMAGE_TABLE[cell.color];
        structure.src = CellView.IMAGE_TABLE[cell.structure];

        hexagon.style.width = (this.options.hexWidth+2) + "px";
        hexagon.style.height = (this.options.hexHeight+2) + "px";
        hexagon.id = point.x + ";" + point.y + ";H";
        hexagon.classList.add("hexagon");

        structure.style.height = this.options.structureHeight + "px";
        structure.style.width = this.options.structureWidth + "px";
        structure.id = point.x + ";" + point.y + ";S";
        structure.classList.add("structure");

        // let structureOffset = new Point(
        //     (this.options.hexWidth - this.options.structureWidth)/2,
        //     (this.options.hexHeight - this.options.structureHeight)/2
        // );

        this.mapView.addNode(hexagon, point, new Point(0,0));
        if( cell.structure !== Cell.STRUCTURES.noStruct ) {
            this.mapView.addNode(structure, point);
        }
    }

    /**
     * @param {Point} point
     */
    removeHex( point ){
          let hexId = point.x + ";" + point.y + ";H";
          let strId = point.x + ";" + point.y + ";S";

          let hex = document.getElementById(hexId);
          let str = document.getElementById(strId);

          if (hex) this.mapView.removeNode(hex);

          if (str) this.mapView.removeNode(str);
    }
}

CellView.IMAGE_TABLE = {};

let STRUCTURES = Cell.STRUCTURES;
let COLORS = Cell.COLORS;
let IMAGE_TABLE = CellView.IMAGE_TABLE;

let imageRoot = CellView.OPTIONS.imageRoot;

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