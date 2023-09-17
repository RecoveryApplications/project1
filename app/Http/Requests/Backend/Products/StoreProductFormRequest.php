<?php

namespace App\Http\Requests\Backend\Products;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreProductFormRequest extends FormRequest
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
            Rule::unique('products')->where(function ($query){
                return $query->where('main_category_id', $this->main_category_id);
            })],
            // 'super_category_id' => 'required|numeric',
            'main_category_id' => 'required|numeric',
            // 'sub_category_id' => 'numeric',
            'sale_price' => 'required|numeric',
            'on_sale_price_status' => 'required|numeric',
            'on_sale_price' => 'required|numeric|lt:sale_price',
            'quantity_available'=>'numeric',
            "image" => 'mimes:g3,gif,ief,jpeg,jpg,jpe,ktx,png,btif,sgi,svg,svgz,tiff,webp|max:4048',
            'status' => 'required|numeric',
            'private_info' => 'required',
            // 'weight_unit' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'name_ar.required' => 'Name AR is Required !!',
            'name_ar.unique' => 'This Name AR is Already Registered !!',

            'name_en.required' => 'Name EN is Required !!',
            'name_en.unique' => 'This Name EN is Already Registered !!',

            // 'super_category_id.required' => 'Super Category ID is Required !!',
            // 'super_category_id.numeric' => 'Super Category ID must be numbers only !!',
            'main_category_id.required' => 'Main Category ID is Required !!',
            'main_category_id.numeric' => 'Main Category ID must be numbers only !!',
            'sub_category_id.required' => 'Sub Category ID is Required !!',
            'sub_category_id.numeric' => 'Sub Category ID must be numbers only !!',

            'sale_price.required' => 'Sale Price is Required !!',
            'sale_price.numeric' => 'Sale Price must be numbers only !!',

            'on_sale_price_status.required' => 'On Sale Price Status is Required !!',
            'on_sale_price_status.numeric' => 'On Sale Price Status must be numbers only !!',

            'on_sale_price.required' => 'On Sale Price is Required !!',
            'on_sale_price.numeric' => 'On Sale Price must be numbers only !!',
            'on_sale_price.lt' => 'On Sale Price must be less than Sale Price !!',

            'image.mimes' => 'Image type must be : (g3,gif,ief,jpeg,jpg,jpe,ktx,png,btif,sgi,svg,svgz,tiff,tif)',
            'image.max' => 'Image size must be less than : (4 MB)',

            'status.required' => 'Status is Required !!',
            'status.numeric' => 'Status must be numbers only !!',

            'weight_unit.required' => 'Weight Unit is Required !!',
            'weight_unit.numeric' => 'Weight Unit must be numbers only !!',
        ];
    }
}
