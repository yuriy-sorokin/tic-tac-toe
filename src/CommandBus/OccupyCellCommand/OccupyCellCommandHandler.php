<?php
declare(strict_types=1);

namespace TicTacToe\CommandBus\OccupyCellCommand;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use TicTacToe\Coordinate\CoordinateCollection;

/**
 *
 */
class OccupyCellCommandHandler implements MessageHandlerInterface
{
    private array $winningCombinations;

    public function __construct(CoordinateCollection ...$winningCombinations)
    {
        $this->winningCombinations = $winningCombinations;
    }

    public function __invoke(OccupyCellCommand $command): void
    {

    }
}
