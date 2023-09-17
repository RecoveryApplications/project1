<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::where('status', 1)->get();

        
        if($request->type == 'list'){
        return view('front_end_inners.shop.shop-list' , compact('products'));

        }
        return view('front_end_inners.shop.index', compact('products'));
    }
}
