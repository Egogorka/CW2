import Point from './Point';
import Cell from './Cell';

import Hex from './Hex';
import {OffsetCoordinate} from "Root/map/HexCoordinate";

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
                let coordinate = new OffsetCoordinate(x,y);

                let hex = new Hex(cell, coordinate);

                this.checkCell( hex );
            }
        }
    }

    /**
     * @param {Hex} hex
     */
    checkCell( hex ) {
        let params = this.MapParams;

        let cell = hex.cell;
        let coordinate = hex.coordinate;

        if (cell.structure === Cell.STRUCTURES['base']) {
            params.bases.push(hex);
        }

        if (cell.structure !== Cell.STRUCTURES['noStruct']) {

            if (params.structures[cell.color] === undefined)
                params.structures[cell.color] = [];

            if (params.structures[cell.color][cell.structure] === undefined)
                params.structures[cell.color][cell.structure] = [];

            params.structures[cell.color][cell.structure].push(coordinate);
        }

        if (params.minX === null){
            params.minX = params.maxX = coordinate.x;
            params.minY = params.maxY = coordinate.y;
        } else {
            if( coordinate.x > params.maxX ) params.maxX = coordinate.x;
            if( coordinate.x < params.minX ) params.minX = coordinate.x;

            if( coordinate.y > params.maxY ) params.maxY = coordinate.y;
            if( coordinate.y < params.minY ) params.minY = coordinate.y;
        }
    }

    /**
     * @param {Cell} cell
     * @return {Array}
     */
    getArrayOfHex( cell ){
        return this.MapParams.structures[cell.color][cell.structure];
    }

    getAmountOfHex( cell ){
        return this.getArrayOfHex(cell).length;
    }

    /**
     * @param {OffsetCoordinate} coordinate
     * @return {Hex}
     */
    getHex( coordinate ) {
        return new Hex(this.map[coordinate.x][coordinate.y], coordinate );
    }

    /**
     * @param {Hex} hex
     */
    setHex( hex ) {
        let coordinate = hex.coordinate;
        this.map[coordinate.x][coordinate.y] = hex.cell;
    }

    /**
     * Callback description
     * @callback thatCallback
     * @param {Hex} hex
     */

    /**
     * @param {thatCallback} func
     * @return {void}
     */
    forEachCell( func ){
        let that = this;
        that.map.forEach( function ( row, x ) {
            row.forEach( function ( cell, y ) {
                func( new Hex( cell , new OffsetCoordinate(x,y) ) );
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
        // mapRaw : {x|y;type;type|y;type;type|...|y;type;type"x|y;type;...;type" }

        let out = "";
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