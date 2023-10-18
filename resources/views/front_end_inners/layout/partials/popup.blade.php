<div class="popup-part">
    <div class="popup-links">
        <div class="bg-transparent popup-links-inner">
            <ul class="ps-0">
                <li class="cart-icon">
                    <a class="popup-with-form" href="#cart_popup" data-toggle="modal"><span class="icon"></span><span
                            class="icon-text">Cart</span></a>
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
                    <a href="#"><span class="icon"></span></a>
                </li>
            </ul>
        </div>
    </div>
    <div class="popup_containt">
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
                                        @forelse ($public_customer_carts as $item)
                                            @php
                                                if ($item->property_type == 2) {
                                                    $product_name = $item->cart_product->name_en;
                                                } else {
                                                    $product_name = $item->cart_product->product->name_en;
                                                }
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
                                                            <small>JOD
                                                            </small>{{ $item->cart_product->on_sale_price_status == 'Active' ? $item->cart_product->on_sale_price : $item->cart_product->sale_price }}
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
                                                    <a href="{{ route('shop') }}" style="text-decoration: underline"> >>
                                                        Go to shopping << </a>
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
                            <div class="row justify-content-center">
                                @auth('customer')
                                    <div class="col-lg-4">
                                        <a href="{{ route('customer.profile') }}">
                                            <div class="account-inner mb-30">
                                                <i class="fa fa-user"></i><br />
                                                <span>Account</span>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-lg-4">
                                        <a href="{{ route('shop') }}">
                                            <div class="account-inner mb-30">
                                                <i class="fa fa-shopping-bag"></i><br />
                                                <span>Shopping</span>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-lg-4">
                                        <a href="{{ route('customer.logout') }}">
                                            <div class="account-inner">
                                                <i class="fa fa-share-square-o"></i><br />
                                                <span>log out</span>
                                            </div>
                                        </a>
                                    </div>
                                @endauth

                                @guest('customer')
                                    <div class="col-lg-4">
                                        <a href="{{ route('customer.loginRegister', 'login') }}">
                                            <div class="account-inner mb-30">
                                                <i class="fa fa-sign-in"></i><br />
                                                <span>Login</span>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-lg-4">
                                        <a href="{{ route('customer.loginRegister', 'register') }}">
                                            <div class="account-inner mb-30">
                                                <i class="fa fa-user-plus"></i><br />
                                                <span>Register</span>
                                            </div>
                                        </a>
                                    </div>
                                @endguest

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
                                    <form
                                        action="{{ route('shop') }}"
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
    </div>
</div>
