<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;
use App\Repositories\Admin\UserRepository;

class UpdateUserPasswordRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules['password'] = 'required';
        return $rules;
    }

    /**
     * Handle an incoming request.
     */
    public function prepareForValidation()
    {
        $this->merge(UserRepository::requestHandler($this));
    }

}
