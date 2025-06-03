<h1>Wishing Well</h1>
<p>Users (or characters) may place a wish at the well, others may see their wishes.</p>

<div class="row">
    <div class="col form-group">
        {!! Form::checkbox('use_characters', 1, $data['use_characters'] ?? 0, ['class' => 'form-check-label', 'data-toggle' => 'toggle']) !!}
        {!! Form::label('use_characters', 'Use Characters?', ['class' => 'form-check-label ml-3']) !!}{!! add_help('Users can select a character to wish at the well.') !!}
    </div>
    <div class="col form-group">
        {!! Form::checkbox('require_message', 1, $data['require_message'] ?? 0, ['class' => 'form-check-label', 'data-toggle' => 'toggle']) !!}
        {!! Form::label('require_message', 'Require Message?', ['class' => 'form-check-label ml-3']) !!}{!! add_help('The user will be required to include a textual "RP" message of their character and their wish.') !!}
    </div>
</div>
