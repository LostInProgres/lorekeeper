@extends('home.layout')

@section('title')
    GAME NAME
@endsection

@section('content')
    {!! breadcrumbs(['gamename' => 'gamename']) !!}

    @endsection
    @section('scripts')
        @include('gamename._game_js')
        @parent
    @endsection