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
                    <h3><i class="mdi mdi-account-multiple"></i> Payment Wallets</h3>
                    <nav aria-label="breadcrumb">
                        <ol class="p-0 breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('super_admin.dashboard') }}"> <i class="mdi mdi-home"></i> Dashboard </a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page"><i class="mdi mdi-account-multiple"></i>
                                Payment Wallets
                            </li>
                        </ol>
                    </nav>
                    <div>
                        <a href="{{ route('super_admin.payment_wallets.create') }}" class="mb-1 btn btn-primary"><i
                                class="mdi mdi-playlist-plus"></i> Add New </a>
                    </div>
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
                                {{-- <th>#</th> --}}
                                <th><i class="mdi mdi-account"></i> Name EN</th>
                                <th><i class="mdi mdi-account-question"></i> Status</th>
                                <th><i class="mdi mdi-settings mdi-spin"></i> Control</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($payment_wallets as $wallet)
                                <tr>
                                    <td>
                                        {{ $wallet->name_en }}
                                    </td>
                                    <td>
                                        @if ($wallet->status == 'active')
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">Inactive</span>
                                        @endif
                                    </td>


                                    <td class="gap-1 d-flex">
                                        <form action="{{ route('super_admin.payment_wallets.edit', $wallet->id) }}"
                                            method="GET">
                                            @csrf
                                            <button class="p-2 btn btn-danger btn-sm"> <i class="fa fa-edit"
                                                    title="Edit"></i></button>
                                        </form>

                                        <form
                                            action="{{ route('super_admin.payment_wallets.toggle-status', $wallet->id) }}"
                                            method="POST">
                                            @csrf
                                            <button class="p-2 btn btn-warning btn-sm"> <i class="fa fa-toggle-on"
                                                    title="Toggle Status"></i></button>
                                        </form>
                                        <form action="{{ route('super_admin.payment_wallets.destroy', $wallet->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="p-2 btn btn-primary btn-sm"> <i class="fa fa-trash"
                                                    title="Delete"></i></button>
                                        </form>
                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No Wallets</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
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
            });
        });
    </script>
    <script src="{{ asset('dashboard_files/assets/plugins/data-tables/jquery.datatables.min.js') }}"></script>
    <script src="{{ asset('dashboard_files/assets/plugins/data-tables/datatables.bootstrap4.min.js') }}"></script>
@endsection
