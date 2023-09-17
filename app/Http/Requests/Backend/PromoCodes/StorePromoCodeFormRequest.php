<?php

namespace App\Http\Requests\Backend\PromoCodes;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StorePromoCodeFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {

        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'promo_code' => 'required|unique:promo_codes',
            // 'promo_type' => 'required|numeric',
            'expiration_date' => 'required|date|after:' . now(),
            'status' => 'required|numeric',
        ];

        
    }

    public function messages()
    {
        return [
            'promo_code.required' => 'Promo Code is Required !!',
            'promo_code.unique' => 'This Promo Code is Already Registered !!',

            'promo_type.required' => 'Promo Type is Required !!',
            'promo_type.numeric' => 'Promo Type must be numbers only !!',

            'expiration_date.required' => 'Expiration Date is Required !!',
            'expiration_date.date' => 'Expiration Date must be Date only !!',
            'expiration_date.after' => 'Expiration Date must be After Today !!',

            'status.required' => 'Status is Required !!',
            'status.numeric' => 'Status must be numbers only !!',
        ];
    }
}
