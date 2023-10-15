@extends('front_end_inners.shop.layout.shopLayout')


@section('shop-theme')
    <div class="product-listing">
        <div class="inner-listing">
            <div class="row">
                @forelse ( $products as $product )
                <div class="col-md-4 col-6 item-width mb-30">
                    <x-products.product-card :product="$product" />
                </div>
                @empty
                    <div class="col-12">
                        <div class="text-center alert alert-danger">
                            <h3 class="p-0 m-0">
                                No products found!
                            </h3>
                        </div>
                    </div>
                @endforelse
            </div>
            <div class="row">
                <div class="col-12">
                    {{ $products->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
