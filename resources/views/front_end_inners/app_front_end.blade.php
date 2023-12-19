<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="robots" content="@yield('robot')">
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta name=description content="{{ $description ?? 'FamilyDrop shop' }}">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <link rel="icon" href="{{ asset('front_end_style/assets/{{ asset('front_end_style/assets/images/favicon/1.png')}}') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('front_end_style/assets/{{ asset('front_end_style/assets/images/favicon/1.png')}}') }}" type="image/x-icon"> --}}
    <title>FamilyDrop | {{ $title ?? 'Home' }}</title>

    <!-- CSS ================================================== -->
    <link rel="stylesheet" type="text/css" href="{{ asset('front_end_style/assets/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('front_end_style/assets/css/bootstrap.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('front_end_style/assets/css/simplebar.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('front_end_style/assets/css/jquery-ui.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('front_end_style/assets/css/owl.carousel.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('front_end_style/assets/css/alertify.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('front_end_style/assets/css/custom.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('front_end_style/assets/css/responsive.css') }}">
    <link rel="shortcut icon" href="{{ asset('front_end_style/assets/images/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('front_end_style/assets/images/apple-touch-icon.png') }}">
    <link rel="apple-touch-icon" sizes="72x72"
        href="{{ asset('front_end_style/assets/images/apple-touch-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="114x114"
        href="{{ asset('front_end_style/assets/images/apple-touch-icon-114x114.png') }}">

    @if (LaravelLocalization::setLocale() == 'ar')
        <link rel="stylesheet" type="text/css" href="{{ asset('front_end_style/assets/css/bootstrap-rtl.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('front_end_style/assets/css/custom-rtl.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('front_end_style/assets/css/responsive-rtl.css') }}">
    @endif

    <style>
        /* alertify styles */
        .alertify-notifier .ajs-message.ajs-success {
            background: #22af4c;
            color: #fff;
            border-radius: 7px 14px;
            box-shadow: 0 0 10px #053d16a2;
        }

        .alertify-notifier .ajs-message.ajs-error {
            background: #c82333d0;
            color: #fff;
            border-radius: 7px 14px;
            box-shadow: 0 0 10px #c8233373;

        }
    </style>
    @stack('styles')
</head>

<body class="homepage">

    <div class="se-pre-con"></div>
    <!-- newslatter-popup Start -->
    {{-- //TODO - Remove Comment On This Popup --}}
    {{-- <div id="onload-popup" class="modal fade subscribe-popup" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="newsletter-popup">
                        <div class="nl-popup-main">
                            <div class="nl-popup-inner">
                                <div class="newsletter-inner">
                                    <div class="row no-gutters">
                                        <div class="col-md-5 d-none d-md-block">
                                            <div class="newslatter-popup-img h-100">
                                                <img src="{{ asset('front_end_style/assets/images/newspopup.jpg') }}"
                                                    alt="Medizee">
                                            </div>
                                        </div>
                                        <div class="col-md-7 col-12">
                                            <div class="d-flex align-items-center h-100">
                                                <div class="text-center newslatter-popup-detail w-100">
                                                    <h2 class="main_title">Subscribe Emails</h2>
                                                    <div class="newsletter-subtitle">Get Latest News & Update</div>
                                                    <p class="text-muted">Subscribe to the FamilyDrop eCommerce newsletter
                                                        to receive timely updates from your favorite products.</p>
                                                    <form class="main-form">
                                                        <input type="email" placeholder="Email Here...">
                                                        <button class="btn btn-color"
                                                            title="Subscribe">Subscribe</button>
                                                    </form>
                                                    <div class="mt-20 check-box">
                                                        <span>
                                                            <input id="no_show" type="checkbox" name="remember_me"
                                                                class="checkbox">
                                                            <label class="text-muted" for="no_show">Don't show this
                                                                popup again!</label>
                                                        </span>
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
            </div>
        </div>
    </div> --}}
    <div class="main">
        <!-- Popup Links Start -->

        @include('front_end_inners.layout.partials.popup')

        <!-- Popup Links End -->

        <!-- HEADER START -->
        @include('front_end_inners.layout.partials.head')
        <!-- HEADER END -->


        {{-- =================================================================================================================== --}}
        {{-- ============================================== End Mobile Menu Area =============================================== --}}
        {{-- =================================================================================================================== --}}

        {{-- =================================================================================================================== --}}
        {{-- ================================================ Start Content Area =============================================== --}}
        {{-- =================================================================================================================== --}}
        @yield('content')
        {{-- =================================================================================================================== --}}
        {{-- ================================================== End Content Area =============================================== --}}
        {{-- =================================================================================================================== --}}

        <!-- FOOTER START -->
        @include('front_end_inners.layout.partials.footer')
    </div>

    <!-- FOOTER END -->

    @include('front_end_inners.layout.partials.scripts')
    @yield('javascript')
    @stack('scripts')
</body>

</html>
