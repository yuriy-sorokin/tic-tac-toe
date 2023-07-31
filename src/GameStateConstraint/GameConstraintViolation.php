<?php
declare(strict_types=1);

namespace TicTacToe\GameStateConstraint;

class GameConstraintViolation
{
    private string $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
