<?php

namespace App\Http\Requests\Backend\PrivacyPolicies;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StorePrivacyPolicyFormRequest extends FormRequest
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
            'privacy_policy_title_en' => 'required',
            'privacy_policy_des_en' => 'required',
            'privacy_policy_status' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'privacy_policy_title_en.required' => trans('custom_validation.general_instruction_title_en_required'),
            'privacy_policy_title_ar.required' => trans('custom_validation.general_instruction_title_ar_required'),
            'privacy_policy_des_en.required' => trans('custom_validation.general_instruction_des_en_required'),
            'privacy_policy_des_ar.required' => trans('custom_validation.general_instruction_des_ar_required'),

        ];
    }
}
