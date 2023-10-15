<?php

namespace App\Http\Requests\Frontend\Carts;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AddToCartFormRequest extends FormRequest
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
            // 'cart_prop_type'=>'required|numeric',
            'product_id'=>'required',
            'quantity'=>'required|numeric|min:1'
        ];
    }

    public function messages()
    {
        return [
            'product_id.required' => 'Product is Required !!',
            'quantity.required' => 'Quantity is Required !!',
            'quantity.numeric' => 'Quantity must be numbers only !!',
            'quantity.min' => 'Quantity must be at least 1 !!',
        ];
    }
}
