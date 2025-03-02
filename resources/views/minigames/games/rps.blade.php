<p>You are challenged by a mighty foe... to rock, paper, scissors! What will you choose!?</p>
@if ($use_7)
<p>RPS-7 is enabled...</p>
@endif

{!! Form::open(['url' => 'minigames/' . $minigame->id . '/play']) !!}
<div class="col-md-4">
    <div class="input-group mb-3">
        {!! Form::select('option', $options, null, ['class' => 'form-control', 'placeholder' => 'Select Option']) !!}
        <div class="input-group-append">
            {!! Form::submit('Fight!', ['class' => 'btn btn-primary']) !!}
        </div>
    </div>
</div>
{!! Form::close() !!}

