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
                                <h3>All countries
                                    {{-- <small>Multikart Admin panel</small> --}}
                                </h3>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <ol class="breadcrumb pull-right">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('super_admin.dashboard') }}">
                                        <i data-feather="home"></i>
                                    </a>
                                </li>
                                {{-- <li class="breadcrumb-item">Sales</li> --}}
                                <li class="breadcrumb-item active">All countries</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid Ends-->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        {{-- <a href="{{ route('super_admin.public_values-create') }}" class="mt-2 btn btn-primary add-row mt-md-0">Add New</a>
                        <a href="{{ route('super_admin.public_values-showSoftDelete') }}" class="mt-2 btn btn-danger add-row mt-md-0">Archive </a> --}}
                    </div>
                    <div class="card-body order-datatable">
                        <table class="display" id="basic-1">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Key</th>
                                    <th>
                                        Name En
                                    </th>
                                    <th>
                                        Name Ar
                                    </th>
                                    <th>
                                        Status
                                    </th>
                                    <th>Control</th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($countries as $country)
                                    <tr>
                                        <td>
                                            {{ $country->id }}
                                        </td>
                                        <td>
                                            {{ $country->key }}
                                        </td>
                                        <td>
                                            {{ $country->name_en ?? '-' }}
                                        </td>
                                        <td>
                                            {{ $country->name_ar ?? '-' }}
                                        </td>
                                        <td>
                                            @if ($country->is_active == 1)
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-danger">InActive</span>
                                            @endif
                                        </td>
                                        <td class="gap-1 d-flex align-items-center">
                                            <a href="{{ route('super_admin.countries.toggle-status', $country->id) }}" class="p-1 btn btn-sm btn-air-warning">
                                                @if ($country->is_active == 1)
                                                    <i class="fa fa-toggle-on" style="font-size: 16px"
                                                        aria-hidden="true"></i>
                                                @else
                                                    <i class="fa fa-toggle-off" style="font-size: 16px"
                                                        aria-hidden="true"></i>
                                                @endif
                                            </a>
                                            <a href="{{ route('super_admin.countries.edit' , $country->id) }}" >
                                                <i class="p-1 btn btn-info btn-sm fa fa-edit" style="font-size: 16px"
                                                    aria-hidden="true"></i>
                                            </a>
                                            {{-- <form action="{{ route('super_admin.countries.destroy', $country->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="p-1 btn btn-air-primary btn-sm">
                                                    <i class="fa fa-trash" style="font-size: 16px" aria-hidden="true"></i>
                                                </button>
                                            </form> --}}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No Data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endsection
