<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalesRequest extends FormRequest
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
            'fk_cust_id' => 'required|numeric',
            // 'sale_date' => 'required|date',
            'courier_service' => 'required|numeric',
            // 'discount' => 'required|numeric|digits_between:1,100',
            // 'discountedbill' => 'required|numeric'
        ]; 
           
        foreach($this->request->get('fk_med_id') as $key => $val)
        {
            $rules['fk_med_id.'.$key] = 'required|numeric';
        }
        // foreach($this->request->get('price') as $key => $val)
        // {
        //     $rules['price.'.$key] = 'required|numeric';
        // }
        foreach($this->request->get('sale_price') as $key => $val)
        {
            $rules['sale_price.'.$key] = 'required';
        }
        foreach($this->request->get('sale_quantity') as $key => $val)
        {
            $rules['sale_quantity.'.$key] = 'required|numeric';
        }
        foreach($this->request->get('total_price') as $key => $val)
        {
            $rules['total_price.'.$key] = 'required|numeric';
        }
        // foreach($this->request->get('sale_price') as $key => $val)
        // {
        //     $rules['sale_price.'.$key] = 'required';
        // }
        return $rules;
    }

    public function messages()
    {
        $messages = [
            'fk_cust_id.required' => 'Customer Name is required.',
            'fk_cust_id.numeric' => 'Customer ID should be numeric.',
            // 'sale_date.required' => 'Sale Date is required.',
            // 'sale_date.date' => 'Sale Date should be a valid date formate.',
            'courier_service.required' => 'Courier service charges are required.',
            'courier_service.numeric' => 'Courier service charges should be numeric.',
            // 'discount.required' => 'Discount Percentage is required',
            // 'discount.numeric' => 'Discount Percentage should be a number',
            // 'discount.digits_between' => 'Discount Percentage should be in the range on 1 to 100',
            // 'discountedbill.required' => 'Discounted Bill is required',
            // 'discountedbill.numeric' => 'Discounted Bill should be numeric'
        ];
        foreach($this->request->get('fk_med_id') as $key => $val)
        {
            $messages['fk_med_id.'.$key.'.required'] = 'Medicine Name is required.';
            $messages['fk_med_id.'.$key.'.numeric'] = 'Medicine ID should be numeric.';

        }
        // foreach($this->request->get('price') as $key => $val)
        // {
        //     $messages['price.'.$key.'.required'] = 'Intended Price is required.';
        //     $messages['price.'.$key.'.numeric'] = 'Intended Price should be numeric.';
        // }
        foreach($this->request->get('sale_price') as $key => $val)
        {
            $messages['sale_price.'.$key.'.required'] = 'Sale Price is required.';
        }
        foreach($this->request->get('sale_quantity') as $key => $val)
        {
            $messages['sale_quantity.'.$key.'.required'] = 'Sale Quantity is required.';
            $messages['sale_quantity.'.$key.'.numeric'] = 'Sale Quantity should be numeric.';

        }
        foreach($this->request->get('total_price') as $key => $val)
        {
            $messages['total_price.'.$key.'.required'] = 'Total Price is required.';
            $messages['total_price.'.$key.'.numeric'] = 'Total Price should be numeric.';

        }
        // foreach($this->request->get('sale_price') as $key => $val)
        // {
        //     $messages['sale_price.'.$key.'.required'] = 'Sale Price is required.';
        // }
        return $messages;
    }
}
