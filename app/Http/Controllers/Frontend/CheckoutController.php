<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Checkout\StoreCheckoutRequest;
use App\Models\CartOperation;
use App\Models\CartSale;
use App\Models\CartTemp;
use App\Models\Customer;
use App\Models\ProdSzeClrRelation;
use App\Models\Product;
use App\Models\PromoCode;
use App\Models\PublicValue;
use App\Models\SupportTicket;
use App\Models\UsedPromoCode;
use App\Models\UserLocation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function  index()
    {
        if (!auth('customer')->check()) {
            return redirect()->route('customer.login')->with('danger', "You must login first");
        }
        if (auth('customer')->user()->cartTemps->count() == 0) {
            return redirect()->route('shop')->with('danger', "The cart is empty, please add products to the cart");
        }
        return view('front_end_inners.order-overview');
    }

    public function store(Route $route, StoreCheckoutRequest $request)
    {
        try {
            // check for auth user
            if (!auth('customer')->check()) {
                return redirect()->back()->with('danger', "You must login first");
            }
            if (auth('customer')->user()->cartTemps->count() == 0) {
                return redirect()->back()->with('danger', "The cart is empty");
            }

            // ================================================
            // ================= Public Values =================
            // ================================================
            $get_sale_percentage = PublicValue::where('title', 'SalePercentage')->first()->values;
            $get_tax_percentage = PublicValue::where('title', 'Tax')->first()->values;
            $get_shipping_value = PublicValue::where('title', 'Shipping')->first()->values;

            $user = auth('customer')->user();

            // =================================================
            // ----------- Create new location ------------
            // =================================================
            $locationData = $request->only([
                'name',
                'phone',
                'email',
                'company',
                'city',
                'address',
                'apartment',
                'zipcode',
                'more_info',
            ]);
            $locationData['user_id'] = $user->id;
            $location = UserLocation::create($locationData);

            // =================================================
            // ---- Add outsale price to the cart items --------
            // =================================================
            $carts = $user->cartTemps;
            $outSalePrices = $request->out_sale_price;
            foreach ($carts as $key => $cartTemp) {
                $cartTemp->out_sale_price = $outSalePrices[$key];
                $price = $cartTemp->product->on_sale_price_status == 'Active' ? $cartTemp->product->on_sale_price : $cartTemp->product->sale_price;
                if ($cartTemp->out_sale_price < $price) {
                    return redirect()->back()->with('danger', "The outsale price of the product is less than the minimum price");
                }
            }

            $discountValue = 0;
            $endTotal = 0;
            $coupan = null;

            if (isset($carts) && $carts->count() > 0) {
                DB::transaction(function () use ($user, $request, $coupan, $endTotal, $discountValue, $carts, $location, $get_shipping_value, $get_tax_percentage, $get_sale_percentage) {
                    $order_num = $user->id . mb_substr($user->name, 0, 1) . time();
                    // invoice header
                    $CartSale = CartSale::create([
                        'user_id' => $user->id,
                        'user_type' => 'Customer',
                        'location_id' => $location->id,
                        'product_count' => $carts->count(),
                        // 'discount' => $coupan != null ? $discountValue : null,
                        // 'promo_code_id' => $coupan != null ? $coupan->id : null,
                        'total' => 0,
                        'sub_total' => 0,
                        'sale_percentage' => 0,
                        'promo_code_id' => null,
                        'orderNumber' => $order_num,
                        'status' => 1,
                        'payment_status' => 1,
                        'delivery_status' => 1,
                        'name' => $location->name,
                        'phone' => $location->phone,
                        'email' => $location->email,
                        'company' => $location->company,
                        'city' => $location->city,
                        'address' => $location->address,
                        'apartment' => $location->apartment,
                        'zipcode' => $location->zipcode,
                        'more_info' => $location->more_info,
                    ]);

                    $out_total = 0;
                    $sub_total = 0;
                    $tax = $get_tax_percentage / 100;
                    $sale_percentage = $get_sale_percentage / 100;
                    $shipping = $get_shipping_value;
                    foreach ($carts as $cart) {
                        $out_total += $cart->out_sale_price * $cart->quantity;

                        $sale_price = $cart->product->on_sale_price_status == 'Active' ? $cart->product->on_sale_price : $cart->product->sale_price;
                        $sub_total += $cart->quantity * $sale_price;
                        // invoice details
                        CartOperation::create([
                            "cart_sale_id" => $CartSale->id,
                            "product_id" => $cart->product_id,
                            "unit_price" => $sale_price,
                            "sub_total" => $cart->quantity * $sale_price,
                            "total" => $cart->quantity * $sale_price,
                            "out_sale_price" => $cart->out_sale_price * $cart->quantity,
                            "quantity" => $cart->quantity,
                            "property_type" => $cart->property_type,
                        ]);
                    }
                    $redeem =  ($out_total + (($sub_total * $tax) + ($sub_total * $sale_percentage) + $shipping)) - ($sub_total + (($sub_total * $tax) + ($sub_total * $sale_percentage) + $shipping));
                    // let redeem = sum -(websitePercentage + shippingPrice + taxPrice + all_total )
                    $CartSale->update([
                        'total' => $out_total + (($sub_total * $tax) + ($sub_total * $sale_percentage) + $shipping),
                        'sub_total' => $sub_total,
                        'sale_percentage' => $sub_total * $sale_percentage,
                        'tax' => $sub_total * $tax,
                        'shipping' => $shipping ?? 0,
                        'redeem' => $redeem,
                    ]);

                    // delete items from the cart for the user
                    auth('customer')->user()->cartTemps()->delete();
                });
                return redirect()->route('shop')->with('success', "Order created successfully");
            } else {
                return redirect()->back()->with(['danger', 'The cart is empty']);
            }
        } catch (\Throwable $th) {
            $function_name =  $route->getActionName();
            $check_old_errors = new SupportTicket();
            $check_old_errors = $check_old_errors->select('*')->where([
                'error_location' => $th->getFile(),
                'error_description' => $th->getMessage(),
                'function_name' => $function_name,
                'error_line' => $th->getLine(),
            ])->get();
            if ($check_old_errors->count() == 0) {
                $new_error_ticket = SupportTicket::create([
                    'error_location' => $th->getFile(),
                    'error_description' => $th->getMessage(),
                    'function_name' => $function_name,
                    'error_line' =>  $th->getLine(),
                ]);
                $end_error_ticket = $new_error_ticket;
            } else {
                $end_error_ticket = $check_old_errors->first();
            }
            return view('errors.support_tickets', compact('th', 'function_name', 'end_error_ticket'));
        }
    }
}
