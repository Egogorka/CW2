
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
                this.x += (this.y % 2);
                this.y--;
                break;

            case Point.DIRECTIONS['ul']:
                this.x -= ((this.y+1) % 2);
                this.y--;
                break;

            case Point.DIRECTIONS['dr']:
                this.x += (this.y % 2);
                this.y++;
                break;

            case Point.DIRECTIONS['dl']:
                this.x -= ((this.y+1) % 2);
                this.y++;
                break;
        }
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