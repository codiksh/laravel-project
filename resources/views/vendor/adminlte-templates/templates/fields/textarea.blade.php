<!-- {{ $fieldTitle }} Field -->
<div class="form-group col-sm-12 col-lg-12">
    @if($config->options->localized)
        @{!! html()->label(__('models/{{ $config->modelNames->camelPlural }}.fields.{{ $fieldName }}'))->for('{{ $fieldName }}') !!}
    @else
        @{!! html()->label('{{ $fieldTitle }}')->for('{{ $fieldName }}') !!}
    @endif
        @{!! html()->textarea('{{ $fieldName }}', null)->class('form-control') !!}
</div>