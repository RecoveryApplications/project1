@extends('front_end_inners.app_front_end')

@push('styles')
    <link rel="stylesheet" href="{{ asset('front_end_style/assets/css/splide-default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('front_end_style/assets/css/fotorama.css') }}">

    <style>
        .splide__slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .splide__slide {
            opacity: 0.6;
        }

        .splide__slide.is-active {
            opacity: 1;
            border-radius: 5px;
            border: .5px solid #ccc;
        }
    </style>
@endpush

@section('content')

    <!-- CONTAIN START -->
    <section class="pt-70">
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-lg-5 col-md-5 mb-xs-30">
                            @if ($product->productImages->count())
                                <section class="splide" aria-labelledby="carousel-heading">
                                    <div class="splide__track">
                                        <ul class="splide__list">
                                            @foreach ($product->productImages as $image)
                                                <li class="splide__slide">
                                                    <img src="{{ asset($image->image) }}" alt="FamilyDrop">
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </section>
                                <section id="thumbnail-carousel" class="splide"
                                    aria-label="The carousel with thumbnails. Selecting a thumbnail will change the Beautiful Gallery carousel.">
                                    <div class="splide__track">
                                        <ul class="splide__list">
                                            @foreach ($product->productImages as $image)
                                                <li class="splide__slide">
                                                    <img src="{{ asset($image->image) }}" alt="{{ $product->name }}">
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </section>
                            @else
                                <section class="splide">
                                    <div class="splide__track">
                                        <ul class="splide__list">
                                            <li class="splide__slide">
                                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
                                            </li>
                                        </ul>
                                    </div>
                                </section>
                            @endif
                        </div>
                        <div class="col-lg-7 col-md-7">
                            <div class="row">
                                <div class="col-12">
                                    <div class="product-detail-main">
                                        <div class="product-item-details">
                                            <h1 class="product-item-name">
                                                {{ $product->name }}
                                            </h1>
                                            <div class="rating-summary-block">
                                                <div title="53%" class="rating-result"> <span style="width:53%"></span>
                                                </div>
                                            </div>
                                            <div class="price-box">
                                                @if ($product && $product->on_sale_price_status == 'Active')
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
                                            {{-- <div class="product-info-stock-sku">
                                                <div>
                                                    <label>Availability: </label>
                                                    <span class="info-deta">In stock</span>
                                                </div>
                                                <div>
                                                    <label>SKU: </label>
                                                    <span class="info-deta">20MVC-18</span>
                                                </div>
                                            </div> --}}

                                            {{-- <div class="mb-20 product-size select-arrow input-box select-dropdown mt-30">
                                                <label>Size</label>
                                                <fieldset>
                                                    <select class="selectpicker form-control option-drop"
                                                        id="select-by-size">
                                                        <option selected="selected" value="#">S</option>
                                                        <option value="#">M</option>
                                                        <option value="#">L</option>
                                                    </select>
                                                </fieldset>
                                            </div>
                                            <div class="mb-20 product-color select-arrow input-box select-dropdown">
                                                <label>Color</label>
                                                <fieldset>
                                                    <select class="selectpicker form-control option-drop"
                                                        id="select-by-color">
                                                        <option selected="selected" value="#">Blue</option>
                                                        <option value="#">Green</option>
                                                        <option value="#">Orange</option>
                                                        <option value="#">White</option>
                                                    </select>
                                                </fieldset>
                                            </div> --}}
                                            <div class="mb-20">
                                                <form action="{{ route('customer.add-to-cart') }}" method="post">
                                                    @csrf
                                                    <div class="product-qty">
                                                        <label for="qty">Qty:</label>
                                                        <div class="custom-qty">
                                                            <button
                                                                onclick="var result = document.getElementById('qty'); var qty = result.value; if( !isNaN( qty ) &amp;&amp; qty &gt; 1 ) result.value--;return false;"
                                                                class="reduced items" type="button"> <i
                                                                    class="fa fa-minus"></i> </button>
                                                            <input type="text" class="input-text qty" title="Qty"
                                                                value="1" maxlength="8" id="qty"
                                                                name="quantity">
                                                            <button
                                                                onclick="var result = document.getElementById('qty'); var qty = result.value; if( !isNaN( qty )) result.value++;return false;"
                                                                class="increase items" type="button"> <i
                                                                    class="fa fa-plus"></i> </button>
                                                        </div>
                                                    </div>
                                                    <div class="bottom-detail cart-button">
                                                        <ul>
                                                            <li class="pro-cart-icon">
                                                                <button title="Add to Cart"
                                                                    class="btn-color"><span></span>Add to Cart</button>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                </form>
                                            </div>
                                            <div class="bottom-detail">
                                                <ul>
                                                    <li class="pro-wishlist-icon active">
                                                        <a href="{{ route('customer.wishlist', $product->id) }}">
                                                            <span></span> Wishlist
                                                        </a>
                                                    </li>
                                                    {{-- <li class="pro-email-icon"><a href="#"><span></span>Email to
                                                            Friends</a></li> --}}
                                                </ul>
                                            </div>
                                            {{-- <div class="share-link">
                                                <label>Share This : </label>
                                                <div class="social-link">
                                                    <ul class="social-icon">
                                                        <li><a class="facebook" title="Facebook" href="#"><i
                                                                    class="fa fa-facebook"> </i></a></li>
                                                        <li><a class="twitter" title="Twitter" href="#"><i
                                                                    class="fa fa-twitter"> </i></a></li>
                                                        <li><a class="linkedin" title="Linkedin" href="#"><i
                                                                    class="fa fa-linkedin"> </i></a></li>
                                                        <li><a class="rss" title="RSS" href="#"><i
                                                                    class="fa fa-rss"> </i></a></li>
                                                        <li><a class="pinterest" title="Pinterest" href="#"><i
                                                                    class="fa fa-pinterest"> </i></a></li>
                                                    </ul>
                                                </div>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    @if ($product->brand)
                        <div class="brand-logo-pro align-center mb-30">
                            <img src="{{ asset($product->brand->image) }}" alt="FamilyDrop">
                        </div>
                    @endif
                    <div class="sub-banner-block align-center">
                        <img src="{{ asset($product->image) }}" alt="FamilyDrop">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="ptb-70">
        <div class="container">
            <div class="product-detail-tab">
                <div class="row">
                    <div class="col-lg-12">
                        <div id="tabs">
                            <ul class="nav nav-tabs">
                                @if ($product->description)
                                    <li><a class="tab-Description selected" title="Description">Description</a></li>
                                @endif
                                <li><a @class(['tab-Reviews', 'selected' => !$product->description]) title="Reviews">Reviews</a></li>
                            </ul>
                        </div>
                        <div id="items">
                            <div class="tab_content">
                                <ul>
                                    <li>
                                        <div class="items-Description selected ">
                                            <div class="Description">
                                                {!! $product->description !!}
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div @class(['items-Reviews', 'selected' => !$product->description])>
                                            <div class="main-form mt-30">
                                                <h4>Leave a review</h4>
                                                <form>
                                                    <div class="row mt-30">
                                                        <div class="col-md-4 mb-30">
                                                            <input type="text" placeholder="Name" required>
                                                        </div>
                                                        <div class="col-md-4 mb-30">
                                                            <input type="email" placeholder="Email" required>
                                                        </div>
                                                        <div class="col-md-4 mb-30">
                                                            <input type="text" placeholder="Website" required>
                                                        </div>
                                                        <div class="col-12 mb-30">
                                                            <textarea cols="30" rows="3" placeholder="Message" required></textarea>
                                                        </div>
                                                        <div class="col-12 mb-30">
                                                            <button class="btn btn-color" name="submit"
                                                                type="submit">Submit</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if ($relatedProducts->count())
        <section class="pb-70">
            <div class="container">
                <div class="product-listing">
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-40 heading-part">
                                <h2 class="main_title heading"><span>Related Products</span></h2>
                            </div>
                        </div>
                    </div>
                    <div class="pro_cat">
                        <div class="row">
                            <div class="owl-carousel pro-cat-slider">
                                @foreach ($relatedProducts as $item)
                                    <div class="item">
                                        <x-products.product-card :product="$item" status="new" />
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- CONTAINER END -->
    @endif

    <!-- News Letter Start -->
    <section>
        <div class="newsletter">
            <div class="container">
                <div class="newsletter-inner center-sm">
                    <div class="row justify-content-center align-items-center">
                        <div class=" col-xl-10 col-md-12">
                            <div class="newsletter-bg">
                                <div class="row align-items-center">
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="d-lg-flex align-items-center">
                                            <div class="newsletter-icon">
                                                <img alt="FamilyDrop"
                                                    src="{{ asset('front_end_style/assets/images/newsletter-icon.png') }}">
                                            </div>
                                            <div class="newsletter-title">
                                                <h2 class="main_title">Subscribe to our newsletter</h2>
                                                <div class="sub-title">Sign up for newsletter and Get upto 50% off</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6">
                                        <form>
                                            <div class="newsletter-box">
                                                <input type="email" placeholder="Email Here...">
                                                <button title="Subscribe" class="btn-color">Subscribe</button>
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
    </section>
    <!-- News Letter End -->

    {{-- JavaScript Section --}}
@section('javascript')
@endsection
{{-- JavaScript Section --}}
@endsection

@push('scripts')
<script src="{{ asset('front_end_style/assets/js/fotorama.js') }}"></script>
<script src="{{ asset('front_end_style/assets/js/splide.min.js') }}"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var main = new Splide('.splide', {
            pagination: false,
            type: 'fade',
        }).mount();
        var thumbnails = new Splide('#thumbnail-carousel', {
            fixedWidth: 80,
            fixedHeight: 60,
            gap: 4,
            rewind: true,
            pagination: false,
            focus: 'center',
            isNavigation: true,
            arrows: false,
            breakpoints: {
                600: {
                    fixedWidth: 60,
                    fixedHeight: 44,
                },
            },
        }).mount();

        main.sync(thumbnails);
        main.mount();
        thumbnails.mount();
    });
</script>
@endpush
