<div class="row world-entry">
    @if ($subtype->subtypeImageUrl)
        <div class="col-md-3 world-entry-image">
            <a href="{{ $subtype->subtypeImageUrl }}" data-lightbox="entry" data-title="{{ $subtype->name }}">
                <img src="{{ $subtype->subtypeImageUrl }}" class="world-entry-image" alt="{{ $subtype->name }}" />
            </a>
        </div>
    @endif
    <div class="{{ $subtype->subtypeImageUrl ? 'col-md-9' : 'col-12' }}">
        <x-admin-edit title="Subtype" :object="$subtype" />
        <h3>
            @if (!$subtype->is_visible)
                <i class="fas fa-eye-slash mr-1"></i>
            @endif
            {!! $subtype->displayName !!} ({!! $subtype->species->displayName !!} Subtype)
            <a href="{{ $subtype->searchUrl }}" class="world-entry-search text-muted">
                <i class="fas fa-search"></i>
            </a>
        </h3>
        <div class="world-entry-text">
            {!! $subtype->parsed_description !!}
        </div>
        <h5 class="inventory-header">
            Related Traits
            <a class="small collapse-toggle collapsed" href="#alt-{{ $subtype->id }}" data-toggle="collapse">Show</a></h3>
        </h5>
        <div class="collapse" id="alt-{{ $subtype->id }}">
            @if ($subtype->features->count())
                @php
                    $traitgroup = $subtype->features()->get()->groupBy('feature_category_id');
                @endphp
                <div class="row">
                    @if ($subtype->features->count())
                        @foreach ($traitgroup as $key => $group)
                            <div class="mb-2 col-md-4">
                                @if ($key)
                                    <strong>{!! $group->first()->category->displayName !!}:</strong>
                                @else
                                    <strong>Miscellaneous:</strong>
                                @endif
                                @foreach ($group as $feature)
                                    <div>{!! $feature->displayName !!} @if ($feature->data)
                                            ({{ $feature->data }})
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    @endif
                </div>
            @endif
        </div>
        @if ($subtype->featureAssociations()->count())
            @include('widgets._feature_associations', ['object' => $subtype])
        @endif
    </div>
</div>
