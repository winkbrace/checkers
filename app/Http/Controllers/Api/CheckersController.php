<?php declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Checkers\AI;
use Checkers\Board;
use Checkers\Jury;
use Checkers\Move;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class CheckersController extends Controller
{
    private Jury $jury;
    private AI $ai;

    public function __construct(Jury $jury, AI $ai)
    {
        $this->jury = $jury;
        $this->ai = $ai;
    }

    /**
     * Process player move and return AI move
     */
    public function move(Request $request)
    {
        $input = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        $board = new Board($input['grid']);
        $move = Move::fromInput($input);

        try {
            $this->jury->judge($board, $move);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Invalid move: ' . $e->getMessage()], 400);
        }

        $board->apply($move);

        return $this->ai->calculateMove($board);
    }
}
