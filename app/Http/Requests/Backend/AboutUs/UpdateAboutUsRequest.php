<?php

namespace App\Http\Requests\Backend\AboutUs;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateAboutUsRequest extends FormRequest
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
            'about_us_en' => 'required',
            'vision_en' => 'required',
            'mission_en' => 'required',
            'about_us_image' => 'mimes:g3,gif,ief,jpeg,jpg,jpe,ktx,png,btif,sgi,svg,svgz,tiff,tif|max:4048',
            'vision_image' => 'mimes:g3,gif,ief,jpeg,jpg,jpe,ktx,png,btif,sgi,svg,svgz,tiff,tif|max:4048',
            'mission_image' => 'mimes:g3,gif,ief,jpeg,jpg,jpe,ktx,png,btif,sgi,svg,svgz,tiff,tif|max:4048',

        ];
    }


    public function messages()
    {
        return [
            'about_us_ar.required' => 'About Us AR is Required !!',
            'about_us_en.required' => 'About Us EN is Required !!',
            'vision_ar.required' => 'Vision AR is Required !!',
            'vision_en.required' => 'Vision EN is Required !!',
            'mission_ar.required' =>  'Mission AR is Required !!',
            'mission_en.required' => 'Mission EN is Required !!',
            'about_us_image.mimes' => 'About Image type must be : (g3,gif,ief,jpeg,jpg,jpe,ktx,png,btif,sgi,svg,svgz,tiff,tif)',
            'about_us_image.max' =>  'About Image size must be less than : (4 MB)',
            'vision_image.mimes' => 'Vision Image type must be : (g3,gif,ief,jpeg,jpg,jpe,ktx,png,btif,sgi,svg,svgz,tiff,tif)',
            'vision_image.max' =>  'Vision Image size must be less than : (4 MB)',
            'mission_image.max' =>  'Mission Image size must be less than : (4 MB)',
            'mission_image.mimes' => 'Mission Image type must be : (g3,gif,ief,jpeg,jpg,jpe,ktx,png,btif,sgi,svg,svgz,tiff,tif)',
        ];
    }
}
