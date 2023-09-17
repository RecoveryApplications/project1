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
            <h1> Contact Us Messages</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb p-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('super_admin.dashboard') }}">
                            <span class="mdi mdi-home"></span> dashboard
                        </a>
                    </li>

                    <li class="breadcrumb-item">
                        <a href="{{ route('super_admin.contact_us-requests') }}">
                            <i class="far fa-envelope"></i> Contact Us Messages
                        </a>
                    </li>


                </ol>
            </nav>
        </div>
    </div>
    <div class="bg-white border rounded">


        <div class="row no-gutters">

            <div class="col-md-6">
                <div class="profile-content-left pt-5 pb-3 px-3 px-xl-5">
                    <div class="text-center pb-4">
                        <h4 class="pb-2" style="color: blue"> Full Name :</h4>
                        <p class="text-dark">{!! isset($request->full_name) ? $request->full_name : "<span style='color:red;'>Undefined</span>" !!}</p>
                    </div>
                    <hr class="w-100">
                </div>
            </div>

            <div class="col-md-6">
                <div class="profile-content-left pt-5 pb-3 px-3 px-xl-5">
                    <div class="text-center pb-4">
                        <h4 class="pb-2" style="color: blue"> Email :</h4>
                        <p class="text-dark">{!! isset($request->email) ? $request->email : "<span style='color:red;'>Undefined</span>" !!} </p>
                    </div>
                    <hr class="w-100">
                </div>
            </div>

            <div class="col-md-6">
                <div class="profile-content-left pt-5 pb-3 px-3 px-xl-5">
                    <div class="text-center pb-4">
                        <h4 class="pb-2" style="color: blue"> Phone :</h4>
                        <p class="text-dark">{!! isset($request->phone) ? $request->phone : "<span style='color:red;'>Undefined</span>" !!} </p>
                    </div>
                    <hr class="w-100">
                </div>
            </div>

            <div class="col-md-6">
                <div class="profile-content-left pt-5 pb-3 px-3 px-xl-5">
                    <div class="text-center pb-4">
                        <h4 class="pb-2" style="color: blue"> Subject :</h4>
                        <p class="text-dark">{!! isset($request->subject) ? $request->subject : "<span style='color:red;'>Undefined</span>" !!} </p>
                    </div>
                    <hr class="w-100">
                </div>
            </div>




            <div class="col-md-12">
                <div class="profile-content-left pt-5 pb-3 px-3 px-xl-5">
                    <div class="text-center pb-4">
                        <h4 class="pb-2" style="color: blue">  Message :</h4>
                        <p class="text-dark">{!! isset($request->message) ? $request->message : "<span style='color:red;'>Undefined</span>" !!} </p>
                    </div>
                    <hr class="w-100">
                </div>
            </div>








        </div>
    </div>
@endsection
