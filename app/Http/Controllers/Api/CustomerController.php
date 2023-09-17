<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CartOperation;
use App\Models\CartSale;
use App\Models\CartTemp;
use App\Models\Customer;
use App\Models\ProdSzeClrRelation;
use App\Models\Product;
use App\Models\ProductWishlist;
use App\Models\PromoCode;
use App\Models\UsedPromoCode;
use App\Models\UserLocation;
use App\Traits\GeneralTrait;
use App\Traits\SharedMethod;
use App\Traits\UploadImageTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Sanctum\PersonalAccessToken;

class CustomerController extends Controller
{

    use UploadImageTrait;
    use SharedMethod;
    use GeneralTrait;



    function login(Request $request)
    {
        $rules = [
            'email' => ['required'],
            'lang' => ['required'],
            'device_id' => ['required'],
            'password' => ['required']
        ];

        $messages = [
            'lang.required' => __('validator_api.lang_required'),
            'device_id.required' => __('validator_api.device_id_required'),
        ];

        if (is_numeric($request->email)) {
            $rules['country_key'] = ['required'];
        }

        app()->setLocale($request->lang);

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'msg' => $validator->errors()->toArray()]);
        }


        if (filter_var($request->get('email'), FILTER_VALIDATE_EMAIL)) {
            if (Auth::guard('customer_api')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {

                $old_user = Customer::where('email', $request->email)->get()->first();

                PersonalAccessToken::where('tokenable_type', 'App\Models\Customer')->where('tokenable_id', $old_user->id)->whereNull('expires_at')->update([
                    'expires_at' => Carbon::yesterday()->format('Y-m-d H:i:s')
                ]);

                //generate the token for the user
                $token = auth()->guard('customer_api')->user()->createToken('MyApp')->plainTextToken;

                // Get some user from somewhere
                $user = auth('customer_api')->user();

                return $this->respondWithToken($token, $user, __('api.You_registered_successfully'), true);
            } else {
                return response()->json(['status' => false, 'messages' => __('api.email_incorrect')]);
            }
        } elseif (is_numeric($request->email)) {

            if (Auth::guard('customer_api')->attempt(['country_key' => $request->country_key, 'phone' => $request->email, 'password' => $request->password], $request->get('remember'))) {
                // return 'sadsdasa';
                $old_user = Customer::where('phone', $request->email)->get()->first();

                PersonalAccessToken::where('tokenable_type', 'App\Models\Customer')->where('tokenable_id', $old_user->id)->whereNull('expires_at')->update([
                    'expires_at' => Carbon::yesterday()->format('Y-m-d H:i:s')
                ]);

                //generate the token for the user
                $token = auth()->guard('customer_api')->user()->createToken('MyApp')->plainTextToken;

                // Get some user from somewhere
                $user = auth('customer_api')->user();


                return $this->respondWithToken($token, $user, __('api.You_registered_successfully'), true);
            } else {
                return response()->json(['status' => false, 'messages' => __('api.phone_incorrect')]);
            }
        }
    }


    function register(Request $request)
    {



        $rules = [
            'device_id' => ['required'],
            'lang' => ['required'],
            'name_en' => ['required'],
            'country_key' => ['required'],
            'phone' => ['required', 'numeric', Rule::unique('customers')->where(function ($query) use ($request) {
                return $query->where('country_key', $request->country_key);
            })],
            'email' => ['nullable', 'email', 'unique:customers,email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ];
        $messages = [
            'device_id.required' => __('validator_api.device_id_required'),
            'lang.required' => __('validator_api.lang_required'),
        ];


        app()->setLocale($request->lang);


        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {

            return response()->json(['status' => false, 'msg' => $validator->errors()->toArray()]);
        }




        $created_data = [
            'name_en' => $request->name_en,
            'username' => $request->name_en,
            'email' => $request->email,
            'phone' => $request->phone,
            'country_key' => $request->country_key,
            'password' => Hash::make($request->password),
            'user_status' => 2, // Active
            'created_by' => 1,
            'phone_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'player_id' => $request->player_id
        ];

        $user = Customer::create($created_data);


        $success['token'] =  $user->createToken('MyApp')->plainTextToken;
        $success['name'] =  $user->name_en;


        return $this->respondWithToken($success['token'], $user, __('api.You_registered_successfully'), true);
    }


    // ================================================================
    // ================== respondWithToken Function ===================
    // ===================By : Mohammed Al-Jazi =======================
    // ================================================================
    protected function respondWithToken($token, $user, $message)
    {
        return response()->json([
            'access_token' => $token,
            'status' => true,
            'msg' => $message,
            'user' => [
                'id' => $user->id,
                'name' => $user->name_en == null ? "" : $user->name_en,
                'email' => $user->email == null ? "" : $user->email,
                'profile_photo_path' => $user->profile_photo_path == null ? "" : url($user->profile_photo_path),
                'phone' => $user->phone,
            ],
            'token_type' => 'bearer'
        ]);
    }




    // ==================================================================
    // ======================= Add To Cart Function =====================
    // ====================== By : Mohammed Al-Jazi =====================
    // ==================================================================
    function addToCart(Request $request)
    {
        $rules = [
            'device_id' => ['required'],
            'lang' => ['required'],
            'product_id' => ['required'],
            'quantity' => ['required']
        ];
        $messages = [
            'device_id.required' => __('validator_api.device_id_required'),
            'lang.required' => __('validator_api.lang_required'),
        ];


        app()->setLocale($request->lang);


        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {

            return response()->json(['status' => false, 'msg' => $validator->errors()->toArray()]);
        }

        $token = PersonalAccessToken::findToken($request->bearerToken());


        if ($token) {
            $user = $token->tokenable;
            if ($user) {


                $product = Product::where('id', $request->product_id)->get()->first();
                if ($product) {
                    if (isset($product->properties) && $product->properties->count() > 0) {
                        if (isset($request->property_id) && $request->property_id != "") {
                            $property = ProdSzeClrRelation::find($request->property_id);
                            if ($property) {
                                if ($property->quantity_available < $request->quantity) {
                                    return $this->returnError('Quantity not available !!!');
                                }

                                $old_cart = CartTemp::where([['user_id', $user->id], ['user_type', 'Customer'], ['property_type', 1], ['product_id', $request->property_id]])->get()->first();

                                if ($old_cart) {

                                    if ($property->quantity_available < $request->quantity + 1) {
                                        return $this->returnError('Quantity not available !!!');
                                    }

                                    $old_cart->update([
                                        'quantity' => $request->quantity  + 1
                                    ]);
                                } else {
                                    if (isset($user->cartTemps) && $user->cartTemps->count() > 0) {
                                        if ($user->cartTemps->count() > 20) {
                                            return $this->returnError('You Cant Add More Than 20 Item In Cart !!!');
                                        }
                                    }


                                    CartTemp::create([
                                        'user_id' => $user->id,
                                        'user_type' => 'Customer',
                                        'product_id' => $property->id,
                                        'property_type' => 1,
                                        'quantity' => $request->quantity,
                                    ]);
                                }


                                return $this->returnSuccessMessage('Item Successfully Added To Cart');
                            } else {
                                return $this->returnError('Attribute Not found !!!');
                            }
                        } else {
                            return $this->returnError('Attribute Not found !!!');
                        }
                    } else {

                        if ($product->quantity_available < $request->quantity) {
                            return $this->returnError('Quantity not available !!!');
                        }

                        $old_cart = CartTemp::where([
                            ['user_id', $user->id],
                            ['product_id', $product->id],
                            ['user_type', 'Customer'],
                            ['property_type', 2]
                        ])->get()->first();

                        if ($old_cart) {

                            if ($product->quantity_available < $request->quantity + 1) {
                                return $this->returnError('Quantity not available !!!');
                            }

                            $old_cart->update([
                                'quantity' => $request->quantity + 1
                            ]);
                        } else {

                            if (isset($user->cartTemps) && $user->cartTemps->count() >= 20) {
                                return $this->returnError('You Cant Add More Than 20 Item In Cart !!!');
                            }

                            CartTemp::create([
                                'user_id' => $user->id,
                                'user_type' => 'Customer',
                                'product_id' => $product->id,
                                'property_type' => 2,
                                'quantity' => $request->quantity,
                            ]);
                        }
                        return $this->returnSuccessMessage('Item Successfully Added To Cart');
                    }
                } else {
                    return $this->returnError('Item Not found !!!');
                }
            } else {
                return response()->json(['status' => false, 'messages' => __('api.unautherized')]);
            }
        }
    }





    // ==================================================================
    // ======================= Get Cart Function ========================
    // ====================== By : Mohammed Al-Jazi =====================
    // ==================================================================
    function getCart(Request $request)
    {
        $rules = [
            'device_id' => ['required'],
            'lang' => ['required']
        ];
        $messages = [
            'device_id.required' => __('validator_api.device_id_required'),
            'lang.required' => __('validator_api.lang_required'),
        ];


        app()->setLocale($request->lang);


        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {

            return response()->json(['status' => false, 'msg' => $validator->errors()->toArray()]);
        }

        $token = PersonalAccessToken::findToken($request->bearerToken());


        if ($token) {
            $user = $token->tokenable;
            if ($user) {
                $carts = CartTemp::where('user_id', $user->id)->where('user_type', 'Customer')->select([
                    'id', 'product_id', 'property_type', 'quantity'
                ])->get();


                if (isset($carts) && $carts->count() > 0) {
                    foreach ($carts as $cart) {
                        if ($cart->property_type == 1) {
                            $cart->product_name = $cart->product->product->name;
                            $cart->get_size = $cart->product->size->name_en;
                            $cart->get_color = $cart->product->color->color_code;
                            $cart->get_color_img =  $cart->product->color->color_code == null ? "" : url($cart->product->color->color_code);
                            $cart->product_img =  $cart->product->image == null ? (($cart->product->image_url) == null ? url('/') . '/images_default/no_image.png' :  $cart->product->image_url) : url($cart->product->image);

                            $cart->makeHidden(['product', 'size', 'color']);
                        } else {
                            $cart->product_name = $cart->product->name;
                            $cart->get_size = "";
                            $cart->get_color = "";
                            $cart->get_color_img = "";
                            $cart->product_img =  $cart->product->image == null ? (($cart->product->image_url) == null ? url('/') . '/images_default/no_image.png' :  $cart->product->image_url) : url($cart->product->image);
                            $cart->makeHidden(['product', 'size', 'color']);
                        }

                        $cart->product_price = $cart->product->sale_price;
                        $cart->product_on_sale_price_status = $cart->product->getRawOriginal('on_sale_price_status');
                        $cart->product_on_sale_price = $cart->product->on_sale_price;
                        $cart->product_available_quantity = $cart->product->quantity_available;
                    }

                    return $this->returnData('data', $carts);
                } else {
                    return $this->returnError('Cart is empty !!!');
                }
            } else {
                return response()->json(['status' => false, 'messages' => __('api.unautherized')]);
            }
        }
    }
    // ==================================================================
    // ======================= Get getOrders Function ========================
    // ====================== By : Mohammed Al-Jazi =====================
    // ==================================================================
    function getOrders(Request $request)
    {


        app()->setLocale($request->lang);



        $token = PersonalAccessToken::findToken($request->bearerToken());


        if ($token) {
            $user = $token->tokenable;
            if ($user) {
                $carts = CartSale::where('user_id', $user->id)->select([
                    'id','user_id','location_id','product_count',
                    'discount','promo_code_id','sub_total','total','status','payment_status','payment_method',
                    DB::raw('DATE_FORMAT(created_at,\'%b %d,%Y %H:%i\') as date'),'orderNumber'
                ])->get();




                if (isset($carts) && $carts->count() > 0) {
                    foreach ($carts as $cart) {
                        $location=$cart->location;
                        $order_oparations=$cart->cartOperations;

                        foreach ($order_oparations as $order_oparation) {

                            if ($order_oparation->property_type == 1) {
                                $order_oparation->product_name = $order_oparation->product->product->name;
                                $order_oparation->get_size = $order_oparation->product->size->name_en;

                                $order_oparation->get_color = str_replace('#','',$order_oparation->product->color->color_code);
                                $order_oparation->get_color_img =  $order_oparation->product->color->color_code == null ? "" : url($order_oparation->product->color->color_code);
                                $order_oparation->product_img =  $order_oparation->product->image == null ? (($order_oparation->product->image_url) == null ? url('/') . '/images_default/no_image.png' :  $order_oparation->product->image_url) : url($order_oparation->product->image);

                                $order_oparation->makeHidden(['product', 'size', 'color','created_at','updated_at']);
                            } else {
                                $order_oparation->product_name = $order_oparation->product->name;
                                $order_oparation->get_size = "";
                                $order_oparation->get_color = "";
                                $order_oparation->get_color_img = "";
                                $order_oparation->product_img =  $order_oparation->product->image == null ? (($order_oparation->product->image_url) == null ? url('/') . '/images_default/no_image.png' :  $order_oparation->product->image_url) : url($order_oparation->product->image);
                                $order_oparation->makeHidden(['product', 'size', 'color','created_at','updated_at']);
                            }

                            $order_oparation->product_price = $order_oparation->product->sale_price;
                            $order_oparation->product_on_sale_price_status = $order_oparation->product->getRawOriginal('on_sale_price_status');
                            $order_oparation->product_on_sale_price = $order_oparation->product->on_sale_price;
                            $order_oparation->product_available_quantity = $order_oparation->product->quantity_available;

                    }
                }

                    return $this->returnData('data', $carts);
                } else {
                    return $this->returnData('data', []);
                }
            } else {
                return response()->json(['status' => false, 'messages' => __('api.unautherized')]);
            }
        }
    }


    // ==================================================================
    // ======================= Get Wishlist Function ========================
    // ====================== By : Mohammed Al-Jazi =====================
    // ==================================================================
    function getWishlist(Request $request)
    {


        app()->setLocale($request->lang);



        $token = PersonalAccessToken::findToken($request->bearerToken());


        if ($token) {
            $user = $token->tokenable;
            if ($user) {
                $wishlists = ProductWishlist::where('customer_id', $user->id)->get();


                if (isset($wishlists) && $wishlists->count() > 0) {
                    foreach ($wishlists as $wishlist) {
                        if ($wishlist->property_type == 1) {
                            $wishlist->product_name = $wishlist->product->product->name;
                            $wishlist->get_size = $wishlist->product->size->name_en;
                            $wishlist->get_color = $wishlist->product->color->color_code;
                            $wishlist->get_color_img =  $wishlist->product->color->color_code == null ? "" : url($wishlist->product->color->color_code);
                            $wishlist->product_img =  $wishlist->product->image == null ? (($wishlist->product->image_url) == null ? url('/') . '/images_default/no_image.png' :  $wishlist->product->image_url) : url($wishlist->product->image);

                            $wishlist->makeHidden(['product', 'size', 'color']);
                        } else {
                            $wishlist->product_name = $wishlist->product->name;
                            $wishlist->get_size = "";
                            $wishlist->get_color = "";
                            $wishlist->get_color_img = "";
                            $wishlist->product_img =  $wishlist->product->image == null ? (($wishlist->product->image_url) == null ? url('/') . '/images_default/no_image.png' :  $wishlist->product->image_url) : url($wishlist->product->image);
                            $wishlist->makeHidden(['product', 'size', 'color']);
                        }

                        $wishlist->product_price = $wishlist->product->sale_price;
                        $wishlist->product_on_sale_price_status = $wishlist->product->getRawOriginal('on_sale_price_status');
                        $wishlist->product_on_sale_price = $wishlist->product->on_sale_price;
                        $wishlist->product_available_quantity = $wishlist->product->quantity_available;
                    }

                    return $this->returnData('data', $wishlists);
                } else {
                    return $this->returnData('data',[]);
                }
            } else {
                return response()->json(['status' => false, 'messages' => __('api.unautherized')]);
            }
        }
    }


      //add Wishlist
      public function addWishlist(Request $request)
      {

          $rules = [
              'product_id' => ['required'],
          ];

          $messages = [
              'product_id.required' => __('validator_api.product_id_required'),
          ];


          //تغيير الغة



          $validator = Validator::make($request->all(), $rules, $messages);

          if ($validator->fails())
              return response()->json(['status' => false, 'messages' => $validator->errors()->toArray()]);

          $token = PersonalAccessToken::findToken($request->bearerToken());


          if ($token) {
              $customer = $token->tokenable;
              $wishlist = ProductWishlist::where('product_id', $request->product_id)->where('customer_id', $customer->id)->get()->first();

              if ($wishlist) {
                  $wishlist->delete();
              } else {
                ProductWishlist::create([
                    'customer_id' => $customer->id,
                    'product_id' => $request->product_id,
                ]);
                  // return $x;
                  return response()->json(['status' => true, 'messages' => __('validator_api.The_information_been_successfully_added')]);

              }



          } else {
              return response()->json(['status' => false, 'messages' => __('api.unautherized')]);
          }
      }


    // ==================================================================
    // ======================= Update Cart Function =====================
    // ====================== By : Mohammed Al-Jazi =====================
    // ==================================================================
    function updateCart(Request $request)
    {
        $rules = [
            'device_id' => ['required'],
            'lang' => ['required'],
            'cart_id' => ['required'],
            'quantity' => ['required']
        ];
        $messages = [
            'device_id.required' => __('validator_api.device_id_required'),
            'lang.required' => __('validator_api.lang_required'),
        ];


        app()->setLocale($request->lang);


        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {

            return response()->json(['status' => false, 'msg' => $validator->errors()->toArray()]);
        }

        $token = PersonalAccessToken::findToken($request->bearerToken());


        if ($token) {
            $user = $token->tokenable;
            if ($user) {
                $cart = CartTemp::find($request->cart_id);

                if ($cart) {
                    if ($request->quantity > $cart->product->quantity_available) {
                        return $this->returnError('quantity Not Available !!!!!');
                    }

                    if ($request->quantity == 0) {
                        $cart->delete();
                    } else {
                        $cart->update([
                            'quantity' => $request->quantity
                        ]);
                    }

                    return $this->returnSuccessMessage('Cart Updated Successfully');
                } else {
                    return $this->returnError('Cart is empty !!!');
                }
            } else {
                return response()->json(['status' => false, 'messages' => __('api.unautherized')]);
            }
        }
    }





    // ==================================================================
    // ========================== Checkout Function =====================
    // ====================== By : Mohammed Al-Jazi =====================
    // ==================================================================
    function checkout(Request $request)
    {
        $rules = [
            'device_id' => ['required'],
            'lang' => ['required'],
            // 'location_id' => ['required']
        ];
        $messages = [
            'device_id.required' => __('validator_api.device_id_required'),
            'lang.required' => __('validator_api.lang_required'),
        ];


        app()->setLocale($request->lang);


        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {

            return response()->json(['status' => false, 'msg' => $validator->errors()->toArray()]);
        }

        $token = PersonalAccessToken::findToken($request->bearerToken());


        if ($token) {
            $user = $token->tokenable;
            if ($user) {

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
                                $total_price = $this->totalPrice($user, $coupan);
                                $endTotal = $total_price->endTotal;
                                if (isset($endTotal) && $endTotal > 0) {

                                    UsedPromoCode::create([
                                        "customer_id" => $user->id,
                                        "promo_code_id" => $coupan->id,
                                        "status" => 1,
                                    ]);

                                    $discountValue = $total_price->discountValue ?? 0;
                                    $price_count = $total_price->count();
                                } else
                                    return response()->json(['status' => false, 'messages' => 'Error .']);
                            } else {
                                return response()->json(['status' => false, 'messages' => 'This coupon has been used before .']);
                            }
                        } else {
                            return response()->json(['status' => false, 'messages' => 'Coupon card not available .']);
                        }
                    } else {
                        $endTotal = $this->totalPrice($user)?->endTotal;
                        $price_count = $this->totalPrice($user)->count();
                        $coupan = null;
                        $usedPromoCode = null;
                        $discountValue = 0;
                    }


                    // return $price_count;

                    DB::transaction(function () use ($user, $request, $price_count, $coupan, $endTotal, $discountValue, $carts) {
                        $order_num = $user->id . mb_substr($user->name, 0, 1) . time();
                        $CartSale = CartSale::create([
                            'user_id' => $user->id,
                            'location_id' => $request->location_id,
                            'product_count' => $carts->count(),
                            'discount' => $coupan != null  ? $discountValue : null,
                            'promo_code_id' => $coupan != null ? $coupan->id : null,
                            'sub_total' => $endTotal,
                            'total' => $endTotal - $discountValue,
                            'status' => 1,
                            'orderNumber' => $order_num,
                            'payment_status' => 1
                        ]);

                        foreach ($carts as $cart) {

                            if ($cart->product->on_sale_price_status == 'Active') {
                                $endTotal += $cart->quantity * $cart->product->on_sale_price;
                                $sub_total = $cart->quantity * $cart->product->on_sale_price;
                            } else {
                                $endTotal += $cart->quantity * $cart->product->sale_price;
                                $sub_total = $cart->quantity * $cart->product->sale_price;
                            }

                            CartOperation::create([
                                "cart_sale_id" => $CartSale->id,
                                "product_id" => $cart->product->id,
                                "unit_price" => $cart->product->sale_price,
                                "sub_total" => $sub_total,
                                "total" => $endTotal,
                                "quantity" => $cart->quantity,
                                "property_type" => $cart->property_type
                            ]);
                        }

                        CartTemp::where('user_id', $user->id)->delete();
                    });

                    return $this->returnSuccessMessage('Order purchased');
                } else {
                    return $this->returnError('Cart is Empty !!!');
                }
            } else {
                return response()->json(['status' => false, 'messages' => __('api.unautherized')]);
            }
        }
    }



    // ارجاع السعر في سله المشتريات
    function totalPrice($user, $promoCode = null)
    {
        $TotalPromoCode = 0;
        if ($user && !$promoCode) {

            $carts = CartTemp::where(['user_id' => $user->id])->get();
            $endTotal = 0;
            foreach ($carts as $cart) {

                $sub_total = 0;

                if ($cart->product->on_sale_price_status == 'Active') {
                    $endTotal += $cart->quantity * $cart->product->on_sale_price;
                    $sub_total = $cart->quantity * $cart->product->on_sale_price;
                } else {
                    $endTotal += $cart->quantity * $cart->product->sale_price;
                    $sub_total = $cart->quantity * $cart->product->sale_price;
                }
                $cart->sub_total = $sub_total;
            }
            $cart->discountValue = 0;
            $cart->endTotal = $endTotal;
            return $cart;
        } else if ($user || $promoCode) {

            $carts = CartTemp::where(['user_id' => $user->id])->get();
            $endTotal = 0;


            foreach ($carts as $cart) {
                $sub_total = 0;

                if ($cart->product_type == 1) {
                    $cart->product = ProdSzeClrRelation::find($cart->product_id);
                } else {
                    $cart->product = Product::find($cart->product_id);
                }
                if ($cart->product->on_sale_price_status == 'Active') {
                    $endTotal += $cart->quantity * $cart->product->on_sale_price;
                    $sub_total = $cart->quantity * $cart->product->on_sale_price;
                } else {
                    $endTotal += $cart->quantity * $cart->product->sale_price;
                    $sub_total = $cart->quantity * $cart->product->sale_price;
                }

                $cart->sub_total = $sub_total;


                $TotalPromoCode += $sub_total;
            }

            $discountValue = 0;

            $discountValue = number_format((($TotalPromoCode * $promoCode->promo_value) / 100), 2);


            $carts->discountValue = $discountValue;
            $carts->endTotal = $endTotal;
            return $carts;
        } else
            return null;
    }



    //ارجاع العناوين كافه
    public function getAddress(Request $request)
    {

        $rules = [
            'lang' =>  'required',
            'device_id' => 'required',
        ];

        $messages = [
            'lang.required' => __('validator_api.lang_required'),
            'device_id.required' => __('validator_api.device_id_required'),
        ];

        //تغيير الغة

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails())
            return response()->json(['status' => false, 'messages' => $validator->errors()->toArray()]);


        $token = PersonalAccessToken::findToken($request->bearerToken());


        if ($token) {
            $customer = $token->tokenable;

            $address = UserLocation::where('user_id', $customer->id)->get();
            if ($address) {
                return $this->returnData('data', $address);
            }
            return response()->json(['status' => false, 'messages' => __('api.address_not_found')]);
        } else {
            return response()->json(['status' => false, 'messages' => __('api.unautherized')]);
        }
    }

    //حذف العناوين
    public function deleteAddress(Request $request)
    {
        // return 'sdds';
        $rules = [
            'lang' =>  'required',
            'device_id' => 'required',
            // 'location_id' => 'location_id',
        ];

        $messages = [
            'lang.required' => __('validator_api.lang_required'),
            'device_id.required' => __('validator_api.device_id_required'),
            // 'location_id.required' =>'location id is required',
        ];

        //تغيير الغة

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails())
            return response()->json(['status' => false, 'messages' => $validator->errors()->toArray()]);


        $token = PersonalAccessToken::findToken($request->bearerToken());


        if ($token) {

            UserLocation::where('id', $request->location_id)->delete();

            return $this->returnSuccessMessage('address deleted !!!');
        } else {
            return response()->json(['status' => false, 'messages' => __('api.unautherized')]);
        }
    }



    //اضافة موقع
    public function addAddress(Request $request)
    {

        $rules = [
            'lang' => ['required'],
            'device_id' => ['required'],
            'email' => ['nullable', 'email:rfc,dns'],
            'phone' => ['required'],
            'name' => ['required'],
            'company' => ['nullable'],
            'address' => ['required'],
            'apartment' => ['required'],
            'city' => ['required'],
            'state' => ['nullable'],
            'zipcode' => ['nullable'],
            'country' => ['required'],
            'more_info' => ['nullable']
        ];

        $messages = [
            'lang.required' => __('validator_api.lang_required'),
            'device_id.required' => __('validator_api.device_id_required'),
            'email.required' => __('validator_api.email_is_required'),
            'email.email' => __('validator_api.Email_not_valid'),
            'name.required' => __('validator_api.name_is_required'),
            'address.required' => __('validator_api.address_required'),
            'city.required' => __('validator_api.city_required'),
            'state.required' => __('validator_api.state_required'),
            'zipcode.required' => __('validator_api.zipcode_required'),
            'zipcode.numeric' => __('validator_api.country_numeric'),
            'country.required' => __('validator_api.country_required'),
            'latitudes.required' => __('validator_api.latitudes_required'),
            'longitude.required' => __('validator_api.longitude_required')
        ];


        //تغيير الغة



        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails())
            return response()->json(['status' => false, 'messages' => $validator->errors()->toArray()]);

        $token = PersonalAccessToken::findToken($request->bearerToken());


        if ($token) {
            $customer = $token->tokenable;


            DB::transaction(function () use ($request, $customer) {

                UserLocation::create([
                    'user_id' => $customer->id,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'name' => $request->name,
                    'company' => $request->company,
                    'address' => $request->address,
                    'apartment' => $request->apartment,
                    'city' => $request->city,
                    'state' => $request->state,
                    'zipcode' => $request->zipcode,
                    'country' => $request->country,
                    'more_info' => $request->more_info
                ]);
            });

            return response()->json(['status' => true, 'messages' => __('validator_api.The_information_been_successfully_added')]);
        } else {
            return response()->json(['status' => false, 'messages' => __('api.unautherized')]);
        }
    }




    // معلومات الفاتورة قبل تسجيلها
    function checkoutData(Request $request)
    {
        $rules = [
            'device_id' => ['required'],
            'lang' => ['required'],
            // 'location_id' => ['required']
        ];
        $messages = [
            'device_id.required' => __('validator_api.device_id_required'),
            'lang.required' => __('validator_api.lang_required'),
        ];


        app()->setLocale($request->lang);


        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {

            return response()->json(['status' => false, 'msg' => $validator->errors()->toArray()]);
        }

        $token = PersonalAccessToken::findToken($request->bearerToken());


        if ($token) {
            $user = $token->tokenable;
            if ($user) {

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
                                $total_price = $this->totalPrice($user, $coupan);
                                $endTotal = $total_price->endTotal;
                                if (isset($endTotal) && $endTotal > 0) {

                                    UsedPromoCode::create([
                                        "customer_id" => $user->id,
                                        "promo_code_id" => $coupan->id,
                                        "status" => 1,
                                    ]);

                                    $discountValue = $total_price->discountValue ?? 0;
                                    $price_count = $total_price->count();
                                } else
                                    return response()->json(['status' => false, 'messages' => 'Error .']);
                            } else {
                                return response()->json(['status' => false, 'messages' => 'This coupon has been used before .']);
                            }
                        } else {
                            return response()->json(['status' => false, 'messages' => 'Coupon card not available .']);
                        }
                    } else {
                        $endTotal = $this->totalPrice($user)?->endTotal;
                        $price_count = $this->totalPrice($user)->count();
                        $coupan = null;
                        $usedPromoCode = null;
                        $discountValue = 0;
                    }


                    $data = [
                        'total' => $endTotal,
                        'item_count' => $price_count,
                        'coupon' => $coupan,
                        'discountValue' => $discountValue
                    ];


                    return $this->returnData('data', $data);
                } else {
                    return $this->returnError('Cart is Empty !!!');
                }
            } else {
                return response()->json(['status' => false, 'messages' => __('api.unautherized')]);
            }
        }
    }

    // ==================================================================
    // ======================= Update password Function =====================
    // ====================== By : Mohammed Al-Jazi =====================
    // ==================================================================
    function updatePassword(Request $request)
    {
        $rules = [
            'device_id' => ['required'],
            'lang' => ['required'],
            'password' => ['required'],
            'password_confirmation' => ['required']
        ];
        $messages = [
            'device_id.required' => __('validator_api.device_id_required'),
            'lang.required' => __('validator_api.lang_required'),
        ];


        app()->setLocale($request->lang);


        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {

            return response()->json(['status' => false, 'msg' => $validator->errors()->toArray()]);
        }

        $token = PersonalAccessToken::findToken($request->bearerToken());


        if ($token) {
            $user = $token->tokenable;
            if ($user) {
                $user_password = Customer::find($user->id);

                if ($user_password) {
                    if ($user_password->password || $user_password->password_confirmation) {
                        if ($request->password != $request->password_confirmation) {
                            return $this->returnError('Password does not match !!!');
                        } else {
                            $user_password->update([
                                'password' =>  Hash::make($request->password)
                            ]);
                            return $this->returnSuccessMessage('Password Updated Successfully');
                        }
                    }
                }
            } else {
                return response()->json(['status' => false, 'messages' => __('api.unautherized')]);
            }
        }
    }

    public function logout(Request $request)

    {
        $token = PersonalAccessToken::findToken($request->bearerToken());

        if ($token) {
            $user = $token->tokenable;

            if ($user) {
                $token->expires_at = Carbon::now(); // Set token expiration to the current time
                $token->save(); // Save the updated token

                return response()->json(['message' => 'Logged out successfully']);
            } else {
                return response()->json(['status' => false, 'message' => __('api.unauthorized')]);
            }
        } else {
            return response()->json(['status' => false, 'message' => __('api.unauthorized')]);
        }
    }

    public function deleteUserAccount(Request $request)

    {
        $token = PersonalAccessToken::findToken($request->bearerToken());

        if ($token) {
            $user = $token->tokenable;

            if ($user) {
                $user->delete();

                return response()->json(['message' => 'Account deleted successfully']);
            } else {
                return response()->json(['status' => false, 'message' => __('api.unauthorized')]);
            }
        } else {
            return response()->json(['status' => false, 'message' => __('api.unauthorized')]);
        }
    }

}
