<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\CartTemp;
use App\Models\PromoCode;
use Illuminate\Http\Request;
use App\Models\UsedPromoCode;
use App\Models\ProductWishlist;
use App\Models\ProdSzeClrRelation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{

    function index()
    {
        if (!auth('customer')->check()) {
            return redirect()->route('customer.login')->with('danger', "You must login first");
        }
        if (auth('customer')->user()->cartTemps->count() == 0) {
            return redirect()->route('shop')->with('danger', "The cart is empty, please add products to the cart");
        }
        return view('front_end_inners.cart');
    }


    function promoCode(Request $request)
    {
        $request->validate([
            "coupan" => 'required',
        ]);
        $coupan = PromoCode::where('promo_code', $request->input('coupan'))->where('status', 1)->where('expiration_date', ">=", Carbon::now()->format('Y-m-d'))->first();
        if (auth('customer')->user()) {
            if (isset($coupan)) {
                $used_promo_code = UsedPromoCode::where('customer_id', auth('customer')->user()->id)->where("promo_code_id", $coupan->id)->first();
                if (!$used_promo_code) {

                    $total_price = $this->totalPrice();
                    if (isset($total_price) && $total_price > 0) {
                        $total_price = number_format($total_price - (($total_price * $coupan->promo_value) / 100), 3);
                        return response()->json(['status' => true, 'output' => $total_price]);
                    } else
                        return response()->json(['status' => false, 'output' => "Error"]);
                } else {
                    return response()->json(['status' => false, 'output' => "This coupon has been used before ."]);
                }
            } else {
                return response()->json(['status' => false, 'output' => "Coupon card not available ."]);
            }
        } else {
            if (isset($coupan)) {
                $total_price = $this->getTotalCookie();
                if (isset($total_price) && $total_price > 0) {
                    $total_price = number_format($total_price - (($total_price * $coupan->promo_value) / 100), 3);
                    return response()->json(['status' => true, 'output' => $total_price]);
                } else
                    return response()->json(['status' => false, 'output' => "Error"]);
            } else {
                return response()->json(['status' => false, 'output' => "Coupon card not available ."]);
            }
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
        return $public_customer_carts?->endTotal;
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
            $cart_datas['endTotal'] = $endTotal;
        } else {
            // if not exist create array to create cart
            $cart_data = array();
        }
        return number_format($cart_datas['endTotal'], 2);
    }
}
