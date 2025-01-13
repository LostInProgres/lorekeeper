@extends('home.layout')

@section('title')
    Higher or Lower
@endsection

@section('content')
    {!! breadcrumbs(['Higher or Lower' => 'higher-or-lower']) !!}
    <p class="text-right"> You have <strong>{{ $user->settings->hol_plays }}</strong> games left to play today. </p>
    <div class="text-center game">

        <h1>Higher or Lower</h1>
        <p>Higher or lower is a simple game. You will be given a number 2-12. </p>
        <p>It's your job to guess whether you think
            it will be <strong>higher</strong> or <strong>lower</strong> than a second, randomly generated number between
            1-13 that you cannot see. </p>
        <p>Win, and get a currency
            prize. Sound fun?</p>
        @if ($user->settings->hol_plays != 0)
            <a href="#" class="btn btn-primary play-hol"><i class="fas fa-gamepad"></i> Play!</a>
            <hr>
        @else
            <div class="alert alert-danger text-center">
                You're out of plays for today. Check back tomorrow.
            </div>
        @endif
    </div>
    <script>
        $(document).ready(function() {
            $('.play-hol').on('click', function(e) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('higher-or-lower/play') }}",
                }).done(function(res) {
                    $(".game").fadeOut(500, function() {
                        $(".game").html(res);
                        $(".game").fadeIn(500);
                    });
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    alert("AJAX call failed: " + textStatus + ", " + errorThrown);
                });
            });
        });
    </script>
@endsection
