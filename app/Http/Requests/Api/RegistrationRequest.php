<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\BaseRequest;
use App\Models\User;
use App\Repositories\Admin\UserRepository;

class RegistrationRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = User::$rules;
        unset($rules['role']);
        unset($rules['role.*']);
        return $rules;
    }

    protected function prepareForValidation()
    {
        $this->merge(UserRepository::requestHandler($this));
    }
}
