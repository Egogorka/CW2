
import MapView from "Root/map/MapView";

import Plan from "Root/session/plans/plans-model";
import Attack from "Root/session/plans/attack/attack";

import Cell from "Root/map/Cell";
import {CubeCoordinate, Coordinate} from "Root/map/HexCoordinate";

import Point from "Root/map/Point";

export default class AttackArrowView {

    /**
     * @param {number} dir
     * @param {number} color
     * @return {string}
     */
    static ARROW_FILE_PATH(dir, color) {
        let path = "/images/plan/attack/arrows/";
        console.log("Direction ", dir);
        switch (dir) {
            case 0:
            case 2:
            case 3:
            case 5:
                path += "d";
                break;
            default:
            case 1:
            case 4:
                path += "h";
                break;
        }

        switch (color) {
            default:
            case Cell.COLORS.red:
                path += "red";
                break;
            case Cell.COLORS.yellow:
                path += "yellow";
                break;
            case Cell.COLORS.green:
                path += "green";
                break;
            case Cell.COLORS.cyan:
                path += "cyan";
                break;
            case Cell.COLORS.blue:
                path += "blue";
                break;
            case Cell.COLORS.purple:
                path += "purple";
                break;
        }
        path += ".png";
        return path;
    }

    /**
     * @param {MapView} mapView
     */
    constructor( mapView ) {
        this.mapView = mapView;
    }

    /**
     * @param {Plan} plan
     * @param {number} id
     */
    drawArrow( plan , id ) {

        /**@type {Attack}*/
        let attack = plan.object;

        let arrow = document.createElement("img");

        let dir = CubeCoordinate.directionToNumber(Coordinate.sub(attack.hexTo.coordinate, attack.hexFrom.coordinate));

        arrow.src = AttackArrowView.ARROW_FILE_PATH(dir, attack.hexFrom.cell.color);
        console.log(AttackArrowView.ARROW_FILE_PATH(dir, attack.hexFrom.cell.color));
        this.arrowStyle(dir, arrow);
        arrow.setAttribute("arrow-id", id.toString());

        this.mapView.addNode(arrow, attack.hexFrom.coordinate, this.arrowOffset(dir));
    }

    /**
     * @param {number} dir
     * @param {HTMLElement} arrow
     */
    arrowStyle( dir , arrow ) {
        switch (dir) {
            case 0: // on 1h (30 degrees)
                arrow.style.transform = "scale(-1, -1)";
                break;
            case 1: // on 3h (90 degrees)
                arrow.style.transform = "scaleX(-1)";
                break;
            case 2: // on 5h (150 degrees)
                arrow.style.transform = "scaleX(-1)";
                break;
            case 3: // on 7h (210 degrees (-150))
                //nothing
                break;
            case 4: // on 9h (270 degrees (-90))
                //nothing
                break;
            case 5: // on 11h (330 degrees (-30))
                arrow.style.transform = "scaleY(-1)";
                break;
            default: throw Error("Direction must be set");
        }
        switch (dir) {
            case 0: // on 1h (30 degrees)
            case 2: // on 5h (150 degrees)
            case 3: // on 7h (210 degrees (-150))
            case 5: // on 11h (330 degrees (-30))
                arrow.style.width = MapView.OPTIONS.hexWidth/2 + "px";
                arrow.style.height = MapView.OPTIONS.hexHeight*3/4 + "px";
                break;
            case 4: // on 9h (270 degrees (-90))
            case 1: // on 3h (90 degrees)
                arrow.style.width = MapView.OPTIONS.hexWidth + "px";
                arrow.style.height = MapView.OPTIONS.hexHeight/2 + "px";
                break;
        }
        arrow.style.position = "absolute";
    }

    /**
     * @param {number} dir
     * @return {Point}
     */
    arrowOffset(dir){
        let offset = new Point(0,0);
        let width = MapView.OPTIONS.hexWidth;
        let height = MapView.OPTIONS.hexHeight;
        switch (dir) {
            case 0: // on 1h (30 degrees)
                offset.x = width/2;
                offset.y = -height/4;
                break;
            case 1: // on 3h (90 degrees)
                offset.x = width/2;
                offset.y = height/4;
                break;
            case 2: // on 5h (150 degrees)
                offset.x = width/2;
                offset.y = height/2;
                break;
            case 3: // on 7h (210 degrees (-150))
                offset.x = 0;
                offset.y = height/2;
                break;
            case 4: // on 9h (270 degrees (-90))
                offset.x = -width/2;
                offset.y = height/4;
                break;
            case 5: // on 11h (330 degrees (-30))
                offset.x = 0;
                offset.y = -height/4;
                break;
            default: throw Error("Direction must be set");
        }
        return offset;
    }


    /**
     * @param {Plan} plan
     * @param {number} id
     */
    onCreate( plan, id ){
        console.log("drawArrow ");
        this.drawArrow(plan, id);
    }

    /**
     * @param {Plan} plan
     * @param {number} id
     */
    onDelete( plan, id ){
        let img = document.querySelector("img[arrow-id=\""+id+ "\"");
        if(img) this.mapView.removeNode(img);
    }

    /**
     * @param {Plan} plan
     * @param {number} id
     */
    onUpdate( plan, id ){

    }

}