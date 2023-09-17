@extends('admin.layouts.app')

@section('admin_css')
    {{-- <link href="{{ asset('dashboard_files/assets/plugins/data-tables/datatables.bootstrap4.min.css') }}"
        rel="stylesheet"> --}}
    {{-- <link href="{{ asset('dashboard_files/assets/css/sleek.min.css') }}"> --}}
    {{-- <link href="{{ asset('dashboard_files/assets/css/sleek.css') }}"> --}}

@endsection

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
                        swal("Oops !!!", "{!! Session::get('danger') !!}", "error", {
                            button: "Close",
                        });

                    </script>
                @endif
            </div>

            {{-- ============================================== --}}
            {{-- ================== Header ==================== --}}
            {{-- ============================================== --}}
            <div class="breadcrumb-wrapper breadcrumb-contacts">
                <div>
                    <h1> Home Banner </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb p-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('super_admin.dashboard') }}">
                                    <span class="mdi mdi-home"></span> Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">All Banner</li>
                        </ol>
                    </nav>
                </div>

            <div>
                <a href="{{ route('super_admin.banners-create') }}" class="mb-1 btn btn-primary"><i
                        class="mdi mdi-playlist-plus"></i> Add New</a>

                        {{-- <a href="{{ route('super_admin.banners-showSoftDelete') }}" class="mb-1 btn btn-danger"><i
                            class="mdi mdi-delete"></i> Archive </a> --}}


            </div>

     </div>        {{-- ============================================== --}}
            {{-- =================== Body ===================== --}}
            {{-- ============================================== --}}
            <div class="card card-default">
                <div class="card-body">
                    <table id="hoverable-data-table" class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th style="text-align: center"><i class="mdi mdi-format-title"></i> Title </th>
                                <th style="text-align: center"><i class="mdi mdi-format-title"></i> Page </th>
                                <th style="text-align: center"><i class="mdi mdi-format-title"></i> Last Update </th>
                                <th style="text-align: center"><i class="mdi mdi-settings mdi-spin"></i> Status </th>
                                <th style="text-align: center"><i class="mdi mdi-settings mdi-spin"></i> image  </th>
                                <th style="text-align: center"><i class="mdi mdi-settings mdi-spin"></i> Control </th>

                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($banners))
                                 @if ($banners->count() > 0)
                                @foreach ($banners as $index => $banner)

                                <tr>
                                    <td  style="text-align: center">{{ isset($banner->title) ? $banner->title : 'Undefined' }}</td>
                                    <td  style="text-align: center">{{ isset($banner->page) ? $banner->page : 'Undefined' }}</td>

                                    <td style="text-align: center">
                                        {{ isset($banner->updated_at) ? $banner->updated_at : "<span style='color:red;'>Undefined</span>" }}
                                    </td>

                                    <td  style="text-align: center">{{ isset($banner->status) ? $banner->status : 'Undefined' }}</td>
                                    @if ($banner->image && file_exists($banner->image))
                                            <td>

                                                <div class="d-flex align-items-center">
                                                    <img src="{{ asset($banner->image) }}"
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
                                    <td  style="text-align: center">

                                        <a href="{{ route('super_admin.banners-show', $banner->id) }}"
                                            class="btn btn-primary"><i class="fa fa-eye"></i></a>






                                            <a href="{{ route('super_admin.banners-edit', $banner->id) }}"class=" btn  btn-success">
                                                <i class="fa fa-edit" title="Edit"></i>
                                            </a>



                                            <a href="{{ route('super_admin.banners-softDelete', $banner->id) }}"class=" btn  btn-danger">
                                                <i class="fa fa-close" title="soft Delete"></i>
                                            </a>
                                            <a href="{{ route('super_admin.banners-activeInactiveSingle', [$banner->id]) }}" title="Active / Inactive" class=" btn  btn-warning"><i class="fa fa-stop" aria-hidden="true"></i></a>

                                            <a href="{{ route('super_admin.banners-destroy', [$banner->id]) }}"class="btn  btn-primary">
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
        @endsection

        @section('admin_javascript')
            <script>
                jQuery(document).ready(function() {
            jQuery('#hoverable-data-table').DataTable({
                "aLengthMenu": [
                    [20, 30, 50, 75, -1],
                    [20, 30, 50, 75, "All"]
                ],
                "pageLength": 20,
                "dom": '<"row justify-content-between top-information"lf>rt<"row justify-content-between bottom-information"ip><"clear">',
                "order": [
                    [0, "desc"]
                ]
            });
        });

            </script>
            <script src="{{ asset('dashboard_files/assets/plugins/data-tables/jquery.datatables.min.js') }}">
            </script>
            <script src="{{ asset('dashboard_files/assets/plugins/data-tables/datatables.bootstrap4.min.js') }}">
            </script>

        @endsection
