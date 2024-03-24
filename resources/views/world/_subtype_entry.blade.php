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
    </div>
    @if ($subtype->item_id)
        <div class="col text-center">
            <h4>Related item:</h4>
            @if ($subtype->item->imageUrl)
                <div class="world-entry-image"><a href="{{ $subtype->item->imageUrl }}" data-lightbox="entry" data-title="{{ $subtype->item->name }}"><img src="{{ $subtype->item->imageUrl }}" class="world-entry-image" alt="{{ $subtype->item->name }}" /></a></div>
            @endif
            <h5>
            {!! $subtype->item->name !!}
                <a href="{{ $subtype->item->idUrl }}" class="world-entry-search text-muted">
                    <i class="fas fa-search"></i>
                </a>
            </h5>
        </div>
    @endif
</div>
