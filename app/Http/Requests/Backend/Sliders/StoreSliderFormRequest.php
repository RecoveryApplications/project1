<?php

namespace App\Http\Requests\Backend\Sliders;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreSliderFormRequest extends FormRequest
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
            "title_en"=>'required|unique:sliders,title_en',
            "image" => 'required|mimes:g3,gif,ief,jpeg,jpg,jpe,ktx,png,btif,sgi,svg,svgz,tiff,tif|max:4048',
            'status' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'image.required' => 'Image is Required !!',
            'image.mimes' => 'Image type must be : (g3,gif,ief,jpeg,jpg,jpe,ktx,png,btif,sgi,svg,svgz,tiff,tif)',
            'image.max' => 'Image size must be less than : (4 MB)',

            'status.required' => 'Status is Required !!',
            'status.numeric' => 'Status must be numbers only !!',
        ];
    }
}
