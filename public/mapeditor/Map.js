
function Point(x,y) {
    return {x: x, y: y};
}

function Cell() {
    this.structures = {
        empty     : 0,
        base      : 1,
        harvester : 2,
    };

    // clanN = 0 - neutral

    this.struct = 0;
    this.clanN  = 0;
}



function Map() {
    this.arr = [];

    this.addCell = function (point, cell) {
        yArr = this.arr[point.x];
        if (!Array.isArray(yArr)) this.arr[point.x] = [];
        this.arr[point.x][point.y] = cell;

        return true;
    };

    this.delCell = function (point) {
        yArr = this.arr[point.x];
        if (!Array.isArray(yArr)) return false;

        this.arr[point.x][point.y] = 0;
    };
}