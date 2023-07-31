<?php
declare(strict_types=1);

namespace TicTacToe\Cell;

use TicTacToe\Player\Player;

class Cell
{
    private int $index;
    private ?Player $occupiedBy = null;

    public function __construct(int $index)
    {
        $this->index = $index;
    }

    public function getIndex(): int
    {
        return $this->index;
    }

    public function occupyBy(Player $player): void
    {
        if (null !== $this->occupiedBy) {
            throw new \LogicException(\sprintf('Cell %d is already occupied', $this->index));
        }

        $this->occupiedBy = $player;
    }

    public function getOccupiedBy(): ?Player
    {
        return $this->occupiedBy;
    }
}
