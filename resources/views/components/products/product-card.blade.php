    <div @class(['product-item', 'mb-30' => $isInHomeView])>
        <div class="main-label sale-label"><span>Sale</span></div>
        <div class="product-image"> <a href="product-page.html"> <img
                    src={{ asset('front_end_style/assets/images/product/product_2_md.jpg') }} alt="Stylexpo">
            </a>
            <div class="product-detail-inner">
                <div class="detail-inner-left align-center">
                    <ul>
                        <li class="pro-cart-icon">
                            <form>
                                <button title="Add to Cart"><span></span>Add to
                                    Cart</button>
                            </form>
                        </li>
                        <li class="pro-wishlist-icon "><a href="wishlist.html" title="Wishlist"></a></li>
                        <li class="pro-compare-icon"><a href="compare.html" title="Compare"></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="product-item-details">
            <div class="product-item-name">
                <a href="product-page.html">
                    {{ $product->name ?? '-' }}
                </a>
            </div>
            <div class="price-box">
                @if ($product && $product->on_sale_price_status == "Active")
                    <span class="price">
                        ${{ $product->on_sale_price }}
                    </span>
                    <del class="price old-price">
                        ${{ $product->sale_price }}
                    </del>
                @else
                    <span class="price">
                        ${{ $product->sale_price ?? '' }}
                    </span>
                @endif
            </div>
        </div>
    </div>
