<?php

namespace App\Http\Requests\Backend\TermAndConditions;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateTermAndConditionFormRequest extends FormRequest
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
            'term_and_condition_title_en' => 'required',
            'term_and_condition_des_en' => 'required',
            'term_and_condition_status' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'term_and_condition_title_en.required' => trans('custom_validation.general_instruction_title_en_required'),
            'term_and_condition_title_ar.required' => trans('custom_validation.general_instruction_title_ar_required'),
            'term_and_condition_des_en.required' => trans('custom_validation.general_instruction_des_en_required'),
            'term_and_condition_des_ar.required' => trans('custom_validation.general_instruction_des_ar_required'),
            'term_and_condition_status.required' => trans('custom_validation.general_instruction_status_required'),

        ];
    }
}
