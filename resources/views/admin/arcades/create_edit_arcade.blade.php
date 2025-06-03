@extends('admin.layout')

@section('admin-title')
    Arcade
@endsection

@section('admin-content')
    {!! breadcrumbs(['Admin Panel' => 'admin', 'Arcade' => 'admin/data/arcade', ($arcade->id ? 'Edit' : 'Create') . ' Game' => $arcade->id ? 'admin/data/arcade/edit/' . $arcade->id : 'admin/data/arcade/create']) !!}

    <h1>{{ $arcade->id ? 'Edit' : 'Create' }} Game
        @if ($arcade->id)
            ({!! $arcade->displayName !!})
            <a href="#" class="btn btn-danger float-right delete-arcade-button">Delete Game</a>
        @endif
    </h1>

    {!! Form::open(['url' => $arcade->id ? 'admin/data/arcade/edit/' . $arcade->id : 'admin/data/arcade/create', 'files' => true]) !!}

    <h3>Basic Information</h3>

    <div class="form-group">
        {!! Form::label('Name') !!}
        {!! Form::text('name', $arcade->name, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('Game Image (Optional)') !!} {!! add_help('This image is used on the arcade index as an icon.') !!}
        <div>{!! Form::file('image') !!}</div>
        <div class="text-muted">Recommended size: None (Choose a standard size for all game images)</div>
        @if ($arcade->has_image)
            <div class="form-check">
                {!! Form::checkbox('remove_image', 1, false, ['class' => 'form-check-input']) !!}
                {!! Form::label('remove_image', 'Remove current image', ['class' => 'form-check-label']) !!}
            </div>
        @endif
    </div>

    <div class="form-group">
        {!! Form::label('Description (Optional)') !!}
        {!! Form::textarea('description', $arcade->description, ['class' => 'form-control wysiwyg']) !!}
    </div>

    <h3>Play Limits (Optional)</h3>
    <p>You can limit the amount of times a user can play this game.</p>
    <p>Set a number into number of plays. This will be applied for all time if you leave period blank, or per time period (ex: once a month, twice a week) if selected.</p>
    <div class="row">
        <div class="col-md-4 form-group">
            {!! Form::label('limit', 'Number of Plays (Optional)') !!} {!! add_help('Enter a number to limit how many times a user can play this game. Leave blank to allow endless plays.') !!}
            {!! Form::text('limit', $arcade->limit, ['class' => 'form-control']) !!}
        </div>
        <div class="col-md-4 form-group">
            {!! Form::label('limit_period', 'Limit Period') !!} {!! add_help('The time period that the limit is set for.') !!}
            {!! Form::select('limit_period', $limit_periods, $arcade->limit_period, ['class' => 'form-control', 'data-name' => 'limit_period']) !!}
        </div>
    </div>

    <h5>Entry Fee (Optional)</h5>
    <p>A user will pay this fee every time they play the game, regardless of if they win or lose.</p>
    <div class="row">
        <div class="col-md-4 form-group">
            {!! Form::label('Currency') !!}
            {!! Form::select('currency_id', $currencies, $arcade->currency_id, ['class' => 'form-control currency-selectize', 'placeholder' => 'Select Currency']) !!}
        </div>
        <div class="col-md-4 form-group">
            {!! Form::label('Fee') !!}
            {!! Form::number('fee', $arcade->fee, ['class' => 'form-control']) !!}
        </div>
    </div>

    <h5>Custom Text (Optional)</h5>
    <p>You can change the default messages for the game here, further messages may be editable from the specific game's settings.</p>
    <p>This is still a bit of a WIP!!!!</p>
    <h5>Win/Loss Messages</h5>
    <div class="row">
        <div class="col-md-4 form-group">
            {!! Form::label('Win Message') !!}
            {!! Form::text('win_message', $flavor['win_message'] ?? null, ['class' => 'form-control']) !!}
        </div>
        <div class="col-md-4 form-group">
            {!! Form::label('Lose Message') !!}
            {!! Form::text('lose_message', $flavor['lose_message'] ?? null, ['class' => 'form-control']) !!}
        </div>
        <div class="col-md-4 form-group">
            {!! Form::label('Neutral Message') !!}
            {!! Form::text('neutral_message', $flavor['neutral_message'] ?? null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <h5>Log Info</h5>
    <div class="row">
        <div class="col-md-4 form-group">
            {!! Form::label('Log Name') !!}{!! add_help('When rewarding or debiting from users, the arcade will be referred to as this instead of its respective game type.') !!}
            {!! Form::text('log_name', $flavor['log_name'] ?? null, ['class' => 'form-control']) !!}
        </div>
    </div>

    <h4 class="mt-5">Rewards</h4>
    <p>Users will receive these rewards upon successful completion of the game.</p>
    <p>For some games, this may or may not be optional.</p>

    @include('widgets._loot_select', ['loots' => $arcade->rewards, 'showLootTables' => true, 'showRaffles' => true])

    <h3>Game Type</h3>
    <p>Game types are the different types of games, which all have their own settings. You can edit the specific game's settings after you've chosen the type of game.
    </p>
    <p>After you select a game type and add info, you can set it to active or inactive.</p>

    <div class="form-group">
        {!! Form::select('arcade_type', [null => 'Select a Type'] + $types, $arcade->arcade_type ?? null, ['class' => 'form-control']) !!}
    </div>

    <div class="text-right">
        {!! Form::submit($arcade->id ? 'Edit' : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>

    {!! Form::close() !!}

    @include('widgets._loot_select_row', ['showLootTables' => true, 'showRaffles' => true])

    @if ($arcade->arcade_type)
        {!! Form::open(['url' => 'admin/data/arcade/games/' . $arcade->id]) !!}

        <div class="form-group">
            {!! Form::checkbox('is_visible', 1, $arcade->id ? $arcade->is_visible : 1, ['class' => 'form-check-input', 'data-toggle' => 'toggle']) !!}
            {!! Form::label('is_visible', 'Set Active', ['class' => 'form-check-label ml-3']) !!} {!! add_help('If turned off, the game will not be visible to regular users.') !!}
        </div>

        @if (View::exists('admin.arcades.games.' . $arcade->arcade_type))
            @include('admin.arcades.games.' . $arcade->arcade_type, ['data' => $arcade->data])
        @endif

        <div class="text-right">
            {!! Form::submit('Edit Game Settings', ['class' => 'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
        @if (View::exists('admin.arcades.games.' . $arcade->arcade_type . '_post'))
            @include('admin.arcades.games.' . $arcade->arcade_type . '_post', ['data' => $arcade->data])
        @endif

        @if (View::exists('admin.arcades.games.' . $arcade->arcade_type . '_images'))
            <h3>Images</h3>
            <p>These additional images are optional, and the types and numbers of these will vary. They can help you further customize the look of the game.
            </p>

            {!! Form::open(['url' => 'admin/data/arcade/images/' . $arcade->id, 'files' => true]) !!}
            @include('admin.arcades.games.' . $arcade->arcade_type . '_images', ['data' => $arcade->data])
            <div class="text-right">
                {!! Form::submit('Edit Images', ['class' => 'btn btn-primary']) !!}
            </div>
            {!! Form::close() !!}
        @endif
    @endif

@endsection

@section('scripts')
    @parent
    @if (View::exists('admin.arcades.games.' . $arcade->arcade_type . '_js'))
        @include('admin.arcades.games.' . $arcade->arcade_type . '_js', ['data' => $arcade->data])
    @endif
    @include('js._loot_js', ['showLootTables' => true, 'showRaffles' => true])
    <script>
        $(document).ready(function() {
            $('.currency-selectize').selectize();
            $('.delete-arcade-button').on('click', function(e) {
                e.preventDefault();
                loadModal("{{ url('admin/data/arcade/delete') }}/{{ $arcade->id }}", 'Delete Game');
            });
        });
    </script>
@endsection
