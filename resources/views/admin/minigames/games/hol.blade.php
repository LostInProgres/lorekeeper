<h1>Higher or Lower</h1>
<p>The user will be given a random number. They must guess whether they think it will be <strong>higher</strong> or <strong>lower</strong> than a second, randomly generated number that they cannot see. </p>
<p>The defaults for this game are already set at <strong>2-12</strong> as the known number, with <strong>1-13</strong> as the unknown number.</p>
<p>You can set your own numbers here, but you should follow a similar guideline. (Unknown's min being smaller, with the max being larger.)</p>

<div class="row">
    <div class="col form-group text-center">
        <h5>Known Number</h5>
        <div class="row">
            <div class="col form-group">
                {!! Form::label('Minimum') !!}
                {!! Form::number('known_min', $data['known_min'] ?? 2, ['class' => 'form-control']) !!}
            </div>
            <div class="col form-group">
                {!! Form::label('Maximum') !!}
                {!! Form::number('known_max', $data['known_max'] ?? 12, ['class' => 'form-control']) !!}
            </div>
        </div>
    </div>
    <div class="col form-group text-center">
        <h5>Unknown Number</h5>
        <div class="row">
            <div class="col form-group">
                {!! Form::label('Minimum') !!}
                {!! Form::number('unknown_min', $data['unknown_min'] ?? 1, ['class' => 'form-control']) !!}
            </div>
            <div class="col form-group">
                {!! Form::label('Maximum') !!}
                {!! Form::number('unknown_max', $data['unknown_max'] ?? 13, ['class' => 'form-control']) !!}
            </div>
        </div>
    </div>
</div>
