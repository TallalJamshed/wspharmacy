<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class paysaverequest extends FormRequest
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
        return [
            'ledger_id' => 'required|numeric',
            'cust_name' => 'required',
            // 'payment_date' => 'required|date',
            'total_bill' => 'required|numeric',
            'payment' => 'required|numeric',
            'discount' => 'required|numeric',
            'courier_paid' => 'required|numeric'
        ];
    }

    public function messages(){
        return [
            'ledger_id.required' => 'Ledger Id is required',
            'ledger_id.numeric' => 'Ledger Id should be numeric',
            'cust_name.required' => 'Customer Name is required',
            // 'payment_date.required' => 'Payment Date is required',
            // 'payment_date.date' => 'Payment Date should be a valid date',
            'total_bill.required' => 'Total Bill is required',
            'total_bill.numeric' => 'Total Bill should be a numeric value',
            'payment.required' => 'Paid Amount is required',
            'payment.numeric' => 'Paid Amount should be a numeric value',
            'discount.required' => 'Discount is required',
            'dicount.numeric' => 'Discount should be a numeric value',
            'courier_paid.required' => 'Courier charges are required',
            'courier_paid.numeric' => 'Courier charges should be a numeric number'
        ];
    }
}
