<h1>Word Search</h1>
<p>Classic word search. Users can either earn rewards per word found, or for completing the entire word search. </p>
<p>You can set your own set of words below, or populate a preset selection of words.</p>

<div class="row">
    <div class="col form-group text-center">
        <h5>Word Settings</h5>
        <p>This determines the number of words the user's generated puzzle will have. This means that you could input a word list of 20 words, but each game may generate a different number of words each time.</p>
        <div class="row">
            <div class="col form-group">
                {!! Form::label('Minimum Word List Size') !!}
                {!! Form::number('word_min', $data['word_min'] ?? 10, ['class' => 'form-control']) !!}
            </div>
            <div class="col form-group">
                {!! Form::label('Maximum Word List Size') !!}{!! add_help('Note that the word list MUST contain at least this amount of unique words.') !!}
                {!! Form::number('word_max', $data['word_max'] ?? 15, ['class' => 'form-control', 'id' => 'word_max']) !!}
            </div>
        </div>
    </div>
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
<div class="text-center">
    <div class="row">
        <div class="col form-group">
            <h5>Word Sets</h5>
            <p>Select a theme to populate a default word set, or you can input your own instead. Individual words should be separated by commas. Try not to include duplicate words or spaces.</p>
            <p>While the editor helps you ensure your word list is formatted correctly, it may be troublesome to edit, and impossible to copy paste. Click edit to save any changes before clicking to copy your word set.</p>
        </div>
        <div class="col form-group">
            <p>The default word sets can be found and modified in <code>config/lorekeeper/wordsearch.php</code> if desired.</p>
            <p>The word set will populate into the data after you click "edit".</p>
            {!! Form::label('Preset Word Selection') !!}{!! add_help('Selecting a preset will overwrite any existing words. Save data that you want to keep in a text editor!') !!}
            {!! Form::select('preset', $presets, null, ['class' => 'form-control word-selectize', 'placeholder' => 'Select Preset']) !!}
        </div>
    </div>

    <h5> Word List
        @if (isset($data['words']))
        <i data-toggle="tooltip" title="Click to copy" id="copy" style="vertical-align: middle;" class="far fa-copy"></i>
        <i data-toggle="tooltip" title="Click to clear" id="clear-words" style="vertical-align: middle;" class="fas fa-broom"></i>
        @endif
    </h5>
    {!! Form::text('words', $data['words'] ?? null, [
        'class' => 'form-control word-list',
        'multiple',
    ]) !!}
</div>
