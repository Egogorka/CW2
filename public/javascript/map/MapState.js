import Point from './Point';
import Cell from './Cell';

export default class MapState {


    /**
     * @param {string} mapRaw
     */
    constructor(mapRaw){

        this.map = [];
        this.MapParams = {
            minX : null,
            maxX : null,
            minY : null,
            maxY : null,

            bases : [],
            structures : []
        };


        // mapRaw : {x|y;type;type|y;type;type|...|y;type;type"x|y;type;...;type" }
        let mapDec1 = mapRaw.split("\"");
        //  mapDec1 : {x|y;type;type|y;type;type|...|y;type;type , ... , x|y;type;...;type  , space }
        for (var i = 0; i < mapDec1.length-1; i++){

            let mapDec2 = mapDec1[i].split("|");
            //  mapDec2 : { x , y;type;type , y;type;type , ... , y;type;type }

            let x = Number(mapDec2[0]);

            this.map[x] = [];

            for( var j = 1; j < mapDec2.length; j++ ){
                let mapDec3 = mapDec2[j].split(";");
                //  mapDec3 : { y , type(color) , type(structure) }

                let y = Number(mapDec3[0]);

                let cell = this.map[x][y] = new Cell(Number(mapDec3[1]), Number(mapDec3[2]));
                let point = new Point(x,y);

                this.checkCell( cell , point );
            }
        }
    }

    /**
     * @param {Cell} cell
     * @param {Point} point
     */
    checkCell( cell, point ) {
        let params = this.MapParams;

        if (cell.structure === Cell.STRUCTURES['base']) {
            params.bases.push({cell: cell, position: point});
        }

        if (cell.structure !== Cell.STRUCTURES['noStruct']) {

            if (params.structures[cell.color] === undefined)
                params.structures[cell.color] = [];

            if (params.structures[cell.color][cell.structure] === undefined)
                params.structures[cell.color][cell.structure] = [];

            params.structures[cell.color][cell.structure].push(point);
        }

        if (params.minX === null){
            params.minX = params.maxX = point.x;
            params.minY = params.maxY = point.y;
        } else {
            if( point.x > params.maxX ) params.maxX = point.x;
            if( point.x < params.minX ) params.minX = point.x;

            if( point.y > params.maxY ) params.maxY = point.y;
            if( point.y < params.minY ) params.minY = point.y;
        }
    }

    /**
     * @param {Cell} cell
     * @return {Array}
     */
    getArrayOfCell( cell ){
        return this.MapParams.structures[cell.color][cell.structure];
    }

    getAmountOfCell( cell ){
        return this.getArrayOfCell(cell).length;
    }

    /**
     * @param {Point} point
     * @return {Cell}
     */
    getCell( point ) {
        return this.map[point.x][point.y];
    }

    /**
     * @param {Cell}  cell
     * @param {Point} point
     */
    setCell( cell, point ) {
        this.map[point.x][point.y] = cell;
    }

    /**
     * Callback description
     * @callback thatCallback
     * @param {Cell}
     * @param {Point}
     */

    /**
     * @param {thatCallback} func
     * @return {void}
     */
    forEachCell( func ){
        let that = this;
        that.map.forEach( function ( row, x ) {
            row.forEach( function ( cell, y ) {
                func( cell, new Point(x,y));
            });
        });
    }


    /**
     * @return {string}
     */
    encode(){
        /*
        var savemap = "";
        var savemap_y = "";
        MapBoard.forEach( function (hextable_x , i) {
            savemap_y = "";
            hextable_x.forEach( function (hextable_y , j) {
                if( hextable_y[1] == 0 || key_table[hextable_y[1]] === undefined){
                    hextable_y[1] = 0;
                    savemap_typeofhex = hextable_y.join(':');
                }
                savemap_y = savemap_y + "|" + j + ";" + hextable_y[0] + ";" + hextable_y[1];
            });
            if (savemap_y != "")
                savemap = savemap + i + savemap_y + "\"";
        });
        return savemap;*/

        let out = "";

        // mapRaw : {x|y;type;type|y;type;type|...|y;type;type"x|y;type;...;type" }
        this.map.forEach( function ( row, x ) {

            out += x;
            row.forEach( function ( cell, y ) {
                out += "|" + y + ";";

                out += cell.encode();
            });
            out += "\"";

        });

        return out;
    }
}