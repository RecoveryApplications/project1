@extends('front_end_inners.app_front_end', ['title' => 'الصفحة الرئيسية'])

@php
    $image_url = asset('images/contactUs.png');
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
                <h1 class="banner-title">Contact</h1>
                <div class="bread-crumb right-side float-none-xs">
                    <ul>
                        <li><a href="index.html">Home</a>/</li>
                        <li><span>Contact</span></li>
                    </ul>
                </div>
            </section>
        </div>
    </div>
    <!-- Bread Crumb END -->

    <!-- CONTAIN START ptb-95-->
    <section class="pt-70 client-main align-center">
        <div class="container">
            <div class="contact-info">
                <div class="m-0 row">
                    <div class="p-0 col-md-6">
                        <div class="contact-box">
                            <div class="contact-icon contact-phone-icon"></div>
                            <span><b>Tel</b></span>
                            <p>{{ $public_contact_us['phone'] }}</p>
                        </div>
                    </div>
                    <div class="p-0 col-md-6">
                        <div class="contact-box">
                            <div class="contact-icon contact-mail-icon"></div>
                            <span><b>Mail</b></span>
                            <p>{{ $public_contact_us['email'] }} </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="ptb-70">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="heading-part mb-30">
                        <h2 class="main_title heading"><span>Leave a message!</span></h2>
                    </div>
                </div>
            </div>
            <div class="main-form">
                <form action="{{ route('contactUsRequest') }}" method="POST" name="contactform">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-30">
                            <input type="text" required placeholder="Name" name="full_name">
                        </div>
                        <div class="col-md-6 mb-30">
                            <input type="email" required placeholder="Email" name="email">
                        </div>
                        <div class="col-md-6 mb-30">
                            <input type="text" required placeholder="Phone" name="phone">
                        </div>
                        <div class="col-md-6 mb-30">
                            <input type="text" required placeholder="Subject" name="subject">
                        </div>
                        <div class="col-12 mb-30">
                            <textarea required placeholder="Message" rows="3" cols="30" name="message"></textarea>
                        </div>
                        <div class="col-12">
                            <div class="align-center">
                                <button type="submit" name="submit" class="btn btn-color">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- CONTAINER END -->

    <hr>

@section('javascript')
@endsection
@endsection
