@extends('admin.layouts.app')

{{-- @section('admin_css')
    <link href="{{ asset('resources/dashboard_files/assets/plugins/data-tables/datatables.bootstrap4.min.css') }}"
        rel="stylesheet">
    <link href="{{ asset('resources/dashboard_files/assets/css/sleek.min.css') }}">
@endsection --}}

@section('content')

    {{-- ============================================== --}}
    {{-- ================== Header ==================== --}}
    {{-- ============================================== --}}
    <div class="breadcrumb-wrapper breadcrumb-contacts">
        <div>
            <h1><i class="mdi mdi-account-multiple"></i> Order Details</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb p-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('super_admin.dashboard') }}">
                            <i class="mdi  mdi-home"></i> Dashboard
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('super_admin.orders-index') }}">
                            <i class="mdi  mdi-account-multiple"></i> All Orders
                        </a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page"><i class="mdi  mdi-account-multiple"></i> Order Details
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="bg-white border rounded">
        <div class="row no-gutters">

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

            {{-- ================================================================================================= --}}
            {{-- ========================================== Right Section ========================================= --}}
            {{-- ================================================================================================= --}}
            <div class="col-lg-12 col-xl-12">
                <div class="profile-content-right py-5">
                    {{-- ================================================================================================= --}}
                    {{-- ===================================== Tabs Bodies Section ======================================= --}}
                    {{-- ================================================================================================= --}}
                    <div class="tab-content px-3 px-xl-5" id="myTabContent">

                        {{-- ============================================== --}}
                        {{-- ============= All Error Messages ============= --}}
                        {{-- ============================================== --}}
                        <div class="mt-3">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <h3>Please correct the following errors : </h3>
                                    <hr>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>- {{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>

                        {{-- ============================================================================== --}}
                        {{-- =========================== Product Info Tab Body ============================ --}}
                        {{-- ============================================================================== --}}
                        <div class="tab-pane fade show active" id="tab_1" role="tabpanel"
                            aria-labelledby="timeline-tab">

                            {{-- ================================================= --}}
                            {{-- =========== Main Product Information ============ --}}
                            {{-- ================================================= --}}
                            <div class="media mt-3 profile-timeline-media">
                                <div class="media-body">
                                    <h3 class="py-3 text-dark"><i class="mdi mdi-information"></i> Main Order Information :
                                    </h3>
                                    <table class="table table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th><i class="mdi mdi-account"></i> Order ID: <span
                                                        style="color:blue;">{!! isset($cartSale->id) ? $cartSale->id : '<span style="color:red;">Undefined</span>' !!}</span></th>
                                                <th><i class="mdi mdi-account"></i> Number Of Product : <span
                                                        style="color:blue;">{!! isset($cartSale->product_count)
                                                            ? $cartSale->product_count . ' products'
                                                            : '<span style="color:red;">Undefined</span>' !!}</span></th>
                                            </tr>
                                            <tr>
                                                <th><i class="mdi mdi-account"></i> Sub Total : <span
                                                        style="color:blue;">{!! isset($cartSale->sub_total)
                                                            ? $cartSale->sub_total . '<small> $</small>'
                                                            : '<span style="color:red;">Undefined</span>' !!}</span></th>
                                                <th><i class="mdi mdi-account"></i> Total : <span
                                                        style="color:blue;">{!! isset($cartSale->total)
                                                            ? $cartSale->total . '<small> $</small>'
                                                            : '<span style="color:red;">Undefined</span>' !!}</span></th>
                                            </tr>
                                            <tr>
                                                <th><i class="mdi mdi-email"></i> Promo Code : <span
                                                        style="color:blue;">{!! isset($cartSale->promoCode->promo_code) ? $cartSale->promoCode->promo_code : '------' !!}</span></th>
                                                <th><i class="mdi mdi-email"></i> Discount : <span
                                                        style="color:blue;">{!! isset($cartSale->discount) ? $cartSale->discount . '<small> $</small>' : '------' !!}</span></th>
                                            </tr>
                                            <tr>
                                                <th><i class="mdi mdi-phone"></i> Order Status :
                                                    @if (isset($cartSale->status))
                                                        @if ($cartSale->status == 'Pendding')
                                                            <span
                                                                style="color:rgba(182, 121, 7, 0.87);">{!! $cartSale->status !!}</span>
                                                        @elseif($cartSale->status == 'Accepted')
                                                            <span style="color:green;">{!! $cartSale->status !!}</span>
                                                        @elseif($cartSale->status == 'Rejected')
                                                            <span style="color:red;">{!! $cartSale->status !!}</span>
                                                        @endif
                                                    @else
                                                        <span style="color:red;">Undefined</span>
                                                    @endif
                                                </th>
                                                <th><i class="mdi mdi-phone"></i> Payment Status :
                                                    @if (isset($cartSale->payment_status))
                                                        @if ($cartSale->payment_status == 'Pendding')
                                                            <span
                                                                style="color:rgba(182, 121, 7, 0.87);">{!! $cartSale->payment_status !!}</span>
                                                        @elseif($cartSale->payment_status == 'Accepted')
                                                            <span style="color:green;">{!! $cartSale->payment_status !!}</span>
                                                        @elseif($cartSale->payment_status == 'Rejected')
                                                            <span style="color:red;">{!! $cartSale->payment_status !!}</span>
                                                        @endif
                                                    @else
                                                        <span>------</span>
                                                    @endif
                                                </th>

                                            </tr>

                                            <tr>

                                                <th><i class="mdi mdi-phone"></i> Customer Name : <span style="color:blue;">
                                                        @if (isset($cartSale->customer->name_en))
                                                            {{ $cartSale->customer->name_en }}
                                                        @else
                                                            @if ($cartSale->name)
                                                                {{ $cartSale->name }}
                                                            @else
                                                                <span style="color:red;">Undefined</span>
                                                            @endif
                                                        @endif
                                                    </span></th>
                                                    <th><i class="mdi mdi-phone"></i> order Number : <span
                                                        style="color:blue;">{!! isset($cartSale->orderNumber) ? $cartSale->orderNumber : '<span style="color:red;">Undefined</span>' !!}</span></th>
                                            </tr>




                                            <tr>
                                                <th><i class="mdi mdi-account-multiple"></i> Customer Email : <span
                                                        style="color:blue;">
                                                        @if (isset($cartSale->customer->email))
                                                            {{ $cartSale->customer->email }}
                                                        @else
                                                            @if (isset($cartSale->email))
                                                                {{ $cartSale->email }}
                                                            @else
                                                                <span style="color:red;">Undefined</span>
                                                            @endif
                                                        @endif
                                                    </span></th>
                                                <th><i class="mdi mdi-phone"></i> Customer Phone : <span
                                                        style="color:blue;">
                                                        @if (isset($cartSale->customer->phone))
                                                            {{ $cartSale->customer->phone }}
                                                        @else
                                                            @if (isset($cartSale->phone))
                                                                {{ $cartSale->phone }}
                                                            @else
                                                                <span style="color:red;">Undefined</span>
                                                            @endif
                                                        @endif
                                                    </span>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th><i class="mdi mdi-clock-outline mdi-spin"></i> Order Added Since : <span
                                                        style="color:blue;">{!! isset($cartSale->created_at)
                                                            ? $cartSale->created_at->diffForHumans()
                                                            : '<span style="color:red;">Undefined</span>' !!}</span></th>
                                                <th><i class="mdi mdi-clock-outline mdi-spin"></i> Date & Time of Addtion :
                                                    <span style="color:blue;">{!! isset($cartSale->created_at)
                                                        ? date('Y.d.m / h:i A', strtotime($cartSale->created_at))
                                                        : '<span style="color:red;">Undefined</span>' !!}</span>
                                                </th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <div class="media mt-3 profile-timeline-media">
                                <div class="media-body">
                                    <h3 class="py-3 text-dark"><i class="mdi mdi-information"></i> Delivery Information :
                                    </h3>
                                    <table class="table table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th><i class="mdi mdi-account"></i> Name : <span style="color:blue;">
                                                        @if (isset($cartSale->location->name))
                                                            {{ $cartSale->location->name }}
                                                        @else
                                                            @if (isset($cartSale->name))
                                                                {{ $cartSale->name }}
                                                            @else
                                                                <span style="color:red;">Undefined</span>
                                                            @endif
                                                        @endif
                                                    </span>
                                                </th>
                                                <th><i class="mdi mdi-account"></i> Email : <span style="color:blue;">
                                                        @if (isset($cartSale->customer->email))
                                                            {{ $cartSale->customer->email }}
                                                        @else
                                                            @if (isset($cartSale->email))
                                                                {{ $cartSale->email }}
                                                            @else
                                                                <span style="color:red;">Undefined</span>
                                                            @endif
                                                        @endif
                                                    </span>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th><i class="mdi mdi-account"></i> Phone : <span style="color:blue;">
                                                        @if (isset($cartSale->customer->phone))
                                                            {{ $cartSale->customer->phone }}
                                                        @else
                                                            @if (isset($cartSale->phone))
                                                                {{ $cartSale->phone }}
                                                            @else
                                                                <span style="color:red;">Undefined</span>
                                                            @endif
                                                        @endif
                                                    </span>
                                                </th>
                                                <th><i class="mdi mdi-account"></i> Company : <span style="color:blue;">
                                                        @if (isset($cartSale->location->company))
                                                            {{ $cartSale->location->company }}
                                                        @else
                                                            @if (isset($cartSale->company))
                                                                {{ $cartSale->company }}
                                                            @else
                                                                <span style="color:red;">Undefined</span>
                                                            @endif
                                                        @endif
                                                    </span>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th><i class="mdi mdi-email"></i> Address : <span style="color:blue;">
                                                        @if (isset($cartSale->location->address))
                                                            {{ $cartSale->location->address }}
                                                        @else
                                                            @if (isset($cartSale->address))
                                                                {{ $cartSale->address }}
                                                            @else
                                                                <span style="color:red;">Undefined</span>
                                                            @endif
                                                        @endif
                                                    </span>
                                                </th>
                                                <th><i class="mdi mdi-email"></i> Apt/Unit/Suite/etc. : <span
                                                        style="color:blue;">
                                                        @if (isset($cartSale->location->apartment))
                                                            {{ $cartSale->location->apartment }}
                                                        @else
                                                            @if (isset($cartSale->apartment))
                                                                {{ $cartSale->apartment }}
                                                            @else
                                                                <span style="color:red;">Undefined</span>
                                                            @endif
                                                        @endif
                                                    </span>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th><i class="mdi mdi-email"></i> City : <span style="color:blue;">
                                                        @if (isset($cartSale->location->city))
                                                            {{ $cartSale->location->city }}
                                                        @else
                                                            @if (isset($cartSale->city))
                                                                {{ $cartSale->city }}
                                                            @else
                                                                <span style="color:red;">Undefined</span>
                                                            @endif
                                                        @endif
                                                    </span>
                                                </th>
                                                <th><i class="mdi mdi-phone"></i><span style="color:blue;">
                                                        @if (isset($cartSale->location->state))
                                                            {{ $cartSale->location->state }}
                                                        @else
                                                            @if (isset($cartSale->state))
                                                                {{ $cartSale->state }}
                                                            @else
                                                                <span style="color:red;">Undefined</span>
                                                            @endif
                                                        @endif
                                                    </span>
                                                </th>
                                            </tr>
                                            <tr>

                                                <th><i class="mdi mdi-phone"></i> ZipCode : <span style="color:blue;">
                                                        @if (isset($cartSale->location->zipcode))
                                                            {{ $cartSale->location->zipcode }}
                                                        @else
                                                            @if (isset($cartSale->zipcode))
                                                                {{ $cartSale->zipcode }}
                                                            @else
                                                                <span style="color:red;">Undefined</span>
                                                            @endif
                                                        @endif
                                                    </span>
                                                </th>
                                                <th><i class="mdi mdi-phone"></i> Country : <span style="color:blue;">
                                                        @if (isset($cartSale->location->country))
                                                            {{ $cartSale->location->country }}
                                                        @else
                                                            @if (isset($cartSale->country))
                                                                {{ $cartSale->country }}
                                                            @else
                                                                <span style="color:red;">Undefined</span>
                                                            @endif
                                                        @endif
                                                    </span>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th colspan="2"><i class="mdi mdi-account-multiple"></i> More Info :
                                                    <span style="color:blue;">
                                                        @if (isset($cartSale->location->more_info))
                                                            {{ $cartSale->location->more_info }}
                                                        @else
                                                            @if (isset($cartSale->more_info))
                                                                {{ $cartSale->more_info }}
                                                            @else
                                                                <span style="color:red;">Undefined</span>
                                                            @endif
                                                        @endif
                                                    </span>
                                                </th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>



                            {{-- ================================================= --}}
                            {{-- =========== payments Information ============ --}}
                            {{-- ================================================= --}}
                            <div class="media mt-3 profile-timeline-media">
                                <div class="media-body">
                                    @if (isset($payment))
                                        <h3 class="py-3 text-dark"><i class="mdi mdi-information"></i> Payment Information
                                            :
                                        </h3>
                                        <table class="table table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th><i class="mdi mdi-account"></i> payment ID: <span
                                                            style="color:blue;">{!! isset($payment->payment_id) ? $payment->payment_id : '<span style="color:red;">Undefined</span>' !!}</span></th>
                                                    <th><i class="mdi mdi-account"></i> Payer ID : <span
                                                            style="color:blue;">{!! isset($payment->payer_id) ? $payment->payer_id : '<span style="color:red;">Undefined</span>' !!}</span></th>
                                                </tr>
                                                <tr>
                                                    <th><i class="mdi mdi-account"></i> Sub Total : <span
                                                            style="color:blue;">{!! isset($payment->amount)
                                                                ? $payment->amount . '<small> $</small>'
                                                                : '<span style="color:red;">Undefined</span>' !!}</span></th>
                                                    <th><i class="mdi mdi-account"></i> Total : <span
                                                            style="color:blue;">{!! isset($payment->amount)
                                                                ? $payment->amount . '<small> $</small>'
                                                                : '<span style="color:red;">Undefined</span>' !!}</span></th>
                                                </tr>
                                                <tr>
                                                    <th><i class="mdi mdi-email"></i> Paypal email : <span
                                                            style="color:blue;">{!! isset($payment->payer_email) ? $payment->payer_email : '------' !!}</span></th>
                                                    <th> </th>
                                                </tr>
                                                <tr>


                                                    <th><i class="mdi mdi-phone"></i> Payment Status :
                                                        @if (isset($cartSale->payment_status))
                                                            @if ($cartSale->payment_status == 'Pendding')
                                                                <span
                                                                    style="color:rgba(182, 121, 7, 0.87);">{!! $cartSale->payment_status !!}</span>
                                                            @elseif($cartSale->payment_status == 'Accepted')
                                                                <span style="color:green;">{!! $cartSale->payment_status !!}</span>
                                                            @elseif($cartSale->payment_status == 'Rejected')
                                                                <span style="color:red;">{!! $cartSale->payment_status !!}</span>
                                                            @endif
                                                        @else
                                                            <span style="color:red;">Undefined</span>
                                                        @endif
                                                    </th>
                                                </tr>


                                                <tr>
                                                    <th><i class="mdi mdi-account-multiple"></i> Customer Email : <span
                                                            style="color:blue;">
                                                            @if (isset($cartSale->customer->email))
                                                                {{ $cartSale->customer->email }}
                                                            @else
                                                                @if (isset($cartSale->email))
                                                                    {{ $cartSale->email }}
                                                                @else
                                                                    <span style="color:red;">Undefined</span>
                                                                @endif
                                                            @endif
                                                        </span></th>
                                                    <th><i class="mdi mdi-phone"></i> Customer Phone : <span
                                                            style="color:blue;">
                                                            @if (isset($cartSale->customer->phone))
                                                                {{ $cartSale->customer->phone }}
                                                            @else
                                                                @if (isset($cartSale->phone))
                                                                    {{ $cartSale->phone }}
                                                                @else
                                                                    <span style="color:red;">Undefined</span>
                                                                @endif
                                                            @endif
                                                        </span>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th><i class="mdi mdi-clock-outline mdi-spin"></i> Order Added Since :
                                                        <span style="color:blue;">{!! isset($cartSale->created_at)
                                                            ? $cartSale->created_at->diffForHumans()
                                                            : '<span style="color:red;">Undefined</span>' !!}</span>
                                                    </th>
                                                    <th><i class="mdi mdi-clock-outline mdi-spin"></i> Date & Time of
                                                        Addtion : <span style="color:blue;">{!! isset($cartSale->created_at)
                                                            ? date('Y.d.m / h:i A', strtotime($cartSale->created_at))
                                                            : '<span style="color:red;">Undefined</span>' !!}</span>
                                                    </th>
                                                </tr>
                                            </thead>
                                        </table>
                                    @endif
                                    {{-- ================================================= --}}
                                    {{-- ================== Order Details ================ --}}
                                    {{-- ================================================= --}}
                                    <h3 class="py-3 text-dark"><i class="mdi mdi-information"></i> Order Details :
                                    </h3>
                                    <table class="table table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th><span style="color:blue;">Image</th>
                                                <th><span style="color:blue;">Product</th>
                                                <th><span style="color:blue;">Quantity</th>
                                                <th><span style="color:blue;">Unit Price</th>
                                                <th><span style="color:blue;">Sub Total</th>
                                                <th><span style="color:blue;">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (isset($cartSale->cartOperations) && $cartSale->cartOperations->count())
                                                @foreach ($cartSale->cartOperations as $cartOperation)
                                                    <tr>
                                                        <td>
                                                            @if (isset($cartOperation->product->image) &&
                                                                $cartOperation->product->image &&
                                                                file_exists($cartOperation->product->image))
                                                                <img src="{{ asset($cartOperation->product->image) }}"
                                                                    alt="" width="90">
                                                            @elseif (isset($cartOperation->product->image_url) && $cartOperation->product->image_url != null)
                                                                <img src="{{ $cartOperation->product->image_url }}"
                                                                    alt="" width="90">
                                                            @else
                                                                <img src="{{ asset('front_end_style/images/default.png') }}"
                                                                    alt="" width="100">
                                                            @endif
                                                        </td>
                                                        <td><a
                                                                href="{{ route('super_admin.products-show', $cartOperation->product_id) }}">{!! isset($cartOperation->product->name_en)
                                                                    ? $cartOperation->product->name_en
                                                                    : '<span style="color: red;">Undefined</span>' !!}</a>
                                                        </td>
                                                        <td>{{ isset($cartOperation->quantity) ? $cartOperation->quantity : 0 }}
                                                        </td>
                                                        <td>{!! isset($cartOperation->unit_price)
                                                            ? $cartOperation->unit_price . '<small> $</small>'
                                                            : '<span style="color: red;">Undefined</span>' !!}</td>
                                                        <td>{!! isset($cartOperation->quantity) && isset($cartOperation->unit_price)
                                                            ? $cartOperation->quantity * $cartOperation->unit_price . '<small> $</small>'
                                                            : '<span style="color: red;">Undefined</span>' !!}</td>
                                                        <td>{!! isset($cartOperation->quantity) && isset($cartOperation->unit_price)
                                                            ? $cartOperation->quantity * $cartOperation->unit_price  .
                                                                '<small> $</small>'
                                                            : '<span style="color: red;">Undefined</span>' !!}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        <tbody>
                                    </table>
                                </div>
                            </div>


                        </div>

                        {{-- ============================================================================== --}}
                        {{-- ========================== Product Images Tab Body =========================== --}}
                        {{-- ============================================================================== --}}
                        <div class="tab-pane fade" id="tab_2" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="mt-5">
                                {{-- ============================================== --}}
                                {{-- ============= Topic Other Images ============= --}}
                                {{-- ============================================== --}}
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card card-default" style="background-color:rgb(236, 233, 233);">
                                            <div class="card-body">
                                                {{-- Card Header : --}}
                                                <div class="card-header card-header-border-bottom"
                                                    style="background-color: #4c84ff;">
                                                    <h2 style="color:white;">Product Other Images :</h2>
                                                </div>
                                                {{-- Card Body : --}}
                                                <div class="card-body">
                                                    {{-- Add Other Images Form --}}
                                                    <form
                                                        action="{{ route('super_admin.products-addImages', $cartSale->id) }}"
                                                        method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="hidden" name="product_id"
                                                            value="{{ $cartSale->id }}">

                                                        <div class="form-row">
                                                            {{-- Product Other Images Input --}}
                                                            <div class="col-md-6 mb-3">
                                                                <label class="text-dark font-weight-medium mb-3"
                                                                    for="validationServer01">Product Other Images : <strong
                                                                        class="text-danger"> * </strong></label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span
                                                                            class="input-group-text mdi mdi-cloud-upload"></span>
                                                                    </div>
                                                                    <input type="file" name="product_other_images[]"
                                                                        class="form-control" id="validationServer01"
                                                                        multiple>
                                                                </div>
                                                            </div>

                                                            {{-- Button --}}
                                                            <div class="col-md-6 mb-3">
                                                                <label class="text-dark font-weight-medium mb-3"
                                                                    for="validationServer01">Save Product Other Images :
                                                                </label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span
                                                                            class="input-group-text mdi mdi-upload"></span>
                                                                    </div>
                                                                    <button type="submit"
                                                                        class="btn btn-success btn-sm form-control">Upload
                                                                        Images </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="card-img mx-auto rounded-circle">
                                                    <hr>
                                                    @if (isset($product) && $product->productImages->count() > 0)
                                                        <div class="row">
                                                            @foreach ($product->productImages as $productImage)
                                                                @if (isset($productImage->image) && $productImage->image && file_exists($productImage->image))
                                                                    <div class="col-md-4">
                                                                        <img src="{{ asset($productImage->image) }}"
                                                                            class="img-thumbnail image-preview"
                                                                            alt="Topic Other Image"
                                                                            style="border:double 3px black; margin-bottom:5px; margin-top:5px;">
                                                                        <a href="{{ route('super_admin.products-deleteImages', $productImage->id) }}"
                                                                            class="confirm btn btn-danger btn-sm"><i
                                                                                class="fa fa-trash"></i> Delete image</a>
                                                                    </div>
                                                                @else
                                                                    <div class="col-md-4">
                                                                        <img src="{{ asset('front_end_style/images/default.png') }}"
                                                                            class="img-thumbnail image-preview"
                                                                            alt="Topic Other Image"
                                                                            style="border:double 3px black; margin-bottom:5px; margin-top:5px;">
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    @else
                                                        <h3 style="color:red;">No images uploaded</h3>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ============================================================================== --}}
                        {{-- ========================= Product Orders Tab Body ============================ --}}
                        {{-- ============================================================================== --}}
                        <div class="tab-pane fade" id="tab_3" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="mt-5">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <table id="hoverable-data-table_1" class="table table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th><i class="mdi mdi-account-question"></i> Post Title</th>
                                                    <th><i class="mdi mdi-account-question"></i> Post Since</th>
                                                    <th><i class="mdi mdi-account-question"></i> Post Date/Time
                                                    </th>
                                                    <th><i class="mdi mdi-account-question"></i> Post Details</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {{-- Super Admin --}}
                                                @if (isset($activitylogs))
                                                    @if ($activitylogs->count() > 0)
                                                        @foreach ($activitylogs->sortBy('created_at') as $index => $activitylog)
                                                            <tr>
                                                                <td>{!! isset($activitylog->activity_key_type)
                                                                    ? $activitylog->activity_key_type
                                                                    : "<span style='color:red;'>Undefined</span>" !!}</td>
                                                                <td>{!! isset($activitylog->created_at)
                                                                    ? $activitylog->created_at->diffForHumans()
                                                                    : "<span style='color:red;'>Undefined</span>" !!}</td>
                                                                {{-- <td>{!! (isset($activitylog->created_at) ?  date('Y.d.m / h:i A', strtotime($activitylog->created_at)) : "<span style='color:red;'>Undefined</span>") !!}</td> --}}
                                                                <td>{!! isset($activitylog->created_at) ? $activitylog->created_at : "<span style='color:red;'>Undefined</span>" !!}</td>
                                                                <td>
                                                                    @if (isset($activitylog->id) && isset($activitylog->related_id) && isset($activitylog->model_name))
                                                                        <a href="{{ route('super_admin.activity_logs-show', [$activitylog->id]) }}"
                                                                            title="Show"
                                                                            class="mb-1 btn btn-sm btn-primary"><i
                                                                                class="mdi mdi-eye"></i> View
                                                                            Details</a>
                                                                    @endif
                                                                    {{-- {!! isset($activitylog->related_id) && isset($activitylog->model_name) ? $activitylog->related_id : "<span style='color:red;'>Undefined</span>" !!} --}}
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

                        </div>

                        {{-- ============================================================================== --}}
                        {{-- ========================= Product Reviews Tab Body =========================== --}}
                        {{-- ============================================================================== --}}
                        <div class="tab-pane fade" id="tab_4" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="mt-5">
                                <div class="row">

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('admin_javascript')
    <script>
        jQuery(document).ready(function() {
            jQuery('#hoverable-data-table_1').DataTable({
                "aLengthMenu": [
                    [20, 30, 50, 75, -1],
                    [20, 30, 50, 75, "All"]
                ],
                "pageLength": 20,
                "dom": '<"row justify-content-between top-information"lf>rt<"row justify-content-between bottom-information"ip><"clear">',
                "order": [
                    [2, "desc"]
                ]
            });
            jQuery('#hoverable-data-table_2').DataTable({
                "aLengthMenu": [
                    [20, 30, 50, 75, -1],
                    [20, 30, 50, 75, "All"]
                ],
                "pageLength": 20,
                "dom": '<"row justify-content-between top-information"lf>rt<"row justify-content-between bottom-information"ip><"clear">',
                "order": [
                    [2, "desc"]
                ]
            });
        });
    </script>
    <script src="{{ asset('dashboard_files/assets/plugins/data-tables/jquery.datatables.min.js') }}"></script>
    <script src="{{ asset('dashboard_files/assets/plugins/data-tables/datatables.bootstrap4.min.js') }}"></script>
@endsection
