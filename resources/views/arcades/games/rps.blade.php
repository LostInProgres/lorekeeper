@if ($use_7)
    <p>RPS-7 is enabled...</p>
@endif

@if ($allimages)
    <div class="text-center">
        {!! Form::open(['url' => 'arcade/' . $arcade->id . '/play']) !!}

        {!! Form::hidden('option', null, ['class' => 'option']) !!}

        <div class="row selectable" id="selectable">
            @foreach ($options as $key => $name)
                <div class="col-md-4 mb-4" value="{{ $key }}">
                    <img src="{{ $arcade->customImageUrl($key) }}" class="img-fluid mb-4">
                    <h5>{{ $name }}</h5>
                </div>
            @endforeach
        </div>

        {!! Form::submit('Fight!', ['class' => 'btn btn-primary']) !!}

        {!! Form::close() !!}
    </div>

    @include('arcades.games.rps_js', ['arcade' => $arcade])
    @include('arcades.games.rps_css', ['arcade' => $arcade])
@else
    {!! Form::open(['url' => 'arcade/' . $arcade->id . '/play']) !!}
    <div class="col-md-4">
        <div class="input-group mb-3">
            {!! Form::select('option', $options, null, ['class' => 'form-control', 'placeholder' => 'Select Option']) !!}
            <div class="input-group-append">
                {!! Form::submit('Fight!', ['class' => 'btn btn-primary']) !!}
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endif
