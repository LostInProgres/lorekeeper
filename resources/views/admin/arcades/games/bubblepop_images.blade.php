<h5>Bubble Images</h5>
<p>If you want to replace the sudoku numbers with images, you can do so here.</p>

@if (isset($arcade->data['bubble_colour_amount']))
    <div class="row">
        @for ($i = 0; $i < $arcade->data['bubble_colour_amount']; $i++)
            @php
                $num = $i + 1;
            @endphp
            @include('admin.arcades.image_widget', ['key' => 'number_' . $num, 'size' => '???, dependant on game settings, default is 40x40', 'imagename' => $num . ' Tile'])
        @endfor
    </div>
@else
<p>Please set a bubble amount first!
@endif

<h5>Backgrounds</h5>
<div class="row">
   @include('admin.arcades.image_widget', ['key' => 'background', 'size' => '???, dependant on game settings', 'imagename' => 'Background'])
   @include('admin.arcades.image_widget', ['key' => 'header', 'size' => '???, dependant on game settings', 'imagename' => 'header'])
   @include('admin.arcades.image_widget', ['key' => 'footer', 'size' => '???, dependant on game settings', 'imagename' => 'footer'])
</div>