@extends('front_end_inners.customer.profile.layout')



@section('content')
    <div id="data-step3" class="account-content" data-temp="tabdata" style="display:none">
        <div id="form-print" class="admission-form-wrapper">
            <div class="row">
                <div class="col-12">
                    <div class="heading-part heading-bg mb-30">
                        <h2 class="m-0 heading">My Orders</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 mb-xs-30">
                    <div class="cart-item-table commun-table">
                        <div class="table-responsive">

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date/Time</th>
                                        <th>Items</th>
                                        <th>Status</th>
                                        <th>Payment</th>
                                        <th>Delivery</th>
                                        <th>Total</th>
                                        <th>Show</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($cartSales as $cartSale)
                                        <tr>
                                            <td>
                                                {{ $loop->iteration }}
                                            </td>
                                            <td style="min-width: 200px">
                                                {{ date('Y.m.d / h:i A', strtotime($cartSale->created_at)) }}
                                            </td>
                                            <td>
                                                {{ $cartSale->product_count }}
                                            </td>
                                            <td>
                                                {{ $cartSale->status }}
                                            </td>
                                            <td>
                                                {{ $cartSale->payment_status }}
                                            </td>
                                            <td>
                                                {{ $cartSale->delivery_status }}
                                            </td>
                                            <td>
                                                {{ $cartSale->total }}
                                            </td>
                                            <td><button class="p-1 btn btn-sm btn-secondary show_order" data-toggle="modal"
                                                    data-target="#exampleModalCenter{{ $cartSale->id }}"
                                                    data-id="{{ encrypt($cartSale->id) }}"><i
                                                        class="ecicon eci-info"></i>show</button></td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">No Orders</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{ $cartSales->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- modal section --}}
    @foreach ($cartSales as $cartSale)
        <div class="modal fade" id="exampleModalCenter{{ $cartSale->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content" style="height: 100% !important; overflow: auto !important;">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Order Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="order_body">
                        <div class="tab-pane fade show active" id="tab_1" role="tabpanel"
                            aria-labelledby="timeline-tab">
                            {{-- ================================================= --}}
                            {{-- =========== Main Product Information ============ --}}
                            {{-- ================================================= --}}
                            <div class="mt-3 media profile-timeline-media">
                                <div class="media-body">
                                    <h3 class="py-3 text-dark"><i class="mdi mdi-information"></i> Main
                                        Order
                                        Information :
                                    </h3>
                                    <table class="table table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th><i class="mdi mdi-account"></i> Order ID: <span
                                                        style="color:blue;">{!! isset($cartSale->id) ? $cartSale->id : '<span style="color:red;">Undefined</span>' !!}</span>
                                                </th>
                                                <th><i class="mdi mdi-account"></i> Number Of Product :
                                                    <span style="color:blue;">{!! isset($cartSale->product_count) ? $cartSale->product_count : '<span style="color:red;">Undefined</span>' !!}</span>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th><i class="mdi mdi-account"></i> Sub Total : <span
                                                        style="color:blue;">{!! isset($cartSale->sub_total)
                                                            ? $cartSale->sub_total . '<small> $</small>'
                                                            : '<span style="color:red;">Undefined</span>' !!}</span>
                                                </th>
                                                <th><i class="mdi mdi-account"></i> Total : <span
                                                        style="color:blue;">{!! isset($cartSale->total)
                                                            ? $cartSale->total . '<small> $</small>'
                                                            : '<span style="color:red;">Undefined</span>' !!}</span>
                                                </th>
                                            </tr>
                                            {{-- <tr>
                                        <th><i class="mdi mdi-email"></i> Promo Code : <span
                                                style="color:blue;">{!! isset($cartSale->promoCode->promo_code) ? $cartSale->promoCode->promo_code : '------' !!}</span></th>
                                        <th><i class="mdi mdi-email"></i> Discount : <span
                                                style="color:blue;">{!! isset($cartSale->discount) ? $cartSale->discount . '<small> $</small>' : '------' !!}</span></th>
                                    </tr> --}}
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
                                                <th><i class="mdi mdi-phone"></i> Customer Name : <span
                                                        style="color:blue;">{!! isset($cartSale->customer->name_en)
                                                            ? $cartSale->customer->name_en
                                                            : '<span style="color:red;">Undefined</span>' !!}</span>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th><i class="mdi mdi-phone"></i> Delivery Status :
                                                    @if (isset($cartSale->delivery_status))
                                                        @if ($cartSale->delivery_status == 'Pendding')
                                                            <span
                                                                style="color:rgba(182, 121, 7, 0.87);">{!! $cartSale->delivery_status !!}</span>
                                                        @elseif($cartSale->payment_status == 'In Progress')
                                                            <span style="color:green;">{!! $cartSale->delivery_status !!}</span>
                                                        @else
                                                            <span style="color:red;">{!! $cartSale->delivery_status !!}</span>
                                                        @endif
                                                    @else
                                                        <span>------</span>
                                                    @endif
                                                </th>
                                                <th><i class="mdi mdi-phone"></i> Shipment Num. :
                                                    @if (isset($cartSale->track_number))
                                                        <span style="color:blue;">{!! $cartSale->track_number !!}</span>
                                                    @else
                                                        <span>------</span>
                                                    @endif
                                                </th>
                                            </tr>
                                            <tr>
                                                <th><i class="mdi mdi-account-multiple"></i> Customer Email
                                                    :
                                                    <span style="color:blue;">{!! isset($cartSale->customer->email) ? $cartSale->customer->email : '<span style="color:red;">Undefined</span>' !!}</span>
                                                </th>
                                                <th><i class="mdi mdi-phone"></i> Customer Phone : <span
                                                        style="color:blue;">{!! isset($cartSale->customer->phone) ? $cartSale->customer->phone : '<span style="color:red;">Undefined</span>' !!}</span>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th><i class="mdi mdi-clock-outline mdi-spin"></i> Order
                                                    Added
                                                    Since : <span style="color:blue;">{!! isset($cartSale->created_at)
                                                        ? $cartSale->created_at->diffForHumans()
                                                        : '<span style="color:red;">Undefined</span>' !!}</span>
                                                </th>
                                                <th><i class="mdi mdi-clock-outline mdi-spin"></i> Date &
                                                    Time
                                                    of
                                                    Addtion :
                                                    <span style="color:blue;">{!! isset($cartSale->created_at)
                                                        ? date('Y.d.m / h:i A', strtotime($cartSale->created_at))
                                                        : '<span style="color:red;">Undefined</span>' !!}</span>
                                                </th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <div class="mt-3 media profile-timeline-media">
                                <div class="media-body">
                                    <h3 class="py-3 text-dark"><i class="mdi mdi-information"></i>
                                        Delivery
                                        Information :
                                    </h3>
                                    <table class="table table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th><i class="mdi mdi-account"></i> Name : <span
                                                        style="color:blue;">{!! isset($cartSale->location->name) ? $cartSale->location->name : '<span style="color:red;">Undefined</span>' !!}</span>
                                                </th>
                                                <th><i class="mdi mdi-account"></i> Email : <span
                                                        style="color:blue;">{!! isset($cartSale->location->email) ? $cartSale->location->email : '<span style="color:red;">Undefined</span>' !!}</span>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th><i class="mdi mdi-account"></i> Phone : <span
                                                        style="color:blue;">{!! isset($cartSale->location->phone) ? $cartSale->location->phone : '<span style="color:red;">Undefined</span>' !!}</span>
                                                </th>
                                                <th><i class="mdi mdi-account"></i> Company : <span
                                                        style="color:blue;">{!! isset($cartSale->location->company)
                                                            ? $cartSale->location->company
                                                            : '<span style="color:red;">Undefined</span>' !!}</span>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th><i class="mdi mdi-email"></i> Address : <span
                                                        style="color:blue;">{!! isset($cartSale->location->address) ? $cartSale->location->address : '------' !!}</span>
                                                </th>
                                                <th><i class="mdi mdi-email"></i> Apt/Unit/Suite/etc. :
                                                    <span style="color:blue;">{!! isset($cartSale->location->apartment) ? $cartSale->location->apartment : '------' !!}</span>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th><i class="mdi mdi-email"></i> City : <span
                                                        style="color:blue;">{!! isset($cartSale->location->city) ? $cartSale->location->city : '<span style="color:red;">Undefined</span>' !!}</span>
                                                </th>
                                                <th><i class="mdi mdi-phone"></i>State :<span
                                                        style="color:blue;">{!! isset($cartSale->location->state) ? $cartSale->location->state : '<span style="color:red;">Undefined</span>' !!}</span>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th><i class="mdi mdi-phone"></i> ZipCode : <span
                                                        style="color:blue;">{!! isset($cartSale->location->zipcode)
                                                            ? $cartSale->location->zipcode
                                                            : '<span style="color:red;">Undefined</span>' !!}</span>
                                                </th>
                                                <th><i class="mdi mdi-phone"></i> Country : <span
                                                        style="color:blue;">{!! isset($cartSale->location->country)
                                                            ? $cartSale->location->country
                                                            : '<span style="color:red;">Undefined</span>' !!}</span>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th colspan="2"><i class="mdi mdi-account-multiple"></i>
                                                    More
                                                    Info : <span style="color:blue;">{!! isset($cartSale->location->more_info)
                                                        ? $cartSale->location->more_info
                                                        : '<span style="color:red;">Undefined</span>' !!}</span>
                                                </th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>

                            <div class="mt-3 media profile-timeline-media">
                                <div class="media-body">

                                    {{-- ================================================= --}}
                                    {{-- ================== Order Details ================ --}}
                                    {{-- ================================================= --}}
                                    <h3 class="py-3 text-dark"><i class="mdi mdi-information"></i> Order
                                        Details :
                                    </h3>
                                    <table class="table table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th><span style="color:blue;">Image</th>
                                                <th><span style="color:blue;">Product</th>
                                                <th><span style="color:blue;">Quantity</th>
                                                <th><span style="color:blue;">Unit Price</th>
                                                <th><span style="color:blue;">Sub Total</th>
                                                {{-- <th><span style="color:blue;">Total</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
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
                                                            <img src="{{ asset('front_end_style/assets/images/logo.png') }}"
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
                                                    {{-- <td>{!! isset($cartOperation->quantity) && isset($cartOperation->unit_price)
                                                    ? $cartOperation->quantity * $cartOperation->unit_price +
                                                        ($cartOperation->quantity * $cartOperation->unit_price * 15) / 100 .
                                                        '<small> $</small>'
                                                    : '<span style="color: red;">Undefined</span>' !!}</td> --}}
                                                </tr>
                                            @endforeach
                                        <tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
