<div class="row world-entry">
    @if ($feature->has_image)
        <div class="col-md-3 world-entry-image">
            <a href="{{ $feature->imageUrl }}" data-lightbox="entry" data-title="{{ $feature->name }}">
                <img src="{{ $feature->imageUrl }}" class="world-entry-image" alt="{{ $feature->name }}" />
            </a>
        </div>
    @endif
    <div class="{{ $feature->has_image ? 'col-md-9' : 'col-12' }}">
        <x-admin-edit title="Trait" :object="$feature" />
        <h3>
            {!! $feature->displayName !!}
            <a href="{{ $feature->searchUrl }}" class="world-entry-search text-muted">
                <i class="fas fa-search"></i>
            </a>
        </h3>
        @if ($feature->feature_category_id)
            <div>
                <strong>Category:</strong> {!! $feature->category->displayName !!}
            </div>
        @endif
        @if ($feature->species_id)
            <div>
                <strong>Species:</strong> {!! $feature->species->displayName !!}
                @if ($feature->subtype_id)
                    ({!! $feature->subtype->displayName !!} subtype)
                @endif
            </div>
        @endif
        <div class="world-entry-text parsed-text">
            {!! $feature->parsed_description !!}
        </div>
        @if (count($feature->characters()))
        <h4>Random characters</h4>
            <div class="row">
                @foreach ($feature->characters() as $character)
                    <div class="col-md-3 text-center mb-2">
                        <div>
                            <a href="{{ $character->url }}"><img src="{{ $character->image->thumbnailUrl }}" class="img-thumbnail" alt="{{ $character->fullName }}" /></a>
                        </div>
                        <div class="mt-1">
                            <a href="{{ $character->image->character->url }}" class="h5 mb-0">
                                @if (!$character->image->character->is_visible)
                                    <i class="fas fa-eye-slash"></i>
                                @endif
                                {{ Illuminate\Support\Str::limit($character->image->character->fullName, 20, $end = '...') }}
                            </a>
                        </div>
                        <div class="small">
                            {!! $character->image->character->image->species_id
                                ? $character->image->character->image->species->displayName
                                : 'No Species' !!} ・ {!! $character->image->character->image->rarity_id
                                ? $character->image->character->image->rarity->displayName
                                : 'No Rarity' !!}
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p>No characters found.</p>
        @endif
        @if ($feature->item_id)
            <div class="col text-center">
                <h4>Related item:</h4>
                @if ($feature->item->imageUrl)
                    <div class="world-entry-image"><a href="{{ $feature->item->imageUrl }}" data-lightbox="entry" data-title="{{ $feature->item->name }}"><img src="{{ $feature->item->imageUrl }}" class="world-entry-image" alt="{{ $feature->item->name }}" /></a></div>
                @endif
                <h5>
                {!! $feature->item->name !!}
                    <a href="{{ $feature->item->idUrl }}" class="world-entry-search text-muted">
                        <i class="fas fa-search"></i>
                    </a>
                </h5>
            </div>
        @endif
    </div>
</div>
