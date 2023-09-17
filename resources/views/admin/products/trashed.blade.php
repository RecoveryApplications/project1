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
                                <h3>All PRODUCTS  Archived
                                    {{-- <small>Multikart Admin panel</small> --}}
                                </h3>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <ol class="breadcrumb pull-right">
                                <li class="breadcrumb-item">
                                    <a href="index.html">
                                        <i data-feather="home"></i>
                                    </a>
                                </li>
                                {{-- <li class="breadcrumb-item">Sales</li> --}}
                                <li class="breadcrumb-item active">All PRODUCTS  Archived</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid Ends-->
            <div class="col-sm-12">
                <div class="card">
                     {{-- <div class="card-header">
                        <a href="{{ route('super_admin.blogs-create') }}" class="btn btn-primary add-row mt-md-0 mt-2">Add New</a>
                        <a href="{{ route('super_admin.blogs-showSoftDelete') }}" class="btn btn-danger add-row mt-md-0 mt-2">Archive </a>
                        </div> --}}
                    <div class="card-body order-datatable">
                        <table class="display" id="basic-1">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th> Name </th>
                                    <th> Sale Price</th>
                                    <th> On Sale Price</th>
                                    <th> Image</th>
                                    <th> Status</th>
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
                                                    <img src="{{ asset($product->image) }}" width="70" height="70" style="border-radius: 10px; border:solid 1px black;">
                                                @elseif(isset($product->image_url))
                                                    <img src="{{ $product->image_url }}" width="70" height="50">
                                                @else
                                                    <img src="{{ asset('front_end_style/images/default.png') }}" width="70" height="50">
                                                @endif
                                            </td>
                                            <td>
                                                @if (isset($product->status))
                                                    @if ($product->status == 'Active')
                                                        <span style="color: green;">{{ isset($product->status) ? $product->status : "<span style='color:red;'>Undefined</span>" }}</span>
                                                    @else
                                                        <span style="color: red;">{{ isset($product->status) ? $product->status : "<span style='color:red;'>Undefined</span>" }}</span>
                                                    @endif
                                                @else
                                                    <span style='color:red;'>Undefined</span>
                                                @endif
                                            </td>
                                            <td style="text-align: center">
                                                <a href="{{ route('super_admin.products-softDeleteRestore', $product->id) }}"class="unarchive mb-1 btn btn-sm btn-success">
                                                    <i class="fa fa-solid fa-rotate-right"></i>
                                                </a>
                                                {{-- <a href="{{ route('super_admin.products-destroy', [$product->id]) }}" title="Permanently Delete" class="confirm mb-1 btn btn-sm btn-danger"><i class="mdi mdi-delete"></i></a> --}}
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
