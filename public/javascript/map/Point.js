
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
        return Point(x,y);
    }

    /**
     * @param {Point} p1
     * @param {Point} p2
     * @return {Point}
     */
    static sub( p1, p2 ){
        let x = p1.x - p2.x;
        let y = p1.y - p2.y;
        return Point(x,y);
    }

    /**
     * @param {Point} p1
     * @param {Point} p2
     * @return {Point}
     */
    static scaleUp( p1 , p2 ){
        let x = p1.x * p2.x;
        let y = p1.y * p2.y;
        return Point(x,y);
    }

    /**
     * @param {Point} p1
     * @param {Point} p2
     * @return {Point}
     */
    static scaleDown( p1 , p2 ){
        let x = p1.x / p2.x;
        let y = p1.y / p2.y;
        return Point(x,y);
    }

    /**
     * @return {Point}
     * @param {Point} p
     * @param {number} s
     */
    static mulScalar( p , s ){
        let x = p.x * s;
        let y = p.y * s;
        return Point(x,y);
    }

    /**
     * @param {Point} p
     * @param {Function} func
     */
    static pointFunction( p , func ){
        p.x = func(p.x);
        p.y = func(p.y);
    }
    
    shiftPosition( dir ){
        switch ( dir ){
            case Point.DIRECTIONS['rr']:
                this.posX++;
                break;

            case Point.DIRECTIONS['ll']:
                this.posX--;
                break;

            case Point.DIRECTIONS['ur']:
                this.posX += (this.posY % 2);
                this.posY--;
                break;

            case Point.DIRECTIONS['ul']:
                this.posX -= ((this.posY+1) % 2);
                this.posY--;
                break;

            case Point.DIRECTIONS['dr']:
                this.posX += (this.posY % 2);
                this.posY++;
                break;

            case Point.DIRECTIONS['dl']:
                this.posX -= ((this.posY+1) % 2);
                this.posY++;
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