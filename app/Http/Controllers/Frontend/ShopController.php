<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\MainCategory;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $itemsPerPage = request()->query('items', 12);

        // Define the base query for products
        $productsQuery = Product::query()->where('status', 1)->orderBy('created_at', 'desc');

        // Apply filters if they are present in the request
        if ($request->has('brand')) {
            $productsQuery->where('brand_id', $request->input('brand'));
        }

        if ($request->has('category')) {
            $productsQuery->where('main_category_id', $request->input('category'));
        }

        if ($request->has('price_range')) {
            // Explode the 'price_range' parameter into an array
            $price_range = explode('-', $request->input('price_range'));

            // Apply the 'whereBetween' condition for 'sale_price' and 'on_sale_price'
            $productsQuery->where(function ($query) use ($price_range) {
                $query->whereBetween('sale_price', [$price_range[0], $price_range[1]])
                    ->orWhereBetween('on_sale_price', [$price_range[0], $price_range[1]]);
            });
        }

        // Get the query parameters excluding the CSRF token
        $queryParams = $request->query();
        unset($queryParams['_token']);
        // Paginate the products
        $products = $productsQuery->paginate($itemsPerPage)->withQueryString();

        // Fetch brands and categories separately
        $brands = Brand::where('status', 1)->whereHas('products')->orderBy('created_at', 'desc')->get();
        $categories = MainCategory::where('status', 1)->whereHas('products')->orderBy('name_en', 'asc')->get();


        // if ($request->type == 'list') {
        //     return view('front_end_inners.shop.shop-list', compact('products', 'brands'));
        // }

        return view('front_end_inners.shop.index', compact('products', 'brands', 'categories'));
    }
}
