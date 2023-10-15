@extends('front_end_inners.app_front_end')

@push('styles')
    <style>
        .input-text.qty {
            width: 100% !important;
            border-radius: 20px !important;
            max-width: 80px !important;
        }
    </style>
@endpush

@section('content')
    <!-- Bread Crumb STRAT -->
    <div class="banner inner-banner1 ">
        <div class="container">
            <section class="banner-detail center-xs">
                <h1 class="banner-title">Shopping Cart</h1>
                <div class="bread-crumb right-side float-none-xs">
                    <ul>
                        <li><a href="index.html">Home</a>/</li>
                        <li><span>Shopping Cart</span></li>
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
                                        <th>Product</th>
                                        <th>Product Name</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Sub Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($public_customer_carts as $item)
                                        @php
                                            // dd($public_customer_carts);
                                            if ($item->property_type == 2) {
                                                $product_name = $item->cart_product->name_en;
                                                $product_slug = $item->product->slug_en;
                                            } else {
                                                $product_name = $item->cart_product->product->name_en;
                                                $product_slug = $item->cart_product->product->slug_en;
                                            }
                                            $product_price = $item->cart_product->on_sale_price_status == 'Active' ? $item->cart_product->on_sale_price : $item->cart_product->sale_price;

                                        @endphp
                                        <tr>
                                            <td>
                                                <a href="{{ route('productDetails', $product_slug) }}">
                                                    <div class="product-image">
                                                        <img alt="FamilyDrop" src="{{ asset($item->cart_product->image) }}">
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
                                                            <span class="price">${{ $product_price }}</span>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </td>
                                            <td>
                                                <div>
                                                    <input type="number" name="qty" maxlength="8" minlength="1"
                                                        min="1" value="{{ $item->quantity }}" readonly title="Qty"
                                                        class="text-white input-text qty bg-secondary">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="total-price price-box">
                                                    <span class="price">${{ $product_price * $item->quantity }}</span>
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
                                Continue Shopping
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mt-30 right-side float-none-xs">
                            <a class="btn btn-color" href="{{ route('cart') }}">Update Cart</a>
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
                                            <th colspan="2">Cart Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Item(s) Subtotal</td>
                                            <td>
                                                <div class="price-box">
                                                    <span class="price">${{ $public_prices['subTotal'] }}</span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Shipping</td>
                                            <td>
                                                <div class="price-box">
                                                    <span class="price">${{ $public_prices['shipping'] }}</span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Tax [{{ $public_prices['taxPercentage'] . '%' }}]</td>
                                            <td>
                                                <div class="price-box">
                                                    <span class="price">${{ $public_prices['tax'] }}</span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Amount Payable</b></td>
                                            <td>
                                                <div class="price-box">
                                                    <span class="price"><b>${{ $public_prices['total'] }}</b></span>
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
                            <a href="{{ route('customer.orderOverview') }}" class="btn btn-color">Proceed to checkout
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
