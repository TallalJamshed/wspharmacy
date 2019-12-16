<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PriceSaveRequest extends FormRequest
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
            'fk_med_id' => 'required|numeric',
            'sale_price' => 'required|numeric'
        ];
        return $rules;
    }

    public function messages()
    {
        $messages = [
            'fk_med_id.required' => 'Medicine Name is required.',
            'fk_med_id.numeric' => 'Medicine id should be numeric.',

            'sale_price.required' => 'Sale Price is required.',
            'sale_price.numeric' => 'Sale Price should be numeric.'
        ];
        return $messages;
    }

}
