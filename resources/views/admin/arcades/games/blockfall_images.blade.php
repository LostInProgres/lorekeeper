<h5>Fallominoes</h5>
<p>Please note that the fallominoes are made up out of several smaller blocks. You can upload an image for them, which will cover each "tile" of the shape</p>

<div class="row">
    @include('admin.arcades.image_widget', ['key' => 'Steward', 'size' => 'Square, keep it small', 'imagename' => 'Steward (Straight)'])
    @include('admin.arcades.image_widget', ['key' => 'Arnold', 'size' => 'Square, keep it small', 'imagename' => 'Arnold (Square)'])
    @include('admin.arcades.image_widget', ['key' => 'Freddy', 'size' => 'Square, keep it small', 'imagename' => 'Freddy (T-shape)'])
    @include('admin.arcades.image_widget', ['key' => 'Gerald', 'size' => 'Square, keep it small', 'imagename' => 'Gerald (L-shape)'])
    @include('admin.arcades.image_widget', ['key' => 'Evil_Gerald', 'size' => 'Square, keep it small', 'imagename' => 'Evil Gerald (Reverse L-shape)'])
    @include('admin.arcades.image_widget', ['key' => 'Vanessa', 'size' => 'Square, keep it small', 'imagename' => 'Vanessa (Squiggle)'])
    @include('admin.arcades.image_widget', ['key' => 'Amber', 'size' => 'Square, keep it small', 'imagename' => 'Amber (Reverse Squiggle)'])
</div>

<h5>Backgrounds</h5>
<div class="row">
   @include('admin.arcades.image_widget', ['key' => 'board', 'size' => '???', 'imagename' => 'Board'])
   @include('admin.arcades.image_widget', ['key' => 'score', 'size' => '???', 'imagename' => 'Score'])
   @include('admin.arcades.image_widget', ['key' => 'next', 'size' => '???', 'imagename' => 'Next Shape'])
   @include('admin.arcades.image_widget', ['key' => 'container', 'size' => '???', 'imagename' => 'Container'])
</div>

