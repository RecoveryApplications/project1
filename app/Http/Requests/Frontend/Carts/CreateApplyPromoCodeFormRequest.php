<?php

namespace App\Http\Requests\Frontend\Carts;

use Illuminate\Foundation\Http\FormRequest;

class CreateApplyPromoCodeFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'promo_code' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'promo_code.required' => 'Promo Code is Required !!',
        ];
    }
}
