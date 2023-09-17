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
                                <h3>All Brands
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
                                <li class="breadcrumb-item active">All Brands</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid Ends-->
            <div class="col-sm-12">
                <div class="card">
                     <div class="card-header">
                        <a href="{{ route('super_admin.brands-create') }}" class="btn btn-primary add-row mt-md-0 mt-2">Add New</a>
                        </div>
                    <div class="card-body order-datatable">
                        <table class="display" id="basic-1">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Main Category</th>
                                    <th> Name </th>
                                    <th>Image</th>
                                    <th>Status</th>
                                    <th>Control</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($brands))
                                @if ($brands->count() > 0)
                                    @foreach ($brands as $index => $brand)
                                        <tr>
                                            <td>{!! isset($brand->id) ? $brand->id : "<span style='color:red;'>Undefined</span>" !!}</td>
                                            <td>{!! isset($brand->mainCategory->name_en)
                                                ? $brand->mainCategory->name_en
                                                : "<span style='color:red;'>Undefined</span>" !!}</td>
                                            <td>{!! isset($brand->name_en) ? $brand->name_en : "<span style='color:red;'>Undefined</span>" !!}</td>
                                            <td>
                                                @if (isset($brand->image) && $brand->image && file_exists($brand->image))
                                                    <img src="{{ asset($brand->image) }}" width="70" height="70"
                                                        style="border-radius: 10px; border:solid 1px black;">
                                                @else
                                                    <img src="{{ asset('front_end_style/images/default.png') }}"
                                                        width="70" height="50">
                                                @endif
                                            </td>
                                            <td>
                                                @if (isset($brand->status))
                                                    @if ($brand->status == 1)
                                                        <span style="color: green;">Active</span>
                                                    @else
                                                        <span style="color: red;">Not Active</span>
                                                    @endif
                                                @else
                                                    <span style='color:red;'>Undefined</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('super_admin.brands-edit', [$brand->id]) }}"class=" btn  btn-success">
                                                    <i class="fa fa-edit" title="Edit"></i>
                                                </a>


                                                <a href="{{ route('super_admin.brands-destroy', [$brand->id]) }}"class="btn  btn-primary">
                                                    <i class="fa fa-trash" title="Destroy"></i>
                                                </a>

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
