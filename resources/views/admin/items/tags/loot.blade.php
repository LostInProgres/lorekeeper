<h3>Rewards</h3>

<p>These are the rewards that will be distributed to the user when they use the loot from their inventory. The loot will only distribute rewards to the user themselves - character-only currencies should not be added.</p>

<div class="form-group">
    {!! Form::select('table_id', $tables, $tag->data, ['class' => 'form-control table-select', 'placeholder' => 'Select Loot Table']) !!}
</div>