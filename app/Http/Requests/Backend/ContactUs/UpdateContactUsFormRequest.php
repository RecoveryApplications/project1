<?php

namespace App\Http\Requests\Backend\ContactUs;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateContactUsFormRequest extends FormRequest
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
            'email' => 'required',
            'phone' => 'required',
            'address_en' => 'required',

        ];
    }

    public function messages()
    {
        return [
            'email.required' => trans('custom_validation.email_required'),
            'phone.required' =>  trans('custom_validation.phone_required'),
            'address_ar.required' => trans('custom_validation.address_ar_required'),
            'address_en.required' =>  trans('custom_validation.address_en_required'),
        ];
    }
}
