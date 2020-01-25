<?php


namespace eduslim\domain\mapstate;


use eduslim\interfaces\domain\mapstate\PointInterface;

class Point implements PointInterface
{
    /*const DIRECTIONS = [
        'ur' => 0,
        'rr' => 1,
        'dr' => 2,
        'dl' => 3,
        'll' => 4,
        'ul' => 5,

        0 => 'ur',
        1 => 'rr',
        2 => 'dr',
        3 => 'dl',
        4 => 'll',
        5 => 'ul',
    ];*/

    /**
     * @var int $posX
     * @var int $posY
     */
    protected $posX;
    protected $posY;

    public function __construct( int $x, int $y)
    {
        $this->setPosition($x, $y);
    }

    public function setPosition(int $x, int $y){
        $this->posX = $x;
        $this->posY = $y;
    }

    public function getX():?int
    {
        return $this->posX;
    }

    public function getY():?int
    {
        return $this->posY;
    }

    public function shiftPosition( int $dirID ){
        switch($dirID){
            case self::DIRECTIONS['rr']:
                $this->posX++;
                break;

            case self::DIRECTIONS['ll']:
                $this->posX--;
                break;

            case self::DIRECTIONS['ur']:
                $this->posX += ($this->posY % 2);
                $this->posY--;
                break;

            case self::DIRECTIONS['ul']:
                $this->posX -= (($this->posY+1) % 2);
                $this->posY--;
                break;

            case self::DIRECTIONS['dr']:
                $this->posX += ($this->posY % 2);
                $this->posY++;
                break;

            case self::DIRECTIONS['dl']:
                $this->posX -= (($this->posY+1) % 2);
                $this->posY++;
                break;
        }
    }
}