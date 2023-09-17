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
                                        <h3>Add Blogs
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
                                        <li class="breadcrumb-item active">Add Blogs</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Container-fluid Ends-->
                    <div class="row product-adding">
                        {{-- <div class="col-xl-5">
                            <div class="add-product">
                                <div class="row">
                                    <div class="col-xl-9 xl-50 col-sm-6 col-9">
                                        <img src="assets/images/pro3/1.jpg" alt=""
                                            class="img-fluid image_zoom_1 blur-up lazyloaded">
                                    </div>
                                    <div class="col-xl-3 xl-50 col-sm-6 col-3">
                                        <ul class="file-upload-product">
                                            <li>
                                                <div class="box-input-file"><input class="upload"
                                                        type="file"><i class="fa fa-plus"></i></div>
                                            </li>
                                            <li>
                                                <div class="box-input-file"><input class="upload"
                                                        type="file"><i class="fa fa-plus"></i></div>
                                            </li>
                                            <li>
                                                <div class="box-input-file"><input class="upload"
                                                        type="file"><i class="fa fa-plus"></i></div>
                                            </li>
                                            <li>
                                                <div class="box-input-file"><input class="upload"
                                                        type="file"><i class="fa fa-plus"></i></div>
                                            </li>
                                            <li>
                                                <div class="box-input-file"><input class="upload"
                                                        type="file"><i class="fa fa-plus"></i></div>
                                            </li>
                                            <li>
                                                <div class="box-input-file"><input class="upload"
                                                        type="file"><i class="fa fa-plus"></i></div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        <div class="col-xl-12">
                            <form action="{{ route('super_admin.blogs-store') }}" method="POST" enctype="multipart/form-data"
                            class="needs-validation add-product-form" novalidate="">
                            @csrf
                                <div class="form ">
                                    <div class="form-group mb-3 row">
                                        <label for="validationCustom01"
                                            class="col-xl-3 col-sm-4 mb-0">Title AR:</label>
                                        <div class="col-xl-8 col-sm-7">
                                            <input name="title_ar" class="form-control @error('title_ar') is-invalid @enderror" id="validationCustom01"
                                                type="text"  value="{{ old('title_ar') }}" placeholder="Title AR" required="">
                                        </div>
                                        <div class="valid-feedback">Looks good!</div>
                                    </div>
                                    <div class="form-group mb-3 row">
                                        <label for="validationCustom01"
                                            class="col-xl-3 col-sm-4 mb-0">Title EN:</label>
                                        <div class="col-xl-8 col-sm-7">
                                            <input name="title_en" class="form-control @error('title_en') is-invalid @enderror" id="validationCustom01"
                                                type="text"  value="{{ old('title_en') }}" placeholder="Title EN" required="">
                                        </div>
                                        <div class="valid-feedback">Looks good!</div>
                                    </div>
                                    <div class="form-group mb-3 row">
                                        <label for="validationCustom01"
                                            class="col-xl-3 col-sm-4 mb-0">image:</label>
                                        <div class="col-xl-8 col-sm-7">
                                            <div class="box-input-file"><input class="upload form-control"
                                                type="file" name="image" required=""></div>

                                        </div>
                                        <div class="valid-feedback">Looks good!</div>
                                    </div>

                                </div>
                                <div class="form">
                                    <div class="form-group row">
                                        <label for="exampleFormControlSelect1"
                                            class="col-xl-3 col-sm-4 mb-0">Status :</label>
                                        <div class="col-xl-8 col-sm-7">
                                            <select name="status" class="form-control digits"
                                                id="exampleFormControlSelect1">
                                                <option value="2" selected>Choose...</option>
                                                <option value="1" @if (old('status') == '1') selected @endif>Active</option>
                                                <option value="2" @if (old('status') == '2') selected @endif>Inactive</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-xl-3 col-sm-4">Blog Details AR :</label>
                                        <div class="col-xl-8 col-sm-7 description-sm">
                                            <textarea id="desc_ar" name="desc_ar" cols="5"
                                                rows="5">{{ old('desc_ar') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-sm-4">Blog Details EN :</label>
                                        <div class="col-xl-8 col-sm-7 description-sm">
                                            <textarea id="desc_en" name="desc_en" cols="5"
                                                rows="5"class="form-control ">{{ old('desc_en') }}</textarea>
                                        </div>
                                    </div>
                                         {{-- seo title AR --}}
                                    <div class="form-group mb-3 row">
                                        <label for="validationCustom01"
                                            class="col-xl-3 col-sm-4 mb-0">SEO Title AR  :</label>
                                        <div class="col-xl-8 col-sm-7">
                                            <input name="seo_title_ar" class="form-control @error('seo_title_ar') is-invalid @enderror" id="validationCustom01"
                                                type="text"  value="{{ old('seo_title_ar') }}" placeholder="seo_title_ar" >
                                        </div>
                                        <div class="valid-feedback">Looks good!</div>
                                    </div>
                                        {{-- seo title En --}}
                                    <div class="form-group mb-3 row">
                                        <label for="validationCustom01"
                                            class="col-xl-3 col-sm-4 mb-0">SEO Title EN  :</label>
                                        <div class="col-xl-8 col-sm-7">
                                            <input name="seo_title_en" class="form-control @error('seo_title_en') is-invalid @enderror" id="validationCustom01"
                                                type="text"  value="{{ old('seo_title_en') }}" placeholder="seo_title_en" >
                                        </div>
                                        <div class="valid-feedback">Looks good!</div>
                                    </div>
                                        {{-- Meta Desc AR--}}
                                    <div class="form-group mb-3 row">
                                        <label for="validationCustom01"
                                            class="col-xl-3 col-sm-4 mb-0">Meta Desc AR:</label>
                                        <div class="col-xl-8 col-sm-7">
                                            <input name="meta_desc_ar" class="form-control @error('meta_desc_ar') is-invalid @enderror" id="validationCustom01"
                                                type="text"  value="{{ old('meta_desc_ar') }}" placeholder="meta_desc_ar" >
                                        </div>
                                        <div class="valid-feedback">Looks good!</div>
                                    </div>
                                        {{-- Meta Desc EN--}}
                                    <div class="form-group mb-3 row">
                                        <label for="validationCustom01"
                                            class="col-xl-3 col-sm-4 mb-0">Meta Desc AR:</label>
                                        <div class="col-xl-8 col-sm-7">
                                            <input name="meta_desc_en" class="form-control @error('meta_desc_en') is-invalid @enderror" id="validationCustom01"
                                                type="text"  value="{{ old('meta_desc_en') }}" placeholder="meta_desc_en" >
                                        </div>
                                        <div class="valid-feedback">Looks good!</div>
                                    </div>
                                         {{-- SEO Meta data AR --}}
                                    <div class="form-group mb-3 row">
                                        <label for="validationCustom01"
                                            class="col-xl-3 col-sm-4 mb-0">keywords AR:</label>
                                        <div class="col-xl-8 col-sm-7">
                                            <input name="keywords_ar" class="form-control @error('keywords_ar') is-invalid @enderror" id="validationCustom01"
                                                type="text"  value="{{ old('keywords_ar') }}" placeholder="keywords_ar" >
                                        </div>
                                        <div class="valid-feedback">Looks good!</div>
                                    </div>
                                        {{-- SEO Meta data EN --}}
                                    <div class="form-group mb-3 row">
                                        <label for="validationCustom01"
                                            class="col-xl-3 col-sm-4 mb-0">keywords EN:</label>
                                        <div class="col-xl-8 col-sm-7">
                                            <input name="keywords_en" class="form-control @error('keywords_en') is-invalid @enderror" id="validationCustom01"
                                                type="text"  value="{{ old('keywords_en') }}" placeholder="keywords_en" >
                                        </div>

                                        <div class="valid-feedback">Looks good!</div>
                                        <div class="offset-xl-3 offset-sm-4 mt-4">
                                            <button type="submit" class="btn btn-primary">Add</button>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
        {{-- ========================================================== --}}
        {{-- ================ Advance Text Area Section =============== --}}
        {{-- ========================================================== --}}


    @endsection
    @section('admin_javascript')
    <script src="https://cdn.ckeditor.com/4.7.3/full/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'desc_ar',{
            fullPage: true,
            allowedContent: true,
            height : '300px'
        });
        CKEDITOR.replace( 'desc_en',{
            fullPage: true,
            allowedContent: true,
            height : '300px'
        });
</script>
    @endsection
