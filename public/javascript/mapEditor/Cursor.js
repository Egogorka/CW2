import MapView from "Root/map/MapView";
import Point from "Root/map/Point";
import {CubeCoordinate} from "Root/map/HexCoordinate";

const NO_SYMMETRY = 0;
const MIRROR_SYMMETRY = 1;
const TRIGONAL_SYMMETRY = 2;
const HEX_SYMMETRY = 3;

export default class Cursor {

    /**
     * @param {MapView} MapView
     */
    constructor(MapView) {
        this.view = MapView;
        this.mainCursor = this.createCursorImg();
        this.cursors = [];

        this.symmetryType = NO_SYMMETRY;

        this.init();
    }

    init() {
        this.view.board.appendChild(this.mainCursor);

        this.view.board.addEventListener("mousemove", this.mouseMoveHandler.bind(this));
        this.view.board.addEventListener("click", this.clickHandler.bind(this));

    }

    createCursorImg() {
        let cursor = document.createElement("img");

        cursor.classList.add("cursorHex");
        cursor.src = MapView.OPTIONS.imageRoot + "/hexagons/selector.png";

        return cursor;
    }

    symmetryEventHandler(type){
        this.mainCursor.src = MapView.OPTIONS.imageRoot + "/hexagons/selectorRed.png";
        this.symmetryType = type;
        this.symmetryFlag = true;
    }

    mouseMoveHandler(e) {
        let pt = new Point(e.pageX, e.pageY);
        let lhx = new CubeCoordinate(this.view.lastPoint.x, this.view.lastPoint.y);
        let hx = this.view.pixelToPoint(pt);

        if( !CubeCoordinate.equal(lhx, hx) ) {
            this.view.moveNode(this.mainCursor, hx);
            this.symmetryHandler(hx);
        }
    }

    clickHandler(e) {
        if( (this.symmetryType !== NO_SYMMETRY) && (this.symmetryFlag) ) {
            this.symmetryFlag = false;

            this.mainCursor.src = MapView.OPTIONS.imageRoot + "/hexagons/selector.png";

            let tmp = this.createCursorImg();
            tmp.src = MapView.OPTIONS.imageRoot + "/hexagons/selectorRed.png";

            this.rotationCenter = new CubeCoordinate(this.view.lastPoint.x, this.view.lastPoint.y);

            console.log(this.rotationCenter);
            this.view.addNode(tmp, this.rotationCenter);

            this.cursors[0] = tmp;

            console.log(this.symmetryType);
            switch (Number(this.symmetryType)) {
                case MIRROR_SYMMETRY:
                    this.symmetryHandler = this.mirrorSymmetryHandler;

                    this.cursors[1] = this.createCursorImg();
                    console.log("mirror");
                    break;
                case TRIGONAL_SYMMETRY:
                    this.symmetryHandler = this.trigonalSymmetryHandler;

                    this.cursors[1] = this.createCursorImg();
                    this.cursors[2] = this.createCursorImg();

                    break;
                case HEX_SYMMETRY:
                    this.symmetryHandler = this.hexSymmetryHandler;

                    this.cursors[1] = this.createCursorImg();
                    this.cursors[2] = this.createCursorImg();
                    this.cursors[3] = this.createCursorImg();
                    this.cursors[4] = this.createCursorImg();
                    this.cursors[5] = this.createCursorImg();

                    break;
                default:
                    console.log("what the fuck");
            }
            for (let i = 1; i < this.cursors.length; i++)
                this.view.board.appendChild(this.cursors[i]);
            console.log(this.cursors);
        }

        if( this.symmetryType === NO_SYMMETRY ) {
            this.symmetryHandler = function ( coordinate ) {};
        }
    }

    // dummy method
    symmetryHandler( coordinate ) {
        let curhex = coordinate;
        switch( this.symmetryType ){
            case MIRROR_SYMMETRY:
                for( let i=1 ; i<2 ; i++) {
                    curhex = CubeCoordinate.rotate180(this.rotationCenter, curhex);

                }
                break;
            case TRIGONAL_SYMMETRY:


                break;
            case HEX_SYMMETRY:

                break;
        }
    }

    mirrorSymmetryHandler( coordinate ){
        this.view.moveNode(this.cursors[1], CubeCoordinate.rotate180(this.rotationCenter ,coordinate));
        console.log(coordinate);
    }

    trigonalSymmetryHandler( coordinate ) {
        this.view.moveNode(this.cursors[1], CubeCoordinate.rotate120clockwise(this.rotationCenter,coordinate));
        this.view.moveNode(this.cursors[2], CubeCoordinate.rotate120aclockwise(this.rotationCenter,coordinate));
    }

    hexSymmetryHandler( coordinate ) {
        this.view.moveNode(this.cursors[1], CubeCoordinate.rotate60clockwise(this.rotationCenter,coordinate));
        this.view.moveNode(this.cursors[2], CubeCoordinate.rotate120clockwise(this.rotationCenter,coordinate));
        this.view.moveNode(this.cursors[3], CubeCoordinate.rotate180(this.rotationCenter,coordinate));
        this.view.moveNode(this.cursors[4], CubeCoordinate.rotate120aclockwise(this.rotationCenter,coordinate));
        this.view.moveNode(this.cursors[5], CubeCoordinate.rotate120aclockwise(this.rotationCenter,
            CubeCoordinate.rotate60clockwise(this.rotationCenter,coordinate)));
    }
}