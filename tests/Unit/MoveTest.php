<?php declare(strict_types=1);

namespace Tests\Unit;

use Checkers\Move;
use Checkers\Square;
use PHPUnit\Framework\TestCase;

class MoveTest extends TestCase
{
    /** @test */
    public function it_should_determine_if_a_move_is_equal() : void
    {
        $move1 = new Move(new Square(7, 2, 'white'), new Square(6, 3, null));
        $move2 = new Move(new Square(7, 2, 'white'), new Square(6, 3, null));
        $move3 = new Move(new Square(5, 2, 'white'), new Square(6, 3, null));

        self::assertTrue($move1->equals($move2));
        self::assertFalse($move1->equals($move3));
    }
}
