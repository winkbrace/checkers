<?php declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

final class CheckersController extends Controller
{
    /**
     * Process player move and return AI move
     */
    public function move(Request $request)
    {
        dd(request()->input());
        // TODO validate received move


        $board = [];

        return ['start' => [], 'target' => []];
    }
}
