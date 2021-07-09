<?php declare(strict_types=1);

namespace Checkers;

use Illuminate\Support\Collection;
use JsonSerializable;

/**
 * This value object contains the current board state.
 */
final class Board implements JsonSerializable
{
    private array $grid;

    public function __construct(array $grid)
    {
        foreach ($grid as $row => $columns) {
            foreach ($columns as $col => $square) {
                $this->grid[$row][$col] = $square instanceof Square ? $square : Square::fromArray($square);
            }
        }
    }

    public function getSquare(int $row, int $col) : Square
    {
        return $this->grid[$row][$col];
    }

    /** @return Collection|Square[] */
    public function getPiecesOf(string $player): Collection
    {
        return collect($this->grid)->flatMap(function ($columns) use ($player) {
            return array_filter($columns, fn (Square $square) => $square->player === $player);
        });
    }

    public function apply(Move $move) : void
    {
        $start = $move->start;
        $target = $move->target;
        $square = $this->grid[$start->row][$start->col];
        $this->grid[$start->row][$start->col] = new Square($square->row, $square->col, null);
        $this->grid[$target->row][$target->col] = $target;
    }

    public function jsonSerialize()
    {
        return $this->grid;
    }
}
