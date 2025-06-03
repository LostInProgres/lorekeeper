{!! Form::open(['url' => 'arcade/' . $arcade->id . '/play']) !!}

<div class="text-center">
    {!! Form::submit('Pull!', ['class' => 'btn btn-primary']) !!}
</div>

{!! Form::close() !!}
