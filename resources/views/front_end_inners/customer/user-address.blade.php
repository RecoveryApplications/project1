@extends('front_end_inners.app_front_end', ['title' => 'الصفحة الرئيسية'])



@section('admin_css')
    <link href="{{ asset('dashboard_files/assets/plugins/data-tables/datatables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard_files/assets/css/sleek.min.css') }}">
@endsection


@section('content')
    <!-- Ec breadcrumb start -->
    <div class="sticky-header-next-sec  ec-breadcrumb section-space-mb">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row ec_breadcrumb_inner">
                        <div class="col-md-6 col-sm-12">
                            <h2 class="ec-breadcrumb-title">User Profile</h2>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <!-- ec-breadcrumb-list start -->
                            <ul class="ec-breadcrumb-list">
                                <li class="ec-breadcrumb-item"><a href="{{route('welcome')}}">Home</a></li>
                                <li class="ec-breadcrumb-item active">Profile</li>
                            </ul>
                            <!-- ec-breadcrumb-list end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Ec breadcrumb end -->

    <!-- User profile section -->
    <section class="ec-page-content ec-vendor-uploads ec-user-account section-space-p">
        <div class="container">
            <div class="row">
                <!-- Sidebar Area Start -->
                <div class="ec-shop-leftside ec-vendor-sidebar col-lg-3 col-md-12">
                    <div class="ec-sidebar-wrap">
                        <!-- Sidebar Category Block -->
                        <div class="ec-sidebar-block">
                            <div class="ec-vendor-block">

                                <div class="ec-vendor-block-items">
                                    <ul>
                                        <li><a href="{{ route('customer.profile') }}">Update Profile</a></li>
                                        <li><a href="{{ route('customer.address') }}">Address</a></li>
                                        <li><a href="{{ route('customer.getWishList') }}">Wishlist</a></li>
                                        <li><a href="{{ route('cart') }}">Cart</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ec-shop-rightside col-lg-9 col-md-1 ">
                    <div class="row">
                        <div class="col-md-10">
                            <h4>My Shipping Address</h4>
                        </div>
                        <div class="col-md-2">
                            <a class="btn btn-primary" title="Wishlist" data-toggle="modal"
                                data-target="#address-modal-add">
                                Add Address
                            </a>
                        </div>
                    </div>
                    {{-- @isset($user_addresses) --}}
                        @foreach ($user_addresses as $address)
                            <div class="my-4">

                                <div class="ec-vendor-dashboard-card ec-vendor-setting-card  p-3">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <p class="fs-5 col-md-4">
                                                {{$address->name}} / {{$address->address}}
                                            </p>
                                            <p class="fs-5 col-md-4">
                                               {{$address->country}} / {{$address->city}} / {{$address->state}} / {{$address->zipcode}}
                                            </p>
                                        </div>
                                        <div class="col-md-2 ">
                                            <div class="row">
                                                {{-- <a href="#"  data-toggle="modal" data-target="#address-modal-{{$address->id}}"> Edit</a> --}}
                                                <a href="#" data-toggle="modal"
                                                    data-target="#address-modal-delete-{{ $address->id }}"> Delete</a>




                                                <div class="modal fade" id="address-modal-delete-{{ $address->id }}"
                                                    tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Delete Address
                                                                </h5>

                                                            </div>
                                                            <div class="modal-body">
                                                                <div
                                                                    class="h-100 d-flex align-items-center justify-content-center">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="108"
                                                                        height="108" fill="currentColor"
                                                                        class="bi bi-info-circle" viewBox="0 0 16 16">
                                                                        <path
                                                                            d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                                                        <path
                                                                            d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                                                                    </svg>

                                                                    <p
                                                                        class="h-100 d-flex align-items-center justify-content-center m-3">
                                                                        Are you sure to delete the item!!
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Close</button>
                                                                <a href="{{ route('address-destroy', $address->id) }}"
                                                                    class="btn btn-warning">Delete Address</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>




                                                <!-- Modal -->
                                                <div class="modal fade" id="address-modal-{{ $address->id }}" tabindex="-1"
                                                    role="dialog" aria-labelledby="AddressTitle" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div
                                                                class="modal-header h-100 d-flex align-items-center justify-content-center">
                                                                <h5
                                                                    class="modal-title h-100 d-flex align-items-center justify-content-center">
                                                                    Edit address</h5>
                                                            </div>
                                                            <div class="modal-body">

                                                                <form
                                                                    action="{{ Route('updateAddress.profile', $address->id) }}"
                                                                    method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    <div class="row">
                                                                        <div class="col-md-6 ">
                                                                            <label for="city"
                                                                                class="small mb-1">{{ trans('front_end.city') }}
                                                                            </label>
                                                                            <div class="input-group mb-3">
                                                                                <select name="city" data-live-search="true"
                                                                                    class="form-select" required>
                                                                                    <option value=""> Choose the state ...
                                                                                    </option>
                                                                                    @if (isset($states) && $states->count() > 0)
                                                                                        @foreach ($states as $state)
                                                                                            @if ($address->city == $state->state_en)
                                                                                                <option
                                                                                                    value="{{ $state->state_en }}"
                                                                                                    selected>
                                                                                                    {{ $state->state_en }}
                                                                                                </option>
                                                                                            @else
                                                                                                <option
                                                                                                    value="{{ $state->state_en }}">
                                                                                                    {{ $state->state_en }}
                                                                                                </option>
                                                                                            @endif
                                                                                        @endforeach
                                                                                    @endif
                                                                                </select>
                                                                                @error('state')
                                                                                    <span class="invalid-feedback text-danger" role="alert">
                                                                                        <strong>{{ $message }}</strong>
                                                                                    </span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6 ">
                                                                            <label for="retail"
                                                                                class="small mb-1">{{ trans('front_end.retail') }}
                                                                            </label>
                                                                            <div class="input-group mb-3">
                                                                                <input id="retail" type="text"
                                                                                    placeholder="Enter your the retail"
                                                                                    class="form-control @error('retail') is-invalid @enderror"
                                                                                    name="retail"
                                                                                    value="{{ $address->retail }}"
                                                                                    autocomplete="retail" autofocus>
                                                                                @error('retail')
                                                                                    <span class="invalid-feedback text-danger" role="alert">
                                                                                        <strong>{{ $message }}</strong>
                                                                                    </span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                    </div>


                                                                    <div class="row">
                                                                        <div class="col-md-6 ">
                                                                            <label for="phone"
                                                                                class="small mb-1">{{ trans('front_end.phone') }}
                                                                            </label>
                                                                            <div class="input-group mb-3">

                                                                                <input id="phone" type="text"
                                                                                    placeholder="Enter your the phone"
                                                                                    class="form-control @error('phone') is-invalid @enderror"
                                                                                    name="phone"
                                                                                    value="{{ $address->phone }}"
                                                                                    autocomplete="phone" autofocus>

                                                                                @error('phone')
                                                                                    <span class="invalid-feedback text-danger" role="alert">
                                                                                        <strong>{{ $message }}</strong>
                                                                                    </span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label for="extra_phone_number"
                                                                                class="small mb-1">{{ trans('front_end.extra_phone_number') }}
                                                                            </label>
                                                                            <div class="input-group mb-3">
                                                                                <input id="phone_extra" type="text"
                                                                                    placeholder="Enter your phone extra"
                                                                                    class="form-control @error('phone_extra') is-invalid @enderror"
                                                                                    name="phone_extra"
                                                                                    value="{{ $address->phone_extra }}"
                                                                                    autocomplete="phone_extra" autofocus>
                                                                                @error('phone_extra')
                                                                                    <span class="invalid-feedback text-danger" role="alert">
                                                                                        <strong>{{ $message }}</strong>
                                                                                    </span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="address_2"
                                                                            class="small mb-1">{{ trans('front_end.address') }}
                                                                        </label>
                                                                        <div class="form-outline ">
                                                                            <input id="address_2" type="text"
                                                                                placeholder="Enter your address"
                                                                                class="form-control @error('address_2') is-invalid @enderror"
                                                                                name="address_2"
                                                                                value="{{ $address->address_2 }}" required
                                                                                autocomplete="address_2" autofocus>
                                                                            @error('address_2')
                                                                                <span class="invalid-feedback text-danger" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">Close</button>
                                                                        <input class="btn btn-primary col-md-3" type="submit"
                                                                            value="Save changes" />
                                                                    </div>
                                                                </form>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    {{-- @endisset --}}
                </div>
            </div>
    </section>



    <section>
        <!-- Modal -->
        <div class="modal fade" id="address-modal-add" tabindex="-1" role="dialog" aria-labelledby="AddressTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="m    odal-content">
                    <div class="modal-header h-100 d-flex align-items-center justify-content-center">
                        <h5 class="modal-title h-100 d-flex align-items-center justify-content-center">Add address</h5>
                    </div>
                    <div class="modal-body">

                        <form action="{{ Route('createAddress.profile') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                {{-- <div class="col-md-6 ">
                                    <label for="city" class="small mb-1">{{ trans('front_end.city') }}
                                    </label>
                                    <div class="input-group mb-3">
                                        <select name="city" data-live-search="true" class="form-select" required>
                                            <option value=""> Choose the state ...</option>
                                            @if (isset($states) && $states->count() > 0)
                                                @foreach ($states as $state)
                                                    @if (old('city') == $state->state_en)
                                                        <option value="{{ $state->state_en }}" selected>
                                                            {{ $state->state_en }}</option>
                                                    @else
                                                        <option value="{{ $state->state_en }}">
                                                            {{ $state->state_en }}</option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('state')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div> --}}
                                <div class="col-md-6 ">
                                    <label for="email" class="small mb-1">Email (optional)
                                    </label>
                                    <div class="input-group mb-3">
                                        <input id="email" type="text" placeholder="Enter your email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="" autocomplete="email" autofocus>
                                        @error('email')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 ">
                                    <label for="phone" class="small mb-1">Phone (optional)
                                    </label>
                                    <div class="input-group mb-3">

                                        <input id="phone" type="text" placeholder="Enter your the phone"
                                            class="form-control @error('phone') is-invalid @enderror" name="phone"
                                            value="" autocomplete="phone" autofocus>

                                        @error('phone')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="name"
                                        class="small mb-1">Name *
                                    </label>
                                    <div class="input-group mb-3">
                                        <input id="name" type="text" placeholder="Enter your name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            name="name" value="" autocomplete="name" autofocus>
                                        @error('name')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="company"
                                        class="small mb-1">Company (optional)
                                    </label>
                                    <div class="input-group mb-3">
                                        <input id="company" type="text" placeholder="Enter your company"
                                            class="form-control @error('company') is-invalid @enderror"
                                            name="company" value="" autocomplete="company" autofocus>
                                        @error('company')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="address"
                                        class="small mb-1">Address
                                    </label>
                                    <div class="input-group mb-3">
                                        <input id="address" type="text" placeholder="Enter your address"
                                            class="form-control @error('address') is-invalid @enderror"
                                            name="address" value="" autocomplete="address" autofocus>
                                        @error('address')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="apartment"
                                        class="small mb-1">Apt/Unit/Suite/etc. (Optional)
                                    </label>
                                    <div class="input-group mb-3">
                                        <input id="apartment" type="text" placeholder="Enter your Apt/Unit/Suite/etc."
                                            class="form-control @error('apartment') is-invalid @enderror"
                                            name="apartment" value="" autocomplete="apartment" autofocus>
                                        @error('apartment')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="city"
                                        class="small mb-1">City
                                    </label>
                                    <div class="input-group mb-3">
                                        <input id="city" type="text" placeholder="Enter your city"
                                            class="form-control @error('city') is-invalid @enderror"
                                            name="city" value="" autocomplete="city" autofocus>
                                        @error('city')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="state"
                                        class="small mb-1">State
                                    </label>
                                    <div class="input-group mb-3">
                                        <input id="state" type="text" placeholder="Enter your state"
                                            class="form-control @error('state') is-invalid @enderror"
                                            name="state" value="" autocomplete="state" autofocus>
                                        @error('state')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="zipcode"
                                        class="small mb-1">Zipcode
                                    </label>
                                    <div class="input-group mb-3">
                                        <input id="zipcode" type="text" placeholder="Enter your zipcode"
                                            class="form-control @error('zipcode') is-invalid @enderror"
                                            name="zipcode" value="" autocomplete="zipcode" autofocus>
                                        @error('zipcode')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="country"
                                        class="small mb-1">Country
                                    </label>
                                    <div class="input-group mb-3">
                                        <select name="country" data-live-search="true" class="form-select" required>
                                            <option value="United States">United States</option>
                                        </select>
                                        @error('country')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="more_info"
                                        class="small mb-1">More Info (optional)
                                    </label>
                                    <div class="input-group mb-3">
                                        <textarea id="more_info" type="text" placeholder="Enter More Info"
                                            class="form-control @error('more_info') is-invalid @enderror"
                                            name="more_info" value="" autocomplete="more_info" autofocus></textarea>
                                        @error('more_info')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <input class="btn btn-primary col-md-3" type="submit" value="Save changes" />
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection
