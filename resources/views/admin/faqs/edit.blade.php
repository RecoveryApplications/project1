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
                                        <h3>Update FAQ Information
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
                                        <li class="breadcrumb-item active">Update FAQ </li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Container-fluid Ends-->
                    <div class="row product-adding">

                        <div class="col-xl-12">
                            <form action="{{ route('super_admin.faqs-update', [$faq->id]) }}" method="POST" enctype="multipart/form-data"
                            class="needs-validation add-product-form" novalidate="">
                            @csrf
                                <div class="form ">
                                    <div class="form-group mb-3 row">
                                        <label for="validationCustom01"
                                            class="col-xl-3 col-sm-4 mb-0">Title AR:</label>
                                        <div class="col-xl-8 col-sm-7">
                                            <input name="title_ar" class="form-control @error('title_ar') is-invalid @enderror" id="validationCustom01"
                                                type="text"  value="{{ isset($faq->title_en) ? $faq->title_en : null }}" placeholder="Title AR" required="">
                                        </div>
                                        <div class="valid-feedback">Looks good!</div>
                                    </div>
                                    <div class="form-group mb-3 row">
                                        <label for="validationCustom01"
                                            class="col-xl-3 col-sm-4 mb-0">Answer AR:</label>
                                        <div class="col-xl-8 col-sm-7">
                                            <input name="answer_ar" class="form-control @error('answer_ar') is-invalid @enderror" id="validationCustom01"
                                                type="text"  value="{{ isset($faq->answer_ar) ? $faq->answer_ar : null }}" placeholder="Title AR" required="">
                                        </div>
                                        <div class="valid-feedback">Looks good!</div>
                                    </div>
                                    <div class="form-group mb-3 row">
                                        <label for="validationCustom01"
                                            class="col-xl-3 col-sm-4 mb-0">Title EN:</label>
                                        <div class="col-xl-8 col-sm-7">
                                            <input name="title_en" class="form-control @error('title_en') is-invalid @enderror" id="validationCustom01"
                                                type="text"  value="{{ isset($faq->title_en) ? $faq->title_en : null }} " placeholder="Title EN " required="">
                                        </div>
                                        <div class="valid-feedback">Looks good!</div>
                                    </div>
                                    <div class="form-group mb-3 row">
                                        <label for="validationCustom01"
                                            class="col-xl-3 col-sm-4 mb-0">Answer EN :</label>
                                        <div class="col-xl-8 col-sm-7">
                                            <input name="answer_en" class="form-control @error('answer_en') is-invalid @enderror" id="validationCustom01"
                                                type="text"  value="{{ isset($faq->answer_en) ? $faq->answer_en : null }}" placeholder="Title AR" required="">
                                        </div>
                                        <div class="valid-feedback">Looks good!</div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="exampleFormControlSelect1"
                                            class="col-xl-3 col-sm-4 mb-0">Status :</label>
                                        <div class="col-xl-8 col-sm-7">
                                            <select name="status" class="form-control digits"
                                                id="exampleFormControlSelect1">
                                                <option value="" selected>Choose...</option>
                                                <option value="1" @if (isset($faq->status) && $faq->status == 'Active') selected @endif>Active</option>
                                                <option value="2" @if (isset($faq->status) && $faq->status == 'Inactive') selected @endif>Inactive</option>
                                            </select>
                                        </div>
                                    </div>
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
