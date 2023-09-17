@extends('admin.layouts.app')

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
            <div class="breadcrumb-wrapper breadcrumb-contacts">
                <!-- Container-fluid starts-->
            <div class="container-fluid">
                <div class="page-header">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="page-header-left">
                                <h3>About Us
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
                                <li class="breadcrumb-item active">About Us</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid Ends-->
                <div>

                    <a href="{{ route('super_admin.about_us-edit', $about->id) }}" class="mb-1 btn btn-primary"><i
                            class="mdi mdi-playlist-edit"></i> Edit </a>
                </div>
            </div>

            {{-- ============================================== --}}
            {{-- =================== Body ===================== --}}
            {{-- ============================================== --}}
            <div class="breadcrumb-wrapper breadcrumb-contacts">
                <div class="content-wrapper">
                    <div class="content">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card card-default">
                                  
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="d-flex justify-content-center ">
                                                    <div class="text-center pb-4">
                                                        <h3 class="text-dark pb-2">About Us EN</h3>
                                                        <p class="text-dark">
                                                            {!! isset($about->about_us_en) ? $about->about_us_en : "<span style='color:red;'>Undefined</span>" !!}
                                                        </p>
                                                    </div>
                                                </div>
                                                <hr class="w-100">
                                            </div>
                                            <div class="col-md-12">
                                                <div class="d-flex justify-content-center ">
                                                    <div class="text-center pb-4">
                                                        <h3 class="text-dark pb-2">About Us AR</h3>
                                                        <p class="text-dark">
                                                            {!! isset($about->about_us_ar) ? $about->about_us_ar : "<span style='color:red;'>Undefined</span>" !!}
                                                        </p>
                                                    </div>
                                                </div>
                                                <hr class="w-100">
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-center ">
                                                    <div class="text-center pb-4">
                                                        <h3 class="text-dark pb-2">Vision EN</h3>
                                                        <p class="text-dark">
                                                            {!! isset($about->vision_en) ? $about->vision_en : "<span style='color:red;'>Undefined</span>" !!}

                                                        </p>
                                                    </div>
                                                </div>
                                                <hr class="w-100">
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-center ">
                                                    <div class="text-center pb-4">
                                                        <h3 class="text-dark pb-2">Vision AR</h3>
                                                        <p class="text-dark">
                                                            {!! isset($about->vision_ar) ? $about->vision_ar : "<span style='color:red;'>Undefined</span>" !!}

                                                        </p>
                                                    </div>
                                                </div>
                                                <hr class="w-100">
                                            </div>

                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-center ">
                                                    <div class="text-center pb-4">
                                                        <h3 class="text-dark pb-2">Mission EN</h3>
                                                        <p class="text-dark">
                                                            {!! isset($about->mission_en) ? $about->mission_en : "<span style='color:red;'>Undefined</span>" !!}

                                                        </p>
                                                    </div>
                                                </div>
                                                <hr class="w-100">
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-center ">
                                                    <div class="text-center pb-4">
                                                        <h3 class="text-dark pb-2">Mission AR</h3>
                                                        <p class="text-dark">
                                                            {!! isset($about->mission_ar) ? $about->mission_ar : "<span style='color:red;'>Undefined</span>" !!}

                                                        </p>
                                                    </div>
                                                </div>
                                                <hr class="w-100">
                                            </div>
                                            <div class="col-md-4 m-auto">
                                                <div class="card card-mini mb-4">
                                                    @if ($about->about_us_image && file_exists($about->about_us_image))
                                                        <img style="height: 150px"
                                                            src="{{ asset($about->about_us_image) }}" width="auto">
                                                    @else
                                                        <img style="height: 150px"
                                                            src="{{ asset('images_default/default.jpg') }}" width="auto">
                                                    @endif
                                                    <span class="rounded p-1 text-light bg-danger  text-center">About Us Image</span>
                                                </div>
                                            </div>

                                            <div class="col-md-4 m-auto">
                                                <div class="card card-mini mb-4">
                                                    @if ($about->mission_image && file_exists($about->mission_image))
                                                        <img style="height: 150px"
                                                            src="{{ asset($about->mission_image) }}" width="auto">
                                                    @else
                                                        <img style="height: 150px"
                                                            src="{{ asset('images_default/default.jpg') }}" width="auto">
                                                    @endif
                                                    <span class="rounded p-1 text-light bg-danger  text-center">Mission Image</span>
                                                </div>
                                            </div>


                                            <div class="col-md-4 m-auto">
                                                <div class="card card-mini mb-4">
                                                    @if ($about->vision_image && file_exists($about->vision_image))
                                                        <img style="height: 150px" src="{{ asset($about->vision_image) }}"
                                                            width="auto">
                                                    @else
                                                        <img style="height: 150px"
                                                            src="{{ asset('images_default/default.jpg') }}" width="auto">
                                                    @endif
                                                    <span class="rounded p-1 text-light bg-danger  text-center">Vision Image</span>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
