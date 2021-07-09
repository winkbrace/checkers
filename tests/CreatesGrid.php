<?php declare(strict_types=1);

namespace Tests;

use Checkers\Square;

trait CreatesGrid
{
    public function makeEmptyGrid() : array
    {
        $grid = [];
        for ($r = 0; $r < 10; $r++) {
            for ($c = 0; $c < 10; $c++) {
                $grid[$r][$c] = new Square($r, $c, null);
            }
        }

        return $grid;
    }
}
