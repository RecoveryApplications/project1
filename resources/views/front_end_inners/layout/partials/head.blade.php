<header class="navbar navbar-custom container-full-sm" id="header">
    <div class="header-middle">
        <div class="container">
            <hr>
            <div class="row align-items-center">
                <div class="col-xl-3 col-md-3 col-6 col-lgmd-20per order-md-1">
                    <div class="header-middle-left">
                        <div class="navbar-header float-none-sm">
                            <a class="navbar-brand page-scroll" href="{{ route('welcome') }}">
                                <img alt="FamilyDrop" src="{{ asset('front_end_style/assets/images/logo.png') }}"
                                    style="width: 100px">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-3 col-6 col-lgmd-20per order-md-3">
                    <div class="right-side header-right-link">
                        <ul>
                            <li class="wishlist-icon">
                                <a href="{{ route('customer.getWishList') }}">
                                    <span></span>
                                </a>
                            </li>
                            <li class="cart-icon">
                                <a href="#"> <span> <small
                                            class="cart-notification">{{ $public_customer_carts_count }}</small> </span>
                                </a>
                                <div class="cart-dropdown header-link-dropdown">
                                    <div style="height: 245px;" data-simplebar data-simplebar-auto-hide="false">
                                        <ul class="cart-list link-dropdown-list">
                                            @forelse ($public_customer_carts as $item)
                                                @php
                                                    if ($item->property_type == 2) {
                                                        $product_name = $item->cart_product->name_en;
                                                    } else {
                                                        $product_name = $item->cart_product->product->name_en;
                                                    }

                                                    $product_price = $item->cart_product->on_sale_price_status == 'Active' ? $item->cart_product->on_sale_price : $item->cart_product->sale_price;
                                                @endphp
                                                <li>
                                                    <a class="close-cart"
                                                        href="{{ route('customer.remove-from-cart', $item->id) }}">
                                                        <i class="fa fa-times-circle"></i>
                                                    </a>
                                                    <div class="media"> <a class="pull-left"> <img alt="Stylexpo"
                                                                src="{{ asset($item->cart_product->image) }}"></a>
                                                        <div class="media-body"> <span><a href="#">
                                                                    {{ $product_name }}
                                                                </a></span>
                                                            <p class="cart-price">
                                                                ${{ $product_price }}
                                                            </p>
                                                            <div class="product-qty">
                                                                <label>Qty:</label>
                                                                <div class="custom-qty">
                                                                    <input type="text" readonly name="qty"
                                                                        maxlength="8" value="{{ $item->quantity }}"
                                                                        title="Qty" class="input-text qty">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            @empty
                                                <li>
                                                    <h5 class="text-center alert alert-danger">
                                                        No items in the cart <br>
                                                        <a href="{{ route('shop') }}"
                                                            style="text-decoration: underline"> >> Go to shopping <<
                                                                </a>
                                                    </h5>
                                                </li>
                                            @endforelse
                                        </ul>
                                    </div>
                                    <p class="cart-sub-totle">
                                        <span class="pull-left">Cart Subtotal</span>
                                        <span class="pull-right"><strong
                                                class="price-box">${{ $endTotal }}</strong></span>
                                    </p>
                                    <div class="clearfix"></div>
                                    <div class="mt-20">
                                        <a href="{{ route('cart') }}" class="btn-color btn left-side">Cart</a>
                                        <a href="{{ route('customer.orderOverview') }}"
                                            class="btn-color btn right-side">Checkout</a>
                                    </div>
                                </div>
                            </li>
                            <li class="side-toggle">
                                <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle"
                                    type="button"><i class="fa fa-bars"></i></button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-6 col-md-6 col-12 col-lgmd-60per order-md-2">
                    <div class="p-0 header-right-part">
                        <div class="main-search w-100">
                            <div class="header_search_toggle desktop-view">
                                <form>
                                    <div class="search-box">
                                        <input class="input-text" type="text"
                                            placeholder="Search store products here...">
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
    <div class="header-bottom">
        <div class="container">
            <div class="row position-r">
                <div class="col-xl-2 col-lg-3 col-lgmd-20per position-s">
                    <div class="sidebar-menu-dropdown home">
                        <a class="btn-sidebar-menu-dropdown"><span></span> Categories </a>
                        <div id="cat" class="cat-dropdown">
                            <div class="sidebar-contant">
                                <div id="menu" class="navbar-collapse collapse">
                                    <div class="top-right-link mobile right-side">
                                        <ul>
                                            <li class="login-icon content">
                                                <a class="content-link">
                                                    <span class="content-icon"></span>
                                                </a>
                                                <a href="login.html" title="Login">Login</a> or
                                                <a href="register.html" title="Register">Register</a>
                                                <div class="content-dropdown">
                                                    <ul>
                                                        @auth('customer')
                                                            <li class="login-icon">
                                                                <a href="{{ route('customer.profile') }}" title="Login"><i
                                                                        class="fa fa-user"></i>
                                                                    Profile
                                                                </a>
                                                            </li>
                                                        @endauth
                                                        @guest('customer')
                                                            <li class="login-icon">
                                                                <a href="{{ route('customer.login') }}" title="Login"><i
                                                                        class="fa fa-user"></i>
                                                                    Login
                                                                </a>
                                                            </li>
                                                            <li class="register-icon">
                                                                <a href="{{ route('customer.register') }}"
                                                                    title="Register">
                                                                    <i class="fa fa-user-plus"></i>
                                                                    Register
                                                                </a>
                                                            </li>
                                                        @endguest
                                                    </ul>
                                                </div>
                                            </li>
                                            {{-- <li class="track-icon">
                                                <a title="Track your order"><span></span> Track your order</a>
                                            </li>
                                            <li class="gift-icon">
                                                <a href="" title="Gift card"><span></span> Gift
                                                    card</a>
                                            </li> --}}
                                        </ul>
                                    </div>
                                    <ul class="nav navbar-nav ">
                                        <li class="level sub-megamenu">
                                            <span class="opener plus"></span>
                                            <a href="{{ route('shop') }}" class="page-scroll"><i
                                                    class="fa fa-female"></i>Fashion (10)</a>
                                            <div class="megamenu mobile-sub-menu">
                                                <div class="megamenu-inner-top">
                                                    <ul class="sub-menu-level1 d-lg-flex">
                                                        <li class="level2">
                                                            <a href="{{ route('shop') }}"><span>Kids
                                                                    Fashion</span></a>
                                                            <ul class="sub-menu-level2 ">
                                                                <li class="level3"><a
                                                                        href="{{ route('shop') }}"><span>■</span>Blazer
                                                                        &
                                                                        Coat</a></li>
                                                                <li class="level3"><a
                                                                        href="{{ route('shop') }}"><span>■</span>Sport
                                                                        Shoes</a></li>
                                                                <li class="level3"><a
                                                                        href="{{ route('shop') }}"><span>■</span>Trousers</a>
                                                                </li>
                                                                <li class="level3"><a
                                                                        href="{{ route('shop') }}"><span>■</span>Purse</a>
                                                                </li>
                                                                <li class="level3"><a
                                                                        href="{{ route('shop') }}"><span>■</span>Wallets</a>
                                                                </li>
                                                                <li class="level3"><a
                                                                        href="{{ route('shop') }}"><span>■</span>Skirts</a>
                                                                </li>
                                                                <li class="level3"><a
                                                                        href="{{ route('shop') }}"><span>■</span>Tops</a>
                                                                </li>
                                                                <li class="level3"><a
                                                                        href="{{ route('shop') }}"><span>■</span>Sleepwear</a>
                                                                </li>
                                                                <li class="level3"><a
                                                                        href="{{ route('shop') }}"><span>■</span>Jeans</a>
                                                                </li>
                                                            </ul>
                                                        </li>
                                                        <li class="level2">
                                                            <div class="sub-menu-slider d-none d-lg-block ">
                                                                <div class="row">
                                                                    <div class="owl-carousel sub_menu_slider">
                                                                        <div class="product-item">
                                                                            <div class="product-image">
                                                                                <a href="product-page.html">
                                                                                    <img src="{{ asset('front_end_style/assets/images/product/product_1_md.jpg') }}"
                                                                                        alt="Stylexpo">
                                                                                </a>
                                                                                <div class="product-detail-inner">
                                                                                    <div
                                                                                        class="detail-inner-left align-center">
                                                                                        <ul>
                                                                                            <li class="pro-cart-icon">
                                                                                                <form>
                                                                                                    <button
                                                                                                        title="Add to Cart"><span></span></button>
                                                                                                </form>
                                                                                            </li>
                                                                                            <li
                                                                                                class="pro-wishlist-icon">
                                                                                                <a href="{{ route('customer.getWishList') }}"
                                                                                                    title="Wishlist"></a>
                                                                                            </li>
                                                                                        </ul>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="product-item-details">
                                                                                <div class="product-item-name">
                                                                                    <a href="product-page.html">Defyant
                                                                                        Reversible Dot
                                                                                        Shorts</a>
                                                                                </div>
                                                                                <div class="price-box"> <span
                                                                                        class="price">$80.00</span>
                                                                                </div>
                                                                                <div
                                                                                    class="rating-summary-block right-side">
                                                                                    <div title="53%"
                                                                                        class="rating-result">
                                                                                        <span style="width:53%"></span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="product-item">
                                                                            <div class="product-image">
                                                                                <a href="product-page.html">
                                                                                    <img src="{{ asset('front_end_style/assets/images/product/product_2_md.jpg') }}"
                                                                                        alt="Stylexpo">
                                                                                </a>
                                                                                <div class="product-detail-inner">
                                                                                    <div
                                                                                        class="detail-inner-left align-center">
                                                                                        <ul>
                                                                                            <li class="pro-cart-icon">
                                                                                                <form>
                                                                                                    <button
                                                                                                        title="Add to Cart"><span></span></button>
                                                                                                </form>
                                                                                            </li>
                                                                                            <li
                                                                                                class="pro-wishlist-icon">
                                                                                                <a href="{{ route('customer.getWishList') }}"
                                                                                                    title="Wishlist"></a>
                                                                                            </li>

                                                                                        </ul>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="product-item-details">
                                                                                <div class="product-item-name">
                                                                                    <a href="product-page.html">Defyant
                                                                                        Reversible Dot
                                                                                        Shorts</a>
                                                                                </div>
                                                                                <div class="price-box"> <span
                                                                                        class="price">$80.00</span>
                                                                                </div>
                                                                                <div
                                                                                    class="rating-summary-block right-side">
                                                                                    <div title="53%"
                                                                                        class="rating-result">
                                                                                        <span style="width:53%"></span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="product-item">
                                                                            <div class="product-image">
                                                                                <a href="product-page.html">
                                                                                    <img src="{{ asset('front_end_style/assets/images/product/product_3_md.jpg') }}"
                                                                                        alt="Stylexpo">
                                                                                </a>
                                                                                <div class="product-detail-inner">
                                                                                    <div
                                                                                        class="detail-inner-left align-center">
                                                                                        <ul>
                                                                                            <li class="pro-cart-icon">
                                                                                                <form>
                                                                                                    <button
                                                                                                        title="Add to Cart"><span></span></button>
                                                                                                </form>
                                                                                            </li>
                                                                                            <li
                                                                                                class="pro-wishlist-icon">
                                                                                                <a href="{{ route('customer.getWishList') }}"
                                                                                                    title="Wishlist"></a>
                                                                                            </li>
                                                                                        </ul>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="product-item-details">
                                                                                <div class="product-item-name">
                                                                                    <a href="product-page.html">Defyant
                                                                                        Reversible Dot
                                                                                        Shorts</a>
                                                                                </div>
                                                                                <div class="price-box"> <span
                                                                                        class="price">$80.00</span>
                                                                                </div>
                                                                                <div
                                                                                    class="rating-summary-block right-side">
                                                                                    <div title="53%"
                                                                                        class="rating-result">
                                                                                        <span style="width:53%"></span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="product-item">
                                                                            <div class="product-image">
                                                                                <a href="product-page.html">
                                                                                    <img src="{{ asset('front_end_style/assets/images/product/product_4_md.jpg') }}"
                                                                                        alt="Stylexpo">
                                                                                </a>
                                                                                <div class="product-detail-inner">
                                                                                    <div
                                                                                        class="detail-inner-left align-center">
                                                                                        <ul>
                                                                                            <li class="pro-cart-icon">
                                                                                                <form>
                                                                                                    <button
                                                                                                        title="Add to Cart"><span></span></button>
                                                                                                </form>
                                                                                            </li>
                                                                                            <li
                                                                                                class="pro-wishlist-icon">
                                                                                                <a href="{{ route('customer.getWishList') }}"
                                                                                                    title="Wishlist"></a>
                                                                                            </li>
                                                                                        </ul>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="product-item-details">
                                                                                <div class="product-item-name">
                                                                                    <a href="product-page.html">Defyant
                                                                                        Reversible Dot
                                                                                        Shorts</a>
                                                                                </div>
                                                                                <div class="price-box"> <span
                                                                                        class="price">$80.00</span>
                                                                                </div>
                                                                                <div
                                                                                    class="rating-summary-block right-side">
                                                                                    <div title="53%"
                                                                                        class="rating-result">
                                                                                        <span style="width:53%"></span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="product-item">
                                                                            <div class="product-image">
                                                                                <a href="product-page.html">
                                                                                    <img src="{{ asset('front_end_style/assets/images/product/product_5_md.jpg') }}"
                                                                                        alt="Stylexpo">
                                                                                </a>
                                                                                <div class="product-detail-inner">
                                                                                    <div
                                                                                        class="detail-inner-left align-center">
                                                                                        <ul>
                                                                                            <li class="pro-cart-icon">
                                                                                                <form>
                                                                                                    <button
                                                                                                        title="Add to Cart"><span></span></button>
                                                                                                </form>
                                                                                            </li>
                                                                                            <li
                                                                                                class="pro-wishlist-icon">
                                                                                                <a href="{{ route('customer.getWishList') }}"
                                                                                                    title="Wishlist"></a>
                                                                                            </li>
                                                                                        </ul>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="product-item-details">
                                                                                <div class="product-item-name">
                                                                                    <a href="product-page.html">Defyant
                                                                                        Reversible Dot
                                                                                        Shorts</a>
                                                                                </div>
                                                                                <div class="price-box"> <span
                                                                                        class="price">$80.00</span>
                                                                                </div>
                                                                                <div
                                                                                    class="rating-summary-block right-side">
                                                                                    <div title="53%"
                                                                                        class="rating-result">
                                                                                        <span style="width:53%"></span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="level">
                                            <a href="{{ route('shop') }}" class="page-scroll"><i
                                                    class="fa fa-camera-retro"></i>Cameras (70)</a>
                                        </li>
                                        <li class="level">
                                            <a href="{{ route('shop') }}" class="page-scroll">
                                                <i class="fa fa-desktop"></i>computers (10)<div class="menu-label">
                                                    <span class="hot-menu"> Hot </span>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="level sub-megamenu">
                                            <span class="opener plus"></span>
                                            <a href="{{ route('shop') }}" class="page-scroll"><i
                                                    class="fa fa-clock-o"></i>Wathches (15)</a>
                                            <div class="megamenu mobile-sub-menu">
                                                <div class="megamenu-inner-top">
                                                    <ul class="sub-menu-level1 d-lg-flex">
                                                        <li class="level2">
                                                            <a href="{{ route('shop') }}"><span>Men Fashion</span></a>
                                                            <ul class="sub-menu-level2">
                                                                <li class="level3"><a
                                                                        href="{{ route('shop') }}"><span>■</span>Dresses</a>
                                                                </li>
                                                                <li class="level3"><a
                                                                        href="{{ route('shop') }}"><span>■</span>Sport
                                                                        Jeans</a></li>
                                                                <li class="level3"><a
                                                                        href="{{ route('shop') }}"><span>■</span>Skirts</a>
                                                                </li>
                                                                <li class="level3"><a
                                                                        href="{{ route('shop') }}"><span>■</span>Tops</a>
                                                                </li>
                                                                <li class="level3"><a
                                                                        href="{{ route('shop') }}"><span>■</span>Sleepwear</a>
                                                                </li>
                                                                <li class="level3"><a
                                                                        href="{{ route('shop') }}"><span>■</span>Jeans</a>
                                                                </li>
                                                            </ul>
                                                        </li>
                                                        <li class="level2">
                                                            <a href="{{ route('shop') }}"><span>Women
                                                                    Fashion</span></a>
                                                            <ul class="sub-menu-level2 ">
                                                                <li class="level3"><a
                                                                        href="{{ route('shop') }}"><span>■</span>Blazer
                                                                        &
                                                                        Coat</a></li>
                                                                <li class="level3"><a
                                                                        href="{{ route('shop') }}"><span>■</span>Sport
                                                                        Shoes</a></li>
                                                                <li class="level3"><a
                                                                        href="{{ route('shop') }}"><span>■</span>Phone
                                                                        Cases</a></li>
                                                                <li class="level3"><a
                                                                        href="{{ route('shop') }}"><span>■</span>Trousers</a>
                                                                </li>
                                                                <li class="level3"><a
                                                                        href="{{ route('shop') }}"><span>■</span>Purse</a>
                                                                </li>
                                                                <li class="level3"><a
                                                                        href="{{ route('shop') }}"><span>■</span>Wallets</a>
                                                                </li>
                                                            </ul>
                                                        </li>
                                                        <li class="level2 d-none d-lg-block">
                                                            <a href="{{ route('shop') }}">
                                                                <img src="{{ asset('front_end_style/assets/images/drop_banner.jpg') }}"
                                                                    alt="Stylexpo">
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="level">
                                            <a href="{{ route('shop') }}" class="page-scroll">
                                                <i class="fa fa-shopping-bag"></i>Bags (18)<div class="menu-label">
                                                    <span class="new-menu"> New </span>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="level sub-megamenu ">
                                            <span class="opener plus"></span>
                                            <a href="{{ route('shop') }}" class="page-scroll"><i
                                                    class="fa fa-tablet"></i>Smartphones (20)</a>
                                            <div class="megamenu mobile-sub-menu">
                                                <div class="megamenu-inner-top">
                                                    <ul class="sub-menu-level1 d-lg-flex">
                                                        <li class="level2">
                                                            <a href="{{ route('shop') }}"><span>Women
                                                                    Clothings</span></a>
                                                            <ul class="sub-menu-level2">
                                                                <li class="level3"><a
                                                                        href="{{ route('shop') }}"><span>■</span>Dresses</a>
                                                                </li>
                                                                <li class="level3"><a
                                                                        href="{{ route('shop') }}"><span>■</span>Sport
                                                                        Jeans</a></li>
                                                                <li class="level3"><a
                                                                        href="{{ route('shop') }}"><span>■</span>Skirts</a>
                                                                </li>
                                                                <li class="level3"><a
                                                                        href="{{ route('shop') }}"><span>■</span>Tops</a>
                                                                </li>
                                                                <li class="level3"><a
                                                                        href="{{ route('shop') }}"><span>■</span>Sleepwear</a>
                                                                </li>
                                                                <li class="level3"><a
                                                                        href="{{ route('shop') }}"><span>■</span>Jeans</a>
                                                                </li>
                                                            </ul>
                                                        </li>
                                                        <li class="level2">
                                                            <a href="{{ route('shop') }}"><span>Men
                                                                    Clothings</span></a>
                                                            <ul class="sub-menu-level2 ">
                                                                <li class="level3"><a
                                                                        href="{{ route('shop') }}"><span>■</span>Blazer
                                                                        &
                                                                        Coat</a></li>
                                                                <li class="level3"><a
                                                                        href="{{ route('shop') }}"><span>■</span>Sport
                                                                        Shoes</a></li>
                                                                <li class="level3"><a
                                                                        href="{{ route('shop') }}"><span>■</span>Phone
                                                                        Cases</a></li>
                                                                <li class="level3"><a
                                                                        href="{{ route('shop') }}"><span>■</span>Trousers</a>
                                                                </li>
                                                                <li class="level3"><a
                                                                        href="{{ route('shop') }}"><span>■</span>Purse</a>
                                                                </li>
                                                                <li class="level3"><a
                                                                        href="{{ route('shop') }}"><span>■</span>Wallets</a>
                                                                </li>
                                                            </ul>
                                                        </li>
                                                        <li class="level2">
                                                            <a href="{{ route('shop') }}"><span>Juniors kid</span></a>
                                                            <ul class="sub-menu-level2 ">
                                                                <li class="level3"><a
                                                                        href="{{ route('shop') }}"><span>■</span>Blazer
                                                                        &
                                                                        Coat</a></li>
                                                                <li class="level3"><a
                                                                        href="{{ route('shop') }}"><span>■</span>Sport
                                                                        Shoes</a></li>
                                                                <li class="level3"><a
                                                                        href="{{ route('shop') }}"><span>■</span>Phone
                                                                        Cases</a></li>
                                                                <li class="level3"><a
                                                                        href="{{ route('shop') }}"><span>■</span>Trousers</a>
                                                                </li>
                                                                <li class="level3"><a
                                                                        href="{{ route('shop') }}"><span>■</span>Purse</a>
                                                                </li>
                                                                <li class="level3"><a
                                                                        href="{{ route('shop') }}"><span>■</span>Wallets</a>
                                                                </li>
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="level">
                                            <a href="{{ route('shop') }}" class="page-scroll"><i
                                                    class="fa fa-heart"></i>Software</a>
                                        </li>
                                        <li class="level "><a href="{{ route('shop') }}" class="page-scroll"><i
                                                    class="fa fa-headphones"></i>Headphone (12)</a></li>
                                        <li class="level">
                                            <a href="{{ route('shop') }}" class="page-scroll"><i
                                                    class="fa fa-microphone"></i>Accessories (70)</a>
                                        </li>
                                        <li class="level"><a href="{{ route('shop') }}" class="page-scroll"><i
                                                    class="fa fa-bolt"></i>Printers & Ink</a></li>
                                        <li class="level"><a href="{{ route('shop') }}" class="page-scroll"><i
                                                    class="fa fa-plus-square"></i>More Categories</a></li>
                                    </ul>
                                    <div class="header-top mobile">
                                        <div class="">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="top-link top-link-left select-dropdown ">
                                                        <fieldset>
                                                            <select name="speed" class="country option-drop">
                                                                <option selected="selected">English</option>
                                                                <option>Frence</option>
                                                                <option>German</option>
                                                            </select>
                                                            <select name="speed" class="currency option-drop">
                                                                <option selected="selected">USD</option>
                                                                <option>EURO</option>
                                                                <option>POUND</option>
                                                            </select>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="top-link right-side">
                                                        <div class="help-num">Need Help? :
                                                            {{ $public_contact_us['phone'] }}</div>
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
                <div class="col-xl-6 col-lg-6 col-lgmd-60per">
                    <div class="bottom-inner">
                        <div class="position-r">
                            <div class="nav_sec position-r">
                                <div class="mobilemenu-title mobilemenu">
                                    <span>Menu</span>
                                    <i class="fa fa-bars pull-right"></i>
                                </div>
                                <div class="mobilemenu-content">
                                    <ul class="nav navbar-nav" id="menu-main">
                                        <li @class(['active' => request()->routeIs('welcome')]) class="active">
                                            <a href="{{ route('welcome') }}"><span>Home</span></a>
                                        </li>
                                        <li @class(['active' => request()->routeIs('shop')])>
                                            <a href="{{ route('shop') }}"><span>Shop</span></a>
                                        </li>
                                        <li @class(['active' => request()->routeIs('Blogs')])>
                                            <a href="{{ route('Blogs') }}"><span>Blogs</span></a>
                                        </li>
                                        <li @class(['active' => request()->routeIs('aboutUs')])>
                                            <a href="{{ route('aboutUs') }}"><span>About Us</span></a>
                                        </li>
                                        <li @class(['active' => request()->routeIs('contactUs')])>
                                            <a href="{{ route('contactUs') }}"><span>Contact</span></a>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-3 col-lgmd-20per">
                    <div class="right-side float-left-xs header-right-link">
                        <div class="right-side">
                            <div class="help-num">Need Help? : {{ $public_contact_us['phone'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
