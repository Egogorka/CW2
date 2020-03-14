<?php


namespace eduslim\interfaces\domain\mapstate;


interface HexInterface
{
    public function getCell():CellInterface;
    public function setCell(CellInterface $cell):void;

    public function getCoordinate():OffsetCoordinateInterface;
    public function setCoordinate(OffsetCoordinateInterface $coordinate):void;
}