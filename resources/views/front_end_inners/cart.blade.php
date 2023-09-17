@extends('front_end_inners.app_front_end')

@section('content')
  <!-- Bread Crumb STRAT -->
  <div class="banner inner-banner1 ">
    <div class="container">
      <section class="banner-detail center-xs">
        <h1 class="banner-title">Shopping Cart</h1>
        <div class="bread-crumb right-side float-none-xs">
          <ul>
            <li><a href="index.html">Home</a>/</li>
            <li><span>Shopping Cart</span></li>
          </ul>
        </div>
      </section>
    </div>
  </div>
  <!-- Bread Crumb END -->

  <!-- CONTAIN START -->
  <section class="ptb-70">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="cart-item-table commun-table">
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>Product</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Sub Total</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>
                      <a href="product-page.html">
                        <div class="product-image">
                          <img alt="Stylexpo" src="{{ asset('front_end_style/assets/images/product/product_1_md.jpg')}}">
                        </div>
                      </a>
                    </td>
                    <td>
                      <div class="product-title">
                        <h4><a href="product-page.html">Cross Colours Camo Print Tank half mengo</a></h4>
                        <div class=""><span class="text-muted mr-2">Color :</span>gray</div>
                        <div class=""><span class="text-muted mr-2">Size :</span>XL</div>
                      </div>
                    </td>
                    <td>
                      <ul>
                        <li>
                          <div class="base-price price-box">
                            <span class="price">$80.00</span>
                          </div>
                        </li>
                      </ul>
                    </td>
                    <td>
                      <div class="input-box select-dropdown">
                        <fieldset>
                          <select data-id="100" class="quantity_cart option-drop" name="quantity_cart">
                            <option selected="" value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                          </select>
                        </fieldset>
                      </div>
                    </td>
                    <td>
                      <div class="total-price price-box">
                        <span class="price">$80.00</span>
                      </div>
                    </td>
                    <td>
                      <i title="Remove Item From Cart" data-id="100" class="fa fa-trash cart-remove-item"></i>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <a href="product-page.html">
                        <div class="product-image">
                          <img alt="Stylexpo" src="{{ asset('front_end_style/assets/images/product/product_2_md.jpg')}}">
                        </div>
                      </a>
                    </td>
                    <td>
                      <div class="product-title">
                        <h4><a href="product-page.html">Defyant Reversible Dot Shorts</a> </h4>
                        <div class=""><span class="text-muted mr-2">Color :</span>gray</div>
                        <div class=""><span class="text-muted mr-2">Size :</span>XL</div>
                      </div>
                    </td>
                    <td>
                      <ul>
                        <li>
                          <div class="base-price price-box">
                            <span class="price">$80.00</span>
                          </div>
                        </li>
                      </ul>
                    </td>
                    <td>
                      <div class="input-box select-dropdown">
                        <fieldset>
                          <select data-id="100" class="quantity_cart option-drop" name="quantity_cart">
                            <option selected="" value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                          </select>
                        </fieldset>
                      </div>
                    </td>
                    <td>
                      <div class="total-price price-box">
                        <span class="price">$80.00</span>
                      </div>
                    </td>
                    <td>
                      <i title="Remove Item From Cart" data-id="100" class="fa fa-trash cart-remove-item"></i>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="mb-30">
        <div class="row">
          <div class="col-md-6">
            <div class="mt-30">
              <a href="shop.html" class="btn btn-color">
                <span><i class="fa fa-angle-left"></i></span>
                Continue Shopping
              </a>
            </div>
          </div>
          <div class="col-md-6">
            <div class="mt-30 right-side float-none-xs">
              <a class="btn btn-color">Update Cart</a>
            </div>
          </div>
        </div>
      </div>
      <hr>
      <div class="mtb-30">
        <div class="row">
          <div class="col-md-6 mb-xs-40">
            <div class="estimate">
              <div class="heading-part mb-20">
                <h3 class="sub-heading">Estimate shipping and tax</h3>
              </div>
              <form class="full">
                <div class="row">
                  <div class="col-md-12">
                    <div class="input-box select-dropdown mb-20">
                      <fieldset>
                        <select id="country_id" class="option-drop">
                          <option selected="" value="">Select Country</option>
                          <option value="1">India</option>
                          <option value="2">China</option>
                          <option value="3">Pakistan</option>
                        </select>
                      </fieldset>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="input-box select-dropdown mb-20">
                      <fieldset>
                        <select id="state_id" class="option-drop">
                          <option selected="" value="1">Select State/Province</option>
                          <option value="2">---</option>
                        </select>
                      </fieldset>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="input-box select-dropdown mb-20">
                      <fieldset>
                        <select id="city_id" class="option-drop">
                          <option selected="" value="1">Select City</option>
                          <option value="2">---</option>
                        </select>
                      </fieldset>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <div class="col-md-6">
            <div class="cart-total-table commun-table">
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th colspan="2">Cart Total</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Item(s) Subtotal</td>
                      <td>
                        <div class="price-box">
                          <span class="price">$160.00</span>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>Shipping</td>
                      <td>
                        <div class="price-box">
                          <span class="price">$0.00</span>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td><b>Amount Payable</b></td>
                      <td>
                        <div class="price-box">
                          <span class="price"><b>$160.00</b></span>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <hr>
      <div class="mt-30">
        <div class="row">
          <div class="col-12">
            <div class="right-side float-none-xs">
              <a href="checkout.html" class="btn btn-color">Proceed to checkout
                <span><i class="fa fa-angle-right"></i></span>
              </a>
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
