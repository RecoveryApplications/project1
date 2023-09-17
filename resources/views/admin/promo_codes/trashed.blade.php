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
                    <h1><i class="fas fa-user-md"></i> All Promo Codes Archived</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb p-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('super_admin.dashboard') }}">
                                    <i class="mdi  mdi-home"></i> Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('super_admin.promo_codes-index') }}">
                                    <i class="fas fa-spell-check"></i> All Promo Codes
                                </a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page"><i
                                class="mdi mdi-delete"></i> All Promo Codes Archived
                            </li>
                        </ol>
                    </nav>
                </div>

            </div>

            {{-- ============================================== --}}
            {{-- =================== Body ===================== --}}
            {{-- ============================================== --}}
            <div class="card card-default">
                <div class="card-header justify-content-between " style="background-color: #4c84ff;">
                    {{-- <h2 style="color:white;"><i class="mdi mdi-star mdi-spin"></i> طلبات سحب الرصيد : </h2> --}}
                </div>
                <div class="card-body">
                    <table id="hoverable-data-table" class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><i class="mdi mdi-account"></i> Promo Code</th>
                                <th><i class="mdi mdi-account"></i> Promo Type</th>
                                <th><i class="mdi mdi-account"></i> Promo Value</th>
                                <th><i class="mdi mdi-email"></i> Expiration Date</th>
                                <th><i class="mdi mdi-account-switch"></i> Status</th>
                                <th><i class="mdi mdi-settings mdi-spin"></i> Control</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($promoCodes))
                                @if ($promoCodes->count() > 0)
                                    @foreach ($promoCodes as $index => $promoCode)
                                        <tr>
                                            <td>{!! isset($promoCode->id) ? $promoCode->id : "<span style='color:red;'>Undefined</span>" !!}</td>
                                            <td>{!! isset($promoCode->promo_code) ? $promoCode->promo_code : "<span style='color:red;'>Undefined</span>" !!}</td>
                                            <td>{!! isset($promoCode->promo_type) ? $promoCode->promo_type : "<span style='color:red;'>Undefined</span>" !!}</td>
                                            @if ($promoCode->promo_type == 'Percentage')
                                                <td>{!! isset($promoCode->promo_value) ? $promoCode->promo_value . ' %' : "<span style='color:red;'>Undefined</span>" !!}</td>
                                            @else
                                                <td>{!! isset($promoCode->promo_value) ? $promoCode->promo_value . ' SAR' : "<span style='color:red;'>Undefined</span>" !!}</td>
                                            @endif
                                            <td>{!! isset($promoCode->expiration_date) ? $promoCode->expiration_date : "<span style='color:red;'>Undefined</span>" !!}</td>
                                            <td>
                                                @if (isset($promoCode->status))
                                                    @if ($promoCode->status == 'Active')
                                                        <span style="color: green;">{{ isset($promoCode->status) ? $promoCode->status : "<span style='color:red;'>Undefined</span>" }}</span>
                                                    @else
                                                        <span style="color: red;">{{ isset($promoCode->status) ? $promoCode->status : "<span style='color:red;'>Undefined</span>" }}</span>
                                                    @endif
                                                @else
                                                    <span style='color:red;'>Undefined</span>
                                                @endif
                                            </td>
                                            <td style="text-align: center">
                                                <a href="{{ route('super_admin.promo_codes-softDeleteRestore', $promoCode->id) }}" class="unarchive mb-1 btn btn-sm btn-success"><i class="fa fa-solid fa-rotate-right"></i></a>
                                                {{-- <a href="{{ route('super_admin.promo_codes-destroy', [$promoCode->id]) }}" title="Permanently Delete" class="confirm mb-1 btn btn-sm btn-danger"><i class="mdi mdi-delete"></i></a> --}}
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
                        "dom": '<"row justify-content-between top-information"lf>rt<"row justify-content-between bottom-information"ip><"clear">'
                        "order": [[ 2, "desc" ]]
                    });
                });
            </script>
            <script src="{{ asset('dashboard_files/assets/plugins/data-tables/jquery.datatables.min.js') }}">
            </script>
            <script src="{{ asset('dashboard_files/assets/plugins/data-tables/datatables.bootstrap4.min.js') }}">
            </script>

        @endsection
