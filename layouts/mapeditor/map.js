
const CellWidth  = 10;
const CellHeight = 10;

/*
 *  Hex is a ordered collection of points
 *  In our case, of 6 points (and only 6
 *  They are placed on 1x1 plane (so their coordinates
 *  must be between 1 and 0 )
 */
function aHex(){
    this.width  = CellWidth;
    this.height = CellHeight;

    this.points = [];

    this.addPoint = function (point) {
        x = point.x;
        y = point.y;

        if ( x > 1 || x < 0 ) return false;
        if ( y > 1 || y < 0 ) return false;

        this.points.push(point);
    }


}



function aPoint( x, y , type='int'){
    if (type === 'int') {
        this.x = isNaN(parseInt(x)) ? 0 : parseInt(x);
        this.y = isNaN(parseInt(y)) ? 0 : parseInt(y);
    } else {
        this.x = isNaN(parseFloat(x)) ? 0 : parseFloat(x);
        this.y = isNaN(parseFloat(y)) ? 0 : parseFloat(y);
    }
}

function aCell(clan, struct){
    this.clan   = clan;
    this.struct = struct;
}

function aMap() {
    this.map = [];

    this.addCell = function(point, cell) {
        x = point.x;
        y = point.y;

        if (!Array.isArray(this.map[x])){
            this.map[x] = [];
        }

        if (cell instanceof aCell || cell == null){
            this.map[x][y] = cell;
        } else {
            this.map[x][y] = null;
        }

    }

}

function aCursor(){
    this.curCell = new Cell(0,0);

    /*
     *  Gets an point of canvas (relative to upper left corner)
     *  returns the position of cell on the map
     */

    this.pixel2hex = function(point){
        x = point.x;
        y = point.y;

        x = x / CellWidth;
        y = y / CellHeight;

        x = Math.floor(x);
        y = Math.floor(y);

        return point;
    }


}
