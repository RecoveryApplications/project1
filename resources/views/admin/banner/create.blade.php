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
                        swal("Oops !!!", "{!! Session::get('danger') !!}", "error", {
                            button: "Close",
                        });

                    </script>
                @endif
            </div>



            <div class="breadcrumb-wrapper breadcrumb-contacts">
                {{-- ============================================== --}}
                {{-- ================== Header ==================== --}}
                {{-- ============================================== --}}
                <div>
                    <h3>Add New Banner</h3>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb p-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('super_admin.dashboard') }}">
                                    <span class="mdi mdi-home"></span> Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('super_admin.banners-index') }}">
                                    <i class="far fa-newspaper"></i></span> All Banner
                                </a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page"> Add New</li>
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
                                        <form action="{{ route('super_admin.banners-store') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="text-dark font-weight-medium mb-3"
                                                        for="validationServer01"> Title  <strong
                                                            class="text-danger"> * @error('title') -
                                                                {{ $message }}
                                                            @enderror</strong></label>
                                                    <div class="input-group">
                                                        <input type="text" name="title"
                                                            class="form-control @error('title') is-invalid @enderror"
                                                            id="validationServer01" placeholder="Title "
                                                            value="{{ old('title') }}">
                                                    </div>
                                                </div>





                                                {{-- Status --}}
                                                <div class="col-md-6 mb-3">
                                                    <label class="text-dark font-weight-medium mb-3"> Status
                                                        <strong class="text-danger"> * @error('status') - {{ $message }} @enderror</strong></label>
                                                    <div class="input-group">
                                                        <select name="status" class="form-control digits" data-live-search="true" data-width="88%"
                                                            id="inlineFormCustomSelectPref">
                                                            <option value="" selected>Choose...</option>
                                                            <option value="1" @if (old('status') == '1') selected @endif>Active</option>
                                                            <option value="2" @if (old('status') == '2') selected @endif>Inactive</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                {{-- page --}}
                                                <div class="col-md-6 mb-3">
                                                    <label class="text-dark font-weight-medium mb-3"> page
                                                        <strong class="text-danger"> * @error('page') - {{ $message }} @enderror</strong></label>
                                                    <div class="input-group">
                                                        <select name="page" class="form-control digits" data-live-search="true" data-width="88%"
                                                            id="inlineFormCustomSelectPref">
                                                            <option value="" selected>Choose...</option>
                                                            <option value="Home" @if (old('page') == 'Home') selected @endif>Home</option>
                                                            <option value="Shop" @if (old('page') == 'Shop') selected @endif>Shop</option>
                                                            <option value="Mobile" @if (old('page') == 'Mobile') selected @endif>Mobile</option>
                                                        </select>
                                                    </div>
                                                </div>


                                                 {{-- Image --}}
                                                <div class="col-md-6 mb-3">
                                                    <label class="text-dark font-weight-medium mb-3"
                                                        for="validationServer01">
                                                        <i class="mdi mdi-image"></i> Image : <strong class="text-danger"> @error('image')* ( {{ $message }} ) @enderror</strong>
                                                    </label>
                                                    <div class="input-group">
                                                        <input type="file" name="image" class="form-control" id="validationServer01" placeholder="Image">
                                                    </div>
                                                </div>


                                                <div class="col-md-12 mb-3">
                                                    <div class="input-group">
                                                        <button class="btn btn-primary" type="submit">Add</button>
                                                    </div>
                                                </div>
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

        {{-- ========================================================== --}}
        {{-- ================ Advance Text Area Section =============== --}}
        {{-- ========================================================== --}}
        <script src="https://cdn.ckeditor.com/4.7.3/full/ckeditor.js"></script>

        <script>
                CKEDITOR.replace( 'desc_ar',{
                    fullPage: true,
                    allowedContent: true,
                    height : '800px'
                });
                CKEDITOR.replace( 'desc_en',{
                    fullPage: true,
                    allowedContent: true,
                    height : '800px'
                });
        </script>
        {{-- ========================================================== --}}
        {{-- ================ Advance Text Area Section =============== --}}
        {{-- ========================================================== --}}
@endsection
