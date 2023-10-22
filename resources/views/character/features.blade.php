@extends('character.layout', ['isMyo' => $character->is_myo_slot])

@section('profile-title')
    {{ $character->fullName }}'s Bank
@endsection

@section('meta-img')
    {{ $character->image->thumbnailUrl }}
@endsection

@section('profile-content')
    {!! breadcrumbs([
        $character->category->masterlist_sub_id
            ? $character->category->sublist->name . ' Masterlist'
            : 'Character masterlist' => $character->category->masterlist_sub_id
            ? 'sublist/' . $character->category->sublist->key
            : 'masterlist',
        $character->fullName => $character->url,
        'Bank' => $character->url . '/bank',
    ]) !!}

    @include('character._header', ['character' => $character])
    <div class="text-center">
        <h3>
            @if (Auth::check() && Auth::user()->hasPower('edit_inventories'))
                <a href="#" class="float-right btn btn-outline-info btn-sm" id="giveButton"><i class="fas fa-cog"></i>
                    Grant Traits (Admin)
                </a>
                <a href="#" class="float-right btn btn-outline-info btn-sm" id="takeButton"><i class="fas fa-cog"></i>
                    Remove Traits (Admin)
                </a>
            @endif
            {!! $character->displayName !!}'s Traits
        </h3>
        <p>Please note that these aren't an official trait list for the character, these are merely what traits have been
            unlocked by this character and can be used in future design updates or changes.</p>
    </div>
    @if ($default->count())
        <h4>Default</h4>
        <div class="card-body p-2 row">
            @foreach ($default as $feature)
                <div class="col-lg-3 col-sm-4 col-12">
                    <ul class="mb-0">
                        <li>
                            @if ($feature->has_image)
                                <img src="{{ $feature->imageUrl }}" style="height: 25px;" alt="{{ $feature->name }}" />
                            @endif
                            {!! $feature->displayName !!}
                        </li>
                    </ul>
                </div>
            @endforeach
        </div>
    @endif
    @if ($character->unlockedTraits->count())
        <h4>Unlocked by {!! $character->displayName !!}</h4>
        <div class="card-body p-2 row">
            @foreach ($character->unlockedTraits as $feature)
                <div class="col-lg-3 col-sm-4 col-12">
                    <ul class="mb-0">
                        <li>
                            @if ($feature->feature->has_image)
                                <img src="{{ $feature->feature->imageUrl }}" style="height: 25px;"
                                    alt="{{ $feature->feature->name }}" />
                            @endif
                            {!! $feature->feature->displayName !!}
                        </li>
                    </ul>
                </div>
            @endforeach
        </div>
    @endif

    @if (Auth::check() && Auth::user()->hasPower('edit_inventories'))
        <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content hide" id="giveContent">
                    <div class="modal-header">
                        <span class="modal-title h5 mb-0">[ADMIN] Grant Traits</span>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>This will credit the traits to the character's unlocked traits list.</p>
                        <div class="form-group">
                            {!! Form::open(['url' => 'admin/character/' . $character->slug . '/grant-features']) !!}
                            {!! Form::label('Traits(s)') !!}
                            <div id="featureListGive">
                                <div class="d-flex mb-2">
                                    {!! Form::select('feature_ids[]', $featureOptions, null, [
                                        'class' => 'form-control mr-2 default feature-select',
                                        'placeholder' => 'Select Trait',
                                    ]) !!}
                                    <a href="#" class="remove-feature btn btn-danger mb-2 disabled">×</a>
                                </div>
                            </div>
                            <div><a href="#" class="btn btn-primary" id="add-feature">Add Trait</a></div>
                            <div class="feature-row hide mb-2">
                                {!! Form::select('feature_ids[]', $featureOptions, null, [
                                    'class' => 'form-control mr-2 feature-select',
                                    'placeholder' => 'Select Trait',
                                ]) !!}
                                <a href="#" class="remove-feature btn btn-danger mb-2">×</a>
                            </div>

                            <div class="text-right">
                                {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
                            </div>

                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
                <div class="modal-content hide" id="takeContent">
                    <div class="modal-header">
                        <span class="modal-title h5 mb-0">[ADMIN] Remove Traits</span>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>This will remove the traits from the character's unlocked traits list. You cannot debit default
                            traits.</p>
                        <div class="form-group">
                            {!! Form::open(['url' => 'admin/character/' . $character->slug . '/take-features']) !!}
                            {!! Form::label('Traits(s)') !!}
                            <div id="featureListRemove">
                                <div class="d-flex mb-2">
                                    {!! Form::select('feature_ids[]', $takeFeatureOptions, null, [
                                        'class' => 'form-control mr-2 default feature-select',
                                        'placeholder' => 'Select Trait',
                                    ]) !!}
                                    <a href="#" class="remove-remove-feature btn btn-danger mb-2 disabled">×</a>
                                </div>
                            </div>
                            <div><a href="#" class="btn btn-primary" id="add-remove-feature">Add Trait</a></div>
                            <div class="feature-remove-row hide mb-2">
                                {!! Form::select('feature_ids[]', $takeFeatureOptions, null, [
                                    'class' => 'form-control mr-2 feature-select',
                                    'placeholder' => 'Select Trait',
                                ]) !!}
                                <a href="#" class="remove-remove-feature btn btn-danger mb-2">×</a>
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
    <script>
        $(document).ready(function() {
            var $confirmationModal = $('#confirmationModal');
            var $submissionForm = $('#submissionForm');

            var $giveButton = $('#giveButton');
            var $giveContent = $('#giveContent');

            var $takeButton = $('#takeButton');
            var $takeContent = $('#takeContent');


            // Buttons that pop-up the modals for removing/adding traits
            $giveButton.on('click', function(e) {
                e.preventDefault();
                $giveContent.removeClass('hide');
                $takeContent.addClass('hide');
                $confirmationModal.modal('show');
            });

            $takeButton.on('click', function(e) {
                e.preventDefault();
                $takeContent.removeClass('hide');
                $giveContent.addClass('hide');
                $confirmationModal.modal('show');
            });

            // Adding rows to the "give" option.
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
                var $rows = $("#featureListGive > div")
                if ($rows.length === 1) {
                    $rows.find('.remove-feature').removeClass('disabled')
                }
                var $clone = $('.feature-row').clone();
                $('#featureListGive').append($clone);
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
                var $rows = $("#featureListGive > div")
                if ($rows.length === 1) {
                    $rows.find('.remove-feature').addClass('disabled')
                }
            }

            // Adding rows to the "take" option.
            $('.default.feature-select-take').selectize();
            $('#add-remove-feature').on('click', function(e) {
                e.preventDefault();
                addFeatureRemoveRow();
            });
            $('.remove-remove-feature').on('click', function(e) {
                e.preventDefault();
                removeFeatureRow($(this));
            })

            function addFeatureRemoveRow() {
                var $rows = $("#featureListRemove > div")
                if ($rows.length === 1) {
                    $rows.find('.remove-remove-feature').removeClass('disabled')
                }
                var $clone = $('.feature-remove-row').clone();
                $('#featureListRemove').append($clone);
                $clone.removeClass('hide feature-remove-row');
                $clone.addClass('d-flex');
                $clone.find('.remove-remove-feature').on('click', function(e) {
                    e.preventDefault();
                    removeFeatureRow($(this));
                })
                $clone.find('.feature-select-take').selectize();
            }
        });
    </script>
@endsection
