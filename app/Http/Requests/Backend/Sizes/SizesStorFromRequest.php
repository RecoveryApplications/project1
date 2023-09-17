<?php

namespace App\Http\Requests\Backend\Sizes;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SizesStorFromRequest extends FormRequest
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
            'name_en' => 'required|unique:main_sizes',
        ];
    }

    public function messages()
    {
        return [
            'name_ar.required' => 'Name AR is Required !!',
            'name_ar.unique' => 'This Name AR is Already Registered !!',

            'name_en.required' => 'Name EN is Required !!',
            'name_en.unique' => 'This Name EN is Already Registered !!',

        ];
    }
}
