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
                                <h3>All Promo Codes
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
                                <li class="breadcrumb-item active">All Promo Codes</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid Ends-->
            <div class="col-sm-12">
                <div class="card">
                     <div class="card-header">
                        <a href="{{ route('super_admin.promo_codes-create') }}" class="btn btn-primary add-row mt-md-0 mt-2">Add New</a>
                        <a href="{{ route('super_admin.promo_codes-showSoftDelete') }}" class="btn btn-danger add-row mt-md-0 mt-2">Archive </a>
                        </div>
                    <div class="card-body order-datatable">
                        <table class="display" id="basic-1">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th> Promo Code</th>
                                    <th> Promo Type</th>
                                    <th> Promo Value</th>
                                    <th>Expiration Date</th>
                                    <th>Status</th>
                                    <th>Control</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Super Admin --}}
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
                                                {{-- <td>{!! isset($promoCode->expiration_date) ? $promoCode->expiration_date : "<span style='color:red;'>Undefined</span>" !!} </td> --}}
                                                <td>
                                                    @if (isset($promoCode->expiration_date))
                                                        @if ($promoCode->expiration_date >= date('Y-m-d'))
                                                            <span style="color: green;">{{ isset($promoCode->expiration_date) ? $promoCode->expiration_date : "<span style='color:red;'>Undefined</span>" }}</span>
                                                        @else
                                                            <span style="color: red;">{{ isset($promoCode->expiration_date) ? $promoCode->expiration_date : "<span style='color:red;'>Undefined</span>" }}</span>
                                                        @endif
                                                    @else
                                                        <span style='color:red;'>Undefined</span>
                                                    @endif
                                                </td>
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
                                                <td>
                                                    {{-- <a href="{{ route('super_admin.categories-show', [$promoCode->id]) }}" title="Show" class="mb-1 btn btn-sm btn-info"><i class="mdi mdi-eye"></i></a> --}}
                                                    @if ($promoCode->expiration_date >= date('Y-m-d'))
                                                    <a href="{{ route('super_admin.promo_codes-edit', [$promoCode->id]) }}"class=" btn  btn-success">
                                                        <i class="fa fa-edit" title="Edit"></i>
                                                    </a>
                                                    <a href="{{ route('super_admin.promo_codes-activeInactiveSingle', [$promoCode->id]) }}" title="Active / Inactive" class=" btn  btn-warning"><i class="fa fa-stop" aria-hidden="true"></i></a>

                                                    @endif
                                                    <a href="{{ route('super_admin.promo_codes-softDelete', [$promoCode->id]) }}"class=" btn  btn-danger">
                                                        <i class="fa fa-close" title="soft Delete"></i>
                                                    </a>
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
            </div>
        @endsection
