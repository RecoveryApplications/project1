@extends('front_end_inners.app_front_end', ['title' => 'الصفحة الرئيسية'])

@section('content')
    <!-- CONTAIN START -->
    <section class="checkout-section ptb-70">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row justify-content-center">
                        <div class="col-xl-6 col-lg-8 col-md-8 ">
                            <form method="POST" action="{{ route('customer.register') }}" class="main-form full">
                                @csrf
                                <div class="row">
                                    <div class="mb-20 col-12">
                                        <div class="heading-part heading-bg">
                                            <h2 class="heading">Create your account</h2>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="input-box">
                                            <label for="f-name">Full Name * @error('name_en')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </label>
                                            <input type="text" name="name_en" id="f-name" placeholder="Full Name"
                                                value="{{ old('name_en') }}">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="input-box">
                                            <label for="l-name">User Name</label>
                                            <input type="text" name="username" id="l-name" placeholder="User Name"
                                                value="{{ old('username') }}">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="input-box">
                                            <label for="login-email">Email address</label>
                                            <input id="login-email" name="email" type="email"
                                                placeholder="Email Address" value="{{ old('email') }}">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="input-box">
                                            <label for="login-email">Phone Number</label>
                                            <input id="login-email" name="phone" type="text" placeholder="Phone Number"
                                                value="{{ old('phone') }}">
                                        </div>
                                    </div>
                                    <div class="mb-1 col-12">
                                        <div class="mb-20 input-box select-dropdown">
                                            <label for="country" class="form-label" style="font-size: 14px">
                                                Country*
                                            </label>
                                            <fieldset>
                                                <select id="country" class="option-drop" name="country_id"
                                                    required>
                                                    @foreach ($countries as $country)
                                                        <option value="{{ $country->id }}">
                                                            {{ $country->name_en }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="input-box">
                                            <label for="login-pass">Password</label>
                                            <input id="login-pass" name="password" type="password"
                                                placeholder="Enter your Password">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="input-box">
                                            <label for="re-enter-pass">Re-enter Password</label>
                                            <input id="re-enter-pass" type="password" placeholder="Re-enter your Password"
                                                name="password_confirmation">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button name="submit" type="submit" class="btn-color right-side">Submit</button>
                                    </div>
                                    <div class="col-12">
                                        <hr>
                                        <div class="mt-20 new-account align-center"> <span>Already have an account with
                                                us</span> <a class="link" title="Register with FamilyDrop"
                                                href="{{ route('customer.loginRegister', 'login') }}">Login Here</a> </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- CONTAINER END -->

    <hr>
@endsection
