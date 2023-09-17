@extends('admin.layouts.app')

{{-- @section('admin_css')
    <link href="{{ asset('resources/dashboard_files/assets/plugins/data-tables/datatables.bootstrap4.min.css') }}"
        rel="stylesheet">
    <link href="{{ asset('resources/dashboard_files/assets/css/sleek.min.css') }}">
@endsection --}}

@section('content')

    {{-- ============================================== --}}
    {{-- ================== Header ==================== --}}
    {{-- ============================================== --}}
    <div class="breadcrumb-wrapper breadcrumb-contacts">
        <div>
            <h3><i class="mdi mdi-account-multiple"></i> User Details</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb p-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('super_admin.dashboard') }}">
                            <i class="mdi  mdi-home"></i> Dashboard
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('super_admin.users-index') }}">
                            <i class="mdi  mdi-account-multiple"></i> All Users
                        </a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page"><i class="mdi  mdi-account-multiple"></i> User Details
                    </li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="{{ route('super_admin.users-create') }}" class="mb-1 btn btn-primary"><i
                    class="mdi mdi-playlist-plus"></i> Add New </a>
        </div>
    </div>

    <div class="bg-white border rounded">
        <div class="row no-gutters">

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
                        swal("Oops !!!", "{!! Session::get('danger') !!}", "error", {
                            button: "Close",
                        });
                    </script>
                @endif
            </div>

            {{-- ================================================================================================= --}}
            {{-- ========================================= Left Section ========================================= --}}
            {{-- ================================================================================================= --}}
            <div class="col-lg-4 col-xl-3">
                <div class="profile-content-left pt-5 pb-3 px-3 px-xl-5">
                    <div class="card text-center widget-profile px-0 border-0">
                        <div class="card-img mx-auto rounded-circle">
                            @if (isset($user->profile_photo_path))
                                @if ($user->profile_photo_path && file_exists($user->profile_photo_path))
                                    <img src="{{ asset($user->profile_photo_path) }}" width="100" alt="user image">
                                @else
                                    <img src="{{ asset('front_end_style/images/profilesf.png') }}" width="100"
                                        alt="user image">
                                @endif
                            @else
                                <img src="{{ asset('front_end_style/images/profilesf.png') }}" width="100"
                                    alt="user image">
                            @endif
                        </div>
                        <div class="card-body">
                            <h5 class="py-2 text-dark"><i class="mdi mdi-account"></i> {!! isset($user->name_en) ? $user->name_en : "<span style='color:red;'>Undefined</span>" !!}</h5>
                            <a class="btn btn-primary btn-pill btn-sm my-4"
                                href="{{ isset($user->id) ? route('super_admin.users-edit', [$user->id, $user->user_type]) : '#' }}">Update
                                User Profile <i class="mdi mdi-update"></i></a>
                        </div>


                        {{-- تم ايقاف العمل  على تعديل البيانات الوظيفية من راتب واجازات وعدد اعلانات لمدخل البيانات لانه تم حذف جميع البيانات من الجدول حسب طلب الزبون --}}
                        {{-- تم الابقاء على وجودها مخفيه  --}}
                        {{-- @if ($user->user_type == 'Data Entry')
                            <a class="btn btn-primary btn-pill btn-sm my-4"
                                href="{{ isset($user->id) ? route('super_admin.users-editDataEntryJobInformation', [$user->id]) : '#' }}">Update
                                Job Information<i class="mdi mdi-update"></i></a>
                        @endif --}}
                        @if ($user->user_type == 'Job Supervisor')
                            <a class="btn btn-primary btn-pill btn-sm my-4"
                                href="{{ isset($user->id) ? route('super_admin.users-editJobSupervisorJobInformation', [$user->id]) : '#' }}">Update
                                Job Information<i class="mdi mdi-update"></i></a>
                        @endif


                    </div>
                    {{-- <h5 class="py-2 text-dark"><i class="mdi mdi-currency-usd"></i> Summary :</h5><hr> --}}
                    <div class="d-flex justify-content-between">
                        <div class="text-center pb-4">
                            <p style="color: green;" stNewsBlogLogyle="color: blue;"><i
                                    class="mdi mdi-timer-sand mdi-spin"></i> All Jobs</p>
                            <h6 class="text-dark pt-2">
                                {{ isset($active_questions) ? $active_questions->count() : '##' }}<h6>
                        </div>
                        <div class="text-center pb-4">
                            <p style="color: green;"><i class="mdi mdi-check"></i> Posts</p>
                            <h6 class="text-dark pt-2">
                                {{ isset($complete_questions) ? $complete_questions->count() : '##' }}</h6>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div class="text-center pb-4">
                            <p style="color: green;" stNewsBlogLogyle="color: blue;"><i
                                    class="mdi mdi-timer-sand mdi-spin"></i> Pendding</p>
                            <h6 class="text-dark pt-2">
                                {{ isset($active_questions) ? $active_questions->count() : '##' }}<h6>
                        </div>
                        <div class="text-center pb-4">
                            <p style="color: green;"><i class="mdi mdi-check"></i> Active</p>
                            <h6 class="text-dark pt-2">
                                {{ isset($complete_questions) ? $complete_questions->count() : '##' }}</h6>
                        </div>
                    </div>
                    <hr class="w-100">
                    <div class="contact-info pt-4">
                        <h6 class="text-dark"><i class="mdi mdi-contacts"></i> Contact Information :</h6>
                        <hr>
                        <h5 class="text-dark"></h5>
                        <p class="text-dark font-weight-medium pt-4 mb-2"><i class="mdi mdi-email"></i> Email : </p>
                        <p style="color: blue;">{!! isset($user->email) ? $user->email : "<span style='color:red;'>Undefined</span>" !!}</p>
                        <p class="text-dark font-weight-medium pt-4 mb-2"><i class="mdi mdi-phone"></i> Phone :</p>
                        <p style="color: blue;">{!! isset($user->phone) ? $user->phone : "<span style='color:red;'>Undefined</span>" !!}</p>
                        <p class="text-dark font-weight-medium pt-4 mb-2"><i class="mdi mdi-contacts"></i> Username :</p>
                        <p style="color: blue;">{!! isset($user->username) ? $user->username : "<span style='color:red;'>Undefined</span>" !!}</p>
                        <p class="text-dark font-weight-medium pt-4 mb-2"><i class="mdi mdi-account-switch"></i> User Type :
                        </p>
                        <p style="color: blue;">{!! isset($user->user_type) ? $user->user_type : "<span style='color:red;'>Undefined</span>" !!}</p>
                        <p class="text-dark font-weight-medium pt-4 mb-2"><i class="mdi mdi-account-switch"></i> User Status
                            :</p>
                        <p style="color: blue;">{!! isset($user->user_status) ? $user->user_status : "<span style='color:red;'>Undefined</span>" !!}</p>
                    </div>
                </div>
            </div>

            {{-- ================================================================================================= --}}
            {{-- ========================================== Right Section ========================================= --}}
            {{-- ================================================================================================= --}}
            <div class="col-lg-8 col-xl-9">
                <div class="profile-content-right py-5">
                    {{-- ================================================================================================= --}}
                    {{-- ===================================== Tabs Titles Section ======================================= --}}
                    {{-- ================================================================================================= --}}

                    <ul class="nav nav-tabs tab-coupon" id="myTab" role="tablist">
                        <li class="nav-item"><a class="nav-link active show" id="general-tab" data-bs-toggle="tab"
                                href="#general" role="tab" aria-controls="general" aria-selected="true"
                                data-original-title="" title="">Profile</a></li>
                        {{-- User Jobs Tab Title --}}
                        @if (isset($user->user_type))
                            @if ($user->user_type == 'Company')
                                <li class="nav-item"><a class="nav-link" id="restriction-tabs" data-bs-toggle="tab"
                                        href="#restriction" role="tab" aria-controls="restriction"
                                        aria-selected="false" data-original-title="" title="">Jobs</a></li>
                            @endif
                        @endif
                        <li class="nav-item"><a class="nav-link" id="usage-tab" data-bs-toggle="tab" href="#usage"
                                role="tab" aria-controls="usage" aria-selected="false" data-original-title=""
                                title="">Posts</a></li>
                        <li class="nav-item"><a class="nav-link" id="usage-tab1" data-bs-toggle="tab" href="#usage1"
                                role="tab" aria-controls="usage1" aria-selected="false" data-original-title=""
                                title="">Activity log</a></li>
                    </ul>

                    {{-- ================================================================================================= --}}
                    {{-- ===================================== Tabs Bodies Section ======================================= --}}
                    {{-- ================================================================================================= --}}
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade active show" id="general" role="tabpanel"
                            aria-labelledby="general-tab">
                            {{-- ============================================== --}}
                            {{-- ============= Statistics Counters ============ --}}
                            {{-- ============================================== --}}
                            @if (isset($user))
                                <div class="row mt-4">
                                    {{-- Active Ads --}}
                                    <div class="col-xl-6 col-sm-6">
                                        <div class="card card-mini mb-4">
                                            <div class="card-body">
                                                @if ($user->user_type == 'Expert')
                                                    <h2 class="mb-1">
                                                        {{ isset($user->profile->total_current_balance) ? $user->profile->total_current_balance : 'NoN' }}
                                                        $</h2>
                                                @elseif($user->user_type == 'Super Admin')
                                                    <h2 class="mb-1">
                                                        {{ isset($user->total_current_balance) ? $user->total_current_balance : 'NoN' }}
                                                    </h2>
                                                @endif
                                                <h5 style="color: orange;"><i class="mdi mdi-star mdi-spin"></i> Active
                                                    Ads
                                                </h5>
                                                <div class="chartjs-wrapper">
                                                    <canvas id="barChart"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Pendding Ads --}}
                                    <div class="col-xl-6 col-sm-6">
                                        <div class="card card-mini  mb-4">
                                            <div class="card-body">
                                                @if ($user->user_type == 'Expert')
                                                    <h2 class="mb-1">
                                                        {{ isset($user->profile->total_available_balance) ? $user->profile->total_available_balance : 'NoN' }}
                                                        $</h2>
                                                @elseif($user->user_type == 'Super Admin')
                                                    <h2 class="mb-1">
                                                        {{ isset($user->total_available_balance) ? $user->total_available_balance : 'NoN' }}
                                                    </h2>
                                                @endif
                                                <h5 style="color: green;"><i class="mdi mdi-star mdi-spin"></i> Pendding
                                                    Ads
                                                </h5>
                                                <div class="chartjs-wrapper">
                                                    <canvas id="dual-line"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- ============================================== --}}
                            {{-- ============= Main User Counters ============= --}}
                            {{-- ============================================== --}}
                            <div class="row">
                                <div class="col-xl-4">
                                    <div class="media widget-media p-4 bg-white border">
                                        <div class="icon rounded-circle mr-4 bg-primary">
                                            <i class="mdi mdi-timer-sand text-white mdi-spin"></i>
                                        </div>
                                        <div class="media-body align-self-center">
                                            <h4 class="text-primary mb-2">
                                                {{ isset($active_questions) ? $active_questions->count() : '' }}</h4>
                                            <p>Active Ads</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="media widget-media p-4 bg-white border">
                                        <div class="icon rounded-circle bg-success mr-4">
                                            <i class="mdi mdi-check text-white "></i>
                                        </div>
                                        <div class="media-body align-self-center">
                                            <h4 class="text-primary mb-2">
                                                {{ isset($complete_questions) ? $complete_questions->count() : '' }}
                                            </h4>
                                            <p>Pendding Ads</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="media widget-media p-4 bg-white border">
                                        <div class="icon rounded-circle mr-4 bg-danger">
                                            <i class="mdi mdi-close text-white "></i>
                                        </div>
                                        <div class="media-body align-self-center">
                                            <h4 class="text-primary mb-2">
                                                {{ isset($incomplete_questions) ? $incomplete_questions->count() : '' }}
                                            </h4>
                                            <p>Deleted Ads</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- ============================================== --}}
                            {{-- =========== Main User Information ============ --}}
                            {{-- ============================================== --}}
                            <div class="media mt-3 profile-timeline-media">
                                <div class="media-body">
                                    <h3 class="py-3 text-dark"><i class="mdi mdi-information"></i> Main Employee
                                        Information :</h3>
                                    <table class="table table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th><i class="mdi mdi-account"></i> Name EN : <span
                                                        style="color:blue;">{!! isset($user->name_en) ? $user->name_en : '<span style="color:red;">Undefined</span>' !!}</span></th>
                                            </tr>
                                            <tr>
                                                <th><i class="mdi mdi-account"></i> Username : <span
                                                        style="color:blue;">{!! isset($user->username) ? $user->username : '<span style="color:red;">Undefined</span>' !!}</span></th>
                                                <th><i class="mdi mdi-account-multiple"></i> User Type : <span
                                                        style="color:blue;">{!! isset($user->user_type) ? $user->user_type : '<span style="color:red;">Undefined</span>' !!}</span></th>
                                            </tr>
                                            <tr>
                                                <th><i class="mdi mdi-phone"></i> Phone : <span
                                                        style="color:blue;">{!! isset($user->phone) ? $user->phone : '<span style="color:red;">Undefined</span>' !!}</span></th>
                                                <th><i class="mdi mdi-email"></i> Email : <span
                                                        style="color:blue;">{!! isset($user->email) ? $user->email : '<span style="color:red;">Undefined</span>' !!}</span></th>
                                            </tr>
                                            <tr>
                                                <th><i class="mdi mdi-clock-outline mdi-spin"></i> Registered Since : <span
                                                        style="color:blue;">{!! isset($user->created_at) ? $user->created_at->diffForHumans() : '<span style="color:red;">Undefined</span>' !!}</span></th>
                                                <th><i class="mdi mdi-clock-outline mdi-spin"></i> Date & Time of
                                                    Registration : <span
                                                        style="color:blue;">{!! isset($user->created_at)
                                                            ? date('Y.d.m / h:i A', strtotime($user->created_at))
                                                            : '<span style="color:red;">Undefined</span>' !!}</span>
                                                </th>
                                            </tr>
                                        </thead>
                                    </table>

                                    <h3 class="py-3 text-dark"><i class="mdi mdi-information"></i> Employee Job
                                        Information :</h3>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="restriction" role="tabpanel" aria-labelledby="restriction-tabs">
                            <div class="mt-5">
                                <div class="row">
                                    {{-- Active Ads : --}}
                                    {{-- ==================================================================== --}}
                                    <div class="col-xl-12">
                                        <div class="card card-default" data-scroll-height="550">
                                            <div class="card-header justify-content-between "
                                                style="background-color: #4c84ff;">
                                                <h2 style="color:white;"><i class="mdi mdi-timer-sand text-white "></i>
                                                    Active Ads :</h2>
                                            </div>
                                            <div class="card-body slim-scroll" style="background-color: #eff4ff;">
                                                @if (isset($active_questions))
                                                    @if ($active_questions->count() > 0)
                                                        @foreach ($active_questions as $active_question)
                                                            <table id="hoverable-data-table"
                                                                class="table table-hover table-striped"
                                                                style="border:2px solid black;">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="border:1px solid black;">
                                                                            <p class="font-size-15 text-dark"><i
                                                                                    class="mdi mdi-numeric"></i> رقم السؤال
                                                                                : <span
                                                                                    style="color:blue;">{{ isset($active_question->id) ? $active_question->id : 'غير معرف' }}</span>
                                                                            </p>
                                                                        </th>
                                                                        <th style="border:1px solid black;">
                                                                            <p class="font-size-15 text-dark"><i
                                                                                    class="mdi mdi-format-title"></i> عنوان
                                                                                السؤال : <span
                                                                                    style="color:blue;">{{ isset($active_question->question_title) ? $active_question->question_title : 'غير معرف' }}</span>
                                                                            </p>
                                                                        </th>
                                                                    </tr>

                                                                    <tr>
                                                                        <th style="border:1px solid black;">
                                                                            <p class="mt-0 mb-1 font-size-15 text-dark"><i
                                                                                    class="mdi mdi-currency-usd"></i> سعر
                                                                                الاستشارة : <span style="color:blue;">
                                                                                    {{ isset($active_question->QuestionPaypalTransaction->total_amount) ? $active_question->QuestionPaypalTransaction->total_amount : 'غير معرف' }}
                                                                                    $</span></p>
                                                                        </th>
                                                                        <th style="border:1px solid black;">
                                                                            <p class="mt-0 mb-1 font-size-15 text-dark"><i
                                                                                    class="mdi mdi-currency-usd"></i> حصة
                                                                                الخبير : <span style="color:blue;">
                                                                                    {{ isset($active_question->QuestionPaypalTransaction->export_amount) ? $active_question->QuestionPaypalTransaction->export_amount : 'غير معرف' }}
                                                                                    $</span></p>
                                                                        </th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th style="border:1px solid black;">
                                                                            <p class="mt-0 mb-1 font-size-15 text-dark"><i
                                                                                    class="mdi mdi-currency-usd"></i> حصة
                                                                                الإدارة : <span style="color:blue;">
                                                                                    {{ isset($active_question->QuestionPaypalTransaction->admin_amount) ? $active_question->QuestionPaypalTransaction->admin_amount : 'غير معرف' }}
                                                                                    $</span></p>
                                                                        </th>
                                                                        <th style="border:1px solid black;">
                                                                            <p class="mt-0 mb-1 font-size-15 text-dark"><i
                                                                                    class="mdi mdi-credit-card"></i> طريقة
                                                                                الدفع : <span style="color:blue;">
                                                                                    {{ isset($active_question->QuestionPaypalTransaction->payment_type) ? $active_question->QuestionPaypalTransaction->payment_type : 'غير معرف' }}</span>
                                                                            </p>
                                                                        </th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th style="border:1px solid black;">
                                                                            <p class="mt-0 mb-1 font-size-15 text-dark"><i
                                                                                    class="mdi mdi-clock-outline mdi-spin"></i>
                                                                                تاريخ انشاء السؤال : <span
                                                                                    style="color:blue;">{{ isset($active_question->created_at) ? date('Y.d.m / h:i A', strtotime($active_question->created_at)) : 'غير معرف' }}</span>
                                                                            </p>
                                                                        </th>
                                                                        <th style="border:1px solid black;">
                                                                            <p class="mt-0 mb-1 font-size-15 text-dark"><i
                                                                                    class="mdi mdi-clock-outline mdi-spin"></i>
                                                                                تاريخ انتهاء السؤال : <span
                                                                                    style="color:blue;">{{ isset($active_question->question_expire_date) ? date('Y.d.m / h:i A', strtotime($active_question->question_expire_date)) : 'غير معرف' }}</span>
                                                                            </p>
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        @endforeach
                                                    @else
                                                        <h3 style="color: red;">There Are No Active Ads !!</h3>
                                                    @endif
                                                @else
                                                    <h3 style="color: red;">There Are No Active Ads !!</h3>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Pendding Ads : --}}
                                    {{-- ==================================================================== --}}
                                    <div class="col-xl-12">
                                        <div class="card card-default" data-scroll-height="550">
                                            <div class="card-header justify-content-between "
                                                style="background-color: #4c84ff;">
                                                <h2 style="color:white;"><i class="mdi mdi-check text-white "></i>
                                                    Pendding
                                                    Ads :</h2>
                                            </div>
                                            <div class="card-body slim-scroll" style="background-color: #eff4ff;">

                                                @if (isset($complete_questions))
                                                    @if ($complete_questions->count() > 0)
                                                        @foreach ($complete_questions as $complete_question)
                                                            <table id="hoverable-data-table"
                                                                class="table table-hover table-striped"
                                                                style="border:2px solid black;">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="border:1px solid black;">
                                                                            <p class="mt-0 mb-1 font-size-15 text-dark"><i
                                                                                    class="mdi mdi-numeric"></i> رقم السؤال
                                                                                : <span
                                                                                    style="color:blue;">{{ isset($complete_question->question->id) ? $complete_question->question->id : 'غير معرف' }}</span>
                                                                            </p>
                                                                        </th>
                                                                        <th style="border:1px solid black;">
                                                                            <p class="mt-0 mb-1 font-size-15 text-dark"><i
                                                                                    class="mdi mdi-format-title"></i> عنوان
                                                                                السؤال : <span
                                                                                    style="color:blue;">{{ isset($complete_question->question->question_title) ? $complete_question->question->question_title : 'غير معرف' }}</span>
                                                                            </p>
                                                                        </th>
                                                                    </tr>
                                                                    </tr>
                                                                    <tr>
                                                                        <th style="border:1px solid black;">
                                                                            <p class="mt-0 mb-1 font-size-15 text-dark"><i
                                                                                    class="mdi mdi-currency-usd"></i> سعر
                                                                                الاستشارة : <span style="color:blue;">
                                                                                    {{ isset($complete_question->total_amount) ? $complete_question->total_amount : 'غير معرف' }}
                                                                                    $</span></p>
                                                                        </th>
                                                                        <th style="border:1px solid black;">
                                                                            <p class="mt-0 mb-1 font-size-15 text-dark"><i
                                                                                    class="mdi mdi-currency-usd"></i> حصة
                                                                                الخبير : <span style="color:blue;">
                                                                                    {{ isset($complete_question->export_amount) ? $complete_question->export_amount : 'غير معرف' }}
                                                                                    $</span></p>
                                                                        </th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th style="border:1px solid black;">
                                                                            <p class="mt-0 mb-1 font-size-15 text-dark"><i
                                                                                    class="mdi mdi-currency-usd"></i> حصة
                                                                                الإدارة : <span style="color:blue;">
                                                                                    {{ isset($complete_question->admin_amount) ? $complete_question->admin_amount : 'غير معرف' }}
                                                                                    $</span></p>
                                                                        </th>
                                                                        <th style="border:1px solid black;">
                                                                            <p class="mt-0 mb-1 font-size-15 text-dark"><i
                                                                                    class="mdi mdi-credit-card"></i> طريقة
                                                                                الدفع : <span style="color:blue;">
                                                                                    {{ isset($complete_question->payment_type) ? $complete_question->payment_type : 'غير معرف' }}</span>
                                                                            </p>
                                                                        </th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th style="border:1px solid black;">
                                                                            <p class="mt-0 mb-1 font-size-15 text-dark"><i
                                                                                    class="mdi mdi-clock-outline mdi-spin"></i>
                                                                                تاريخ إنشاء السؤال : <span
                                                                                    style="color:blue;">{{ isset($complete_question->question->created_at) ? date('Y.d.m / h:i A', strtotime($complete_question->question->created_at)) : 'غير معرف' }}</span>
                                                                            </p>
                                                                        </th>
                                                                        <th style="border:1px solid black;">
                                                                            <p class="mt-0 mb-1 font-size-15 text-dark"><i
                                                                                    class="mdi mdi-clock-outline mdi-spin"></i>
                                                                                تاريخ انتهاء السؤال : <span
                                                                                    style="color:blue;">{{ isset($complete_question->question->question_expire_date) ? date('Y.d.m / h:i A', strtotime($complete_question->question->question_expire_date)) : 'غير معرف' }}</span>
                                                                            </p>
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        @endforeach
                                                    @else
                                                        <h3 style="color: red;">There Are No Pendding Ads !!</h3>
                                                    @endif
                                                @else
                                                    <h3 style="color: red;">There Are No Pendding Ads !!</h3>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Deleted Ads : --}}
                                    {{-- ==================================================================== --}}
                                    <div class="col-xl-12">
                                        <div class="card card-default" data-scroll-height="550">
                                            <div class="card-header justify-content-between "
                                                style="background-color: #4c84ff;">
                                                <h2 style="color:white;"><i class="mdi mdi-close text-white "></i> Deleted
                                                    Ads :</h2>
                                            </div>
                                            <div class="card-body slim-scroll" style="background-color: #eff4ff;">

                                                @if (isset($incomplete_questions))
                                                    @if ($complete_questions->count() > 0)
                                                        @foreach ($incomplete_questions as $incomplete_question)
                                                            <table id="hoverable-data-table"
                                                                class="table table-hover table-striped"
                                                                style="border:2px solid black;">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="border:1px solid black;">
                                                                            <p class="mt-0 mb-1 font-size-15 text-dark"><i
                                                                                    class="mdi mdi-numeric"></i> رقم السؤال
                                                                                : <span
                                                                                    style="color:blue;">{{ isset($incomplete_question->question->id) ? $incomplete_question->question->id : 'غير معرف' }}</span>
                                                                            </p>
                                                                        </th>
                                                                        <th style="border:1px solid black;">
                                                                            <p class="mt-0 mb-1 font-size-15 text-dark"><i
                                                                                    class="mdi mdi-format-title"></i> عنوان
                                                                                السؤال : <span
                                                                                    style="color:blue;">{{ isset($incomplete_question->question->question_title) ? $incomplete_question->question->question_title : 'غير معرف' }}</span>
                                                                            </p>
                                                                        </th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th style="border:1px solid black;">
                                                                            <p class="mt-0 mb-1 font-size-15 text-dark"><i
                                                                                    class="mdi mdi-currency-usd"></i> سعر
                                                                                الاستشارة : <span style="color:blue;">
                                                                                    {{ isset($incomplete_question->total_amount) ? $incomplete_question->total_amount : 'غير معرف' }}
                                                                                    $</span></p>
                                                                        </th>
                                                                        <th style="border:1px solid black;">
                                                                            <p class="mt-0 mb-1 font-size-15 text-dark"><i
                                                                                    class="mdi mdi-currency-usd"></i> حصة
                                                                                الخبير : <span style="color:blue;">
                                                                                    {{ isset($incomplete_question->export_amount) ? $incomplete_question->export_amount : 'غير معرف' }}
                                                                                    $</span></p>
                                                                        </th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th style="border:1px solid black;">
                                                                            <p class="mt-0 mb-1 font-size-15 text-dark"><i
                                                                                    class="mdi mdi-currency-usd"></i> حصة
                                                                                الإدارة : <span style="color:blue;">
                                                                                    {{ isset($incomplete_question->admin_amount) ? $incomplete_question->admin_amount : 'غير معرف' }}
                                                                                    $</span></p>
                                                                        </th>
                                                                        <th style="border:1px solid black;">
                                                                            <p class="mt-0 mb-1 font-size-15 text-dark"><i
                                                                                    class="mdi mdi-credit-card"></i> طريقة
                                                                                الدفع : <span style="color:blue;">
                                                                                    {{ isset($incomplete_question->payment_type) ? $incomplete_question->payment_type : 'غير معرف' }}</span>
                                                                            </p>
                                                                        </th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th style="border:1px solid black;">
                                                                            <p class="mt-0 mb-1 font-size-15 text-dark"><i
                                                                                    class="mdi mdi-clock-outline mdi-spin"></i>
                                                                                تاريخ السؤال : <span
                                                                                    style="color:blue;">{{ isset($incomplete_question->question->created_at) ? date('Y.d.m / h:i A', strtotime($incomplete_question->question->created_at)) : 'غير معرف' }}</span>
                                                                            </p>
                                                                        </th>
                                                                        <th style="border:1px solid black;">
                                                                            <p class="mt-0 mb-1 font-size-15 text-dark"><i
                                                                                    class="mdi mdi-clock-outline mdi-spin"></i>
                                                                                تاريخ انتهاء السؤال : <span
                                                                                    style="color:blue;">{{ isset($incomplete_question->question->question_expire_date) ? date('Y.d.m / h:i A', strtotime($incomplete_question->question->question_expire_date)) : 'غير معرف' }}</span>
                                                                            </p>
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        @endforeach
                                                    @else
                                                        <h3 style="color: red;">There Are No Deleted Ads !!</h3>
                                                    @endif
                                                @else
                                                    <h3 style="color: red;">There Are No Deleted Ads !!</h3>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- ============================================================================== --}}
                        {{-- =========================== User Posts Tab Body ============================== --}}
                        {{-- ============================================================================== --}}
                        @if (isset($user->user_type))
                            @if ($user->user_type == 'Company')
                                <div class="tab-pane fade" id="usage" role="tabpanel" aria-labelledby="usage-tab">
                                    <div class="mt-5">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <table id="hoverable-data-table_1"
                                                    class="table table-hover table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th><i class="mdi mdi-account-question"></i> Post Title</th>
                                                            <th><i class="mdi mdi-account-question"></i> Post Since</th>
                                                            <th><i class="mdi mdi-account-question"></i> Post Date/Time
                                                            </th>
                                                            <th><i class="mdi mdi-account-question"></i> Post Details</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        {{-- Super Admin --}}
                                                        @if (isset($activitylogs))
                                                            @if ($activitylogs->count() > 0)
                                                                @foreach ($activitylogs->sortBy('created_at') as $index => $activitylog)
                                                                    <tr>
                                                                        <td>{!! isset($activitylog->activity_key_type)
                                                                            ? $activitylog->activity_key_type
                                                                            : "<span style='color:red;'>Undefined</span>" !!}</td>
                                                                        <td>{!! isset($activitylog->created_at)
                                                                            ? $activitylog->created_at->diffForHumans()
                                                                            : "<span style='color:red;'>Undefined</span>" !!}</td>
                                                                        {{-- <td>{!! (isset($activitylog->created_at) ?  date('Y.d.m / h:i A', strtotime($activitylog->created_at)) : "<span style='color:red;'>Undefined</span>") !!}</td> --}}
                                                                        <td>{!! isset($activitylog->created_at) ? $activitylog->created_at : "<span style='color:red;'>Undefined</span>" !!}</td>
                                                                        <td>
                                                                            @if (isset($activitylog->id) && isset($activitylog->related_id) && isset($activitylog->model_name))
                                                                                <a href="{{ route('super_admin.activity_logs-show', [$activitylog->id]) }}"
                                                                                    title="Show"
                                                                                    class="mb-1 btn btn-sm btn-primary"><i
                                                                                        class="mdi mdi-eye"></i> View
                                                                                    Details</a>
                                                                            @endif
                                                                            {{-- {!! isset($activitylog->related_id) && isset($activitylog->model_name) ? $activitylog->related_id : "<span style='color:red;'>Undefined</span>" !!} --}}
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @endif
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif

                        <div class="tab-pane fade" id="usage1" role="tabpanel" aria-labelledby="usage1-tab">
                            <div class="mt-5">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <table id="hoverable-data-table_2" class="table table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th><i class="mdi mdi-account-question"></i> Activity Type</th>
                                                    <th><i class="mdi mdi-account-question"></i> Activity Since</th>
                                                    {{-- <th><i class="mdi mdi-account-question"></i> Activity Date/Time</th> --}}
                                                    <th><i class="mdi mdi-account-question"></i> Activity Date/Time</th>
                                                    <th><i class="mdi mdi-account-question"></i> Activity Details</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {{-- Super Admin --}}
                                                @if (isset($activitylogs))
                                                    @if ($activitylogs->count() > 0)
                                                        @foreach ($activitylogs->sortBy('created_at') as $index => $activitylog)
                                                            <tr>
                                                                <td>{!! isset($activitylog->activity_key_type)
                                                                    ? $activitylog->activity_key_type
                                                                    : "<span style='color:red;'>Undefined</span>" !!}</td>
                                                                <td>{!! isset($activitylog->created_at)
                                                                    ? $activitylog->created_at->diffForHumans()
                                                                    : "<span style='color:red;'>Undefined</span>" !!}</td>
                                                                {{-- <td>{!! (isset($activitylog->created_at) ?  date('Y.d.m / h:i A', strtotime($activitylog->created_at)) : "<span style='color:red;'>Undefined</span>") !!}</td> --}}
                                                                <td>{!! isset($activitylog->created_at) ? $activitylog->created_at : "<span style='color:red;'>Undefined</span>" !!}</td>
                                                                <td>
                                                                    @if (isset($activitylog->id) && isset($activitylog->related_id) && isset($activitylog->model_name))
                                                                        <a href="{{ route('super_admin.activity_logs-show', [$activitylog->id]) }}"
                                                                            title="Show"
                                                                            class="mb-1 btn btn-sm btn-primary"><i
                                                                                class="mdi mdi-eye"></i> View
                                                                            Details</a>
                                                                    @endif
                                                                    {{-- {!! isset($activitylog->related_id) && isset($activitylog->model_name) ? $activitylog->related_id : "<span style='color:red;'>Undefined</span>" !!} --}}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                @endif
                                            </tbody>
                                        </table>
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

@section('admin_javascript')
    <script>
        jQuery(document).ready(function() {
            jQuery('#hoverable-data-table_1').DataTable({
                "aLengthMenu": [
                    [20, 30, 50, 75, -1],
                    [20, 30, 50, 75, "All"]
                ],
                "pageLength": 20,
                "dom": '<"row justify-content-between top-information"lf>rt<"row justify-content-between bottom-information"ip><"clear">',
                "order": [
                    [2, "desc"]
                ]
            });
            jQuery('#hoverable-data-table_2').DataTable({
                "aLengthMenu": [
                    [20, 30, 50, 75, -1],
                    [20, 30, 50, 75, "All"]
                ],
                "pageLength": 20,
                "dom": '<"row justify-content-between top-information"lf>rt<"row justify-content-between bottom-information"ip><"clear">',
                "order": [
                    [2, "desc"]
                ]
            });
        });
    </script>
    <script src="{{ asset('dashboard_files/assets/plugins/data-tables/jquery.datatables.min.js') }}"></script>
    <script src="{{ asset('dashboard_files/assets/plugins/data-tables/datatables.bootstrap4.min.js') }}"></script>
@endsection
