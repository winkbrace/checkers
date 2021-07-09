<?php declare(strict_types=1);

namespace Checkers;

use Checkers\Exceptions\InvalidMove;
use Illuminate\Support\Collection;

/**
 * This service is responsible for judging if a move is allowed.
 * Note: We are ignoring promotions to a King in these rules.
 * Note: We only calculate one move at a time. A multi-capture will have to be played in separate moves
 * Note: We're ignoring the fact you are required to take when you can. (which is the whole core of the game, I know)
 */
final class Jury
{
    public function judge(Board $board, Move $move) : bool
    {
        $this->validateMove($move);
        $allowed = $this->getAllowedMovesFor($board, $move->start->player);

        return $allowed->containsMove($move);
    }

    /**
     * Catch moves that can never be valid, regardless of the board state.
     */
    public function validateMove(Move $move) : void
    {
        if ($move->start->equals($move->target)) {
            throw InvalidMove::notMoved($move);
        }
        if ( ! $move->target->isBlack()) {
            throw InvalidMove::toWhiteSquare($move);
        }
        if ( ! $move->target->isEmpty()) {
            throw InvalidMove::toOccupied($move);
        }
        if (abs($move->start->col - $move->target->col) > 2 || abs($move->start->row - $move->target->row) > 2) {
            throw InvalidMove::tooManySteps($move);
        }
    }

    public function getAllowedMovesFor(Board $board, string $player): MovesCollection
    {
        $pieces = $board->getPiecesOf($player);

        $moves = [];
        foreach ($pieces as $piece) {
            foreach ($this->findMoves($board, $piece) as $move) {
                $moves[] = $move;
            }
        }

        return new MovesCollection($moves);
    }

    public function findMoves(Board $board, Square $piece): Collection
    {
        $opponent = $piece->player === 'white' ? 'black' : 'white';
        $targetRow = $piece->player === 'white' ? $piece->row - 1 : $piece->row + 1;

        return collect([
            // Moves
            ['row' => $targetRow, 'col' => $piece->col - 1],
            ['row' => $targetRow, 'col' => $piece->col + 1],
            // Capture moves
            ['row' => $piece->row - 2, 'col' => $piece->col - 2, 'captures' => ['row' => $piece->row - 1, 'col' => $piece->col - 1]],
            ['row' => $piece->row - 2, 'col' => $piece->col + 2, 'captures' => ['row' => $piece->row - 1, 'col' => $piece->col + 1]],
            ['row' => $piece->row + 2, 'col' => $piece->col - 2, 'captures' => ['row' => $piece->row + 1, 'col' => $piece->col - 1]],
            ['row' => $piece->row + 2, 'col' => $piece->col + 2, 'captures' => ['row' => $piece->row + 1, 'col' => $piece->col + 1]],
        ])->filter(function($target) {
            // ensure target is not out of bounds
            return $target['row'] >= 0 && $target['row'] <= 9
                && $target['col'] >= 0 && $target['col'] <= 9;
        })->filter(function($target) use ($board) {
            // ensure target is not occupied
            return $board->getSquare($target['row'], $target['col'])->player === null;
        })->filter(function($target) use ($board, $opponent) {
            // check that capture actually captures
            if (empty($target['captures'])) {
                return true;
            }
            $capture = $target['captures'];
            return $board->getSquare($capture['row'], $capture['col'])->player === $opponent;
        })->map(function($target) use ($board, $piece) {
            // map to Move containing optional capture
            $capture = $target['captures'] ?? null;
            return new Move(
                $piece,
                new Square($target['row'], $target['col'], null),
                $capture ? $board->getSquare($capture['row'], $capture['col']) : null // TODO make this work. For some reason it's not returned
            );
        });
    }
}
