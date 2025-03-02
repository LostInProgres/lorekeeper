@extends('admin.layout')

@section('admin-title')
    Minigame
@endsection

@section('admin-content')
    {!! breadcrumbs(['Admin Panel' => 'admin', 'Minigames' => 'admin/data/minigames', ($minigame->id ? 'Edit' : 'Create') . ' Minigame' => $minigame->id ? 'admin/data/minigames/edit/' . $minigame->id : 'admin/data/minigames/create']) !!}

    <h1>{{ $minigame->id ? 'Edit' : 'Create' }} Minigame
        @if ($minigame->id)
            ({!! $minigame->displayName !!})
            <a href="#" class="btn btn-danger float-right delete-minigame-button">Delete Minigame</a>
        @endif
    </h1>

    {!! Form::open(['url' => $minigame->id ? 'admin/data/minigames/edit/' . $minigame->id : 'admin/data/minigames/create', 'files' => true]) !!}

    <h3>Basic Information</h3>

    <div class="form-group">
        {!! Form::label('Name') !!}
        {!! Form::text('name', $minigame->name, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('Minigame Image (Optional)') !!} {!! add_help('This image is used on the minigame index as an icon.') !!}
        <div>{!! Form::file('image') !!}</div>
        <div class="text-muted">Recommended size: None (Choose a standard size for all minigame images)</div>
        @if ($minigame->has_image)
            <div class="form-check">
                {!! Form::checkbox('remove_image', 1, false, ['class' => 'form-check-input']) !!}
                {!! Form::label('remove_image', 'Remove current image', ['class' => 'form-check-label']) !!}
            </div>
        @endif
    </div>

    <div class="form-group">
        {!! Form::label('Description (Optional)') !!}
        {!! Form::textarea('description', $minigame->description, ['class' => 'form-control wysiwyg']) !!}
    </div>

    <div class="form-group">
        {!! Form::checkbox('is_visible', 1, $minigame->id ? $minigame->is_visible : 1, ['class' => 'form-check-input', 'data-toggle' => 'toggle']) !!}
        {!! Form::label('is_visible', 'Set Active', ['class' => 'form-check-label ml-3']) !!} {!! add_help('If turned off, the minigame will not be visible to regular users.') !!}
    </div>

    <h3>Play Limits (Optional)</h3>
    <p>You can limit the amount of times a user can play this minigame.</p>
    <p>Set a number into number of plays. This will be applied for all time if you leave period blank, or per time period (ex: once a month, twice a week) if selected.</p>
    <div class="row">
        <div class="col-md-4 form-group">
            {!! Form::label('limit', 'Number of Plays (Optional)') !!} {!! add_help('Enter a number to limit how many times a user can play this minigame. Leave blank to allow endless plays.') !!}
            {!! Form::text('limit', $minigame->limit, ['class' => 'form-control']) !!}
        </div>
        <div class="col-md-4 form-group">
            {!! Form::label('limit_period', 'Limit Period') !!} {!! add_help('The time period that the limit is set for.') !!}
            {!! Form::select('limit_period', $limit_periods, $minigame->limit_period, ['class' => 'form-control', 'data-name' => 'limit_period']) !!}
        </div>
    </div>

    <h5>Entry Fee (Optional)</h5>
    <p>A user will pay this fee every time they play the minigame, regardless of if they win or lose.</p>
    <div class="row">
        <div class="col-md-4 form-group">
            {!! Form::label('Currency') !!}
            {!! Form::select('currency_id', $currencies, $minigame->currency_id, ['class' => 'form-control currency-selectize', 'placeholder' => 'Select Currency']) !!}
        </div>
        <div class="col-md-4 form-group">
            {!! Form::label('Fee') !!}
            {!! Form::number('fee', $minigame->fee, ['class' => 'form-control']) !!}
        </div>
    </div>

    <h5>Custom Text (Optional)</h5>
    <p>You can change the default messages for the minigame here, further messages may be editable from the specific minigame's settings.</p>
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
            {!! Form::label('Log Name') !!}{!! add_help('When rewarding or debiting from users, the minigame will be referred to as this instead of its respective game type.') !!}
            {!! Form::text('log_name', $flavor['log_name'] ?? null, ['class' => 'form-control']) !!}
        </div>
    </div>

    <h4 class="mt-5">Rewards</h4>
    <p>Users will receive these rewards upon successful completion of the minigame.</p>
    <p>For some minigames, this may or may not be optional.</p>

    @include('widgets._loot_select', ['loots' => $minigame->rewards, 'showLootTables' => true, 'showRaffles' => true])

    <h3>Minigame Type</h3>
    <p>Minigame types are the different types of games, which all have their own settings. You can edit the specific game's settings after you've chosen the type of minigame.
    </p>

    <div class="form-group">
        {!! Form::select('minigame_type', [null => 'Select a Type'] + $types, $minigame->minigame_type ?? null, ['class' => 'form-control']) !!}
    </div>

    <div class="text-right">
        {!! Form::submit($minigame->id ? 'Edit' : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>

    {!! Form::close() !!}

    @include('widgets._loot_select_row', ['showLootTables' => true, 'showRaffles' => true])

    @if ($minigame->minigame_type)
        {!! Form::open(['url' => 'admin/data/minigames/games/' . $minigame->id]) !!}
        @if (View::exists('admin.minigames.games.' . $minigame->minigame_type))
            @include('admin.minigames.games.' . $minigame->minigame_type, ['data' => $minigame->data])
        @endif

        <div class="text-right">
            {!! Form::submit('Edit', ['class' => 'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
        @if (View::exists('admin.minigames.games.' . $minigame->minigame_type . '_post'))
            @include('admin.minigames.games.' . $minigame->minigame_type . '_post', ['data' => $minigame->data])
        @endif

        @if (View::exists('admin.minigames.games.' . $minigame->minigame_type . '_images'))
            <h3>Images</h3>
            <p>These additional images are optional, and the types and numbers of these will vary. They can help you further customize the look of the game.
            </p>

            {!! Form::open(['url' => 'admin/data/minigames/images/' . $minigame->id, 'files' => true]) !!}
            @include('admin.minigames.games.' . $minigame->minigame_type . '_images', ['data' => $minigame->data])
            <div class="text-right">
                {!! Form::submit('Edit Images', ['class' => 'btn btn-primary']) !!}
            </div>
            {!! Form::close() !!}
        @endif
    @endif

@endsection

@section('scripts')
    @parent
    @if (View::exists('admin.minigames.games.' . $minigame->minigame_type . '_js'))
        @include('admin.minigames.games.' . $minigame->minigame_type . '_js', ['data' => $minigame->data])
    @endif
    @include('js._loot_js', ['showLootTables' => true, 'showRaffles' => true])
    <script>
        $(document).ready(function() {
            $('.currency-selectize').selectize();
            $('.delete-minigame-button').on('click', function(e) {
                e.preventDefault();
                loadModal("{{ url('admin/data/minigames/delete') }}/{{ $minigame->id }}", 'Delete Minigame');
            });
        });
    </script>
@endsection
