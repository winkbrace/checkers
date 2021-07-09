@extends('layouts.app')

@section('content')
    <div id="dirty-image-preloader" style="display:none;">
        <img src="/img/white.png">
        <img src="/img/black.png">
    </div>

    <div class="relative mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
        <div class="canvas-container">
            <canvas id="board" width="800" height="800"></canvas>
            <canvas id="pieces" width="800" height="800"></canvas>
            <canvas id="dragging" width="800" height="800"></canvas>
        </div>
    </div>

    <div class="flex justify-center mt-4 sm:items-center sm:justify-between">
        <div class="text-center text-sm text-gray-500 sm:text-left">
            <input id="boardColor" type="color">
            Choose square color
        </div>
    </div>

    @include('layouts.footer')
@endsection
