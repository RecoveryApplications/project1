<?php

namespace App\Http\Requests\Backend\Products;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProductPropertiesStorFromRequest extends FormRequest
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
            'main_color_id'=>['nullable',
            Rule::unique('prod_sze_clr_relations')->where(function ($query){
                return $query->where('main_size_id', $this->main_size_id)
                    ->where('product_id',$this->product_id);
            })
        ],
            'main_size_id'=>['nullable',
            Rule::unique('prod_sze_clr_relations')->where(function ($query){
                return $query->where('main_color_id', $this->main_color_id)
                    ->where('product_id',$this->product_id);
            })
        ],
        'product_id'=>'required',
        'status'=>'required|numeric',
        'sale_price'=>'required|numeric',
        'on_sale_price_status'=>'required|numeric',
        'on_sale_price'=>'required|numeric|max:'.$this->sale_price,
        'quantity_available'=>'numeric',
        'image'=>'mimes:g3,gif,ief,jpeg,jpg,jpe,ktx,png,btif,sgi,svg,svgz,tiff,tif,webp|max:4048',
        'status'=>'required|numeric',
        ];

    }


    public function messages()
    {
        return [
            'product_quantity_min.required'=>'Property Quantities Must Be Less Than Product Quantity',
            'product_limit_min.required'=>'Property Quantity Limits Must Be Less Than Product Quantity Limit'
        ];
    }
}
