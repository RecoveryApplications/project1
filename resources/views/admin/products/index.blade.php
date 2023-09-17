@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="content">
            {{-- =========================================================== --}}
            {{-- ================== Sweet Alert Section ==================== --}}
            {{-- =========================================================== --}}
            <div>
                @if (session()->has('success'))
                    <script>
                        swal("Great Job !!!", "{!! Session::get('success') !!}", "success", {
                            button: "OK",
                        });
                    </script>
                @endif
                @if (session()->has('danger'))
                    <script>
                        swal("oops !!!", "{!! Session::get('danger') !!}", "error", {
                            button: "Close",
                        });
                    </script>
                @endif
            </div>
            <!-- Container-fluid starts-->
            <div class="container-fluid">
                <div class="page-header">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="page-header-left">
                                <h3>All Products
                                    {{-- <small>Multikart Admin panel</small> --}}
                                </h3>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <ol class="breadcrumb pull-right">
                                <li class="breadcrumb-item">
                                    <a href="{{route('super_admin.dashboard')}}">
                                        <i data-feather="home"></i>
                                    </a>
                                </li>
                                {{-- <li class="breadcrumb-item">Sales</li> --}}
                                <li class="breadcrumb-item active">All Products</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid Ends-->
            <div class="col-sm-12">
                <div class="card">
                     <div class="card-header">
                        <a href="{{ route('super_admin.products-importXlsx') }}" class="btn btn-primary add-row mt-md-0 mt-2">import from file xlsx</a>
                        <a href="{{ route('super_admin.products-create') }}" class="btn btn-primary add-row mt-md-0 mt-2">Add New</a>
                        <a href="{{ route('super_admin.products-showSoftDelete') }}" class="btn btn-danger add-row mt-md-0 mt-2">Archive </a>
                        <a href="{{ route('super_admin.products-export') }}" class="btn btn-danger add-row mt-md-0 mt-2">export </a>
                        <form method="POST" action="{{ route('super_admin.update.items') }}">
                            @csrf
                            <button  class="btn btn-danger add-row mt-md-0 mt-2" type="submit">Update All Items</button>
                        </form>
                    </div>
                    <div class="card-body order-datatable">
                        <table class="display" id="basic-1">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th> Name EN</th>
                                    <th> Sale Price</th>
                                    <th> On Sale Price</th>
                                    <th> Image</th>
                                    <th>Status</th>
                                    <th>Main Category</th>
                                    <th>Sub Category</th>
                                    <th> Control</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($products))
                                @if ($products->count() > 0)
                                    @foreach ($products as $index => $product)
                                        <tr>
                                            <td>{!! isset($product->id) ? $product->id : "<span style='color:red;'>Undefined</span>" !!}</td>
                                            <td>{!! isset($product->name_en) ? $product->name_en : "<span style='color:red;'>Undefined</span>" !!}</td>
                                            <td>{!! isset($product->sale_price) ? $product->sale_price : "<span style='color:red;'>Undefined</span>" !!}</td>
                                            <td>{!! isset($product->on_sale_price) ? $product->on_sale_price : "<span style='color:red;'>Undefined</span>" !!}</td>
                                            <td>
                                                @if (isset($product->image) && $product->image && file_exists($product->image))
                                                    <img src="{{ asset($product->image) }}" width="70" height="70"
                                                        style="border-radius: 10px; border:solid 1px black;">
                                                @elseif(isset($product->image_url))
                                                    <img src="{{ $product->image_url }}" width="70" height="50">
                                                @else
                                                    <img src="{{ asset('front_end_style/images/default.png') }}"
                                                        width="70" height="50">
                                                @endif
                                            </td>
                                            <td>
                                                @if (isset($product->status))
                                                    @if ($product->status == 'Active')
                                                        <span
                                                            style="color: green;">{{ isset($product->status) ? $product->status : "<span style='color:red;'>Undefined</span>" }}</span>
                                                    @else
                                                        <span
                                                            style="color: red;">{{ isset($product->status) ? $product->status : "<span style='color:red;'>Undefined</span>" }}</span>
                                                    @endif
                                                @else
                                                    <span style='color:red;'>Undefined</span>
                                                @endif
                                            </td>

                                            <td><a
                                                    href="{{ route('super_admin.mainCategories-index') }}">{!! isset($product->mainCategory->name_en)
                                                        ? $product->mainCategory->name_en
                                                        : "<span style='color:red;'>Undefined</span>" !!}</a>
                                            </td>
                                            <td><a
                                                    href="{{ route('super_admin.subCategories-index') }}">{!! isset($product->subCategory->name_en)
                                                        ? $product->subCategory->name_en
                                                        : "<span style='color:red;'>Undefined</span>" !!}</a>
                                            </td>
                                            <td>
                                                <a href="{{ route('super_admin.products-show', [$product->id]) }}"
                                                    title="Show" class="mb-1 btn btn-sm btn-info"> <i class="fa fa-eye" aria-hidden="true"></i></a>
                                                    <a href="{{ route('super_admin.products-edit', [$product->id]) }}"class=" btn  btn-success">
                                                        <i class="fa fa-edit" title="Edit"></i>
                                                    </a>
                                                <a href="{{ route('super_admin.products-activeInactiveSingle', [$product->id]) }}" title="Active / Inactive" class=" btn  btn-warning"><i class="fa fa-stop" aria-hidden="true"></i></a>
                                                <a href="{{ route('super_admin.products-softDelete', [$product->id]) }}"class=" btn  btn-danger">
                                                    <i class="fa fa-close" title="soft Delete"></i>
                                                </a>
                                        @foreach ($public_color_values_proparty as $key => $public_color)
                                            @foreach ($public_size_values_proparty as $key => $public_size)

                                                @if($public_size->values==2 && $public_color->values==2)

                                                @else
                                                <a href="{{ route('super_admin.products-properties', [$product->id]) }}"
                                                    class="mb-1 btn btn-sm btn-secondary">Properties</a>
                                                @endif

                                            @endforeach

                                        @endforeach




                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endsection
