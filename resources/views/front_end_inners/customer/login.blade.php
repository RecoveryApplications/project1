@extends('front_end_inners.app_front_end')

@section('content')
    <!-- Bread Crumb STRAT -->
    <div class="banner inner-banner1 ">
        <div class="container">
            <section class="banner-detail center-xs">
                <h1 class="banner-title">Login</h1>
                <div class="bread-crumb right-side float-none-xs">
                    <ul>
                        <li><a href="index.html">Home</a>/</li>
                        <li><span>Login</span></li>
                    </ul>
                </div>
            </section>
        </div>
    </div>
    <!-- Bread Crumb END -->

    <!-- CONTAIN START -->
    <section class="checkout-section ptb-70">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form class="main-form full" action="{{ route('customer.login') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="mb-20 col-12">
                                <div class="heading-part heading-bg">
                                    <h2 class="heading">Customer Login</h2>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-box">
                                    <label for="login-email">Email address</label>
                                    <input id="login-email" name="email_login" type="email" required
                                        placeholder="Email Address">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-box">
                                    <label for="login-pass">Password</label>
                                    <input id="login-pass" name="password_login" type="password" required
                                        placeholder="Enter your Password">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="check-box left-side">
                                    <span>
                                        <input type="checkbox" name="remember_me" id="remember_me" class="checkbox">
                                        <label for="remember_me">Remember Me</label>
                                    </span>
                                </div>
                                <button name="submit" type="submit" class="btn-color right-side">Log In</button>
                            </div>
                            <div class="col-12"> <a title="Forgot Password" class="forgot-password mtb-20"
                                    href="#">Forgot your password?</a>
                                <hr>
                            </div>
                            <div class="col-12">
                                {{-- <div class="mt-20 new-account align-center"> <span>New to FamilyDrop?</span> <a class="link" title="Register with FamilyDrop" href="register.html">Create New Account</a> </div> --}}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
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
