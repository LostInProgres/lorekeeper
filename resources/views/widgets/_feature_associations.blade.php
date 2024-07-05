<div class="row justify-content-center mx-0 px-0 mt-3">
    <hr class="w-75" />
    @foreach ($object->featureAssociations->groupBy('association_type') as $type => $association)
        <div class="text-center col-md-4 mb-3">
            <h5>Related {{ $type }}s:</h5>
            @foreach ($association as $related)
                {!! $related->object->displayName !!}
                <br>
                @if ($related->association_summary)
                    ({{ $related->association_summary }})
                @endif
                <br>
            @endforeach
        </div>
    @endforeach
</div>
