<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CatSaveRequest extends FormRequest
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
        $rules = [
            'cat_name' => 'required|unique:categories',
        ];
        return $rules;
    }

    public function messages()
    {
        $messages = [
            'required' => 'Category Name is required.',
            'unique' => 'Category Name Already Exist'
        ];
        return $messages;
    }
}
