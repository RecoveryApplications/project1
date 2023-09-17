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
                                <h3>All Main Categories Archived
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
                                <li class="breadcrumb-item active">All Main Categories Archived</li>
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
                                    <th>Name EN</th>
                                    <th>Name AR</th>
                                    <th>Desc EN</th>
                                    <th>Desc AR</th>
                                    <th>Status</th>
                                    <th>Main Image</th>
                                    <th>Control</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($subCategories->count() > 0)
                                    @foreach ($subCategories as $index => $subCategory)
                                    <tr>
                                        <td>{!! isset($subCategory->id) ? $subCategory->id : "<span style='color:red;'>Undefined</span>" !!}</td>
                                        <td>{!! isset($subCategory->name_en) ? $subCategory->name_en : "<span style='color:red;'>Undefined</span>" !!}</td>
                                        <td>{!! isset($subCategory->name_ar) ? $subCategory->name_ar : "<span style='color:red;'>Undefined</span>" !!}</td>
                                        <td>{!! isset($subCategory->description_en) ? $subCategory->description_en : "<span style='color:red;'>Undefined</span>" !!}</td>
                                        <td>{!! isset($subCategory->description_ar) ? $subCategory->description_ar : "<span style='color:red;'>Undefined</span>" !!}</td>
                                        <td>
                                        <td>
                                            @if (isset($subCategory->status))
                                            @if ($subCategory->status == 1)
                                                <span class="badge badge-success">{{ isset($subCategory->status) ? 'Active' : "<span style='color:red;'>Undefined</span>" }}</span>
                                            @else
                                                <span class="badge badge-primary" >{{ isset($subCategory->status) ? 'InActive' : "<span style='color:red;'>Undefined</span>" }}</span>
                                            @endif
                                        @else
                                            <span style='color:red;'>Undefined</span>
                                        @endif
                                        </td>
                                        @if ($subCategory->image && file_exists($subCategory->image))
                                        <td>

                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset($subCategory->image) }}"
                                                    alt="" class="img-fluid img-60 me-2 blur-up lazyloaded">
                                            </div>
                                        </td>
                                        @else
                                        <td>

                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset('dashboard_files/assets/images/fashion/product/19.jpg') }}"
                                                    alt="" class="img-fluid img-60 me-2 blur-up lazyloaded">
                                            </div>
                                        </td>
                                        @endif
                                        <td>
                                            <a href="{{ route('super_admin.subCategories-softDeleteRestore', $subCategory->id) }}"class="unarchive mb-1 btn btn-sm btn-success">
                                                <i class="fa fa-solid fa-rotate-right"></i>
                                            </a>

                                        </td>
                                    </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endsection
