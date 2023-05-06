<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class BaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Overridden
     * To add, additional Error Hooks
     *
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function (Validator $validator) {
            $this->afterValidation($validator);
        });
    }

    /**
     * function to manage after-request-has-been-validated.
     * @param $validator
     */
    protected function afterValidation($validator)
    {
        //
    }
}
