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
                    <h3><i class="mdi mdi-playlist-plus"></i> Add New User</h3>
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
                            <li class="breadcrumb-item" aria-current="page"><i class="mdi mdi-playlist-plus"></i> Add New
                                User</li>
                        </ol>
                    </nav>
                </div>

                {{-- ============================================== --}}
                {{-- ==================== Body ==================== --}}
                {{-- ============================================== --}}
                <div class="content-wrapper">
                    <div class="content">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card card-default">
                                    <div class="card-body">
                                        <form action="{{ route('super_admin.users-store') }}" method="POST"
                                            enctype="multipart/form-data" id="createForm">
                                            @csrf
                                            <div class="form-row">

                                                {{-- User ID --}}
                                                {{-- <div class="col-md-6 mb-3">
                                                    <label class="text-dark font-weight-medium mb-3" for="validationServer01">User Id :</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text mdi mdi-page-last" id="inputGroupPrepend2"></span>
                                                        </div>
                                                        <input type="text" class="form-control"
                                                            id="validationServer01" placeholder="Name" value="{{ $nextId }}" required disabled>
                                                    </div>
                                                </div> --}}
                                                {{-- Name EN --}}
                                                <div class="col-md-6 mb-3">
                                                    <label class="text-dark font-weight-medium mb-3"
                                                        for="validationServer01">
                                                        <i class="mdi mdi-account"></i> Name : <strong
                                                            class="text-danger"> * @error('name_en') (
                                                            {{ $message }} ) @enderror</strong>
                                                    </label>
                                                    <div class="input-group">
                                                        <input type="text" name="name_en"
                                                            class="form-control @error('name_en') is-invalid @enderror"
                                                            id="validationServer01" placeholder="Name EN"
                                                            value="{{ old('name_en') }}">
                                                    </div>
                                                </div>

                                                {{-- Username --}}
                                                <div class="col-md-6 mb-3">
                                                    <label class="text-dark font-weight-medium mb-3"
                                                        for="validationServer01">
                                                        <i class="mdi mdi-account"></i> Username : <strong
                                                            class="text-danger"> * @error('username') (
                                                            {{ $message }} ) @enderror</strong>
                                                    </label>
                                                    <div class="input-group">
                                                        <input type="text" name="username"
                                                            class="form-control @error('username') is-invalid @enderror"
                                                            id="validationServer01" placeholder="Username"
                                                            value="{{ old('username') }}">
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
                                                            id="validationDefaultUsername" placeholder="Email"
                                                            value="{{ old('email') }}"
                                                            aria-describedby="inputGroupPrepend2">
                                                    </div>
                                                </div>

                                                {{-- Phone --}}
                                                <div class="col-md-6 mb-3">
                                                    <label class="text-dark font-weight-medium mb-3"
                                                        for="validationServer01">
                                                        <i class="mdi mdi-phone"></i> Phone : <strong
                                                            class="text-danger"> * @error('phone') ( {{ $message }}
                                                            ) @enderror</strong>
                                                    </label>
                                                    <div class="input-group">
                                                        <input type="number" name="phone"
                                                            class="form-control @error('phone') is-invalid @enderror"
                                                            id="validationServer01" placeholder="Phone"
                                                            value="{{ old('phone') }}">
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
                                                        <select name="user_type"
                                                            class="custom-select my-1 mr-sm-2 @error('user_type') is-invalid @enderror"
                                                            id="inlineFormCustomSelectPref">
                                                            <option value="" selected>Select User Type...</option>
                                                            @if (isset($public_user_types))
                                                                @foreach ($public_user_types as $user_type)
                                                                    @if ($user_type != 'Super Admin')
                                                                        <option value="{{ $user_type }}"
                                                                            @if (old('user_type') == $user_type) selected @endif>{{ $user_type }}
                                                                        </option>
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                            </option>
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
                                                        <i class="mdi mdi-account-key"></i> Confirm Password : <strong
                                                            class="text-danger"> * @error('password_confirmation') (
                                                            {{ $message }} ) @enderror</strong>
                                                    </label>
                                                    <div class="input-group">
                                                        <input type="password" name="password_confirmation"
                                                            class="form-control @error('password_confirmation') is-invalid @enderror"
                                                            id="password_confirmation" placeholder="Confirm Password"
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
                                                        <select name="user_status"
                                                            class="custom-select my-1 mr-sm-2 @error('user_status') is-invalid @enderror"
                                                            id="inlineFormCustomSelectPref">
                                                            <option value="">Select User Status...</option>
                                                            <option value="1" @if (old('user_status') == '1') selected @endif>Pendding</option>
                                                            <option value="2" @if (old('user_status') == '2') selected @endif>Active</option>
                                                            <option value="3" @if (old('user_status') == '3') selected @endif>Inactive</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                {{-- User Image --}}
                                                <div class="col-md-6 mb-3">
                                                    <label class="text-dark font-weight-medium mb-3"
                                                        for="validationServer01">
                                                        <i class="mdi mdi-image"></i> User Image : <strong
                                                            class="text-danger"> @error('profile_photo_path')* (
                                                            {{ $message }} ) @enderror</strong>
                                                    </label>
                                                    <div class="input-group">
                                                        <input type="file" name="profile_photo_path" class="form-control"
                                                            id="validationServer01" placeholder="User Image">
                                                    </div>
                                                </div>

                                            </div>
                                            {{-- Button --}}
                                            <button class="btn btn-primary" type="submit"><i class="mdi mdi-playlist-plus"></i> Add</button>
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
