<h1>Guess The Number</h1>
<p>A very simple game wherein a random number will be generated, and the user can guess a number and see if it matches. </p>

<div class="row">
    <div class="col form-group text-center">
        <h5>Random Number</h5>
        <div class="row">
            <div class="col form-group">
                {!! Form::label('Minimum') !!}
                {!! Form::number('min', $data['min'] ?? 1, ['class' => 'form-control']) !!}
            </div>
            <div class="col form-group">
                {!! Form::label('Maximum') !!}
                {!! Form::number('max', $data['max'] ?? 10, ['class' => 'form-control']) !!}
            </div>
        </div>
    </div>
</div>
