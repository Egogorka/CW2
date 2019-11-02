// export class HexCoordinate {
//
//     /**
//      * @param {OffsetCoordinate} offset
//      */
//     setOffsetCoordinate( offset ) {
//         this.offset = offset;
//         this.lastUpdated = "offset";
//
//         this.cube = offset.convertToCube();
//     }
//
//     /**
//      * @param {CubeCoordinate} cube
//      */
//     setCubeCoordinate( cube ) {
//         this.cube = cube;
//         this.lastUpdated = "cube";
//
//         this.offset = cube.convertToOffset();
//     }
//
//     /**
//      * @return {OffsetCoordinate}
//      */
//     getOffsetCoordinate() {
//         if (this.lastUpdated === "offset")
//             return this.offset;
//         this.lastUpdated = "offset";
//         return this.offset = this.cube.convertToOffset();
//     }
//
//     /**
//      * @return {CubeCoordinate}
//      */
//     getCubeCoordinate() {
//         if (this.lastUpdated === "cube")
//             return this.cube;
//         this.lastUpdated = "cube";
//         return this.cube = this.offset.convertToCube();
//     }
// }

export class CubeCoordinate {
    /**
     * @param {number} x
     * @param {number} y
     * @param {number} [z]
     */
    constructor( x, y, z ){
        if( isNaN(z) ){
            this.x = x;
            this.y = y;
            this.z = -(x+y);
        } else
        if( isNaN(x) ){
            this.x = -(y+z);
            this.y = y;
            this.z = z;
        } else
        if( isNaN(y) ){
            this.x = x;
            this.y = -(x+z);
            this.z = z;
        } else {
            this.x = x;
            this.y = y;
            this.z = -(x+y);
        }
    }

    convertToOffset() {
        let col = this.x + (this.z - (this.z&1)) / 2;
        let row = this.z;
        return new OffsetCoordinate(col, row);
    }

    static directions() {
        return [
            new CubeCoordinate(+1, 0, -1), new CubeCoordinate(+1, -1, 0), new CubeCoordinate(0, -1, +1),
            new CubeCoordinate(-1, 0, +1), new CubeCoordinate(-1, +1, 0), new CubeCoordinate(0, +1, -1),
        ]
    }

    /**
     * @param {CubeCoordinate} hex
     */
    static directionToNumber( hex ) {
        console.log("Direction hex ", hex);
        if(CubeCoordinate.distance(hex, new CubeCoordinate(0,0,0)) !== 1)
            return 0;

        let directions = CubeCoordinate.directions();
        for( let i=0; i<6; i++){
            if( CubeCoordinate.equal(hex, directions[i])) return i;
        }
        return 0;
    }

    /**
     * @param {CubeCoordinate} a
     * @param {CubeCoordinate} b
     * @return {CubeCoordinate}
     */
    static add( a, b ){
        return new CubeCoordinate( a.x + b.x , a.y + b.y );
    }

    /**
     * @param {CubeCoordinate} a
     * @param {CubeCoordinate} b
     * @return {CubeCoordinate}
     */
    static sub( a, b ){
        return new CubeCoordinate( a.x - b.x , a.y - b.y );
    }

    /**
     * @param {CubeCoordinate} a
     * @param {CubeCoordinate} b
     * @return {boolean}
     */
    static equal( a, b ){
        return (a.x === b.x) && (a.y === b.y);
    }

    /**
     * @param {CubeCoordinate} a
     * @param {CubeCoordinate} b
     * @return {number}
     */
    static distance( a, b ){
        return (Math.abs(a.x - b.x) + Math.abs(a.y - b.y) + Math.abs(a.z - b.z)) / 2;
    }

    /**
     * @param {CubeCoordinate} a
     * @param {CubeCoordinate} b
     * @return {boolean}
     */
    static isNeighbor( a, b ){
        return (CubeCoordinate.distance(a,b) === 1);
    }

}

export class OffsetCoordinate {
    // Considering ODD-R type
    constructor( x , y ) {
        this.x = x;
        this.y = y;
    }

    convertToCube(){
        let x = this.x - (this.y - (this.y&1)) / 2;
        let z = this.y;
        let y = -x-z;

        return new CubeCoordinate(x,y,z);
    }

    /**
     * @param {OffsetCoordinate} a
     * @param {OffsetCoordinate} b
     * @return {boolean}
     */
    static isNeighbor( a, b ){
        return CubeCoordinate.isNeighbor( a.convertToCube(), b.convertToCube() );
    }

    /**
     * @param {OffsetCoordinate} a
     * @param {OffsetCoordinate} b
     * @return {number}
     */
    static distance( a, b ){
        return CubeCoordinate.distance( a.convertToCube(), b.convertToCube() );
    }
}

export class Coordinate {

    // no constructor

    /**
     * @param {CubeCoordinate|OffsetCoordinate} a
     * @return {CubeCoordinate}
     */
    static toCube( a ){
        return ( a instanceof CubeCoordinate ) ? a : a.convertToCube();
    }

    /**
     * @param {CubeCoordinate|OffsetCoordinate} a
     * @param {CubeCoordinate|OffsetCoordinate} b
     * @return {boolean}
     */
    static isNeighbor( a, b ){
        a = Coordinate.toCube(a); b = Coordinate.toCube(b);
        return CubeCoordinate.isNeighbor(a,b);
    }

    /**
     * @param {CubeCoordinate|OffsetCoordinate} a
     * @param {CubeCoordinate|OffsetCoordinate} b
     * @return {CubeCoordinate}
     */
    static add( a, b ){
        a = Coordinate.toCube(a); b = Coordinate.toCube(b);
        return new CubeCoordinate( a.x + b.x , a.y + b.y );
    }

    /**
     * @param {CubeCoordinate|OffsetCoordinate} a
     * @param {CubeCoordinate|OffsetCoordinate} b
     * @return {CubeCoordinate}
     */
    static sub( a, b ){
        a = Coordinate.toCube(a); b = Coordinate.toCube(b);
        return new CubeCoordinate( a.x - b.x , a.y - b.y );
    }

    /**
     * @param {CubeCoordinate|OffsetCoordinate} a
     * @param {CubeCoordinate|OffsetCoordinate} b
     * @return {boolean}
     */
    static equal( a, b ){
        a = Coordinate.toCube(a); b = Coordinate.toCube(b);
        return (a.x === b.x) && (a.y === b.y);
    }

    /**
     * @param {CubeCoordinate|OffsetCoordinate} a
     * @param {CubeCoordinate|OffsetCoordinate} b
     * @return {number}
     */
    static distance( a, b ){
        a = Coordinate.toCube(a); b = Coordinate.toCube(b);
        return (Math.abs(a.x - b.x) + Math.abs(a.y - b.y) + Math.abs(a.z - b.z)) / 2;
    }

}
