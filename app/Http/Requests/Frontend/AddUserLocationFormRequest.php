<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class AddUserLocationFormRequest extends FormRequest
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

        if($this->check_value == null){
            return [
                'check_value' => 'required',
            ];
        }

        if($this->check_value != null && $this->check_value == 2){
            return [
                'shipping_country' => 'required',
                'shipping_city' => 'required',
                'shipping_retail' => 'required',
                'shipping_address' => 'required',
                'shipping_phone' => 'required|numeric',
                'phone_extra' => 'nullable|numeric',

            ];
        }
        if($this->check_value != null && $this->check_value == 1){
            return[
                'location_id'=>'required|numeric'
            ];
        }

    }

    public function messages()
    {
        return [

            'shipping_country.required' => 'Shipping country is Required !!',
            'shipping_city.required' => 'Shipping city is Required !!',
            'shipping_retail.required' => 'Shipping retail is Required !!',
            'shipping_address.required' => 'Shipping address is Required !!',
            'shipping_phone.required' => 'Shipping phone is Required !!',
            'shipping_phone.numeric' => 'Shipping phone must be a number !!',
            'phone_extra.numeric' => 'Shipping Extra phone must be a number !!',
            'location_id.required' => 'Address is Required !!',
            'location_id.numeric' => 'Address must be a number !!',

        ];
    }
}
