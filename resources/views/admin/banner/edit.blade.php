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
                    <h3><i class="mdi mdi-playlist-plus"></i> Edit Home Banner</h3>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb p-0">
                            <li class="breadcrumb-item">
                                <a href="">
                                    <i class="mdi mdi-home"></i> Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="">
                                    <i class="mdi mdi-account-group"></i> Home Banner
                                </a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page"><i class="mdi mdi-playlist-plus"></i> Edit Home Banner</li>
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
                                    <div class="card-header justify-content-between " >
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ route('super_admin.banners-update', [$banner->id]) }}" method="POST"
                                            enctype="multipart/form-data" id="createForm">
                                            @csrf
                                            <div class="form-row">

                                                {{-- Name  --}}
                                                <div class="col-md-6">
                                                    <label class="text-dark font-weight-medium mb-3"
                                                        for="validationServer01">
                                                        <i class="mdi mdi-account"></i>Title : <strong>

                                                        </strong>
                                                    </label>
                                                    <div class="input-group">

                                                        <input type="text" name="title"
                                                            class="form-control @error('title') is-invalid @enderror"
                                                            id="validationServer01" placeholder="Name "
                                                            value="{{ isset($banner->title) ? $banner->title : null }}">
                                                    </div>
                                                </div>



                                                {{-- Status --}}
                                                <div class="col-md-6 mb-6">
                                                    <label class="text-dark font-weight-medium mb-3"> Status
                                                        <strong class="text-danger"> * @error('status') - {{ $message }} @enderror</strong></label>
                                                    <div class="input-group">
                                                        <select name="status" class="form-control digits" data-live-search="true" data-width="88%"
                                                            id="inlineFormCustomSelectPref">
                                                            <option value="" selected>Choose...</option>
                                                            <option value="1" @if ($banner->status == '1') selected @endif>Active</option>
                                                            <option value="2" @if ($banner->status == '2') selected @endif>Inactive</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                {{-- Status --}}
                                                <div class="col-md-6 mb-6">
                                                    <label class="text-dark font-weight-medium mb-3"> page
                                                        <strong class="text-danger"> * @error('page') - {{ $message }} @enderror</strong></label>
                                                    <div class="input-group">
                                                        <select name="page" class="form-control digits" data-live-search="true" data-width="88%"
                                                            id="inlineFormCustomSelectPref">
                                                            <option value="" selected>Choose...</option>
                                                            <option value="Home" @if ($banner->page == 'Home') selected @endif>Home</option>
                                                            <option value="Shop" @if ($banner->page == 'Shop') selected @endif>Shop</option>
                                                            <option value="Mobile" @if ($banner->page == 'Mobile') selected @endif>Mobile</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group mb-3 row">
                                                    <label for="validationCustom01"
                                                        class="col-xl-12 col-sm-12 mb-0">image:</label>
                                                    <div class="col-xl-6 col-sm-6">
                                                        <div class="box-input-file"><input class="upload form-control"
                                                            type="file" name="image"></div>

                                                    </div>
                                                    <div class="valid-feedback">Looks good!</div>
                                                </div>
                                                @if ($banner->image && file_exists($banner->image))
                                                <img src="{{ asset($banner->image) }}"
                                                    width="100" height="100"
                                                    style="border-radius: 10px; border:solid 1px black;">
                                            @else
                                                <img src="{{ asset('images_default/default.jpg') }}"
                                                    width="100" height="100"
                                                    style="border-radius: 10px; border:solid 1px black;">
                                            @endif



                                            </div>
                                            {{-- Button --}}
                                            <button class="btn btn-primary" type="submit"><i
                                                    class="mdi mdi-playlist-plus"></i> Save Updates</button>
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

