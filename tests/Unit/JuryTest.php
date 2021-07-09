<?php declare(strict_types=1);

namespace Tests\Unit;

use Checkers\Board;
use Checkers\Exceptions\InvalidMove;
use Checkers\Jury;
use Checkers\Move;
use Checkers\Square;
use PHPUnit\Framework\TestCase;
use Tests\CreatesGrid;

class JuryTest extends TestCase
{
    use CreatesGrid;

    private Jury $jury;

    protected function setUp() : void
    {
        parent::setUp();

        $this->jury = new Jury();
    }

    /** @test */
    public function it_should_invalidate_a_move_to_a_white_square() : void
    {
        $move = new Move(
            new Square(7, 2, 'white'),
            new Square(6, 2, null),
        );

        $this->expectException(InvalidMove::class);
        $this->expectExceptionMessage('ends on a white square.');

        $this->jury->validateMove($move);
    }

    /** @test */
    public function it_should_invalidate_a_move_to_an_occupied_square() : void
    {
        $move = new Move(
            new Square(7, 2, 'white'),
            new Square(6, 3, 'black'),
        );

        $this->expectException(InvalidMove::class);
        $this->expectExceptionMessage('ends on an occupied square.');

        $this->jury->validateMove($move);
    }

    /** @test */
    public function it_should_invalidate_a_move_of_more_than_two() : void
    {
        $move = new Move(
            new Square(7, 2, 'white'),
            new Square(4, 5, null),
        );

        $this->expectException(InvalidMove::class);
        $this->expectExceptionMessage('Too many steps');

        $this->jury->validateMove($move);
    }

    /** @test */
    public function it_should_determine_available_moves_for_a_white_piece() : void
    {
        $board = new Board($this->makeEmptyGrid());
        $piece = new Square(7, 2, 'white');

        $moves = $this->jury->findMoves($board, $piece);

        self::assertCount(2, $moves);
        self::assertEquals(new Square(6, 1, null), $moves[0]->target);
        self::assertEquals(new Square(6, 3, null), $moves[1]->target);
    }

    /** @test */
    public function it_should_determine_available_moves_for_a_black_piece() : void
    {
        $board = new Board($this->makeEmptyGrid());
        $piece = new Square(7, 2, 'black');

        $moves = $this->jury->findMoves($board, $piece);

        self::assertCount(2, $moves);
        self::assertEquals(new Square(8, 1, null), $moves[0]->target);
        self::assertEquals(new Square(8, 3, null), $moves[1]->target);
    }

    // TODO validate the unhappy path of available moves
}
