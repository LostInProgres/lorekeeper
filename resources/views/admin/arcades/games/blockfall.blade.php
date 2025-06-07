<h1>Blockfall</h1>
<p>A simple game of tetris. Users earn rewards based on points earned.</p>

<div class="row">
    <div class="col form-group text-center">
        <h5>Reward/Submit Settings</h5>
        <div class="row">
            <div class="award_per_word {{ isset($data['award_per_word']) && $data['award_per_word'] == 1 ? '' : 'hide' }}">
                <div class="col form-group">
                    {!! Form::label('Found Word Minimum') !!}{!! add_help('Minimum words that need to be found to be rewarded for playing the puzzle. Note that empty word searches cannot be submitted regardless. If you do not want a minimum, leave this blank.') !!}
                    {!! Form::number('submit_min', $data['submit_min'] ?? null, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col form-group">
                {!! Form::checkbox('award_per_word', 1, $data['award_per_word'] ?? 0, ['class' => 'form-check-label', 'data-toggle' => 'toggle', 'id' => 'award_per_word']) !!}
                {!! Form::label('award_per_word', 'Award Per Word?', ['class' => 'form-check-label ml-3']) !!}{!! add_help('If set on, users will earn the specified rewards above PER WORD FOUND. Otherwise, they will only earn rewards if the word search is fully complete.') !!}
            </div>
        </div>
    </div>
</div>
