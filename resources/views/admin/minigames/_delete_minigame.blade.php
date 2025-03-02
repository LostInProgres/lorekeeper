@if($minigame)
    {!! Form::open(['url' => 'admin/data/minigames/delete/'.$minigame->id]) !!}

    <p>You are about to delete the minigame <strong>{{ $minigame->name }}</strong>. This is not reversible. If you would like to hide the minigame from users, you can set it as inactive from the minigame settings page.</p>
    <p>Are you sure you want to delete <strong>{{ $minigame->name }}</strong>?</p>

    <div class="text-right">
        {!! Form::submit('Delete Minigame', ['class' => 'btn btn-danger']) !!}
    </div>

    {!! Form::close() !!}
@else
    Invalid minigame selected.
@endif
