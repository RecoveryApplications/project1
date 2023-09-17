<?php

namespace App\Http\Requests\Backend\ProprtyImages;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreImagePropertyFormRequest extends FormRequest
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
            'property_other_images' => 'required',
            'property_other_images.*' => 'mimes:g3,gif,ief,jpeg,jpg,jpe,ktx,png,btif,sgi,svg,svgz,tiff,tif,webp|max:4048', // Size => 4 MB
        ];
    }

    public function messages()
    {
        return [
            'property_other_images.required' => 'Product Other Images is required !!',
            'property_other_images.*.mimes' => 'Product Other Images type must be : (g3,gif,ief,jpeg,jpg,jpe,ktx,png,btif,sgi,svg,svgz,tiff,tif)',
            'property_other_images.*.max' => ' Product Other Images size should be less than : (4 MB)',
        ];
    }
}
