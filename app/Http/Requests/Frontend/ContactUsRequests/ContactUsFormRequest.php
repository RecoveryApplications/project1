<?php

namespace App\Http\Requests\Frontend\ContactUsRequests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ContactUsFormRequest extends FormRequest
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
            'full_name' => 'required',
            'email' => 'required',
            "phone" => 'required|numeric',
            'subject' => 'required',
            'message' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'full_name.required' => 'Full Name is Required !!',

            'email.required' => 'Email is Required !!',

            'phone.required' => 'Phone is Required !!',
            'phone.numeric' => 'Phone must be numbers only !!',

            'subject.required' => 'Subject is Required !!',

            'message.required' => 'Message is Required !!',
        ];
    }
}
