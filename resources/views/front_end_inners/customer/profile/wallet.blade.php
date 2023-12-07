@extends('front_end_inners.customer.profile.layout', ['title' => 'المحفظة'])

@section('user-content')
    <div class="container">
        <div class="row">
            <div class="col-12 ">
                <div class="heading-part heading-bg mb-30">
                    <h2 class="m-0 heading">
                        Wallet :
                        {{ auth('customer')->user()->wallet->ballance ?? 0 }} <small> JOD</small>
                    </h2>
                    <p class="m-0 heading">
                        Amount withdrawn :
                        <strong>
                            {{ auth('customer')->user()->wallet->amount_withdrawn ?? 0 }}JOD
                        </strong>
                    </p>
                </div>
            </div>
        </div>
        <div class="p-4 m-0" id="createWithdrawalRequest" >
            <div class="row mb-30">
                <div class="mb-20 col-12" style="background: rgba(0, 0, 0, 0.089)">
                    <div class="gap-3 heading-part d-flex align-items-center">
                        <h3 class="m-0 sub-heading">Request Wallet Withdrawal </h3>
                    </div>
                    <hr>
                </div>
                <div class="col-12">
                    <div class="cart-total-table address-box commun-table">
                        <form action="{{ route('customer.request_order.store', 'wallet') }}" method="POST"
                            class="p-2 mt-2 card">
                            @csrf
                            <div class="row">
                                <div class="mb-1 col-6">
                                    <label for="amount" class="form-label" style="font-size: 14px">
                                        Amount *
                                    </label>
                                    <input type="number" min="0" step="0.001"
                                        max=" {{ auth('customer')->user()->wallet->ballance ?? 0 }}" name="amount"
                                        value="{{ old('amount') }}" class="form-control form-control-sm"
                                        placeholder="amount" id="amount" required>
                                </div>
                                <div class="mb-1 col-6">
                                    <label for="phone" class="form-label" style="font-size: 14px">
                                        Phone Number *
                                    </label>
                                    <input type="text" name="phone" value="{{ old('phone') }}"
                                        class="form-control form-control-sm" placeholder="phone_number" id="phone"
                                        required>
                                </div>

                                <div class="mb-1 col-6">
                                    <div class="mb-20 input-box select-dropdown">
                                        <label for="payment_wallet" class="form-label" style="font-size: 14px">
                                            Payment Wallet*
                                        </label>
                                        <fieldset>
                                            <select id="payment_wallet" class="option-drop" name="payment_wallet_id"
                                                required>
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

            <div class="row mb-30">
                <div class="mb-20 col-12" style="background: rgba(0, 0, 0, 0.089)">
                    <div class="heading-part ">
                        <h4>or you can</h4>
                        <h3 class="m-0 sub-heading">Request Western Withdrawal </h3>
                    </div>
                    <hr>
                </div>
                <div class="col-12">
                    <div class="cart-total-table address-box commun-table">
                        <form action="{{ route('customer.request_order.store', 'western') }}" method="POST"
                            class="p-2 mt-2 card">
                            @csrf
                            <div class="row">

                                <div class="mb-1 col-6">
                                    <label for="name" class="form-label" style="font-size: 14px">
                                        Full name *
                                    </label>
                                    <input type="text" name="name" value="{{ old('name') }}"
                                        class="form-control form-control-sm" placeholder="name" id="name" required>
                                </div>


                                <div class="mb-1 col-6">
                                    <label for="phone" class="form-label" style="font-size: 14px">
                                        Phone Number *
                                    </label>
                                    <input type="text" name="phone" value="{{ old('phone') }}"
                                        class="form-control form-control-sm" placeholder="phone_number" id="phone"
                                        required>
                                </div>

                                <div class="mb-1 col-6">
                                    <label for="country" class="form-label" style="font-size: 14px">
                                        Country *
                                    </label>
                                    <input type="text" name="country" value="{{ old('country') }}"
                                        class="form-control form-control-sm" placeholder="country" id="country" required>
                                </div>

                                <div class="mb-1 col-6">
                                    <label for="city" class="form-label" style="font-size: 14px">
                                        City *
                                    </label>
                                    <input type="text" name="city" value="{{ old('city') }}"
                                        class="form-control form-control-sm" placeholder="city" id="city" required>
                                </div>

                                <div class="mb-1 col-6">
                                    <label for="amount" class="form-label" style="font-size: 14px">
                                        Amount *
                                    </label>
                                    <input type="number" min="0" step="0.001"
                                        max=" {{ auth('customer')->user()->wallet->ballance ?? 0 }}" name="amount"
                                        value="{{ old('amount') }}" class="form-control form-control-sm"
                                        placeholder="amount" id="amount" required>
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
    </div>
@endsection
