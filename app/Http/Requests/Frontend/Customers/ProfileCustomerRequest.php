<?php

namespace App\Http\Requests\Frontend\Customers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProfileCustomerRequest extends FormRequest
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
            'name_en' => 'required',
            'email' => 'email:rfc,dns',
            'phone' => 'required',
            'password' => 'nullable',
            'password_confirmation' => 'nullable',
            'country_id' => 'required|exists:countries,id',
        ];
        
    }

    public function messages()
    {
        return [
            'name_en.required' => 'Customer name_en is required !!',
            'email.email' => 'Enter the correct email !!',
            'phone.required' => 'Customer phone is required !!',
            'phone.regex' => 'Enter the correct phone !!',
            'country_id.required' => 'Country is required !!',
            'country_id.exists' => 'Country is not exists !!',
        ];
    }
}
