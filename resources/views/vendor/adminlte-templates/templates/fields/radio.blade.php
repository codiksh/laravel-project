<label class="form-check">
    @{!! html()->radio('{{ $fieldName }}', "{{ $value }}", null)->class('form-check-input') !!} {{ $label }}
</label>