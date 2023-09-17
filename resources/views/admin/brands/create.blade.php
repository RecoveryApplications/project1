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
                 <!-- Container-fluid starts-->
                 <div class="container-fluid">
                    <div class="page-header">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="page-header-left">
                                    <h3>ADD NEW BRAND

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
                                    {{-- <li class="breadcrumb-item">Sales</li> --}}
                                    <li class="breadcrumb-item active">ADD NEW BRAND
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Container-fluid Ends-->

                {{-- ============================================== --}}
                {{-- ==================== Body ==================== --}}
                {{-- ============================================== --}}
                <div class="content-wrapper">
                    <div class="content">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card card-default">
                                    <div class="card-header justify-content-between " >
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ route('super_admin.brands-store') }}" method="POST"
                                            enctype="multipart/form-data" id="createForm">
                                            @csrf
                                            <div class="form-row">

                                                {{-- Super Category --}}
                                                <div class="col-md-12 mb-3">
                                                    <label class="text-dark font-weight-medium mb-3"
                                                        for="validationServer01">
                                                        <i class="mdi mdi-account"></i> Super Category : <strong
                                                            class="text-danger"> * @error('super_category_id') (
                                                            {{ $message }} ) @enderror</strong>
                                                    </label>
                                                    <div class="input-group">

                                                        <select name="main_category_id" id="main_category_id" class="form-control" required>

                                                            <option value="">Select Super Category....</option>
                                                            @if(isset($categories) && $categories->count() > 0)
                                                            @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}" @if(old('main_category_id') == $category->id) selected @endif>{{ $category->name_en }}</option>
                                                            @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>

                                                {{-- Name EN --}}
                                                <div class="col-md-6 mb-3">
                                                    <label class="text-dark font-weight-medium mb-3"
                                                        for="validationServer01">
                                                        <i class="mdi mdi-account"></i> Name : <strong class="text-danger"> * @error('name_en') ( {{ $message }} ) @enderror</strong>
                                                    </label>
                                                    <div class="input-group">

                                                        <input type="text" name="name_en"
                                                            class="form-control @error('name_en') is-invalid @enderror"
                                                            id="validationServer01" placeholder="Name EN"
                                                            value="{{ old('name_en') }}">
                                                    </div>
                                                </div>


                                                {{-- Status --}}
                                                <div class="form-group row">
                                                    <label for="exampleFormControlSelect1"
                                                        class="col-xl-12 col-sm-12 mb-0">Status :</label>
                                                    <div class="col-xl-12 col-sm-12">
                                                        <select name="status" class="form-control digits"
                                                            id="exampleFormControlSelect1">
                                                            <option value="2" selected>Choose...</option>
                                                            <option value="1" @if (old('status') == '1') selected @endif>Active</option>
                                                            <option value="2" @if (old('status') == '2') selected @endif>Inactive</option>
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
