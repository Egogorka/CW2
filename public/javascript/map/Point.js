
// Stupid % operator
const modEx = function (x,y) {
    return x - Math.floor(x/y)*y;
};

export default class Point {

    /**
     * @param {number} x 
     * @param {number} y 
     */
    constructor(x, y){
        this.x = x;
        this.y = y;
    }

    /**
     * @param {Point} point
     * @return {Point}
     */
    static clone( point ){
        return new Point(point.x, point.y);
    }

    toString() {
        return this.x+":"+this.y;
    }

    static equal( p1, p2 ){
        return (p1.x === p2.x)&&(p1.y === p2.y);
    }

    /**
     * @return {Point}
     * @param {Point} p1
     * @param {Point} p2
     */
    static add( p1 , p2 ){
        let x = p1.x + p2.x;
        let y = p1.y + p2.y;
        return new Point(x,y);
    }

    /**
     * @param {Point} p1
     * @param {Point} p2
     * @return {Point}
     */
    static sub( p1, p2 ){
        let x = p1.x - p2.x;
        let y = p1.y - p2.y;
        return new Point(x,y);
    }

    /**
     * @param {Point} p1
     * @param {Point} p2
     * @return {Point}
     */
    static scaleUp( p1 , p2 ){
        let x = p1.x * p2.x;
        let y = p1.y * p2.y;
        return new Point(x,y);
    }

    /**
     * @param {Point} p1
     * @param {Point} p2
     * @return {Point}
     */
    static scaleDown( p1 , p2 ){
        let x = p1.x / p2.x;
        let y = p1.y / p2.y;
        return new Point(x,y);
    }

    /**
     * @return {Point}
     * @param {Point} p
     * @param {number} s
     */
    static mulScalar( p , s ){
        let x = p.x * s;
        let y = p.y * s;
        return new Point(x,y);
    }

    /**
     * @param {Point} p
     */
    static pointFloor( p ){
        let x = Math.floor(p.x);
        // noinspection JSSuspiciousNameCombination
        let y = Math.floor(p.y);
        return new Point(x, y);
    }
    
    shiftPosition( dir ){
        switch ( dir ){
            case Point.DIRECTIONS['rr']:
                this.x++;
                break;

            case Point.DIRECTIONS['ll']:
                this.x--;
                break;

            case Point.DIRECTIONS['ur']:
                this.x += modEx(this.y,2);
                this.y--;
                break;

            case Point.DIRECTIONS['ul']:
                this.x -= modEx(this.y+1,2);
                this.y--;
                break;

            case Point.DIRECTIONS['dr']:
                this.x += modEx(this.y, 2);
                this.y++;
                break;

            case Point.DIRECTIONS['dl']:
                this.x -= modEx(this.y+1,2);
                this.y++;
                break;
        }
    }

    /**
     * @param {Point} pt1
     * @param {Point} pt2
     * @return {boolean}
     */
    static isNeighbor( pt1, pt2 ){
        try {
            Point.getDirection( pt1 , pt2 );
            return true;
        } catch (e) {
            return false;
        }
    }

    /**
     * @param {Point} ptFrom
     * @param {Point} ptTo
     * @return {number}
     */
    static getDirection( ptFrom , ptTo ){
        // Test, if is a neighbor
        let offset = Point.sub(ptTo, ptFrom);

        if( (Math.abs(offset.x) > 1) || (Math.abs(offset.y) > 1) ) throw new Error("Not a neighbor");

        for (let i = 0; i < 6; i++) {
            offset.shiftPosition(i);

            if ((offset.x === 0) && (offset.y === 0)) return i;
            offset.shiftPosition(Point.oppositeDirection(i));
        }

        throw new Error("Not a neighbor");
    }

    static oppositeDirection( dir ){
        return (3+dir)%6;
    }
}

Point.DIRECTIONS = {
    'ur' : 0,
    'rr' : 1,
    'dr' : 2,
    'dl' : 3,
    'll' : 4,
    'ul' : 5,

    0 : 'ur',
    1 : 'rr',
    2 : 'dr',
    3 : 'dl',
    4 : 'll',
    5 : 'ul',
};
