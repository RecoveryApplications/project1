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
                                        <h3>Edite Operations
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
                                        <li class="breadcrumb-item active">dit Seo Operations </li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Container-fluid Ends-->
                    <div class="row product-adding">

                        <div class="col-xl-12">
                            <form action="{{ route('super_admin.seo_operations-update', $operations->id) }}" method="POST" enctype="multipart/form-data"
                            class="needs-validation add-product-form" novalidate="">
                            @csrf
                                <div class="form ">
                                    <div class="form-group mb-3 row">
                                        <label for="validationCustom01"
                                            class="col-xl-3 col-sm-4 mb-0">SEO Title AR</label>
                                        <div class="col-xl-8 col-sm-7">
                                            <input name="seo_title_ar" class="form-control @error('seo_title_ar') is-invalid @enderror" id="validationCustom01"
                                                type="text"  value="{{ $operations->seo_title_ar }}" placeholder="seo title ar" required="">
                                        </div>
                                        <div class="valid-feedback">Looks good!</div>
                                    </div>
                                    <div class="form-group mb-3 row">
                                        <label for="validationCustom01"
                                            class="col-xl-3 col-sm-4 mb-0">SEO Title EN</label>
                                        <div class="col-xl-8 col-sm-7">
                                            <input name="seo_title_en" class="form-control @error('seo_title_en') is-invalid @enderror" id="validationCustom01"
                                                type="text"  value="{{ $operations->seo_title_en }}" placeholder="seo title en" required="">
                                        </div>
                                        <div class="valid-feedback">Looks good!</div>
                                    </div>
                                </div>
                                <div class="form">

                                    <div class="form-group row">
                                        <label class="col-xl-3 col-sm-4">Meta Desc AR :</label>
                                        <div class="col-xl-8 col-sm-7 description-sm">
                                            <textarea  name="meta_desc_ar" cols="105"
                                                rows="10">{{ $operations->meta_desc_ar }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-sm-4">Meta Desc EN :</label>
                                        <div class="col-xl-8 col-sm-7 description-sm">
                                            <textarea  name="meta_desc_en" cols="105"
                                                rows="10">{{ $operations->meta_desc_en }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-sm-4">keywords AR :</label>
                                        <div class="col-xl-8 col-sm-7 description-sm">
                                            <textarea  name="keywords_ar" cols="105"
                                                rows="5">{{ $operations->keywords_ar }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-sm-4">keywords EN :</label>
                                        <div class="col-xl-8 col-sm-7 description-sm">
                                            <textarea  name="keywords_en" cols="105"
                                                rows="5">{{ $operations->keywords_en }}</textarea>
                                        </div>

                                        <div class="valid-feedback">Looks good!</div>
                                        <div class="offset-xl-3 offset-sm-4 mt-4">
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


    @endsection
