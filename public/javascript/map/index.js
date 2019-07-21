
// Cell Module
//
//     class Cell {
//
//         /**
//          * @param {number} color
//          * @param {number} structure
//          */
//         constructor(color, structure) {
//             this.color = color;
//             this.structure = structure;
//         }
//
//         /**
//          * @return {string}
//          */
//         encode() {
//             return String(this.color + ";" + this.structure);
//         }
//
//         /**
//          * @param {string} str
//          */
//         decode(str) {
//             let ar = str.split(";");
//             this.color = ar[0];
//             this.structure = ar[1];
//         }
//     }
//
//     Cell.STRUCTURES =
//         {
//             0: 'noStruct',
//             7: 'base',
//             8: 'harvester',
//             9: 'radar',
//             10: 'shipFactory',
//
//             "noStruct": 0,
//             "base": 7,
//             "harvester": 8,
//             "radar": 9,
//             "shipFactory": 10,
//         };
//
//     Cell.COLORS =
//         {
//             0: 'neutral',
//
//             1: 'purple',
//             2: 'red',
//             3: 'yellow',
//             4: 'green',
//             5: 'cyan',
//             6: 'blue',
//
//             'neutral': 0,
//
//             'purple': 1,
//             'red': 2,
//             'yellow': 3,
//             'green': 4,
//             'cyan': 5,
//             'blue': 6,
//         };
//
// // Point Module
//
//     class Point {
//
//         /**
//          * @param {number} x
//          * @param {number} y
//          */
//         constructor(x, y){
//             this.x = x;
//             this.y = y;
//         }
//
//         shiftPosition( dir ){
//             switch ( dir ){
//                 case Point.DIRECTIONS['rr']:
//                     this.posX++;
//                     break;
//
//                 case Point.DIRECTIONS['ll']:
//                     this.posX--;
//                     break;
//
//                 case Point.DIRECTIONS['ur']:
//                     this.posX += (this.posY % 2);
//                     this.posY--;
//                     break;
//
//                 case Point.DIRECTIONS['ul']:
//                     this.posX -= ((this.posY+1) % 2);
//                     this.posY--;
//                     break;
//
//                 case Point.DIRECTIONS['dr']:
//                     this.posX += (this.posY % 2);
//                     this.posY++;
//                     break;
//
//                 case Point.DIRECTIONS['dl']:
//                     this.posX -= ((this.posY+1) % 2);
//                     this.posY++;
//                     break;
//             }
//         }
//     }
//
//     Point.DIRECTIONS = {
//         'ur' : 0,
//         'rr' : 1,
//         'dr' : 2,
//         'dl' : 3,
//         'll' : 4,
//         'ul' : 5,
//
//         0 : 'ur',
//         1 : 'rr',
//         2 : 'dr',
//         3 : 'dl',
//         4 : 'll',
//         5 : 'ul',
//     };
//
// // MapView Module
//
//     class MapView {
//
//         /**
//          * A node in the DOM tree.
//          *
//          * @external Node
//          * @see {@link https://developer.mozilla.org/en-US/docs/Web/API/Node Node}
//          */
//
//         /**
//          * @param {Node} MapBoardElement
//          */
//         constructor( MapBoardElement ){
//
//             let STRUCTURES = Cell.STRUCTURES;
//             let COLORS = Cell.COLORS;
//
//             const imageRoot = "/images/mapStuff";
//
//             let IMAGE_TABLE = MapView.IMAGE_TABLE;
//
//             IMAGE_TABLE[STRUCTURES.base] = imageRoot+"/structures/base.png";
//             IMAGE_TABLE[STRUCTURES.harvester] = imageRoot+"/structures/harvester.png";
//             IMAGE_TABLE[STRUCTURES.radar] = imageRoot+"/structures/radar.png";
//             IMAGE_TABLE[STRUCTURES.shipFactory] = imageRoot+"/structures/shipfactory.png";
//
//             IMAGE_TABLE[COLORS.neutral] = imageRoot+"/hexagons/neutral.png";
//             IMAGE_TABLE[COLORS.red] = imageRoot+"/hexagons/red.png";
//             IMAGE_TABLE[COLORS.yellow] = imageRoot+"/hexagons/yellow.png";
//             IMAGE_TABLE[COLORS.green] = imageRoot+"/hexagons/green.png";
//             IMAGE_TABLE[COLORS.cyan] = imageRoot+"/hexagons/cyan.png";
//             IMAGE_TABLE[COLORS.blue] = imageRoot+"/hexagons/blue.png";
//             IMAGE_TABLE[COLORS.purple] = imageRoot+"/hexagons/purple.png";
//
//             this.board = MapBoardElement;
//
//         }
//         /*
//         neutral_alias: 'hexagons/empty.png',
//
//         purple_alias : 'hexagons/hxgonPurple.png',
//         red_alias    : 'hexagons/hxgonRed.png',
//         yellow_alias : 'hexagons/hxgonYellow.png',
//         green_alias  : 'hexagons/hxgonGreen.png',
//         cyan_alias   : 'hexagons/hxgonCyan.png',
//         blue_alias   : 'hexagons/hxgonBlue.png',
//
//     // Структуры
//
//         base         : 'upgrades/base_1.png',
//         harvester    : 'upgrades/harvester_1.png',
//         radar        : 'upgrades/radar_1.png',
//         shipfactory  : 'upgrades/shipfactory_1.png'
//         */
//
//         /**
//          * @param {Cell} cell
//          * @param {Point} point
//          */
//         appendHex( cell , point ){
//
//             let hexagon = document.createElement("img");
//             let structure = document.createElement("img");
//
//             hexagon.src = MapView.IMAGE_TABLE[cell.color];
//             structure.src = MapView.IMAGE_TABLE[cell.structure];
//
//             hexagon.style.width = MapView.OPTIONS.hexWidth + "px";
//             hexagon.style.height = MapView.OPTIONS.hexHeight + "px";
//             hexagon.id = point.x + ";" + point.y + ";H;" + cell.color;
//             hexagon.classList.add("hexagon");
//
//             structure.style.height = MapView.OPTIONS.structureHeight + "px";
//             structure.style.width = MapView.OPTIONS.structureWidth + "px";
//             structure.id = point.x + ";" + point.y + ";S;" + cell.structure;
//             structure.classList.add("structure");
//
//             let x = MapView.OPTIONS.offsetX + this.board.clientWidth/2;
//             let y = MapView.OPTIONS.offsetX + this.board.clientHeight/2;
//
//             x +=  MapView.OPTIONS.hexWidth*point.x;
//             y += (MapView.OPTIONS.hexHeight - MapView.OPTIONS.hexMiddleSection)*point.y;
//
//             x += MapView.OPTIONS.hexWidth*(point.y & 1)/2;
//
//             hexagon.style.marginTop = y + "px";
//             hexagon.style.marginLeft = x + "px";
//
//             structure.style.marginTop = y + (MapView.OPTIONS.hexHeight - MapView.OPTIONS.structureHeight)/2 + "px";
//             structure.style.marginLeft = x + (MapView.OPTIONS.hexWidth - MapView.OPTIONS.structureWidth)/2 + "px";
//
//             this.board.appendChild(hexagon);
//             if( cell.structure !== Cell.STRUCTURES.noStruct)
//                 this.board.appendChild(structure);
//         }
//     }
//
//     MapView.OPTIONS = {
//
//         // Considering the "px"
//         hexWidth : 70,
//         hexHeight : 70,
//
//         hexMiddleSection : 70/4,
//
//         structureWidth : 60,
//         structureHeight : 60,
//
//         offsetX : 0,
//         offsetY : 0,
//
//     };
//
//     MapView.IMAGE_TABLE = {};
//
// // MapState Module
//
//     class MapState {
//         /**
//          * @param {string} mapRaw
//          */
//         constructor(mapRaw){
//
//             this.map = [];
//             this.bases = [];
//             this.structures = [];
//
//             // mapRaw : {x|y;type;type|y;type;type|...|y;type;type"x|y;type;...;type" }
//
//             let mapDec1 = mapRaw.split("\"");
//             //  mapDec1 : {x|y;type;type|y;type;type|...|y;type;type , ... , x|y;type;...;type  , space }
//
//             for (var i = 0; i < mapDec1.length-1; i++){
//
//                 let mapDec2 = mapDec1[i].split("|");
//                 //  mapDec2 : { x , y;type;type , y;type;type , ... , y;type;type }
//
//                 let x = Number(mapDec2[0]);
//
//                 this.map[x] = [];
//
//                 for( var j = 1; j < mapDec2.length; j++ ){
//                     let mapDec3 = mapDec2[j].split(";");
//                     //  mapDec3 : { y , type(color) , type(structure) }
//
//                     let y = Number(mapDec3[0]);
//
//                     let cell = this.map[x][y] = new Cell(Number(mapDec3[1]), Number(mapDec3[2]));
//                     let point = new Point(x,y);
//
//                     this.checkCell( cell , point );
//                 }
//             }
//         }
//
//         /**
//          * @param {Cell} cell
//          * @param {Point} point
//          */
//         checkCell( cell, point ) {
//             if (cell.structure === Cell.STRUCTURES['base']) {
//                 this.bases.push({cell: cell, position: point});
//             }
//
//             if (cell.structure !== Cell.STRUCTURES['noStruct']) {
//
//                 if (this.structures[cell.color] === undefined)
//                     this.structures[cell.color] = [];
//
//                 if (this.structures[cell.color][cell.structure] === undefined)
//                     this.structures[cell.color][cell.structure] = [];
//
//                 this.structures[cell.color][cell.structure].push(point);
//             }
//         }
//
//         /**
//          * @param {Cell} cell
//          * @return {Array}
//          */
//         getArrayOfCell( cell ){
//             return this.structures[cell.color][cell.structure];
//         }
//
//         getAmountOfCell( cell ){
//             return this.getArrayOfCell(cell).length;
//         }
//
//         /**
//          * @param {Point} point
//          * @return {Cell}
//          */
//         getCell( point ) {
//             return this.map[point.x][point.y];
//         }
//
//         /**
//          * @param {Cell}  cell
//          * @param {Point} point
//          */
//         setCell( cell, point) {
//             this.map[point.x][point.y] = cell;
//         }
//
//         /**
//          * Callback description
//          * @callback thatCallback
//          * @param {Cell}
//          * @param {Point}
//          */
//
//         /**
//          * @param {thatCallback} func
//          * @return {void}
//          */
//         forEachCell( func ){
//             let that = this;
//             that.map.forEach( function ( row, x ) {
//                 row.forEach( function ( cell, y ) {
//                     func( cell, new Point(x,y));
//                 });
//             });
//         }
//
//
//         /**
//          * @return {string}
//          */
//         encode(){
//             /*
//             var savemap = "";
//             var savemap_y = "";
//             MapBoard.forEach( function (hextable_x , i) {
//                 savemap_y = "";
//                 hextable_x.forEach( function (hextable_y , j) {
//                     if( hextable_y[1] == 0 || key_table[hextable_y[1]] === undefined){
//                         hextable_y[1] = 0;
//                         savemap_typeofhex = hextable_y.join(':');
//                     }
//                     savemap_y = savemap_y + "|" + j + ";" + hextable_y[0] + ";" + hextable_y[1];
//                 });
//                 if (savemap_y != "")
//                     savemap = savemap + i + savemap_y + "\"";
//             });
//             return savemap;*/
//
//             let out = "";
//
//             // mapRaw : {x|y;type;type|y;type;type|...|y;type;type"x|y;type;...;type" }
//             this.map.forEach( function ( row, x ) {
//
//                 out += x;
//                 row.forEach( function ( cell, y ) {
//                     out += "|" + y + ";";
//
//                     out += cell.encode();
//                 });
//                 out += "\"";
//
//             });
//
//             return out;
//         }
//     }

import MapView from "./MapView.js";
import MapState from "./MapState.js";

//let mapRaw = '32|31;2;7"33|29;0;0|30;0;0|31;0;8|32;0;0|33;0;0"34|31;0;0"35|31;0;0"36|30;0;0|32;0;0"37|30;0;0|32;0;0"';
//35|30;0;0|31;4;7|32;0;0"36|29;0;0|30;5;7|31;0;8|32;3;7|33;0;0"37|30;6;7|31;1;7|32;2;7"38|30;0;0|32;0;0"
let map = new MapState(mapRaw);

let view = new MapView(document.getElementById("MapBoard"), {
    offsetX : -map.MapParams.minX*(MapView.OPTIONS.hexWidth) + 100,
    offsetY : -map.MapParams.minY*(MapView.OPTIONS.hexHeight - MapView.OPTIONS.hexMiddleSection) + 100,
});

console.log("MapParams");
console.log(map.MapParams);

console.log("ViewOptions");
console.log(view.options);

console.log(map.map);

map.forEachCell(function (cell, point) {
    view.appendHex(cell, point);
});
