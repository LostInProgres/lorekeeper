@extends('admin.layout')

@section('admin-title') Awards @endsection

@section('admin-content')
{!! breadcrumbs(['Admin Panel' => 'admin', 'Rarities' => 'admin/data/rarities']) !!}

<h1>Awards sort</h1>

@if(!isset($UserAwards))
    <p>No awards found.</p>
@else 
    <table class="table table-sm award-table">
        <tbody id="sortable" class="sortable">
            @foreach($UserAwards as $UserAward)
                <tr class="sort-item" data-id="{{ $UserAward->id }}">
                    <td>
                        <a class="fas fa-arrows-alt-v handle mr-3" href="#"></a>
                        @if($UserAward->award->has_image)
                            <a href="{{ $UserAward->award->idUrl }}"><img src="{{ $UserAward->award->imageUrl }}" alt="{{ $UserAward->award->name }}" class="img-fluid" style="Height:4rem"/></a>
                        @endif
                        {!! $UserAward->award->displayName !!}
                    </td>
                    <td class="text-right">
                        {!! Form::checkbox('is_visible['.$UserAward->id.']', 1, $UserAward->is_visible ?? 1, [
                        'class' => 'form-check-input',
                        'data-toggle' => 'toggle',
                    ]) !!}
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>
    <div class="mb-4">
        {!! Form::open(['url' => 'awardcase/edit/sort/post']) !!}
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