<?php

namespace App\Http\Controllers\Frontend;

use Exception;
use Carbon\Carbon;
use Stripe\Charge;
use Stripe\Stripe;
use Omnipay\Omnipay;
use App\Models\Payment;
use App\Models\Product;
use App\Models\CartSale;
use App\Models\CartTemp;
use App\Models\PromoCode;
use Illuminate\Http\Request;
use App\Models\CartOperation;
use App\Models\UsedPromoCode;
use LVR\CreditCard\CardNumber;
use App\Models\ProductWishlist;
use App\Models\ProdSzeClrRelation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Frontend\Carts\PaymentResource;

class PaymentController extends Controller
{
    private $gateway;
    private $data;


    function __construct()
    {

        $this->gateway = Omnipay::create('PayPal_Rest');
        $this->gateway->setClientId('AfCS6-Dcxk3w-RORyqHlQzOeUKFKXqhWSsh-jfWwOT7sNGDTqQ7qHH4UCiSoBFp4Nf_WCtJMHTva1PlU');
        $this->gateway->setSecret('EMsnZN37KTjf1tzP0kVPvA4hydodcSuIrYH2Q27VOCq6mSECZluEb8_z7nNrewp9wJuiwLiYCKMrZ38I');
        $this->gateway->setTestMode(false);
    }

    public function charge(PaymentResource $request)
    {
        try {

            if ($request->payment_method == 'Paypal')
                if (auth('customer')->user()) {
                    return $this->Paypal($request);
                } else {
                    return $this->PaypalCookie($request);
                }
            elseif ($request->payment_method == 'Stripe') {

                if (auth('customer')->user()) {
                    return $this->Stripe($request);
                } else {
                    return $this->StripeCookie($request);
                }
            } else {
                return redirect()->route('customer.checkout')->with('danger', 'Payment method is not supported .');
            }
        } catch (Exception $e) {
            return  $e->getMessage();
        }
    }
    public function success(Request $request)
    {
        // try {

        $CartSale = decrypt($request->CartSale);
        $CartSale = CartSale::find($CartSale);

        if (!$CartSale)
            return redirect()->back()->with('danger', 'There was a problem with the payment process .');

        if ($request->input('paymentId') && $request->input('PayerID')) {
            $transaction = $this->gateway->completePurchase(array(
                "payer_id"  => $request->input('PayerID'),
                "transactionReference"  => $request->input('paymentId'),
            ));
            $response = $transaction->send();


            if ($response->isSuccessful()) {
                $arr_data = $response->getData();
                $pay = Payment::where('invoice_id', $CartSale->id)->first();
                if ($pay)
                    return redirect()->route('customer.checkout')->with('danger', 'There was a problem with the payment process .');

                $payment = new Payment();
                $payment->payment_id = $arr_data['id'];
                $payment->payer_id = $arr_data['payer']['payer_info']['payer_id'];
                $payment->payer_email = $arr_data['payer']['payer_info']['email'];
                $payment->amount = $arr_data['transactions'][0]['amount']['total'];
                $payment->currency = "USD";
                $payment->payment_status = $arr_data['state'];
                $payment->invoice_id = $CartSale->id;
                $payment->save();
                $CartSale->payment_status = 2;
                $CartSale->status = 1;
                $CartSale->payment_method = 'Paypal';
                $CartSale->save();

                if (auth('customer')->user()) {

                    foreach ($this->totalPrice() as $prodact) {
                        CartOperation::create([
                            "cart_sale_id" => $CartSale->id,
                            "product_id" => $prodact->id,
                            "unit_price" => $prodact->cart_product->sale_price,
                            "sub_total" => $prodact->sub_total,
                            "total" => $prodact->sub_total,
                            "quantity" => $prodact->quantity,
                            "property_type" => $prodact->property_type

                        ]);
                    }
                } else {
                    foreach ($this->getTotalCookie()[0] as $prodact) {
                        CartOperation::create([
                            "cart_sale_id" => $CartSale->id,
                            "product_id" => $prodact['cart_product']['id'],
                            "unit_price" => $prodact['cart_product']['sale_price'],
                            "sub_total" => $prodact['sub_total'],
                            "total" => $prodact['sub_total'],
                            "quantity" => $prodact['quantity'],
                            "property_type" => $prodact['property_type']
                        ]);
                    }
                }

                if (auth('customer')->user()) {
                    CartTemp::where('user_id', auth('customer')->user()->id)->delete();
                } else {
                    $item_data = json_encode([], JSON_UNESCAPED_UNICODE);
                    $minutes = 43000;
                    Cookie::queue(Cookie::make('shopping_cart', $item_data, $minutes));
                }

                return redirect()->route('customer.checkout')->with('success', 'Payment is successful .');
            } else {

                return $response->getMessage();
            }
        } else {
            return "Transaction is declined";
        }
        // } catch (Exception $e) {
        //     return redirect()->back()->with('danger', 'There was a problem with the payment process .');
        // }
    }
    public function error()
    {
        return "User cancelled the payment .";
    }

