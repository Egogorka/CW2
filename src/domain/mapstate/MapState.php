<?php
/**
 * Created by PhpStorm.
 * User: EGor
 * Date: 07.04.2019
 * Time: 14:49
 */

namespace eduslim\domain\mapstate;


use eduslim\domain\mapstate\Cell;
use eduslim\domain\mapstate\Point;
use eduslim\interfaces\domain\mapstate\CellInterface;
use eduslim\interfaces\domain\mapstate\MapStateInterface;
use eduslim\interfaces\domain\mapstate\PointInterface;

class MapState implements MapStateInterface
{

    /*
     * 1 Layer - X
     *      2 Layer - Y
     *          3 Layer - Cell;
     */
    protected $map = array();

    /*
     * Consists of Points of bases
     */
    protected $bases = array();

    /*
     * Consists of arrays of Points of corresponding structure
     * color =>
     *   structure =>
     *      Point , Point , ... , Point
     */
    protected $structures = array();

    public function __construct(string $mapRaw)
    {
        // mapRaw : x|y;type;type|y;type;type|..."x|y;type;type"
        $mapDec1 = explode("\"", $mapRaw);
        $map = array();

        // mapDec.1 : {x|y;type;type|y;type;type|...|y;type;type , ... , x|y;type;...;type  , space }
        $len1 = count($mapDec1);
        for($i=0; $i < $len1-1; $i++){
            $mapDec2 = explode("|",$mapDec1[$i]);

            // mapDec2 : { x , y;type;type , y;type;type , ... , y;type;type }
            $x = (int)$mapDec2[0];
            $len2 = count($mapDec2);

            $map[$x] = array();
            for($j=1; $j < $len2; $j++){
                $mapDec3 = explode(";",$mapDec2[$j]);
                // mapDec3 : { y , type(color) , type(structure) }

                $y = (int)$mapDec3[0];
                //$map[$x][$y] = array( (int)$mapDec3[1] , (int)$mapDec3[2] );

                $cell = $map[$x][$y] = new Cell((int)$mapDec3[1] , (int)$mapDec3[2]);

                $this->CheckCell($cell, new Point($x, $y));
            }
        }
    }

    protected function CheckCell(CellInterface $cell, PointInterface $point)
    {
        if($cell->getStructure() == CellInterface::STRUCTURES['base']){
                $this->bases[] = array("pos" => $point, "cell" => $cell);
        }


        if($cell->getStructure() != CellInterface::STRUCTURES['noStruct']){

            if(!key_exists($cell->getColor() ,$this->structures))
                $this->structures[$cell->getColor()] = array();

            if(!key_exists($cell->getStructure() ,$this->structures[$cell->getColor()]))
                $this->structures[$cell->getColor()][$cell->getStructure()] = array();

            $this->structures[$cell->getColor()][$cell->getStructure()][] = $point;
        }
    }

    public function setCell(PointInterface $point, CellInterface $cell)
    {
        $this->map[$point->getX()][$point->getY()] = $cell;
    }

    public function getCell(PointInterface $point):CellInterface
    {
        return $this->map[$point->getX()][$point->getY()];
    }

    public function getMap():?array
    {
        return $this->map;
    }

    public function ToString(): string
    {
        //return "hello";
        $out = "";
        foreach($this->map as $x => $mapX){
            $out .= $x;

            /**
             * @var CellInterface $cell
             */
            foreach ($mapX as $y => $cell){
                $out .= "|".$y.";".$cell->getCodedPair();
            }
            $out .= "\"";
        }
        return $out;
    }

    public function getAmountOfCell(CellInterface $cell): int
    {
        return count($this->structures[$cell->getColor()][$cell->getStructure()]);
    }

    public function getArrayOfCell(CellInterface $cell): ?array
    {
        return $this->structures[$cell->getColor()][$cell->getStructure()];
    }
}