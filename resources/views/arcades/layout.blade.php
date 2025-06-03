@extends('layouts.app')

@section('title')
    Arcade ::
    @yield('arcades-title')
@endsection

@section('content')
    @yield('arcades-content')
@endsection

@section('scripts')
@parent
@endsection
