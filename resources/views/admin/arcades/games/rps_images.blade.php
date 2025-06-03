<h5>Option Images</h5>
<p>This will replace the dropdown with an image that must be clicked.</p>
<p>Each option must have an image uploaded for image selection to work!</p>
<p>RPS-7 images can be added after RPS-7 is enabled.</p>
<div class="row">
    @foreach ($arcade->service->rpsOptions($arcade) as $key => $name)
        @include('admin.arcades.image_widget', ['key' => $key, 'size' => '??? (Choose a standard size for all options)', 'imagename' => $name])
    @endforeach
</div>
