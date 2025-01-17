@extends('home.layout')

@section('title')
    GAME NAME
@endsection

@section('content')
    {!! breadcrumbs(['gamename' => 'gamename']) !!}

    <h1 id="sudoku_title">SUDOKU</h1>

    <div id="sudoku_container"></div>

    <a class="restart" href="#restart">New Game</a>

    @include('gamename.style')

    @endsection
    @section('scripts')
        @include('gamename._game_js')
        @parent
    @endsection