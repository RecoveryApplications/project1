@extends('front_end_inners.app_front_end')

@section('content')
    <!-- CONTAIN START -->
    <section class="checkout-section ptb-70">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
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
                            <div class="col-12">
                                <hr>
                                <div class="mt-20 new-account align-center">
                                    <span>Don't have an account ?</span>
                                    <a class="link" title="Register with FamilyDrop"
                                        href="{{ route('customer.loginRegister', 'register') }}">Register Here</a>
                                </div>
                            </div>
                            {{-- <div class="col-12"> 
                                <a title="Forgot Password" class="forgot-password mtb-20"
                                    href="#">Forgot your password?</a>
                                <hr>
                            </div> --}}
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

    <hr>
@section('javascript')
@endsection
@endsection
