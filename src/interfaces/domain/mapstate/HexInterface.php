<?php


namespace eduslim\interfaces\domain\mapstate;


interface HexInterface extends \JsonSerializable
{
    public function getCell():CellInterface;
    public function setCell(CellInterface $cell):void;

    public function getCoordinate():OffsetCoordinateInterface;
    public function setCoordinate(OffsetCoordinateInterface $coordinate):void;
}