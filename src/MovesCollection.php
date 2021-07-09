<?php declare(strict_types=1);

namespace Checkers;

use Illuminate\Support\Collection;

final class MovesCollection extends Collection
{
    public function containsMove(Move $move) : bool
    {
        /** @var Move $move */
        foreach ($this->items as $allowed) {
            if ($allowed->equals($move)) {
                return true;
            }
        }

        return false;
    }
}
