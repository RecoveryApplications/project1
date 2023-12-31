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
  <section class="ptb-70">
    <div class="container">
      <div class="row">
        <div class="col-xl-2 col-lg-3 mb-sm-30 col-lgmd-20per">
          <div class="sidebar-block">
            <div class="mb-40 sidebar-box listing-box"> <span class="opener plus"></span>
              <div class="sidebar-title">
                <h3><span>Categories</span></h3>
              </div>
              <div class="sidebar-contant">
                <ul>
                  <li><a href="#">Clothing <span>(21)</span></a></li>
                  <li><a href="#">Shoes <span>(05)</span></a></li>
                  <li><a href="#">Jewellery <span>(10)</span></a></li>
                  <li><a href="#">Furniture <span>(12)</span></a></li>
                  <li><a href="#">Bags <span>(18)</span></a></li>
                  <li><a href="#">Accessories <span>(70)</span></a></li>
                </ul>
              </div>
            </div>
            <div class="mb-40 sidebar-box"> <span class="opener plus"></span>
              <div class="sidebar-title">
                <h3><span>Shop by</span></h3>
              </div>
              <div class="sidebar-contant">
                <div class="price-range mb-30">
                  <div class="inner-title">Price range</div>
                  <input class="price-txt" type="text" id="amount">
                  <div id="slider-range"></div>
                </div>
                <div class="mb-20 size">
                  <div class="inner-title">Size</div>
                  <ul >
                    <li><a href="#">S (10)</a></li>
                    <li><a href="#">M (05)</a></li>
                    <li><a href="#">L (10)</a></li>
                    <li><a href="#">XL (08)</a></li>
                    <li><a href="#">XXL (05)</a></li>
                  </ul>
                </div>
                <div class="mb-20">
                  <div class="inner-title">Color</div>
                  <ul>
                    <li><a href="#">Black <span>(0)</span></a></li>
                    <li><a href="#">Blue <span>(05)</span></a></li>
                    <li><a href="#">Brown <span>(10)</span></a></li>
                  </ul>
                </div>
                <div class="mb-20">
                  <div class="inner-title">Manufacture</div>
                  <ul>
                    <li><a href="#">Augue congue <span>(0)</span></a></li>
                    <li><a href="#">Eu magna <span>(05)</span></a></li>
                    <li><a href="#">Ipsum sit <span>(10)</span></a></li>
                  </ul>
                </div>
                <a href="#" class="btn btn-color">Refine</a> </div>
            </div>
            <div class="mb-40 sidebar-box d-none d-lg-block">
              <a href="#">
                <img src="{{ asset('front_end_style/assets/images/left-banner.jpg')}}" alt="FamilyDrop">
              </a>
            </div>
            <div class="sidebar-box sidebar-item"> <span class="opener plus"></span>
              <div class="sidebar-title">
                <h3><span>Best Seller</span></h3>
              </div>
              <div class="sidebar-contant">
                <ul>
                  <li>
                    <div class="pro-media"> <a href="#"><img alt="T-shirt" src="{{ asset('front_end_style/assets/images/product/product_1_sm.jpg')}}"></a> </div>
                    <div class="pro-detail-info"> <a href="#">Black African Print</a>
                      <div class="rating-summary-block">
                        <div class="rating-result" title="53%"> <span style="width:53%"></span> </div>
                      </div>
                      <div class="price-box"> <span class="price">$80.00</span> </div>
                      <div class="cart-link">
                        <form>
                          <button title="Add to Cart">Add To Cart</button>
                        </form>
                      </div>
                    </div>
                  </li>
                  <li>
                    <div class="pro-media"> <a href="#"><img alt="T-shirt" src="{{ asset('front_end_style/assets/images/product/product_2_sm.jpg')}}"></a> </div>
                    <div class="pro-detail-info"> <a href="#">Black African Print</a>
                      <div class="rating-summary-block">
                        <div class="rating-result" title="53%"> <span style="width:53%"></span> </div>
                      </div>
                      <div class="price-box"> <span class="price">$80.00</span> </div>
                      <div class="cart-link">
                        <form>
                          <button title="Add to Cart">Add To Cart</button>
                        </form>
                      </div>
                    </div>
                  </li>
                  <li>
                    <div class="pro-media"> <a href="#"><img alt="T-shirt" src="{{ asset('front_end_style/assets/images/product/product_3_sm.jpg')}}"></a> </div>
                    <div class="pro-detail-info"> <a href="#">Black African Print</a>
                      <div class="rating-summary-block">
                        <div class="rating-result" title="53%"> <span style="width:53%"></span> </div>
                      </div>
                      <div class="price-box"> <span class="price">$80.00</span> </div>
                      <div class="cart-link">
                        <form>
                          <button title="Add to Cart">Add To Cart</button>
                        </form>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-10 col-lg-9 col-lgmd-80per">
          <div class="shorting mb-30">
            <div class="row">
              <div class="col-lg-6">
                <div class="view">
                  <div class="grid list-types"> <a href="shop.html">
                    <div class="grid-icon list-types-icon"></div>
                    </a>
                  </div>
                  <div class="list-types list active "> <a href="shop-list.html">
                    <div class="list-icon list-types-icon"></div>
                    </a>
                  </div>
                </div>
                <div class="short-by float-right-sm"> <span>Sort By :</span>
                  <div class="select-item select-dropdown">
                    <fieldset>
                      <select  name="speed" id="sort-price" class="option-drop">
                        <option value="" selected="selected">Name (A to Z)</option>
                        <option value="">Name(Z - A)</option>
                        <option value="">price(low&gt;high)</option>
                        <option value="">price(high &gt; low)</option>
                        <option value="">rating(highest)</option>
                        <option value="">rating(lowest)</option>
                      </select>
                    </fieldset>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="show-item right-side float-left-sm"> <span>Show :</span>
                  <div class="select-item select-dropdown">
                    <fieldset>
                      <select  name="speed" id="show-item" class="option-drop">
                        <option value="" selected="selected">24</option>
                        <option value="">12</option>
                        <option value="">6</option>
                      </select>
                    </fieldset>
                  </div>
                  <span>Per Page</span>
                  <div class="compare float-right-sm"> <a href="#" class="btn btn-color">Compare (0)</a> </div>
                </div>
              </div>
            </div>
          </div>
          <div class="product-listing list-type">
            <div class="row">
              <div class="col-xl-6 col-12">
                <div class="shop-list-view">
                  <div class="product-item">
                    <div class="main-label sale-label"><span>Sale</span></div>
                    <div class="product-image"> <a href="product-page.html"> <img src="{{ asset('front_end_style/assets/images/product/product_1_md.jpg')}}" alt="FamilyDrop"> </a> </div>
                  </div>
                  <div class="product-item-details">
                    <div class="product-item-name">
                      <a href="product-page.html">Cross Colours Camo Print </a>
                    </div>
                    <div class="rating-summary-block">
                      <div title="53%" class="rating-result"> <span style="width:53%"></span> </div>
                    </div>
                    <div class="price-box"> <span class="price">$80.00</span> <del class="price old-price">$100.00</del> </div>
                    <p>Proin lectus ipsum, gravida et mattis vulputate, tristique ut lectus. Sed et lorem nunc. ipsum primis in faucibus orci luctus et ultrices.</p>
                    <div class="bottom-detail">
                      <ul>
                        <li class="pro-cart-icon">
                          <form>
                            <button title="Add to Cart" class=""><span></span></button>
                          </form>
                        </li>
                        <li class="pro-wishlist-icon active"><a href="#"><span></span></a></li>
                        <li class="pro-compare-icon"><a href="#"><span></span></a></li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-6 col-12">
                <div class="shop-list-view">
                  <div class="product-item">
                    <div class="product-image"> <a href="product-page.html"> <img src="{{ asset('front_end_style/assets/images/product/product_2_md.jpg')}}" alt="FamilyDrop"> </a> </div>
                  </div>
                  <div class="product-item-details">
                    <div class="product-item-name"> <a href="product-page.html">Cross Colours Camo Print </a> </div>
                    <div class="rating-summary-block">
                      <div title="53%" class="rating-result"> <span style="width:53%"></span> </div>
                    </div>
                    <div class="price-box"> <span class="price">$80.00</span> <del class="price old-price">$100.00</del> </div>
                    <p>Proin lectus ipsum, gravida et mattis vulputate, tristique ut lectus. Sed et lorem nunc. ipsum primis in faucibus orci luctus et ultrices.</p>
                    <div class="bottom-detail">
                      <ul>
                        <li class="pro-cart-icon">
                          <form>
                            <button title="Add to Cart" class=""><span></span></button>
                          </form>
                        </li>
                        <li class="pro-wishlist-icon"><a href="#"><span></span></a></li>
                        <li class="pro-compare-icon"><a href="#"><span></span></a></li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-6 col-12">
                <div class="shop-list-view">
                  <div class="product-item">
                    <div class="product-image"> <a href="product-page.html"> <img src="{{ asset('front_end_style/assets/images/product/product_3_md.jpg')}}" alt="FamilyDrop"> </a> </div>
                  </div>
                  <div class="product-item-details">
                    <div class="product-item-name"> <a href="product-page.html">Cross Colours Camo Print</a> </div>
                    <div class="rating-summary-block">
                      <div title="53%" class="rating-result"> <span style="width:53%"></span> </div>
                    </div>
                    <div class="price-box"> <span class="price">$80.00</span> <del class="price old-price">$100.00</del> </div>
                    <p>Proin lectus ipsum, gravida et mattis vulputate, tristique ut lectus. Sed et lorem nunc. ipsum primis in faucibus orci luctus et ultrices.</p>
                    <div class="bottom-detail">
                      <ul>
                        <li class="pro-cart-icon">
                          <form>
                            <button title="Add to Cart" class=""><span></span></button>
                          </form>
                        </li>
                        <li class="pro-wishlist-icon"><a href="#"><span></span></a></li>
                        <li class="pro-compare-icon"><a href="#"><span></span></a></li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-6 col-12">
                <div class="shop-list-view">
                  <div class="product-item">
                    <div class="product-image"> <a href="product-page.html"> <img src="{{ asset('front_end_style/assets/images/product/product_4_md.jpg')}}" alt="FamilyDrop"> </a> </div>
                  </div>
                  <div class="product-item-details">
                    <div class="product-item-name"> <a href="product-page.html">Cross Colours Camo Print</a> </div>
                    <div class="rating-summary-block">
                      <div title="53%" class="rating-result"> <span style="width:53%"></span> </div>
                    </div>
                    <div class="price-box"> <span class="price">$80.00</span> <del class="price old-price">$100.00</del> </div>
                    <p>Proin lectus ipsum, gravida et mattis vulputate, tristique ut lectus. Sed et lorem nunc. ipsum primis in faucibus orci luctus et ultrices.</p>
                    <div class="bottom-detail">
                      <ul>
                        <li class="pro-cart-icon">
                          <form>
                            <button title="Add to Cart" class=""><span></span></button>
                          </form>
                        </li>
                        <li class="pro-wishlist-icon"><a href="#"><span></span></a></li>
                        <li class="pro-compare-icon"><a href="#"><span></span></a></li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-6 col-12">
                <div class="shop-list-view">
                  <div class="product-item">
                    <div class="product-image"> <a href="product-page.html"> <img src="{{ asset('front_end_style/assets/images/product/product_5_md.jpg')}}" alt="FamilyDrop"> </a> </div>
                  </div>
                  <div class="product-item-details">
                    <div class="product-item-name"> <a href="product-page.html">Cross Colours Camo Print</a> </div>
                    <div class="rating-summary-block">
                      <div title="53%" class="rating-result"> <span style="width:53%"></span> </div>
                    </div>
                    <div class="price-box"> <span class="price">$80.00</span> <del class="price old-price">$100.00</del> </div>
                    <p>Proin lectus ipsum, gravida et mattis vulputate, tristique ut lectus. Sed et lorem nunc. ipsum primis in faucibus orci luctus et ultrices.</p>
                    <div class="bottom-detail">
                      <ul>
                        <li class="pro-cart-icon">
                          <form>
                            <button title="Add to Cart" class=""><span></span></button>
                          </form>
                        </li>
                        <li class="pro-wishlist-icon"><a href="#"><span></span></a></li>
                        <li class="pro-compare-icon"><a href="#"><span></span></a></li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-6 col-12">
                <div class="shop-list-view">
                  <div class="product-item">
                    <div class="product-image"> <a href="product-page.html"> <img src="{{ asset('front_end_style/assets/images/product/product_6_md.jpg')}}" alt="FamilyDrop"> </a> </div>
                  </div>
                  <div class="product-item-details">
                    <div class="product-item-name"> <a href="product-page.html">Cross Colours Camo Print</a> </div>
                    <div class="rating-summary-block">
                      <div title="53%" class="rating-result"> <span style="width:53%"></span> </div>
                    </div>
                    <div class="price-box"> <span class="price">$80.00</span> <del class="price old-price">$100.00</del> </div>
                    <p>Proin lectus ipsum, gravida et mattis vulputate, tristique ut lectus. Sed et lorem nunc. ipsum primis in faucibus orci luctus et ultrices.</p>
                    <div class="bottom-detail">
                      <ul>
                        <li class="pro-cart-icon">
                          <form>
                            <button title="Add to Cart" class=""><span></span></button>
                          </form>
                        </li>
                        <li class="pro-wishlist-icon"><a href="#"><span></span></a></li>
                        <li class="pro-compare-icon"><a href="#"><span></span></a></li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-6 col-12">
                <div class="shop-list-view">
                  <div class="product-item">
                    <div class="product-image"> <a href="product-page.html"> <img src="{{ asset('front_end_style/assets/images/product/product_7_md.jpg')}}" alt="FamilyDrop"> </a> </div>
                  </div>
                  <div class="product-item-details">
                    <div class="product-item-name"> <a href="product-page.html">Cross Colours Camo Print</a> </div>
                    <div class="rating-summary-block">
                      <div title="53%" class="rating-result"> <span style="width:53%"></span> </div>
                    </div>
                    <div class="price-box"> <span class="price">$80.00</span> <del class="price old-price">$100.00</del> </div>
                    <p>Proin lectus ipsum, gravida et mattis vulputate, tristique ut lectus. Sed et lorem nunc. ipsum primis in faucibus orci luctus et ultrices.</p>
                    <div class="bottom-detail">
                      <ul>
                        <li class="pro-cart-icon">
                          <form>
                            <button title="Add to Cart" class=""><span></span></button>
                          </form>
                        </li>
                        <li class="pro-wishlist-icon"><a href="#"><span></span></a></li>
                        <li class="pro-compare-icon"><a href="#"><span></span></a></li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-6 col-12">
                <div class="shop-list-view">
                  <div class="product-item">
                    <div class="product-image"> <a href="product-page.html"> <img src="{{ asset('front_end_style/assets/images/product/product_8_md.jpg')}}" alt="FamilyDrop"> </a> </div>
                  </div>
                  <div class="product-item-details">
                    <div class="product-item-name"> <a href="product-page.html">Cross Colours Camo Print</a> </div>
                    <div class="rating-summary-block">
                      <div title="53%" class="rating-result"> <span style="width:53%"></span> </div>
                    </div>
                    <div class="price-box"> <span class="price">$80.00</span> <del class="price old-price">$100.00</del> </div>
                    <p>Proin lectus ipsum, gravida et mattis vulputate, tristique ut lectus. Sed et lorem nunc. ipsum primis in faucibus orci luctus et ultrices.</p>
                    <div class="bottom-detail">
                      <ul>
                        <li class="pro-cart-icon">
                          <form>
                            <button title="Add to Cart" class=""><span></span></button>
                          </form>
                        </li>
                        <li class="pro-wishlist-icon"><a href="#"><span></span></a></li>
                        <li class="pro-compare-icon"><a href="#"><span></span></a></li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <div class="pagination-bar">
                  <ul>
                    <li><a href="#"><i class="fa fa-angle-left"></i></a></li>
                    <li class="active"><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#"><i class="fa fa-angle-right"></i></a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- CONTAINER END -->
  <hr>

@endsection
@section('javascript')

@endsection
