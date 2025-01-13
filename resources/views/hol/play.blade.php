<div class="text-center">
    <p>The number to guess with is: <strong>{{ $number }}</strong></p>
    <p>What is your guess: do you think the random number is <strong>higher</strong> or
        <strong>lower</strong>?
    </p>
    {!! Form::open(['url' => 'higher-or-lower/play/guess']) !!}
    {!! Form::hidden('number', $number) !!}
    {!! Form::hidden('guess', 'higher') !!}
    <div class="form-group">
        {!! Form::submit('Higher!', ['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}

    {!! Form::open(['url' => 'higher-or-lower/play/guess']) !!}
    {!! Form::hidden('number', $number) !!}
    {!! Form::hidden('guess', 'lower') !!}
    <div class="form-group">
        {!! Form::submit('Lower!', ['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}
</div>
