{!! Form::open(['url' => 'admin/data/expanded-traits/edit/' . base64_encode(urlencode(get_class($object))) . '/' . $object->id]) !!}

@php
    $items = \App\Models\Item\Item::orderBy('name')->pluck('name', 'id');
    $features = \App\Models\Feature\Feature::orderBy('name')->pluck('name', 'id');
@endphp

<hr style="margin-top: 3em;">

<div class="card mb-3">
    <div class="card-header h2">
        <a href="#" class="btn btn-outline-info float-right" id="addAssociation">Add Association</a>
        Associations
    </div>
    <div class="card-body" style="clear:both;">
        <p>These are items/traits/etc you can associate with this {{ $type }}. Usually what applies this {{ $type }}, but not always.</p>
        <table class="table table-sm" id="associationTable">
            <thead>
                <tr>
                    <th width="15%">Association Type</th>
                    <th width="35%">Association</th>
                    <th width="40%">Summary{!! add_help('Short summary (256 chars or less) that will show underneath this association.') !!}</th>
                    <th width="10%"></th>
                </tr>
            </thead>
            <tbody id="associationTableBody">
                @if ($associations)
                    @foreach ($associations as $association)
                        <tr class="association-row">
                            <td>{!! Form::select('association_type[]', ['Item' => 'Item', 'Trait' => 'Trait'], $association->association_type, [
                                'class' => 'form-control associate-type',
                                'placeholder' => 'Select Type',
                            ]) !!}</td>
                            <td class="association-row-select">
                                @if ($association->association_type == 'Item')
                                    {!! Form::select('association_id[]', $items, $association->association_id, ['class' => 'form-control item-select selectize', 'placeholder' => 'Select Item']) !!}
                                @elseif ($association->association_type == 'Trait')
                                    {!! Form::select('association_id[]', $features, $association->association_id, ['class' => 'form-control feature-select selectize', 'placeholder' => 'Select Trait']) !!}
                                @endif
                            </td>
                            <td>{!! Form::text('association_summary[]', $association->association_summary, ['class' => 'form-control']) !!}</td>
                            <td class="text-right"><a href="#" class="btn btn-danger remove-association-button">Remove</a></td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>

<div class="text-right">
    {!! Form::submit('Edit', ['class' => 'btn btn-primary']) !!}
</div>

{!! Form::close() !!}

<hr style="margin-bottom: 3em;">

<div id="associationRowData" class="hide">
    <table class="table table-sm">
        <tbody id="associationRow">
            <tr class="association-row">
                <td>{!! Form::select('association_type[]', ['Item' => 'Item', 'Trait' => 'Trait'], null, [
                    'class' => 'form-control associate-type',
                    'placeholder' => 'Select Type',
                ]) !!}</td>
                <td class="association-row-select"></td>
                <td>{!! Form::text('association_summary[]', null, ['class' => 'form-control']) !!}</td>
                <td class="text-right"><a href="#" class="btn btn-danger remove-association-button">Remove</a></td>
            </tr>
        </tbody>
    </table>
    {!! Form::select('association_id[]', $items, null, ['class' => 'form-control item-select', 'placeholder' => 'Select Item']) !!}
    {!! Form::select('association_id[]', $features, null, ['class' => 'form-control feature-select', 'placeholder' => 'Select Trait']) !!}
</div>


<script>
    $(document).ready(function() {
        var $associationTable = $('#associationTableBody');
        var $associationRow = $('#associationRow').find('.association-row');
        var $itemSelect = $('#associationRowData').find('.item-select');
        var $featureSelect = $('#associationRowData').find('.feature-select');

        $('#associationTableBody .selectize').selectize();
        attachRemoveListener($('#associationTableBody .remove-association-button'));

        $('#addAssociation').on('click', function(e) {
            e.preventDefault();
            var $clone = $associationRow.clone();
            $associationTable.append($clone);
            attachAssociateTypeListener($clone.find('.associate-type'));
            attachRemoveListener($clone.find('.remove-association-button'));
        });

        $('.associate-type').on('change', function(e) {
            var val = $(this).val();
            var $cell = $(this).parent().parent().find('.association-row-select');

            var $clone = null;
            if (val == 'Item') $clone = $itemSelect.clone();
            else if (val == 'Trait') $clone = $featureSelect.clone();

            $cell.html('');
            $cell.append($clone);
        });

        function attachAssociateTypeListener(node) {
            node.on('change', function(e) {
                var val = $(this).val();
                var $cell = $(this).parent().parent().find('.association-row-select');

                var $clone = null;
                if (val == 'Item') $clone = $itemSelect.clone();
                else if (val == 'Trait') $clone = $featureSelect.clone();

                $cell.html('');
                $cell.append($clone);
                $clone.selectize();
            });
        }

        function attachRemoveListener(node) {
            node.on('click', function(e) {
                e.preventDefault();
                $(this).parent().parent().remove();
            });
        }

    });
</script>
