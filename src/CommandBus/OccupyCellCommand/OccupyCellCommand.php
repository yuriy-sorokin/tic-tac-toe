<?php
declare(strict_types=1);

namespace TicTacToe\CommandBus\OccupyCellCommand;

use TicTacToe\Cell\Cell;
use TicTacToe\Player\Player;
use TicTacToe\PlayingField\PlayingField;

/**
 *
 */
class OccupyCellCommand
{
    private PlayingField $playingField;
    private int $cellIndex;
    private Player $player;

    /**
     * @param PlayingField $playingField
     * @param int $cellIndex
     * @param Player $player
     */
    public function __construct(PlayingField $playingField, int $cellIndex, Player $player)
    {
        $this->playingField = $playingField;
        $this->cellIndex = $cellIndex;
        $this->player = $player;
    }

    /**
     * @return PlayingField
     */
    public function getPlayingField(): PlayingField
    {
        return $this->playingField;
    }

    /**
     * @return int
     */
    public function getCellIndex(): int
    {
        return $this->cellIndex;
    }

    /**
     * @return Player
     */
    public function getPlayer(): Player
    {
        return $this->player;
    }
}
