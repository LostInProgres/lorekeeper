<h1>Bubble Pop</h1>
<p>Pop a cluster of bubbles to score points.</p>

<h3>Sizes</h3>
<p>It is reccomended to keep the sizes in this section roughly proportionate to their default values. Going outside of these ratios might make the game hard to play on certain devices!</p>
<div class="row">
    <div class="col-6">
        <h4>Bubble size</h4>
        <p>This decides the size of the bubbles. Note that bubbles will always be square.</p>
        <p>The game will automatically reisze if the screen size cannot accomodate it, which means that bubbles might show up smaller then configured here.</p>
        <div class="col form-group">
            {!! Form::label('Bubble size') !!}
            {!! Form::number('bubble_size', $data['bubble_size'] ?? 40, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-6">
        <h4>Game Columns</h4>
        <p>This decides the amount of columns in the game.</p>
        <div class="col form-group">
            {!! Form::label('Game columns') !!}
            {!! Form::number('game_columns', $data['game_columns'] ?? 15, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-6">
        <h4>Game Rows</h4>
        <p>This decides the amount of rows in the game.</p>
        <div class="col form-group">
            {!! Form::label('Game rows') !!}
            {!! Form::number('game_rows', $data['game_rows'] ?? 14, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>

<h3>Gameplay</h3>
<div class="row">
    <div class="col-6">
        <h4>Colour amounts</h4>
        <p>This decides how many unique colours of bubbles will be in the game. The higher the amount, the harder the game will be!</p>
        <div class="col form-group">
            {!! Form::label('Colour Amount') !!}
            {!! Form::number('bubble_colour_amount', $data['bubble_colour_amount'] ?? 7, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-6">
        <h4>Initial rows</h4>
        <p>This decides how many rows are added at the start of the game.</p>
        <div class="col form-group">
            {!! Form::label('Initial rows') !!}
            {!! Form::number('initial_rows', $data['initial_rows'] ?? 5, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-6">
        <h4>Turns until rows are added</h4>
        <p>This decides how many turns pass before a new row of bubbles is added to the top of the screen. Make this number lower for a harder game.</p>
        <div class="col form-group">
            {!! Form::label('Turn Speed') !!}
            {!! Form::number('turn_speed', $data['turn_speed'] ?? 5, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-6">
        <h4>Minimum cluster size</h4>
        <p>This decides how many same-colour bubbles need to touch for them to dissapear and be added to the score.</p>
        <div class="col form-group">
            {!! Form::label('Cluster Size') !!}
            {!! Form::number('cluster_size', $data['cluster_size'] ?? 3, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-6">
        <h4>Points per pop</h4>
        <p>This decides how many points are earned for each popped bubble. Keep in mind the minimum cluster size when setting this!</p>
        <div class="col form-group">
            {!! Form::label('points per pop') !!}
            {!! Form::number('points_per_pop', $data['points_per_pop'] ?? 100, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-6">
        <h4>Bubble travel speed</h4>
        <p>This decides how fast the bubbel travels when shot.</p>
        <div class="col form-group">
            {!! Form::label('Bubble speed') !!}
            {!! Form::number('bubble_speed', $data['bubble_speed'] ?? 1000, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>
<h3>Aim assist</h3>
<div class="row">
    <div class="col-6">
        <h4>Aim assist length</h4>
        <div class="col form-group">
            {!! Form::number('aim_assist_length', $data['aim_assist_length'] ?? 250, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-6">
        <h4>Aim assist colour</h4>
        <div class="form-group">
            <div class="input-group cp">
                {!! Form::text('aim_assist_colour', $data['aim_assist_colour'] ?? "#000000", ['class' => 'form-control']) !!}
                <span class="input-group-append">
                    <span class="input-group-text colorpicker-input-addon"><i></i></span>
                </span>
            </div>
        </div>
    </div>
</div>

<h3>Colours</h3>
<div class="row">
    <div class="col-6">
        <h4>Header colour</h4>
        <div class="form-group">
            <div class="input-group cp">
                {!! Form::text('header_colour', $data['header_colour'] ?? "#01121c", ['class' => 'form-control']) !!}
                <span class="input-group-append">
                    <span class="input-group-text colorpicker-input-addon"><i></i></span>
                </span>
            </div>
        </div>
    </div>
    <div class="col-6">
        <h4>Header text colour</h4>
        <div class="form-group">
            <div class="input-group cp">
                {!! Form::text('header_text_colour', $data['header_text_colour'] ?? "#ffffff", ['class' => 'form-control']) !!}
                <span class="input-group-append">
                    <span class="input-group-text colorpicker-input-addon"><i></i></span>
                </span>
            </div>
        </div>
    </div>
    <div class="col-6">
        <h4>Footer colour</h4>
        <div class="form-group">
            <div class="input-group cp">
                {!! Form::text('footer_colour', $data['footer_colour'] ?? "#c4c4c4", ['class' => 'form-control']) !!}
                <span class="input-group-append">
                    <span class="input-group-text colorpicker-input-addon"><i></i></span>
                </span>
            </div>
        </div>
    </div>
    <div class="col-6">
        <h4>Footer text colour</h4>
        <div class="form-group">
            <div class="input-group cp">
                {!! Form::text('footer_text_colour', $data['footer_text_colour'] ?? "#ffffff", ['class' => 'form-control']) !!}
                <span class="input-group-append">
                    <span class="input-group-text colorpicker-input-addon"><i></i></span>
                </span>
            </div>
        </div>
    </div>
    <div class="col-6">
        <h4>Background colour</h4>
        <div class="form-group">
            <div class="input-group cp">
                {!! Form::text('background_colour', $data['background_colour'] ?? "#e8eaec", ['class' => 'form-control']) !!}
                <span class="input-group-append">
                    <span class="input-group-text colorpicker-input-addon"><i></i></span>
                </span>
            </div>
        </div>
    </div>
</div>

<!-- LOSTODO:
    3. Add custom image for the shooter
    5. Add background image
-->