    private function Paypal($request)
    {
        try {


            $data['address_id'] = decrypt($request->address_id);


            $data['ec-coupan'] = $request->input('ec-coupan');



            if (isset($data['ec-coupan'])) {
                $coupan = PromoCode::where('promo_code', $data['ec-coupan'])->where('status', 1)->where('expiration_date', ">=", Carbon::now()->format('Y-m-d'))->first();
                $data['coupan'] = $coupan;
                if (isset($coupan)) {

                    $data['used_promo_code'] = UsedPromoCode::where('customer_id', auth('customer')->user()->id)->where("promo_code_id", $coupan->id)->first();
                    if (!$data['used_promo_code']) {
                        $data['used_promo_code'] = UsedPromoCode::create([
                            "customer_id" => auth('customer')->user()->id,
                            "promo_code_id" => $coupan->id,
                            "status" => 1,
                        ]);

                        $total_price = $this->totalPrice()?->endTotal;
                        $data['price_count'] = $this->totalPrice()->count();
                        $data['price'] =  $total_price;

                        if (isset($total_price) && $total_price > 0) {
                            $total_price = number_format($total_price - (($total_price * $coupan->promo_value) / 100), 3);
                            $data['total_price'] = $total_price;
                        } else
                            return redirect()->back()->with('danger', 'Error');
                    } else {
                        return redirect()->back()->with('danger', 'This coupon has been used before .');
                    }
                } else {
                    return redirect()->back()->with('danger', 'Coupon card not available .');
                }
            } else {
                $total_price = $this->totalPrice()?->endTotal;
                $data['price'] = $total_price;
                $data['total_price'] = $total_price;
                $data['price_count'] = $this->totalPrice()->count();
                $data['coupan'] = null;
                $data['used_promo_code'] = null;
            }

            $this->data = $data;


            if ($total_price) {

                $CartSale = CartSale::create([
                    'user_id' => auth('customer')->user()->id,
                    'location_id' => $this->data['address_id'],
                    'product_count' => $this->data['price_count'],
                    'discount' => $this->data['coupan']  ? $this->data['coupan']->promo_value : null,
                    'promo_code_id' => $this->data['coupan']?->id,
                    'sub_total' => $this->data['price'],
                    'total' => $this->data['total_price'],
                    'status' => 1,
                    'payment_status' => 1,
                    'payment_method' => 'Paypal'
                ]);


                // CartTemp::where('user_id', auth('customer')->user()->id)->delete();

                $this->data['CartSale'] = $CartSale->id;

                $response = $this->gateway->purchase(array(
                    "amount" => number_format($total_price, 2),
                    "currency" => "USD",
                    "returnUrl" => url('/paypal/success?CartSale=' . encrypt($CartSale->id)),
                    "cancelUrl" => url('/paypal/error?CartSale=' . encrypt($CartSale->id)),

                ))->send();



                if ($response->isRedirect()) {
                    $response->Redirect();
                } else {
                    return  $response->getMessage();
                }
            } else
                return redirect()->back()->with('danger', 'Your cart is empty .');
        } catch (Exception $e) {
            return  $e->getMessage();
        }
    }

