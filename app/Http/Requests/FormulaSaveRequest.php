<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormulaSaveRequest extends FormRequest
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
            'formula_name' => 'required|unique:formulas',
        ];
        return $rules;
    }

    public function messages()
    {
        $messages = [
            'formula_name.required' => 'Formula Name is required.',
            'formula_name.unique' => 'Formula Name already exists.',

        ];
        return $messages;
    }

}
