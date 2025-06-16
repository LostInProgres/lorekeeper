<h1>Blockfall</h1>
<p>A simple game of tetris. Users earn rewards based on points earned.</p>

<h3>Fallomino colours</h3>
<p>there are optional settings for customization.</p>
<div class="row">
    <div class="col-6">
        <h4>Straight fallomino - Steward</h4>
        <div class="form-group">
            <div class="input-group cp">
                {!! Form::text('steward_colour', $data['steward_colour'] ?? "#00F0F0", ['class' => 'form-control']) !!}
                <span class="input-group-append">
                    <span class="input-group-text colorpicker-input-addon"><i></i></span>
                </span>
            </div>
        </div>
    </div>

    <div class="col-6">
        <h4>Square fallomino - Arnold</h4>
        <div class="form-group">
            <div class="input-group cp">
                {!! Form::text('arnold_colour', $data['arnold_colour'] ?? "#F0F000", ['class' => 'form-control']) !!}
                <span class="input-group-append">
                    <span class="input-group-text colorpicker-input-addon"><i></i></span>
                </span>
            </div>
        </div>
    </div>

    <div class="col-6">
        <h4>T-shape fallomino - Freddy </h4>
        <div class="form-group">
            <div class="input-group cp">
                {!! Form::text('freddy_colour', $data['freddy_colour'] ?? "#A000F0", ['class' => 'form-control']) !!}
                <span class="input-group-append">
                    <span class="input-group-text colorpicker-input-addon"><i></i></span>
                </span>
            </div>
        </div>
    </div>

    <div class="col-6">
        <h4>L-shape fallomino - Gerald</h4>
        <div class="form-group">
            <div class="input-group cp">
                {!! Form::text('gerald_colour', $data['gerald_colour'] ?? "#0000F0", ['class' => 'form-control']) !!}
                <span class="input-group-append">
                    <span class="input-group-text colorpicker-input-addon"><i></i></span>
                </span>
            </div>
        </div>
    </div>

    <div class="col-6">
        <h4>Reverse L-shape fallomino - Evil Gerald</h4>
        <div class="form-group">
            <div class="input-group cp">
                {!! Form::text('evil_gerald_colour', $data['evil_gerald_colour'] ?? "#F0A000", ['class' => 'form-control']) !!}
                <span class="input-group-append">
                    <span class="input-group-text colorpicker-input-addon"><i></i></span>
                </span>
            </div>
        </div>
    </div>

    <div class="col-6">
        <h4>Squiggle fallomino - Vanessa</h4>
        <div class="form-group">
            <div class="input-group cp">
                {!! Form::text('vanessa_colour', $data['vanessa_colour'] ?? "#00F000", ['class' => 'form-control']) !!}
                <span class="input-group-append">
                    <span class="input-group-text colorpicker-input-addon"><i></i></span>
                </span>
            </div>
        </div>
    </div>

    <div class="col-6">
        <h4>Reverse squiggle fallomino - Amber</h4>
        <div class="form-group">
            <div class="input-group cp">
                {!! Form::text('amber_colour', $data['amber_colour'] ?? "#F00000", ['class' => 'form-control']) !!}
                <span class="input-group-append">
                    <span class="input-group-text colorpicker-input-addon"><i></i></span>
                </span>
            </div>
        </div>
    </div>
</div>

<h3>Fallomino outlines</h3>
<div class="row">
    <div class="col form-group">
        {!! Form::label('Board outline width') !!}
        {!! Form::number('board_outline_width', $data['outline_width'] ?? 1, ['class' => 'form-control']) !!}
    </div>
    <div class="col form-group">
        {!! Form::label('Board outline colour') !!}
        <div class="input-group cp">
            {!! Form::text('board_outline_colour', $data['outline_colour'] ?? "#FFFFFF", ['class' => 'form-control']) !!}
            <span class="input-group-append">
                <span class="input-group-text colorpicker-input-addon"><i></i></span>
            </span>
        </div>
    </div>
</div>

<h3>Board</h3>
<p>This is the part of the game where the fallominoes are placed.</p>
<div class="row">
    <div class="col-md-6 form-group">
        {!! Form::label('Board colour') !!}
        <div class="input-group cp">
            {!! Form::text('board_colour', $data['board_colour'] ?? "#000000", ['class' => 'form-control']) !!}
            <span class="input-group-append">
                <span class="input-group-text colorpicker-input-addon"><i></i></span>
            </span>
        </div>
    </div>
</div>

<h3>Score</h3>
<p>This is the box to the right of the field, containing the score.</p>
<div class="row">
    <div class="col form-group">
        {!! Form::label('Score colour') !!}
        <div class="input-group cp">
            {!! Form::text('score_colour', $data['score_colour'] ?? "#000000", ['class' => 'form-control']) !!}
            <span class="input-group-append">
                <span class="input-group-text colorpicker-input-addon"><i></i></span>
            </span>
        </div>
    </div>
    <div class="col form-group">
        {!! Form::label('Score text colour') !!}
        <div class="input-group cp">
            {!! Form::text('score_text_colour', $data['score_text_colour'] ?? "#000000", ['class' => 'form-control']) !!}
            <span class="input-group-append">
                <span class="input-group-text colorpicker-input-addon"><i></i></span>
            </span>
        </div>
    </div>
</div>

<h3>Next shape</h3>
<p>This is the box to the right of the field, containing the next piece.</p>
<div class="row">
    <div class="col form-group">
        {!! Form::label('Next up colour') !!}
        <div class="input-group cp">
            {!! Form::text('next_colour', $data['next_colour'] ?? "#000000", ['class' => 'form-control']) !!}
            <span class="input-group-append">
                <span class="input-group-text colorpicker-input-addon"><i></i></span>
            </span>
        </div>
    </div>
    <div class="col form-group">
        {!! Form::label('Next up Outline width') !!}
        {!! Form::number('next_outline_width', $data['next_outline_width'] ?? 1, ['class' => 'form-control']) !!}
    </div>
    <div class="col form-group">
        {!! Form::label('Next up outline colour') !!}
        <div class="input-group cp">
            {!! Form::text('next_outline_colour', $data['next_outline_colour'] ?? "#FFFFFF", ['class' => 'form-control']) !!}
            <span class="input-group-append">
                <span class="input-group-text colorpicker-input-addon"><i></i></span>
            </span>
        </div>
    </div>
</div>

<h3>Container</h3>
<p>This is the container wrapping around the blockfall board, as well as the score container.</p>
<div class="row">
    <div class="col form-group">
        {!! Form::label('Container colour') !!}
        <div class="input-group cp">
            {!! Form::text('container_colour', $data['container_colour'] ?? "#000000", ['class' => 'form-control']) !!}
            <span class="input-group-append">
                <span class="input-group-text colorpicker-input-addon"><i></i></span>
            </span>
        </div>
    </div>
    <div class="col form-group">
        {!! Form::label('Container Outline width') !!}
        {!! Form::number('container_outline_width', $data['container_outline_width'] ?? 1, ['class' => 'form-control']) !!}
    </div>
    <div class="col form-group">
        {!! Form::label('Container outline colour') !!}
        <div class="input-group cp">
            {!! Form::text('container_outline_colour', $data['container_outline_colour'] ?? "#FFFFFF", ['class' => 'form-control']) !!}
            <span class="input-group-append">
                <span class="input-group-text colorpicker-input-addon"><i></i></span>
            </span>
        </div>
    </div>
</div>
