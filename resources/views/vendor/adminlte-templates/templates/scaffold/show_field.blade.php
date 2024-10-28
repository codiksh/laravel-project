<!-- {{ $fieldTitle }} Field -->
<div class="col-sm-12">
    @if($config->options->localized)
        @{!! html()->label(
            __('models/{{ $config->modelNames->camelPlural }}.fields.{{ $fieldName }}'))->for('{{ $fieldName }}') !!}
    @else
        @{!! html()->label('{{ $fieldTitle }}')->for('{{ $fieldName }}') !!}
    @endif
    <p>@{{ ${!! $config->modelNames->camel !!}->{!! $fieldName !!} }}</p>
</div>
