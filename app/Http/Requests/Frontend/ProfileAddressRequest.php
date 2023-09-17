<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class ProfileAddressRequest extends FormRequest
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
            'name'=>'required',
            'address'=>'required',
            'city'=>'required',
            'state'=>'required',
            'zipcode'=>'required',
            'country'=>'required'
        ];
    }
}
