<?php


namespace eduslim\domain\mapstate;


class Cell
{
    const STRUCTURES = [

        0  => 'noStruct',
        7  => 'base',
        8  => 'harvester',
        9  => 'radar',
        10 => 'shifactory',

        'noStruct' => 0,
        'base' => 7,
        'harvester' => 8,
        'radar' => 9,
        'shifactory' => 10,

        ];

    const COLORS = [

        0 => 'neutral',

        1 => 'purple',
        2 => 'red',
        3 => 'yellow',
        4 => 'green',
        5 => 'cyan',
        6 => 'blue',

        'neutral' => 0,

        'purple' => 1,
        'red' => 2,
        'yellow' => 3,
        'green' => 4,
        'cyan' => 5,
        'blue' => 6,

        ];

    protected $structure;
    protected $color;

    public function __construct(int $color, int $structure)
    {
        $this->color = $color;
        $this->structure =$structure;
    }

    public function setStructure( int $s ){
        $this->structure = $s;
    }

    public function setColor( int $a ){
        $this->alias = $a;
    }

    public function getStructure(){
        return $this->structure;
    }

    public function getColor(){
        return $this->color;
    }

    public function getCodedPair(){
        return ($this->color).";".($this->structure);
    }

}