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
                                            <h2 class="heading">{{ __('front_end.register_Create_an_Account') }}</h2>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="input-box">
                                            <label for="f-name">{{ __('front_end.register_Full_Name') }} *
                                                @error('name_en')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </label>
                                            <input type="text" name="name_en" id="f-name"
                                                placeholder="{{ __('front_end.register_Full_Name') }}"
                                                value="{{ old('name_en') }}">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="input-box">
                                            <label for="l-name">{{ __('front_end.register_User_Name') }}</label>
                                            <input type="text" name="username" id="l-name"
                                                placeholder="{{ __('front_end.register_User_Name') }}"
                                                value="{{ old('username') }}">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="input-box">
                                            <label for="login-email">{{ __('front_end.register_Email_Address') }}</label>
                                            <input id="login-email" name="email" type="email"
                                                placeholder="{{ __('front_end.register_Email_Address') }}"
                                                value="{{ old('email') }}">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="input-box">
                                            <label for="login-email">{{ __('front_end.register_Phone_Number') }}</label>
                                            <input id="login-email" name="phone" type="text"
                                                placeholder="{{ __('front_end.register_Phone_Number') }}"
                                                value="{{ old('phone') }}">
                                        </div>
                                    </div>
                                    <div class="mb-1 col-12">
                                        <div class="mb-20 input-box select-dropdown">
                                            <label for="country" class="form-label" style="font-size: 14px">
                                                {{ __('front_end.register_Country') }}*
                                            </label>
                                            <fieldset>
                                                <select id="country" class="option-drop" name="country_id" required>
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
                                            <label for="login-pass">{{ __('front_end.register_Password') }}</label>
                                            <input id="login-pass" name="password" type="password"
                                                placeholder="{{ __('front_end.register_Password') }} ">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="input-box">
                                            <label
                                                for="re-enter-pass">{{ __('front_end.register_Confirm_Password') }}</label>
                                            <input id="re-enter-pass" type="password"
                                                placeholder="{{ __('front_end.register_Confirm_Password') }}"
                                                name="password_confirmation">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button name="submit" type="submit"
                                            class="btn-color right-side">{{ __('front_end.register_Register') }}</button>
                                    </div>
                                    <div class="col-12">
                                        <hr>
                                        <div class="mt-20 new-account align-center">
                                            <span>
                                                {{ __('front_end.register_Already_have_an_account') }}
                                            </span>
                                            <a class="link" title="Register with FamilyDrop"
                                                href="{{ route('customer.loginRegister', 'login') }}">
                                                {{ __('front_end.register_Login') }}
                                            </a>
                                        </div>
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
