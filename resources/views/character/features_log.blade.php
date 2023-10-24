@extends('character.layout', ['isMyo' => $character->is_myo_slot])

@section('profile-title')
    {{ $character->fullName }}'s Trait Logs
@endsection

@section('meta-img')
    {{ $character->image->thumbnailUrl }}
@endsection

@section('profile-content')
    {!! breadcrumbs([
        $character->category->masterlist_sub_id
            ? $character->category->sublist->name . ' Masterlist'
            : 'Character masterlist' => $character->category->masterlist_sub_id
            ? 'sublist/' . $character->category->sublist->key
            : 'masterlist',
        $character->fullName => $character->url,
        'Unlocked Traits' => $character->url . '/features',
        'Trait Logs' => $character->url . '/trait-logs',
    ]) !!}

    @include('character._header', ['character' => $character])

    <h3>Trait Logs</h3>

    {!! $logs->render() !!}

    <div class="row ml-md-2">
        <div class="d-flex row flex-wrap col-12 mt-1 pt-1 px-0 ubt-bottom">
            <div class="col-6 col-md-2 font-weight-bold">Sender</div>
            <div class="col-6 col-md-2 font-weight-bold">Recipient</div>
            <div class="col-6 col-md-2 font-weight-bold">Trait</div>
            <div class="col-6 col-md-4 font-weight-bold">Log</div>
            <div class="col-6 col-md-2 font-weight-bold">Date</div>
        </div>
        @foreach ($logs as $log)
            <div class="d-flex row flex-wrap col-12 mt-1 pt-1 px-0 ubt-top">
                <div class="col-6 col-md-2">
                    <i
                        class="btn py-1 m-0 px-2 btn-{{ $log->recipient_id == $character->id && $log->recipient_type == $character->logType ? 'success' : 'danger' }} fas {{ $log->recipient_id == $character->id && $log->recipient_type == $character->logType ? 'fa-arrow-up' : 'fa-arrow-down' }} mr-2"></i>
                    {!! $log->sender ? $log->sender->displayName : '' !!}
                </div>
                <div class="col-6 col-md-2">{!! $log->recipient ? $log->recipient->displayName : '' !!}</div>
                <div class="col-6 col-md-2">{!! $log->feature->displayName !!}</div>
                <div class="col-6 col-md-4">{!! $log->log !!}</div>
                <div class="col-6 col-md-2">{!! pretty_date($log->created_at) !!}</div>
            </div>
        @endforeach
    </div>
    {!! $logs->render() !!}
@endsection
