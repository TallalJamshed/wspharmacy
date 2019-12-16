<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpSaveRequest extends FormRequest
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
            'fk_meds_id' => 'required|numeric',
            'expiry_date' => 'required|date'
        ];
        return $rules;
    }

    public function messages(){
        $messages = [
            'fk_meds_id.required' => 'Medicine is required.',
            'fk_meds_id.numeric' => 'Medicine id should be numeric.',

            'expiry_date.required' => 'Expiry Date is required.',
            'expiry_date.date' => 'Expiry Date should be a date.'
        ];
        return $messages;
    }
}
