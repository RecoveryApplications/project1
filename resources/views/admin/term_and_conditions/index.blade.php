@extends('admin.layouts.app')

@section('admin_css')
    {{-- <link href="{{ asset('dashboard_files/assets/plugins/data-tables/datatables.bootstrap4.min.css') }}"
        rel="stylesheet"> --}}
    {{-- <link href="{{ asset('dashboard_files/assets/css/sleek.min.css') }}"> --}}
    {{-- <link href="{{ asset('dashboard_files/assets/css/sleek.css') }}
    "> --}}

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
                       <!-- Container-fluid starts-->
            <div class="container-fluid">
                <div class="page-header">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="page-header-left">
                                <h3>TERM AND CONDITION
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
                                <li class="breadcrumb-item active"> TERM AND CONDITION
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid Ends-->
                <div class="card-header">
                    <a href="{{ route('super_admin.term_and_conditions-create') }}" class="mb-1 btn btn-primary"><i
                            class="mdi mdi-playlist-plus"></i> Add New </a>


                    <a href="{{ route('super_admin.term_and_conditions-showSoftDelete') }}"
                        class="mb-1 btn btn-danger"><i class="mdi mdi-delete"></i> Archive </a>


                </div>
            </div>
            {{-- ============================================== --}}
            {{-- =================== Body ===================== --}}
            {{-- ============================================== --}}
            <div class="card card-default">

                <div class="card-body">
                    <table id="hoverable-data-table" class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th ><i class="mdi mdi-format-title"></i> Title </th>
                                <th  ><i class="mdi mdi-clock-outline mdi-spin"></i>  Date/Time</th>
                                <th ><i class="mdi mdi-settings mdi-spin"></i> Control</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($term_and_conditions->count() > 0)
                                @foreach ($term_and_conditions as $index => $term_and_condition)
                                    <tr>
                                        <td >{!! isset($term_and_condition->term_and_condition_title_en) ? $term_and_condition->term_and_condition_title_en : "<span style='color:red;'>Undefined</span>" !!} </td>

                                        <td >
                                            {!! isset($term_and_condition->created_at) ? $term_and_condition->created_at : "<span style='color:red;'>Undefined</span>" !!}
                                        </td>



                                        <td>
                                            {{-- <a href="{{ route('super_admin.blogs-show', $news_blog->id) }}"class=" text-primary">
                                                <i class="fa fa-eye" title="Show"></i>
                                            </a> --}}

                                            <a href="{{ route('super_admin.term_and_conditions-edit', $term_and_condition->id) }}"class=" btn  btn-success">
                                                <i class="fa fa-edit" title="Edit"></i>
                                            </a>



                                            <a href="{{ route('super_admin.term_and_conditions-softDelete', $term_and_condition->id) }}"class=" btn  btn-danger">
                                                <i class="fa fa-close" title="soft Delete"></i>
                                            </a>

                                        </td>
                                    </tr>
                                @endforeach
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
                        "dom": '<"row justify-content-between top-information"lf>rt<"row justify-content-between bottom-information"ip><"clear">'
                        "order": [[ 3, "desc" ]]
                    });
                });
            </script>
            <script src="{{ asset('dashboard_files/assets/plugins/data-tables/jquery.datatables.min.js') }}">
            </script>
            <script src="{{ asset('dashboard_files/assets/plugins/data-tables/datatables.bootstrap4.min.js') }}">
            </script>

        @endsection
