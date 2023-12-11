@extends('front_end_inners.customer.profile.layout', ['title' => __('front_end.profile_My_Order_List')])



@section('user-content')
    <div>
        <div id="form-print" class="admission-form-wrapper">
            <div class="row">
                <div class="col-12">
                    <div class="heading-part heading-bg mb-30">
                        <h2 class="m-0 heading">{{ __('front_end.profile_My_Orders') }}</h2>
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
                                        <th>{{ __('front_end.profile_Date_Time') }}</th>
                                        <th>{{ __('front_end.profile_Items') }}</th>
                                        <th>{{ __('front_end.profile_Status') }}</th>
                                        <th>{{ __('front_end.profile_Payment_Status') }}</th>
                                        <th>{{ __('front_end.profile_Delivery_Status') }}</th>
                                        <th>{{ __('front_end.profile_Sub_Total') }}</th>
                                        <th>{{ __('front_end.profile_Total') }}</th>
                                        <th>{{ __('front_end.profile_Show') }}</th>
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
                                                @if (isset($cartSale->status))
                                                    @if ($cartSale->status == 'Pendding')
                                                        <span class="badge badge-warning">{!! $cartSale->status !!}</span>
                                                    @elseif($cartSale->status == 'Accepted')
                                                        <span class="badge badge-success">{!! $cartSale->status !!}</span>
                                                    @elseif($cartSale->status == 'Rejected')
                                                        <span class="badge badge-danger">{!! $cartSale->status !!}</span>
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                @if (isset($cartSale->payment_status))
                                                    @if ($cartSale->payment_status == 'Pendding')
                                                        <span class="badge badge-warning">{!! $cartSale->payment_status !!}</span>
                                                    @elseif($cartSale->payment_status == 'Accepted')
                                                        <span class="badge badge-success">{!! $cartSale->payment_status !!}</span>
                                                    @elseif($cartSale->payment_status == 'Rejected')
                                                        <span class="badge badge-danger">{!! $cartSale->payment_status !!}</span>
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                @if (isset($cartSale->delivery_status))
                                                    @if ($cartSale->delivery_status == 'Pendding')
                                                        <span class="badge badge-warning">{!! $cartSale->delivery_status !!}</span>
                                                    @elseif($cartSale->delivery_status == 'Received')
                                                        <span class="badge badge-success">{!! $cartSale->delivery_status !!}</span>
                                                    @elseif($cartSale->delivery_status == 'Not Received')
                                                        <span class="badge badge-danger">{!! $cartSale->delivery_status !!}</span>
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                {{ $cartSale->sub_total }}
                                            </td>
                                            <td>
                                                {{ $cartSale->total }}
                                            </td>
                                            <td>
                                                <button class="p-1 btn btn-sm btn-secondary show_order" data-toggle="modal"
                                                    data-target="#exampleModalCenter{{ $cartSale->id }}"
                                                    data-id="{{ encrypt($cartSale->id) }}">
                                                    <i class="ecicon eci-info"></i>
                                                    {{ __('front_end.profile_Show') }}
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">{{ __('front_end.profile_No_Orders') }}
                                            </td>
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

    @foreach ($cartSales as $cartSale)
        <div class="modal fade" id="exampleModalCenter{{ $cartSale->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content" style="height: 100% !important; overflow: auto !important;">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">{{ __('front_end.profile_Order_Details') }}</h5>
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
                                    <h3 class="py-3 text-dark">
                                        <i class="mdi mdi-information"></i>
                                        {{ __('front_end.profile_Main_Order_Information') }} :
                                    </h3>
                                    <table class="table table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th><i class="mdi mdi-account"></i> {{ __('front_end.profile_Order_Id') }}:
                                                    <span style="color:blue;">{!! isset($cartSale->id) ? $cartSale->id : '<span style="color:red;">Undefined</span>' !!}</span>
                                                </th>

                                            </tr>
                                            <tr>
                                                <th><i class="mdi mdi-phone"></i> {{ __('front_end.profile_Status') }} :
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
                                                <th><i class="mdi mdi-phone"></i>
                                                    {{ __('front_end.profile_Payment_Status') }} :
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
                                                <th><i class="mdi mdi-phone"></i>
                                                    {{ __('front_end.profile_Delivery_Status') }} :
                                                    @if (isset($cartSale->delivery_status))
                                                        @if ($cartSale->delivery_status == 'Pendding')
                                                            <span
                                                                style="color:rgba(182, 121, 7, 0.87);">{!! $cartSale->delivery_status !!}</span>
                                                        @elseif($cartSale->delivery_status == 'Received')
                                                            <span style="color:green;">{!! $cartSale->delivery_status !!}</span>
                                                        @elseif($cartSale->delivery_status == 'Not Received')
                                                            <span style="color:red;">{!! $cartSale->delivery_status !!}</span>
                                                        @endif
                                                    @else
                                                        <span style="color:red;">Undefined</span>
                                                    @endif
                                                </th>
                                            </tr>
                                            <hr>
                                            <tr>
                                                <th><i class="mdi mdi-account"></i> {{ __('front_end.profile_Items') }} :
                                                    <span style="color:blue;">{!! isset($cartSale->product_count) ? $cartSale->product_count : '<span style="color:red;">Undefined</span>' !!}</span>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th><i class="mdi mdi-account"></i> {{ __('front_end.profile_Shipping') }}
                                                    : <span style="color:blue;">{!! isset($cartSale->shipping)
                                                        ? $cartSale->shipping . '<small> JOD</small>'
                                                        : '<span style="color:red;">Undefined</span>' !!}</span>
                                                </th>
                                                <th><i class="mdi mdi-account"></i> {{ __('front_end.profile_Tax') }} :
                                                    <span style="color:blue;">{!! isset($cartSale->tax) ? $cartSale->tax . '<small> JOD</small>' : '<span style="color:red;">Undefined</span>' !!}</span>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th><i class="mdi mdi-account"></i>
                                                    {{ __('front_end.profile_Website_percentage') }} :
                                                    <span style="color:blue;">{!! isset($cartSale->sale_percentage)
                                                        ? $cartSale->sale_percentage . '<small> JOD</small>'
                                                        : '<span style="color:red;">Undefined</span>' !!}</span>
                                                </th>
                                                <th><i class="mdi mdi-account"></i> {{ __('front_end.profile_Redeem') }} :
                                                    <span style="color:blue;">{!! isset($cartSale->redeem)
                                                        ? $cartSale->redeem . '<small> JOD</small>'
                                                        : '<span style="color:red;">Undefined</span>' !!}</span>
                                                </th>
                                            </tr>

                                            <tr>
                                                <th><i class="mdi mdi-account"></i> {{ __('front_end.profile_Sub_Total') }}
                                                    : <span style="color:blue;">{!! isset($cartSale->sub_total)
                                                        ? $cartSale->sub_total . '<small> JOD</small>'
                                                        : '<span style="color:red;">Undefined</span>' !!}</span>
                                                </th>
                                                <th><i class="mdi mdi-account"></i> {{ __('front_end.profile_Total') }} :
                                                    <span style="color:blue;">{!! isset($cartSale->total)
                                                        ? $cartSale->total . '<small> JOD</small>'
                                                        : '<span style="color:red;">Undefined</span>' !!}</span>
                                                </th>
                                            </tr>
                                            {{-- <tr>
                                        <th><i class="mdi mdi-email"></i> Promo Code : <span
                                                style="color:blue;">{!! isset($cartSale->promoCode->promo_code) ? $cartSale->promoCode->promo_code : '------' !!}</span></th>
                                        <th><i class="mdi mdi-email"></i> Discount : <span
                                                style="color:blue;">{!! isset($cartSale->discount) ? $cartSale->discount . '<small> JOD</small>' : '------' !!}</span></th>
                                    </tr> --}}

                                            <tr>
                                                <th><i class="mdi mdi-phone"></i>
                                                    {{ __('front_end.profile_Customer_Name') }} : <span
                                                        style="color:blue;">{!! isset($cartSale->customer->name_en)
                                                            ? $cartSale->customer->name_en
                                                            : '<span style="color:red;">Undefined</span>' !!}</span>
                                                </th>
                                                <th><i class="mdi mdi-account-multiple"></i>
                                                    {{ __('front_end.profile_Customer_Email') }}
                                                    :
                                                    <span style="color:blue;">{!! isset($cartSale->customer->email) ? $cartSale->customer->email : '<span style="color:red;">Undefined</span>' !!}</span>
                                                </th>

                                            </tr>
                                            <tr>
                                                <th><i class="mdi mdi-phone"></i>
                                                    {{ __('front_end.profile_Customer_Phone') }} : <span
                                                        style="color:blue;">{!! isset($cartSale->customer->phone) ? $cartSale->customer->phone : '<span style="color:red;">Undefined</span>' !!}</span>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th><i class="mdi mdi-clock-outline mdi-spin"></i>
                                                    {{ __('front_end.profile_Order_Added_Since') }} :
                                                    <span style="color:blue;">{!! isset($cartSale->created_at)
                                                        ? $cartSale->created_at->diffForHumans()
                                                        : '<span style="color:red;">Undefined</span>' !!}
                                                    </span>
                                                </th>
                                                <th><i class="mdi mdi-clock-outline mdi-spin"></i>
                                                    {{ __('front_end.profile_Date_Time_of_Addtion') }} :
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
                                        {{ __('front_end.profile_Delivery_Information') }} :
                                    </h3>
                                    <table class="table table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th><i class="mdi mdi-account"></i> {{ __('front_end.profile_Name') }} :
                                                    <span style="color:blue;">{!! isset($cartSale->location->name) ? $cartSale->location->name : '<span style="color:red;">Undefined</span>' !!}</span>
                                                </th>
                                                <th><i class="mdi mdi-account"></i> {{ __('front_end.contact_Email') }} :
                                                    <span style="color:blue;">{!! isset($cartSale->location->email) ? $cartSale->location->email : '<span style="color:red;">Undefined</span>' !!}</span>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th><i class="mdi mdi-account"></i> {{ __('front_end.profile_Phone') }} :
                                                    <span style="color:blue;">{!! isset($cartSale->location->phone) ? $cartSale->location->phone : '<span style="color:red;">Undefined</span>' !!}</span>
                                                </th>
                                                <th><i class="mdi mdi-account"></i>
                                                    {{ __('front_end.register_Company_Name') }} : <span
                                                        style="color:blue;">{!! isset($cartSale->location->company)
                                                            ? $cartSale->location->company
                                                            : '<span style="color:red;">Undefined</span>' !!}</span>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th><i class="mdi mdi-email"></i> {{ __('front_end.profile_city') }} :
                                                    <span style="color:blue;">{!! isset($cartSale->location->city) ? $cartSale->location->city : '<span style="color:red;">Undefined</span>' !!}</span>
                                                </th>
                                                <th><i class="mdi mdi-email"></i> {{ __('front_end.home_Address') }} :
                                                    <span style="color:blue;">{!! isset($cartSale->location->address) ? $cartSale->location->address : '------' !!}</span>
                                                </th>

                                            </tr>
                                            <tr>
                                                <th><i class="mdi mdi-phone"></i> {{ __('front_end.profile_Zip_Code') }} :
                                                    <span style="color:blue;">{!! isset($cartSale->location->zipcode)
                                                        ? $cartSale->location->zipcode
                                                        : '<span style="color:red;">Undefined</span>' !!}</span>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th colspan="2"><i class="mdi mdi-account-multiple"></i>
                                                    {{ __('front_end.home_More_Info') }} : <span
                                                        style="color:blue;">{!! isset($cartSale->location->more_info)
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
                                    <h3 class="py-3 text-dark"><i class="mdi mdi-information"></i>
                                        {{ __('front_end.profile_Order_Details') }} :
                                    </h3>
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th><span style="color:blue;">{{ __("front_end.profile_image") }}</th>
                                                    <th><span style="color:blue;">{{ __('front_end.product_product') }}
                                                    </th>
                                                    <th><span style="color:blue;">{{ __('front_end.profile_Items') }}</th>
                                                    <th><span style="color:blue;">{{ __('front_end.profile_unit_price') }}
                                                    </th>
                                                    <th><span
                                                            style="color:blue;">{{ __('front_end.profile_Out_Sale_Price') }}
                                                    </th>
                                                    <th><span style="color:blue;">{{ __('front_end.profile_Sub_Total') }}
                                                    </th>
                                                    <th><span style="color:blue;">{{ __('front_end.profile_Total') }}</th>
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
                                                            ? $cartOperation->unit_price . '<small> JOD</small>'
                                                            : '<span style="color: red;">Undefined</span>' !!}</td>
                                                        <td>{!! isset($cartOperation->out_sale_price)
                                                            ? $cartOperation->out_sale_price . '<small> JOD</small>'
                                                            : '<span style="color: red;">Undefined</span>' !!}</td>
                                                        <td>
                                                            {{ $cartOperation->sub_total ?? '<span style="color: red;">Undefined</span>' }}
                                                        </td>
                                                        <td>
                                                            {{ $cartOperation->total ?? '<span style="color: red;">Undefined</span>' }}
                                                        </td>

                                                        {{-- <td>{!! isset($cartOperation->quantity) && isset($cartOperation->unit_price)
                                                        ? $cartOperation->quantity * $cartOperation->unit_price +
                                                            ($cartOperation->quantity * $cartOperation->unit_price * 15) / 100 .
                                                            '<small> JOD</small>'
                                                        : '<span style="color: red;">Undefined</span>' !!}</td> --}}
                                                    </tr>
                                                @endforeach
                                            <tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __("front_end.prodile_close") }}</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
