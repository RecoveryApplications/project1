<div @class(['product-item product-card', 'mb-30' => $isInHomeView])>
    {{-- <div class="main-label sale-label"><span>Sale</span></div> --}}
    @if ($status == 'sale')
        <div class="main-label sale-label"><span>Sale</span></div>
    @endif
    @if ($status == 'new')
        <div class="main-label new-label"><span>New</span></div>
    @endif
    @php
        $defaultImage = 'front_end_style/assets/images/product/product_2_md.jpg';
    @endphp
    <div class="bg-white product-image">
        <div class="img-holder">
            <a href="{{ route('productDetails', $product->slug) }}">
                <img src={{ asset("$product->image ?? $defaultImage") }} alt="{{ $product->name ?? 'product image' }}"
                    @class(['img-fluid w-100'])>
            </a>
        </div>
        <div class="product-detail-inner">
            <div class="detail-inner-left align-center">
                <ul class="gap-2 m-0 d-flex align-items-center justify-content-center">
                    @auth('customer')
                        <li class="pro-cart-icon">
                            <form action="{{ route('customer.add-to-cart') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button title="Add to Cart"><span></span>
                                    Add to Cart
                                </button>
                            </form>
                        </li>
                        <li class="pro-wishlist-icon d-flex align-items-center justify-content-center">
                            <form action="{{ route('customer.wishlist',  $product->id) }}" method="get">
                                @csrf
                                <button type="submit"  title="Wishlist" @class(['d-flex align-items-center justify-content-center p-2', 'bg-danger text-white' => $isInFavourite]) class="">
                                    <i class="fa fa-heart" aria-hidden="true"></i>
                                </button>
                            </form>
                        </li>
                    @endauth
                    @guest('customer')
                        <li class="pro-cart-icon d-none d-lg-block">
                            <a href="#account_popup" data-toggle="modal" class="m-0 d-block w-100 add-to-cart"
                                title="Add to Cart"> <span></span>
                                Add to Cart
                            </a>
                        </li>
                        <li class="pro-cart-icon d-block d-lg-none">
                            <a href="#account_popup" data-toggle="modal">
                                <button title="Add to Cart"><span></span>
                                    Add to Cart
                                </button>
                            </a>
                        </li>
                        <li class="pro-wishlist-icon d-flex align-items-center justify-content-center">
                            <a href="#account_popup" data-toggle="modal" title="Wishlist"></a>
                        </li>
                        {{-- <li class="pro-compare-icon d-flex align-items-center justify-content-center"><a href="#account_popup" data-toggle="modal" title="Compare"></a></li> --}}
                    @endguest
                </ul>
            </div>
        </div>
    </div>
    <div class="product-item-details">
        <div class="product-item-name">
            <a href="{{ route('productDetails', $product->slug) }}">
                {{ $product->name ?? '-' }}
            </a>
        </div>
        <div class="price-box">
            @if ($product && $product->on_sale_price_status == 'Active')
                <span class="price">
                    <small>JOD </small>{{ $product->on_sale_price }}
                </span>
                <del class="price old-price">
                    <small>JOD </small>{{ $product->sale_price }}
                </del>
            @else
                <span class="price">
                    <small>JOD </small>{{ $product->sale_price ?? '' }}
                </span>
            @endif
        </div>
    </div>
</div>
