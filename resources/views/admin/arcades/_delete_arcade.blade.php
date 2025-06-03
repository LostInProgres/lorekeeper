@if($arcade)
    {!! Form::open(['url' => 'admin/data/arcade/delete/'.$arcade->id]) !!}

    <p>You are about to delete the game <strong>{{ $arcade->name }}</strong>. This is not reversible. If you would like to hide the game from users, you can set it as inactive from the game settings page.</p>
    <p>Are you sure you want to delete <strong>{{ $arcade->name }}</strong>?</p>

    <div class="text-right">
        {!! Form::submit('Delete Game', ['class' => 'btn btn-danger']) !!}
    </div>

    {!! Form::close() !!}
@else
    Invalid game selected.
@endif