    private function PaypalCookie($request)
    {
        try {

            $data['address_id'] = $request->address_id;
            $data['ec-coupan'] = $request->input('ec-coupan');


            if (isset($data['ec-coupan'])) {
                $coupan = PromoCode::where('promo_code', $data['ec-coupan'])->where('status', 1)->where('expiration_date', ">=", Carbon::now()->format('Y-m-d'))->first();
                $data['coupan'] = $coupan;
                if (isset($coupan)) {

                    $data['used_promo_code'] = UsedPromoCode::create([
                        "customer_id" => null,
                        "promo_code_id" => $coupan->id,
                        "status" => 1,
                    ]);

                    $total_price = $this->getTotalCookie()[1];
                    $data['price_count'] = count($this->getTotalCookie()[0]);
                    $data['price'] =  $total_price;

                    if (isset($total_price) && $total_price > 0) {
                        $total_price = number_format($total_price - (($total_price * $coupan->promo_value) / 100), 3);
                        $data['total_price'] = $total_price;
                    } else
                        return redirect()->back()->with('danger', 'Error');
                } else {
                    return redirect()->back()->with('danger', 'Coupon card not available .');
                }
            } else {
                $total_price = $this->getTotalCookie()[1];
                $data['price'] = $total_price;
                $data['total_price'] = $total_price;
                $data['price_count'] = count($this->getTotalCookie()[0]);
                $data['coupan'] = null;
                $data['used_promo_code'] = null;
            }

            $this->data = $data;


            if ($total_price) {
                if (!Cookie::get('shopping_Address'))
                    return redirect()->back()->with('danger', 'Your Address is empty .');

                $cookie_data = stripslashes(Cookie::get('shopping_Address'));
                $cart_datas = json_decode($cookie_data, true);

                if (!isset($cart_datas[$request->address_id]))
                    return redirect()->back()->with('danger', 'Your Address is empty .');

                $cart_datas = $cart_datas[$request->address_id];

                $CartSale = CartSale::create([
                    'user_id' => null,
                    'location_id' => null,
                    'product_count' => $this->data['price_count'],
                    'discount' => $this->data['coupan']  ? $this->data['coupan']->promo_value : null,
                    'promo_code_id' => $this->data['coupan']?->id,
                    'sub_total' => $this->data['price'],
                    'total' => $this->data['total_price'],
                    'status' => 1,
                    'payment_status' => 1,
                    'payment_method' => 'Paypal',
                    'email' => $cart_datas['email'],
                    'phone' => $cart_datas['phone'],
                    'name' => $cart_datas['name'],
                    'company' => $cart_datas['company'],
                    'address' => $cart_datas['address'],
                    'apartment' => $cart_datas['apartment'],
                    'city' => $cart_datas['city'],
                    'state' => $cart_datas['state'],
                    'zipcode' => $cart_datas['zipcode'],
                    'country' => $cart_datas['country'],
                    'more_info' => $cart_datas['more_info'],
                ]);


                $this->data['CartSale'] = $CartSale->id;


                $response = $this->gateway->purchase(array(
                    "amount" => number_format($total_price, 2),
                    "currency" => "USD",
                    "returnUrl" => url('/paypal/success?CartSale=' . encrypt($CartSale->id)),
                    "cancelUrl" => url('/paypal/error?CartSale=' . encrypt($CartSale->id)),
                ))->send();

                if ($response->isRedirect()) {

                    $response->Redirect();
                } else {
                    return  $response->getMessage();
                }
            } else
                return redirect()->back()->with('danger', 'Your cart is empty .');
        } catch (Exception $e) {
            return  $e->getMessage();
        }
    }

    private function Stripe($request)
    {
        try {

            $data['address_id'] = decrypt($request->address_id);
            $data['ec-coupan'] = $request->input('ec-coupan');

            if (isset($data['ec-coupan'])) {
                $coupan = PromoCode::where('promo_code', $data['ec-coupan'])->where('status', 1)->where('expiration_date', ">=", Carbon::now()->format('Y-m-d'))->first();
                $data['coupan'] = $coupan;
                if (isset($coupan)) {
                    $data['used_promo_code'] = UsedPromoCode::where('customer_id', auth('customer')->user()->id)->where("promo_code_id", $coupan->id)->first();
                    if (!$data['used_promo_code']) {

                        $data['used_promo_code'] = UsedPromoCode::create([
                            "customer_id" => auth('customer')->user()->id,
                            "promo_code_id" => $coupan->id,
                            "status" => 1,
                        ]);

                        $total_price = $this->totalPrice()?->endTotal;
                        $data['price_count'] = $this->totalPrice()->count();
                        $data['price'] =  $total_price;

                        if (isset($total_price) && $total_price > 0) {
                            $total_price = number_format($total_price - (($total_price * $coupan->promo_value) / 100), 3);
                            $data['total_price'] = $total_price;
                        } else
                            return redirect()->back()->with('danger', 'Error');
                    } else {
                        return redirect()->back()->with('danger', 'This coupon has been used before .');
                    }
                } else {
                    return redirect()->back()->with('danger', 'Coupon card not available .');
                }
            } else {
                $total_price = $this->totalPrice()?->endTotal;
                $data['price'] = $total_price;
                $data['total_price'] = $total_price;
                $data['price_count'] = $this->totalPrice()->count();
                $data['coupan'] = null;
                $data['used_promo_code'] = null;
            }



            if ($total_price) {
                Stripe::setApiKey("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");
                $Charge = Charge::create([
                    "amount" => $total_price * 100,
                    "currency" => "usd",
                    "source" => $request->stripeToken,
                    "description" => "This payment is tested purpose phpcodingstuff.com"
                ]);

                $CartSale = CartSale::create([
                    'user_id' => auth('customer')->user()->id,
                    'location_id' => $data['address_id'],
                    'product_count' => $data['price_count'],
                    'discount' => $data['coupan']  ? $data['coupan']->promo_value : null,
                    'promo_code_id' => $data['coupan']?->id,
                    'sub_total' => $data['price'],
                    'total' => $data['total_price'],
                    'status' => 1,
                    'payment_status' => 2,
                    'payment_method' => 'Stripe'
                ]);


                $payment = new Payment();
                $payment->payment_id = $Charge->id;
                $payment->payer_id = $Charge->id;
                $payment->payer_email = '';
                $payment->amount = $total_price * 100;
                $payment->currency = $Charge->currency;
                $payment->payment_status = 'success';
                $payment->invoice_id = $CartSale->id;
                $payment->save();

                $CartSale->payment_status = 2;
                $CartSale->status = 1;
                $CartSale->save();

                foreach ($this->totalPrice() as $prodact) {
                    CartOperation::create([
                        "cart_sale_id" => $CartSale->id,
                        "product_id" => $prodact->cart_product->id,
                        "unit_price" => $prodact->cart_product->sale_price,
                        "sub_total" => $prodact->sub_total,
                        "total" => $prodact->sub_total,
                        "quantity" => $prodact->quantity,
                        "property_type" => $prodact->property_type
                    ]);
                }
                CartTemp::where('user_id', auth('customer')->user()->id)->delete();
                return redirect()->back()->with('success', 'Your purchase has been successfully completed .');
            } else
                return redirect()->back()->with('danger', 'Your cart is empty .');
        } catch (Exception $e) {
            return  $e->getMessage();
        }
    }

