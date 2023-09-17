@extends('front_end_inners.app_front_end', ['title' => 'الصفحة الرئيسية'])

@section('content')


  <!-- Bread Crumb STRAT -->
  <div class="banner inner-banner1 ">
    <div class="container">
      <section class="banner-detail  center-xs">
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
  <section class="pt-70">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="map">
            <div class="map-part">
              <div id="map" class="map-inner-part"></div>
            </div>
            <iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d2965.0824050173574!2d-93.63905729999999!3d41.998507000000004!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sWebFilings%2C+University+Boulevard%2C+Ames%2C+IA!5e0!3m2!1sen!2sus!4v1390839289319" style="border:0"></iframe>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="pt-70 client-main align-center">
    <div class="container">
      <div class="contact-info">
        <div class="row m-0">
          <div class="col-md-4 p-0">
            <div class="contact-box">
              <div class="contact-icon contact-phone-icon"></div>
              <span><b>Tel</b></span>
              <p>0123 456 789 / 0123 456 788</p>
            </div>
          </div>
          <div class="col-md-4 p-0">
            <div class="contact-box">
              <div class="contact-icon contact-mail-icon"></div>
              <span><b>Mail</b></span>
              <p>infoservices@stylexpo.com </p>
            </div>
          </div>
          <div class="col-md-4 p-0">
            <div class="contact-box">
              <div class="contact-icon contact-open-icon"></div>
              <span><b>Open</b></span>
              <p>Mon – Sat: 9:00 – 18:00</p>
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
            <h2 class="main_title  heading"><span>Leave a message!</span></h2>
          </div>
        </div>
      </div>
      <div class="main-form">
        <form action="contact-form-handler.php" method="POST" name="contactform">
          <div class="row">
            <div class="col-md-4 mb-30">
              <input type="text" required placeholder="Name" name="name">
            </div>
            <div class="col-md-4 mb-30">
              <input type="email" required placeholder="Email" name="email">
            </div>
            <div class="col-md-4 mb-30">
              <input type="text" required placeholder="Website" name="website">
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
                        <img alt="Stylexpo" src="images/newsletter-icon.png">
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
