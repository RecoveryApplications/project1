<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="robots" content="@yield('robot')">

    <meta property="og:url" content="{{ url()->current() }}" />

    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <link rel="icon" href="{{ asset('front_end_style/assets/{{ asset('front_end_style/assets/images/favicon/1.png')}}') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('front_end_style/assets/{{ asset('front_end_style/assets/images/favicon/1.png')}}') }}" type="image/x-icon"> --}}
    <title>@yield('page_title')</title>

    <!-- CSS
  ================================================== -->
    <link rel="stylesheet" type="text/css" href="{{ asset('front_end_style/assets/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('front_end_style/assets/css/bootstrap.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('front_end_style/assets/css/simplebar.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('front_end_style/assets/css/jquery-ui.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('front_end_style/assets/css/owl.carousel.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('front_end_style/assets/css/custom.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('front_end_style/assets/css/responsive.css') }}">
    <link rel="shortcut icon" href="{{ asset('front_end_style/assets/images/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('front_end_style/assets/images/apple-touch-icon.png') }}">
    <link rel="apple-touch-icon" sizes="72x72"
        href="{{ asset('front_end_style/assets/images/apple-touch-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="114x114"
        href="{{ asset('front_end_style/assets/images/apple-touch-icon-114x114.png') }}">

</head>

