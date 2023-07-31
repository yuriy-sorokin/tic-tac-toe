<?php
declare(strict_types=1);

use TicTacToe\Coordinate\Coordinate;
use TicTacToe\Coordinate\CoordinateCollection;
use TicTacToe\GameStateConstraint\GameStateConstraint;

require __DIR__.'/../vendor/autoload.php';

class App
{
    private const ROWS = 3;
    private const COLUMNS = 3;
    private const PLAYER_SIGNS = ['X', 'O'];

    public function start(): void
    {
        $input = new \Symfony\Component\Console\Input\ArgvInput();
        $output = new \Symfony\Component\Console\Output\ConsoleOutput();
        $output->writeln('<info>Starting a new game</info>');

        $gameStateValidators = [
            new \TicTacToe\GameStateConstraint\GameWonConstraint\GameWonConstraintValidator(
                new GameStateConstraint(
                    new CoordinateCollection(
                        new Coordinate(1, 1),
                        new Coordinate(2, 1),
                        new Coordinate(3, 1),
                    ),
                    new CoordinateCollection(
                        new Coordinate(1, 1),
                        new Coordinate(1, 2),
                        new Coordinate(1, 3),
                    ),
                    new CoordinateCollection(
                        new Coordinate(1, 1),
                        new Coordinate(2, 2),
                        new Coordinate(3, 3),
                    ),
                    new CoordinateCollection(
                        new Coordinate(3, 1),
                        new Coordinate(2, 2),
                        new Coordinate(1, 3),
                    ),
                    new CoordinateCollection(
                        new Coordinate(1, 1),
                        new Coordinate(2, 3),
                        new Coordinate(3, 1),
                    )
                )
            )
        ];

        $questionHelper = new \Symfony\Component\Console\Helper\QuestionHelper();
        $rowsQuestion = new \Symfony\Component\Console\Question\Question(
            \sprintf('Rows amount [%d]? ', static::ROWS),
            static::ROWS
        );
        $columnsQuestion = new \Symfony\Component\Console\Question\Question(
            \sprintf('Columns amount [%d]? ', static::COLUMNS),
            static::COLUMNS
        );

        $playingField = new \TicTacToe\PlayingField\PlayingField(
            (int) $questionHelper->ask($input, $output, $rowsQuestion),
            (int) $questionHelper->ask($input, $output, $columnsQuestion),
            ...$gameStateValidators
        );

        $playingFieldDrawer = new \TicTacToe\CLI\PlayingFieldDrawer\PlayingFieldDrawer($output, $playingField);

        /** @var \TicTacToe\CLI\PlayerInput\PlayerInput[] $consolePlayersInput */
        $consolePlayersInput = [];

        foreach (static::PLAYER_SIGNS as $playerSign) {
            $consolePlayersInput[] = new \TicTacToe\CLI\PlayerInput\PlayerInput(
                new TicTacToe\Player\Player($playerSign),
                new \Symfony\Component\Console\Question\Question(\sprintf('Player %s move (type 0 to start a new game): ', $playerSign))
            );
        }

        $playingFieldDrawer->draw();
        $app = $this;

        $playersLoop = static function() use (&$playersLoop, $questionHelper, $input, $output, $consolePlayersInput, $playingField, $playingFieldDrawer, $app) {
            foreach ($consolePlayersInput as $player) {
                while (true) {
                    $cellIndex = $questionHelper->ask($input, $output, $player->getQuestion());

                    if ('0' === (string) $cellIndex) {
                        $app->start();

                        return;
                    }

                    try {
                        $violation = $playingField->occupyCell((int) $cellIndex, $player->getPlayer());

                        if (null !== $violation) {
                            $output->writeln(\sprintf('<info>%s</info>', $violation->getMessage()));

                            $app->start();

                            return;
                        }

                        break;
                    } catch (\Throwable $exception) {
                        $output->writeln(\sprintf('<error>%s</error>', $exception->getMessage()));
                    }
                }

                $playingFieldDrawer->draw();
            }

            $playersLoop();
        };

        $playersLoop();
    }
}

$game = new App();
$game->start();
