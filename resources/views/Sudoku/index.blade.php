@extends('home.layout')

@section('title')
    Sudoku
@endsection

@section('content')
    {!! breadcrumbs(['Sudoku' => 'Sudoku']) !!}

    <h1 id="sudoku_title">SUDOKU</h1>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div id="sudoku_container"></div>
        </div>
    </div>

    <div class="text-center">
    {!! Form::open(['url' => 'Sudoku/submit']) !!}
        <div class="form-group">
            {!! Form::hidden('count', 0, ['class' => 'count']) !!}
            {!! Form::submit('submit', ['class' => 'btn btn-primary', 'id' => 'solve']) !!}
        </div>
    {!! Form::close() !!}
    </div>

    <!-- TODO: GAME DESCRIPTION, including PRIZE MONEY and PLAY STAMINA. -->

    @include('Sudoku.style')

    @endsection
    @section('scripts')
        @include('Sudoku._game_js')
        @parent
    @endsection