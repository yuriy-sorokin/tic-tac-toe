<?php
declare(strict_types=1);

namespace TicTacToe\GameStateConstraint\GameWonConstraint;

use TicTacToe\Coordinate\Coordinate;
use TicTacToe\GameStateConstraint\GameStateConstraint;
use TicTacToe\GameStateConstraint\GameStateConstraintValidatorInterface;
use TicTacToe\GameStateConstraint\GameConstraintViolation;
use TicTacToe\GameStateConstraint\GameStateConstraintValidatorMessage;

class GameWonConstraintValidator implements GameStateConstraintValidatorInterface
{
    private GameStateConstraint $gameStateConstraint;

    public function __construct(GameStateConstraint $gameStateConstraint)
    {
        $this->gameStateConstraint = $gameStateConstraint;
    }

    public function validate(GameStateConstraintValidatorMessage $message): ?GameConstraintViolation
    {
        $lastOccupiedCell = $message->getLastOccupiedCell();
        $occupiedCellCoordinate = $lastOccupiedCell->getCoordinate();

        foreach ($this->gameStateConstraint->getCellsCombinations() as $winningCombination) {
            $coordinates = $winningCombination->getCoordinates();

            foreach ($coordinates as $winningCombinationRelativeCoordinate) {
                foreach ($coordinates as $coordinate) {
                    $playingFieldCoordinateAbsoluteCoordinate = new Coordinate(
                        $occupiedCellCoordinate->getX() + ($coordinate->getX() - $winningCombinationRelativeCoordinate->getX()),
                        $occupiedCellCoordinate->getY() + ($coordinate->getY() - $winningCombinationRelativeCoordinate->getY()),
                    );

                    $playFieldCell = $message->getPlayingField()->getCellByCoordinate(
                        $playingFieldCoordinateAbsoluteCoordinate
                    );

                    if (null === $playFieldCell ||
                        null === $playFieldCell->getOccupiedBy() ||
                        null === $lastOccupiedCell->getCell()->getOccupiedBy() ||
                        $lastOccupiedCell->getCell()->getOccupiedBy()->getId() !== $playFieldCell->getOccupiedBy()->getId()) {
                        continue 2;
                    }
                }

                return new GameConstraintViolation(
                    \sprintf(
                        'The winner is %s!',
                        $lastOccupiedCell->getCell()->getOccupiedBy()->getId()
                    )
                );
            }
        }

        return null;
    }
}
