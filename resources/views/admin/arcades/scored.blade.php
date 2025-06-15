<h1>Scored game configuration</h1>
<p>In this game, players earn a score based on their moves in the game. Because of this, additional settings are required for these games to reward prizes.</p>

<h3>Minimum score based rewards</h3>
<p>When this option has data, rewards are granted starting a specific score. This is compatible with milestone based rewards below, but at least one should have input for the game to send any rewards out.</p>
<div class="col form-group">
    {!! Form::label('Minimum score') !!}
    {!! Form::number('score_min', $data['score_min'] ?? null, ['class' => 'form-control']) !!}
</div>

<h3>Milestone based rewards</h3>
<p>When this option has data, rewards are given out any time a "milestone" amount of points is reached. Inputting 250, for example, would mean that rewards are given out at 250, 500, 750 etc points.</p>
<div class="col form-group">
    {!! Form::label('Milestones') !!}
    {!! Form::number('milestone', $data['milestone'] ?? null, ['class' => 'form-control']) !!}
</div>

<h5>Maximum score</h5>
<p>When this option has data, milestone rewards will be capped after the set amount of points. For example, if milestone rewards are set at 750, and the cap is set at 2500, a user submitting a score of more than 2500 will still only receive the reward ten times.</p>
<div class="col form-group">
    {!! Form::label('Maximum score') !!}
    {!! Form::number('score_max', $data['score_max'] ?? null, ['class' => 'form-control']) !!}
</div>