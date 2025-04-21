@extends('home.layout')

@section('home-title') {{ ucfirst(__('awards.awards')) }} @endsection

@section('home-content')
{!! breadcrumbs([ ucfirst(__('awards.awardcase'))  => __('awards.awardcase'), 'Awards Sort' => 'awardcase/edit/sort']) !!}

<h1>Awards sort</h1>

@if(!isset($UserAwards))
    <p>No awards found.</p>
@else 
{!! Form::open(['url' => 'awardcase/edit/sort/post']) !!}
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
                        @if (isset($UserAward->is_visible) && $UserAward->is_visible == 1)
                            <input type="checkbox" name="visibility[]" value="{{ $UserAward->id }}" checked>
                        @else
                            <input type="checkbox" name="visibility[]" value="{{ $UserAward->id }}">
                        @endif
                        Is visible?
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>
    <div class="mb-4">

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