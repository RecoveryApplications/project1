<?php

namespace App\Http\Requests\Backend\Blogs;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateBlogFormRequest extends FormRequest
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
            'title_ar' => 'required|unique:blogs,title_ar,'.$this->id,
            'title_en' => 'required|unique:blogs,title_en,'.$this->id,
            'desc_ar' => 'required',
            'desc_en' => 'required',
            'image' => 'mimes:g3,gif,ief,jpeg,jpg,jpe,ktx,png,btif,sgi,svg,svgz,tiff,tif,webp|max:4048',
            'status' => 'required',
        ];
    }
}
