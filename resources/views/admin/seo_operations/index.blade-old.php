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
                    <h1> Seo Operations </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb p-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('super_admin.dashboard') }}">
                                    <span class="mdi mdi-home"></span> Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">All Seo Operations</li>
                        </ol>
                    </nav>
                </div>
            </div>
            {{-- ============================================== --}}
            {{-- =================== Body ===================== --}}
            {{-- ============================================== --}}
            <div class="card card-default">
                <div class="card-header card-header-border-bottom">
                    <h2> List Seo Operations : </h2>
                </div>
                <div class="card-body">
                    <table id="hoverable-data-table" class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th style="text-align: center"><i class="mdi mdi-format-title"></i> Page Name </th>
                                <th style="text-align: center"><i class="mdi mdi-format-title"></i> Last Update By </th>
                                <th style="text-align: center"><i class="mdi mdi-format-title"></i> Last Update </th>
                                <th style="text-align: center"><i class="mdi mdi-settings mdi-spin"></i> H1 En </th>
                                <th style="text-align: center"><i class="mdi mdi-settings mdi-spin"></i> H1 AR </th>
                                <th style="text-align: center"><i class="mdi mdi-settings mdi-spin"></i> H2 EN </th>
                                <th style="text-align: center"><i class="mdi mdi-settings mdi-spin"></i> H2 AR </th>
                                <th style="text-align: center"><i class="mdi mdi-settings mdi-spin"></i> Control </th>

                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($operations))
                                 @if ($operations->count() > 0)
                                @foreach ($operations as $index => $operation)              

                                    <tr>  
                                        <td  style="text-align: center"></td>
                                        <td  style="text-align: center"></td>

                                        <td style="text-align: center">
                                            {{ isset($operation->updated_at) ? $operation->updated_at : 'Undefined' }}
                                          
                                        </td>

                                        <td  style="text-align: center"></td>
                                        <td  style="text-align: center">{{ isset($operation->h1_val_ar) ? $operation->h1_val_ar : 'Undefined' }}</td>
                                        <td  style="text-align: center">{{ isset($operation->h2_val_en) ? $operation->h2_val_en : 'Undefined' }}</td>
                                        <td  style="text-align: center">{{ isset($operation->h2_val_ar) ? $operation->h2_val_ar : 'Undefined' }}</td>



                                        <td  style="text-align: center">
                                            <a href="{{ route('super_admin.operations-edit', $operation->id) }}"
                                                class="mb-1 btn btn-sm btn-success"><i
                                                    class="mdi mdi-playlist-edit"></i></a>
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
