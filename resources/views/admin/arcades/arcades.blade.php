@extends('admin.layout')

@section('admin-title') Arcade @endsection

@section('admin-content')
{!! breadcrumbs(['Admin Panel' => 'admin', 'Arcade' => 'admin/data/arcade']) !!}

<h1>Arcade</h1>

<p>This is a list of games that users can play.</p>
<p>The sorting order reflects the order in which the games will be listed on the arcade index.</p>

<div class="text-right mb-3"><a class="btn btn-primary" href="{{ url('admin/data/arcade/create') }}"><i class="fas fa-plus"></i> Create New Game</a></div>
@if(!count($arcades))
    <p>No games found.</p>
@else
    <table class="table table-sm">
        <tbody id="sortable" class="sortable">
            @foreach($arcades as $arcade)
                <tr class="sort-item" data-id="{{ $arcade->id }}">
                    <td>
                        <a class="fas fa-arrows-alt-v handle mr-3" href="#"></a>
                        {!! $arcade->displayName !!}
                    </td>
                    <td class="text-right">
                        <a href="{{ url('admin/data/arcade/edit/'.$arcade->id) }}" class="btn btn-primary">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>
    <div class="mb-4">
        {!! Form::open(['url' => 'admin/data/arcade/sort']) !!}
        {!! Form::hidden('sort', '', ['id' => 'sortableOrder']) !!}
        {!! Form::submit('Save Order', ['class' => 'btn btn-primary']) !!}
        {!! Form::close() !!}
    </div>
@endif

@endsection

@section('scripts')
@parent
<script>

$( document ).ready(function() {
    $('.handle').on('click', function(e) {
        e.preventDefault();
    });
    $( "#sortable" ).sortable({
        items: '.sort-item',
        handle: ".handle",
        placeholder: "sortable-placeholder",
        stop: function( event, ui ) {
            $('#sortableOrder').val($(this).sortable("toArray", {attribute:"data-id"}));
        },
        create: function() {
            $('#sortableOrder').val($(this).sortable("toArray", {attribute:"data-id"}));
        }
    });
    $( "#sortable" ).disableSelection();
});
</script>
@endsection
