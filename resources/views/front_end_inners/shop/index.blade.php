@extends('front_end_inners.shop.layout.shopLayout')


@section('shop-theme')
    <div class="product-listing">
        <div class="inner-listing">
            <div class="row">
                @foreach ($products as $product)
                    <div class="col-md-4 col-6 item-width mb-30">
                        <x-products.product-card :product="$product" />
                    </div>
                @endforeach

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
@endsection
