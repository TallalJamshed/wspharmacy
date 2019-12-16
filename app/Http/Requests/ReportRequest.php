<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportRequest extends FormRequest
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
            'start_date' => 'present|date|nullable',
            'end_date' => 'present|date|nullable|after_or_equal:start_date',
            'cust_id' => 'present|numeric|nullable|exists:customers',
        ];
    }
    public function messages(){
        return [
            'start_date.present' => 'Start Date should be present.',
            'end_date.present' => 'End Date should be present.',
            'start_date.date' => 'Start Date should be in date formate.',
            'end_date.date' => 'End Date should be in date formate.',
            'end_date.after_or_equal' => 'End Date should be equal to or comes after Start Date.',
            'cust_id.present' => 'Customer Id should be present.',
            'cust_id.numeric' => 'Customer Id should be a number.',
            'cust_id.exists' => 'Customer Id does not exist in database.'
        ];
    }
}
