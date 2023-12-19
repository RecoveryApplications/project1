@extends('front_end_inners.app_front_end')

@push('styles')
    <style>
        input[type='number'] {
            background: #f5f5f5;
            border: none;
            border-radius: 25px;
            -moz-border-radius: 25px;
            -webkit-border-radius: 25px;
            -o-border-radius: 25px;
            padding: 9px 20px;
            width: 110px
        }

        p#addAddress:hover {
            cursor: pointer;
            background: #f5f5f5;
            transition: 0.5s;
        }

        .commun-table td .product-title {
            min-width: fit-content;
        }
    </style>
@endpush


@php
    $image_url = asset('images/Checkout.png');
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
    <div class="banner inner-banner1 ">
        <div class="container">
            <section class="banner-detail center-xs">
                <h1 class="p-1 rounded-lg banner-title bg-danger">{{ __('front_end.home_Checkout') }}</h1>
                <div class="bread-crumb right-side float-none-xs">
                    <ul>
                        <li><a href="index.html">{{ __('front_end.BreadCrump_Home') }}</a>/</li>
                        <li><a href="cart.html">{{ __('front_end.BreadCrump_Cart') }}</a>/</li>
                        <li><span>{{ __('front_end.home_Checkout') }}</span></li>
                    </ul>
                </div>
            </section>
        </div>
    </div>
    <!-- Bread Crumb END -->

    <!-- CONTAIN START -->
    <section class="checkout-section ptb-70">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="checkout-content">
                        <div class="row">
                            <div class="col-12">
                                <div class="heading-part align-center">
                                    <h2 class="heading">{{ __('front_end.shop_OrderOverview') }}</h2>
                                </div>
                            </div>
                        </div>
                        <form action="{{ route('customer.orderOverview.store') }}" method="POST" id="checkoutFORM">
                            <div class="row">
                                <div class="col-md-8 mb-sm-30">
                                    <div class="cart-item-table commun-table mb-30">
                                        <div class="table-responsive">
                                            <table class="table">

                                                @csrf
                                                <input type="hidden" name="shipping"
                                                    value="{{ $public_prices['shipping'] }}">
                                                <input type="hidden" name="tax" value="{{ $public_prices['tax'] }}">
                                                <thead>
                                                    <tr>
                                                        <th>{{ __('front_end.product_product') }}</th>

                                                        <th>{{ __('front_end.profile_Order_Details') }}</th>
                                                        <th>{{ __('front_end.home_Subtotal') }}</th>
                                                        <th>{{ __('front_end.shop_OutsalePrice') }}</th>
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
                                                                        <img alt="{{ $product_name }}"
                                                                            src="{{ asset($item->cart_product->image) }}">
                                                                    </div>
                                                                </a>
                                                            </td>
                                                            <td>
                                                                <div class="product-title">
                                                                    <h4>
                                                                        <a
                                                                            href="{{ route('productDetails', $product_slug) }}">
                                                                            {{ $product_name }}
                                                                        </a>
                                                                    </h4>
                                                                    {{-- <div class="color"><span class="mr-2 text-muted">Color
                                                                            :</span>gray</div>
                                                                    <div class="size"><span class="mr-2 text-muted">Size
                                                                            :</span>XL</div> --}}
                                                                    <strong class="price">JOD {{ $product_price }} *
                                                                        {{ $item->quantity }}</strong>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div data-id="100" class="total-price price-box">
                                                                    <span class="price">JOD
                                                                        {{ $product_price * $item->quantity }}
                                                                    </span>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <input type="number" step=".01"
                                                                    min="{{ $product_price }}" name="out_sale_price[]"
                                                                    value="{{ $product_price }}" />
                                                                <input type="hidden" class="qty"
                                                                    value="{{ $item->quantity }}">
                                                            </td>
                                                            <td>
                                                                <i class="fa fa-trash cart-remove-item" data-id="100"
                                                                    title="Remove Item From Cart"></i>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="5">
                                                                <div class="text-center alert alert-danger">
                                                                    <h3 class="p-0 m-0">
                                                                        No products found!
                                                                    </h3>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                    <input type="hidden" value="{{ $endTotal }}" name="sub_total">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="cart-total-table commun-table mb-30">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th colspan="2">{{ __('front_end.shop_CartTotal') }}l</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            {{ __('front_end.shop_ItemsSubtotal') }}
                                                        </td>
                                                        <td>
                                                            <div class="price-box">
                                                                <span class="price"><small>JOD
                                                                    </small>{{ $public_prices['subTotal'] }}</span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ __('front_end.profile_Shipping') }}</td>
                                                        <td>
                                                            <div class="price-box">
                                                                <span class="price">
                                                                    <small>JOD </small>
                                                                    <span
                                                                        id="shippingPrice">{{ $public_prices['shipping'] }}</span></span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ __('front_end.profile_Tax') }}
                                                            [{{ $public_prices['taxPercentage'] . '%' }}]</td>
                                                        <td>
                                                            <div class="price-box">
                                                                <span class="price"><small>JOD
                                                                    </small>
                                                                    <span id="taxPrice">
                                                                        {{ $public_prices['tax'] }}
                                                                    </span>
                                                                </span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ __('front_end.shop_WebsitePercentage') }}
                                                            [{{ $public_prices['salePercentage'] . '%' }}]</td>
                                                        <td>
                                                            <div class="price-box">
                                                                <span class="price"><small>JOD </small><span
                                                                        id="websitePercentage"></span></span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>{{ __('front_end.shop_AmountPayable') }}</b></td>
                                                        <td>
                                                            <div class="price-box">
                                                                <span class="price"><small>JOD
                                                                    </small><b>{{ $public_prices['total'] }}</b></span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>{{ __('front_end.shop_Redeem') }}</b></td>
                                                        <td>
                                                            <div class="price-box">
                                                                <span class="price"><small>JOD </small><b
                                                                        id="redeemPrice">0</b></span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>{{ __('front_end.shop_OutsaleAmount') }}</b></td>
                                                        <td>
                                                            <div class="price-box">
                                                                <span class="price"><small>JOD </small><b
                                                                        id="outsaleTotalPrice"></b></span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="cart-total-table address-box commun-table mb-30">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>{{ __('front_end.shop_ShippingAddress') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <tr>
                                                        <td>

                                                            <div class="row">
                                                                <div class="mb-2 col-12">
                                                                    <label for="name" class="form-label"
                                                                        style="font-size: 14px">
                                                                        {{ __('front_end.profile_Name') }}*
                                                                    </label>
                                                                    <input type="text" name="name"
                                                                        value="{{ old('name') }}"
                                                                        class="form-control form-control-sm"
                                                                        placeholder="{{ __('front_end.profile_Name') }}"
                                                                        id="name" required>
                                                                </div>
                                                                <div class="mb-2 col-12">
                                                                    <label for="phone" class="form-label"
                                                                        style="font-size: 14px">
                                                                        {{ __('front_end.profile_Phone') }}*
                                                                    </label>
                                                                    <input type="tel" name="phone"
                                                                        value="{{ old('phone') }}"
                                                                        class="form-control form-control-sm"
                                                                        placeholder="{{ __('front_end.profile_Phone') }}"
                                                                        id="phone" required>
                                                                </div>

                                                                <div class="mb-2 col-12">
                                                                    <label for="email" class="form-label"
                                                                        style="font-size: 14px">
                                                                        {{ __('front_end.profile_Email') }}
                                                                    </label>
                                                                    <input type="email" name="email"
                                                                        value="{{ old('email') }}"
                                                                        class="form-control form-control-sm"
                                                                        placeholder="{{ __('front_end.profile_Email') }}" id="email">
                                                                </div>
                                                                <div class="mb-2 col-12">
                                                                    <label for="company" class="form-label"
                                                                        style="font-size: 14px">
                                                                        {{ __("front_end.profile_Company") }}
                                                                    </label>
                                                                    <input type="text" name="company"
                                                                        value="{{ old('company') }}"
                                                                        class="form-control form-control-sm"
                                                                        placeholder="{{ __("front_end.profile_Company") }}" id="company">
                                                                </div>
                                                                <div class="mb-2 col-12">
                                                                    <div class="mb-0 input-box select-dropdown">
                                                                        <label for="city" class="form-label"
                                                                            style="font-size: 14px">
                                                                            {{ __("front_end.profile_city") }}*
                                                                        </label>
                                                                        <fieldset>
                                                                            <select id="city" class="option-drop"
                                                                                name="city" required>
                                                                                <option value="amman" selected>
                                                                                    {{ __("front_end.city_Amman") }}
                                                                                </option>
                                                                                <option value="zarqaa">
                                                                                    {{ __("front_end.city_Zarqaa") }}
                                                                                </option>
                                                                                <option value="irbid">
                                                                                    {{ __("front_end.city_Irbid") }}
                                                                                </option>
                                                                                <option value="salt">
                                                                                    {{ __("front_end.city_Salt") }}
                                                                                </option>
                                                                                <option value="madaba">
                                                                                    {{ __("front_end.city_Maddaba") }}
                                                                                </option>
                                                                                <option value="karak">
                                                                                    {{ __("front_end.city_Karak") }}
                                                                                </option>
                                                                                <option value="Tafilah">
                                                                                    {{ __("front_end.city_Tafilah") }}
                                                                                </option>
                                                                                <option value="ma'an">
                                                                                    {{ __("front_end.city_Maan") }}
                                                                                </option>
                                                                                <option value="jerash">
                                                                                    {{ __("front_end.city_Jerash") }}
                                                                                </option>
                                                                                <option value="ajloun">
                                                                                    {{ __("front_end.city_Ajloun") }}
                                                                                </option>
                                                                                <option value="mafraq">
                                                                                    {{ __("front_end.city_Mafraq") }}
                                                                                </option>
                                                                                <option value="aqaba">
                                                                                    {{ __("front_end.city_Aqaba") }}
                                                                                </option>
                                                                            </select>
                                                                        </fieldset>
                                                                    </div>
                                                                </div>
                                                                <div class="mb-2 col-12">
                                                                    <label for="address" class="form-label"
                                                                        style="font-size: 14px">
                                                                        {{ __("front_end.home_Address") }}*
                                                                    </label>
                                                                    <input type="text" name="address"
                                                                        value="{{ old('address') }}"
                                                                        class="form-control form-control-sm"
                                                                        placeholder="{{ __("front_end.home_Address") }}" id="address" required>
                                                                </div>
                                                                <div class="mb-2 col-12">
                                                                    <label for="apartment" class="form-label"
                                                                        style="font-size: 14px">
                                                                        {{ __("front_end.home_Apartment") }}
                                                                    </label>
                                                                    <input type="text" name="apartment"
                                                                        value="{{ old('apartment') }}"
                                                                        class="form-control form-control-sm"
                                                                        placeholder="{{ __("front_end.home_Apartment") }}" id="apartment">
                                                                </div>
                                                                <div class="mb-2 col-12">
                                                                    <label for="zipcode" class="form-label"
                                                                        style="font-size: 14px">
                                                                        {{ __("front_end.profile_Zip_Code") }}
                                                                    </label>
                                                                    <input type="text" name="zipcode"
                                                                        value="{{ old('zipcode') }}"
                                                                        class="form-control form-control-sm"
                                                                        placeholder="{{ __("front_end.profile_Zip_Code") }}" id="zipcode">
                                                                </div>
                                                                <div class="mb-2 col-12">
                                                                    <label for="zipcode" class="form-label"
                                                                        style="font-size: 14px">
                                                                        {{ __("front_end.home_More_Info") }}
                                                                    </label>
                                                                    <textarea name="more_info" id="more_info" cols="30" rows="3" class="form-control form-control-sm"
                                                                        placeholder="{{ __("front_end.home_More_Info") }}">{{ old('more_info') }}</textarea>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="right-side float-none-xs">
                                <button class="btn btn-color">
                                    Checkout
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
    <!-- CONTAINER END -->
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#checkoutBTN').on('click', function() {
                $('#checkoutFORM').submit();
            });
            // $('.createAddressForm').hide();

            $('.editAddress').on('click', function() {
                let id = $(this).attr('id');
                $(`#updateAddressForm${id}`).slideToggle();
            });

            $('#addAddress').on('click', function() {
                $('.createAddressForm').slideToggle();
            });

            $('.deleteAddressBtn').on('click', function() {
                // console.log($(this).attr('id'))
                $(this).next('form').submit();
            })

            var shippingPrice = parseFloat($('#shippingPrice').text());
            var taxPrice = parseFloat($('#taxPrice').text());
            var websitePercentage = ({{ $public_prices['subTotal'] }} * {{ $public_sale_percentage / 100 }})
                .toFixed(2);
            websitePercentage = parseFloat(websitePercentage);
            var totalSum = 0 + shippingPrice + taxPrice;





            $('input[name="out_sale_price[]"]').each(function() {
                let qty = $(this).next('.qty').val();
                let price = parseFloat($(this).val());

                totalSum += parseFloat(price * qty) || 0;
            });
            var sum = websitePercentage + totalSum;
            $('#outsaleTotalPrice').text(sum.toFixed(2));
            $('#websitePercentage').text(websitePercentage);

            $('input[name="out_sale_price[]"]').on('input', function() {
                var all_total = parseFloat({{ $public_prices['subTotal'] }})
                var shippingPrice = parseFloat($('#shippingPrice').text());
                var taxPrice = parseFloat($('#taxPrice').text());
                var websitePercentage =
                    ({{ $public_prices['subTotal'] }} * {{ $public_sale_percentage / 100 }}).toFixed(2);
                websitePercentage = parseFloat(websitePercentage);
                var totalSum = 0;


                // Loop through all "out_sale_price" input fields and sum their values
                $('input[name="out_sale_price[]"]').each(function() {
                    let qty = $(this).next('.qty').val();
                    let price = parseFloat($(this).val());
                    totalSum += parseFloat(price * qty) || 0;
                });
                // Update the "totalSumInput" with the calculated total
                var sum = totalSum + shippingPrice + taxPrice + websitePercentage;

                $('#outsaleTotalPrice').text(sum.toFixed(2));

                let redeem = sum - (websitePercentage + shippingPrice + taxPrice + all_total)

                $('#redeemPrice').text(redeem);
            });
        });
    </script>
@endpush
