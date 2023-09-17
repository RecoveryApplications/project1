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
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="page-header-left">
                                    <h3>Add New Promo Code
                                        {{-- <small>Multikart Admin panel</small> --}}
                                    </h3>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <ol class="breadcrumb pull-right">
                                    <li class="breadcrumb-item">
                                        <a href="{{route('super_admin.dashboard')}}">
                                            <i data-feather="home"></i>
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item">Digital</li>
                                    <li class="breadcrumb-item active">Add New Promo Code</li>
                                </ol>
                            </div>
                        </div>
                    </div>
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
                                        <form action="{{ route('super_admin.promo_codes-store') }}" method="POST" enctype="multipart/form-data" id="createForm">
                                            @csrf
                                            <div class="row product-adding">
                                                <div class="col-xl-6">
                                                {{-- Promo Code --}}
                                                <div class="form-group row">
                                                    <label class="text-dark font-weight-medium mb-3"
                                                        for="validationServer01">
                                                        <i class="mdi mdi-account"></i> Promo Code : <strong
                                                            class="text-danger"> * @error('promo_code') (
                                                            {{ $message }} ) @enderror</strong>
                                                    </label>
                                                    <div class="input-group">

                                                        <input type="text" name="promo_code" class="form-control @error('promo_code') is-invalid @enderror"
                                                            id="validationServer01" placeholder="Promo Code"
                                                            value="{{ old('promo_code') }}">
                                                    </div>
                                                </div>


                                                {{-- Promo Value --}}
                                                <div class="form-group row">
                                                    <label class="text-dark font-weight-medium mb-3"
                                                        for="validationServer01">
                                                        <i class="mdi mdi-account"></i> Promo Value : <strong
                                                            class="text-danger"> * @error('promo_value') (
                                                            {{ $message }} ) @enderror</strong>
                                                    </label>
                                                    <div class="input-group">

                                                        <input type="number" step="0.01" name="promo_value" class="form-control @error('promo_value') is-invalid @enderror"
                                                            id="validationServer01" placeholder="Promo Value"
                                                            value="{{ old('promo_value') }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                {{-- Expiration Date --}}
                                                <div class="form-group row">
                                                    <label class="text-dark font-weight-medium mb-3"
                                                        for="validationServer01">
                                                        <i class="mdi mdi-account"></i> Expiration Date : <strong class="text-danger"> * @error('expiration_date') ( {{ $message }} ) @enderror</strong>
                                                    </label>
                                                    <div class="input-group">

                                                        <input type="date" name="expiration_date"
                                                            class="form-control @error('expiration_date') is-invalid @enderror"
                                                            id="validationServer01" placeholder="Expiration Date"
                                                            value="{{ old('expiration_date') }}">
                                                    </div>
                                                </div>

                                                {{-- Status --}}
                                                <div class="form-group row">
                                                    <div class="col-md-6 mb-3">
                                                    <label for="exampleFormControlSelect1"
                                                        class="col-xl-12 col-sm-4 mb-0">Status :</label>
                                                    <div class="col-xl-12 col-sm-7">
                                                        <select name="status" class="form-control digits"
                                                            id="exampleFormControlSelect1">
                                                            <option value="2" selected>Choose...</option>
                                                            <option value="1" @if (old('status') == '1') selected @endif>Active</option>
                                                            <option value="2" @if (old('status') == '2') selected @endif>Inactive</option>
                                                        </select>
                                                    </div>
                                                    </div>

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
