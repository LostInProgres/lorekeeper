@extends('home.layout')

@section('title')
    GAME NAME
@endsection

@section('content')
    {!! breadcrumbs(['gamename' => 'gamename']) !!}

    <h1 id="sudoku_title">SUDOKU</h1>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div id="sudoku_container"></div>
        </div>
    </div>

    {!! Form::open(['url' => 'gamename/submit']) !!}
        <div class="form-group">
            {!! Form::hidden('count', 0, ['class' => 'count']) !!}
            {!! Form::submit('submit', ['class' => 'btn btn-primary', 'id' => 'solve']) !!}
        </div>
    {!! Form::close() !!}

    @include('gamename.style')

    @endsection
    @section('scripts')
        @include('gamename._game_js')
        @parent
    @endsection