<?php
declare(strict_types=1);

namespace TicTacToe\GameStateConstraint;

use TicTacToe\Coordinate\CoordinateCollection;

class GameStateConstraint
{
    private array $cellsCombinations;

    public function __construct(CoordinateCollection ...$cellsCombinations)
    {
        $this->cellsCombinations = $cellsCombinations;
    }

    public function getCellsCombinations(): array
    {
        return $this->cellsCombinations;
    }
}
