@extends('admin.layouts.app')


@section('content')
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
        <div>
            <h1> Show Banner </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb p-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('super_admin.dashboard') }}">
                            <span class="mdi mdi-home"></span> Dashboard
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('super_admin.banners-index') }}">
                            <i class="far fa-newspaper"></i></span> List Banners
                        </a>
                    </li>
                    <li class="breadcrumb-item">

                        <i class="mdi mdi-eye"></i> Show
                        </li>



                </ol>
            </nav>
        </div>
        <div>
            <a href="{{ route('super_admin.banners-edit', $banner->id) }}" class="mb-1 btn btn-primary"><i
                    class="mdi mdi-playlist-edit"></i> Edit </a>

        </div>

    </div>

    <div class="bg-white border rounded">


        <div class="row no-gutters">

            <div class="col-md-4">
                <div class="profile-content-left pt-5 pb-3 px-3 px-xl-5">
                    <div class="text-center pb-4">
                        <h4 class="text-dark mb-3"> title  :</h4>
                        <p style="color: blue">
                            {{ isset($banner->title) ? $banner->title : 'Undefined' }}</p>
                    </div>
                    <hr class="w-100">
                </div>
            </div>

            <div class="col-md-4">
                <div class="profile-content-left pt-5 pb-3 px-3 px-xl-5">
                    <div class="text-center pb-4">
                        <h4 class="text-dark mb-3"> Page:</h4>
                        <p style="color: blue">
                            {{ isset($banner->page) ? $banner->page : 'Undefined' }}</p>
                    </div>
                    <hr class="w-100">
                </div>
            </div>
            <div class="col-md-4">
                <div class="profile-content-left pt-5 pb-3 px-3 px-xl-5">
                    <div class="text-center pb-4">
                        <h4 class="text-dark mb-3"> Status :</h4>

                        <p style="color: blue">
                            {!! isset($banner->status) ? $banner->status : 'Undefined' !!}</p>
                    </div>
                    <hr class="w-100">
                </div>
            </div>

            <div class="col-md-6">
                <div class="profile-content-left pt-5 pb-3 px-3 px-xl-5">
                    @if ($banner->image && file_exists($banner->image))
                    <img src="{{ asset($banner->image) }}"
                        width="250" height="250"
                        style="border-radius: 10px; border:solid 1px black;">
                @else
                    <img src="{{ asset('images_default/default.jpg') }}"
                        width="100" height="100"
                        style="border-radius: 10px; border:solid 1px black;">
                @endif
                    <hr class="w-100">
                </div>
            </div>





        </div>
    </div>
@endsection
