@extends('minigames.layout')

@section('minigames-title')
    {{ $minigame->name }}
@endsection

@section('minigames-content')
    {!! breadcrumbs(['Minigames' => 'minigames', $minigame->name => $minigame->url]) !!}

    <h1>
        {{ $minigame->name }}
    </h1>
    <p class="mb-0 col-md-4">
        by
        @if ($minigame->configInfo['creators'])
            @foreach ($minigame->configInfo['creators'] as $name => $url)
                <a href="{{ $url }}">{{ $name }}</a>{{ !$loop->last ? ',' : '' }}
            @endforeach
        @else
            no credit listed
        @endif
    </p>

    <div class="text-center">
        <p>{!! $minigame->parsed_description !!}</p>
    </div>

    @if ($user && $minigame->checkLimit($user))
        @if (isset($minigame->limit))
            <p class="text-right">
                You can play this minigame {{ $minigame->limit }} {{ $minigame->limit > 1 ? 'times' : 'time' }}{{ $minigame->limit_period ? ' per ' . strtolower($minigame->limit_period) : '' }}. ( Played {{ $minigame->logCount($user) }} /
                {{ $minigame->limit }} )
            </p>
        @endif

        @if (View::exists('minigames.games.' . $minigame->minigame_type))
            @include('minigames.games.' . $minigame->minigame_type, ['data' => $minigame->data])
        @else
            <div class="alert alert-danger text-center">
                No game view set. File a bug report.
            </div>
        @endif
    @else
        <div class="alert alert-danger text-center">
            You have already played this minigame the maximum number of times{{ $minigame->limit_period ? ' per ' . strtolower($minigame->limit_period) : '' }}.
        </div>
    @endif



@endsection

@section('scripts')
    @parent
@endsection
