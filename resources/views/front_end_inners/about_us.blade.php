@extends('front_end_inners.app_front_end', ['title' => 'الصفحة الرئيسية'])

@php
    $image_url = asset('images/AboutUs.png');
@endphp
@push('styles')
    <style>
        .inner-banner1 {
            background: url({{ $image_url }}) no-repeat scroll center center;
            padding: 60px 0;
        }
    </style>
@endpush
@section('content')
    <!-- Bread Crumb STRAT -->
    <div class="banner inner-banner1 ">
        <div class="container">
            <section class="banner-detail center-xs">
                <h1 class="banner-title" style="color: black">About us</h1>
                <div class="bread-crumb right-side float-none-xs">
                    <ul>
                        <li><a href="{{ route('welcome') }}">Home</a>/</li>
                        <li><span>About us</span></li>
                    </ul>
                </div>
            </section>
        </div>
    </div>
    <!-- Bread Crumb END -->

    <!-- CONTAIN START ptb-95-->
    <section class="ptb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="about-detail">
                        <div class="row">
                            <div class="col-12">
                                <div class="heading-part mb-30">
                                    <h2 class="main_title heading"><span>Who We Are</span></h2>
                                </div>
                            </div>
                            <div class="col-sm-5 mb-xs-30">
                                <div class="image-part center-xs"> <img alt="FamilyDrop"
                                        src="{{ asset('front_end_style/assets/images/about-sub.jpg') }}"> </div>
                            </div>
                            <div class="col-sm-7">
                                <div class="heading-part-desc align_left center-md">
                                    <h2 class="heading">Nullam vel sollicitudin diam proin congue lacinia tortor vel
                                        vulputate morbi et mauris nec risus id at odio.</h2>
                                </div>
                                <p>Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos
                                    himenaeos nunc cursus purus sed elit aliquet aliquet luctus pulvivvvvnar tortor, cras
                                    malesuada mi gravida, vehiculaue vitae, congue erat, aenean ullamcorper nibh nec sem
                                    interdum</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="responsive-part">
                        <div class="row">
                            <div class="col-sm-12 partner-detail-main">
                                <div class="heading-part mb-30">
                                    <h2 class="main_title heading"><span>Our Partners</span></h2>
                                </div>
                                <p>Nullam vel sollicitudin diam proin congue lacinia tortor vel vulputate morbi et mauris
                                    nec risus feugiat malesuada id at odio nulla ornare scelerisque est, nec rutrum arcu
                                    elementu.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <hr>
@endsection
