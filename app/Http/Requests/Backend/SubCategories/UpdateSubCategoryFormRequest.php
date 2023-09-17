<?php

namespace App\Http\Requests\Backend\SubCategories;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateSubCategoryFormRequest extends FormRequest
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
            'name_en' => ['required',
            Rule::unique('categories')->where(function ($query){
                return $query->where('id','!=',$this->id)->where('main_category_id', $this->main_category_id);
            })],
            "image" => 'mimes:g3,gif,ief,jpeg,jpg,jpe,ktx,png,btif,sgi,svg,svgz,tiff,webp|max:4048',
            'status' => 'required|numeric',
            // 'super_category_id' => 'required',
            'main_category_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            // 'super_category_id.required' => 'Super Category is Required !!',
            'main_category_id.required' => 'Main Category is Required !!',
            'name_ar.required' => 'Name AR is Required !!',
            'name_ar.unique' => 'This Name AR is Already Registered !!',

            'name_en.required' => 'Name EN is Required !!',
            'name_en.unique' => 'This Name EN is Already Registered !!',

            'image.mimes' => 'Image type must be : (g3,gif,ief,jpeg,jpg,jpe,ktx,png,btif,sgi,svg,svgz,tiff,tif)',
            'image.max' => 'Image size must be less than : (4 MB)',

            'status.required' => 'Status is Required !!',
            'status.numeric' => 'Status must be numbers only !!',
        ];
    }
}
