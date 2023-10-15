<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ProdSzeClrRelation;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Support\Facades\Config;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function view($aliasname){
        $lang=Config::get('app.locale');

        $product = Product::with(['brand' ,'productImages'])->where('slug_'.$lang,$aliasname)->get()->first();
        // return $product;
        if ($product) {

            // return $product->firstProperty->active_colors;

            $properties = ProdSzeClrRelation::where('product_id', $product->product_id)->get();
            $relatedProducts = Product::where('main_category_id', $product->main_category_id)->where('status', 1)->where('id', '!=', $product->id)->limit(12)->get();
            $reviews = Review::where('product_id', $aliasname)->where('status', 2)->get();

            $check_review_user = false;
            if (auth('customer')->user()) {
                $review_user = Review::where('product_id', $aliasname)->where('user_id', auth('customer')->user()?->id)->get();
                if ($review_user->count() > 0)
                    $check_review_user = false;
                else
                    $check_review_user = true;
            }

            return view('front_end_inners.product-detail', compact('product', 'properties', 'relatedProducts', 'reviews', 'check_review_user'));
        } else {
            return redirect()->back()->with(trans('front_end.product_not_found'));
        }
    }
  
}
