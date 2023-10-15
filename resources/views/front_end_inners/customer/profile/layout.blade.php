@extends('front_end_inners.app_front_end', ['title' => 'الصفحة الرئيسية'])


@section('content')
    <!-- Bread Crumb STRAT -->
    <div class="banner inner-banner1 ">
        <div class="container">
            <section class="banner-detail center-xs">
                <h1 class="banner-title">Account</h1>
                <div class="bread-crumb right-side float-none-xs">
                    <ul>
                        <li><a href="{{ route('welcome') }}">Home</a>/</li>
                        <li><span>Account</span></li>
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
                                <div class="sub-title"><span></span> My Account</div>
                            </div>
                        </div>
                        <div class="account-tab-inner">
                            <ul class="account-tab-stap">
                                <li id="step1" class="active"> <a href="javascript:void(0)">My Dashboard<i
                                            class="fa fa-angle-right"></i> </a> </li>
                                <li id="step3"> <a href="javascript:void(0)">My Order List<i
                                            class="fa fa-angle-right"></i> </a> </li>

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    {{-- @yield('content') --}}
                </div>
            </div>
        </div>
    </section>
    <hr>
    <!-- CONTAINER END -->
@endsection

