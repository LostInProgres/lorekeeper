<div class="row world-entry">
    @if ($imageUrl)
        <div class="col-md-3 world-entry-image"><a href="{{ $imageUrl }}" data-lightbox="entry" data-title="{{ $name }}"><img src="{{ $imageUrl }}" class="world-entry-image" alt="{{ $name }}" /></a></div>
    @endif
    <div class="{{ $imageUrl ? 'col-md-9' : 'col-12' }}">
        <h3>{!! $name !!}

            <div class="float-right small">
                @if (isset($searchFeaturesUrl) && $searchFeaturesUrl)
                    <a href="{{ $searchFeaturesUrl }}" class="world-entry-search text-muted small"><i class="fas fa-search"></i> Traits</a>
                @endif
                @if (isset($searchCharactersUrl) && $searchCharactersUrl)
                    <a href="{{ $searchCharactersUrl }}" class="world-entry-search text-muted small ml-4"><i class="fas fa-search"></i> Characters</a>
                @endif
                @if (isset($edit))
                    <x-admin-edit title="{{ $edit['title'] }}" :object="$edit['object']" />
                @endif
            </div>

        </h3>
        <div class="world-entry-text">
            {!! $description !!}
        </div>
        @if (Config::get('lorekeeper.traits_expanded.rarity_examples'))
            <h4>Characters with {{ $rarity->name }}:</h4>
            @if (count($rarity->randomCharacters()))
                <div class="row">
                    @foreach ($rarity->randomCharacters() as $character)
                    @dd($character)
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
        @if ($rarity->featureAssociations()->count() && Config::get('lorekeeper.traits_expanded.rarity_associations'))
            @include('widgets._feature_associations', ['object' => $rarity])
        @endif
    </div>
</div>
