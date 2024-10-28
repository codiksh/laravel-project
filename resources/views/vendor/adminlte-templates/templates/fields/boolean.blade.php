<!-- 'Boolean {{ $fieldTitle }} Field' checked by default -->
<div class="form-group col-sm-6">
    @if($config->options->localized)
        @{!! html()->label(__('models/{{ $config->modelNames->camelPlural }}.fields.{{ $fieldName }}'))->for('{{ $fieldName }}') !!}
    @else
        @{!! html()->label('{{ $fieldTitle }}')->for('{{ $fieldName }}') !!}
    @endif
    <label class="checkbox-inline">
        @{!! html()->checkbox('{{ $fieldName }}', 1, true) !!}
        </label>
</div>
