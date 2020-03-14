<?php


namespace eduslim\domain\mapstate;


use eduslim\interfaces\domain\mapstate\CellInterface;
use eduslim\interfaces\domain\mapstate\HexInterface;
use eduslim\interfaces\domain\mapstate\OffsetCoordinateInterface;

class Hex implements HexInterface
{
    /** @var CellInterface */
    protected $cell;

    /** @var OffsetCoordinateInterface */
    protected $coordinate;

    /**
     * Hex constructor.
     * @param CellInterface $cell
     * @param OffsetCoordinateInterface $coordinate
     */
    public function __construct(CellInterface $cell, OffsetCoordinateInterface $coordinate)
    {
        $this->cell = $cell;
        $this->coordinate = $coordinate;
    }

    /**
     * @return CellInterface
     */
    public function getCell(): CellInterface
    {
        return $this->cell;
    }

    /**
     * @param CellInterface $cell
     */
    public function setCell(CellInterface $cell): void
    {
        $this->cell = $cell;
    }

    /**
     * @return OffsetCoordinateInterface
     */
    public function getCoordinate(): OffsetCoordinateInterface
    {
        return $this->coordinate;
    }

    /**
     * @param OffsetCoordinateInterface $coordinate
     */
    public function setCoordinate(OffsetCoordinateInterface $coordinate): void
    {
        $this->coordinate = $coordinate;
    }
}