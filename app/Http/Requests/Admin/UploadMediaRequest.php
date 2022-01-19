<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UploadMediaRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];
        switch(self::getCaseFromUuid($this->input('validationCase'))) {
            case 'single_image_1MB' :
                $rules = [
                    'file' => 'required|image|max:1024',
                ];
                break;
            case 'single_image_2MB' :
                $rules = [
                    'file' => 'required|image|max:2048',
                ];
                break;
        }
        return $rules;
    }

    public static function getCaseFromUuid($uuid)
    {
        switch($uuid){
            case "b0a489a5-bb3c-4e02-9217-d70c57845768": return 'single_image_2MB';

            default: return 'single_image_1MB';
        }
    }
}
