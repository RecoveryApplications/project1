@extends('front_end_inners.app_front_end')

@php
    $image_url = asset('images/Shop.png');
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
                <h1 class="banner-title">{{ __('front_end.BreadCrump_Shop') }}</h1>
                <div class="bread-crumb right-side float-none-xs">
                    <ul>
                        <li><a href="{{ route('welcome') }}">{{ __('front_end.BreadCrump_Home') }}</a>/</li>
                        <li><span>{{ __('front_end.BreadCrump_Shop') }}</span></li>
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
                        @if ($categories->count())
                            <div class="mb-40 sidebar-box listing-box"> <span class="opener plus"></span>
                                <div class="sidebar-title">
                                    <h3><span>{{ __('front_end.home_Categories') }}</span></h3>
                                </div>
                                <div class="sidebar-contant">
                                    <ul>
                                        @foreach ($categories as $category)
                                            <li class="text-black">
                                                @php
                                                    $queryParams = request()->query();
                                                    unset($queryParams['search']);
                                                    unset($queryParams['_token']);
                                                    $queryParams['category'] = $category->id;

                                                    $url = route('shop') . '?' . http_build_query($queryParams);
                                                @endphp
                                                <a href="{{ $url }}" @class([
                                                    'text-secondary',
                                                    'text-danger font-bold' => request()->query('category') == $category->id,
                                                ])>
                                                    {{ $category->name }}
                                                </a>
                                            </li>
                                        @endforeach
                                        <li class="text-black">
                                            @php
                                                $queryParams = request()->query();
                                                unset($queryParams['search']);
                                                unset($queryParams['_token']);
                                                unset($queryParams['category']);
                                                $url = route('shop') . '?' . http_build_query($queryParams);
                                            @endphp
                                            <a href="{{ $url }}" @class([
                                                'text-secondary',
                                                'text-danger font-bold' => !request()->has('category'),
                                            ])>
                                                {{ __('front_end.shop_All_Categories') }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        @endif

                        @if ($brands->count())
                            <div class="mb-40 sidebar-box listing-box"> <span class="opener plus"></span>
                                <div class="sidebar-title">
                                    <h3><span>{{ __('front_end.shop_Brands') }}</span></h3>
                                </div>
                                <div class="sidebar-contant">
                                    <ul>
                                        @foreach ($brands as $brand)
                                            <li>
                                                @php
                                                    $queryParams = request()->query();
                                                    unset($queryParams['search']);
                                                    unset($queryParams['_token']);
                                                    $queryParams['brand'] = $brand->id;
                                                    $url = route('shop') . '?' . http_build_query($queryParams);
                                                @endphp
                                                <a href="{{ $url }}" @class([
                                                    'text-secondary',
                                                    'text-danger font-bold' => request()->query('brand') == $brand->id,
                                                ])>
                                                    {{ $brand->name_en }}
                                                </a>
                                            </li>
                                        @endforeach
                                        {{-- add new li to remove the brand from the query --}}

                                        <li>
                                            @php
                                                $queryParams = request()->query();
                                                unset($queryParams['search']);
                                                unset($queryParams['brand']);
                                                unset($queryParams['_token']);
                                                $url = route('shop') . '?' . http_build_query($queryParams);
                                            @endphp
                                            <a href="{{ $url }}" @class([
                                                'text-secondary',
                                                'text-danger font-bold' => !request()->has('brand'),
                                            ])>
                                                {{ __('front_end.shop_All_Brands') }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        @endif
                        <div class="mb-40 sidebar-box"> <span class="opener plus"></span>
                            <div class="sidebar-title">
                                <h3><span>{{ __('front_end.shop_Price_range') }}</span></h3>
                            </div>
                            @php
                                $queryParams = request()->query();
                                $url = route('shop') . '?' . http_build_query($queryParams);
                            @endphp
                            <form action="{{ $url }}" method="post">
                                @csrf
                                @method('GET')
                                <div class="sidebar-contant">
                                    <div class="price-range mb-30">
                                        <input class="price-txt" name="price_range" type="text" id="amount">
                                        <div id="slider-range"></div>
                                    </div>
                                    <button href="#"
                                        class="btn btn-danger">{{ __('front_end.shop_Refine') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-xl-10 col-lg-9 col-lgmd-80per">
                    <div class="shorting mb-30">
                        <div class="row">
                            <div class="col-lg-6">
                                {{-- <div class="view">
                                    <div @class(['grid list-types', 'active' => request()->routeIs('shop')])> <a href="{{ route('shop') }}">
                                            <div class="grid-icon list-types-icon"></div>
                                        </a>
                                    </div>
                                    <div @class(['list-types list', 'active' => request()->routeIs('shop-list')]) class=""> <a href="{{ route('shop'). '?type=list' }}">
                                            <div class="list-icon list-types-icon"></div>
                                        </a>
                                    </div>
                                </div> --}}
                                {{-- <div class="short-by float-right-sm"> <span>Sort By :</span>
                                    <div class="select-item select-dropdown">
                                        <fieldset>
                                            <select name="speed" id="sort-price" class="option-drop">
                                                <option value="" selected="selected">Name (A to Z)
                                                </option>
                                                <option value="">Name(Z - A)</option>
                                                <option value="">price(low&gt;high)</option>
                                                <option value="">price(high &gt; low)</option>
                                                <option value="">rating(highest)</option>
                                                <option value="">rating(lowest)</option>
                                            </select>
                                        </fieldset>
                                    </div>
                                </div> --}}
                            </div>
                            {{-- <div class="col-lg-6">
                                <div class="show-item right-side float-left-sm"> <span>Show :</span>
                                    <div class="select-item select-dropdown">
                                        <fieldset>
                                            <select name="speed" id="show-item" class="option-drop">
                                                <option value="" selected="selected">
                                                    <a href="{{ route('shop') . '?perPage=5' }}">24</a>
                                                </option>
                                                <option value="">12</option>
                                                <option value="">6</option>
                                            </select>
                                        </fieldset>
                                    </div>
                                    <span>Per Page</span>
                                    <div class="compare float-right-sm"> <a href="#" class="btn btn-color">Compare
                                            (0)</a> </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                    @yield('shop-theme')
                </div>
            </div>
        </div>
    </section>
    <!-- CONTAINER END -->
    <hr>
@endsection

@push('scripts')
    <script>
        $(document).on("ready", function() {
            console.log("object")
            $("#slider-range").slider({
                range: true,
                min: 0,
                max: 2000,
                values: [0, 800],
                slide: function(event, ui) {
                    $("#amount").val(`${ui.values[0]}  -  ${ui.values[1]}`);
                }
            });
            $("#amount").val($("#slider-range").slider("values", 0) + " - " + $("#slider-range").slider(
                "values",
                1));
        });
    </script>
@endpush