<body class="homepage">
    <div class="se-pre-con"></div>
    <!-- newslatter-popup Start -->
    {{-- //TODO - Remove Comment On This Popup --}}
    {{-- <div id="onload-popup" class="modal fade subscribe-popup" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="newsletter-popup">
                        <div class="nl-popup-main">
                            <div class="nl-popup-inner">
                                <div class="newsletter-inner">
                                    <div class="row no-gutters">
                                        <div class="col-md-5 d-none d-md-block">
                                            <div class="newslatter-popup-img h-100">
                                                <img src="{{ asset('front_end_style/assets/images/newspopup.jpg') }}"
                                                    alt="Medizee">
                                            </div>
                                        </div>
                                        <div class="col-md-7 col-12">
                                            <div class="d-flex align-items-center h-100">
                                                <div class="text-center newslatter-popup-detail w-100">
                                                    <h2 class="main_title">Subscribe Emails</h2>
                                                    <div class="newsletter-subtitle">Get Latest News & Update</div>
                                                    <p class="text-muted">Subscribe to the Stylexpo eCommerce newsletter
                                                        to receive timely updates from your favorite products.</p>
                                                    <form class="main-form">
                                                        <input type="email" placeholder="Email Here...">
                                                        <button class="btn btn-color"
                                                            title="Subscribe">Subscribe</button>
                                                    </form>
                                                    <div class="mt-20 check-box">
                                                        <span>
                                                            <input id="no_show" type="checkbox" name="remember_me"
                                                                class="checkbox">
                                                            <label class="text-muted" for="no_show">Don't show this
                                                                popup again!</label>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- newslatter-popup End -->
    <div>
        @if (session()->has('success'))
            <script>
                swal.fire("Great Job !!!", "{!! Session::get('success') !!}", "success", {
                    button: "OK",
                });
            </script>
        @endif
        @if (session()->has('danger'))
            <script>
                swal.fire("oops !!!", "{!! Session::get('danger') !!}", "error", {
                    button: "Close",
                });
            </script>
        @endif
    </div>
    <div class="main">
        <!-- Popup Links Start -->
        <div class="popup-part">
            <div class="popup-links">
                <div class="popup-links-inner">
                    <ul>
                        <li class="categories">
                            <a class="popup-with-form" href="#categories_popup" data-toggle="modal"><span
                                    class="icon"></span><span class="icon-text">Categories</span></a>
                        </li>
                        <li class="cart-icon">
                            <a class="popup-with-form" href="#cart_popup" data-toggle="modal"><span
                                    class="icon"></span><span class="icon-text">Cart</span></a>
                        </li>
                        <li class="account">
                            <a class="popup-with-form" href="#account_popup" data-toggle="modal"><span
                                    class="icon"></span><span class="icon-text">Account</span></a>
                        </li>
                        <li class="search">
                            <a class="popup-with-form" href="#search_popup" data-toggle="modal"><span
                                    class="icon"></span><span class="icon-text">Search</span></a>
                        </li>
                        <li class="scroll scrollup">
                            <a href="#"><span class="icon"></span><span
                                    class="icon-text">Scroll-top</span></a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="popup_containt">
                <div class="modal fade" id="categories_popup" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <div class="popup-title">
                                    <h2 class="m-0 main_title heading"><span>categories</span></h2>
                                </div>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="pl-4 modal-body">
                                <div style="height: 100%;" data-simplebar data-simplebar-auto-hide="false">
                                    <div class="popup-detail">
                                        <ul class="cate-inner">
                                            <li class="level sub-megamenu">
                                                <span class="opener plus"></span>
                                                <a href="shop.html" class="page-scroll"><i
                                                        class="fa fa-female"></i>Fashion (10)</a>
                                                <div class="megamenu mega-sub-menu">
                                                    <div class="megamenu-inner-top">
                                                        <ul class="sub-menu-level1">
                                                            <li class="level2">
                                                                <ul class="sub-menu-level2 ">
                                                                    <li class="level3"><a
                                                                            href="shop.html"><span>■</span>Blazer &
                                                                            Coat</a></li>
                                                                    <li class="level3"><a
                                                                            href="shop.html"><span>■</span>Sport
                                                                            Shoes</a></li>
                                                                    <li class="level3"><a
                                                                            href="shop.html"><span>■</span>Trousers</a>
                                                                    </li>
                                                                    <li class="level3"><a
                                                                            href="shop.html"><span>■</span>Purse</a>
                                                                    </li>
                                                                    <li class="level3"><a
                                                                            href="shop.html"><span>■</span>Wallets</a>
                                                                    </li>
                                                                    <li class="level3"><a
                                                                            href="shop.html"><span>■</span>Skirts</a>
                                                                    </li>
                                                                    <li class="level3"><a
                                                                            href="shop.html"><span>■</span>Tops</a>
                                                                    </li>
                                                                    <li class="level3"><a
                                                                            href="shop.html"><span>■</span>Sleepwear</a>
                                                                    </li>
                                                                    <li class="level3"><a
                                                                            href="shop.html"><span>■</span>Jeans</a>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="level">
                                                <a href="shop.html" class="page-scroll"><i
                                                        class="fa fa-camera-retro"></i>Cameras (70)</a>
                                            </li>
                                            <li class="level">
                                                <a href="shop.html" class="page-scroll"><i
                                                        class="fa fa-desktop"></i>computers (10)</a>
                                            </li>
                                            <li class="level sub-megamenu">
                                                <span class="opener plus"></span>
                                                <a href="shop.html" class="page-scroll"><i
                                                        class="fa fa-clock-o"></i>Wathches (15)</a>
                                                <div class="megamenu mega-sub-menu">
                                                    <div class="megamenu-inner-top">
                                                        <ul class="sub-menu-level1">
                                                            <li class="level2">
                                                                <ul class="sub-menu-level2">
                                                                    <li class="level3"><a
                                                                            href="shop.html"><span>■</span>Dresses</a>
                                                                    </li>
                                                                    <li class="level3"><a
                                                                            href="shop.html"><span>■</span>Sport
                                                                            Jeans</a></li>
                                                                    <li class="level3"><a
                                                                            href="shop.html"><span>■</span>Skirts</a>
                                                                    </li>
                                                                    <li class="level3"><a
                                                                            href="shop.html"><span>■</span>Tops</a>
                                                                    </li>
                                                                    <li class="level3"><a
                                                                            href="shop.html"><span>■</span>Sleepwear</a>
                                                                    </li>
                                                                    <li class="level3"><a
                                                                            href="shop.html"><span>■</span>Jeans</a>
                                                                    </li>
                                                                    <li class="level3"><a
                                                                            href="shop.html"><span>■</span>Blazer &
                                                                            Coat</a></li>
                                                                    <li class="level3"><a
                                                                            href="shop.html"><span>■</span>Sport
                                                                            Shoes</a></li>
                                                                    <li class="level3"><a
                                                                            href="shop.html"><span>■</span>Phone
                                                                            Cases</a></li>
                                                                    <li class="level3"><a
                                                                            href="shop.html"><span>■</span>Trousers</a>
                                                                    </li>
                                                                    <li class="level3"><a
                                                                            href="shop.html"><span>■</span>Purse</a>
                                                                    </li>
                                                                    <li class="level3"><a
                                                                            href="shop.html"><span>■</span>Wallets</a>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="level">
                                                <a href="shop.html" class="page-scroll"><i
                                                        class="fa fa-shopping-bag"></i>Bags (18)</a>
                                            </li>
                                            <li class="level sub-megamenu ">
                                                <span class="opener plus"></span>
                                                <a href="shop.html" class="page-scroll"><i
                                                        class="fa fa-tablet"></i>Smartphones (20)</a>
                                                <div class="megamenu mega-sub-menu">
                                                    <div class="megamenu-inner-top">
                                                        <ul class="sub-menu-level1">
                                                            <li class="level2">
                                                                <ul class="sub-menu-level2">
                                                                    <li class="level3"><a
                                                                            href="shop.html"><span>■</span>Dresses</a>
                                                                    </li>
                                                                    <li class="level3"><a
                                                                            href="shop.html"><span>■</span>Sport
                                                                            Jeans</a></li>
                                                                    <li class="level3"><a
                                                                            href="shop.html"><span>■</span>Skirts</a>
                                                                    </li>
                                                                    <li class="level3"><a
                                                                            href="shop.html"><span>■</span>Tops</a>
                                                                    </li>
                                                                    <li class="level3"><a
                                                                            href="shop.html"><span>■</span>Sleepwear</a>
                                                                    </li>
                                                                    <li class="level3"><a
                                                                            href="shop.html"><span>■</span>Jeans</a>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                            <li class="level2">
                                                                <ul class="sub-menu-level2 ">
                                                                    <li class="level3"><a
                                                                            href="shop.html"><span>■</span>Blazer &
                                                                            Coat</a></li>
                                                                    <li class="level3"><a
                                                                            href="shop.html"><span>■</span>Sport
                                                                            Shoes</a></li>
                                                                    <li class="level3"><a
                                                                            href="shop.html"><span>■</span>Phone
                                                                            Cases</a></li>
                                                                    <li class="level3"><a
                                                                            href="shop.html"><span>■</span>Trousers</a>
                                                                    </li>
                                                                    <li class="level3"><a
                                                                            href="shop.html"><span>■</span>Purse</a>
                                                                    </li>
                                                                    <li class="level3"><a
                                                                            href="shop.html"><span>■</span>Wallets</a>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="level">
                                                <a href="shop.html" class="page-scroll"><i
                                                        class="fa fa-heart"></i>Software</a>
                                            </li>
                                            <li class="level "><a href="shop.html" class="page-scroll"><i
                                                        class="fa fa-headphones"></i>Headphone (12)</a></li>
                                            <li class="level">
                                                <a href="shop.html" class="page-scroll"><i
                                                        class="fa fa-microphone"></i>Accessories (70)</a>
                                            </li>
                                            <li class="level"><a href="shop.html" class="page-scroll"><i
                                                        class="fa fa-bolt"></i>Printers & Ink</a></li>
                                            <li class="level"><a href="shop.html" class="page-scroll"><i
                                                        class="fa fa-plus-square"></i>More Categories</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="cart_popup" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <div class="popup-title">
                                    <h2 class="m-0 main_title heading"><span>cart</span></h2>
                                </div>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="pl-4 modal-body">
                                <div class="popup-detail">
                                    <div class="cart-dropdown ">
                                        <div style="height: 300px;" data-simplebar data-simplebar-auto-hide="false">
                                            <ul class="cart-list link-dropdown-list">
                                                <li>
                                                    <a class="close-cart"><i class="fa fa-times-circle"></i></a>
                                                    <div class="media">
                                                        <a class="pull-left"><img alt="Stylexpo"
                                                                src="{{ asset('front_end_style/assets/images/product/product_1_sm.jpg') }}"></a>
                                                        <div class="media-body"> <span><a href="#">Black African
                                                                    Print Skirt</a></span>
                                                            <p class="cart-price">$14.99</p>
                                                            <div class="product-qty">
                                                                <label>Qty:</label>
                                                                <div class="custom-qty">
                                                                    <input type="text" name="qty"
                                                                        maxlength="8" value="1" title="Qty"
                                                                        class="input-text qty">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <a class="close-cart"><i class="fa fa-times-circle"></i></a>
                                                    <div class="media">
                                                        <a class="pull-left"><img alt="Stylexpo"
                                                                src="{{ asset('front_end_style/assets/images/product/product_2_sm.jpg') }}"></a>
                                                        <div class="media-body"> <span><a href="#">Black African
                                                                    Print Skirt</a></span>
                                                            <p class="cart-price">$14.99</p>
                                                            <div class="product-qty">
                                                                <label>Qty:</label>
                                                                <div class="custom-qty">
                                                                    <input type="text" name="qty"
                                                                        maxlength="8" value="1" title="Qty"
                                                                        class="input-text qty">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <a class="close-cart"><i class="fa fa-times-circle"></i></a>
                                                    <div class="media">
                                                        <a class="pull-left"><img alt="Stylexpo"
                                                                src="{{ asset('front_end_style/assets/images/product/product_3_sm.jpg') }}"></a>
                                                        <div class="media-body"> <span><a href="#">Black African
                                                                    Print Skirt</a></span>
                                                            <p class="cart-price">$14.99</p>
                                                            <div class="product-qty">
                                                                <label>Qty:</label>
                                                                <div class="custom-qty">
                                                                    <input type="text" name="qty"
                                                                        maxlength="8" value="1" title="Qty"
                                                                        class="input-text qty">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <p class="cart-sub-totle">
                                            <span class="pull-left">Cart Subtotal</span>
                                            <span class="pull-right"><strong class="price-box">$29.98</strong></span>
                                        </p>
                                        <div class="clearfix"></div>
                                        <div class="mt-20">
                                            <a href="cart.html" class="btn-color btn left-side">Cart</a>
                                            <a href="checkout.html" class="btn-color btn right-side">Checkout</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="account_popup" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <div class="popup-title">
                                    <h2 class="m-0 main_title heading"><span>Account</span></h2>
                                </div>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="p-4 modal-body">
                                <div class="pr-0 popup-detail">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <a href="account.html">
                                                <div class="account-inner mb-30">
                                                    <i class="fa fa-user"></i><br />
                                                    <span>Account</span>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-lg-4">
                                            <a href="register.html">
                                                <div class="account-inner mb-30">
                                                    <i class="fa fa-user-plus"></i><br />
                                                    <span>Register</span>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-lg-4">
                                            <a href="cart.html">
                                                <div class="account-inner mb-30">
                                                    <i class="fa fa-shopping-bag"></i><br />
                                                    <span>Shopping</span>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-lg-4">
                                            <a href="account.html#step4">
                                                <div class="account-inner">
                                                    <i class="fa fa-key"></i><br />
                                                    <span>Change Pass</span>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-lg-4">
                                            <a href="account.html#step3">
                                                <div class="account-inner">
                                                    <i class="fa fa-history"></i><br />
                                                    <span>history</span>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-lg-4">
                                            <a href="login.html">
                                                <div class="account-inner">
                                                    <i class="fa fa-share-square-o"></i><br />
                                                    <span>log out</span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="search_popup" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <div class="popup-title">
                                    <h2 class="m-0 main_title heading"><span>Search</span></h2>
                                </div>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="p-4 modal-body">
                                <div class="pr-0 popup-detail">
                                    <div class="main-search">
                                        <div class="header_search_toggle desktop-view">
                                            <form>
                                                <div class="search-box">
                                                    <input class="input-text" type="text"
                                                        placeholder="Search entire store here...">
                                                    <button class="search-btn"></button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Popup Links End -->

        <!-- HEADER START -->
        @include('front_end_inners.layout.partials.head')
        <!-- HEADER END -->


        {{-- =================================================================================================================== --}}
        {{-- ============================================== End Mobile Menu Area =============================================== --}}
        {{-- =================================================================================================================== --}}

        {{-- =================================================================================================================== --}}
        {{-- ================================================ Start Content Area =============================================== --}}
        {{-- =================================================================================================================== --}}
        @yield('content')
        {{-- =================================================================================================================== --}}
        {{-- ================================================== End Content Area =============================================== --}}
        {{-- =================================================================================================================== --}}

        <!-- FOOTER START -->
        @include('front_end_inners.layout.partials.footer')
    </div>

    <!-- FOOTER END -->

    @include('front_end_inners.layout.partials.scripts')
    @yield('javascript')


</body>

</html>
