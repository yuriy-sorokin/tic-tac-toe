<?php
declare(strict_types=1);

namespace TicTacToe\Coordinate;

use TicTacToe\Cell\Cell;

class CellCoordinate
{
    private Coordinate $coordinate;
    private Cell $cell;

    public function __construct(Coordinate $coordinate, Cell $cell)
    {
        $this->coordinate = $coordinate;
        $this->cell = $cell;
    }

    public function getCoordinate(): Coordinate
    {
        return $this->coordinate;
    }

    public function getCell(): Cell
    {
        return $this->cell;
    }
}
