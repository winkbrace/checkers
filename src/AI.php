<?php declare(strict_types=1);

namespace Checkers;

/**
 * This service is responsible for calculating a counter move.
 */
final class AI
{
    public const PLAYER = 'black';

    private Jury $jury;

    public function __construct(Jury $jury)
    {
        $this->jury = $jury;
    }

    public function calculateMove(Board $board): Move
    {
        $moves = $this->jury->getAllowedMovesFor($board, self::PLAYER);

        return $moves->random();
    }
}
