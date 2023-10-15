@extends('front_end_inners.app_front_end')

@section('content')
    <!-- Bread Crumb STRAT -->
    <div class="banner inner-banner1 ">
        <div class="container">
            <section class="banner-detail center-xs">
                <h1 class="banner-title">Blog</h1>
                <div class="bread-crumb right-side float-none-xs">
                    <ul>
                        <li><a href="index.html">Home</a>/</li>
                        <li><span>Blog</span></li>
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
                <div class="col-xl-10 col-lg-9 col-lgmd-80per">
                    <div class="blog-listing">
                        <div class="row">
                            @foreach ($blogs as $blog)
                                <div class="col-xl-6 col-12">
                                    <div class="blog-item">
                                        <div class="blog-media mb-30">
                                            <img src="{{ asset($blog->image) }}" alt="{{ $blog->title }}"
                                                style="height: 270px; object-fit: cover">
                                            <div class="blog-effect"></div>
                                            <a href="single-blog.html" title="Click For Read More" class="read">&nbsp;</a>
                                        </div>
                                        <div class="blog-detail">
                                            <div class="post-date">
                                                <span>{{ $blog->day }}</span> /
                                                {{ $blog->month_and_year }}
                                            </div>
                                            <div class="blog-title">
                                                <a href="{{ route('BlogDetails', $blog->slug) }}">
                                                    {{ $blog->title }}
                                                </a>
                                            </div>
                                            {{-- <p>Lorem khaled ipsum is a major key to success. It’s on you how you want to
                                                live
                                                your life. Nullam consectetur, arcu sed tincidunt mattis, massa nunc sodales
                                                mauris, ut lobortis arcu tortor in risus</p> --}}
                                            <hr>
                                            <div class="mt-2 post-info">
                                              <ul>
                                                  <li>
                                                      <strong>By</strong>
                                                      <a href="#">
                                                          {{ $blog->user->name_en }}
                                                      </a>
                                                  </li>
                                                  <li>
                                                      <a href="{{ route('BlogDetails' , $blog->slug) }}">
                                                          Read more
                                                          <i class="fa fa-angle-double-right"></i>
                                                      </a>
                                                  </li>
                                              </ul>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                        <div class="row">
                            <div class="col-12">
                                {{ $blogs->links()  }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-3 col-lgmd-20per">
                    <div class="sidebar-block">
                        <div class="mb-40 sidebar-box">
                            <form>
                                <div class="search-box">
                                    <input type="text" placeholder="Search here..." class="input-text">
                                    <button class="search-btn"></button>
                                </div>
                            </form>
                        </div>
                        @if ($recent_blogs->count())
                            <div class="sidebar-box sidebar-item sidebar-item-wide"> <span class="opener plus"></span>
                                <div class="sidebar-title">
                                    <h3><span>Recent Post</span></h3>
                                </div>
                                <div class="sidebar-contant">
                                    <ul>
                                        @foreach ($recent_blogs as $blogItem)
                                            <li>
                                                <div class="pro-media"> <a
                                                        href="{{ route('BlogDetails', $blogItem->slug) }}"><img
                                                            alt="{{ $blogItem->title }}"
                                                            src="{{ asset($blogItem->image) }}"></a>
                                                </div>
                                                <div class="pro-detail-info"> <a
                                                        href="{{ route('BlogDetails', $blogItem->slug) }}">{{ $blogItem->title }}</a>
                                                    <div class="post-info">{{ $blogItem->monthAndDay }},
                                                        {{ $blogItem->year }}</div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif
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
