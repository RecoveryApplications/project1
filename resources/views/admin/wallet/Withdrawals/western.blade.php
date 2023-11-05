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
                    <h3><i class="mdi mdi-account-multiple"></i> {{ $status }} western withdrawals</h3>
                    <nav aria-label="breadcrumb">
                        <ol class="p-0 breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('super_admin.dashboard') }}"> <i class="mdi mdi-home"></i> Dashboard </a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page"><i class="mdi mdi-account-multiple"></i>
                                {{ $status }} Withdrawals
                            </li>
                        </ol>
                    </nav>
                    @if ($status == 'pending')
                        <a href="{{ route('super_admin.western_orders.index', 'paid') }}"
                            class="btn btn-primary btn-rounded">
                            Paid Orders
                        </a>
                        <a href="{{ route('super_admin.western_orders.index', 'rejected') }}"
                            class="btn btn-danger btn-rounded">
                            Rejected Orders
                        </a>
                    @elseif ($status == 'paid')
                        <a href="{{ route('super_admin.western_orders.index', 'pending') }}"
                            class="btn btn-warning btn-rounded">
                            Pending Orders
                        </a>
                        <a href="{{ route('super_admin.western_orders.index', 'rejected') }}"
                            class="btn btn-danger btn-rounded">
                            Rejected Orders
                        </a>
                    @elseif ($status == 'rejected')
                        <a href="{{ route('super_admin.western_orders.index', 'pending') }}"
                            class="btn btn-warning btn-rounded">
                            Pending Orders
                        </a>
                        <a href="{{ route('super_admin.western_orders.index', 'paid') }}"
                            class="btn btn-primary btn-rounded">
                            Paid Orders
                        </a>
                    @endif

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
                                <th><i class="mdi mdi-account"></i> Customer Name</th>
                                <th>Customer Email</th>
                                <th><i class="mdi mdi-account"></i> Phone</th>
                                <th><i class="mdi mdi-account"></i> Full Name</th>
                                <th>Country</th>
                                <th>City</th>
                                <th><i class="mdi mdi-account"></i> Amount</th>
                                <th><i class="mdi mdi-account-question"></i> Status</th>
                                <th>Ordered At</th>
                                <th><i class="mdi mdi-settings mdi-spin"></i> Control</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders as $order)
                                <tr>
                                    <td>
                                        {{ $order->customer->name_en }}
                                    </td>
                                    <td>
                                        {{ $order->customer->email }}
                                    </td>
                                    <td>
                                        {{ $order->name ?? '---' }}
                                    </td>
                                    <td>
                                        {{ $order->phone }}
                                    </td>
                                    <td>
                                        {{ $order->country ?? '---' }}
                                    </td>
                                    <td>
                                        {{ $order->city ?? '---' }}
                                    </td>
                                    <td>
                                        {{ $order->amount }} <small> JOD</small>
                                    </td>
                                    <td>
                                        @if ($order->status == 'pending')
                                            <span class="badge badge-warning">Pending</span>
                                        @elseif($order->status == 'paid')
                                            <span class="badge badge-success">
                                                Paid
                                            </span>
                                        @elseif($order->status == 'rejected')
                                            <span class="badge badge-danger">
                                                Rejected
                                            </span>
                                        @endif

                                    </td>

                                    <td>
                                        {{ $order->created_at->format('Y-m-d / H:i:s') }}
                                    </td>

                                    <td class="gap-1 d-flex">
                                        @if ($order->status == 'pending')
                                            <form action="{{ route('super_admin.requested_orders.pay', $order->id) }}"
                                                method="POST">
                                                @csrf
                                                <button class="p-2 btn btn-success btn-sm"> <i class="fa fa-check"
                                                        title="Pay"></i></button>
                                            </form>
                                            <form action="{{ route('super_admin.requested_orders.reject', $order->id) }}"
                                                method="POST">
                                                @csrf
                                                <button class="p-2 btn btn-danger btn-sm"> <i class="fa fa-times"
                                                        title="Reject"></i></button>
                                            </form>
                                        @else
                                            ---
                                        @endif
                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No Requested Withdrawals</td>
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
