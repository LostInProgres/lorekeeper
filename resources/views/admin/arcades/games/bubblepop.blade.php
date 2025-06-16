<h1>Bubble Pop</h1>
<p>Create a cluster of 3 or more bubbles to score points.</p>

<h3>Gameplay config</h3>
<p>there are optional settings for customization.</p>
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
        <h4>Turns untill rows are added</h4>
        <p>This decides how many turns pass before a new row of bubbles is added to the top of the screen. Make this number lower for a harder game.</p>
        <div class="col form-group">
            {!! Form::label('Turn Speed') !!}
            {!! Form::number('turn_speed', $data['turn_speed'] ?? 5, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>

<!-- LOSTODO:
    1. Add seperate image upload for each target
    2. Add configurable target amount
    3. Add configurable game speed
    4. Add custom image for the shooter
    5. Add prediction line, configurable in length
    6. Add background image
-->