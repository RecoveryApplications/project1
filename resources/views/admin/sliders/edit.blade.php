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
                                <h3>Update Slider Information
                                    {{-- <small>Multikart Admin panel</small> --}}
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
                                <li class="breadcrumb-item active">Edit </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid Ends-->
            <div class="row product-adding">

                <div class="col-xl-12">
                    <form action="{{ route('super_admin.sliders-update', [$slider->id]) }}" method="POST"
                        enctype="multipart/form-data" class="needs-validation add-product-form" novalidate="">
                        @csrf
                        <div class="form ">
                            <div class="mb-3 form-group row">
                                <label for="validationCustom01" class="mb-0 col-xl-3 col-sm-4">Title AR:</label>
                                <div class="col-xl-8 col-sm-7">
                                    <input name="title_ar" class="form-control @error('title_ar') is-invalid @enderror"
                                        id="validationCustom01" type="text"
                                        value="{{ isset($slider->title_ar) ? $slider->title_ar : null }}"
                                        placeholder="Title AR" required="">
                                </div>
                                <div class="valid-feedback">Looks good!</div>
                            </div>
                            <div class="mb-3 form-group row">
                                <label for="validationCustom01" class="mb-0 col-xl-3 col-sm-4">Title EN:</label>
                                <div class="col-xl-8 col-sm-7">
                                    <input name="title_en" class="form-control @error('title_en') is-invalid @enderror"
                                        id="validationCustom01" type="text"
                                        value="{{ isset($slider->title_en) ? $slider->title_en : null }}"
                                        placeholder="Title EN" required="">
                                </div>
                                <div class="valid-feedback">Looks good!</div>
                            </div>
                            <div class="mb-3 form-group row">
                                <label for="validationCustom01" class="mb-0 col-xl-3 col-sm-4">image:</label>
                                <div class="col-xl-8 col-sm-7">
                                    <div class="box-input-file"><input class="upload form-control" type="file"
                                            name="image"></div>

                                </div>
                                <div class="valid-feedback">Looks good!</div>
                            </div>
                            @if ($slider->image && file_exists($slider->image))
                                <img src="{{ asset($slider->image) }}" width="100" height="100"
                                    style="border-radius: 10px; border:solid 1px black;">
                            @else
                                <img src="{{ asset('images_default/default.jpg') }}" width="100" height="100"
                                    style="border-radius: 10px; border:solid 1px black;">
                            @endif

                        </div>
                        <div class="form">



                            <div class="form-group row">
                                <label class="col-xl-3 col-sm-4">Slider Details EN :</label>
                                <div class="col-xl-8 col-sm-7 description-sm">
                                    <textarea id="desc_ar" name="description_ar" cols="10" rows="5"class="form-control ">{{ isset($slider->description_ar) ? $slider->description_ar : null }}</textarea>
                                </div>

                            </div>
                            <div class="form-group row">
                                <label class="col-xl-3 col-sm-4">Slider Details EN :</label>
                                <div class="col-xl-8 col-sm-7 description-sm">
                                    <textarea id="desc_en" name="description_en" cols="10" rows="5"class="form-control ">{{ isset($slider->description_en) ? $slider->description_en : null }}</textarea>
                                </div>

                            </div>

                            <div class="form-group row">
                                <label for="exampleFormControlSelect1" class="mb-0 col-xl-3 col-sm-4">Status :</label>
                                <div class="col-xl-8 col-sm-7">
                                    <select name="status" class="form-control digits" id="exampleFormControlSelect1">
                                        <option value="">Select Status...</option>
                                        <option value="1" @if (isset($slider->status) && $slider->status == 'Active') selected @endif>Active
                                        </option>
                                        <option value="2" @if (isset($slider->status) && $slider->status == 'Inactive') selected @endif>Inactive
                                        </option>
                                    </select>
                                </div>
                                <div class="valid-feedback">Looks good!</div>
                                <div class="mt-4 offset-xl-3 offset-sm-4">
                                    <button type="submit" class="btn btn-primary">Save Updates</button>
                                </div>
                            </div>





                        </div>
                    </form>
                </div>
            </div>
            {{-- ========================================================== --}}
            {{-- ================ Advance Text Area Section =============== --}}
            {{-- ========================================================== --}}

        </div>
    </div>
@endsection
@section('admin_javascript')
    <script src="https://cdn.ckeditor.com/4.7.3/full/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('desc_ar', {
            fullPage: true,
            allowedContent: true,
            height: '300px'
        });
        CKEDITOR.replace('desc_en', {
            fullPage: true,
            allowedContent: true,
            height: '300px'
        });
    </script>
@endsection
