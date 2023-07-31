<?php
declare(strict_types=1);

namespace TicTacToe\Coordinate;

class CoordinateCollection
{
    private array $coordinates;

    public function __construct(Coordinate ...$coordinates)
    {
        $this->coordinates = $coordinates;
    }

    public function getCoordinates(): array
    {
        return $this->coordinates;
    }
}
