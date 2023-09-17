<?php

namespace App\Http\Requests\Backend\Faqs;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateFaqFormRequest extends FormRequest
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
            'title_en' => 'required|unique:faqs,title_en,' . $this->id,
            'answer_en' => 'required',
            'status' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'title_ar.required' => 'Title AR is Required !!',
            'title_ar.unique' => 'This Title AR is Already Registered !!',

            'title_en.required' => 'Title EN is Required !!',
            'title_en.unique' => 'This Title EN is Already Registered !!',

            'answer_ar.required' => 'Answer AR is Required !!',
            'answer_ar.unique' => 'This Answer AR is Already Registered !!',

            'answer_en.required' => 'Answer EN is Required !!',
            'answer_en.unique' => 'This Answer EN is Already Registered !!',

            'status.required' => 'Status is Required !!',
            'status.numeric' => 'Status must be numbers only !!',
        ];
    }
}
