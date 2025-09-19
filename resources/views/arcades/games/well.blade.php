<div class="text-center">
    <p>Would you like to make a wish?</p>
    {!! Form::open(['url' => 'arcade/' . $arcade->id . '/play']) !!}
    @if ($require_message)
        <p>{{ $use_characters ? 'Your character' : 'You' }} must make a wish-- you can describe it however you like, from how {{ $use_characters ? 'your character wishes' : 'you wish' }}, what it's for, or similar. Other players will be able to see this!!!
        </p>
        <div class="form-group">
            {!! Form::textarea('wish', null, ['class' => 'form-control wysiwyg']) !!}
        </div>
    @endif

    @if ($use_characters)
        <div class="col-md-4">
            <div class="input-group mb-3">
                {!! Form::select('wish_character', [null => 'Select a Character'] + Auth::user()->characters()->myo(0)->get()->pluck('fullName', 'id')->toArray(), null, ['class' => 'form-control selectize']) !!}
                <div class="input-group-append">
                    {!! Form::submit('Wish!', ['class' => 'btn btn-primary']) !!}
                </div>
            </div>
        </div>
    @else
        {!! Form::submit('Wish!', ['class' => 'btn btn-primary']) !!}
    @endif

    {!! Form::close() !!}

    <div class="container mt-4">
        <div class="row align-items-center text-center mb-3">
            <div class="col-12">
                <h3>{{ $require_message ? '' : 'Your ' }}Recent Wishes...</h3>
            </div>
        </div>
        <div class="row align-items-center text-center">
            <div class="col-2">
                <h5>Date</h5>
            </div>
            @if ($require_message)
                <div class="col-2">
                    <h5>{{ $use_characters ? 'Character' : 'User' }}</h5>
                </div>
            @endif
            <div class="col-8">
                <h5>Action<h5>
            </div>
        </div>
        @if (!$wishes->count())
            <div class="text-center">
                No one has made any wishes yet...
            </div>
        @else
            @foreach ($wishes as $wish)
                <div class="row align-items-center text-center mb-3">
                    <div class="col-2">
                        {!! format_date($wish->created_at) !!}
                    </div>
                    @if ($require_message)
                        <div class="col-2">
                            @if ($use_characters)
                                {!! $wish->character ? $wish->character->displayName : 'Deleted Character' !!}
                            @else
                                {!! $wish->user ? $wish->user->displayName : 'Deleted User' !!}
                            @endif
                        </div>
                    @endif
                    <div class="col-8">
                        {!! isset($wish->data['wish']) ? $wish->data['wish'] : 'No data found.' !!}
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
