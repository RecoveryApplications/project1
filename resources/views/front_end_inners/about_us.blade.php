@extends('front_end_inners.app_front_end', ['title' => 'الصفحة الرئيسية'])

@section('content')

    <!-- Bread Crumb STRAT -->
    <div class="banner inner-banner1 ">
        <div class="container">
            <section class="banner-detail center-xs">
                <h1 class="banner-title">About us</h1>
                <div class="bread-crumb right-side float-none-xs">
                    <ul>
                        <li><a href="index.html">Home</a>/</li>
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
                    <div class="row">
                        <div class="col-12">
                            <h3>What's the secret of the FamilyDrop ?</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. etiam nec suscipit arcu, feugiat
                                fermentum ex cras nec scelerisque magna, eu dignissim ante. mauris ullamcorper neque sed
                                dapibus scelerisque, vestibulum et auctor odio. Fusce dapibus tortor vel quam venenatis
                                rutrum fusce sagittis mauris nisi, eu vulputate nisl lacinia at. Suspendisse potenti, nulla
                                nisi mi, hendrerit vitae faucibus id, ultricies sit amet nisi.</p>
                        </div>
                    </div>
                    <div class="mt-40 about-detail">
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
                            <div class="col-sm-12">
                                <div class="partner-block mb-sm-30 light-gray-bg">
                                    <ul>
                                        <li><span><img src="{{ asset('front_end_style/assets/images/brand1.png') }}"
                                                    alt="FamilyDrop"></span></li>
                                        <li><span><img src="{{ asset('front_end_style/assets/images/brand2.png') }}"
                                                    alt="FamilyDrop"></span></li>
                                        <li><span><img src="{{ asset('front_end_style/assets/images/brand3.png') }}"
                                                    alt="FamilyDrop"></span></li>
                                        <li><span><img src="{{ asset('front_end_style/assets/images/brand4.png') }}"
                                                    alt="FamilyDrop"></span></li>
                                        <li class="owner-logo ">
                                            <span><img src="{{ asset('front_end_style/assets/images/owner-logo.png') }}"
                                                    alt="FamilyDrop"></span>
                                        </li>
                                        <li><span><img src="{{ asset('front_end_style/assets/images/brand5.png') }}"
                                                    alt="FamilyDrop"></span></li>
                                        <li><span><img src="{{ asset('front_end_style/assets/images/brand6.png') }}"
                                                    alt="FamilyDrop"></span></li>
                                        <li><span><img src="{{ asset('front_end_style/assets/images/brand7.png') }}"
                                                    alt="FamilyDrop"></span></li>
                                        <li><span><img src="{{ asset('front_end_style/assets/images/brand8.png') }}"
                                                    alt="FamilyDrop"></span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--Testimonial Block Start -->
    <section class="client-bg ptb-70">
        <div class="top-shadow">
            <img alt="FamilyDrop" src="{{ asset('front_end_style/assets/images/top-shadow.png') }}">
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="client-main client-bg">
                        <div class="client-inner align-center">
                            <div id="client" class="owl-carousel">
                                <div class="item client-detail">
                                    <div class="mt-40 client-img left-side">
                                        <img alt="FamilyDrop"
                                            src="{{ asset('front_end_style/assets/images/testimonial_img1.jpg') }}">
                                        <h4 class="sub-title client-title">- Joseph deboungawer - </h4>
                                        <div class="designation">Maneger of Business Development, 2base</div>
                                    </div>
                                    <div class="quote right-side">
                                        <div class="quote1-img">
                                            <img src="{{ asset('front_end_style/assets/images/quote1.png') }}"
                                                alt="FamilyDrop">
                                        </div>
                                        <p>It is a long established fact that a reader will be distracted by the readable
                                            content of a page when looking at its layout. The point of using Lorem Ipsum is
                                            that it has a more-or-less normal distribution of letters
                                        </p>
                                        <div class="quote2-img">
                                            <img src="{{ asset('front_end_style/assets/images/quote2.png') }}"
                                                alt="FamilyDrop">
                                        </div>
                                    </div>
                                </div>
                                <div class="item client-detail">
                                    <div class="mt-40 client-img left-side">
                                        <img alt="FamilyDrop"
                                            src="{{ asset('front_end_style/assets/images/testimonial_img2.jpg') }}">
                                        <h4 class="sub-title client-title">- Joseph deboungawer - </h4>
                                        <div class="designation">Maneger of Business Development, 2base</div>
                                    </div>
                                    <div class="quote-border right-side">
                                        <div class="quote">
                                            <div class="quote1-img">
                                                <img src="{{ asset('front_end_style/assets/images/quote1.png') }}"
                                                    alt="FamilyDrop">
                                            </div>
                                            <p>It is a long established fact that a reader will be distracted by the
                                                readable content of a page when looking at its layout. The point of using
                                                Lorem Ipsum is that it has a more-or-less normal distribution of letters
                                            </p>
                                            <div class="quote2-img">
                                                <img src="{{ asset('front_end_style/assets/images/quote2.png') }}"
                                                    alt="FamilyDrop">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item client-detail">
                                    <div class="mt-40 client-img left-side">
                                        <img alt="FamilyDrop"
                                            src="{{ asset('front_end_style/assets/images/testimonial_img3.jpg') }}">
                                        <h4 class="sub-title client-title">- Joseph deboungawer - </h4>
                                        <div class="designation">Maneger of Business Development, 2base</div>
                                    </div>
                                    <div class="quote right-side">
                                        <div class="quote1-img">
                                            <img src="{{ asset('front_end_style/assets/images/quote1.png') }}"
                                                alt="FamilyDrop">
                                        </div>
                                        <p>It is a long established fact that a reader will be distracted by the readable
                                            content of a page when looking at its layout. The point of using Lorem Ipsum is
                                            that it has a more-or-less normal distribution of letters
                                        </p>
                                        <div class="quote2-img">
                                            <img src="{{ asset('front_end_style/assets/images/quote2.png') }}"
                                                alt="FamilyDrop">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bottom-shadow">
            <img alt="FamilyDrop" src="{{ asset('front_end_style/assets/images/bottom-shadow.png') }}">
        </div>
    </section>
    <!--Testimonial Block End -->

    <!--team-part Start -->
    <section class="ptb-70">
        <div class="container">
            <div class="team-part team-opt-1">
                <div class="row">
                    <div class="col-12 ">
                        <div class="heading-part mb-30">
                            <h2 class="main_title heading"><span>Our Team</span></h2>
                        </div>
                    </div>
                </div>
                <div class="pro_cat">
                    <div class="row">
                        <div class="owl-carousel our-team ">
                            <div class="item">
                                <div class="team-item listing-effect col-sm-margin-b"> <img alt="FamilyDrop"
                                        src="{{ asset('front_end_style/assets/images/tm1.jpg') }}">
                                    <div class="team-item-detail">
                                        <h3 class="sub-title listing-effect-title">Adamaris Corliss</h3>
                                        <div class="listing-meta">Co-Founder</div>
                                        <div class="social_icon">
                                            <ul>
                                                <li><a href="javascript:void(0)" title="Facebook" class="facebook"><i
                                                            class="fa fa-facebook"> </i></a></li>
                                                <li><a href="javascript:void(0)" title="Twitter" class="twitter"><i
                                                            class="fa fa-twitter"> </i></a></li>
                                                <li><a href="javascript:void(0)" title="Pinterest" class="pinterest"><i
                                                            class="fa fa-dribbble"></i></a></li>
                                                <li><a href="javascript:void(0)" title="Pinterest" class="pinterest"><i
                                                            class="fa fa-pinterest"> </i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="team-item listing-effect col-sm-margin-b"> <img alt="FamilyDrop"
                                        src="{{ asset('front_end_style/assets/images/tm2.jpg') }}">
                                    <div class="team-item-detail">
                                        <h3 class="sub-title listing-effect-title">Lusi Rose</h3>
                                        <div class="listing-meta">Project Manager</div>
                                        <div class="social_icon">
                                            <ul>
                                                <li><a href="javascript:void(0)" title="Facebook" class="facebook"><i
                                                            class="fa fa-facebook"> </i></a></li>
                                                <li><a href="javascript:void(0)" title="Twitter" class="twitter"><i
                                                            class="fa fa-twitter"> </i></a></li>
                                                <li><a href="javascript:void(0)" title="Pinterest" class="pinterest"><i
                                                            class="fa fa-dribbble"></i></a></li>
                                                <li><a href="javascript:void(0)" title="Pinterest" class="pinterest"><i
                                                            class="fa fa-pinterest"> </i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="team-item listing-effect col-sm-margin-b"> <img alt="FamilyDrop"
                                        src="{{ asset('front_end_style/assets/images/tm3.jpg') }}">
                                    <div class="team-item-detail">
                                        <h3 class="sub-title listing-effect-title">Adamaris Corliss</h3>
                                        <div class="listing-meta">Co-Founder</div>
                                        <div class="social_icon">
                                            <ul>
                                                <li><a href="javascript:void(0)" title="Facebook" class="facebook"><i
                                                            class="fa fa-facebook"> </i></a></li>
                                                <li><a href="javascript:void(0)" title="Twitter" class="twitter"><i
                                                            class="fa fa-twitter"> </i></a></li>
                                                <li><a href="javascript:void(0)" title="Pinterest" class="pinterest"><i
                                                            class="fa fa-dribbble"></i></a></li>
                                                <li><a href="javascript:void(0)" title="Pinterest" class="pinterest"><i
                                                            class="fa fa-pinterest"> </i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="team-item listing-effect col-sm-margin-b"> <img alt="FamilyDrop"
                                        src="{{ asset('front_end_style/assets/images/tm4.jpg') }}">
                                    <div class="team-item-detail">
                                        <h3 class="sub-title listing-effect-title">Adamaris Corliss</h3>
                                        <div class="listing-meta">Co-Founder</div>
                                        <div class="social_icon">
                                            <ul>
                                                <li><a href="javascript:void(0)" title="Facebook" class="facebook"><i
                                                            class="fa fa-facebook"> </i></a></li>
                                                <li><a href="javascript:void(0)" title="Twitter" class="twitter"><i
                                                            class="fa fa-twitter"> </i></a></li>
                                                <li><a href="javascript:void(0)" title="Pinterest" class="pinterest"><i
                                                            class="fa fa-dribbble"></i></a></li>
                                                <li><a href="javascript:void(0)" title="Pinterest" class="pinterest"><i
                                                            class="fa fa-pinterest"> </i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="team-item listing-effect col-sm-margin-b"> <img alt="FamilyDrop"
                                        src="{{ asset('front_end_style/assets/images/tm5.jpg') }}">
                                    <div class="team-item-detail">
                                        <h3 class="sub-title listing-effect-title">Adamaris Corliss</h3>
                                        <div class="listing-meta">Co-Founder</div>
                                        <div class="social_icon">
                                            <ul>
                                                <li><a href="javascript:void(0)" title="Facebook" class="facebook"><i
                                                            class="fa fa-facebook"> </i></a></li>
                                                <li><a href="javascript:void(0)" title="Twitter" class="twitter"><i
                                                            class="fa fa-twitter"> </i></a></li>
                                                <li><a href="javascript:void(0)" title="Pinterest" class="pinterest"><i
                                                            class="fa fa-dribbble"></i></a></li>
                                                <li><a href="javascript:void(0)" title="Pinterest" class="pinterest"><i
                                                            class="fa fa-pinterest"> </i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="team-item listing-effect col-sm-margin-b"> <img alt="FamilyDrop"
                                        src="{{ asset('front_end_style/assets/images/tm6.jpg') }}">
                                    <div class="team-item-detail">
                                        <h3 class="sub-title listing-effect-title">Lusi Rose</h3>
                                        <div class="listing-meta">Project Manager</div>
                                        <div class="social_icon">
                                            <ul>
                                                <li><a href="javascript:void(0)" title="Facebook" class="facebook"><i
                                                            class="fa fa-facebook"> </i></a></li>
                                                <li><a href="javascript:void(0)" title="Twitter" class="twitter"><i
                                                            class="fa fa-twitter"> </i></a></li>
                                                <li><a href="javascript:void(0)" title="Pinterest" class="pinterest"><i
                                                            class="fa fa-dribbble"></i></a></li>
                                                <li><a href="javascript:void(0)" title="Pinterest" class="pinterest"><i
                                                            class="fa fa-pinterest"> </i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="team-item listing-effect col-sm-margin-b"> <img alt="FamilyDrop"
                                        src="{{ asset('front_end_style/assets/images/tm7.jpg') }}">
                                    <div class="team-item-detail">
                                        <h3 class="sub-title listing-effect-title">Adamaris Corliss</h3>
                                        <div class="listing-meta">Co-Founder</div>
                                        <div class="social_icon">
                                            <ul>
                                                <li><a href="javascript:void(0)" title="Facebook" class="facebook"><i
                                                            class="fa fa-facebook"> </i></a></li>
                                                <li><a href="javascript:void(0)" title="Twitter" class="twitter"><i
                                                            class="fa fa-twitter"> </i></a></li>
                                                <li><a href="javascript:void(0)" title="Pinterest" class="pinterest"><i
                                                            class="fa fa-dribbble"></i></a></li>
                                                <li><a href="javascript:void(0)" title="Pinterest" class="pinterest"><i
                                                            class="fa fa-pinterest"> </i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--team-part End -->
    <!-- CONTAINER END -->

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
@section('javascript')
@endsection


@endsection
