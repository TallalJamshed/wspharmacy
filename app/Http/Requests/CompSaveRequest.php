<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompSaveRequest extends FormRequest
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
            'company_name' => 'required|unique:companies', 
        ];
        return $rules;
    }

    public function messages(){
        $messages = [
            'required' => 'Company Name is required.',
            'unique' => 'Company Name Already Exist'
        ];
        return $messages;
    }
    
}
