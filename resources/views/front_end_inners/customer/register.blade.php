@extends('front_end_inners.app_front_end', ['title' => 'الصفحة الرئيسية'])

@section('content')
 <!-- Bread Crumb STRAT -->
 <div class="banner inner-banner1 ">
    <div class="container">
      <section class="banner-detail center-xs">
        <h1 class="banner-title">Register</h1>
        <div class="bread-crumb right-side float-none-xs">
          <ul>
            <li><a href="index.html">Home</a>/</li>
            <li><span>Register</span></li>
          </ul>
        </div>
      </section>
    </div>
  </div>
  <!-- Bread Crumb END -->

  <!-- CONTAIN START -->
  <section class="checkout-section ptb-70">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-8 col-md-8 ">
              <form class="main-form full">
                <div class="row">
                  <div class="col-12 mb-20">
                    <div class="heading-part heading-bg">
                      <h2 class="heading">Create your account</h2>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="input-box">
                      <label for="f-name">First Name</label>
                      <input type="text" id="f-name" required placeholder="First Name">
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="input-box">
                      <label for="l-name">Last Name</label>
                      <input type="text" id="l-name" required placeholder="Last Name">
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="input-box">
                      <label for="login-email">Email address</label>
                      <input id="login-email" type="email" required placeholder="Email Address">
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="input-box">
                      <label for="login-pass">Password</label>
                      <input id="login-pass" type="password" required placeholder="Enter your Password">
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="input-box">
                      <label for="re-enter-pass">Re-enter Password</label>
                      <input id="re-enter-pass" type="password" required placeholder="Re-enter your Password">
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="check-box left-side mb-20">
                      <span>
                        <input type="checkbox" name="remember_me" id="remember_me" class="checkbox">
                        <label for="remember_me">Remember Me</label>
                      </span>
                    </div>
                    <button name="submit" type="submit" class="btn-color right-side">Submit</button>
                  </div>
                  <div class="col-12">
                    <hr>
                    <div class="new-account align-center mt-20"> <span>Already have an account with us</span> <a class="link" title="Register with Stylexpo" href="login.html">Login Here</a> </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
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
                <div class="row  align-items-center">
                  <div class="col-xl-6 col-lg-6">
                    <div class="d-lg-flex align-items-center">
                      <div class="newsletter-icon">
                        <img alt="Stylexpo" src="{{ asset('front_end_style/assets/images/newsletter-icon.png')}}">
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
   @endsection
