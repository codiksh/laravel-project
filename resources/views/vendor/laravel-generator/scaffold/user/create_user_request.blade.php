@php
    echo "<?php".PHP_EOL;
@endphp

namespace {{ config('laravel_generator.namespace.request') }};

use App\Http\Requests\BaseRequest;

class CreateUserRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
       $rules = [
          'name'                  => 'required',
          'email'                 => 'required|email|unique:users,email',
          'password'              => 'required|confirmed'
       ];

        return $rules;
    }
}
