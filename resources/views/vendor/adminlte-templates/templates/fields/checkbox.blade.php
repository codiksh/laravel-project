<!-- {{ $fieldTitle }} Field -->
<div class="form-group col-sm-6">
    <div class="form-check">
        @{!! html()->hidden('{{ $fieldName }}', 0) !!}
        @{!! html()->checkbox('{{ $fieldName }}', '{{ $checkboxVal }}', null)->class('form-check-input') !!}
        @{!! html()->label('{{ $fieldName }}', '{{ $fieldTitle }}')->class('form-check-label') !!}
    </div>
</div>