@extends('front_end_inners.app_front_end')

@section('content')


  <!-- Bread Crumb STRAT -->
  <div class="banner inner-banner1 ">
    <div class="container">
      <section class="banner-detail center-xs">
        <h1 class="banner-title">Women</h1>
        <div class="bread-crumb right-side float-none-xs">
          <ul>
            <li><a href="index.html">Home</a>/</li>
            <li><span>Women</span></li>
          </ul>
        </div>
      </section>
    </div>
  </div>
  <!-- Bread Crumb END -->

  <!-- CONTAIN START -->
  <section class="pt-70">
    <div class="container">
      <div class="row">
        <div class="col-lg-9">
          <div class="row">
            <div class="col-lg-5 col-md-5 mb-xs-30">
              <div class="fotorama" data-nav="thumbs" data-allowfullscreen="native">
                <a href="#"><img src="{{ asset('front_end_style/assets/images/product/product_1_lg.jpg')}}" alt="Stylexpo"></a>
                <a href="#"><img src="{{ asset('front_end_style/assets/images/product/product_2_lg.jpg')}}" alt="Stylexpo"></a>
                <a href="#"><img src="{{ asset('front_end_style/assets/images/product/product_3_lg.jpg')}}" alt="Stylexpo"></a>
                <a href="#"><img src="{{ asset('front_end_style/assets/images/product/product_4_lg.jpg')}}" alt="Stylexpo"></a>
                <a href="#"><img src="{{ asset('front_end_style/assets/images/product/product_5_lg.jpg')}}" alt="Stylexpo"></a>
                <a href="#"><img src="{{ asset('front_end_style/assets/images/product/product_6_lg.jpg')}}" alt="Stylexpo"></a>
                <a href="#"><img src="{{ asset('front_end_style/assets/images/product/product_1_lg.jpg')}}" alt="Stylexpo"></a>
                <a href="#"><img src="{{ asset('front_end_style/assets/images/product/product_2_lg.jpg')}}" alt="Stylexpo"></a>
                <a href="#"><img src="{{ asset('front_end_style/assets/images/product/product_3_lg.jpg')}}" alt="Stylexpo"></a> </div>
            </div>
            <div class="col-lg-7 col-md-7">
              <div class="row">
                <div class="col-12">
                  <div class="product-detail-main">
                    <div class="product-item-details">
                      <h1 class="product-item-name">Cross Colours Camo Print Tank half mengo</h1>
                      <div class="rating-summary-block">
                        <div title="53%" class="rating-result"> <span style="width:53%"></span> </div>
                      </div>
                      <div class="price-box"> <span class="price">$80.00</span> <del class="price old-price">$100.00</del> </div>
                      <div class="product-info-stock-sku">
                        <div>
                          <label>Availability: </label>
                          <span class="info-deta">In stock</span>
                        </div>
                        <div>
                          <label>SKU: </label>
                          <span class="info-deta">20MVC-18</span>
                        </div>
                      </div>
                      <p>Proin lectus ipsum, gravida et mattis vulputate, tristique ut lectus. Sed et lorem nunc. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aenean eleifend laoreet congue. Vivamus adipiscing nisl ut dolor dignissim semper. Nulla luctus malesuada </p>
                      <div class="product-size select-arrow input-box select-dropdown mb-20 mt-30">
                        <label>Size</label>
                        <fieldset>
                          <select class="selectpicker form-control option-drop" id="select-by-size">
                            <option selected="selected" value="#">S</option>
                            <option value="#">M</option>
                            <option value="#">L</option>
                          </select>
                        </fieldset>
                      </div>
                      <div class="product-color select-arrow input-box select-dropdown mb-20">
                        <label>Color</label>
                        <fieldset>
                          <select class="selectpicker form-control option-drop" id="select-by-color">
                            <option selected="selected" value="#">Blue</option>
                            <option value="#">Green</option>
                            <option value="#">Orange</option>
                            <option value="#">White</option>
                          </select>
                        </fieldset>
                      </div>
                      <div class="mb-20">
                        <div class="product-qty">
                          <label for="qty">Qty:</label>
                          <div class="custom-qty">
                            <button onclick="var result = document.getElementById('qty'); var qty = result.value; if( !isNaN( qty ) &amp;&amp; qty &gt; 1 ) result.value--;return false;" class="reduced items" type="button"> <i class="fa fa-minus"></i> </button>
                            <input type="text" class="input-text qty" title="Qty" value="1" maxlength="8" id="qty" name="qty">
                            <button onclick="var result = document.getElementById('qty'); var qty = result.value; if( !isNaN( qty )) result.value++;return false;" class="increase items" type="button"> <i class="fa fa-plus"></i> </button>
                          </div>
                        </div>
                        <div class="bottom-detail cart-button">
                          <ul>
                            <li class="pro-cart-icon">
                              <form>
                                <button title="Add to Cart" class="btn-color"><span></span>Add to Cart</button>
                              </form>
                            </li>
                          </ul>
                        </div>
                      </div>
                      <div class="bottom-detail">
                        <ul>
                          <li class="pro-wishlist-icon"><a href="wishlist.html"><span></span>Wishlist</a></li>
                          <li class="pro-compare-icon"><a href="compare.html"><span></span>Compare</a></li>
                          <li class="pro-email-icon"><a href="#"><span></span>Email to Friends</a></li>
                        </ul>
                      </div>
                      <div class="share-link">
                        <label>Share This : </label>
                        <div class="social-link">
                          <ul class="social-icon">
                            <li><a class="facebook" title="Facebook" href="#"><i class="fa fa-facebook"> </i></a></li>
                            <li><a class="twitter" title="Twitter" href="#"><i class="fa fa-twitter"> </i></a></li>
                            <li><a class="linkedin" title="Linkedin" href="#"><i class="fa fa-linkedin"> </i></a></li>
                            <li><a class="rss" title="RSS" href="#"><i class="fa fa-rss"> </i></a></li>
                            <li><a class="pinterest" title="Pinterest" href="#"><i class="fa fa-pinterest"> </i></a></li>
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
        <div class="col-lg-3">
          <div class="brand-logo-pro align-center mb-30">
            <img src="{{ asset('front_end_style/assets/images/brand5.png')}}" alt="Stylexpo">
          </div>
          <div class="sub-banner-block align-center">
            <img src="{{ asset('front_end_style/assets/images/pro-banner.jpg')}}" alt="Stylexpo">
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="ptb-70">
    <div class="container">
      <div class="product-detail-tab">
        <div class="row">
          <div class="col-lg-12">
            <div id="tabs">
              <ul class="nav nav-tabs">
                <li><a class="tab-Description selected" title="Description">Description</a></li>
                <li><a class="tab-Product-Tags" title="Product-Tags">Product-Tags</a></li>
                <li><a class="tab-Reviews" title="Reviews">Reviews</a></li>
              </ul>
            </div>
            <div id="items">
              <div class="tab_content">
                <ul>
                  <li>
                    <div class="items-Description selected ">
                      <div class="Description"> <strong>The standard Lorem Ipsum passage, used since the 1500s</strong><br />
                        <p>Proin lectus ipsum, gravida et mattis vulputate, tristique ut lectus. Sed et lorem nunc. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aenean eleifend laoreet congue. Vivamus adipiscing nisl ut dolor dignissim semper. Nulla luctus malesuada Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy  took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into Stylexponic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets</p>
                        <p>Tristique ut lectus. Sed et lorem nunc. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aenean eleifend laoreet congue. Vivamus adipiscing nisl ut dolor dignissim semper. Nulla luctus malesuada Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                      </div>
                    </div>
                  </li>
                  <li>
                    <div class="items-Product-Tags"><strong>Section 1.10.32 of "de Finibus Bonorum et Malorum", written by Cicero in 45 BC</strong><br />
                      Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur</div>
                  </li>
                  <li>
                    <div class="items-Reviews">
                      <div class="comments-area">
                        <h4>Comments<span>(2)</span></h4>
                        <ul class="comment-list mt-30">
                          <li>
                            <div class="comment-user"> <img src="{{ asset('front_end_style/assets/images/comment-user.jpg')}}" alt="Stylexpo"> </div>
                            <div class="comment-detail">
                              <div class="user-name">John Doe</div>
                              <div class="post-info">
                                <ul>
                                  <li>Fab 11, 2016</li>
                                  <li><a href="#"><i class="fa fa-reply"></i>Reply</a></li>
                                </ul>
                              </div>
                              <p>Consectetur adipiscing elit integer sit amet augue laoreet maximus nuncac.</p>
                            </div>
                            <ul class="comment-list child-comment">
                              <li>
                                <div class="comment-user"> <img src="{{ asset('front_end_style/assets/images/comment-user.jpg')}}" alt="Stylexpo"> </div>
                                <div class="comment-detail">
                                  <div class="user-name">John Doe</div>
                                  <div class="post-info">
                                    <ul>
                                      <li>Fab 11, 2016</li>
                                      <li><a href="#"><i class="fa fa-reply"></i>Reply</a></li>
                                    </ul>
                                  </div>
                                  <p>Consectetur adipiscing elit integer sit amet augue laoreet maximus nuncac.</p>
                                </div>
                              </li>
                              <li>
                                <div class="comment-user"> <img src="{{ asset('front_end_style/assets/images/comment-user.jpg')}}" alt="Stylexpo"> </div>
                                <div class="comment-detail">
                                  <div class="user-name">John Doe</div>
                                  <div class="post-info">
                                    <ul>
                                      <li>Fab 11, 2016</li>
                                      <li><a href="#"><i class="fa fa-reply"></i>Reply</a></li>
                                    </ul>
                                  </div>
                                  <p>Consectetur adipiscing elit integer sit amet augue laoreet maximus nuncac.</p>
                                </div>
                              </li>
                            </ul>
                          </li>
                          <li>
                            <div class="comment-user"> <img src="{{ asset('front_end_style/assets/images/comment-user.jpg')}}" alt="Stylexpo"> </div>
                            <div class="comment-detail">
                              <div class="user-name">John Doe</div>
                              <div class="post-info">
                                <ul>
                                  <li>Fab 11, 2016</li>
                                  <li><a href="#"><i class="fa fa-reply"></i>Reply</a></li>
                                </ul>
                              </div>
                              <p>Consectetur adipiscing elit integer sit amet augue laoreet maximus nuncac.</p>
                            </div>
                          </li>
                        </ul>
                      </div>
                      <div class="main-form mt-30">
                        <h4>Leave a comments</h4>
                        <form >
                          <div class="row mt-30">
                            <div class="col-md-4 mb-30">
                              <input type="text" placeholder="Name" required>
                            </div>
                            <div class="col-md-4 mb-30">
                              <input type="email" placeholder="Email" required>
                            </div>
                            <div class="col-md-4 mb-30">
                              <input type="text" placeholder="Website" required>
                            </div>
                            <div class="col-12 mb-30">
                              <textarea cols="30" rows="3" placeholder="Message" required></textarea>
                            </div>
                            <div class="col-12 mb-30">
                              <button class="btn btn-color" name="submit" type="submit">Submit</button>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="pb-70">
    <div class="container">
      <div class="product-listing">
        <div class="row">
          <div class="col-12">
            <div class="heading-part mb-40">
              <h2 class="main_title heading"><span>Related Products</span></h2>
            </div>
          </div>
        </div>
        <div class="pro_cat">
          <div class="row">
            <div class="owl-carousel pro-cat-slider">
              <div class="item">
                <div class="product-item">
                  <div class="main-label new-label"><span>New</span></div>
                  <div class="product-image"> <a href="product-page.html"> <img src="{{ asset('front_end_style/assets/images/product/product_1_md.jpg')}}" alt="Stylexpo"> </a>
                    <div class="product-detail-inner">
                      <div class="detail-inner-left align-center">
                        <ul>
                          <li class="pro-cart-icon">
                            <form>
                              <button title="Add to Cart"><span></span>Add to Cart</button>
                            </form>
                          </li>
                          <li class="pro-wishlist-icon "><a href="wishlist.html" title="Wishlist"></a></li>
                          <li class="pro-compare-icon"><a href="compare.html" title="Compare"></a></li>
                        </ul>
                      </div>
                    </div>
                  </div>
                  <div class="product-item-details">
                    <div class="product-item-name"> <a href="product-page.html">Defyant Reversible Dot Shorts</a> </div>
                    <div class="price-box"> <span class="price">$80.00</span> <del class="price old-price">$100.00</del> </div>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="product-item">
                  <div class="main-label sale-label"><span>Sale</span></div>
                  <div class="product-image"> <a href="product-page.html"> <img src="{{ asset('front_end_style/assets/images/product/product_2_md.jpg')}}" alt="Stylexpo"> </a>
                    <div class="product-detail-inner">
                      <div class="detail-inner-left align-center">
                        <ul>
                          <li class="pro-cart-icon">
                            <form>
                              <button title="Add to Cart"><span></span>Add to Cart</button>
                            </form>
                          </li>
                          <li class="pro-wishlist-icon "><a href="wishlist.html" title="Wishlist"></a></li>
                          <li class="pro-compare-icon"><a href="compare.html" title="Compare"></a></li>
                        </ul>
                      </div>
                    </div>
                  </div>
                  <div class="product-item-details">
                    <div class="product-item-name"> <a href="product-page.html">Defyant Reversible Dot Shorts</a> </div>
                    <div class="price-box"> <span class="price">$80.00</span> <del class="price old-price">$100.00</del> </div>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="product-item">
                  <div class="main-label new-label"><span>New</span></div>
                  <div class="main-label sale-label"><span>Sale</span></div>
                  <div class="product-image"> <a href="product-page.html"> <img src="{{ asset('front_end_style/assets/images/product/product_3_md.jpg')}}" alt="Stylexpo"> </a>
                    <div class="product-detail-inner">
                      <div class="detail-inner-left align-center">
                        <ul>
                          <li class="pro-cart-icon">
                            <form>
                              <button title="Add to Cart"><span></span>Add to Cart</button>
                            </form>
                          </li>
                          <li class="pro-wishlist-icon "><a href="wishlist.html" title="Wishlist"></a></li>
                          <li class="pro-compare-icon"><a href="compare.html" title="Compare"></a></li>
                        </ul>
                      </div>
                    </div>
                  </div>
                  <div class="product-item-details">
                    <div class="product-item-name"> <a href="product-page.html">Defyant Reversible Dot Shorts</a> </div>
                    <div class="price-box"> <span class="price">$80.00</span> <del class="price old-price">$100.00</del> </div>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="product-item">
                  <div class="product-image"> <a href="product-page.html"> <img src="{{ asset('front_end_style/assets/images/product/product_4_md.jpg')}}" alt="Stylexpo"> </a>
                    <div class="product-detail-inner">
                      <div class="detail-inner-left align-center">
                        <ul>
                          <li class="pro-cart-icon">
                            <form>
                              <button title="Add to Cart"><span></span>Add to Cart</button>
                            </form>
                          </li>
                          <li class="pro-wishlist-icon "><a href="wishlist.html" title="Wishlist"></a></li>
                          <li class="pro-compare-icon"><a href="compare.html" title="Compare"></a></li>
                        </ul>
                      </div>
                    </div>
                  </div>
                  <div class="product-item-details">
                    <div class="product-item-name"> <a href="product-page.html">Defyant Reversible Dot Shorts</a> </div>
                    <div class="price-box"> <span class="price">$80.00</span> <del class="price old-price">$100.00</del> </div>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="product-item">
                  <div class="main-label sale-label"><span>Sale</span></div>
                  <div class="product-image"> <a href="product-page.html"> <img src="{{ asset('front_end_style/assets/images/product/product_5_md.jpg')}}" alt="Stylexpo"> </a>
                    <div class="product-detail-inner">
                      <div class="detail-inner-left align-center">
                        <ul>
                          <li class="pro-cart-icon">
                            <form>
                              <button title="Add to Cart"><span></span>Add to Cart</button>
                            </form>
                          </li>
                          <li class="pro-wishlist-icon "><a href="wishlist.html" title="Wishlist"></a></li>
                          <li class="pro-compare-icon"><a href="compare.html" title="Compare"></a></li>
                        </ul>
                      </div>
                    </div>
                  </div>
                  <div class="product-item-details">
                    <div class="product-item-name"> <a href="product-page.html">Defyant Reversible Dot Shorts</a> </div>
                    <div class="price-box"> <span class="price">$80.00</span> <del class="price old-price">$100.00</del> </div>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="product-item">
                  <div class="product-image"> <a href="product-page.html"> <img src="{{ asset('front_end_style/assets/images/product/product_6_md.jpg')}}" alt="Stylexpo"> </a>
                    <div class="product-detail-inner">
                      <div class="detail-inner-left align-center">
                        <ul>
                          <li class="pro-cart-icon">
                            <form>
                              <button title="Add to Cart"><span></span>Add to Cart</button>
                            </form>
                          </li>
                          <li class="pro-wishlist-icon "><a href="wishlist.html" title="Wishlist"></a></li>
                          <li class="pro-compare-icon"><a href="compare.html" title="Compare"></a></li>
                        </ul>
                      </div>
                    </div>
                  </div>
                  <div class="product-item-details">
                    <div class="product-item-name"> <a href="product-page.html">Defyant Reversible Dot Shorts</a> </div>
                    <div class="price-box"> <span class="price">$80.00</span> <del class="price old-price">$100.00</del> </div>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="product-item">
                  <div class="main-label new-label"><span>New</span></div>
                  <div class="product-image"> <a href="product-page.html"> <img src="{{ asset('front_end_style/assets/images/product/product_7_md.jpg')}}" alt="Stylexpo"> </a>
                    <div class="product-detail-inner">
                      <div class="detail-inner-left align-center">
                        <ul>
                          <li class="pro-cart-icon">
                            <form>
                              <button title="Add to Cart"><span></span>Add to Cart</button>
                            </form>
                          </li>
                          <li class="pro-wishlist-icon "><a href="wishlist.html" title="Wishlist"></a></li>
                          <li class="pro-compare-icon"><a href="compare.html" title="Compare"></a></li>
                        </ul>
                      </div>
                    </div>
                  </div>
                  <div class="product-item-details">
                    <div class="product-item-name"> <a href="product-page.html">Defyant Reversible Dot Shorts</a> </div>
                    <div class="price-box"> <span class="price">$80.00</span> <del class="price old-price">$100.00</del> </div>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="product-item">
                  <div class="main-label sale-label"><span>Sale</span></div>
                  <div class="product-image"> <a href="product-page.html"> <img src="{{ asset('front_end_style/assets/images/product/product_8_md.jpg')}}" alt="Stylexpo"> </a>
                    <div class="product-detail-inner">
                      <div class="detail-inner-left align-center">
                        <ul>
                          <li class="pro-cart-icon">
                            <form>
                              <button title="Add to Cart"><span></span>Add to Cart</button>
                            </form>
                          </li>
                          <li class="pro-wishlist-icon "><a href="wishlist.html" title="Wishlist"></a></li>
                          <li class="pro-compare-icon"><a href="compare.html" title="Compare"></a></li>
                        </ul>
                      </div>
                    </div>
                  </div>
                  <div class="product-item-details">
                    <div class="product-item-name"> <a href="product-page.html">Defyant Reversible Dot Shorts</a> </div>
                    <div class="price-box"> <span class="price">$80.00</span> <del class="price old-price">$100.00</del> </div>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="product-item">
                  <div class="main-label new-label"><span>New</span></div>
                  <div class="main-label sale-label"><span>Sale</span></div>
                  <div class="product-image"> <a href="product-page.html"> <img src="{{ asset('front_end_style/assets/images/product/product_9_md.jpg')}}" alt="Stylexpo"> </a>
                  <div class="product-detail-inner">
                      <div class="detail-inner-left align-center">
                        <ul>
                          <li class="pro-cart-icon">
                            <form>
                              <button title="Add to Cart"><span></span>Add to Cart</button>
                            </form>
                          </li>
                          <li class="pro-wishlist-icon "><a href="wishlist.html" title="Wishlist"></a></li>
                          <li class="pro-compare-icon"><a href="compare.html" title="Compare"></a></li>
                        </ul>
                      </div>
                    </div>
                  </div>
                  <div class="product-item-details">
                    <div class="product-item-name"> <a href="product-page.html">Defyant Reversible Dot Shorts</a> </div>
                    <div class="price-box"> <span class="price">$80.00</span> <del class="price old-price">$100.00</del> </div>
                  </div>
                </div>
              </div>
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

    {{-- JavaScript Section --}}
@section('javascript')

@endsection
{{-- JavaScript Section --}}

@endsection
