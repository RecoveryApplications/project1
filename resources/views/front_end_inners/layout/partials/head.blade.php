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
                        <ul class="d-flex align-items-center">
                            @auth('customer')
                                <li class="d-none d-lg-block">
                                    <a href="{{ route('customer.logout') }}">
                                        <div class="account-inner">
                                            <i class="pt-2 fa fa-share-square-o" style="font-size: 25px"></i>
                                        </div>
                                    </a>
                                </li>
                                <li class="wishlist-icon d-none d-lg-block">
                                    <a href="{{ route('customer.profile') }}">
                                        <i class="pt-2 fa fa-user" style="font-size: 25px" aria-hidden="true"></i>
                                    </a>
                                </li>
                            @endauth
                            @guest('customer')
                                <li class="wishlist-icon d-none d-lg-block">
                                    <a href="{{ route('customer.loginRegister') }}">
                                        <i class="pt-2 fa fa-sign-in" style="font-size: 25px" aria-hidden="true"></i>
                                    </a>
                                </li>
                            @endguest
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
                                                                <small>JOD </small>{{ $product_price }}
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
                                        <span class="pull-right"><strong class="price-box"><small>JOD
                                                </small>{{ $endTotal }}</strong></span>
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
                                <form action="{{ route('shop', array_merge(request()->query(), ['_token' => null])) }}"
                                    method="GET">
                                    <div class="search-box">
                                        <input class="input-text" name="search" value="{{ old('search') }}"
                                            type="text" placeholder="Search store products here...">
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
                                                                <a href="{{ route('customer.profile') }}"
                                                                    title="Login"><i class="fa fa-user"></i>
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
                                        @forelse ($public_main_categories as $category)
                                            @php
                                                $queryParams = request()->query();
                                                $queryParams['category'] = $category->id;
                                                $url = route('shop') . '?' . http_build_query($queryParams);
                                            @endphp
                                            <li class="level">
                                                <a href="{{ $url }}"
                                                    class="page-scroll">{{ $category->name }}
                                                    ({{ $category->products_count }})
                                                </a>
                                            </li>
                                        @empty
                                        @endforelse

                                        <hr>

                                        @auth('customer')
                                            <li class="wishlist-icon d-block d-lg-none">
                                                <a href="{{ route('customer.profile') }}">
                                                    <i class="fa fa-user"></i>
                                                    profile
                                                </a>
                                            </li>
                                            <li class="wishlist-icon d-block d-lg-none">
                                                <a href="{{ route('customer.getWishList') }}">
                                                    ❤️
                                                    wishlist
                                                </a>
                                            </li>
                                            <li class="wishlist-icon d-block d-lg-none">
                                                <a href="{{ route('customer.logout') }}">
                                                    <div class="account-inner">
                                                        <i class="fa fa-share-square-o"></i>
                                                        logout
                                                    </div>
                                                </a>
                                            </li>
                                        @endauth
                                        @guest('customer')
                                            <li class="wishlist-icon d-block d-lg-none">
                                                <a href="{{ route('customer.loginRegister') }}">
                                                    <i class="fa fa-user"></i>
                                                    login
                                                </a>
                                            </li>
                                            <li class="wishlist-icon d-block d-lg-none">
                                                <a href="{{ route('customer.loginRegister', 'register') }}">
                                                    <i class="fa fa-user"></i>
                                                    register
                                                </a>
                                            </li>
                                        @endguest
                                    </ul>
                                    <div class="header-top mobile">
                                        <div class="">
                                            <div class="row">
                                                {{-- <div class="col-12">
                                                    <div class="top-link top-link-left select-dropdown ">
                                                        <fieldset>
                                                            <select name="speed" class="country option-drop">
                                                                <option selected="selected">English</option>
                                                                <option>Frence</option>
                                                                <option>German</option>
                                                            </select>
                                                        </fieldset>
                                                    </div>
                                                </div> --}}
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
