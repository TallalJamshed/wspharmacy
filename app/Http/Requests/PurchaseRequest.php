<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
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
            'invoice_no' => 'required',
            'fk_vendor_id' => 'required|numeric',
            // 'purchase_date' => 'required|date'
        ];    
        foreach($this->request->get('fk_med_id') as $key => $val)
        {
            $rules['fk_med_id.'.$key] = 'required|numeric';
        }
        foreach($this->request->get('pkt_quantity') as $key => $val)
        {
            $rules['pkt_quantity.'.$key] = 'required|numeric';
        }
        foreach($this->request->get('quantity_per_pkt') as $key => $val)
        {
            $rules['quantity_per_pkt.'.$key] = 'required|numeric';
        }
        foreach($this->request->get('pkt_price') as $key => $val)
        {
            $rules['pkt_price.'.$key] = 'required|numeric';
        }
        foreach($this->request->get('purchse_price') as $key => $val)
        {
            $rules['purchse_price.'.$key] = 'required|numeric';
        }
        // if(!empty($this->request->get('expiry_date'))){
            foreach($this->request->get('expiry_date') as $key => $val)
            {
                $rules['expiry_date.'.$key] = 'present|nullable';
            }
        // }
        return $rules;
    }

    public function messages()
    {
        $messages = [
            'invoice_no.required' => 'Invoice Number is required.',
            'fk_vendor_id.required' => 'Vendor is required.',
            'fk_vendor_id.numeric' => 'Vendor id should be a valid number.'

        ];
        foreach($this->request->get('fk_med_id') as $key => $val)
        {
            $messages['fk_med_id.'.$key.'.required'] = 'Medicine Name is required.';
            $messages['fk_med_id.'.$key.'.numeric'] = 'Medicine id should be numeric.';

        }
        foreach($this->request->get('pkt_quantity') as $key => $val)
        {
            $messages['pkt_quantity.'.$key.'.required'] = 'Packet Quantity is required.';
            $messages['pkt_quantity.'.$key.'.numeric'] = 'Packet Quantity should be numeric.';

        }
        foreach($this->request->get('quantity_per_pkt') as $key => $val)
        {
            $messages['quantity_per_pkt.'.$key.'.required'] = 'Quantity per packet is required.';
            $messages['quantity_per_pkt.'.$key.'.numeric'] = 'Quantity per packet should be numeric.';

        }
        foreach($this->request->get('pkt_price') as $key => $val)
        {
            $messages['pkt_price.'.$key.'.required'] = 'Packet Price is required.';
            $messages['pkt_price.'.$key.'.numeric'] = 'Packet Price should be numeric.';

        }
        foreach($this->request->get('purchse_price') as $key => $val)
        {
            $messages['purchse_price.'.$key.'.required'] = 'Purchase Price is required.';
            $messages['purchse_price.'.$key.'.numeric'] = 'Purchase Price should be numeric.';

        }
        foreach($this->request->get('expiry_date') as $key => $val)
        {
            $messages['expiry_date.'.$key.'.present'] = 'Expiry Date should be present.';
        }
        return $messages;
    }
}
