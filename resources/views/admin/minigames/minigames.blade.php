@extends('admin.layout')

@section('admin-title') Minigames @endsection

@section('admin-content')
{!! breadcrumbs(['Admin Panel' => 'admin', 'Minigames' => 'admin/data/minigames']) !!}

<h1>Minigames</h1>

<p>This is a list of minigames that users can play.</p>
<p>The sorting order reflects the order in which the minigames will be listed on the minigame index.</p>

<div class="text-right mb-3"><a class="btn btn-primary" href="{{ url('admin/data/minigames/create') }}"><i class="fas fa-plus"></i> Create New Minigame</a></div>
@if(!count($minigames))
    <p>No minigames found.</p>
@else
    <table class="table table-sm">
        <tbody id="sortable" class="sortable">
            @foreach($minigames as $minigame)
                <tr class="sort-item" data-id="{{ $minigame->id }}">
                    <td>
                        <a class="fas fa-arrows-alt-v handle mr-3" href="#"></a>
                        {!! $minigame->displayName !!}
                    </td>
                    <td class="text-right">
                        <a href="{{ url('admin/data/minigames/edit/'.$minigame->id) }}" class="btn btn-primary">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>
    <div class="mb-4">
        {!! Form::open(['url' => 'admin/data/minigames/sort']) !!}
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
