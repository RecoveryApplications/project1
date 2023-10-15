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
        // dd(auth('customer')->user()->cartSales);
        return view('front_end_inners.order-overview');
    }

    public function store(Route $route, StoreCheckoutRequest $request)
    {
        // dd($request->all());
        // try {
        $user = auth('customer')->user();
        $carts = $user->cartTemps;
        $outSalePrices = $request->out_sale_price;
        foreach ($carts as $key => $cartTemp) {
            $cartTemp->out_sale_price = $outSalePrices[$key];
        }
        $location = UserLocation::find($request->location_id);


        $discountValue = 0;
        $endTotal = 0;
        $coupan = null;
        $sub_total = $request->sub_total;

        if (isset($carts) && $carts->count() > 0) {
            DB::transaction(function () use ($user, $request, $coupan, $endTotal, $discountValue, $carts, $sub_total, $location) {
                $order_num = $user->id . mb_substr($user->name, 0, 1) . time();
                // invoice header
                $CartSale = CartSale::create([
                    'user_id' => $user->id,
                    'user_type' => 'Customer',
                    'location_id' => $location->id,
                    'product_count' => $carts->count(),
                    // 'discount' => $coupan != null ? $discountValue : null,
                    'discount' => null,
                    // 'promo_code_id' => $coupan != null ? $coupan->id : null,
                    'promo_code_id' => null,
                    'orderNumber' => $order_num,
                    'sub_total' => $sub_total,
                    'total' => $sub_total - $discountValue,
                    'tax' => $request->tax ?? 0,
                    'shipping' => $request->shipping ?? 0,
                    'status' => 1,
                    'payment_status' => 1,
                    'delivery_status' => 1,
                    'email' => $location->email,
                    'phone' => $location->phone,
                    'name' => $location->name,
                    'company' => $location->company,
                    'address' => $location->address,
                    'apartment' => $location->apartment,
                    'city' => $location->city,
                    'state' => $location->state,
                    'zipcode' => $location->zipcode,
                    'country' => $location->country,
                    'more_info' => $location->more_info,
                ]);

                $total = $request->shipping + $request->tax; // with shipping + tax + out sale price
                foreach ($carts as $cart) {
                    $total += $cart->out_sale_price * $cart->quantity;
                    $sale_price = 0;

                    $sale_price = $cart->product->on_sale_price_status == 'Active' ? $cart->product->on_sale_price : $cart->product->sale_price;
                    $sub_total = $cart->quantity * $sale_price;
                    $operation_total  = $cart->quantity * $cart->out_sale_price;

                    // invoice details
                    CartOperation::create([
                        "cart_sale_id" => $CartSale->id,
                        "product_id" => $cart->product_id,
                        "unit_price" => $sale_price,
                        "sub_total" => $sub_total,
                        "total" => $operation_total,
                        "out_sale_price" => $cart->out_sale_price,
                        "quantity" => $cart->quantity,
                        "property_type" => $cart->property_type,
                    ]);
                }

                $CartSale->update([
                    'total' => $total,
                ]);


                // delete items from the cart for the user
                auth('customer')->user()->cartTemps()->delete();
            });
            return redirect()->back()->with('success', "Order created successfully");
        } else {
            return redirect()->back()->with(['danger', 'The cart is empty']);
        }
        // } catch (\Throwable $th) {
        //     $function_name =  $route->getActionName();
        //     $check_old_errors = new SupportTicket();
        //     $check_old_errors = $check_old_errors->select('*')->where([
        //         'error_location' => $th->getFile(),
        //         'error_description' => $th->getMessage(),
        //         'function_name' => $function_name,
        //         'error_line' => $th->getLine(),
        //     ])->get();
        //     if ($check_old_errors->count() == 0) {
        //         $new_error_ticket = SupportTicket::create([
        //             'error_location' => $th->getFile(),
        //             'error_description' => $th->getMessage(),
        //             'function_name' => $function_name,
        //             'error_line' =>  $th->getLine(),
        //         ]);
        //         $end_error_ticket = $new_error_ticket;
        //     } else {
        //         $end_error_ticket = $check_old_errors->first();
        //     }
        //     return view('errors.support_tickets', compact('th', 'function_name', 'end_error_ticket'));
        // }
    }
}
