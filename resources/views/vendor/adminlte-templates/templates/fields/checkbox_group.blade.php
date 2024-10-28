<!-- {{ $fieldTitle }} Field -->
<div class="form-group col-sm-12">
    @if($config->options->localized)
        @{!! html()->label(__('models/{{ $config->modelNames->camelPlural }}.fields.{{ $fieldName }}'))->for('{{ $fieldName }}') !!}
    @else
        @{!! html()->label('{{ $fieldTitle }}')->for('{{ $fieldName }}') !!}
    @endif
    @if($config->options->localized)
        @{!! html()->label(__('models/{{ $config->modelNames->camelPlural }}.fields.{{ $fieldName }}'))->for('{{ $fieldName }}') !!}
    @else
        @{!! html()->label('{{ $fieldTitle }}')->for('{{ $fieldName }}') !!}
    @endif
    {!! $checkboxes !!}
</div>