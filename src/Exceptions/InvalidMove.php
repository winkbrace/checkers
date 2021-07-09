<?php declare(strict_types=1);

namespace Checkers\Exceptions;

use Checkers\Move;

final class InvalidMove extends \Exception
{
    public static function notMoved(Move $move) : self
    {
        return new self("This is not a move. You end on the same square you started: {$move->target}.");
    }

    public static function toWhiteSquare(Move $move) : self
    {
        return new self("Invalid Move to {$move->target}. That ends on a white square.");
    }

    public static function toOccupied(Move $move) : self
    {
        return new self("Invalid Move to {$move->target}. That ends on an occupied square.");
    }

    public static function tooManySteps(Move $move) : self
    {
        return new self("Too many steps to move from {$move->start} to {$move->target}.");
    }
}
