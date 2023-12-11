@extends('front_end_inners.app_front_end', [
    'title' => 'Home Page',
    'description' => 'Explore a world of endless shopping possibilities at FamilyDrop . Discover a vast collection of products across numerous categories, featuring top brands and expertly curated blogs. Elevate your shopping experience today!',
])

@section('content')
    @if ($sliders->count())
        <!-- BANNER STRAT -->
        <section class="">
            <div id="owl-example" class="banner owl-carousel">
                <div class="main-banner">
                    @foreach ($sliders as $slider)
                        <div class="item">
                            <div class="banner-3">
                                <img src="{{ asset("$slider->image") }}" alt="FamilyDrop" class="w-100">
                                <div class="banner-detail">
                                    <div class="container-fluid position-relative">
                                        <div class="row ">
                                            <div class="slider-shadow position-absolute"></div>
                                            <div class="col-12">
                                                <div
                                                    class="py-4 text-center banner-detail-inner slider-animation animated-1 ">
                                                    <h1 class="banner-title animated">
                                                        {{ $slider->title }}
                                                    </h1>
                                                    <p class="offer">
                                                        {!! $slider->description !!}
                                                    </p>
                                                    <a class="btn btn-color" href="{{ route('shop') }}">
                                                        {{ __('front_end.home_shop_now') }}!</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        <!-- BANNER END -->
    @endif

    <!-- CONTAIN START -->

    @if ($recent_products->count())
        <!--  New arrivals Products Slider Block Start  -->
        <section class="pt-70">
            <div class="container">
                <div class="product-listing">
                    <div class="row">
                        <div class="col-12">
                            <div class="heading-part mb-30">
                                <h2 class="main_title heading"><span>
                                    {{ __('front_end.home_New_arrivals') }}</span></h2>
                            </div>
                        </div>
                    </div>
                    <div class="pro_cat">
                        <div class="row">
                            <div class="owl-carousel pro-cat-slider ">
                                @foreach ($recent_products as $product)
                                    <div class="item">
                                        <x-products.product-card :product="$product" status="new" />
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--  New arrivals Products Slider Block End  -->
    @endif

    <!-- Top Categories Start-->
    <section class=" pt-70">
        <div class="top-cate-bg ptb-70">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="heading-part mb-30">
                            <h2 class="main_title heading"><span>
                                {{ __('front_end.home_Top_Categories') }}</span></h2>
                        </div>
                    </div>
                </div>
                <div class="pro_cat">
                    <div class="row">
                        <div id="top-cat-pro" class="owl-carousel sell-pro align-center">
                            @php
                                $img = asset('front_end_style/assets/images/cate_1.jpg');
                            @endphp
                            @foreach ($categories as $category)
                                <div class="item ">
                                    <a href="{{ route('shop') }}">
                                        <div class="item-inner">
                                            <img src="{{ asset($category->image ?? $img) }}" alt="FamilyDrop"
                                                style="height: 220px ; object-fit: cover">
                                            <div class="effect"></div>
                                            <div class="cate-detail">
                                                <span>{{ $category->name }}</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Top Categories End-->



    <!--  Site Services Features Block Start  -->
    {{-- <div class="ser-feature-block">
        <div class="container">
            <div class="center-xs">
                <div class="row">
                    <div class="col-xl-3 col-6 service-box">
                        <div class="feature-box ">
                            <div class="feature-icon feature1"></div>
                            <div class="feature-detail">
                                <div class="ser-title">Free Delivery</div>
                                <div class="ser-subtitle">From $59.89</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-6 service-box">
                        <div class="feature-box">
                            <div class="feature-icon feature2"></div>
                            <div class="feature-detail">
                                <div class="ser-title">Support 24/7</div>
                                <div class="ser-subtitle">Online 24 hours</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-6 service-box">
                        <div class="feature-box ">
                            <div class="feature-icon feature3"></div>
                            <div class="feature-detail">
                                <div class="ser-title">Free return</div>
                                <div class="ser-subtitle">365 a day</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-6 service-box">
                        <div class="feature-box ">
                            <div class="feature-icon feature4"></div>
                            <div class="feature-detail">
                                <div class="ser-title">Big Saving</div>
                                <div class="ser-subtitle">Weeken Sales</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <!--  Site Services Features Block End  -->


    @if ($recent_products->count() || $best_selling->count())
        <!--  Special products Products Slider Block Start  -->
        <section class="ptb-70">
            <div class="container">
                <div class="product-listing">
                    <div class="row">
                        @if ($best_selling->count())
                            <div @class(['col-12 mt-xs-30', 'col-md-6' => $recent_products->count()]) class="col-md-6 col-12">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="heading-part mb-30">
                                            <h2 class="main_title heading"><span>{{ __('front_end.home_Best_seller') }}</span></h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="pro_cat">
                                    <div class="row">
                                        <div @class([
                                            'owl-carousel',
                                            'pro-cat-slider' => $recent_products->count() == 0,
                                            'best-seller-pro' => $recent_products->count() != 0,
                                        ])>
                                            @foreach ($best_selling as $product)
                                                <div class="item">
                                                    <x-products.product-card :product="$product" status="sale" />
                                                </div>
                                            @endforeach

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if ($recent_products->count())
                            <div @class(['col-12 mt-xs-30', 'col-md-6' => $best_selling->count()])>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="heading-part mb-30">
                                            <h2 class="main_title heading"><span>{{ __('front_end.home_New_products') }} </span></h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="pro_cat">
                                    <div class="row">
                                        <div @class([
                                            'owl-carousel',
                                            'pro-cat-slider' => $best_selling->count() == 0,
                                            'best-seller-pro' => $best_selling->count() != 0,
                                        ])>
                                            @foreach ($recent_products as $product)
                                                <div class="item">
                                                    <x-products.product-card :product="$product" status="new" />
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
        <!--  Special products Products Slider Block End  -->
    @endif

    @if ($blogs->count())
        <!--Blog Block Start -->
        <section class="pb-70">
            <div class="container">
                <div class="row">
                    <div class="col-12 ">
                        <div class="heading-part mb-30">
                            <h2 class="main_title heading"><span>{{ __('front_end.home_Latest_News') }}</span></h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div id="blog" class="owl-carousel">
                        @foreach ($blogs as $blog)
                            <div class="item mb-md-30">
                                <div class="blog-item">
                                    <div class="">
                                        <div class="blog-media d-flex justify-content-center">
                                            <img src="{{ asset($blog->image) }}" alt="FamilyDrop"
                                                style="height: 250px; object-fit: cover">
                                            <div class="blog-effect"></div>
                                            <a href="{{ route('BlogDetails', $blog->slug) }}" title="Click For Read More"
                                                class="read">&nbsp;</a>
                                        </div>
                                    </div>
                                    <div class="mt-20">
                                        <div class="blog-detail">
                                            <div class="post-date">
                                                <span>{{ $blog->day }}</span> /
                                                {{ $blog->month_and_year }}
                                            </div>
                                            <div class="blog-title">
                                                <a href="{{ route('BlogDetails', $blog->slug) }}">
                                                    {{ $blog->title }}
                                                </a>
                                            </div>
                                            {{-- <p>
                                                {!! $blog->description !!}
                                            </p> --}}
                                            <hr>
                                            <div class="mt-2 post-info">
                                                <ul>
                                                    <li>
                                                        <strong>By</strong>
                                                        <a href="#">
                                                            {{ $blog->user->name_en }}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('BlogDetails', $blog->slug) }}">
                                                            Read more
                                                            <i class="fa fa-angle-double-right"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
        <!--Blog Block End -->
    @endif

    @if ($brands->count())
        <!-- Brand logo block Start  -->
        <div class="brand-logo pb-70">
            <div class="container">
                <div class="row">
                    <div class="col-12 ">
                        <div class="heading-part mb-30">
                            <h2 class="main_title heading"><span>{{ __('front_end.home_Our_Brands') }}</span></h2>
                        </div>
                    </div>
                </div>
                <div class=" brand">
                    <div class="row">
                        <div id="brand-logo" class="owl-carousel align_center">
                            @foreach ($brands as $brand)
                                <div class="item">
                                    <a href="#">
                                        <img src="{{ asset("$brand->image") }}" alt="{{ $brand->name }}">
                                    </a>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Brand logo block End  -->
    @endif
    <!-- CONTAINER END -->

    <hr>
@endsection
