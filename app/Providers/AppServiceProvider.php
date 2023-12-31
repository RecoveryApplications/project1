<?php

namespace App\Providers;

use App\Models\AboutUs;
use App\Models\CartTemp;
use App\Models\ContactUs;
use App\Models\MainCategory;
use App\Models\ProdSzeClrRelation;
use App\Models\Product;
use App\Models\ProductWishlist;
use App\Models\PublicValue;
use App\Models\SuperCategory;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Schema::defaultStringLength(191);
        Paginator::useBootstrap();
        View::composer('*', function ($view) {
            $public_user_types = ['Super Admin', 'Customer'];
            $public_products = Product::where('status', 1)->orderBy('created_at', 'asc')->get();
            $public_contact = ContactUs::get()->first();

            $public_main_categories = MainCategory::withCount(['products'])->where('status', 1)->whereHas('products')->orderBy('name_en', 'asc')->get();


            $withlist_count = 0;
            $endTotal = 0;

            if (Auth::guard('customer')->check()) {
                $withlist_count = ProductWishlist::where('customer_id', Auth::guard('customer')->user()->id)->count();
                $public_customer_carts = CartTemp::with('product')->where(['user_id' => Auth::guard('customer')->user()->id, 'user_type' => 'Customer'])->get();
                $endTotal = 0;
                foreach ($public_customer_carts as $public_customer_cart) {
                    $sub_total = 0;
                    if ($public_customer_cart->property_type == 1) {
                        $public_customer_cart->cart_product = ProdSzeClrRelation::with('product')->find($public_customer_cart->product_id);
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
                $public_customer_carts_count = $public_customer_carts->count();
            }
            $public_customer_carts_count = count($public_customer_carts ?? []);

            $public_color_values_proparty = PublicValue::where('title', 'Color')->get();
            $public_size_values_proparty = PublicValue::where('title', 'Size')->get();
            $public_tax_values_proparty = PublicValue::where('title', 'Tax')->first()->values;
            $public_shipping_price = PublicValue::where('title', 'Shipping')->first()->values;
            $public_sale_percentage = PublicValue::where('title', 'SalePercentage')->first()->values;


            $public_contact_us = ContactUs::all()->first();
            $public_about_us = AboutUs::all()->first();

            // Prices
            $prices = [];
            $prices['subTotal'] = $endTotal; // without shipping,... etc
            $prices['shipping'] = $public_shipping_price;
            $prices['taxPercentage'] = $public_tax_values_proparty;
            $prices['tax'] = round($endTotal * ($public_tax_values_proparty / 100), 3);
            $prices['salePercentage'] = $public_sale_percentage;
            $prices['total'] = $endTotal + $public_shipping_price +  $prices['tax'] + round($endTotal * ($public_sale_percentage / 100), 3);

            view()->share([
                'public_user_types' => $public_user_types,
                'public_products' => $public_products,
                'public_main_categories' => $public_main_categories,
                'public_contact' => $public_contact,
                'public_customer_carts' => $public_customer_carts ?? [],
                'public_customer_carts_count' => $public_customer_carts_count ?? 0,
                'withlist_count' => $withlist_count,
                'endTotal' => $endTotal,
                'public_color_values_proparty' => $public_color_values_proparty,
                'public_size_values_proparty' => $public_size_values_proparty,
                'public_tax_values_proparty' => $public_tax_values_proparty,
                'public_contact_us' => $public_contact_us,
                'public_about_us' => $public_about_us,
                'public_shipping_price' => $public_shipping_price,
                'public_sale_percentage' => $public_sale_percentage,
                'public_prices' => $prices,
            ]);
        });
    }
}
