import {OffsetCoordinate} from "Root/map/HexCoordinate";
import Cell from "Root/map/Cell";

export default class Hex {

    /**
     * @param {OffsetCoordinate} hexCoordinate
     * @param {Cell} cell
     */
    constructor( cell , hexCoordinate ) {
        this.coordinate = hexCoordinate;
        this.cell = cell;
    }

    /**
     * @return {Hex}
     */
    clone() {
        return new Hex(
            new Cell( this.cell.color , this.cell.structure ),
            new OffsetCoordinate( this.coordinate.x , this.coordinate.y )
        );
    }

}