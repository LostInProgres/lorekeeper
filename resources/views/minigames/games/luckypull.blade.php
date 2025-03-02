{!! Form::open(['url' => 'minigames/' . $minigame->id . '/play']) !!}

<div class="text-center">
    {!! Form::submit('Pull!', ['class' => 'btn btn-primary']) !!}
</div>

{!! Form::close() !!}
