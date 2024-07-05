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
        @if (Config::get('lorekeeper.traits_expanded.subtype_examples'))
            <h4>Characters with {{ $subtype->name }}:</h4>
            @if (count($subtype->randomCharacters()))
                <div class="row">
                    @foreach ($subtype->randomCharacters() as $character)
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
                                {!! $character->image->character->image->species_id ? $character->image->character->image->species->displayName : 'No Species' !!} ・ {!! $character->image->character->image->rarity_id ? $character->image->character->image->rarity->displayName : 'No Rarity' !!}
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p>No characters found.</p>
            @endif
        @endif
        @if ($subtype->featureAssociations()->count() && Config::get('lorekeeper.traits_expanded.subtype_associations'))
            @include('widgets._feature_associations', ['object' => $subtype])
        @endif
    </div>
</div>