    private function StripeCookie($request)
    {
        try {


            $data['address_id'] = $request->address_id;
            $data['ec-coupan'] = $request->input('ec-coupan');
            if (isset($data['ec-coupan'])) {
                $coupan = PromoCode::where('promo_code', $data['ec-coupan'])->where('status', 1)->where('expiration_date', ">=", Carbon::now()->format('Y-m-d'))->first();
                $data['coupan'] = $coupan;
                if (isset($coupan)) {
                    $data['used_promo_code'] = UsedPromoCode::create([
                        "customer_id" => null,
                        "promo_code_id" => $coupan->id,
                        "status" => 1,
                    ]);

                    $total_price = $this->getTotalCookie()[1];
                    $data['price_count'] = count($this->getTotalCookie()[0]);
                    $data['price'] =  $total_price;

                    if (isset($total_price) && $total_price > 0) {
                        $total_price = number_format($total_price - (($total_price * $coupan->promo_value) / 100), 3);
                        $data['total_price'] = $total_price;
                    } else
                        return redirect()->back()->with('danger', 'Error');
                } else {
                    return redirect()->back()->with('danger', 'Coupon card not available .');
                }
            } else {
                $total_price = $this->getTotalCookie()[1];
                $data['price'] = $total_price;
                $data['total_price'] = $total_price;
                $data['price_count'] = count($this->getTotalCookie()[0]);
                $data['coupan'] = null;
                $data['used_promo_code'] = null;
            }




            if ($total_price) {
                Stripe::setApiKey("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");
                $Charge = Charge::create([
                    "amount" => $total_price * 100,
                    "currency" => "usd",
                    "source" => $request->stripeToken,
                    "description" => "This payment is tested purpose phpcodingstuff.com"
                ]);

                if (!Cookie::get('shopping_Address'))
                    return redirect()->back()->with('danger', 'Your Address is empty .');

                $cookie_data = stripslashes(Cookie::get('shopping_Address'));
                $cart_datas = json_decode($cookie_data, true);

                if (!isset($cart_datas[$request->address_id]))
                    return redirect()->back()->with('danger', 'Your Address is empty .');

                $cart_datas = $cart_datas[$request->address_id];

                $CartSale = CartSale::create([
                    'user_id' => null,
                    'location_id' => null,
                    'product_count' => $data['price_count'],
                    'discount' => $data['coupan']  ? $data['coupan']['promo_value'] : null,
                    'promo_code_id' => $data['coupan']?->id,
                    'sub_total' => $data['price'],
                    'total' => $data['total_price'],
                    'status' => 1,
                    'payment_status' => 2,
                    'payment_method' => 'Stripe',
                    'email' => $cart_datas['email'],
                    'phone' => $cart_datas['phone'],
                    'name' => $cart_datas['name'],
                    'company' => $cart_datas['company'],
                    'address' => $cart_datas['address'],
                    'apartment' => $cart_datas['apartment'],
                    'city' => $cart_datas['city'],
                    'state' => $cart_datas['state'],
                    'zipcode' => $cart_datas['zipcode'],
                    'country' => $cart_datas['country'],
                    'more_info' => $cart_datas['more_info'],
                ]);



                $payment = new Payment();
                $payment->payment_id = $Charge->id;
                $payment->payer_id = $Charge->id;
                $payment->payer_email = '';
                $payment->amount = $total_price * 100;
                $payment->currency = $Charge->currency;
                $payment->payment_status = 'success';
                $payment->invoice_id = $CartSale->id;
                $payment->save();

                $CartSale->payment_status = 2;
                $CartSale->status = 1;
                $CartSale->save();


                foreach ($this->getTotalCookie()[0] as $prodact) {
                    CartOperation::create([
                        "cart_sale_id" => $CartSale->id,
                        "product_id" => $prodact['cart_product']['id'],
                        "unit_price" => $prodact['cart_product']['sale_price'],
                        "sub_total" => $prodact['sub_total'],
                        "total" => $prodact['sub_total'],
                        "quantity" => $prodact['quantity'],
                        "property_type" => $prodact['property_type']
                    ]);
                }


                $item_data = json_encode([], JSON_UNESCAPED_UNICODE);
                $minutes = 43000;
                // add array to cookies
                Cookie::queue(Cookie::make('shopping_cart', $item_data, $minutes));

                return redirect()->back()->with('success', 'Your purchase has been successfully completed .');
            } else
                return redirect()->back()->with('danger', 'Your cart is empty .');
        } catch (Exception $e) {
            return  $e->getMessage();
        }
    }

