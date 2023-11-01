<?php

namespace App\Http\Requests\Checkout;

use Illuminate\Foundation\Http\FormRequest;

class StoreCheckoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'out_sale_price' => 'required',
            'name' => 'required',
            'phone' => 'required',
            'city' => 'required',
            'address' => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'out_sale_price.required' => 'Out sale price is required',
            'name.required' => 'Name is required',
            'phone.required' => 'Phone is required',
            'city.required' => 'City is required',
            'address.required' => 'Address is required',
        ];
    }
}
