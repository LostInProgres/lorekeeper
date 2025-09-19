@extends('arcades.layout')

@section('arcades-title')
    {{ $arcade->name }}
@endsection

@section('arcades-content')
    {!! breadcrumbs(['Arcade' => 'arcade', $arcade->name => $arcade->url]) !!}

    <h1>
        {{ $arcade->name }}
        @if (isset($arcade->configInfo['rules']))
            <i class="fas fa-question-circle text-info" data-toggle="collapse" href="#collapseRules" role="button" aria-expanded="false" aria-controls="collapseRules">
            </i>
        @endif
    </h1>
    <p class="mb-0 col-md-4">
        by
        @if (isset($arcade->configInfo['creators']))
            @foreach ($arcade->configInfo['creators'] as $name => $url)
                <a href="{{ $url }}">{{ $name }}</a>{{ !$loop->last ? ',' : '' }}
            @endforeach
        @else
            no credit listed
        @endif
    </p>

    @if (isset($arcade->configInfo['rules']))
        <div class="collapse" id="collapseRules">
            <div class="alert alert-info" role="alert">
                <h4 class="alert-heading">Rules</h4>
                {!! $arcade->configInfo['rules'] !!}
            </div>
        </div>
    @endif
    <hr class="w-75">
    <div class="text-center">
        <p>{!! $arcade->parsed_description !!}</p>
    </div>

    @if ($arcade->checkLimit($user) && $arcade->checkCurrencyCap($user))
        @if (isset($arcade->limit))
            <p class="text-right">
                You can play this game {{ $arcade->limit }} {{ $arcade->limit > 1 ? 'times' : 'time' }}{{ $arcade->limit_period ? ' per ' . strtolower($arcade->limit_period) : '' }}. ( Played {{ $arcade->logCount($user) }} /
                {{ $arcade->limit }} )
            </p>
        @endif
        @if (Settings::get('arcade_global_cap') != 0 || isset($arcade->currency_cap))
            <p class="text-right">
                You can only earn {{ Settings::get('arcade_global_cap') != 0 ? Settings::get('arcade_global_cap') : $arcade->currency_cap }} total currency
                {{ Settings::get('arcade_global_cap') != 0 ? '<strong>across all arcade games</strong>' : 'from this game' }} each day. ( Earned {{ $arcade->dailySum($user) }} /
                {{ Settings::get('arcade_global_cap') != 0 ? Settings::get('arcade_global_cap') : $arcade->currency_cap }} )
            </p>
        @endif

        @if (View::exists('arcades.games.' . $arcade->arcade_type))
            @include('arcades.games.' . $arcade->arcade_type, ['data' => $arcade->data])
        @else
            <div class="alert alert-danger text-center">
                No game view set. File a bug report.
            </div>
        @endif
    @elseif(!$arcade->checkLimit($user))
        <div class="alert alert-danger text-center">
            You have already played this game the maximum number of times{{ $arcade->limit_period ? ' per ' . strtolower($arcade->limit_period) : '' }}.
        </div>
    @elseif(!$arcade->checkCurrencyCap($user))
        <div class="alert alert-danger text-center">
            You have already reached the daily currency cap.
        </div>
    @endif



@endsection

@section('scripts')
    @parent
    <script>
        document.addEventListener('contextmenu', (e) => {
            e.preventDefault();
        });
        document.onkeydown = function(e) {
            if (event.keyCode == 123) {
                return false;
            }
            if (e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) {
                return false;
            }
            if (e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) {
                return false;
            }
            if (e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) {
                return false;
            }
            if (e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) {
                return false;
            }
        }
    </script>
@endsection
