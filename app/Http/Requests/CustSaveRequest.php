<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustSaveRequest extends FormRequest
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
            'fk_cust_cat_id'=>'required|numeric',
            'cust_name'=>'required|regex:/^[a-zA-Z ]+$/',
            // 'cust_email'=>'present|email|unique:customers|nullable',
            // 'cust_phoneno'=>'required|numeric|unique:customers|digits_between:10,11',
            'cust_address'=>'present|nullable',
        ];
        return $rules;
    }
    public function messages(){
        $messages = [
            'fk_cust_cat_id.required' => 'Customer Category is required',
            'fk_cust_cat_id.numeric' => 'Customer category should be numeric',

            'cust_name.required' => 'Customer Name is required',
            'cust_name.regex' => 'Customer Name cannot contain numbers or special characters ',

            // 'cust_email.present' => 'Customer Email should be present',
            // 'cust_email.email' => 'Customer Email should be in Email Formate',
            // 'cust_email.unique' => 'Customer Email is already in use',

            // 'cust_phoneno.required' => 'Customer Phone Number is required',
            // 'cust_phoneno.numeric' => 'Customer Phone Number should be numeric',
            // 'cust_phoneno.unique' => 'Customer Phone Number is already in use',
            // 'cust_phoneno.digits_between' => 'Phone Number length is invalid',
            
            'cust_address.present' => 'Customer Address should be present',
        ];
        return $messages;
    }
}
