<?php
declare(strict_types=1);

namespace TicTacToe\PlayingField;

use TicTacToe\Coordinate\CellCoordinate;
use TicTacToe\Coordinate\Coordinate;
use TicTacToe\GameStateConstraint\GameConstraintViolation;
use TicTacToe\GameStateConstraint\GameStateConstraintValidatorInterface;
use TicTacToe\GameStateConstraint\GameStateConstraintValidatorMessage;
use TicTacToe\Player\Player;
use TicTacToe\Cell\Cell;

class PlayingField
{
    private int $rows;
    private int $columns;
    /** @var CellCoordinate[] */
    private array $coordinatesMappedByCellIndex = [];
    /** @var CellCoordinate[]  */
    private array $coordinatesMappedByCoordinate = [];
    /** @var GameStateConstraintValidatorInterface[] */
    private array $gameStateValidators;

    public function __construct(int $rows, int $columns, GameStateConstraintValidatorInterface ...$gameStateValidators)
    {
        $this->rows = $rows;
        $this->columns = $columns;
        $this->gameStateValidators = $gameStateValidators;

        $this->createPlayingField();
    }

    public function getRows(): int
    {
        return $this->rows;
    }

    public function getColumns(): int
    {
        return $this->columns;
    }

    public function getCellByIndex(int $index): Cell
    {
        return $this->coordinatesMappedByCellIndex[$index]->getCell();
    }

    public function getCellByCoordinate(Coordinate $coordinate): ?Cell
    {
        $key = $this->getCoordinateKey($coordinate);

        if (false === \array_key_exists($key, $this->coordinatesMappedByCoordinate)) {
            return null;
        }

        return $this->coordinatesMappedByCoordinate[$key]->getCell();
    }

    public function occupyCell(int $cellIndex, Player $player): ?GameConstraintViolation
    {
        $coordinate = $this->coordinatesMappedByCellIndex[$cellIndex];
        $coordinate->getCell()->occupyBy($player);

        foreach ($this->gameStateValidators as $gameStateValidator) {
            $violation = $gameStateValidator->validate(new GameStateConstraintValidatorMessage($this, $coordinate));

            if (null !== $violation) {
                return $violation;
            }
        }

        return null;
    }

    private function createPlayingField(): void
    {
        $cellIndex = 1;

        for ($y = 1; $y <= $this->columns; $y++) {
            for ($x = 1; $x <= $this->rows; $x++) {
                $coordinate = new CellCoordinate(new Coordinate($x, $y), new Cell($cellIndex));
                $this->coordinatesMappedByCellIndex[$cellIndex] = $coordinate;
                $this->coordinatesMappedByCoordinate[$this->getCoordinateKey($coordinate->getCoordinate())] = $coordinate;

                $cellIndex++;
            }
        }
    }

    private function getCoordinateKey(Coordinate $coordinate): string
    {
        return \sprintf('%s-%s', $coordinate->getX(), $coordinate->getY());
    }
}
