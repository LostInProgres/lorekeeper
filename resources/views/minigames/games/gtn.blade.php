<div class="text-center">
    <p>You may guess a number <strong>{{ $min }}</strong> - <strong>{{ $max }}</strong></p>
    {!! Form::open(['url' => 'minigames/' . $minigame->id . '/play']) !!}
        <div class="col-md-4">
            <div class="input-group mb-3">
                {!! Form::number('guess', null, ['class' => 'form-control', 'min' => $min, 'max' => $max]) !!}
                <div class="input-group-append">
                    {!! Form::submit('Guess!', ['class' => 'btn btn-primary']) !!}
                </div>
            </div>
        </div>
    {!! Form::close() !!}
</div>
