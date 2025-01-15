@extends('home.layout')

@section('title')
    Wordsearch
@endsection

@section('content')
    {!! breadcrumbs(['Wordsearch' => 'wordsearch']) !!}

    <div class="puzzleWrap text-center">
        <div class="text-center mb-2" id="puzzle"></div>
        <div id="words">
        </div>
        <div class="btn btn-primary" id="solve">Solve Puzzle</button>
        </div>
    @endsection
    @section('scripts')
        @include('word_search._word_search_js')
        @parent
    @endsection
