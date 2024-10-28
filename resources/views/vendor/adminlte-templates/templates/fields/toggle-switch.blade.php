<!-- 'bootstrap / Toggle Switch {{ $fieldTitle }} Field' -->
<div class="form-group col-sm-6">
        <div class="custom-control custom-switch">
                @{!! html()->checkbox('{{ $fieldName }}', 1, null)->class('custom-control-input') !!}
        @if($config->options->localized)
                @{!! html()->label(__('models/{{ $config->modelNames->camelPlural }}.fields.{{ $fieldName }}'))->for('{{ $fieldName }}')->class('custom-control-label') !!}
        @else
                @{!! html()->label('{{ $fieldTitle }}')->for('{{ $fieldName }}')->class('custom-control-label') !!}
        @endif
        </div>
</div>