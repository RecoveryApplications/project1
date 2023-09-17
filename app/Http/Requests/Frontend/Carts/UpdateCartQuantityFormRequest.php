<?php

namespace App\Http\Requests\Frontend\Carts;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCartQuantityFormRequest extends FormRequest
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
            'product_ids.*' => 'required|numeric',
            'quantity.*' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'product_ids.*.required' => 'Product IDs is Required !!',
            'product_ids.*.numeric' => 'Product IDs must be numbers only !!',
            
            'quantity.*.required' => 'Quantity is Required !!',
            'quantity.*.numeric' => 'Quantity must be numbers only !!',
        ];
    }
}
