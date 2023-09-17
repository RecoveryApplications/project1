<?php

namespace App\Http\Requests\Frontend\Customers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProductReviewFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
        // return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // 'user_id' => 'required|numeric',
            'product_id' => 'required|numeric',
            'review_value' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            // 'user_id.required' => 'User ID is required !!',
            // 'user_id.numeric' => 'User ID must be numbers only !!',

            'product_id.required' => 'Product ID is required !!',
            'product_id.numeric' => 'Product ID must be numbers only !!',

            'review_value.required' => 'Review Value is required !!',
            'review_value.numeric' => 'Review Value must be numbers only !!',
        ];
    }
}
