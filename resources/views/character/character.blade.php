@extends('character.layout', ['isMyo' => $character->is_myo_slot])

@section('profile-title') {{ $character->fullName }} @endsection

@section('meta-img') {{ $character->image->thumbnailUrl }} @endsection

@section('profile-content')
@if($character->is_myo_slot)
{!! breadcrumbs(['MYO Slot Masterlist' => 'myos', $character->fullName => $character->url]) !!}
@else
{!! breadcrumbs([($character->category->masterlist_sub_id ? $character->category->sublist->name.' Masterlist' : 'Character masterlist') => ($character->category->masterlist_sub_id ? 'sublist/'.$character->category->sublist->key : 'masterlist' ), $character->fullName => $character->url]) !!}
@endif

@include('character._header', ['character' => $character])

@if(Auth::check() && Auth::user()->hasPower('edit_inventories'))
        <a href="#" class="float-right btn btn-outline-info btn-sm" id="grantButton" data-toggle="modal" data-target="#grantModal"><i class="fas fa-cog"></i> Admin</a>
    @endif

{{-- Main Image --}}
<div class="row mb-3">
    <div class="col-md-7">
        <div class="text-center">
            <a href="{{ $character->image->canViewFull(Auth::check() ? Auth::user() : null) && file_exists( public_path($character->image->imageDirectory.'/'.$character->image->fullsizeFileName)) ? $character->image->fullsizeUrl : $character->image->imageUrl }}" data-lightbox="entry" data-title="{{ $character->fullName }}">
                <img src="{{ $character->image->canViewFull(Auth::check() ? Auth::user() : null) && file_exists( public_path($character->image->imageDirectory.'/'.$character->image->fullsizeFileName)) ? $character->image->fullsizeUrl : $character->image->imageUrl }}" class="image" alt="{{ $character->fullName }}" />
            </a>
        </div>
        @if($character->image->canViewFull(Auth::check() ? Auth::user() : null) && file_exists( public_path($character->image->imageDirectory.'/'.$character->image->fullsizeFileName)))
            <div class="text-right">You are viewing the full-size image. <a href="{{ $character->image->imageUrl }}">View watermarked image</a>?</div>
        @endif
    </div>
    @include('character._image_info', ['image' => $character->image])
</div>

{{-- Info --}}
<div class="card character-bio">
    <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item">
                <a class="nav-link active" id="statsTab" data-toggle="tab" href="#stats" role="tab">Stats</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="notesTab" data-toggle="tab" href="#notes" role="tab">Description</a>
            </li>
            @if(Auth::check() && Auth::user()->hasPower('manage_characters'))
                <li class="nav-item">
                    <a class="nav-link" id="settingsTab" data-toggle="tab" href="#settings-{{ $character->slug }}" role="tab"><i class="fas fa-cog"></i></a>
                </li>
            @endif
        </ul>
    </div>
    <div class="card-body tab-content">
        <div class="tab-pane fade show active" id="stats">
            @include('character._tab_stats', ['character' => $character])
        </div>
        <div class="tab-pane fade" id="notes">
            @include('character._tab_notes', ['character' => $character])
        </div>
        @if(Auth::check() && Auth::user()->hasPower('manage_characters'))
            <div class="tab-pane fade" id="settings-{{ $character->slug }}">
                {!! Form::open(['url' => $character->is_myo_slot ? 'admin/myo/'.$character->id.'/settings' : 'admin/character/'.$character->slug.'/settings']) !!}
                    <div class="form-group">
                        {!! Form::checkbox('is_visible', 1, $character->is_visible, ['class' => 'form-check-input', 'data-toggle' => 'toggle']) !!}
                        {!! Form::label('is_visible', 'Is Visible', ['class' => 'form-check-label ml-3']) !!} {!! add_help('Turn this off to hide the character. Only mods with the Manage Masterlist power (that\'s you!) can view it - the owner will also not be able to see the character\'s page.') !!}
                    </div>
                    <div class="text-right">
                        {!! Form::submit('Edit', ['class' => 'btn btn-primary']) !!}
                    </div>
                {!! Form::close() !!}
                <hr />
                <div class="text-right">
                    <a href="#" class="btn btn-outline-danger btn-sm delete-character" data-slug="{{ $character->slug }}">Delete</a>
                </div>
            </div>
        @endif
    </div>
</div>

@if(Auth::check() && Auth::user()->hasPower('edit_inventories'))
    <div class="modal fade" id="grantModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="modal-title h5 mb-0">[ADMIN] Grant Traits</span>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                @php 
                    $featureOptions = \App\Models\Feature\Feature::pluck('name','id');
                    
                @endphp
                <div class="modal-body">
                <p>This will credit the traits to the character's unlocked traits list..</p>
                <div class="form-group">
                {!! Form::open(['url' => 'admin/character/'.$character->slug.'/grant-features']) !!}
                    {!! Form::label('Feature(s)') !!} {!! add_help('Must have at least 1 feature and Quantity must be at least 1.') !!}
                    <div id="featureList">
                        <div class="d-flex mb-2">
                            {!! Form::select('feature_ids[]', $featureOptions, null, ['class' => 'form-control mr-2 default feature-select', 'placeholder' => 'Select Feature']) !!}
                            <a href="#" class="remove-feature btn btn-danger mb-2 disabled">×</a>
                        </div>
                    </div>
                    <div><a href="#" class="btn btn-primary" id="add-feature">Add Feature</a></div>
                    <div class="feature-row hide mb-2">
                        {!! Form::select('feature_ids[]', $featureOptions, null, ['class' => 'form-control mr-2 feature-select', 'placeholder' => 'Select Feature']) !!}
                        <a href="#" class="remove-feature btn btn-danger mb-2">×</a>
                    </div>

                    <h5>Additional Data</h5>

                    <div class="form-group">
                        {!! Form::label('data', 'Reason (Optional)') !!} {!! add_help('A reason for the grant. This will be noted in the logs and in the features description.') !!}
                        {!! Form::text('data', null, ['class' => 'form-control', 'maxlength' => 400]) !!}
                    </div>

                    <div class="text-right">
                        {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
                    </div>

                {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endif

@endsection

@section('scripts')
    @parent
    @include('character._image_js', ['character' => $character])

    <script>

$( document ).ready(function() {
    $('.default.feature-select').selectize();
        $('#add-feature').on('click', function(e) {
            e.preventDefault();
            addFeatureRow();
        });
        $('.remove-feature').on('click', function(e) {
            e.preventDefault();
            removeFeatureRow($(this));
        })
        function addFeatureRow() {
            var $rows = $("#featureList > div")
            if($rows.length === 1) {
                $rows.find('.remove-feature').removeClass('disabled')
            }
            var $clone = $('.feature-row').clone();
            $('#featureList').append($clone);
            $clone.removeClass('hide feature-row');
            $clone.addClass('d-flex');
            $clone.find('.remove-feature').on('click', function(e) {
                e.preventDefault();
                removeFeatureRow($(this));
            })
            $clone.find('.feature-select').selectize();
        }
        function removeFeatureRow($trigger) {
            $trigger.parent().remove();
            var $rows = $("#featureList > div")
            if($rows.length === 1) {
                $rows.find('.remove-feature').addClass('disabled')
            }
        }
});

</script>
@endsection
