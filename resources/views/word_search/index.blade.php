@extends('home.layout')

@section('title')
    Wordsearch
@endsection

@section('content')
    {!! breadcrumbs(['Wordsearch' => 'wordsearch']) !!}

    <!-- TODO wrap the puzzle into something that scrolls so that it can be accessed regardless of screen size -->
    <div class="puzzleWrap text-center">
        <div class="text-center mb-2" id="puzzle"></div>
        <div id="words">
        </div>
        {!! Form::open(['url' => 'word-search/submit']) !!}
            <div class="form-group">
                {!! Form::hidden('count', 0, ['class' => 'count']) !!}
                {!! Form::submit('submit', ['class' => 'btn btn-primary', 'id' => 'solve']) !!}
            </div>
        	{!! Form::close() !!}
        </div>
    <!-- TODO Add game stamina somewhere on this page-->
     <div>
     <p>The objective of this puzzle is to find and mark all the words hidden inside the box. 
     The words may be placed horizontally, vertically, or diagonally, and can be backwards too.</p>
     <p>You get {!! $currency->display($prize) !!} per word found.
        @if ($wordMinimum > 0)
            You must find at least {!! $wordMinimum !!} to receive rewards.
        @endif
     </p>
     </div>
    @endsection
    @section('scripts')
        @include('word_search._word_search_js')
        @parent
    @endsection
