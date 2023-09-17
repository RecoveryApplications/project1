@extends('admin.layouts.app')

@section('admin_css')
    <link href="{{ asset('dashboard_files/assets/plugins/data-tables/datatables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard_files/assets/css/sleek.min.css') }}">
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="content">
            <div class="breadcrumb-wrapper breadcrumb-contacts">
                {{-- ============================================== --}}
                {{-- ================== Header ==================== --}}
                {{-- ============================================== --}}
                <div>
                    <h3><i class="mdi mdi-playlist-edit"></i> Update User Information</h3>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb p-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('super_admin.dashboard') }}">
                                    <i class="mdi mdi-home"></i> Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('super_admin.users-index') }}">
                                    <i class="mdi mdi-account-group"></i> All Users
                                </a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page"><i class="mdi mdi-playlist-edit"></i> Edit</li>
                        </ol>
                    </nav>
                </div>

                {{-- ============================================== --}}
                {{-- =================== Body ===================== --}}
                {{-- ============================================== --}}
                <div class="content-wrapper">
                    <div class="content">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card card-default">
                                    <div class="card-body">
                                        <form action="{{ route('super_admin.users-update', [$user->id]) }}" method="POST"
                                            id="updateForm" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-row">

                                                {{-- Name in English --}}
                                                <div class="col-md-6 mb-3">
                                                    <label class="text-dark font-weight-medium mb-3"
                                                        for="validationServer01"><i class="mdi mdi-account">
                                                        </i> Name : <strong class="text-danger"> * @error('name_en') (
                                                            {{ $message }} ) @enderror</strong>
                                                    </label>
                                                    <div class="input-group">
                                                        <input type="text" name="name_en"
                                                            class="form-control @error('name_en') is-invalid @enderror"
                                                            id="validationServer01" placeholder="Name EN"
                                                            value="{{ isset($user->name_en) ? $user->name_en : null }}">
                                                    </div>
                                                </div>

                                                {{-- Username --}}
                                                <div class="col-md-6 mb-3">
                                                    <label class="text-dark font-weight-medium mb-3"
                                                        for="validationServer01"><i class="mdi mdi-account">
                                                        </i> Username : <strong class="text-danger"> * @error('username')
                                                            ( {{ $message }} ) @enderror</strong>
                                                    </label>
                                                    <div class="input-group">
                                                        <input type="text" name="username"
                                                            class="form-control @error('username') is-invalid @enderror"
                                                            id="validationServer01" placeholder="Username"
                                                            value=" {{ isset($user->username) ? $user->username : null }}">
                                                    </div>
                                                </div>

                                                {{-- E-mail --}}
                                                <div class="col-md-6 mb-3">
                                                    <label class="text-dark font-weight-medium mb-3"
                                                        for="validationDefaultUsername">
                                                        <i class="mdi mdi-email"></i> Email : <strong
                                                            class="text-danger"> * @error('email') ( {{ $message }}
                                                            ) @enderror</strong>
                                                    </label>
                                                    <div class="input-group">
                                                        <input type="email" name="email"
                                                            class="form-control @error('email') is-invalid @enderror"
                                                            id="validationDefaultUsername" placeholder="E-mail"
                                                            value="{{ isset($user->email) ? $user->email : null }}"
                                                            aria-describedby="inputGroupPrepend2">
                                                    </div>
                                                </div>

                                                {{-- Phone --}}
                                                <div class="col-md-6 mb-3">
                                                    <label class="text-dark font-weight-medium mb-3"
                                                        for="validationServer01">
                                                        <i class="mdi mdi-cellphone"></i> Phone : <strong
                                                            class="text-danger"> * @error('phone') ( {{ $message }}
                                                            ) @enderror</strong>
                                                    </label>
                                                    <div class="input-group">
                                                        <input type="text" name="phone"
                                                            class="form-control @error('phone') is-invalid @enderror"
                                                            id="validationServer01" placeholder="Phone"
                                                            value="{{ isset($user->phone) ? $user->phone : null }}">
                                                    </div>
                                                </div>

                                                {{-- User Type --}}
                                                <div class="col-md-6 mb-3">
                                                    <label class="text-dark font-weight-medium mb-3"
                                                        for="validationServer01">
                                                        <i class="mdi mdi-account-question"></i> User Type : <strong
                                                            class="text-danger"> * @error('user_type') (
                                                            {{ $message }} ) @enderror</strong>
                                                    </label>
                                                    <div class="input-group">

                                                        @if (isset($user->user_type))
                                                            @if ($user->user_type == 'Super Admin')
                                                                <input type="hidden" name="user_type" value="Super Admin">
                                                            @elseif($user->user_type == 'Customer')
                                                                <input type="hidden" name="user_type" value="Customer">
                                                            @endif
                                                        @endif

                                                        <select disabled class="custom-select my-1 mr-sm-2 @error('user_type') is-invalid @enderror" id="inlineFormCustomSelectPref">
                                                            <option value="" selected>Choose User Type...</option>
                                                            @if (isset($user->user_type))
                                                                @if (isset($public_user_types))
                                                                    @foreach ($public_user_types as $user_type)
                                                                        <option value="{{ $user_type }}"
                                                                            @if ($user->user_type == $user_type) selected @endif>{{ $user_type }}
                                                                        </option>
                                                                    @endforeach
                                                                @endif
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>

                                                {{-- Password --}}
                                                <div class="col-md-6 mb-3">
                                                    <label class="text-dark font-weight-medium mb-3"
                                                        for="validationServer01">
                                                        <i class="mdi mdi-account-key"></i> Password : <strong
                                                            class="text-danger"> * @error('password') (
                                                            {{ $message }} ) @enderror</strong>
                                                    </label>
                                                    <div class="input-group">
                                                        <input type="password" name="password"
                                                            class="form-control @error('password') is-invalid @enderror"
                                                            id="password" placeholder="Password"
                                                            autocomplete="new-password">
                                                    </div>
                                                </div>

                                                {{-- Confirm Password --}}
                                                <div class="col-md-6 mb-3">
                                                    <label class="text-dark font-weight-medium mb-3"
                                                        for="validationServer01">
                                                        <i class="mdi mdi-account-key"></i> Password Confirm : <strong
                                                            class="text-danger"> * @error('password_confirmation') (
                                                            {{ $message }} ) @enderror</strong>
                                                    </label>
                                                    <div class="input-group">
                                                        <input type="password" name="password_confirmation"
                                                            class="form-control @error('password_confirmation') is-invalid @enderror"
                                                            id="password_confirmation" placeholder="Password Confirm"
                                                            autocomplete="new-password">
                                                    </div>
                                                </div>

                                                {{-- User Status --}}
                                                <div class="col-md-6 mb-3">
                                                    <label class="text-dark font-weight-medium mb-3"
                                                        for="validationServer01">
                                                        <i class="mdi mdi-account-switch"></i> User Status : <strong
                                                            class="text-danger"> * @error('user_status') (
                                                            {{ $message }} ) @enderror</strong>
                                                    </label>
                                                    <div class="input-group">
                                                        @if (isset($user->user_type))
                                                            @if ($user->user_type == 'Super Admin')
                                                                <input type="hidden" name="user_status" value="2">
                                                                <!-- 2 => Active -->
                                                            @endif
                                                            <select
                                                                {{ $user->user_type == 'Super Admin' ? 'disabled' : '' }}
                                                                name="user_status"
                                                                class="custom-select my-1 mr-sm-2 @error('user_status') is-invalid @enderror"
                                                                id="inlineFormCustomSelectPref">
                                                                <option value="" selected>Choose User Status...</option>
                                                                @if (isset($user->user_type))
                                                                    <option value="1" @if (isset($user->user_status) && $user->user_status == 'Pendding') selected @endif>Pendding
                                                                    </option>
                                                                    <option value="2" @if (isset($user->user_status) && $user->user_status == 'Active') selected @endif>Active
                                                                    </option>
                                                                    <option value="3" @if (isset($user->user_status) && $user->user_status == 'Inactive') selected @endif>Inactive
                                                                    </option>
                                                                @endif
                                                            </select>
                                                        @endif
                                                    </div>
                                                </div>

                                                {{-- User Image Filed --}}
                                                <div class="col-md-6 mb-3">
                                                    <label class="text-dark font-weight-medium mb-3"
                                                        for="validationServer01">
                                                        <i class="mdi mdi-image"></i> User Image : <strong
                                                            class="text-danger"> @error('profile_photo_path') (
                                                            {{ $message }} ) @enderror</strong>
                                                    </label>
                                                    <div class="input-group">
                                                        <input type="file" name="profile_photo_path" class="form-control"
                                                            id="validationServer01">
                                                    </div>
                                                </div>

                                                {{-- Display User Image --}}
                                                <div class="col-md-12 mb-3">
                                                    @if (isset($user->profile_photo_path))
                                                        @if ($user->profile_photo_path && file_exists($user->profile_photo_path))
                                                            <img src="{{ asset($user->profile_photo_path) }}" width="100" height="100" style="border-radius: 10px; border:solid 1px black;">
                                                        @else
                                                            <img src="{{ asset('front_end_style/images/profilesf.png') }}" width="100" height="100">
                                                        @endif
                                                    @else
                                                        <img src="{{ asset('front_end_style/images/profilesf.png') }}" width="100" height="100">
                                                    @endif
                                                </div>

                                            </div>

                                            {{-- Button --}}
                                            <button class="btn btn-primary" type="submit"><i class="mdi mdi-content-save-all"></i> Save Updates</button>
                                        </form>
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

    @endsection
