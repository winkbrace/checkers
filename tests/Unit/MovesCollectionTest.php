<?php declare(strict_types=1);

namespace Tests\Unit;

use Checkers\Move;
use Checkers\MovesCollection;
use Checkers\Square;
use PHPUnit\Framework\TestCase;

class MovesCollectionTest extends TestCase
{
    public function test_contains_move() : void
    {
        $collection = new MovesCollection([
            new Move(new Square(7, 2, 'white'), new Square(6, 3, null)),
            new Move(new Square(7, 2, 'white'), new Square(6, 1, null)),
        ]);

        self::assertTrue($collection->containsMove(
            new Move(new Square(7, 2, 'white'), new Square(6, 3, null)))
        );

        self::assertFalse($collection->containsMove(
            new Move(new Square(5, 2, 'white'), new Square(6, 3, null)))
        );
    }
}
