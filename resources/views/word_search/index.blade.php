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
        {!! Form::open(['url' => 'word-search/submit']) !!}
            <div class="form-group">
                {!! Form::submit('submit', ['class' => 'btn btn-primary', 'id' => 'solve']) !!}
            </div>
        	{!! Form::close() !!}
        </div>
    @endsection
    @section('scripts')
        @include('word_search._word_search_js')
        @parent
    @endsection
