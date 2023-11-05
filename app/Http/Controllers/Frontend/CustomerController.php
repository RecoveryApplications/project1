<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Product;
use App\Models\CartSale;
use App\Models\CartTemp;
use App\Models\Customer;
use App\Models\StateUsa;
use App\Models\Newsletter;
use App\Traits\SharedMethod;
use Illuminate\Http\Request;
use App\Models\ProductReview;
use App\Models\SupportTicket;
use Illuminate\Routing\Route;
use App\Models\ProductWishlist;
use App\Traits\UploadImageTrait;
use App\Models\ProdSzeClrRelation;
use Illuminate\Support\Facades\DB;
use LaravelShipStation\ShipStation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Frontend\Carts\AddToCartFormRequest;
use App\Http\Requests\Frontend\Customers\CustomerLoginFormRequest;
use App\Http\Requests\Frontend\Customers\ProductReviewFormRequest;
use App\Http\Requests\Frontend\Customers\CustomerRegisterFormRequest;
use App\Models\CartOperation;
use App\Models\Country;
use App\Models\PaymentWallet;
use App\Models\PromoCode;
use App\Models\UsedPromoCode;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    use UploadImageTrait;
    use SharedMethod;

    // ========================================================================
    // ============== Customer show Login/Register Form Function ==============
    // ========================================================================
    public function loginRegister(Route $route, $type = 'login')
    {
        try {
            if (Auth::guard('customer')->check()) {
                return redirect()->intended(route('customer.profile'));
            }

            if ($type == 'login') {
                return view('front_end_inners.customer.login');
            } else {
                $countries = Country::where('is_active', 1)->get();
                return view('front_end_inners.customer.register', compact('countries'));
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

    // ================================================================
    // ======================== Login Function ========================
    // ================================================================
    public function login(CustomerLoginFormRequest $request, Route $route)
    {
        // dd($request->all());
        try {
            // $rules = [

            //     'password_login' => ['required']
            // ];

            // $messages = [
            //     // 'lang.required' => __('validator_api.lang_required'),
            //     // 'device_id.required' => __('validator_api.device_id_required'),
            // ];

            // if (is_numeric($request->email)) {
            // } else {
            //     $rules['email_login'] = ['required'];
            // }

            // $validator = Validator::make($request->all(), $rules, $messages);

            // if ($validator->fails()) {
            //     return response()->json(['status' => false, 'msg' => $validator->errors()->toArray()]);
            // }
            // Attempt to log the user in
            if (filter_var($request->get('email_login'), FILTER_VALIDATE_EMAIL)) {
                if (Auth::guard('customer')->attempt(['email' => $request->email_login, 'password' => $request->password_login])) {

                    return redirect()->intended(route('customer.profile'));
                } else {
                    return redirect()->back()->withInput($request->only('username', 'remember'))->with('danger', "Email or Password is incorrect");
                }
            } elseif (is_numeric($request->email_login)) {
                if (Auth::guard('customer')->attempt(['phone' => $request->email_login, 'password' => $request->password_login])) {

                    return redirect()->intended(route('customer.profile'));
                } else {
                    return redirect()->back()->withInput($request->only('username', 'remember'))->with('danger', "Email or Password is incorrect");
                }
            }

            return redirect()->back()->withInput($request->only('username', 'remember'))->with('danger', "Email or Password is incorrect");
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
    // ========================================================================
    // ================== Customer Register Request Function ==================
    // ========================================================================

    public function register(Request $request, Route $route)
    {
        $rules = [
            'name_en' => 'required | max:50',
            'username' => 'required|max:50',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'required|unique:customers,phone',
            'password' => 'required|min:6|confirmed',
            'country_id' => 'required|exists:countries,id',
        ];
        $messages = [
            'name_en.required' => 'Name is required',
            'username.required' => 'Username is required',
            'email.required' => 'Email is required',
            'phone.required' => 'Phone is required',
            'password.required' => 'Password is required',
            'country_id.required' => 'Country is required',
            'country_id.exists' => 'Country is not exists',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->only('name_en', 'username', 'email', 'phone', 'country_id'))->withErrors($validator);
        }
        
        try {
            $data = $request->except(['_token', 'password', 'password_confirmation', 'country_key', 'submit']);
            $data['password'] = Hash::make($request->password);
            $data['user_status'] = 2;
            $data['created_by'] = 1;
            // Start the transaction
            $user = Customer::create($data);

            Auth::guard('customer')->login($user);
            return redirect()->back()->with('success', "Registration completed successfully");

            // $rules = [
            //     'password' => ['required']
            // ];

            // $messages = [
            //     // 'lang.required' => __('validator_api.lang_required'),
            //     // 'device_id.required' => __('validator_api.device_id_required'),
            // ];

            // if (is_numeric($request->email)) {
            //     $rules['country_key'] = ['required'];
            // } else {
            //     $rules['email'] = ['required'];
            // }

            // $validator = Validator::make($request->all(), $rules, $messages);

            // if ($validator->fails()) {
            //     return response()->json(['status' => false, 'msg' => $validator->errors()->toArray()]);
            // }
            // Attempt to log the user in
            // if (filter_var($request->get('email'), FILTER_VALIDATE_EMAIL)) {

            //     $created_data = [
            //         'name_en' => $request->name_en,
            //         'username' => $request->name_en,
            //         'email' => $request->email,
            //         'phone' => $request->phone,
            //         'country_key' => '+' . $request->country_key,
            //         'password' => Hash::make($request->password),
            //         'user_status' => 2, // Active
            //         'created_by' => 1,
            //     ];

            //     // dd($created_data);
            //     // Start the transaction
            //     $user = Customer::create($created_data);

            //     Auth::guard('customer')->login($user);
            //     return redirect()->back()->with('success', trans('front_end.message_Registration_completed_successfully'));
            // } elseif (is_numeric($request->email)) {

            //     $created_data = [
            //         'name_en' => $request->name_en,
            //         'username' => $request->name_en,
            //         'phone' => $request->phone,
            //         'email' => $request->email,
            //         'country_key' => '+' . $request->country_key,
            //         'password' => Hash::make($request->password),
            //         'user_status' => 2, // Active
            //         'created_by' => 1,
            //     ];

            //     // dd($created_data);
            //     // Start the transaction
            //     $user = Customer::create($created_data);

            //     Auth::guard('customer')->login($user);
            //     return redirect()->back()->with('success', trans('front_end.message_Registration_completed_successfully'));
            // }
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

    // ================================================================
    // ======================= Profile Function =======================
    // ================================================================
    public function profile()
    {

        if (Auth::guard('customer')->check()) {
            $auth = Auth::guard('customer')->user()->profile_photo_path;
            $user_addresses = Auth::guard('customer')->user()->locations;
            $cartSales = CartSale::with(['cartOperations'])->where(['user_id' => auth('customer')->user()->id])->orderBy('created_at', 'desc')->paginate(10);
            $payment_wallets = PaymentWallet::where('status', 'active')->get();
            $countries = Country::where('is_active', 1)->get();
            return view('front_end_inners.customer.user-profile', compact('auth', 'cartSales', 'user_addresses', 'payment_wallets' , 'countries'));
        } else {
            return view('front_end_inners.customer.login_register');
        }
    }


    // ================================================================
    // ======================== Logout Function =======================
    // ================================================================
    public function logout(Request $request)
    {
        auth::logout();
        $request->session()->invalidate();
        return redirect(route('welcome'));
    }


    // ========================================================================
    // ======================== Product Job Function ==========================
    // ===================== Created By : Mohammed Salah =====================
    // ========================================================================
    public function productReview(ProductReviewFormRequest $request, Route $route)
    {
        try {
            $review = ProductReview::where([
                'user_id' => auth('customer')->user()->id,
                'user_type' => $this->authUserType(),
                'product_id' => $request->product_id,
            ])->get()->first();

            if ($review) {
                return redirect()->back()->with(['danger' => 'You have already rated this product']);
            } else {
                // Start the transaction
                DB::transaction(function () use ($request) {
                    ProductReview::create([
                        'user_id' => auth('customer')->user()->id,
                        'user_type' => $this->authUserType(),
                        'product_id' => $request->product_id,
                        'review_value' => $request->review_value,
                        'review_note' => $request->review_note,
                    ]);
                });
                return redirect()->back()->with(['success' => 'Thank you for your review', 'active_div' => $request->active_div]);
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

    public function orderOverview()
    {
        return view('front_end_inners.order-overview');
    }




    public function addToCart(Route $route, AddToCartFormRequest $request)
    {
        try {

            if (!Auth::guard('customer')->check()) {
                return redirect()->route('customer.login');
                // return $this->addToCartCookies($route, $request);
            }
            $data = $request->only(['product_id', 'quantity']);

            $product = Product::find($data['product_id']);
            $property_type = $product->properties->count() > 0 ? 1 : 2;
            if ($property_type == 1) {
                $product = ProdSzeClrRelation::find($data['product_id']);
            }

            if ($product) {
                // if ($quantity > $product->quantity_available) {
                //     return redirect()->back()->with('danger', 'Out Of Stock !!!');
                // }
                $old_cart = CartTemp::where([
                    ['user_id', Auth::guard('customer')->user()->id],
                    ['product_id', $product->id],
                    ['property_type', $property_type]
                ])->get()->first();


                if ($old_cart) {
                    // 
                    $old_cart->update([
                        'quantity' => $old_cart->quantity + $data['quantity']
                    ]);
                    return redirect()->back()->with('success', 'Cart Updated Successfully');
                } else {
                    CartTemp::create([
                        'user_id' => Auth::guard('customer')->user()->id,
                        'user_type' => 'Customer',
                        'product_id' => $product->id,
                        'property_type' => $property_type,
                        'quantity' => $data['quantity'],
                    ]);
                    return redirect()->back()->with('success', 'Added To Cart Successfully');
                }
            } else {
                return redirect()->back()->with('danger', 'Product Not Found !!!');
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

    public function removeItemFromCart(Route $route, $id)
    {
        try {
            $cart = CartTemp::find($id);
            if ($cart) {
                $cart->delete();
                return redirect()->back()->with('success', 'Item Removed Successfully');
            } else {
                return redirect()->back()->with('danger', 'Item Not Found !!!');
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


    public function addToCartCookies(Route $route, AddToCartFormRequest $request)
    {
        try {

            $product_id = decrypt($request->cart_product_id);
            $quantity = $request->cart_product_quantity;
            $product = Product::find($product_id);
            $property_type = $product->properties->count() > 0 ? 1 : 2;

            if ($property_type == 1) {
                $product = ProdSzeClrRelation::find($product_id);
            }

            if ($product) {
                if ($quantity > $product->quantity_available) {
                    return redirect()->back()->with('danger', 'Out Of Stock !!!');
                }
                // check if cookies cart exist
                if (Cookie::get('shopping_cart')) {
                    $cookie_data = stripslashes(Cookie::get('shopping_cart'));
                    $cart_data = json_decode($cookie_data, true);
                } else {
                    // if not exist create array to create cart
                    $cart_data = array();
                }
                // if cookies cart exist check if item in cart
                $product_id_list = array_column($cart_data, 'product_id');

                // if item in cart .. find the item and update quantity
                if (in_array($product_id, $product_id_list)) {

                    foreach ($cart_data as $keys => $values) {

                        if ($cart_data[$keys]["product_id"] == $product_id) {

                            $cart_data[$keys]["quantity"] = $cart_data[$keys]["quantity"] + $quantity;
                            $cart_data[$keys]["property_type"] = $property_type;
                            $item_data = json_encode($cart_data, JSON_UNESCAPED_UNICODE);
                            $minutes = 6000;

                            Cookie::queue(Cookie::make('shopping_cart', $item_data, $minutes));
                            return redirect()->back()->with('success', __('front_end.cart_update_success'));
                        }
                    }
                } else {
                    // add details to array
                    $item_array = array(
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'property_type' => $property_type,
                    );
                    $cart_data[] = $item_array;
                    // create cart in cookies
                    // return $cart_data;
                    $item_data = json_encode($cart_data, JSON_UNESCAPED_UNICODE);
                    $minutes = 43000;
                    // add array to cookies
                    Cookie::queue(Cookie::make('shopping_cart', $item_data, $minutes));
                    $cookie_data = stripslashes(Cookie::get('shopping_cart'));
                    $cart_data = json_decode($cookie_data, true);

                    return redirect()->back()->with('success', __('front_end.product_add_success'));
                }
            } else {
                return redirect()->back()->with('danger', 'Product Not Found !!!');
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
    public function checkoutPage(Route $route)
    {
        try {
            if (auth('customer')->user()) {
                $locations = auth('customer')->user()->locations;
            } else {
                if (Cookie::get('shopping_Address')) {
                    $cookie_data = stripslashes(Cookie::get('shopping_Address'));
                    $locations = json_decode($cookie_data, true);
                } else {
                    // if not exist create array to create cart
                    $locations = array();
                }
            }


            return view('front_end_inners.checkout')->with('locations', $locations ?? null);
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

    public function checkout(Route $route, Request $request)
    {
        try {
            $request->validate([
                'location_id' => 'required'
            ]);
            $user = Customer::find(auth('customer')->user()->id);
            // return  $user;


            $carts = CartTemp::where([
                ['user_id', $user->id],
                ['user_type', 'Customer']
            ])->get();

            if (isset($carts) && $carts->count() > 0) {

                $discountValue = 0;
                $endTotal = 0;

                if (isset($request->PromoCode) && $request->PromoCode != "") {
                    $coupan = PromoCode::where('promo_code', $request->PromoCode)->where('status', 1)->where('expiration_date', ">=", Carbon::now()->format('Y-m-d'))->first();
                    if ($coupan) {
                        $usedPromoCode = UsedPromoCode::where('customer_id', $user->id)->where("promo_code_id", $coupan->id)->first();
                        if (!$usedPromoCode) {
                            $total_price = $this->getTotal();
                            $endTotal = $total_price;
                            if (isset($endTotal) && $endTotal > 0) {

                                UsedPromoCode::create([
                                    "customer_id" => $user->id,
                                    "promo_code_id" => $coupan->id,
                                    "status" => 1,
                                ]);

                                // $discountValue = $total_price->discountValue ?? 0;
                                // $price_count = $total_price->count();
                            } else {
                                return response()->json(['status' => false, 'messages' => 'Error .']);
                            }
                        } else {
                            return response()->json(['status' => false, 'messages' => trans('api.This_coupon_has_been_used')]);
                        }
                    } else {
                        return response()->json(['status' => false, 'messages' => trans('api.Coupon_card_not_available')]);
                    }
                } else {
                    $total_price = $this->getTotal();
                    // $endTotal = $total_price->endTotal;
                    // $price_count = $total_price->count();
                    $coupan = null;
                    $usedPromoCode = null;
                    $discountValue = 0;
                }

                DB::transaction(function () use ($user, $request, $coupan, $endTotal, $discountValue, $carts, $total_price) {
                    $order_num = $user->id . mb_substr($user->name, 0, 1) . time();

                    $CartSale = CartSale::create([
                        'user_id' => $user->id,
                        'location_id' => $request->location_id,
                        'product_count' => $carts->count(),
                        'discount' => $coupan != null ? $discountValue : null,
                        'promo_code_id' => $coupan != null ? $coupan->id : null,
                        'sub_total' => $endTotal,
                        'total' => $endTotal - $discountValue,
                        // 'tax' => $total_price->tax,
                        'status' => 1,
                        'orderNumber' => $order_num,
                        'payment_status' => 1
                    ]);

                    foreach ($carts as $cart) {


                        $endTotal += $cart->quantity * $cart->product->sale_price;
                        $sub_total = $cart->quantity * $cart->product->sale_price;

                        if ($cart->property_type == 1) {
                            $proparity = 1;
                        } else {
                            $proparity = 2;
                        }

                        CartOperation::create([
                            "cart_sale_id" => $CartSale->id,
                            "product_id" => $cart->product->id,
                            "unit_price" => $cart->product->sale_price,
                            "sub_total" => $sub_total,
                            "total" => $endTotal,
                            "quantity" => $cart->quantity,
                            "property_type" => $proparity
                        ]);
                    }
                    // dd ($cart);
                    CartTemp::where('user_id', $user->id)->delete();
                });

                return redirect()->back()->with('success', trans('front_end.message_sent_successfully'));
            } else {
                return $this->returnError(trans('api.Cart_is_empty'));
            }
            // return redirect()->back()->with('success', trans('sent_successfully'));
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


    // ===================================================================================================================
    // ============================================= account-update-img Section ===================================================
    // ===================================================================================================================

    public function accountUpdateImg(Route $route, Request $request)
    {
        try {
            $request->validate([
                'file_img' => 'required|mimes:jpeg,jpg,png',
            ]);

            if (isset($request->file_img)) {
                $last_image = $this->saveImage($request->file('file_img'), "custom_img");
            } else {
                $last_image = null;
            }

            $user = Customer::find(auth('customer')->user()->id);
            $user->profile_photo_path = $last_image;
            // return $last_image;
            $user->save();
            return redirect()->back()->with('success', __("front_end.message_sent_successfully"));
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





    public function remove_cart(Route $route, $id)
    {
        try {

            $cart = CartTemp::find($id);
            if ($cart) {
                $cart->delete();
                return redirect()->back()->with('success', 'Successfully Removed');
            } else {
                return redirect()->back()->with('danger', 'Item Not In Cart !!!!');
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



    public function wishlist(Request $request, Route $route)
    {
        // try {

        $product = Product::find($request->id);

        if ($product) {
            $wishlist = ProductWishlist::where('product_id', $product->id)->where('customer_id', auth('customer')->user()->id)->get()->first();

            if ($wishlist) {
                $wishlist->delete();
                return redirect()->back()->with('success', 'Successfully Removed');
            } else {
                ProductWishlist::create([
                    'product_id' => $product->id,
                    'customer_id' => auth('customer')->user()->id
                ]);
                return redirect()->back()->with('success', 'Successfully Added');
            }
        } else {
            return redirect()->back()->with('danger', 'Product Not Found !!!!');
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



    public function getWishList(Route $route)
    {
        try {

            $wishlistItems = ProductWishlist::with('product')->where('customer_id', auth('customer')->user()->id)->get();
            return view('front_end_inners.customer.wishlist', compact('wishlistItems'));
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



    public function updateCart(Request $request)
    {

        $request->validate([
            'cart_id' => 'required',
            'qty' => 'required|numeric'
        ]);



        $cart_id = decrypt($request->cart_id);

        if (!auth('customer')->user()) {
            return $this->updateCartCookie($request);
        } else {
            $cart = CartTemp::find($cart_id);
            if ($cart) {

                $product = Product::find($cart->product_id);
                $property_type = $product->properties->count() > 0 ? 1 : 2;
                if ($property_type == 1) {
                    $product = ProdSzeClrRelation::find($cart->product_id);
                }

                if ($request->qty > $product->quantity_available) {
                    return response()->json(['status' => false, 'msg' => 'Out Of Stock !!!']);
                }

                if ($request->qty != 0) {
                    $cart->update([
                        'quantity' => $request->qty
                    ]);
                    return response()->json(['status' => true, 'msg' => 'Updated Successfully ...', 'total' => $this->getTotal()]);
                } else {
                    $cart->delete();
                    return response()->json(['status' => true, 'msg' => 'Deleted Successfully ...', 'total' => $this->getTotal()]);
                }
            } else {
                return response()->json(['status' => false, 'msg' => 'Item not found in cart ...']);
            }
        }
    }

    public function updateCartCookie(Request $request)
    {
        $product = Product::find($request->cart_id);
        $property_type = $product->properties->count() > 0 ? 1 : 2;
        if ($property_type == 1) {
            $product = ProdSzeClrRelation::find($request->cart_id);
        }

        if ($request->qty > $product->quantity_available) {
            return response()->json(['status' => false, 'msg' => 'Out Of Stock !!!']);
        }

        if (Cookie::get('shopping_cart')) {
            $cookie_data = stripslashes(Cookie::get('shopping_cart'));
            $cart_data = json_decode($cookie_data, true);
            foreach ($cart_data as $key => $cart_dat) {
                if (decrypt($request->cart_id) == $key) {
                    if ($request->qty == 0) {
                        unset($cart_data[$key]);
                    } else {
                        $cart_data[$key]['quantity'] = $request->qty;
                    }
                }
            }
        } else {
            // if not exist create array to create cart
            $cart_data = array();
        }

        if ($cart_data != []) {
            if ($request->qty != 0) {
                $item_data = json_encode($cart_data, JSON_UNESCAPED_UNICODE);
                $minutes = 43000;
                // add array to cookies
                Cookie::queue(Cookie::make('shopping_cart', $item_data, $minutes));
                return response()->json(['status' => true, 'msg' => 'Updated Successfully ...', 'total' => $this->getTotalCookie()]);
            } else {
                $item_data = json_encode($cart_data, JSON_UNESCAPED_UNICODE);
                $minutes = 43000;
                // add array to cookies
                Cookie::queue(Cookie::make('shopping_cart', $item_data, $minutes));
                return response()->json(['status' => true, 'msg' => 'Deleted Successfully ...', 'total' => $this->getTotalCookie()]);
            }
        } else {
            return response()->json(['status' => false, 'msg' => 'Item not found in cart ...']);
        }
    }

    public function getTotal()
    {
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
        return number_format($public_customer_carts->endTotal, 2);
    }
    public function getTotalCookie()
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


    public function getOrderDetails(Request $request)
    {
        $request->validate([
            'sale_id' => 'required'
        ]);

        $sale_id = decrypt($request->sale_id);

        $auth = Auth::guard('customer')->user();

        $cartSale = CartSale::where('id', $sale_id)->get()->first();

        if ($cartSale) {
            $shipStation = new ShipStation('42b21befe369478c910ef2b1666bea5e', 'c074d78f698e4cd8b1cc4139f287885b', 'https://ssapi.shipstation.com');
            if ($cartSale->orderId) {
                $orderShipStation = $shipStation->orders->get(['orderNumber' => $cartSale->orderNumber]);
                if (count($orderShipStation->orders) > 0) {
                    $cartSale->statusShipStation = $orderShipStation->orders[0]->orderStatus;
                } else {
                    $cartSale->statusShipStation = 'awaiting_shipment';
                }
            } else {
                $cartSale->statusShipStation = 'awaiting_shipment';
            }
            $output = '';
            $output .= '<div class="tab-pane fade show active" id="tab_1" role="tabpanel" aria-labelledby="timeline-tab">
                                <div class="mt-3 media profile-timeline-media">
                                    <div class="media-body">
                                        <h3 class="py-3 text-dark"><i class="mdi mdi-information"></i> Main Order Information :
                                        </h3>
                                        <table class="table table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th><i class="mdi mdi-account"></i> Order ID: <span style="color:blue;">';
            if (isset($cartSale->id)) {
                $output .= $cartSale->id;
            } else {
                $output .= '<span style="color:red;">Undefined</span>';
            }
            $output .= '</span></th>
                                                    <th><i class="mdi mdi-account"></i> Number Of Product : <span
                                                            style="color:blue;">';
            if (isset($cartSale->product_count)) {
                $output .= $cartSale->product_count . ' products';
            } else {
                $output .= '<span style="color:red;">Undefined</span>';
            }
            $output .= '</span></th>
                                                </tr>
                                                <tr>
                                                    <th><i class="mdi mdi-account"></i> Sub Total : <span
                                                            style="color:blue;">';
            if (isset($cartSale->sub_total)) {
                $output .= $cartSale->sub_total . '<small> $</small>';
            } else {
                $output .= '<span style="color:red;">Undefined</span>';
            }
            $output .= '</span></th>
                                                    <th><i class="mdi mdi-account"></i> Total : <span
                                                            style="color:blue;">';
            if (isset($cartSale->total)) {
                $output .= $cartSale->total . '<small> $</small>';
            } else {
                $output .= '<span style="color:red;">Undefined</span>';
            }
            $output .= '</span></th>
                                                </tr>
                                                <tr>
                                                    <th><i class="mdi mdi-email"></i> Promo Code : <span
                                                            style="color:blue;">';
            if (isset($cartSale->promoCode->promo_code)) {
                $output .= $cartSale->promoCode->promo_code;
            } else {
                $output .= '------';
            }
            $output .= '</span></th>
                                                    <th><i class="mdi mdi-email"></i> Discount : <span
                                                            style="color:blue;">';
            if (isset($cartSale->discount)) {
                $output .= $cartSale->discount . '<small> $</small>';
            } else {
                $output .= '------';
            }
            $output .= '</span></th>
                                                </tr>
                                                <tr>
                                                    <th><i class="mdi mdi-phone"></i> Order Status :';
            if (isset($cartSale->status)) {
                if ($cartSale->status == 'Pendding') {
                    $output .= '<span style="color:rgba(182, 121, 7, 0.87);">' . $cartSale->status . '</span>';
                } elseif ($cartSale->status == 'Accepted') {
                    $output .= '<span style="color:green;">' . $cartSale->status . '</span>';
                } elseif ($cartSale->status == 'Rejected') {
                    $output .= '<span style="color:red;">' . $cartSale->status . '</span>';
                }
            } else {
                $output .= '<span style="color:red;">Undefined</span>';
            }
            $output .= '</th>
                                                    <th><i class="mdi mdi-phone"></i> Payment Status :';
            if (isset($cartSale->payment_status)) {
                if ($cartSale->payment_status == 'Pendding') {
                    $output .= '<span
                                                                    style="color:rgba(182, 121, 7, 0.87);">' . $cartSale->payment_status . '</span>';
                } elseif ($cartSale->payment_status == 'Accepted') {
                    $output .= '<span style="color:green;">' . $cartSale->payment_status . '</span>';
                } elseif ($cartSale->payment_status == 'Rejected') {
                    $output .= '<span style="color:red;">' . $cartSale->payment_status . '</span>';
                }
            } else {
                $output .= '<span>------</span>';
            }
            $output .= '</th>
                                                </tr>
                                                    <tr>
                                                        <th><i class="mdi mdi-phone"></i> Delivery Status :';
            if (isset($cartSale->delivery_status)) {
                if ($cartSale->statusShipStation) {
                    $output .= '<span style="color:rgba(182, 121, 7, 0.87);">' . $cartSale->statusShipStation . '</span>';
                } else {
                    $output .= '<span style="color:red;">' . $cartSale->statusShipStation . '</span>';
                }
            } else {
                $output .= '<span>------</span>';
            }
            $output .= '</th>
                                                        <th><i class="mdi mdi-phone"></i> Shipment Num. :';
            if (isset($cartSale->track_number)) {
                $output .= '<span
                                                                        style="color:blue;">' . $cartSale->track_number . '</span>';
            } else {
                $output .= '<span>------</span>';
            }
            $output .= '</th>
                                                    </tr>
                                                <tr>
                                                    <th><i class="mdi mdi-account-multiple"></i> Customer Email : <span
                                                            style="color:blue;">';
            if (isset($cartSale->customer->email)) {
                $output .= $cartSale->customer->email;
            } else {
                $output .= '<span style="color:red;">Undefined</span>';
            }
            $output .= '</span></th>
                                                    <th><i class="mdi mdi-phone"></i> Customer Phone : <span
                                                            style="color:blue;">';
            if (isset($cartSale->customer->phone)) {
                $output .= $cartSale->customer->phone;
            } else {
                $output .= '<span style="color:red;">Undefined</span>';
            }
            $output .= '</span></th>
                                                </tr>
                                                <tr>
                                                    <th><i class="mdi mdi-clock-outline mdi-spin"></i> Order Added Since : <span
                                                            style="color:blue;">';
            if (isset($cartSale->created_at)) {
                $output .= $cartSale->created_at->diffForHumans();
            } else {
                $output .= '<span style="color:red;">Undefined</span>';
            }
            $output .= '</span></th>
                                                    <th><i class="mdi mdi-clock-outline mdi-spin"></i> Date & Time of Addtion :
                                                        <span style="color:blue;">';
            if (isset($cartSale->created_at)) {
                $output .= date('Y.d.m / h:i A', strtotime($cartSale->created_at));
            } else {
                $output .= '<span style="color:red;">Undefined</span>';
            }
            $output .= '</span>
                                                    </th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>

                                <div class="mt-3 media profile-timeline-media">
                                    <div class="media-body">
                                        <h3 class="py-3 text-dark"><i class="mdi mdi-information"></i> Delivery Information :
                                        </h3>
                                        <table class="table table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th><i class="mdi mdi-account"></i> Name : <span
                                                            style="color:blue;">';
            if (isset($cartSale->location->name)) {
                $output .= $cartSale->location->name;
            } else {
                $output .= '<span style="color:red;">Undefined</span>';
            }
            $output .= '</span></th>
                                                    <th><i class="mdi mdi-account"></i> Email : <span
                                                            style="color:blue;">';
            if (isset($cartSale->location->email)) {
                $output .= $cartSale->location->email;
            } else {
                $output .= '<span style="color:red;">Undefined</span>';
            }
            $output .= '</span></th>
                                                </tr>
                                                <tr>
                                                    <th><i class="mdi mdi-account"></i> Phone : <span
                                                            style="color:blue;">';
            if (isset($cartSale->location->phone)) {
                $output .= $cartSale->location->phone;
            } else {
                $output .= '<span style="color:red;">Undefined</span>';
            }
            $output .= '</span></th>
                                                    <th><i class="mdi mdi-account"></i> Company : <span
                                                            style="color:blue;">';
            if (isset($cartSale->location->company)) {
                $output .= $cartSale->location->company;
            } else {
                $output .= '<span style="color:red;">Undefined</span>';
            }
            $output .= '</span></th>
                                                </tr>
                                                <tr>
                                                    <th><i class="mdi mdi-email"></i> Address : <span
                                                            style="color:blue;">';
            if (isset($cartSale->location->address)) {
                $output .= $cartSale->location->address;
            } else {
                $output .= '------';
            }
            $output .= '</span></th>
                                                    <th><i class="mdi mdi-email"></i> Apt/Unit/Suite/etc. : <span
                                                            style="color:blue;">';
            if (isset($cartSale->location->apartment)) {
                $output .= $cartSale->location->apartment;
            } else {
                $output .= '------';
            }
            $output .= '</span></th>
                                                </tr>
                                                <tr>
                                                    <th><i class="mdi mdi-email"></i> City : <span
                                                            style="color:blue;">';
            if (isset($cartSale->location->city)) {
                $output .= $cartSale->location->city;
            } else {
                $output .= '<span style="color:red;">Undefined</span>';
            }
            $output .= '</span></th>
                                                    <th><i class="mdi mdi-phone"></i><span
                                                        style="color:blue;">';
            if (isset($cartSale->location->state)) {
                $output .= $cartSale->location->state;
            } else {
                $output .= '<span style="color:red;">Undefined</span>';
            }
            $output .= '</span>
                                                    </th>
                                                </tr>
                                                <tr>

                                                    <th><i class="mdi mdi-phone"></i> ZipCode : <span
                                                            style="color:blue;">';
            if (isset($cartSale->location->zipcode)) {
                $output .= $cartSale->location->zipcode;
            } else {
                $output .= '<span style="color:red;">Undefined</span>';
            }
            $output .= '</span></th>
                                                    <th><i class="mdi mdi-phone"></i> Country : <span
                                                            style="color:blue;">';
            if (isset($cartSale->location->country)) {
                $output .= $cartSale->location->country;
            } else {
                $output .= '<span style="color:red;">Undefined</span>';
            }
            $output .= '</span></th>
                                                </tr>

                                                <tr>
                                                    <th colspan="2"><i class="mdi mdi-account-multiple"></i> More Info : <span
                                                            style="color:blue;">';
            if (isset($cartSale->location->more_info)) {
                $output .= $cartSale->location->more_info;
            } else {
                $output .= '<span style="color:red;">Undefined</span>';
            }
            $output .= '</span></th>

                                                </tr>

                                            </thead>
                                        </table>
                                    </div>
                                </div>

                                <div class="mt-3 media profile-timeline-media">
                                    <div class="media-body">';
            if (isset($payment)) {
                $output .= '<h3 class="py-3 text-dark"><i class="mdi mdi-information"></i> Paypal Information :
                                            </h3>
                                            <table class="table table-hover table-striped">
                                                <thead>
                                                    <tr>
                                                        <th><i class="mdi mdi-account"></i> payment ID: <span
                                                                style="color:blue;">';
                if (isset($payment->payment_id)) {
                    $output .= $payment->payment_id;
                } else {
                    $output .= '<span style="color:red;">Undefined</span>';
                }
                $output .= '</span></th>
                                                        <th><i class="mdi mdi-account"></i> Payer ID : <span
                                                                style="color:blue;">';
                if (isset($payment->payer_id)) {
                    $output .= $payment->payer_id;
                } else {
                    $output .= '<span style="color:red;">Undefined</span>';
                }
                $output .= '</span></th>
                                                    </tr>
                                                    <tr>
                                                        <th><i class="mdi mdi-account"></i> Sub Total : <span
                                                                style="color:blue;">';
                if (isset($payment->amount)) {
                    $output .= $payment->amount . '<small> $</small>';
                } else {
                    $output .= '<span style="color:red;">Undefined</span>';
                }
                $output .= '</span></th>
                                                        <th><i class="mdi mdi-account"></i> Total : <span
                                                                style="color:blue;">';
                if (isset($payment->amount)) {
                    $output .= $payment->amount . '<small> $</small>';
                } else {
                    $output .= '<span style="color:red;">Undefined</span>';
                }
                $output .= '</span></th>
                                                    </tr>
                                                    <tr>
                                                        <th><i class="mdi mdi-email"></i> Paypal email : <span
                                                                style="color:blue;">';
                if (isset($payment->payer_email)) {
                    $output .= $payment->payer_email;
                } else {
                    $output .= '------';
                }
                $output .= '</span></th>
                                                        <th> </th>
                                                    </tr>
                                                    <tr>


                                                        <th><i class="mdi mdi-phone"></i> Payment Status :';
                if (isset($cartSale->payment_status)) {
                    if ($cartSale->payment_status == 'Pendding') {
                        $output .= '<span
                                                                        style="color:rgba(182, 121, 7, 0.87);">' . $cartSale->payment_status . '</span>';
                    } elseif ($cartSale->payment_status == 'Accepted') {
                        $output .= '<span style="color:green;">' . $cartSale->payment_status . '</span>';
                    } elseif ($cartSale->payment_status == 'Rejected') {
                        $output .= '<span style="color:red;">' . $cartSale->payment_status . '</span>';
                    }
                } else {
                    $output .= '<span style="color:red;">Undefined</span>';
                }
                $output .= '</th>
                                                    </tr>


                                                    <tr>
                                                        <th><i class="mdi mdi-account-multiple"></i> Customer Email : <span
                                                                style="color:blue;">';
                if (isset($cartSale->customer->email)) {
                    $output .= $cartSale->customer->email;
                } else {
                    $output .= '<span style="color:red;">Undefined</span>';
                }
                $output .= '</span></th>
                                                        <th><i class="mdi mdi-phone"></i> Customer Phone : <span
                                                                style="color:blue;">';
                if (isset($cartSale->customer->phone)) {
                    $output .= $cartSale->customer->phone;
                } else {
                    $output .= '<span style="color:red;">Undefined</span>';
                }
                $output .= '</span></th>
                                                    </tr>
                                                    <tr>
                                                        <th><i class="mdi mdi-clock-outline mdi-spin"></i> Order Added Since :
                                                            <span style="color:blue;">';
                if (isset($cartSale->created_at)) {
                    $output .= $cartSale->created_at->diffForHumans();
                } else {
                    $output .= '<span style="color:red;">Undefined</span>';
                }
                $output .= '</span>
                                                        </th>
                                                        <th><i class="mdi mdi-clock-outline mdi-spin"></i> Date & Time of
                                                            Addtion : <span style="color:blue;">';
                if (isset($cartSale->created_at)) {
                    $output .= date('Y.d.m / h:i A', strtotime($cartSale->created_at));
                } else {
                    $output .= '<span style="color:red;">Undefined</span>';
                }
                $output .= '</span>
                                                        </th>
                                                    </tr>
                                                </thead>
                                            </table>';
            }
            $output .= '<h3 class="py-3 text-dark"><i class="mdi mdi-information"></i> Order Details :
                                        </h3>
                                        <table class="table table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th><span style="color:blue;">Image</th>
                                                    <th><span style="color:blue;">Product</th>
                                                    <th><span style="color:blue;">Quantity</th>
                                                    <th><span style="color:blue;">Unit Price</th>
                                                    <th><span style="color:blue;">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>';
            if (isset($cartSale->cartOperations) && $cartSale->cartOperations->count()) {
                foreach ($cartSale->cartOperations as $cartOperation) {
                    $output .= '<tr>
                                                            <td>';
                    if (isset($cartOperation->product->image) && $cartOperation->product->image && file_exists($cartOperation->product->image)) {
                        $output .= '<img src="' . asset($cartOperation->product->image) . '"
                                                                        alt="" width="90">';
                    } elseif (isset($cartOperation->product->image_url) && $cartOperation->product->image_url != null) {
                        $output .= '<img src="' . $cartOperation->product->image_url . '"
                                                                            alt="" width="90">';
                    } else {
                        $output .= '<img src="' . asset('front_end_style/images/default.png') . '"
                                                                        alt="" width="100">';
                    }
                    $output .= '</td>
                                                            <td>';
                    if (isset($cartOperation->product->name_en)) {
                        $output .= $cartOperation->product->name_en;
                    } else {
                        $output .= '<span style="color: red;">Undefined</span>';
                    }
                    $output .= '</td>
                                                            <td>';
                    if (isset($cartOperation->quantity)) {
                        $output .= $cartOperation->quantity;
                    } else {
                        $output .= 0;
                    }
                    $output .= '</td>
                                                            <td>';
                    if (isset($cartOperation->unit_price)) {
                        $output .= $cartOperation->unit_price . '<small> $</small>';
                    } else {
                        $output .= '<span style="color: red;">Undefined</span>';
                    }
                    $output .= '</td>
                                                            <td>';
                    if (isset($cartOperation->quantity) && isset($cartOperation->unit_price)) {
                        $output .= $cartOperation->quantity * $cartOperation->unit_price . '<small> $</small>';
                    } else {
                        $output .= '<span style="color: red;">Undefined</span>';
                    }
                    $output .= '</td>

                                                        </tr>';
                }
            }
            $output .= '<tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>';


            return response()->json(['status' => true, 'output' => $output]);
        }
    }
}
