<!-- {{ $fieldTitle }} Field -->
<div class="form-group col-sm-12">
    @if($config->options->localized)
        @{!! html()->label(
            __('models/{{ $config->modelNames->camelPlural }}.fields.{{ $fieldName }}'))->for('{{ $fieldName }}')->class('form-check-label') !!}
    @else
        @{!! html()->label('{{ $fieldTitle }}')->for('{{ $fieldName }}')->class('form-check-label') !!}
    @endif
    {!! $radioButtons !!}
</div>