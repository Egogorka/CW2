<?php


namespace eduslim\interfaces\domain\mapstate;


interface OffsetCoordinateInterface
{
    // clock rule
    const DIRECTIONS = [
        'ur' => 0, // Up - right
        'rr' => 1, // Right
        'dr' => 2, // Down - right
        'dl' => 3, // Down - left
        'll' => 4, // Left
        'ul' => 5, // Up - left

        0 => 'ur',
        1 => 'rr',
        2 => 'dr',
        3 => 'dl',
        4 => 'll',
        5 => 'ul',
    ];

    public function setPosition(int $x, int $y);

    public function getX():?int;
    public function getY():?int;

    // Shifting the coordinates corresponding to the direction (look at DIRECTIONS)
    public function shiftPosition(int $dirID);

}