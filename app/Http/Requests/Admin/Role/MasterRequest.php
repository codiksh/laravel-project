<?php

namespace App\Http\Requests\Admin\Role;

use App\Http\Requests\BaseRequest;
use App\Repositories\Admin\RoleRepository;

class MasterRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|unique:roles,name',
        ];
    }

    /**
     * Handle an incoming request.
     */
    public function prepareForValidation()
    {
        $this->merge(RoleRepository::requestHandler($this));
    }
}
