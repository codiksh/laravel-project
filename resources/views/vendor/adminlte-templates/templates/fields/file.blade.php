<!-- {{ $fieldTitle }} Field -->
<div class="form-group col-sm-6">
    @if($config->options->localized)
        @{!! html()->label(__('models/{{ $config->modelNames->camelPlural }}.fields.{{ $fieldName }}').':')
            ->for('{{ $fieldName }}') !!}
    @else
        @{!! html()->label('{{ $fieldTitle }}:')
            ->for('{{ $fieldName }}') !!}
    @endif
        <div class="input-group">
            <div class="custom-file">
                @{!! html()->file('{{ $fieldName }}')
                    ->class('custom-file-input')
                    ->id('{{ $fieldName }}') !!}
                @{!! html()->label('Choose file')
                    ->for('{{ $fieldName }}')
                    ->class('custom-file-label') !!}
            </div>
        </div>
</div>
<div class="clearfix"></div>