    function totalPrice()
    {
        if (Auth::guard('customer')->check()) {
            $withlist_count = ProductWishlist::where('customer_id', Auth::guard('customer')->user()->id)->count();
            $public_customer_carts = CartTemp::where(['user_id' => Auth::guard('customer')->user()->id, 'user_type' => 'Customer'])->get();
            $endTotal = 0;
            foreach ($public_customer_carts as $public_customer_cart) {
                $sub_total = 0;
                if ($public_customer_cart->property_type == 1) {
                    $public_customer_cart->cart_product = ProdSzeClrRelation::find($public_customer_cart->product_id);
                } else {
                    $public_customer_cart->cart_product = Product::find($public_customer_cart->product_id);
                }
                if ($public_customer_cart->cart_product->on_sale_price_status == 'Active') {
                    $endTotal += $public_customer_cart->quantity * $public_customer_cart->cart_product->on_sale_price;
                    $sub_total = $public_customer_cart->quantity * $public_customer_cart->cart_product->on_sale_price;
                } else {
                    $endTotal += $public_customer_cart->quantity * $public_customer_cart->cart_product->sale_price;
                    $sub_total = $public_customer_cart->quantity * $public_customer_cart->cart_product->sale_price;
                }
                $public_customer_cart->sub_total = $sub_total;
            }
            $public_customer_carts->endTotal = $endTotal;
        } else {
            $public_customer_carts = null;
        }
        return $public_customer_carts;
    }

    function getTotalCookie()
    {

        if (Cookie::get('shopping_cart')) {
            $cookie_data = stripslashes(Cookie::get('shopping_cart'));
            $cart_datas = json_decode($cookie_data, true);
            $endTotal = 0;
            foreach ($cart_datas as $key => $cart_dat) {
                $sub_total = 0;
                if ($cart_datas[$key]['property_type'] == 1) {
                    $cart_datas[$key]['cart_product'] = ProdSzeClrRelation::find($cart_datas[$key]['product_id']);
                } else {
                    $cart_datas[$key]['cart_product'] = Product::find($cart_datas[$key]['product_id']);
                }
                if ($cart_datas[$key]['cart_product']['on_sale_price_status'] == 'Active') {
                    $endTotal += $cart_datas[$key]['quantity'] * $cart_datas[$key]['cart_product']['on_sale_price'];
                    $sub_total = $cart_datas[$key]['quantity'] * $cart_datas[$key]['cart_product']['on_sale_price'];
                } else {
                    $endTotal += $cart_datas[$key]['quantity'] * $cart_datas[$key]['cart_product']['sale_price'];
                    $sub_total = $cart_datas[$key]['quantity'] * $cart_datas[$key]['cart_product']['sale_price'];
                }
                $cart_datas[$key]['sub_total'] = $sub_total;
            }
        } else {
            // if not exist create array to create cart
            $cart_data = array();
        }
        return [$cart_datas, number_format($endTotal, 2)];
    }
}
