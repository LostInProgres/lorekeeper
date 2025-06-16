<h5>Bubble Images</h5>
<p>If you want to replace the sudoku numbers with images, you can do so here.</p>

@if (isset($arcade->data['bubble_colour_amount']))
    <div class="row">
        @for ($i = 0; $i < $arcade->data['bubble_colour_amount']; $i++)
            @php
                $num = $i + 1;
            @endphp
            @include('admin.arcades.image_widget', ['key' => 'number_' . $num, 'size' => '???, keep it square (200x200, etc)', 'imagename' => $num . ' Tile'])
        @endfor
    </div>
@else
<p>Please set a bubble amount first!
@endif
