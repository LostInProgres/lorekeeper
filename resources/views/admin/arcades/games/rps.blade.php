<h1>Rock, Paper, Scissors</h1>
<p>A classic RPS game. </p>

<h5>Standard Game</h5>
<p>The standard 3 options for RPS. You can rename them, but keep in mind their strengths and weaknesses!!!</p>

<div class="mb-4 logs-table">
    <div class="logs-table-header mb-2">
        <div class="row">
            <div class="col-6 col-md-3">
                <div class="logs-table-cell"><strong>Option</strong></div>
            </div>
            <div class="col-6 col-md-2">
                <div class="logs-table-cell"><strong>Wins Vs</strong></div>
            </div>
        </div>
    </div>
    <div class="logs-table-body">
        <div class="row flex-wrap mb-2">
            <div class="col-6 col-md-3">
                <div class="logs-table-cell">
                    {!! Form::text('rock_name', $data['rock_name'] ?? 'Rock', ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-6 col-md-2">
                <div class="logs-table-cell">
                    Rock crushes Scissors.
                </div>
            </div>
        </div>
        <div class="row flex-wrap mb-2">
            <div class="col-6 col-md-3">
                <div class="logs-table-cell">
                    {!! Form::text('paper_name', $data['paper_name'] ?? 'Paper', ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-6 col-md-2">
                <div class="logs-table-cell">
                    Paper covers Rock.
                </div>
            </div>
        </div>
        <div class="row flex-wrap mb-2">
            <div class="col-6 col-md-3">
                <div class="logs-table-cell">
                    {!! Form::text('scissors_name', $data['scissors_name'] ?? 'Scissors', ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-6 col-md-2">
                <div class="logs-table-cell">
                    Scissors cuts Paper.
                </div>
            </div>
        </div>
    </div>
</div>

<h5>RPS-7</h5>
<p>A version of RPS with quote, "the completely unnecessary addition of four additional hand gestures". These are optional, but if you want to use RPS-7, you must add all 4 additional options! </p>
<p>RPS-7 originates from <a href="https://www.umop.com/rps7.htm">umop.com,</a> where you can see the "official" RPS-7 matchup chart.</p>

{!! Form::checkbox('use_7', 1, $data['use_7'] ?? 0, ['class' => 'form-check-label', 'data-toggle' => 'toggle', 'id' => 'use_7']) !!}
{!! Form::label('use_7', 'Use RPS-7?', ['class' => 'form-check-label ml-3']) !!}



<div class="use_7 {{ isset($data['use_7']) && $data['use_7'] == 1 ? '' : 'hide' }}">
    <div class="mb-4 logs-table">
        <div class="logs-table-header mb-2">
            <div class="row">
                <div class="col-6 col-md-3">
                    <div class="logs-table-cell"><strong>Option</strong></div>
                </div>
                <div class="col-6 col-md-4">
                    <div class="logs-table-cell"><strong>Wins Vs</strong></div>
                </div>
            </div>
        </div>
        <div class="logs-table-body">
            <div class="row flex-wrap mb-2">
                <div class="col-6 col-md-3">
                    <div class="logs-table-cell">
                        {!! Form::text('sponge_name', $data['sponge_name'] ?? 'Sponge', ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="col-6 col-md-4">
                    <div class="logs-table-cell">
                        Sponge soaks Paper, uses Air pockets, and absorbs Water.
                    </div>
                </div>
            </div>
            <div class="row flex-wrap mb-2">
                <div class="col-6 col-md-3">
                    <div class="logs-table-cell">
                        {!! Form::text('fire_name', $data['fire_name'] ?? 'Fire', ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="col-6 col-md-4">
                    <div class="logs-table-cell">
                        Fire melts Scissors, and burns Paper and Sponge.
                    </div>
                </div>
            </div>
            <div class="row flex-wrap mb-2">
                <div class="col-6 col-md-3">
                    <div class="logs-table-cell">
                        {!! Form::text('air_name', $data['air_name'] ?? 'Air', ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="col-6 col-md-4">
                    <div class="logs-table-cell">
                        Air blows out Fire, erodes Rock, and evaporates Water.
                    </div>
                </div>
            </div>
            <div class="row flex-wrap mb-2">
                <div class="col-6 col-md-3">
                    <div class="logs-table-cell">
                        {!! Form::text('water_name', $data['water_name'] ?? 'Water', ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="col-6 col-md-4">
                    <div class="logs-table-cell">
                        Water erodes Rock, puts out Fire, and rusts Scissors.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
