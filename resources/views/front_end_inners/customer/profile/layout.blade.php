@extends('front_end_inners.app_front_end', ['title' => $title ?? ''])


@php
    $image_url = asset('images/Userprofile.png');
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
                <h1 class="banner-title">{{ __('front_end.BreadCrump_Account') }}</h1>
                <div class="bread-crumb right-side float-none-xs">
                    <ul>
                        <li><a href="{{ route('welcome') }}">{{ __('front_end.BreadCrump_Home') }}</a>/</li>
                        <li><span>{{ __('front_end.BreadCrump_Account') }}</span></li>
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
                <div class="col-lg-3">
                    <div class="account-sidebar account-tab mb-sm-30">
                        <div class="dark-bg tab-title-bg">
                            <div class="heading-part">
                                <div class="sub-title"><span></span>{{ __('front_end.profile_My_Dashboard') }}</div>
                            </div>
                        </div>
                        <div class="account-tab-inner">
                            <ul class="">
                                <li @class(['active' => request()->routeIs('customer.profile')])>
                                    <a href="{{ route('customer.profile') }}" @class([
                                        'text-secondary' => !request()->routeIs('customer.profile'),
                                        'text-white' => request()->routeIs('customer.profile'),
                                    ])>
                                        {{ __('front_end.profile_My_Dashboard') }}
                                        <i class="fa fa-angle-right"></i>
                                    </a>
                                </li>
                                <li @class(['active' => request()->routeIs('customer.wallet')])>
                                    <a href="{{ route('customer.wallet') }}" @class([
                                        'text-secondary' => !request()->routeIs('customer.wallet'),
                                        'text-white' => request()->routeIs('customer.wallet'),
                                    ])>
                                        {{ __('front_end.profile_My_Wallet') }}
                                        <i class="fa fa-angle-right"></i>
                                    </a>
                                </li>
                                <li @class(['active' => request()->routeIs('customer.orders')])>
                                    <a href="{{ route('customer.orders') }}" @class([
                                        'text-secondary' => !request()->routeIs('customer.orders'),
                                        'text-white' => request()->routeIs('customer.orders'),
                                    ])>
                                        {{ __('front_end.profile_My_Order_List') }}
                                        <i class="fa fa-angle-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    @yield('user-content')
                </div>
            </div>
        </div>
    </section>
    <hr>
    <!-- CONTAINER END -->
@endsection

@push('scripts')
    {{-- <script>
        $('#createWithdrawalRequest').hide();
        $('#createAddressForm').hide();
        $('.editAddressForm').hide();

        $('.editAddress').on('click', function() {
            let id = $(this).attr('id');
            $(`#updateAddressForm${id}`).slideToggle();
        });

        $('#requestWithdrawalBtn').on('click', function() {
            $('#createWithdrawalRequest').slideToggle();
        });
        $('#addAddress').on('click', function() {
            $('#createAddressForm').slideToggle();
        });

        $('.deleteAddressBtn').on('click', function() {
            // console.log($(this).attr('id'))
            $(this).next('form').submit();
        })
    </script> --}}
@endpush
