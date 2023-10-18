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
                    <h3><i class="mdi mdi-playlist-plus"></i> Add New Payment Wallet</h3>
                    <nav aria-label="breadcrumb">
                        <ol class="p-0 breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('super_admin.dashboard') }}">
                                    <i class="mdi mdi-home"></i> Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('super_admin.users-index') }}">
                                    <i class="mdi mdi-account-group"></i> All Payment Wallets
                                </a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page"><i class="mdi mdi-playlist-plus"></i>
                                Add New Payment Wallet
                            </li>
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
                                        <form action="{{ route('super_admin.payment_wallets.store') }}" method="POST"
                                            id="createForm">
                                            @csrf
                                            <div class="row">
                                                {{-- Name --}}
                                                <div class="mb-3 col-md-6">
                                                    <label class="mb-3 text-dark font-weight-medium"
                                                        for="validationServer01">
                                                        <i class="mdi mdi-account"></i> Name En * : <strong class="text-danger">
                                                            * @error('name_en')
                                                                (
                                                                {{ $message }} )
                                                            @enderror
                                                        </strong>
                                                    </label>
                                                    <div class="input-group">
                                                        <input type="text" name="name_en" required
                                                            class="form-control @error('name_en') is-invalid @enderror"
                                                            id="validationServer01" placeholder="Name EN"
                                                            value="{{ old('name_en') }}">
                                                    </div>
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label class="mb-3 text-dark font-weight-medium"
                                                        for="validationServer01">
                                                        <i class="mdi mdi-account"></i> Name Ar : <strong class="text-danger">
                                                            * @error('name_ar')
                                                                (
                                                                {{ $message }} )
                                                            @enderror
                                                        </strong>
                                                    </label>
                                                    <div class="input-group">
                                                        <input type="text" name="name_en" required
                                                            class="form-control @error('name_ar') is-invalid @enderror"
                                                            id="validationServer01" placeholder="Name Ar"
                                                            value="{{ old('name_ar') }}">
                                                    </div>
                                                </div>

                                                {{-- Status --}}
                                                <div class="mb-3 col-md-6">
                                                    <label class="mb-3 text-dark font-weight-medium"
                                                        for="validationServer01">
                                                        <i class="mdi mdi-account-switch"></i> Status : <strong
                                                            class="text-danger"> * @error('status')
                                                                (
                                                                {{ $message }} )
                                                            @enderror
                                                        </strong>
                                                    </label>
                                                    <div class="input-group">
                                                        <select name="status" required
                                                            class="custom-select my-1 mr-sm-2 @error('status') is-invalid @enderror"
                                                            id="inlineFormCustomSelectPref">
                                                            <option value="">Select Status...</option>
                                                            <option value="active" @selected(old('status') == 'active')>
                                                                Active
                                                            </option>
                                                            <option value="inactive" @selected(old('status') == 'inactive')>
                                                                Inactive
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <button class="btn btn-primary" type="submit"><i
                                                    class="mdi mdi-playlist-plus"></i> Add</button>
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
