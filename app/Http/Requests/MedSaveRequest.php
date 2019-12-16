<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MedSaveRequest extends FormRequest
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
            'med_name' => 'required|unique:medicines',
            'fk_company_id' => 'nullable|numeric',
            'fk_formula_id' => 'nullable|numeric',
            'fk_cat_id' => 'required|numeric'
        ];
        return $rules;
    }

    public function messages()
    {
        $messages = [
            'med_name.required' => 'Medicine Name is required.',
            'med_name.unique' => 'Medicine Name already exists.',

            'fk_company_id.present' => 'Company Name is required.',
            'fk_company_id.numeric' => 'Company id should be numeric.',

            'fk_formula_id.present' => 'Formula Name is required',
            'fk_formula_id.numeric' => 'Formula id should be numeric',

            'fk_cat_id.required' => 'Medicine Category is required',
            'fk_cat_id.numeric' => 'Medicine id should be numeric'

        ];
        return $messages;
    }

}
