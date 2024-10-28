<!-- {{ $fieldTitle }} Field -->
<div class="form-group col-sm-6">
    @if($config->options->localized)
        @{!! html()->label(__('models/{{ $config->modelNames->camelPlural }}.fields.{{ $fieldName }}').':')
            ->for('{{ $fieldName }}') !!}
    @else
        @{!! html()->label('{{ $fieldTitle }}:')
            ->for('{{ $fieldName }}') !!}
    @endif
        @{!! html()->text('{{ $fieldName }}')
            ->class('form-control')
            ->id('{{ $fieldName }}') !!}
</div>

@@push('page_scripts')
    <script type="text/javascript">
        $('#{{ $fieldName }}').datepicker()
    </script>
@@endpush