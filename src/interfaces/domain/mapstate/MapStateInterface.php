<?php

namespace eduslim\interfaces\domain\mapstate;


interface MapStateInterface
{
    public function setCell(OffsetCoordinateInterface $point, CellInterface $cell);
    public function getCell(OffsetCoordinateInterface $point):?CellInterface;

    public function getMap():?array;
    public function ToString():string;

    public function getAmountOfCell( CellInterface $cell ):int;
    public function getArrayOfCell ( CellInterface $cell ):?array; // array of Points
}