<?php

namespace App\Http\Controllers\Frontend;

use Carbon\Carbon;
use App\Models\Brand;
use App\Models\Photo;
use App\Models\Banner;
use App\Models\Slider;
use App\Models\Product;
use App\Traits\SharedMethod;
use App\Models\SuperCategory;
use App\Http\Controllers\Controller;
use App\Models\Blogs;
use App\Models\Category;
use App\Models\MainCategory;
use App\Models\Offer;
use App\Models\ProdSzeClrRelation;
use App\Models\SeoOperation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class WelcomeController extends Controller
{
    use SharedMethod;

    // ========================================================================
    // ========================== Welcome Function ============================
    // ========================================================================
    public function welcome()
    {

        // Super Admin
        if (Auth::guard('super_admin')->check()) {
            return redirect()->route('super_admin.dashboard');
        }

        $banner = Banner::inRandomOrder()->limit(5)->get();


   




        $featured_products = Product::where('status', 1)->whereNotNull('featured_flag')->where('on_sale_price_status', '!=', 1)->with('firstProperty')->inRandomOrder()->limit(18)->get();


        $get_8_products = Product::where('status', 1)->inRandomOrder()->limit(8)->get();
        $photos = Photo::get();
        // $offers=Offer::where('status', 1)->where('expire_date','>',Carbon::now())->inRandomOrder()->get()->first();
        $seo_operation = SeoOperation::where('page_name', 'Welcome')->get()->first();
        // $special_offers = Offer::where('status', 1)->where('expire_date','>',Carbon::now())->limit(1)->get()->first();
        // return $get_8_products ->mainCategory;

        // =========================
        // ==== Ahmad Alsakhen ====
        // =========================
        $sliders = Slider::where('status', 1)->orderBy('created_at', 'asc')->get();
        $categories = MainCategory::where('status', 1)->get();
        $recent_products = Product::where('status', 1)->where('featured_flag', null)->where('created_at', '>=', Carbon::now()->subDays(60)->toDateTimeString())->with('firstProperty')->inRandomOrder()->limit(18)->get();
        
        $best_prop = ProdSzeClrRelation::where('status', 1)->whereHas('cartOperations')->get()->sortByDesc(function ($q) {
            return $q->cartOperations->count();
        })->pluck('product_id');
        $best_selling = Product::where('status', 1)->whereHas('cartOperations')->with('firstProperty')->orWhereIn('id', $best_prop)->get()->sortByDesc(function ($q) {
            return $q->cartOperations->count();
        })->take(18);
        //TODO -  show high rated products in welcome view
        $high_rated = Product::where('status', 1)->get()->sortByDesc(function ($q) {
            return $q->productReviews->avg('review_value');
        })->take(18);

        

        $blogs = Blogs::limit(8)->get();
     
        $brands = Brand::where('status', 1)->where('image', '!=', null)->limit(10)->get();



        return view('welcome', compact('sliders', 'banner', 'brands', 'featured_products', 'recent_products', 'photos', 'best_selling', 'get_8_products', 'high_rated', 'blogs', 'seo_operation', 'categories'));
    }



}
