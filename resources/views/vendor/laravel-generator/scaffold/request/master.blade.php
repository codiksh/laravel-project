@php
    echo "<?php".PHP_EOL;
@endphp

namespace {{ $config->namespaces->request }}\{{ $config->modelNames->name }};

use App\Http\Requests\BaseRequest;
use {{ $config->namespaces->model }}\{{ $config->modelNames->name }};
use {{ $config->namespaces->repository }}\{{ $config->modelNames->name }}Repository;

class MasterRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return {{ $config->modelNames->name }}::$rules;
    }

    /**
     * Handle an incoming request.
     */
    public function prepareForValidation() {
        $this->merge({{ $config->modelNames->name }}Repository::requestHandler($this));
    }
}
