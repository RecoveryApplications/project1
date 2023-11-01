@extends('front_end_inners.app_front_end', ['title' => 'الصفحة الرئيسية'])


@php
    $image_url = asset('images/Userprofile.png');
@endphp
@push('styles')
    <style>
        .input-text.qty {
            width: 100% !important;
            border-radius: 20px !important;
            max-width: 80px !important;
        }

        .inner-banner1 {
            background: url({{ $image_url }}) no-repeat scroll center center;
            padding: 60px 0;
        }
    </style>
@endpush

@section('content')
    <!-- Bread Crumb STRAT -->
    <div class="banner inner-banner1 ">
        <div class="container">
            <section class="banner-detail center-xs">
                <h1 class="banner-title">Account</h1>
                <div class="bread-crumb right-side float-none-xs">
                    <ul>
                        <li><a href="{{ route('welcome') }}">Home</a>/</li>
                        <li><span>Account</span></li>
                    </ul>
                </div>
            </section>
        </div>
    </div>
    <!-- Bread Crumb END -->
    {{-- @php
        dd(auth('customer')->user()->cartSales);
    @endphp --}}
    <!-- CONTAIN START -->
    <section class="checkout-section ptb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="account-sidebar account-tab mb-sm-30">
                        <div class="dark-bg tab-title-bg">
                            <div class="heading-part">
                                <div class="sub-title"><span></span> My Account</div>
                            </div>
                        </div>
                        <div class="account-tab-inner">
                            <ul class="account-tab-stap">
                                <li id="step1" class="active"> <a href="javascript:void(0)">My Dashboard<i
                                            class="fa fa-angle-right"></i> </a> </li>
                                <li id="step3"> <a href="javascript:void(0)">My Order List<i
                                            class="fa fa-angle-right"></i> </a> </li>

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div id="data-step1" class="account-content" data-temp="tabdata">
                        <div class="row">
                            <div class="col-12">
                                <div class="gap-5 py-2 heading-part heading-bg mb-30 d-flex bg-secondary">
                                    <div class="d-flex flex-column">
                                        <h3 class="p-2 m-0 text-white rounded heading ">Wallet :
                                            {{ auth('customer')->user()->wallet->ballance ?? 0 }} <small> JOD</small> </h3>
                                        <p class="p-2 m-0 text-white rounded heading ">Amount withdrawn :
                                            <strong>{{ auth('customer')->user()->wallet->amount_withdrawn ?? 0 }}
                                                JOD</strong>
                                        </p>

                                    </div>
                                    <button class="p-1 ml-0 ml-md-5 btn btn-sm btn-secondary"
                                        style="font-size: 14px; text-decoration: underline" id="requestWithdrawalBtn">
                                        Request Withdrawal
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="m-0" id="createWithdrawalRequest">
                            <div class="row mb-30">
                                <div class="mb-20 col-12">
                                    <div class="gap-3 heading-part d-flex align-items-center">
                                        <h3 class="m-0 sub-heading">Request Withdrawal </h3>
                                    </div>
                                    <hr>
                                </div>
                                <div class="col-12">
                                    <div class="cart-total-table address-box commun-table">
                                        <form action="{{ route('customer.request_order.store') }}" method="POST"
                                            class="p-2 mt-2 card">
                                            @csrf
                                            <div class="row">
                                                <div class="mb-1 col-6">
                                                    <label for="amount" class="form-label" style="font-size: 14px">
                                                        Amount *
                                                    </label>
                                                    <input type="number" min="0" step="0.001"
                                                        max=" {{ auth('customer')->user()->wallet->ballance ?? 0 }}"
                                                        name="amount" value="{{ old('amount') }}"
                                                        class="form-control form-control-sm" placeholder="amount"
                                                        id="amount" required>
                                                </div>
                                                <div class="mb-1 col-6">
                                                    <label for="phone" class="form-label" style="font-size: 14px">
                                                        Phone Number *
                                                    </label>
                                                    <input type="text" name="phone" value="{{ old('phone') }}"
                                                        class="form-control form-control-sm" placeholder="phone_number"
                                                        id="phone" required>
                                                </div>

                                                <div class="mb-1 col-6">
                                                    <div class="mb-20 input-box select-dropdown">
                                                        <label for="payment_wallet" class="form-label"
                                                            style="font-size: 14px">
                                                            Payment Wallet*
                                                        </label>
                                                        <fieldset>
                                                            <select id="payment_wallet" class="option-drop"
                                                                name="payment_wallet_id" required>
                                                                <option value="">Select payment wallet ...</option>
                                                                @foreach ($payment_wallets as $wallet)
                                                                    <option value="{{ $wallet->id }}">
                                                                        {{ $wallet->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-3 text-center">
                                                <button type="submit" class="p-2 btn btn-sm btn-success">
                                                    request
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="heading-part heading-bg mb-30">
                                    <h2 class="m-0 heading">Account Dashboard</h2>
                                </div>
                            </div>
                        </div>
                        <div class="mb-30">
                            <div class="row">
                                <div class="col-12">
                                    <div class="heading-part">
                                        <h3 class="sub-heading">Hello, {{ auth('customer')->user()->name_en }}</h3>
                                    </div>
                                    <p>
                                        From your account dashboard. you can easily check &amp; view your recent orders and
                                        edit your password and account
                                        details.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="m-0">
                            {{-- //NOTE - remove if condition if rami asked to make addreses in the profile page --}}
                            @if (1 == 2)
                                <div class="row mb-30">
                                    <div class="mb-20 col-12">
                                        <div class="gap-3 heading-part d-flex align-items-center">
                                            <h3 class="m-0 sub-heading">Addresses</h3>
                                            <button class="p-2 ml-3 btn btn-sm btn-success" id="addAddress">+</button>
                                        </div>
                                        <hr>
                                    </div>
                                    <div class="col-12">
                                        <div class="cart-total-table address-box commun-table">
                                            <form action="{{ route('createAddress.profile') }}" method="post"
                                                class="p-2 mt-2 card" id="createAddressForm">
                                                @csrf
                                                <div class="row">
                                                    <div class="mb-1 col-6">
                                                        <label for="name" class="form-label" style="font-size: 14px">
                                                            name*
                                                        </label>
                                                        <input type="text" name="name" value="{{ old('name') }}"
                                                            class="form-control form-control-sm" placeholder="name"
                                                            id="name" required>
                                                    </div>
                                                    <div class="mb-1 col-6">
                                                        <label for="email" class="form-label" style="font-size: 14px">
                                                            email
                                                        </label>
                                                        <input type="email" name="email" value="{{ old('email') }}"
                                                            class="form-control form-control-sm" placeholder="email"
                                                            id="email">
                                                    </div>
                                                    <div class="mb-1 col-6">
                                                        <label for="phone" class="form-label" style="font-size: 14px">
                                                            phone
                                                        </label>
                                                        <input type="text" name="phone" value="{{ old('phone') }}"
                                                            class="form-control form-control-sm" placeholder="phone"
                                                            id="phone" required>
                                                    </div>
                                                    <div class="mb-1 col-6">
                                                        <label for="company" class="form-label" style="font-size: 14px">
                                                            company
                                                        </label>
                                                        <input type="text" name="company"
                                                            value="{{ old('company') }}"
                                                            class="form-control form-control-sm" placeholder="company"
                                                            id="company">
                                                    </div>
                                                    <div class="mb-1 col-6">
                                                        <label for="address" class="form-label" style="font-size: 14px">
                                                            address*
                                                        </label>
                                                        <input type="text" name="address"
                                                            value="{{ old('address') }}"
                                                            class="form-control form-control-sm" placeholder="address"
                                                            id="address" required>
                                                    </div>
                                                    <div class="mb-1 col-6">
                                                        <label for="apartment" class="form-label"
                                                            style="font-size: 14px">
                                                            apartment
                                                        </label>
                                                        <input type="text" name="apartment"
                                                            value="{{ old('apartment') }}"
                                                            class="form-control form-control-sm" placeholder="apartment"
                                                            id="apartment">
                                                    </div>
                                                    <div class="mb-1 col-6">
                                                        <label for="city" class="form-label" style="font-size: 14px">
                                                            city*
                                                        </label>
                                                        <input type="text" name="city" value="{{ old('city') }}"
                                                            class="form-control form-control-sm" placeholder="city"
                                                            id="city" required>
                                                    </div>
                                                    <div class="mb-1 col-6">
                                                        <label for="state" class="form-label" style="font-size: 14px">
                                                            state*
                                                        </label>
                                                        <input type="text" name="state" value="{{ old('state') }}"
                                                            class="form-control form-control-sm" placeholder="state"
                                                            id="state" required>
                                                    </div>
                                                    <div class="mb-1 col-6">
                                                        <label for="country" class="form-label" style="font-size: 14px">
                                                            country*
                                                        </label>
                                                        <input type="text" name="country"
                                                            value="{{ old('country') }}"
                                                            class="form-control form-control-sm" placeholder="country"
                                                            id="country" required>
                                                    </div>
                                                    <div class="mb-1 col-6">
                                                        <label for="zipcode" class="form-label" style="font-size: 14px">
                                                            zipcode
                                                        </label>
                                                        <input type="text" name="zipcode"
                                                            value="{{ old('zipcode') }}"
                                                            class="form-control form-control-sm" placeholder="zipcode"
                                                            id="zipcode">
                                                    </div>
                                                    <div class="mb-1 col-12">
                                                        <label for="zipcode" class="form-label" style="font-size: 14px">
                                                            more info
                                                        </label>
                                                        <textarea name="more_info" id="more_info" cols="30" rows="3" class="form-control form-control-sm"
                                                            placeholder="more info">{{ old('more_info') }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="mt-3 text-center">
                                                    <button type="submit"
                                                        class="p-2 btn btn-sm btn-success">save</button>
                                                </div>
                                            </form>
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>name</th>
                                                            <th>email</th>
                                                            <th>phone</th>
                                                            <th>company</th>
                                                            <th>address</th>
                                                            <th>apartment</th>
                                                            <th>city</th>
                                                            <th>state</th>
                                                            <th>country</th>
                                                            <th>zipcode</th>
                                                            <th>more info</th>
                                                            <th>action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse (auth('customer')->user()->locations as $location)
                                                            <tr>
                                                                <td>{{ $location->name ?? '-' }}</td>
                                                                <td>{{ $location->email ?? '-' }}</td>
                                                                <td>{{ $location->phone ?? '-' }}</td>
                                                                <td>{{ $location->company ?? '-' }}</td>
                                                                <td>{{ $location->address ?? '-' }}</td>
                                                                <td>{{ $location->apartment ?? '-' }}</td>
                                                                <td>{{ $location->city ?? '-' }}</td>
                                                                <td>{{ $location->state ?? '-' }}</td>
                                                                <td>{{ $location->country ?? '-' }}</td>
                                                                <td>{{ $location->zipcode ?? '-' }}</td>
                                                                <td>{{ $location->more_info ?? '-' }}</td>
                                                                <td class="d-flex align-items-center">
                                                                    <a href="{{ route('address-destroy', $location->id) }}"
                                                                        class="p-1 text-white btn btn-danger">
                                                                        <i title="Remove Address" data-id="100"
                                                                            class="fa fa-trash deleteAddressBtn"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="12" class="text-center">No Addresses</td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="my-4 row">
                                <div class="mb-20 col-12">
                                    <div class="gap-3 heading-part d-flex align-items-center">
                                        <h3 class="m-0 sub-heading">Account Inforamtion</h3>
                                    </div>
                                    <hr>
                                </div>
                                <div class="col-12">
                                    <div class="cart-total-table address-box commun-table">
                                        <form
                                            action="{{ route('customer-update.profile', auth('customer')->user()->id) }}"
                                            method="post" class="p-2 mt-2 card">
                                            @csrf
                                            <div class="row">
                                                <div class="mb-1 col-6">
                                                    <label for="name" class="form-label" style="font-size: 14px">
                                                        Full Name*
                                                    </label>
                                                    <input type="text" name="name_en"
                                                        value="{{ old('name_en', auth('customer')->user()->name_en) }}"
                                                        class="form-control form-control-sm" id="full name" required>
                                                </div>

                                                <div class="mb-1 col-6">
                                                    <label for="username" class="form-label" style="font-size: 14px">
                                                        User Name*
                                                    </label>
                                                    <input type="text" name="username"
                                                        value="{{ old('username', auth('customer')->user()->username) }}"
                                                        class="form-control form-control-sm" id="username" required>
                                                </div>

                                                <div class="mb-1 col-6">
                                                    <label for="company_name" class="form-label" style="font-size: 14px">
                                                        Company Name
                                                    </label>
                                                    <input type="text" name="company_name"
                                                        value="{{ old('company_name', auth('customer')->user()->company_name) }}"
                                                        class="form-control form-control-sm" id="company_name">
                                                </div>

                                                <div class="mb-1 col-6">
                                                    <label for="email" class="form-label" style="font-size: 14px">
                                                        Email*
                                                    </label>
                                                    <input type="email" name="email"
                                                        value="{{ old('email', auth('customer')->user()->email) }}"
                                                        class="form-control form-control-sm" id="email" disabled
                                                        required>
                                                </div>

                                                <div class="mb-1 col-6">
                                                    <label for="phone" class="form-label" style="font-size: 14px">
                                                        Phone*
                                                    </label>
                                                    <input type="text" name="phone"
                                                        value="{{ old('phone', auth('customer')->user()->phone) }}"
                                                        class="form-control form-control-sm" id="phone" required>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="mb-1 col-6">
                                                    <label for="password" class="form-label" style="font-size: 14px">
                                                        Password
                                                    </label>
                                                    <input type="password" name="password"
                                                        class="form-control form-control-sm" id="password">
                                                </div>

                                                <div class="mb-1 col-6">
                                                    <label for="password_confirmation" class="form-label"
                                                        style="font-size: 14px">
                                                        Confirm Password
                                                    </label>
                                                    <input type="password" name="password_confirmation"
                                                        class="form-control form-control-sm" id="password_confirmation">
                                                </div>
                                            </div>


                                            <div class="mt-3 text-center">
                                                <button type="submit" class="p-2 btn btn-sm btn-success">Update</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

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
                                                        <th>Sub Total</th>
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
                                                                {{ $cartSale->sub_total }}
                                                            </td>
                                                            <td>
                                                                {{ $cartSale->total }}
                                                            </td>
                                                            <td><button class="p-1 btn btn-sm btn-secondary show_order"
                                                                    data-toggle="modal"
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
                    <div id="data-step4" class="account-content" data-temp="tabdata" style="display:none">
                        <div class="row">
                            <div class="col-12">
                                <div class="heading-part heading-bg mb-30">
                                    <h2 class="m-0 heading">Change Password</h2>
                                </div>
                            </div>
                        </div>
                        <form class="main-form full">
                            <div class="row">
                                <div class="col-12">
                                    <div class="input-box">
                                        <label for="old-pass">Old-Password</label>
                                        <input type="password" placeholder="Old Password" required id="old-pass">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-box">
                                        <label for="login-pass">Password</label>
                                        <input type="password" placeholder="Enter your Password" required
                                            id="login-pass">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-box">
                                        <label for="re-enter-pass">Re-enter Password</label>
                                        <input type="password" placeholder="Re-enter your Password" required
                                            id="re-enter-pass">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn-color" type="submit" name="submit">Change Password</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    @foreach ($cartSales as $cartSale)
                        <div class="modal fade" id="exampleModalCenter{{ $cartSale->id }}" tabindex="-1"
                            role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                                                    <h3 class="py-3 text-dark">
                                                        <i class="mdi mdi-information"></i>
                                                        Main Order Information :
                                                    </h3>
                                                    <table class="table table-hover table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th><i class="mdi mdi-account"></i> Order ID: <span
                                                                        style="color:blue;">{!! isset($cartSale->id) ? $cartSale->id : '<span style="color:red;">Undefined</span>' !!}</span>
                                                                </th>

                                                            </tr>
                                                            <tr>
                                                                <th><i class="mdi mdi-phone"></i> Order Status :
                                                                    @if (isset($cartSale->status))
                                                                        @if ($cartSale->status == 'Pendding')
                                                                            <span
                                                                                style="color:rgba(182, 121, 7, 0.87);">{!! $cartSale->status !!}</span>
                                                                        @elseif($cartSale->status == 'Accepted')
                                                                            <span
                                                                                style="color:green;">{!! $cartSale->status !!}</span>
                                                                        @elseif($cartSale->status == 'Rejected')
                                                                            <span
                                                                                style="color:red;">{!! $cartSale->status !!}</span>
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
                                                                            <span
                                                                                style="color:green;">{!! $cartSale->payment_status !!}</span>
                                                                        @elseif($cartSale->payment_status == 'Rejected')
                                                                            <span
                                                                                style="color:red;">{!! $cartSale->payment_status !!}</span>
                                                                        @endif
                                                                    @else
                                                                        <span>------</span>
                                                                    @endif
                                                                </th>
                                                            </tr>
                                                            <tr>
                                                                <th><i class="mdi mdi-phone"></i> Delivery Status :
                                                                    @if (isset($cartSale->delivery_status))
                                                                        @if ($cartSale->delivery_status == 'Pendding')
                                                                            <span
                                                                                style="color:rgba(182, 121, 7, 0.87);">{!! $cartSale->delivery_status !!}</span>
                                                                        @elseif($cartSale->delivery_status == 'Received')
                                                                            <span
                                                                                style="color:green;">{!! $cartSale->delivery_status !!}</span>
                                                                        @elseif($cartSale->delivery_status == 'Not Received')
                                                                            <span
                                                                                style="color:red;">{!! $cartSale->delivery_status !!}</span>
                                                                        @endif
                                                                    @else
                                                                        <span style="color:red;">Undefined</span>
                                                                    @endif
                                                                </th>
                                                            </tr>
                                                            <hr>
                                                            <tr>
                                                                <th><i class="mdi mdi-account"></i> Number Of Products :
                                                                    <span
                                                                        style="color:blue;">{!! isset($cartSale->product_count) ? $cartSale->product_count : '<span style="color:red;">Undefined</span>' !!}</span>
                                                                </th>
                                                            </tr>
                                                            <tr>
                                                                <th><i class="mdi mdi-account"></i> Shipping : <span
                                                                        style="color:blue;">{!! isset($cartSale->shipping)
                                                                            ? $cartSale->shipping . '<small> JOD</small>'
                                                                            : '<span style="color:red;">Undefined</span>' !!}</span>
                                                                </th>
                                                                <th><i class="mdi mdi-account"></i> Tax : <span
                                                                        style="color:blue;">{!! isset($cartSale->tax) ? $cartSale->tax . '<small> JOD</small>' : '<span style="color:red;">Undefined</span>' !!}</span>
                                                                </th>
                                                            </tr>
                                                            <tr>
                                                                <th><i class="mdi mdi-account"></i> Website percentage :
                                                                    <span
                                                                        style="color:blue;">{!! isset($cartSale->sale_percentage)
                                                                            ? $cartSale->sale_percentage . '<small> JOD</small>'
                                                                            : '<span style="color:red;">Undefined</span>' !!}</span>
                                                                </th>
                                                                <th><i class="mdi mdi-account"></i> Redeem : <span
                                                                        style="color:blue;">{!! isset($cartSale->redeem)
                                                                            ? $cartSale->redeem . '<small> JOD</small>'
                                                                            : '<span style="color:red;">Undefined</span>' !!}</span>
                                                                </th>
                                                            </tr>

                                                            <tr>
                                                                <th><i class="mdi mdi-account"></i> Sub Total : <span
                                                                        style="color:blue;">{!! isset($cartSale->sub_total)
                                                                            ? $cartSale->sub_total . '<small> JOD</small>'
                                                                            : '<span style="color:red;">Undefined</span>' !!}</span>
                                                                </th>
                                                                <th><i class="mdi mdi-account"></i> Total : <span
                                                                        style="color:blue;">{!! isset($cartSale->total)
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
                                                                <th><i class="mdi mdi-phone"></i> Customer Name : <span
                                                                        style="color:blue;">{!! isset($cartSale->customer->name_en)
                                                                            ? $cartSale->customer->name_en
                                                                            : '<span style="color:red;">Undefined</span>' !!}</span>
                                                                </th>
                                                                <th><i class="mdi mdi-phone"></i> Shipment Num. :
                                                                    @if (isset($cartSale->track_number))
                                                                        <span
                                                                            style="color:blue;">{!! $cartSale->track_number !!}</span>
                                                                    @else
                                                                        <span>------</span>
                                                                    @endif
                                                                </th>
                                                            </tr>
                                                            <tr>
                                                                <th><i class="mdi mdi-account-multiple"></i> Customer Email
                                                                    :
                                                                    <span
                                                                        style="color:blue;">{!! isset($cartSale->customer->email) ? $cartSale->customer->email : '<span style="color:red;">Undefined</span>' !!}</span>
                                                                </th>
                                                                <th><i class="mdi mdi-phone"></i> Customer Phone : <span
                                                                        style="color:blue;">{!! isset($cartSale->customer->phone) ? $cartSale->customer->phone : '<span style="color:red;">Undefined</span>' !!}</span>
                                                                </th>
                                                            </tr>
                                                            <tr>
                                                                <th><i class="mdi mdi-clock-outline mdi-spin"></i> Order
                                                                    Added
                                                                    Since : <span
                                                                        style="color:blue;">{!! isset($cartSale->created_at)
                                                                            ? $cartSale->created_at->diffForHumans()
                                                                            : '<span style="color:red;">Undefined</span>' !!}</span>
                                                                </th>
                                                                <th><i class="mdi mdi-clock-outline mdi-spin"></i> Date &
                                                                    Time
                                                                    of
                                                                    Addtion :
                                                                    <span
                                                                        style="color:blue;">{!! isset($cartSale->created_at)
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
                                                                <th><i class="mdi mdi-email"></i> City : <span
                                                                        style="color:blue;">{!! isset($cartSale->location->city) ? $cartSale->location->city : '<span style="color:red;">Undefined</span>' !!}</span>
                                                                </th>
                                                                <th><i class="mdi mdi-email"></i> Address : <span
                                                                        style="color:blue;">{!! isset($cartSale->location->address) ? $cartSale->location->address : '------' !!}</span>
                                                                </th>

                                                            </tr>
                                                            <tr>
                                                                <th><i class="mdi mdi-email"></i> Apt/Unit/Suite/etc. :
                                                                    <span
                                                                        style="color:blue;">{!! isset($cartSale->location->apartment) ? $cartSale->location->apartment : '------' !!}</span>
                                                                </th>
                                                                <th><i class="mdi mdi-phone"></i> ZipCode : <span
                                                                        style="color:blue;">{!! isset($cartSale->location->zipcode)
                                                                            ? $cartSale->location->zipcode
                                                                            : '<span style="color:red;">Undefined</span>' !!}</span>
                                                                </th>
                                                            </tr>
                                                            <tr>
                                                                <th colspan="2"><i
                                                                        class="mdi mdi-account-multiple"></i>
                                                                    More
                                                                    Info : <span
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
                                                    <h3 class="py-3 text-dark"><i class="mdi mdi-information"></i> Order
                                                        Details :
                                                    </h3>
                                                    <div class="table-responsive">
                                                        <table class="table table-hover table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th><span style="color:blue;">Image</th>
                                                                    <th><span style="color:blue;">Product</th>
                                                                    <th><span style="color:blue;">Quantity</th>
                                                                    <th><span style="color:blue;">Unit Price</th>
                                                                    <th><span style="color:blue;">Out Sale Price</th>
                                                                    <th><span style="color:blue;">Sub Total</th>
                                                                    <th><span style="color:blue;">Total</th>
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
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <hr>
    <!-- CONTAINER END -->
@endsection

@push('scripts')
    <script>
        $('#createWithdrawalRequest').hide();
        $('#createAddressForm').hide();
        $('.editAddressForm').hide();

        $('.editAddress').on('click', function() {
            let id = $(this).attr('id');
            $(`#updateAddressForm${id}`).slideToggle();
        });

        $('#requestWithdrawalBtn').on('click', function() {
            $('#createWithdrawalRequest').slideToggle();
        });
        $('#addAddress').on('click', function() {
            $('#createAddressForm').slideToggle();
        });

        $('.deleteAddressBtn').on('click', function() {
            // console.log($(this).attr('id'))
            $(this).next('form').submit();
        })
    </script>
@endpush
