@extends('front_end_inners.customer.profile.layout')

@section('content')
    <div id="data-step1" class="account-content" data-temp="tabdata">
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
                        From your account dashboard. you can easily check &amp; view your recent orders,
                        manage your shipping and billing addresses and edit your password and account
                        details.
                    </p>
                </div>
            </div>
        </div>
        <div class="m-0">
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
                        <form action="{{ route('createAddress.profile') }}" method="post" class="p-2 mt-2 card"
                            id="createAddressForm">
                            @csrf
                            <div class="row">
                                <div class="mb-1 col-6">
                                    <label for="name" class="form-label" style="font-size: 14px">
                                        name*
                                    </label>
                                    <input type="text" name="name" value="{{ old('name') }}"
                                        class="form-control form-control-sm" placeholder="name" id="name" required>
                                </div>
                                <div class="mb-1 col-6">
                                    <label for="email" class="form-label" style="font-size: 14px">
                                        email
                                    </label>
                                    <input type="email" name="email" value="{{ old('email') }}"
                                        class="form-control form-control-sm" placeholder="email" id="email">
                                </div>
                                <div class="mb-1 col-6">
                                    <label for="phone" class="form-label" style="font-size: 14px">
                                        phone
                                    </label>
                                    <input type="text" name="phone" value="{{ old('phone') }}"
                                        class="form-control form-control-sm" placeholder="phone" id="phone" required>
                                </div>
                                <div class="mb-1 col-6">
                                    <label for="company" class="form-label" style="font-size: 14px">
                                        company
                                    </label>
                                    <input type="text" name="company" value="{{ old('company') }}"
                                        class="form-control form-control-sm" placeholder="company" id="company">
                                </div>
                                <div class="mb-1 col-6">
                                    <label for="address" class="form-label" style="font-size: 14px">
                                        address*
                                    </label>
                                    <input type="text" name="address" value="{{ old('address') }}"
                                        class="form-control form-control-sm" placeholder="address" id="address" required>
                                </div>
                                <div class="mb-1 col-6">
                                    <label for="apartment" class="form-label" style="font-size: 14px">
                                        apartment
                                    </label>
                                    <input type="text" name="apartment" value="{{ old('apartment') }}"
                                        class="form-control form-control-sm" placeholder="apartment" id="apartment">
                                </div>
                                <div class="mb-1 col-6">
                                    <label for="city" class="form-label" style="font-size: 14px">
                                        city*
                                    </label>
                                    <input type="text" name="city" value="{{ old('city') }}"
                                        class="form-control form-control-sm" placeholder="city" id="city" required>
                                </div>
                                <div class="mb-1 col-6">
                                    <label for="state" class="form-label" style="font-size: 14px">
                                        state*
                                    </label>
                                    <input type="text" name="state" value="{{ old('state') }}"
                                        class="form-control form-control-sm" placeholder="state" id="state" required>
                                </div>
                                <div class="mb-1 col-6">
                                    <label for="country" class="form-label" style="font-size: 14px">
                                        country*
                                    </label>
                                    <input type="text" name="country" value="{{ old('country') }}"
                                        class="form-control form-control-sm" placeholder="country" id="country"
                                        required>
                                </div>
                                <div class="mb-1 col-6">
                                    <label for="zipcode" class="form-label" style="font-size: 14px">
                                        zipcode
                                    </label>
                                    <input type="text" name="zipcode" value="{{ old('zipcode') }}"
                                        class="form-control form-control-sm" placeholder="zipcode" id="zipcode">
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
                                <button type="submit" class="p-2 btn btn-sm btn-success">save</button>
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

            <div class="my-4 row">
                <div class="mb-20 col-12">
                    <div class="gap-3 heading-part d-flex align-items-center">
                        <h3 class="m-0 sub-heading">Account Inforamtion</h3>
                    </div>
                    <hr>
                </div>
                <div class="col-12">
                    <div class="cart-total-table address-box commun-table">
                        <form action="{{ route('customer-update.profile', auth('customer')->user()->id) }}"
                            method="post" class="p-2 mt-2 card" id="createAddressForm">
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
                                        class="form-control form-control-sm" id="email" disabled required>
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
                                    <input type="password" name="password" class="form-control form-control-sm"
                                        id="password">
                                </div>

                                <div class="mb-1 col-6">
                                    <label for="password_confirmation" class="form-label" style="font-size: 14px">
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
@endsection


@push('scripts')
    <script>
        $('#createAddressForm').hide();
        $('.editAddressForm').hide();

        $('.editAddress').on('click', function() {
            let id = $(this).attr('id');
            $(`#updateAddressForm${id}`).slideToggle();
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
