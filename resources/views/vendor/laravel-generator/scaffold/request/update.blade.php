@php
    echo "<?php".PHP_EOL;
@endphp

namespace {{ $config->namespaces->request }}\{{ $config->modelNames->name }};

class UpdateRequest extends MasterRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        $rules = parent::rules();
        {!! $uniqueRules !!}
        return $rules;
    }
}
