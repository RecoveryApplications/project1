@extends('front_end_inners.shop.layout.shopLayout')


@section('shop-theme')
    <div class="product-listing list-type">
        <div class="row">
            @foreach ($products as $product)
                <div class="col-xl-6 col-12">
                    <div class="shop-list-view">
                        <div class="product-item">
                            <div class="main-label sale-label"><span>Sale</span></div>
                            <div class="product-image">
                                <a href="product-page.html">
                                    <img src={{ asset($product->image) }} alt="Stylexpo">
                                </a>
                            </div>
                        </div>
                        <div class="product-item-details">
                            <div class="product-item-name">
                                <a href="product-page.html">
                                    {{ $product->name }}
                                </a>
                            </div>
                            <div class="rating-summary-block">
                                <div title="53%" class="rating-result"> <span style="width:53%"></span>
                                </div>
                            </div>
                            <div class="price-box"> <span class="price">$80.00</span> <del
                                    class="price old-price">$100.00</del> </div>
                            <p>Proin lectus ipsum, gravida et mattis vulputate, tristique ut lectus. Sed
                                et lorem nunc. ipsum primis in faucibus orci luctus et ultrices.</p>
                            <div class="bottom-detail">
                                <ul>
                                    <li class="pro-cart-icon">
                                        <form>
                                            <button title="Add to Cart" class=""><span></span></button>
                                        </form>
                                    </li>
                                    <li class="pro-wishlist-icon active"><a href="#"><span></span></a>
                                    </li>
                                    <li class="pro-compare-icon"><a href="#"><span></span></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row">
            <div class="col-12">
                <div class="pagination-bar">
                    <ul>
                        <li><a href="#"><i class="fa fa-angle-left"></i></a></li>
                        <li class="active"><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#"><i class="fa fa-angle-right"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
