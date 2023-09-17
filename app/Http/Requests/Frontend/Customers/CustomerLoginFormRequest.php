<?php

namespace App\Http\Requests\Frontend\Customers;

use Illuminate\Foundation\Http\FormRequest;

class CustomerLoginFormRequest extends FormRequest
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
            'email_login' => 'required',
            'password_login' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'email_login.required' => 'Email is Required !!',
            'password_login.required' => 'Password is Required !!',
        ];
    }
}
