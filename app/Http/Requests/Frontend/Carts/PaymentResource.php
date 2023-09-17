<?php

namespace App\Http\Requests\Frontend\Carts;

use LVR\CreditCard\CardNumber;
use Illuminate\Support\Facades\Auth;
use LVR\CreditCard\CardExpirationYear;
use LVR\CreditCard\CardExpirationMonth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PaymentResource extends FormRequest
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
        if ($this->payment_method == 'Stripe') {
            $exp_date = ["required","regex:/^(0[1-9]|1[0-2])\/?([0-9]{2})$/"];

            return [
                "address_id" => "required",
                "payment_method" => "required",
                "ec-coupan" => "nullable",
                "card_number" => ["required", new CardNumber],
                "exp_date" => $exp_date,
                "cvc" => ["required", 'regex:/^([0-9]{3})$/'],
            ];

        } else
            return [
                "address_id" => "required",
                "payment_method" => "required",
                "ec-coupan" => "nullable",
            ];
    }
}
