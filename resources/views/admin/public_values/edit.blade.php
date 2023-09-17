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
                                        <h3>Update public values Information
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
                                        <li class="breadcrumb-item active">Update public
                                            values </li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Container-fluid Ends-->
                    <div class="row product-adding">

                        <div class="col-xl-12">
                            <form action="{{ route('super_admin.public_values-update', [$public_values->id]) }}" method="POST" enctype="multipart/form-data"
                            class="needs-validation add-product-form" novalidate="">
                            @csrf
                                <div class="form ">
                                    <div class="form-group mb-3 row">
                                        <label for="validationCustom01"
                                            class="col-xl-3 col-sm-4 mb-0">Title :</label>
                                        <div class="col-xl-8 col-sm-7">
                                            <input name="title" class="form-control @error('title') is-invalid @enderror" id="validationCustom01"
                                                type="text"  value="{{ isset($public_values->title) ? $public_values->title : null }}" placeholder="Title " disabled>
                                        </div>
                                        <div class="valid-feedback">Looks good!</div>
                                    </div>
                                    @foreach ($public_settings_values as $public_settings_value)


                                        @if(isset($public_settings_value) && $public_settings_value->count() > 0)
                                            @if($public_settings_value->title=='Color')
                                                <div class="form-group row">
                                                    <label for="exampleFormControlSelect1"
                                                        class="col-xl-3 col-sm-4 mb-0">Values :</label>
                                                    <div class="col-xl-8 col-sm-7">
                                                        <select name="values" class="form-control digits"
                                                            id="exampleFormControlSelect1">
                                                            <option value="" selected>Choose...</option>
                                                            <option value="1" @if (isset($public_settings_value->values) && $public_settings_value->values == 1) selected @endif>Active</option>
                                                            <option value="2" @if (isset($public_settings_value->values) && $public_settings_value->values == 2) selected @endif>Inactive</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            @elseif ($public_settings_value->title=='Size')
                                            <div class="form-group row">
                                                <label for="exampleFormControlSelect1"
                                                    class="col-xl-3 col-sm-4 mb-0">Values :</label>
                                                <div class="col-xl-8 col-sm-7">
                                                    <select name="values" class="form-control digits"
                                                        id="exampleFormControlSelect1">
                                                        <option value="" selected>Choose...</option>
                                                        <option value="1" @if (isset($public_settings_value->values) && $public_settings_value->values == 1) selected @endif>Active</option>
                                                        <option value="2" @if (isset($public_settings_value->values) && $public_settings_value->values == 2) selected @endif>Inactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                            @else
                                            <div class="form-group mb-3 row">
                                                <label for="validationCustom01"
                                                    class="col-xl-3 col-sm-4 mb-0">Values :</label>
                                                <div class="col-xl-8 col-sm-7">
                                                    <input name="values" class="form-control @error('values') is-invalid @enderror" id="validationCustom01"
                                                        type="number"  value="{{$public_settings_value->values}}" placeholder="Title AR" required="">
                                                </div>
                                                <div class="valid-feedback">Looks good!</div>
                                            </div>
                                            @endif
                                        @else
                                        @endif
                                    @endforeach


                                    <div class="valid-feedback">Looks good!</div>
                                        <div class="offset-xl-3 offset-sm-4 mt-4">
                                            <button type="submit" class="btn btn-primary">Save Updates</button>
                                        </div>
                                </div>

                            </form>
                        </div>
                    </div>
        {{-- ========================================================== --}}
        {{-- ================ Advance Text Area Section =============== --}}
        {{-- ========================================================== --}}


    @endsection
