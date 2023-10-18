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
                    <h3><i class="mdi mdi-playlist-edit"></i> Update Payment Wallet</h3>
                    <nav aria-label="breadcrumb">
                        <ol class="p-0 breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('super_admin.dashboard') }}">
                                    <i class="mdi mdi-home"></i> Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('super_admin.payment_wallets.index') }}">
                                    <i class="mdi mdi-account-group"></i> All Payment Wallets
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
                                        <form
                                            action="{{ route('super_admin.payment_wallets.update', $payment_wallet->id) }}"
                                            method="POST" id="createForm">
                                            @csrf
                                            @method('PUT')
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
                                                            value="{{ old('name_en', $payment_wallet->name_en) }}">
                                                    </div>
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label class="mb-3 text-dark font-weight-medium"
                                                        for="validationServer01">
                                                        <i class="mdi mdi-account"></i> Name AR :  @error('name')
                                                                (
                                                                {{ $message }} )
                                                            @enderror
                                                        </strong>
                                                    </label>
                                                    <div class="input-group">
                                                        <input type="text" name="name_ar" required
                                                            class="form-control @error('name_ar') is-invalid @enderror"
                                                            id="validationServer01" placeholder="Name Ar"
                                                            value="{{ old('name_ar', $payment_wallet->name_ar) }}">
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
                                                            <option value="active" @selected($payment_wallet->status == 'active')>
                                                                Active
                                                            </option>
                                                            <option value="inactive" @selected($payment_wallet->status == 'inactive')>
                                                                Inactive
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <button class="btn btn-primary" type="submit"><i
                                                    class="mdi mdi-playlist-plus"></i> Update</button>
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
