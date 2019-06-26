<?php


namespace eduslim\interfaces\domain\mapstate;


interface CellInterface
{
    const STRUCTURES = [

        0 => 'noStruct',
        1 => 'base',
        2 => 'harvester',
        3 => 'radar',
        4 => 'shifactory',

        'noStruct' => 0,
        'base' => 1,
        'harvester' => 2,
        'radar' => 3,
        'shifactory' => 4,

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

    public function setStructure(int $structureID);
    public function setColor(int $colorID);

    public function getStructure():?int;
    public function getColor():?int;

    public function getCodedPair():?string;
}