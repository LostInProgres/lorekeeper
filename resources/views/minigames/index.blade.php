@extends('minigames.layout')

@section('minigames-title')
    Minigames Index
@endsection

@section('minigames-content')
    {!! breadcrumbs(['Minigames' => 'minigames']) !!}

    <h1>
        Minigames
    </h1>
    <p>You can play a series of different minigames here! Each minigame might have different rules, so check its page to see how it works.</p>

    <div class="row">
        @foreach ($minigames as $minigame)
            <div class="col-md-3 col-6 mb-3 text-center">
                @if ($minigame->has_image)
                    <div class="shop-image">
                        <a href="{{ $minigame->url }}"><img class="img-fluid" src="{{ $minigame->imageUrl }}" alt="{{ $minigame->name }}" /></a>
                    </div>
                @endif
                <div class="shop-name mt-1">
                    <a href="{{ $minigame->url }}" class="h5 mb-0">{{ $minigame->name }}</a>
                </div>
            </div>
        @endforeach
    </div>
@endsection
