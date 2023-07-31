<?php
declare(strict_types=1);

namespace TicTacToe\GameStateConstraint;

use TicTacToe\Coordinate\CellCoordinate;
use TicTacToe\PlayingField\PlayingField;

class GameStateConstraintValidatorMessage
{
    private PlayingField $playingField;
    private CellCoordinate $lastOccupiedCell;

    public function __construct(PlayingField $playingField, CellCoordinate $lastOccupiedCell)
    {
        $this->playingField = $playingField;
        $this->lastOccupiedCell = $lastOccupiedCell;
    }

    public function getPlayingField(): PlayingField
    {
        return $this->playingField;
    }

    public function getLastOccupiedCell(): CellCoordinate
    {
        return $this->lastOccupiedCell;
    }
}
