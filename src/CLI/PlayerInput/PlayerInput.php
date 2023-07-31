<?php
declare(strict_types=1);

namespace TicTacToe\CLI\PlayerInput;

use Symfony\Component\Console\Question\Question;
use TicTacToe\Player\Player;

class PlayerInput
{
    private Player $player;
    private Question $question;

    public function __construct(Player $player, Question $question)
    {
        $this->player = $player;
        $this->question = $question;
    }

    public function getPlayer(): Player
    {
        return $this->player;
    }

    public function getQuestion(): Question
    {
        return $this->question;
    }
}
