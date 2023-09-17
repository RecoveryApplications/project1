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
                                <h3>public values
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
                                <li class="breadcrumb-item active">All public values Archived</li>
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
                                    <th>Title </th>
                                    <th>tax </th>
                                    <th>Status</th>
                                    <th>Control</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($public_values))
                                @if ($public_values->count() > 0)
                                    @foreach ($public_values as $index => $public_values)
                                    <tr>
                                        <td>{!! isset($public_values->id) ? $public_values->id : "<span style='color:red;'>Undefined</span>" !!}</td>
                                        <td>{!! isset($public_values->title) ? $public_values->title : "<span style='color:red;'>Undefined</span>" !!}</td>
                                        <td>{!! isset($public_values->tax) ? $public_values->tax : "<span style='color:red;'>Undefined</span>" !!}</td>

                                        <td>
                                            @if (isset($public_values->status))
                                                @if ($public_values->status == 1)
                                                    <span style="color: green;">{{ isset($public_values->status) ? 'Active' : "<span style='color:red;'>Undefined</span>" }}</span>
                                                @else
                                                    <span style="color: red;">{{ isset($public_values->status) ? 'InActive' : "<span style='color:red;'>Undefined</span>" }}</span>
                                                @endif
                                            @else
                                                <span style='color:red;'>Undefined</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('super_admin.public_values-softDeleteRestore', $public_values->id) }}"class="unarchive mb-1 btn btn-sm btn-success">
                                                <i class="fa fa-solid fa-rotate-right"></i>
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
