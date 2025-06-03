<h1>Lucky Pull</h1>
<p>Users get the option to see if they get lucky and earn a reward. </p>
<p>Users will earn the reward pool plus any rewards specified above, so you can have one or the other, or both.</p>

<div class="row">
    <div class="col form-group text-center">
        <div class="row">
            <div class="col">
                <h5>Currency Pool (Optional)</h5>
                <p>The user's fee will be added to the total reward pool every time a user loses, with the first winning user earning the entire pool, then the total pool resets. The game must have a fee to use this.</p>
            </div>
            <div class="col">
                <div class="form-group">
                    {!! Form::checkbox('use_pool', 1, $data['use_pool'] ?? 0, ['class' => 'form-check-label', 'data-toggle' => 'toggle', 'id' => 'use_pool']) !!}
                    {!! Form::label('use_pool', 'Use Pool?', ['class' => 'form-check-label ml-3']) !!}{!! add_help('Turn on to allow a currency pool.') !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group use_pool {{ isset($data['use_pool']) && $data['use_pool'] == 1 ? '' : 'hide' }}">
                    <h5>Pool</h5>
                    <div class="row">
                        <div class="col form-group">
                            {!! Form::label('Max Pool') !!}{!! add_help('The currency cap that the reward can reach. Leave blank for no cap.') !!}
                            {!! Form::number('max_pool', $data['max_pool'] ?? null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col form-group">
                            {!! Form::label('Base Pool') !!}{!! add_help('Starting pool before users interact. Resets to this when a user wins.') !!}
                            {!! Form::number('base_pool', $data['base_pool'] ?? 1, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col form-group text-center">
        <h5>Odds and Ends</h5>
        <p>Percentages are measured out of 100%, so input accordingly.</p>
        <div class="row">
            <div class="col form-group">
                {!! Form::label('Base Win Chance') !!}
                {!! Form::number('base_odds', $data['base_odds'] ?? 1, ['class' => 'form-control']) !!}
            </div>
            <div class="col">
                <div class="form-group">
                    {!! Form::checkbox('use_increment', 1, $data['use_increment'] ?? 0, ['class' => 'form-check-label', 'data-toggle' => 'toggle', 'id' => 'increment']) !!}
                    {!! Form::label('increment', 'Increment?', ['class' => 'form-check-label ml-3']) !!}{!! add_help('The chance to win will increase every time a user fails to succeed (users cannot see the percentage to win.)') !!}
                </div>
                <div class="form-group increment {{ isset($data['use_increment']) && $data['use_increment'] == 1 ? '' : 'hide' }}">
                    {!! Form::label('increment_amount', 'Increment Amount') !!}{!! add_help('Amount for the win percentage to increase every time a player fails.') !!}
                    {!! Form::number('increment_amount', $data['increment_amount'] ?? 1, ['class' => 'form-control']) !!}
                    {!! Form::label('increment_cap', 'Increment Cap') !!}{!! add_help('Cap for the max win percentage.') !!}
                    {!! Form::number('increment_cap', $data['increment_cap'] ?? null, ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
    </div>
</div>
