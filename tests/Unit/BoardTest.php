<?php declare(strict_types=1);

namespace Tests\Unit;

use Checkers\Board;
use Checkers\Square;
use PHPUnit\Framework\TestCase;

class BoardTest extends TestCase
{
    private array $grid = [];

    protected function setUp() : void
    {
        parent::setUp();

        for ($r = 0; $r < 10; $r++) {
            for ($c = 0; $c < 10; $c++) {
                $this->grid[$r][$c] = new Square($r, $c, null);
            }
        }
    }

    /** @test */
    public function it_should_get_pieces_of_a_player() : void
    {
        $this->grid[0][1] = $square1 = new Square(0, 1, 'black');
        $this->grid[0][3] = $square2 = new Square(0, 3, 'black');
        $this->grid[4][4] = $square3 = new Square(4, 4, 'black');

        $board = new Board($this->grid);

        $expected = [$square1, $square2, $square3];
        self::assertEquals($expected, $board->getPiecesOf('black')->all());
    }
}
