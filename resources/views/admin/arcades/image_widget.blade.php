<div class="col-md-4 mb-4">
    <div class="card h-100">
        @if ($arcade->customImageExists($key))
            <div class="card-header text-center">
                <img src="{{ $arcade->customImageUrl($key) }}" class="img-fluid">
            </div>
        @endif
        <div class="card-body text-center">
            <h5 class="mt-3">
                {{ $imagename }} Image
            </h5>
            <div class="text-muted">Recommended size: {{ $size }}</div>
            <div>{!! Form::file('custom_image[' . $key . ']') !!}</div>
            @if ($arcade->customImageExists($key))
                <div class="form-check">
                    {!! Form::checkbox('remove_custom_image[' . $key . ']', 1, false, ['class' => 'form-check-input']) !!}
                    {!! Form::label('remove_custom_image[' . $key . ']', 'Remove current image', ['class' => 'form-check-label']) !!}
                </div>
            @endif
        </div>
    </div>
</div>
