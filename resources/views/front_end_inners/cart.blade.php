@extends('front_end_inners.app_front_end')

@php
    $image_url = asset('images/Cart.png');
@endphp
@push('styles')
    <style>
        .input-text.qty {
            width: 100% !important;
            border-radius: 20px !important;
            max-width: 80px !important;
        }

        .inner-banner1 {
            background: url({{ $image_url }}) no-repeat scroll center center;
            padding: 60px 0;
        }
    </style>
@endpush

@section('content')
    <!-- Bread Crumb STRAT -->
    <div class="banner inner-banner1 ">
        <div class="container">
            <section class="banner-detail center-xs">
                <h1 class="banner-title">{{ __('front_end.BreadCrump_Cart') }}</h1>
                <div class="bread-crumb right-side float-none-xs">
                    <ul>
                        <li><a href="index.html">
                                {{ __('front_end.BreadCrump_Home') }}
                            </a>/</li>
                        <li><span>{{ __('front_end.BreadCrump_Cart') }}</span></li>
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
                <div class="col-12">
                    <div class="cart-item-table commun-table">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>{{ __('front_end.product_product') }}</th>
                                        <th>{{ __('front_end.product_productName') }}</th>
                                        <th>{{ __('front_end.shop_price') }}</th>
                                        <th>{{ __('front_end.product_Quantity') }}</th>
                                        <th>{{ __('front_end.home_Subtotal') }}</th>
                                        <th>{{ __('front_end.profile_Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($public_customer_carts as $item)
                                        @php
                                            // dd($public_customer_carts);
                                            if ($item->property_type == 2) {
                                                $product_name = $item->cart_product->name;
                                                $product_slug = $item->product->slug;
                                            } else {
                                                $product_name = $item->cart_product->product->name;
                                                $product_slug = $item->cart_product->product->slug;
                                            }
                                            $product_price = $item->cart_product->on_sale_price_status == 'Active' ? $item->cart_product->on_sale_price : $item->cart_product->sale_price;

                                        @endphp
                                        <tr>
                                            <td>
                                                <a href="{{ route('productDetails', $product_slug) }}">
                                                    <div class="product-image">
                                                        <img alt="FamilyDrop"
                                                            src="{{ asset($item->cart_product->image) }}">
                                                    </div>
                                                </a>
                                            </td>
                                            <td>
                                                <div class="product-title">
                                                    <h4>
                                                        <a href="{{ route('productDetails', $product_slug) }}">
                                                            {{ $product_name }}
                                                        </a>
                                                    </h4>
                                                    {{-- <div class=""><span class="mr-2 text-muted">Color :</span>gray
                                                    </div>
                                                    <div class=""><span class="mr-2 text-muted">Size :</span>XL</div> --}}
                                                </div>
                                            </td>
                                            <td>
                                                <ul>
                                                    <li>
                                                        <div class="base-price price-box">
                                                            <span class="price">JOD {{ $product_price }}</span>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </td>
                                            <td>
                                                <div>
                                                    <input type="number" name="qty" maxlength="8" minlength="1"
                                                        min="1" value="{{ $item->quantity }}" readonly
                                                        title="Qty" class="text-white input-text qty bg-secondary">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="total-price price-box">
                                                    <span class="price">JOD {{ $product_price * $item->quantity }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="{{ route('customer.remove-from-cart', $item->id) }}">
                                                    <i title="Remove Item From Cart" data-id="100"
                                                        class="fa fa-trash cart-remove-item"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No Items In Cart</td>
                                        </tr>
                                    @endforelse

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-30">
                <div class="row ">
                    <div class="col-md-6">
                        <div class="mt-30">
                            <a href="{{ route('shop') }}" class="btn btn-color">
                                <span><i class="fa fa-angle-left"></i></span>
                                {{ __('front_end.home_Continue_Shopping') }}
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mt-30 right-side float-none-xs">
                            <a class="btn btn-color" href="{{ route('cart') }}">{{ __('front_end.shop_UpdateCart') }}</a>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="mtb-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="cart-total-table commun-table">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th colspan="2">{{ __('front_end.shop_CartTotal') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ __('front_end.shop_ItemsSubtotal') }}</td>
                                            <td>
                                                <div class="price-box">
                                                    <span class="price">JOD {{ $public_prices['subTotal'] }}</span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('front_end.profile_Shipping') }}</td>
                                            <td>
                                                <div class="price-box">
                                                    <span class="price">JOD {{ $public_prices['shipping'] }}</span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('front_end.profile_Tax') }}
                                                [{{ $public_prices['taxPercentage'] . '%' }}]</td>
                                            <td>
                                                <div class="price-box">
                                                    <span class="price">JOD {{ $public_prices['tax'] }}</span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>{{ __('front_end.shop_AmountPayable') }}</b></td>
                                            <td>
                                                <div class="price-box">
                                                    <span class="price"><b>JOD {{ $public_prices['total'] }}</b></span>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="right-side float-none-xs">
                            <a href="{{ route('customer.orderOverview') }}" class="btn btn-color">
                                {{ __('front_end.home_Proceed_to_Checkout') }}
                                <span><i class="fa fa-angle-right"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
        </div>
    </section>
    <!-- CONTAINER END -->
@endsection
