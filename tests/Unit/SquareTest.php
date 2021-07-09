<?php declare(strict_types=1);

namespace Tests\Unit;

use Checkers\Square;
use PHPUnit\Framework\TestCase;

class SquareTest extends TestCase
{
    /** @test */
    public function it_should_know_if_it_is_black() : void
    {
        self::assertFalse((new Square(0, 0, null))->isBlack());
        self::assertTrue((new Square(0, 1, null))->isBlack());
    }

    /** @test */
    public function it_should_know_if_it_is_empty() : void
    {
        self::assertTrue((new Square(0, 1, null))->isEmpty());
        self::assertFalse((new Square(0, 1, 'black'))->isEmpty());
    }
}
