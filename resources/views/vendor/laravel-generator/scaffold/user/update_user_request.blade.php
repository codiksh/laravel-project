@php
    echo "<?php".PHP_EOL;
@endphp

namespace {{ config('laravel_generator.namespace.request') }};

use App\Http\Requests\BaseRequest;

class UpdateUserRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->route('user');
        $rules = [
          'name'     => 'required',
          'email'    => 'required|email|unique:users,email,'.$id,
          'password' => 'confirmed'
        ];

        return $rules;
    }
}
