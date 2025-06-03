<h5>Tile Images</h5>
<p>If you want to replace the sudoku numbers with images, you can do so here.</p>
<div class="row">
    @for ($i = 0; $i < 9; $i++)
        @php
            $num = $i + 1;
        @endphp
        @include('admin.arcades.image_widget', ['key' => 'number_' . $num, 'size' => '???, keep it square (200x200, etc)', 'imagename' => $num . ' Tile'])
    @endfor
</div>

<h5>Board Image</h5>
<p>This will replace the sudoku board/background.</p>
@include('admin.arcades.image_widget', ['key' => 'board_', 'size' => '???, keep it square (200x200, etc)', 'imagename' => 'Board'])
