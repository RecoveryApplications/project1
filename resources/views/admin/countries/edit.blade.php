@extends('admin.layouts.app')

@section('admin_css')
    <link href="{{ asset('dashboard_files/assets/plugins/data-tables/datatables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard_files/assets/css/sleek.min.css') }}">
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="content">
            {{-- =========================================================== --}}
            {{-- ================== Sweet Alert Section ==================== --}}
            {{-- =========================================================== --}}
            <div>
                @if (session()->has('success'))
                    <script>
                        swal("Great Job !!!", "{!! Session::get('success') !!}", "success", {
                            button: "OK",
                        });
                    </script>
                @endif
                @if (session()->has('danger'))
                    <script>
                        swal("oops !!!", "{!! Session::get('danger') !!}", "error", {
                            button: "Close",
                        });
                    </script>
                @endif
            </div>

            {{-- ============================================== --}}
            {{-- ================== Header ==================== --}}
            {{-- ============================================== --}}
            <!-- Container-fluid starts-->
            <div class="container-fluid">
                <div class="page-header">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="page-header-left">
                                <h3>
                                    Update Country Information
                                </h3>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <ol class="breadcrumb pull-right">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('super_admin.dashboard') }}">
                                        <i data-feather="home"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('super_admin.countries.index') }}">
                                        countries
                                    </a>
                                </li>
                                <li class="breadcrumb-item active">Update country </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid Ends-->
            <div class="row product-adding">

                <div class="col-xl-12">
                    <form action="{{ route('super_admin.countries.update', $country->id) }}" method="POST"
                        enctype="multipart/form-data" class="needs-validation add-product-form" novalidate="">
                        @csrf
                        @method('PUT')
                        <div class="form-row row">
                            {{-- Super Category --}}
                            <div class="mb-6 col-md-6">
                                <label class="mb-3 text-dark font-weight-medium" for="validationServer01">
                                    <i class="mdi mdi-account-switch"></i> Country Code : <strong class="text-danger">
                                        @error('main_category_id')
                                            ( {{ $message }} )
                                        @enderror
                                    </strong>
                                </label>
                                <small>
                                    <strong class="text-danger">Note : </strong>
                                    <span class="text-danger">you can't change the country key</span>
                                </small>
                                <div class="input-group">
                                    <input type="text" name="key"
                                        class="form-control @error('key') is-invalid @enderror" id="validationServer01"
                                        disabled placeholder="Name EN"
                                        value="{{ isset($country->key) ? $country->key : null }}">
                                </div>
                            </div>

                        </div>
                        <div class="mt-3 row">
                            {{-- Name EN --}}
                            <div class="mb-3 col-md-6">
                                <label class="mb-3 text-dark font-weight-medium" for="validationServer01">
                                    <i class="mdi mdi-account"></i> Name EN : <strong class="text-danger"> *
                                        @error('name_en')
                                            ( {{ $message }} )
                                        @enderror
                                    </strong>
                                </label>
                                <div class="input-group">
                                    <input type="text" name="name_en"
                                        class="form-control @error('name_en') is-invalid @enderror" id="validationServer01"
                                        placeholder="Name EN" value="{{ old('name_en', $country->name_en) }}">
                                </div>
                            </div>

                            {{-- Name AR --}}
                            <div class="mb-3 col-md-6">
                                <label class="mb-3 text-dark font-weight-medium" for="validationServer01">
                                    <i class="mdi mdi-account"></i> Name AR : <strong class="text-danger"> *
                                        @error('name_ar')
                                            ( {{ $message }} )
                                        @enderror
                                    </strong>
                                </label>
                                <div class="input-group">
                                    <input type="text" name="name_ar"
                                        class="form-control @error('name_ar') is-invalid @enderror" id="validationServer01"
                                        placeholder="Name AR" value="{{ old('name_ar', $country->name_ar) }}">

                                </div>
                            </div>
                        </div>

                        {{-- Button --}}
                        <button class="btn btn-primary" type="submit"><i class="mdi mdi-content-save-all"></i> Save
                            Updates</button>
                    </form>
                </div>
            </div>
            {{-- ========================================================== --}}
            {{-- ================ Advance Text Area Section =============== --}}
            {{-- ========================================================== --}}
        @endsection
