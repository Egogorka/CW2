
export default class Cell {

    /**
     * @param {number} color
     * @param {number} structure
     */
    constructor(color, structure){
        this.color = color;
        this.structure = structure;
    }

    /**
     * @return {string}
     */
    encode(){
        return String(this.color+";"+this.structure);
    }

    /**
     * @param {string} str
     */
    decode( str ){
        let ar = str.split(";");
        this.color = ar[0];
        this.structure = ar[1];
    }
}

Cell.STRUCTURES =
    {
        0: 'noStruct',
        7: 'base',
        8: 'harvester',
        9: 'radar',
        10: 'shipFactory',

        "noStruct": 0,
        "base": 7,
        "harvester": 8,
        "radar": 9,
        "shipFactory": 10,
    };

Cell.COLORS =
    {
        0 : 'neutral',

        1 : 'purple',
        2 : 'red',
        3 : 'yellow',
        4 : 'green',
        5 : 'cyan',
        6 : 'blue',

        'neutral' : 0,

        'purple' : 1,
        'red' : 2,
        'yellow' : 3,
        'green' : 4,
        'cyan' : 5,
        'blue' : 6,
    };
