<?php
declare(strict_types=1);

namespace TicTacToe\GameStateConstraint;

interface GameStateConstraintValidatorInterface
{
    public function validate(GameStateConstraintValidatorMessage $message): ?GameConstraintViolation;
}
