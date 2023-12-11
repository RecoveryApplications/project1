@extends('front_end_inners.app_front_end')

@php
    $image_url = asset('images/Wishlist.png');
@endphp
@push('styles')
    <style>
        .inner-banner1 {
            background: url({{ $image_url }}) no-repeat scroll center center;
            padding: 60px 0;
        }
    </style>
@endpush
@section('content')
    <!-- Bread Crumb STRAT -->
    <div class="banner inner-banner1">
        <div class="container">
            <section class="banner-detail center-xs">
                <h1 class="banner-title">{{ __('front_end.BreadCrump_Wishlist') }}</h1>
                <div class="bread-crumb right-side float-none-xs">
                    <ul>
                        <li><a href="{{ route('welcome') }}">{{ __('front_end.BreadCrump_Home') }}</a>/</li>
                        <li><span>{{ __('front_end.BreadCrump_Wishlist') }}</span></li>
                    </ul>
                </div>
            </section>
        </div>
    </div>
    <!-- Bread Crumb END -->

    <!-- CONTAIN START -->
    <section class="ptb-70">
        <div class="container">
            <div class="row">
                <div class="col-12 ">
                    <div class="cart-item-table commun-table wishlist">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>{{ __('front_end.product_product') }}</th>
                                        <th>{{ __('front_end.profile_Name') }}</th>
                                        <th>{{ __('front_end.shop_price') }}</th>
                                        <th>{{ __('front_end.profile_Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($wishlistItems as $item)
                                        @php
                                            $product_slug = $item->product->slug_en;
                                            $product_price = $item->product->on_sale_price_status == 'Active' ? $item->product->on_sale_price : $item->product->sale_price;

                                            // // dd($public_customer_carts);
                                            // if ($item->property_type == 2) {
                                            //     $product_name = $item->cart_product->name_en;
                                            //     $product_slug = $item->product->slug_en;
                                            // } else {
                                            //     $product_name = $item->cart_product->product->name_en;
                                            //     $product_slug = $item->cart_product->product->slug_en;
                                            // }
                                            // $product_price = $item->cart_product->on_sale_price_status == 'Active' ? $item->cart_product->on_sale_price : $item->cart_product->sale_price;

                                        @endphp
                                        <tr>
                                            <td>
                                                <a href={{ route('productDetails', $product_slug) }}>
                                                    <div class="product-image"><img alt="{{ $item->product->name }}"
                                                            src="{{ asset($item->product->image) }}"></div>
                                                </a>
                                            </td>
                                            <td>
                                                <div class="product-title">
                                                    <h4>
                                                        <a href="{{ route('productDetails', $product_slug) }}">
                                                            {{ $item->product->name }}
                                                        </a>
                                                    </h4>
                                                </div>
                                            </td>
                                            <td>
                                                <ul>
                                                    <li>
                                                        <div class="base-price price-box"> <span
                                                                class="price">${{ $product_price }}</span>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </td>

                                            <td>
                                                <a href="{{ route('cart') }}">
                                                    <i title="Shopping Cart" class="fa fa-shopping-cart"
                                                        aria-hidden="true"></i>
                                                </a>
                                                <a href="{{ route('customer.wishlist', $item->product->id) }}">
                                                    <i title="Remove Item From Cart" data-id="100"
                                                        class="fa fa-trash cart-remove-item"></i>

                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4">
                                                <div class="text-center alert alert-danger">
                                                    <h4 class="py-0 my-0">{{ __("front_end.home_No_Items_In_Wishlist") }}</h4>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-30">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mt-30">
                            <a href="{{ route('shop') }}" class="btn btn-color">
                                <span><i class="fa fa-angle-left"></i></span>
                                {{ __("front_end.home_Continue_Shopping") }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- CONTAINER END -->
@endsection
