<?php

namespace App\Http\Requests\Frontend\Customers;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRegisterFormRequest extends FormRequest
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
            // 'name_en' => 'required|unique:customers,name|unique:users,name|unique:customers,username|unique:users,username',
            'email' => 'required|unique:users,email|unique:customers,email',
            // 'phone' => 'required|numeric|unique:users,phone|unique:customers,phone',
            'password' => 'required|min:8|confirmed',
        ];
    }

    public function messages()
    {
        return [
            // 'name_ar.required' => trans('custom_validation.name_ar_required'),
            // 'name_ar.unique' => trans('custom_validation.name_en_unique'),

            // 'name_en.required' => trans('custom_validation.name_en_required'),
            // 'name_en.unique' => trans('custom_validation.name_en_unique'),

            'username.required' => trans('custom_validation.username_required'),
            'username.unique' => trans('custom_validation.username_unique'),

            'email_register.required' => trans('custom_validation.email_required'),
            'email_register.unique' => trans('custom_validation.email_unique'),

            // 'phone.required' => trans('custom_validation.phone_required'),
            // 'phone.unique' => trans('custom_validation.phone_unique'),
            // 'phone.numeric' => trans('custom_validation.phone_numeric'),

            'password_register.required' => trans('custom_validation.password_required'),
            'password_register.min' => trans('custom_validation.password_min'),
            'password_register.confirmed' => trans('custom_validation.password_confirmed'),

            'profile_photo_path.mimes' => 'Image type must be : (g3,gif,ief,jpeg,jpg,jpe,ktx,png,btif,sgi,svg,svgz,tiff,tif)',
            'profile_photo_path.max' => trans('custom_validation.profile_photo_path_max'),
        ];
    }
}
