<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use App\Models\Banner;
use App\Models\Brand;
use App\Models\ContactUs;
use App\Models\ContactUsRequest;
use App\Models\Faq;
use App\Models\MainCategory;
use App\Models\PrivacyPolicy;
use App\Models\ProdSzeClrRelation;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductWishlist;
use App\Models\PropertyImage;
use App\Models\Slider;
use App\Traits\GeneralTrait;
use App\Traits\SharedMethod;
use App\Traits\UploadImageTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
use Laravel\Sanctum\PersonalAccessToken;

class FrontEndController extends Controller
{
    use UploadImageTrait;
    use SharedMethod;
    use GeneralTrait;

    function getHomePageData(Request $request)
    {
        $rules = [
            'lang' => ['required'],

        ];
        $messages = [
            'device_id.required' => __('validator_api.device_id_required'),
            'lang.required' => __('validator_api.lang_required'),
        ];



        if (isset($request->lang) && $request->lang == 'ar') {
            app()->setLocale('ar');
        } else {
            app()->setLocale('en');
        }

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails())
            return response()->json(['status' => false, 'messages' => $validator->errors()->toArray()]);



        $lang = Config::get('app.locale');



        $banners = Banner::where('page', 'Mobile')->where('status', 1)->select([
            'id',
            DB::raw('IFNULL(CONCAT("' . url('/') . '/",image),CONCAT("' . url('/') . '/","images_default/no_image.png")) as image')
        ])->inRandomOrder()->limit(6)->get();


        $categories = MainCategory::whereHas('products')->where('status', 1)->select(['id', 'name_' . $lang . ' AS category_name', DB::raw('IFNULL(CONCAT("' . url('/') . '/",image),CONCAT("' . url('/') . '/","images_default/no_image.png")) as image')])->inRandomOrder()->limit(6)->get();




        $brands = Brand::where('status', 1)->where('image', '!=', null)->select([DB::raw('IFNULL(CONCAT("' . url('/') . '/",image),CONCAT("' . url('/') . '/","images_default/no_image.png")) as image')])->limit(5)->get();


        $high_rated = Product::where('status', 1)
            ->select([
                'id',
                'sub_category_id',
                'name_' . $lang . ' AS product_name',
                'main_description_' . $lang . ' AS product_main_description',
                'sub_description_' . $lang . ' AS product_sub_description',
                'sale_price AS product_sale_price',
                'on_sale_price_status AS product_on_sale_price_status',
                'on_sale_price AS product_on_sale_price',
                DB::raw('IFNULL(CONCAT("' . url('/') . '/",image),IFNULL(image_url,CONCAT("' . url('/') . '/","images_default/no_image.png"))) AS product_image'),
            ])->withCount('productReviews')->withAvg("productReviews", "review_value")->get()->sortByDesc(function ($q) {
                return $q->productReviews->avg('review_value');
        })->take(4);


        $recent_products = Product::where('status', 1)
            ->where('created_at', '>=', Carbon::now()->subDays(60)->toDateTimeString())
            ->select([
                'id',
                'sub_category_id',
                'name_' . $lang . ' AS product_name',
                'main_description_' . $lang . ' AS product_main_description',
                'sub_description_' . $lang . ' AS product_sub_description',
                'sale_price AS product_sale_price',
                'on_sale_price_status AS product_on_sale_price_status',
                'on_sale_price AS product_on_sale_price',
                DB::raw('IFNULL(CONCAT("' . url('/') . '/",image),IFNULL(image_url,CONCAT("' . url('/') . '/","images_default/no_image.png"))) AS product_image'),
            ])->limit(4)->withCount('productReviews')->withAvg("productReviews", "review_value")
        ->get();


        $best_prop = ProdSzeClrRelation::where('status', 1)->whereHas('cartOperations')->get()->sortByDesc(function ($q) {
            return $q->cartOperations->count();
        })->pluck('product_id');

