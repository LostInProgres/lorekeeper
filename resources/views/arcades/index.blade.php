@extends('arcades.layout')

@section('arcades-title')
    Arcade Index
@endsection

@section('arcades-content')
    {!! breadcrumbs(['Arcade' => 'arcade']) !!}

    <h1>
        Arcade
    </h1>
    <p>You can play a series of different games here! Each game might have different rules, so check its page to see how it works.</p>

    <div class="row">
        @foreach ($arcades as $arcade)
            <div class="col-md-3 col-6 mb-3 text-center">
                @if ($arcade->has_image)
                    <div class="shop-image">
                        <a href="{{ $arcade->url }}"><img class="img-fluid" src="{{ $arcade->imageUrl }}" alt="{{ $arcade->name }}" /></a>
                    </div>
                @endif
                <div class="shop-name mt-1">
                    <a href="{{ $arcade->url }}" class="h5 mb-0">{{ $arcade->name }}</a>
                </div>
            </div>
        @endforeach
    </div>
@endsection
