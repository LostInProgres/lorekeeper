@extends('layouts.app')

@section('title')
    Minigames ::
    @yield('minigames-title')
@endsection

@section('content')
    @yield('minigames-content')
@endsection

@section('scripts')
@parent
@endsection
