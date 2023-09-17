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
                    <h1><i class="mdi mdi-playlist-edit"></i> Update Brand</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb p-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('super_admin.dashboard') }}">
                                    <i class="mdi mdi-home"></i> Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('super_admin.brands-index') }}">
                                    <i class="mdi mdi-account-group"></i> All Brands
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
                                    <div class="card-header justify-content-between " >
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ route('super_admin.brands-update', [$brand->id]) }}" method="POST"
                                            id="updateForm" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-row">

                                                {{-- Super Category --}}
                                                <div class="col-md-6 mb-6">
                                                    <label class="text-dark font-weight-medium mb-3"
                                                        for="validationServer01">
                                                        <i class="mdi mdi-account-switch"></i> Main Category : <strong class="text-danger"> * @error('main_category_id') ( {{ $message }} ) @enderror</strong>
                                                    </label>
                                                    <div class="input-group">
                                                        <select name="main_category_id" id="main_category_id" class="form-control @error('main_category_id') is-invalid @enderror" id="inlineFormCustomSelectPref">
                                                            <option value="">Select Category...</option>
                                                            @if (isset($categories))
                                                                @foreach ($categories as $category)
                                                                    <option data-icon="fa fa-sitemap" value="{{ $category->id }}" @if ($brand->main_category_id == $category->id) selected @endif> {{ $category->name_en }}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                                {{-- Name EN --}}
                                                <div class="col-md-6 mb-3">
                                                    <label class="text-dark font-weight-medium mb-3" for="validationServer01">
                                                        <i class="mdi mdi-account"></i> Name : <strong class="text-danger"> * @error('name_en') ( {{ $message }} ) @enderror</strong>
                                                    </label>
                                                    <div class="input-group">
                                                        <input type="text" name="name_en" class="form-control @error('name_en') is-invalid @enderror" id="validationServer01" placeholder="Name EN"
                                                            value="{{ isset($brand->name_en) ? $brand->name_en : null }}">
                                                    </div>
                                                </div>

                                                {{-- Status --}}
                                                <div class="col-md-6 mb-3">
                                                    <label class="text-dark font-weight-medium mb-3"
                                                        for="validationServer01">
                                                        <i class="mdi mdi-account-switch"></i> Status : <strong class="text-danger"> * @error('status') ( {{ $message }} ) @enderror</strong>
                                                    </label>
                                                    <div class="input-group">
                                                        <select name="status" class="form-control @error('status') is-invalid @enderror" id="inlineFormCustomSelectPref">
                                                            <option value="">Select Status...</option>
                                                            <option value="1" @if (isset($brand->status) && $brand->status == '1') selected @endif>Active</option>
                                                            <option value="2" @if (isset($brand->status) && $brand->status == '2') selected @endif>Inactive</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                {{-- Image Filed --}}
                                                <div class="col-md-6 mb-3">
                                                    <label class="text-dark font-weight-medium mb-3"
                                                        for="validationServer01">
                                                        <i class="mdi mdi-image"></i> Image : <strong class="text-danger"> @error('image')* ( {{ $message }} ) @enderror</strong>
                                                    </label>
                                                    <div class="input-group">
                                                        <input type="file" name="image" class="form-control" id="validationServer01" placeholder="Image">
                                                    </div>
                                                </div>

                                                {{-- Display Image --}}
                                                <div class="col-md-12 mb-3">
                                                    @if (isset($brand->image))
                                                        @if ($brand->image && file_exists($brand->image))
                                                            <img src="{{ asset($brand->image) }}" width="100" height="100" style="border-radius: 10px; border:solid 1px black;">
                                                        @else
                                                            <img src="{{ asset('front_end_style/images/default.png') }}" width="100" height="100">
                                                        @endif
                                                    @else
                                                        <img src="{{ asset('front_end_style/images/default.png') }}" width="100" height="70">
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
