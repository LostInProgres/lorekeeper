@extends('world.layout')

@section('title') {{ $category->name }} @endsection

@section('content')
{!! breadcrumbs(['World' => 'world', 'Items' => 'world/items', $category->name => $category->idUrl]) !!}
<h1>{!! $category->name !!} @if(isset($category->searchUrl) && $category->searchUrl) <a href="{{ $category->searchUrl }}" class="world-entry-search text-muted"><i class="fas fa-search"></i></a>  @endif</h1>
<div class="row world-entry">
    @if($category->categoryImageUrl)
        <div class="col-md-3 world-entry-image"><a href="{{ $category->categoryImageUrl }}" data-lightbox="entry" data-title="{{ $category->name }}"><img src="{{ $category->categoryImageUrl }}" class="world-entry-image" alt="{{ $category->name }}" /></a></div>
    @endif
    <div class="{{ $category->categoryImageUrl ? 'col-md-9' : 'col-12' }}">
        @if($category->is_character_owned == 1)
        <div><strong>Characters can own {{ $category->character_limit != 0 ? $category->character_limit : '' }} items in this category{{ $category->can_name != 0 ? ', as well as name them' : '' }}!</strong></div>
        @endif
        <div class="world-entry-text">
            {!! $category->description !!}
        </div>
    </div>
</div>



<h3>Items</h3>

<div>
    {!! Form::open(['method' => 'GET', 'class' => '']) !!}
        <div class="form-inline justify-content-end">
            <div class="form-group ml-3 mb-3">
                {!! Form::text('name', Request::get('name'), ['class' => 'form-control', 'placeholder' => 'Name']) !!}
            </div>
            @if(Config::get('lorekeeper.extensions.item_entry_expansion.extra_fields'))
                <div class="form-group ml-3 mb-3">
                    {!! Form::select('artist', $artists, Request::get('artist'), ['class' => 'form-control']) !!}
                </div>
            @endif
            <div class="form-group ml-3 mb-3">
                {!! Form::select('sort', [
                    'alpha'          => 'Sort Alphabetically (A-Z)',
                    'alpha-reverse'  => 'Sort Alphabetically (Z-A)',
                    'newest'         => 'Newest First',
                    'oldest'         => 'Oldest First'
                ], Request::get('sort') ? : 'category', ['class' => 'form-control']) !!}
            </div>
            <div class="form-group ml-3 mb-3">
                {!! Form::submit('Search', ['class' => 'btn btn-primary']) !!}
            </div>
        </div>
    {!! Form::close() !!}
</div>

{!! $items->render() !!}
@foreach($items as $item)
    <div class="card mb-3">
        <div class="card-body">
        <?php
        $shops = App\Models\Shop\Shop::whereIn('id', App\Models\Shop\ShopStock::where('item_id', $item->id)->pluck('shop_id')->toArray())->orderBy('sort', 'DESC')->get();
        ?>
        @include('world._item_entry', ['imageUrl' => $item->imageUrl, 'name' => $item->displayName, 'description' => $item->parsed_description, 'idUrl' => $item->idUrl, 'shops' => $shops])
        </div>
    </div>
@endforeach
{!! $items->render() !!}

<div class="text-center mt-4 small text-muted">{{ $items->total() }} result{{ $items->total() == 1 ? '' : 's' }} found.</div>
@endsection
