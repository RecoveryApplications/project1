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
                    <h3><i class="mdi mdi-account-multiple"></i> All Orders</h3>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb p-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('super_admin.dashboard') }}"> <i class="mdi  mdi-home"></i> Dashboard </a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page"><i class="mdi  mdi-account-multiple"></i> All Orders</li>
                        </ol>
                    </nav>
                </div>
                <div>

                    {{-- <a href="{{ route('super_admin.orders-export') }}" class="fa fa-file-excel btn btn-primary mb-1"></i>
                        export </a> --}}
                </div>
            </div>

            {{-- ============================================== --}}
            {{-- =================== Body ===================== --}}
            {{-- ============================================== --}}
            <div class="card card-default">
                <div class="card-header justify-content-between " >
                    {{-- <h2 style="color:white;"><i class="mdi mdi-star mdi-spin"></i> طلبات سحب الرصيد : </h2> --}}
                </div>
                <div class="card-body">
                    <table id="hoverable-data-table" class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date/Time</th>
                                <th>Status</th>
                                <th>Payment</th>
                                <th>Total</th>
                                <th><i class="mdi mdi-settings mdi-spin"></i> Control</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($orders))
                                @if ($orders->count() > 0)
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>{!! isset($order->id) ? $order->id : "<span style='color:rgb(83, 83, 83);'>Undefined</span>" !!}</td>
                                            <td>{{ date('Y.d.m / h:i A', strtotime($order->created_at)) }}</td>
                                            <td>
                                                @if (isset($order->status))
                                                    @if ($order->status == 'Accepted')
                                                        <span style="color: green;">{{ isset($order->status) ? $order->status : "<span style='color:red;'>Undefined</span>" }}</span>
                                                    @else
                                                        <span style="color: red;">{{ isset($order->status) ? $order->status : "<span style='color:red;'>Undefined</span>" }}</span>
                                                    @endif
                                                @else
                                                    <span style='color:red;'>Undefined</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if (isset($order->payment_status))
                                                    @if ($order->payment_status == 'Pendding')
                                                        <span style="color:rgba(182, 121, 7, 0.87);">{!! $order->payment_status !!}</span>
                                                    @elseif($order->payment_status == 'Accepted')
                                                        <span style="color:green;">{!! $order->payment_status !!}</span>
                                                    @elseif($order->payment_status == 'Rejected')
                                                        <span style="color:red;">{!! $order->payment_status !!}</span>
                                                    @endif
                                                @else
                                                    <span>------</span>
                                                @endif
                                            </td>
                                            {{-- <td>
                                                @if (isset($order->delivery_status))
                                                    @if ($order->delivery_status == 'Pendding')
                                                        <span style="color:red">{!! $order->delivery_status !!}</span>
                                                    @elseif($order->delivery_status == 'In Progress')
                                                        <span style="color:rgba(182, 121, 7, 0.87)">{!! $order->delivery_status !!}</span>
                                                    @elseif($order->delivery_status == 'Received')
                                                        <span style="color:green">{!! $order->delivery_status !!}</span>
                                                    @endif
                                                @else
                                                    <p class="cart_amount">------</p>
                                                @endif
                                            </td> --}}
                                            {{-- <td>{!! isset($order->sub_total) ? $order->sub_total . '<small> $</small>' : "<span style='color:red;'>Undefined</span>" !!}</td> --}}
                                            {{-- <td>25 <small> SAR</small></td> --}}
                                            <td>{!! isset($order->total) ? $order->total . '<small> $</small>' : "<span style='color:red;'>Undefined</span>" !!}</td>

                                            <td>
                                                <a href="{{ route('super_admin.orders-show', [$order->id]) }}" title="Show Order Details" class=" text-primary">
                                                    <i class="fa fa-eye" title="Show"></i></a>
                                                @if ($order->status == 'Pendding' && $order->payment_status == 'Accepted' && !isset($order->delivery_status))
                                                    {{-- <a href="{{ route('super_admin.orders-sendToDelivery', [$order->id]) }}" title="Send To Delivery" class="process mb-1 btn btn-sm btn-success"><i class="mdi mdi-send"></i></a> --}}
                                                    <button type="button" class="btn btn-primary btn-sm track_btn" data-toggle="modal" data-target="#exampleModalCenter" data-id="{{$order->id}}">
                                                        <i class="mdi mdi-send"></i>
                                                      </button>
                                             @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    {{ $orders->links('pagination::bootstrap-4') }}
                                @endif
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Add Tracking Number</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="{{ route('super_admin.add-track-number') }}" method="POST"
            enctype="multipart/form-data" id="createForm">
            @csrf
            <input type="hidden" name="sale_id" id="sale_id" value="">
            <div class="modal-body">
                <div class="form-row">

                    {{-- Name EN --}}
                    <div class="col-md-12 mb-3">
                        <label class="text-dark font-weight-medium mb-3"
                            for="validationServer01">
                            <i class="mdi mdi-account"></i> Transfer order to delivery <strong class="text-danger"> * @error('track_number') ( {{ $message }} ) @enderror</strong>
                        </label>
                        <div class="input-group">




                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-primary" value="send">
            </div>
        </form>
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
                    [20, 30, 50, 75, "All"],
                ],
                "order": [[ 0, "desc" ]],
                "order": [[ 1, "desc" ]],
                "pageLength": 20,
                "dom": '<"row justify-content-between top-information"lf>rt<"row justify-content-between bottom-information"ip><"clear">'
            });
        });

        $(document).on('click','.track_btn',function(){

            data_id = $(this).data('id');
            // alert(data_id);
            $("#sale_id").val(data_id);

        });

    </script>
    <script src="{{ asset('dashboard_files/assets/plugins/data-tables/jquery.datatables.min.js') }}">
    </script>
    <script src="{{ asset('dashboard_files/assets/plugins/data-tables/datatables.bootstrap4.min.js') }}">
    </script>

@endsection