        $best_selling = Product::where('status', 1)
            ->whereHas('cartOperations')
            ->orWhereIn('id', $best_prop)
            ->select([
                'id',
                'sub_category_id',
                'name_' . $lang . ' AS product_name',
                'main_description_' . $lang . ' AS product_main_description',
                'sub_description_' . $lang . ' AS product_sub_description',
                'sale_price AS product_sale_price',
                'on_sale_price_status AS product_on_sale_price_status',
                'on_sale_price AS product_on_sale_price',
                DB::raw('IFNULL(CONCAT("' . url('/') . '/",image),IFNULL(image_url,CONCAT("' . url('/') . '/","images_default/no_image.png"))) AS product_image'),
            ])->withCount('productReviews')->withAvg("productReviews", "review_value")->get()->sortByDesc(function ($q) {
                return $q->cartOperations->count();
        })->take(4);


        $best_selling->makeHidden(['product_reviews']);
        $recent_products->makeHidden(['product_reviews']);
        $high_rated->makeHidden(['product_reviews']);

        $homeData =  [
            'banners' => $banners,
            'categories' => $categories,
            'best_selling' => $best_selling,
            'recent_products' => $recent_products,
            'high_rated' => $high_rated,
            'brands' => $brands
        ];


        return  response()->json([
            'status' => true,
            'errNum' => "S000",
            'msg' => null,
            'data' => $homeData
        ]);
    }



    // ================================================================
    // ======================== Shop Function =========================
    // ================================================================
    function shop(Request $request)
    {

        $rules = [
            'lang' => ['required'],
            'counter' => ['required']
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        }

        if (isset($request->lang) && $request->lang == 'ar') {
            app()->setLocale('ar');
        } else {
            app()->setLocale('en');
        }


        $lang = Config::get('app.locale');

        $products = Product::where('status', 1)->with('firstProperty')
            ->select([
                'id',
                'sub_category_id',
                'name_' . $lang . ' AS product_name',
                'main_description_' . $lang . ' AS product_main_description',
                'sub_description_' . $lang . ' AS product_sub_description',
                'sale_price AS product_sale_price',
                'on_sale_price_status AS product_on_sale_price_status',
                'on_sale_price AS product_on_sale_price',
                DB::raw('IFNULL(CONCAT("' . url('/') . '/",image),IFNULL(image_url,CONCAT("' . url('/') . '/","images_default/no_image.png"))) AS product_image'),
            ])->orderBy('created_at', 'desc')->withCount('productReviews')->withAvg("productReviews", "review_value")->skip($request->counter)->take($request->counter + 20)->get();


        foreach ($products as $product) {
            $product->more_images = ProductImage::where('product_id', $product->id)->limit(5)->select(DB::raw('IFNULL(CONCAT("' . url('/') . '/",image),CONCAT("' . url('/') . '/","images_default/no_image.png")) as image'))->get();
        }



        $active_categories = MainCategory::where('status', 1)->select([
            'id',
            'name_' . $lang . ' AS category_name',
            DB::raw('IFNULL(CONCAT("' . url('/') . '/",image),CONCAT("' . url('/') . '/","images_default/no_image.png")) as image')
        ])->get();


        return  response()->json([
            'status' => true,
            'errNum' => "S000",
            'msg' => null,
            'categories' => $active_categories,
            'products' => $products
        ]);
    }
    // ================================================================
    // ======================== getProductByCategory Function =========================
    // ================================================================
    function getProductByCategory(Request $request)
    {

        $rules = [
            'lang' => ['required'],
            'counter' => ['required']
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        }

        if (isset($request->lang) && $request->lang == 'ar') {
            app()->setLocale('ar');
        } else {
            app()->setLocale('en');
        }


        $lang = Config::get('app.locale');

        $products = Product::where('status', 1)->where('main_category_id',$request->category_id)->with('firstProperty')
            ->select([
                'id',
                'sub_category_id',
                'name_' . $lang . ' AS product_name',
                'main_description_' . $lang . ' AS product_main_description',
                'sub_description_' . $lang . ' AS product_sub_description',
                'sale_price AS product_sale_price',
                'on_sale_price_status AS product_on_sale_price_status',
                'on_sale_price AS product_on_sale_price',
                DB::raw('IFNULL(CONCAT("' . url('/') . '/",image),IFNULL(image_url,CONCAT("' . url('/') . '/","images_default/no_image.png"))) AS product_image'),
            ])->orderBy('created_at', 'desc')->withCount('productReviews')->withAvg("productReviews", "review_value")->skip($request->counter)->take($request->counter + 20)->get();


        foreach ($products as $product) {
            $product->more_images = ProductImage::where('product_id', $product->id)->limit(5)->select(DB::raw('IFNULL(CONCAT("' . url('/') . '/",image),CONCAT("' . url('/') . '/","images_default/no_image.png")) as image'))->get();
        }



        return  response()->json([
            'status' => true,
            'errNum' => "S000",
            'msg' => null,
            'products' => $products
        ]);
    }



    // ========================================================================
    // ======================= getproductDetails Functions ====================
    // ========================================================================
    function getproductDetails(Request $request)
    {


        $rules = [
            'lang' => ['required'],
            'product_id' => ['required']
        ];


        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        }

        if (isset($request->lang) && $request->lang == 'ar') {
            app()->setLocale('ar');
        } else {
            app()->setLocale('en');
        }

        $lang = Config::get('app.locale');

        $product = Product::where('id', $request->product_id)->where('status', 1)->withCount('productReviews')->withAvg("productReviews", "review_value")->get()->first();
        if ($product) {

            $product->product_name = $product->name;
            $product->product_main_description = $product->main_description;
            $product->product_sub_description = $product->sub_description;

            $product->product_colors = ProdSzeClrRelation::where('product_id', $product->id)
                ->where('status', 1)->where('main_color_id', '!=', null)
                ->join('main_colors', 'main_colors.id', '=', 'prod_sze_clr_relations.main_color_id')
                ->select([
                    'prod_sze_clr_relations.id',
                    'prod_sze_clr_relations.main_color_id',
                    'main_colors.name_en AS color_name',
                    DB::raw("REPLACE(main_colors.color_code, '#', '') AS color_code"),
                    DB::raw('IFNULL(CONCAT("' . url('/') . '/",main_colors.image),"") as color_image')
                ])
                ->get()
                ->unique('main_color_id')
                ->values();

            $product->product_sizes = ProdSzeClrRelation::where('product_id', $product->id)
                ->where('status', 1)->where('main_size_id', '!=', null)
                ->join('main_sizes', 'main_sizes.id', '=', 'prod_sze_clr_relations.main_size_id')
                ->select([
                    'prod_sze_clr_relations.id',
                    'prod_sze_clr_relations.main_size_id',
                    'main_sizes.name_en AS size_name'
                ])
                ->get()
                ->unique('main_size_id')
                ->values();

            if (isset($product->properties) && $product->properties->count() > 0) {


                if ($product->product_sizes->count() > 0 && $product->product_colors->count() > 0) {
                    $prop = ProdSzeClrRelation::where('product_id', $product->id)->where('status', 1)->where('main_color_id', '!=', null)->where('main_size_id', '!=', null)->get()->first();
                    if ($prop) {
                        $product->property_id = $prop->id;
                        $product->product_sale_price = $prop->sale_price;
                        $product->product_on_sale_price_status = $prop->getRawOriginal('on_sale_price_status');
                        $product->product_on_sale_price = $prop->on_sale_price;
                        $product->product_quantity_available = $prop->quantity_available;
                        $product->product_image = $prop->image == null ? (($prop->image_url) == null ? url('/').'/images_default/no_image.png' : $prop->image_url) : url($prop->image);
                        $product->product_color_id = $prop->main_color_id;
                        $product->product_size_id = $prop->main_size_id;
                        $product->product_size_name = $prop->size->name_en;
                        $product->product_color_code = str_replace('#','',$prop->color->color_code);
                        $product->product_color_image = $prop->color->image == null ? url('/').'/images_default/no_image.png' : url($prop->color->image);

                        $product->more_images = PropertyImage::where('property_id', $prop->id)->select([
                            DB::raw('IFNULL(CONCAT("' . url('/') . '/",image),CONCAT("' . url('/') . '/","images_default/no_image.png")) as image')
                        ])->inRandomOrder()->limit(5)->get();


                        $product_more_images = $product->more_images->pluck('image')->toArray();
                        array_unshift($product_more_images,$product->product_image);
                        $product->more_images =$product_more_images;


                        $product->available_colors = ProdSzeClrRelation::where([['main_size_id',$prop->main_size_id],['product_id',$product->id]])->select([
                            'main_color_id'
                        ])->get()->pluck('main_color_id')->toArray();

                        $product->available_sizes = ProdSzeClrRelation::where([['main_color_id',$prop->main_color_id],['product_id',$product->id]])->select([
                            'main_size_id'
                        ])->get()->pluck('main_size_id')->toArray();



                    }
                } else {
                    if ($product->product_sizes->count() > 0) {
                        $prop = ProdSzeClrRelation::where('product_id', $product->id)->where('status', 1)->where('main_size_id', '!=', null)->get()->first();
                        if ($prop) {
                            $product->property_id = $prop->id;
                            $product->product_sale_price = $prop->sale_price;
                            $product->product_on_sale_price_status = $prop->getRawOriginal('on_sale_price_status');
                            $product->product_on_sale_price = $prop->on_sale_price;
                            $product->product_quantity_available = $prop->quantity_available;
                            $product->product_image = $prop->image == null ? (($prop->image_url) == null ? url('/').'/images_default/no_image.png' : $prop->image_url) : url($prop->image);
                            $product->product_size_id = $prop->main_size_id;
                            $product->product_size_name = $prop->size->name_en;

                            $product->more_images = PropertyImage::where('property_id', $prop->id)->select([
                                DB::raw('IFNULL(CONCAT("' . url('/') . '/",image),CONCAT("' . url('/') . '/","images_default/no_image.png")) as image')
                            ])->inRandomOrder()->limit(5)->get();


                            $product_more_images = $product->more_images->pluck('image')->toArray();

                            array_unshift($product_more_images,$product->product_image);
                            $product->more_images =$product_more_images;


                            $product->available_colors = ProdSzeClrRelation::where([['main_size_id',$prop->main_size_id],['product_id',$product->id]])->select([
                                'main_color_id'
                            ])->get()->pluck('main_color_id')->toArray();

                            $product->available_sizes = ProdSzeClrRelation::where([['main_color_id',$prop->main_color_id],['product_id',$product->id]])->select([
                                'main_size_id'
                            ])->get()->pluck('main_size_id')->toArray();



                        }
                    } elseif ($product->product_colors->count() > 0) {
                        $prop = ProdSzeClrRelation::where('product_id', $product->id)->where('status', 1)->where('main_color_id', '!=', null)->get()->first();
                        if ($prop) {
                            $product->property_id = $prop->id;
                            $product->product_sale_price = $prop->sale_price;
                            $product->product_on_sale_price_status = $prop->getRawOriginal('on_sale_price_status');
                            $product->product_on_sale_price = $prop->on_sale_price;
                            $product->product_quantity_available = $prop->quantity_available;
                            $product->product_image = $prop->image == null ? (($prop->image_url) == null ? url('/').'/images_default/no_image.png' : $prop->image_url) : url($prop->image);
                            $product->product_color_id = $prop->main_color_id;
                            $product->product_color_code = str_replace('#','',$prop->color->color_code);
                            $product->product_color_image = $prop->color->image == null ? "" : url($prop->color->image);

                            $product->more_images = PropertyImage::where('property_id', $prop->id)->select([
                                DB::raw('IFNULL(CONCAT("' . url('/') . '/",image),CONCAT("' . url('/') . '/","images_default/no_image.png")) as image')
                            ])->inRandomOrder()->limit(5)->get();


                            $product_more_images = $product->more_images->pluck('image')->toArray();
                            array_unshift($product_more_images,$product->product_image);
                            $product->more_images =$product_more_images;


                            $product->available_colors = ProdSzeClrRelation::where([['main_size_id',$prop->main_size_id],['product_id',$product->id]])->select([
                                'main_color_id'
                            ])->get()->pluck('main_color_id')->toArray();

                            $product->available_sizes = ProdSzeClrRelation::where([['main_color_id',$prop->main_color_id],['product_id',$product->id]])->select([
                                'main_size_id'
                            ])->get()->pluck('main_size_id')->toArray();

                        }
                    }
                }
            } else {

                $product->property_id = -1;
                $product->product_sale_price = $product->sale_price;
                $product->product_on_sale_price_status = $product->getRawOriginal('on_sale_price_status');
                $product->product_on_sale_price = $product->on_sale_price;
                $product->product_quantity_available = $product->quantity_available;
                $product->product_image = $product->image == null ? (($product->image_url) == null ? url('/').'/images_default/no_image.png' : $product->image_url) : url($product->image);
                $product->product_color_id = $product->color_id;
                $product->product_size_id = $product->size_id;
                $product->product_size_name = isset($product->size->name_en) ? $product->size->name_en : null;
                $product->product_color_code = isset($product->color->color_code) ? str_replace('#','',$product->color->color_code) : null;
                $product->product_color_image = isset($product->color->image) ? ($product->color->image == null ? "" : url($product->color->image)) : null;

                $product->more_images = ProductImage::where('product_id', $product->id)->select([
                    DB::raw('IFNULL(CONCAT("' . url('/') . '/",image),CONCAT("' . url('/') . '/","images_default/no_image.png")) as image')
                ])->inRandomOrder()->limit(5)->get();


                $product_more_images = $product->more_images->pluck('image')->toArray();
                array_unshift($product_more_images,$product->product_image);
                            $product->more_images =$product_more_images;
            }



            $relateds = Product::where('status', 1)->where('id','!=',$product->id)->where('sub_category_id',$product->sub_category_id)
            ->select([
                'id',
                'sub_category_id',
                'name_' . $lang . ' AS product_name',
                'main_description_' . $lang . ' AS product_main_description',
                'sub_description_' . $lang . ' AS product_sub_description',
                'sale_price AS product_sale_price',
                'on_sale_price_status AS product_on_sale_price_status',
                'on_sale_price AS product_on_sale_price',
                DB::raw('IFNULL(CONCAT("' . url('/') . '/",image),IFNULL(image_url,CONCAT("' . url('/') . '/","images_default/no_image.png"))) AS product_image')
            ])->withCount('productReviews')->withAvg("productReviews", "review_value",function($q){
                return $q == null ? 0 : $q;
            })->inRandomOrder()->limit(4)->get();


            $product->makeHidden(['product_reviews']);

        }
        $logged_in = 0;
        $wishlist_flag=0;
        $user = null;

        if($request->bearerToken() != null){

            $token = PersonalAccessToken::findToken($request->bearerToken());
            if ($token) {

                $user = $token->tokenable;

                $logged_in = 1;
                $wishlists = ProductWishlist::where('customer_id', $user->id)->where('product_id', $request->product_id)->get();
                // return $wishlists;
                if($wishlists->count()>0){
                    $wishlist_flag=1;
                }
                else{
                    $wishlist_flag=0;
                }

            }else{
                $wishlist_flag=0;
            }

        }

        $product->makeHidden(['properties', 'product_reviews', 'productReviews', 'updated_at', 'created_at', 'deleted_at', 'size_id', 'color_id', 'brand_id', 'updated_by', 'private_info', 'image', 'image_url', 'status', 'quantity_limit', 'quantity_available', 'weight', 'weight_unit', 'sale_price', 'on_sale_price', 'on_sale_price_status', 'on_sale_price_status', 'main_category_id', 'sub_category_id', 'name_ar', 'name_en', 'main_description_ar', 'main_description_en', 'sub_description_ar', 'sub_description_en']);

        if ($product) {
            return response()->json([
                'status' => true,
                'errNum' => "S000",
                'msg' => 'Success',
                'data' => $product,
                'related' => $relateds,
                'wishlist_flag' => $wishlist_flag,
            ]);
            return $this->returnData('data', $product);
        } else {
            return $this->returnError('product Not Found !!!!');
        }
    }



    // ========================================================================
    // ======================= getAttribute Functions ====================
    // ========================================================================
    function getAttribute(Request $request)
    {


        $rules = [
            'lang' => ['required'],
            'product_id' => ['required'],
            'color_id' => ['required'],
            'size_id' => ['required'],
            'type' => ['required']
        ];


        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        }

        if (isset($request->lang) && $request->lang == 'ar') {
            app()->setLocale('ar');
        } else {
            app()->setLocale('en');
        }

        $lang = Config::get('app.locale');

        $product = Product::where('id', $request->product_id)->where('status', 1)->get()->first();
        if ($product) {


            if (isset($product->properties) && $product->properties->count() > 0) {
                if ($request->size_id != -1 && $request->color_id != -1) {
                    $prop = ProdSzeClrRelation::where('product_id', $product->id)->where('status', 1)->where('main_color_id', $request->color_id)->where('main_size_id', $request->size_id)->get()->first();
                    if ($prop) {
                        $product->property_id = $prop->id;
                        $product->product_sale_price = $prop->sale_price;
                        $product->product_on_sale_price_status = $prop->getRawOriginal('on_sale_price_status');
                        $product->product_on_sale_price = $prop->on_sale_price;
                        $product->product_quantity_available = $prop->quantity_available;
                        $product->product_image = $prop->image == null ? (($prop->image_url) == null ? url('/').'/images_default/no_image.png' : $prop->image_url) : url($prop->image);
                        $product->product_color_id = $prop->main_color_id;
                        $product->product_size_id = $prop->main_size_id;
                        $product->product_size_name = $prop->size->name_en;
                        $product->product_color_code = str_replace('#','',$prop->color->color_code);
                        $product->product_color_image = $prop->color->image == null ? "" : url($prop->color->image);

                        $product->more_images = PropertyImage::where('property_id', $prop->id)->select([
                            DB::raw('IFNULL(CONCAT("' . url('/') . '/",image),CONCAT("' . url('/') . '/","images_default/no_image.png")) as image')
                        ])->inRandomOrder()->limit(5)->get();


                        $product_more_images = $product->more_images->pluck('image')->toArray();
                        array_unshift($product_more_images,$product->product_image);
                            $product->more_images =$product_more_images;


                            $product->available_colors = ProdSzeClrRelation::where([['main_size_id',$prop->main_size_id],['product_id',$product->id]])->select([
                                'main_color_id'
                            ])->get()->pluck('main_color_id')->toArray();

                            $product->available_sizes = ProdSzeClrRelation::where([['main_color_id',$prop->main_color_id],['product_id',$product->id]])->select([
                                'main_size_id'
                            ])->get()->pluck('main_size_id')->toArray();



                    }else{
                        if($request->type == "s"){
                            $available_colors = ProdSzeClrRelation::where([['main_size_id',$request->size_id],['product_id',$product->id]])->select([
                                'main_color_id'
                            ])->get()->unique('main_color_id')->pluck('main_color_id')->toArray();

                            return response()->json([
                                'status' => false,
                                'errNum' => "S000",
                                'msg' => 'Out Of Stock',
                                'available_colors' => $available_colors
                            ]);

                        }elseif($request->type == "c"){
                            $available_sizes = ProdSzeClrRelation::where([['main_color_id',$request->color_id],['product_id',$product->id]])->select([
                                'main_size_id'
                            ])->get()->unique('main_size_id')->pluck('main_size_id')->toArray();

                            return response()->json([
                                'status' => false,
                                'errNum' => "S000",
                                'msg' => 'Out Of Stock',
                                'available_sizes' => $available_sizes
                            ]);

                        }
                    }
                } else {
                    if ($product->sizes->count() > 0 && $request->size_id != -1) {
                        $prop = ProdSzeClrRelation::where('product_id', $product->id)->where('status', 1)->where('main_size_id', $request->size_id)->get()->first();
                        if ($prop) {
                            $product->property_id = $prop->id;
                            $product->product_sale_price = $prop->sale_price;
                            $product->product_on_sale_price_status = $prop->getRawOriginal('on_sale_price_status');
                            $product->product_on_sale_price = $prop->on_sale_price;
                            $product->product_quantity_available = $prop->quantity_available;
                            $product->product_image = $prop->image == null ? (($prop->image_url) == null ? url('/').'/images_default/no_image.png' : $prop->image_url) : url($prop->image);
                            $product->product_size_id = $prop->main_size_id;
                            $product->product_size_name = $prop->size->name_en;

                            $product->more_images = PropertyImage::where('property_id', $prop->id)->select([
                                DB::raw('IFNULL(CONCAT("' . url('/') . '/",image),CONCAT("' . url('/') . '/","images_default/no_image.png")) as image')
                            ])->inRandomOrder()->limit(5)->get();

                            $product_more_images = $product->more_images->pluck('image')->toArray();
                            array_unshift($product_more_images,$product->product_image);
                            $product->more_images =$product_more_images;


                            $product->available_colors = ProdSzeClrRelation::where([['main_size_id',$prop->main_size_id],['product_id',$product->id]])->select([
                                'main_color_id'
                            ])->get()->pluck('main_color_id')->toArray();

                            $product->available_sizes = ProdSzeClrRelation::where([['main_color_id',$prop->main_color_id],['product_id',$product->id]])->select([
                                'main_size_id'
                            ])->get()->pluck('main_size_id')->toArray();

                        }else{
                            if($request->type == "s"){
                                $available_colors = ProdSzeClrRelation::where([['main_size_id',$request->size_id],['product_id',$product->id]])->select([
                                    'main_color_id'
                                ])->get()->unique('main_color_id')->pluck('main_color_id')->toArray();

                                return response()->json([
                                    'status' => false,
                                    'errNum' => "S000",
                                    'msg' => 'Out Of Stock',
                                    'available_colors' => $available_colors
                                ]);

                            }elseif($request->type == "c"){
                                $available_sizes = ProdSzeClrRelation::where([['main_color_id',$request->color_id],['product_id',$product->id]])->select([
                                    'main_size_id'
                                ])->get()->unique('main_size_id')->pluck('main_size_id')->toArray();

                                return response()->json([
                                    'status' => false,
                                    'errNum' => "S000",
                                    'msg' => 'Out Of Stock',
                                    'available_sizes' => $available_sizes
                                ]);

                            }
                        }
                    } elseif ($product->colors->count() > 0 && $request->color_id != -1) {
                        $prop = ProdSzeClrRelation::where('product_id', $product->id)->where('status', 1)->where('main_color_id', $request->color_id)->get()->first();
                        if ($prop) {
                            $product->property_id = $prop->id;
                            $product->product_sale_price = $prop->sale_price;
                            $product->product_on_sale_price_status = $prop->getRawOriginal('on_sale_price_status');
                            $product->product_on_sale_price = $prop->on_sale_price;
                            $product->product_quantity_available = $prop->quantity_available;
                            $product->product_image = $prop->image == null ? (($prop->image_url) == null ? url('/').'/images_default/no_image.png' : $prop->image_url) : url($prop->image);
                            $product->product_color_id = $prop->main_color_id;
                            $product->product_color_code = str_replace('#','',$prop->color->color_code);
                            $product->product_color_image = $prop->color->image == null ? "" : url($prop->color->image);

                            $product->more_images = PropertyImage::where('property_id', $prop->id)->select([
                                DB::raw('IFNULL(CONCAT("' . url('/') . '/",image),CONCAT("' . url('/') . '/","images_default/no_image.png")) as image')
                            ])->inRandomOrder()->limit(5)->get();

                            $product_more_images = $product->more_images->pluck('image')->toArray();
                            array_unshift($product_more_images,$product->product_image);
                            $product->more_images =$product_more_images;


                            $product->available_colors = ProdSzeClrRelation::where([['main_size_id',$prop->main_size_id],['product_id',$product->id]])->select([
                                'main_color_id'
                            ])->get()->pluck('main_color_id')->toArray();

                            $product->available_sizes = ProdSzeClrRelation::where([['main_color_id',$prop->main_color_id],['product_id',$product->id]])->select([
                                'main_size_id'
                            ])->get()->pluck('main_size_id')->toArray();

                        }else{
                            if($request->type == "s"){
                                $available_colors = ProdSzeClrRelation::where([['main_size_id',$request->size_id],['product_id',$product->id]])->select([
                                    'main_color_id'
                                ])->get()->unique('main_color_id')->pluck('main_color_id')->toArray();

                                return response()->json([
                                    'status' => false,
                                    'errNum' => "S000",
                                    'msg' => 'Out Of Stock',
                                    'available_colors' => $available_colors
                                ]);

                            }elseif($request->type == "c"){
                                $available_sizes = ProdSzeClrRelation::where([['main_color_id',$request->color_id],['product_id',$product->id]])->select([
                                    'main_size_id'
                                ])->get()->unique('main_size_id')->pluck('main_size_id')->toArray();

                                return response()->json([
                                    'status' => false,
                                    'errNum' => "S000",
                                    'msg' => 'Out Of Stock',
                                    'available_sizes' => $available_sizes
                                ]);

                            }
                        }
                    }
                }
            }else{
                if($request->type == "s"){
                    $available_colors = ProdSzeClrRelation::where([['main_size_id',$request->size_id],['product_id',$product->id]])->select([
                        'main_color_id'
                    ])->get()->unique('main_color_id')->pluck('main_color_id')->toArray();

                    return response()->json([
                        'status' => false,
                        'errNum' => "S000",
                        'msg' => 'Out Of Stock',
                        'available_colors' => $available_colors
                    ]);

                }elseif($request->type == "c"){
                    $available_sizes = ProdSzeClrRelation::where([['main_color_id',$request->color_id],['product_id',$product->id]])->select([
                        'main_size_id'
                    ])->get()->unique('main_size_id')->pluck('main_size_id')->toArray();

                    return response()->json([
                        'status' => false,
                        'errNum' => "S000",
                        'msg' => 'Out Of Stock',
                        'available_sizes' => $available_sizes
                    ]);

                }
            }

        }

        $product->makeHidden(['properties','product_reviews','updated_at', 'created_at', 'deleted_at', 'size_id', 'color_id', 'brand_id', 'updated_by', 'private_info', 'image', 'image_url', 'status', 'quantity_limit', 'quantity_available', 'weight', 'weight_unit', 'sale_price', 'on_sale_price', 'on_sale_price_status', 'on_sale_price_status', 'main_category_id', 'sub_category_id', 'name_ar', 'name_en', 'main_description_ar', 'main_description_en', 'sub_description_ar', 'sub_description_en']);

        if ($product) {
            return $this->returnData('data', $product);
        } else {
            return $this->returnError('product Not Found !!!!');
        }
    }


    // Get about Us Data
    function aboutUsData(Request $request)
    {


        app()->setLocale($request->lang);




        $lang = Config::get('app.locale');
        $aboutUsData = AboutUs::selectRaw("
                                        about_us_{$lang} AS about_us1,
                                        vision_{$lang} AS vision1,
                                        mission_{$lang} AS mission1,
                                        about_us_image AS about_us_image1,
                                        vision_image AS vision_image1,
                                        mission_image AS mission_image1

                                        ")->get();


        $modifiedData = $aboutUsData->map(function ($item) {
            return [
                ['title' => 'About Us', 'disc' => strip_tags($item->about_us1)],

                ['title' => 'Vision', 'disc' => $item->vision1],
                ['title' => 'Mission', 'disc' => $item->mission1],
                ['title' => 'About Us Image', 'disc' => $item->about_us_image1],
                ['title' => 'Vision Image', 'disc' => $item->vision_image1],
                ['title' => 'Mission Image', 'disc' => $item->mission_image1]
            ];
        });
        return  response()->json([
            'status' => true,
            'errNum' => "S000",
            'msg' => null,
            'data' => $modifiedData
        ]);
    }

       // Get  Privacy Policy Data
       function privacyPolicyData(Request $request)
       {


           app()->setLocale($request->lang);




           $lang = Config::get('app.locale');

           $privacy_policy = PrivacyPolicy::select([
               'privacy_policy_title_' . $lang . ' AS privacy_policy_title', 'privacy_policy_des_' . $lang . ' AS privacy_policy_des'

           ])->get();



           return  response()->json([
               'status' => true,
               'errNum' => "S000",
               'msg' => null,
               'data' => $privacy_policy
           ]);
       }

       // Get  FAQs Data
       function faqsData(Request $request)
       {


           app()->setLocale($request->lang);




           $lang = Config::get('app.locale');



           $faqs = Faq::where('status',1)->selectRaw(" title_{$lang} AS qustion,answer_{$lang} AS answars")->get();


           $modifiedData = $faqs->map(function ($item) {
               return ['qustion' => $item->qustion, 'answar' => $item->answars];
           });

           return  response()->json([
               'status' => true,
               'errNum' => "S000",
               'msg' => null,
               'faqs' => $modifiedData
           ]);
       }

       // Get  Contact Us Data
       function getContactUsData(Request $request)
       {


           app()->setLocale($request->lang);




           $lang = Config::get('app.locale');



           $get_contact_us = ContactUs::selectRaw(" address_{$lang} AS address1,email,phone")->get();




           return  response()->json([
               'status' => true,
               'errNum' => "S000",
               'msg' => null,
               'data' => $get_contact_us
           ]);
       }
       // Get   requist Contac tUs Data
       function requistContactUsData(Request $request)
       {




           ContactUsRequest::create( [
               'full_name' => $request->name,
               'email' => $request->email,
               'phone' => $request->phone,
               'subject' => $request->subject,
               'message' => $request->message,
           ]);

        //    DB::transaction(function () use ($data,) {
        //        ContactUsRequest::create($data);
        //    });

           return $this->returnSuccessMessage('Record has been create Successfully ...');
       }
}
