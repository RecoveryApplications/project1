@extends('admin.layouts.app')

@section('admin_css')
    {{-- <link href="{{ asset('dashboard_files/assets/plugins/data-tables/datatables.bootstrap4.min.css') }}"
        rel="stylesheet"> --}}
    {{-- <link href="{{ asset('dashboard_files/assets/css/sleek.min.css') }}"> --}}
    {{-- <link href="{{ asset('dashboard_files/assets/css/sleek.css') }}"> --}}

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
                        swal("Oops !!!", "{!! Session::get('danger') !!}", "error", {
                            button: "Close",
                        });

                    </script>
                @endif
            </div>

            {{-- ============================================== --}}
            {{-- ================== Header ==================== --}}
            {{-- ============================================== --}}
            <div class="breadcrumb-wrapper breadcrumb-contacts">
                <div>
                    <h1><i class="mdi mdi-star mdi-spin"></i> المستخدمين الموقوفين</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb p-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('super_admin.dashboard') }}">
                                    <i class="mdi mdi-home"></i> لوحة التحكم
                                </a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page"><i class="mdi mdi-block-helper"></i> المستخدمين الموقوفين</li>

                        </ol>
                    </nav>
                </div>
                {{-- <div>
                    <a href="{{ route('super_admin.users-create') }}" class="mb-1 btn btn-primary"><i
                            class="mdi mdi-playlist-plus"></i> Add New </a>
                </div> --}}
            </div>


            {{-- ============================================== --}}
            {{-- =================== Body ===================== --}}
            {{-- ============================================== --}}
            <div class="card card-default">
                <div class="card-header justify-content-between " style="background-color: #4c84ff;">
                    {{-- <h2 style="color:white;"><i class="mdi mdi-star mdi-spin"></i> طلبات سحب الرصيد : </h2> --}}
                </div>
                <div class="card-body">
                    <table id="hoverable-data-table" class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><i class="mdi mdi-account"></i> اسم عربي</th>
                                <th><i class="mdi mdi-account"></i> اسم انجليزي</th>
                                <th><i class="mdi mdi-account-question"></i> نوع المستخدم</th>
                                <th><i class="mdi mdi-email"></i> ايميل</th>
                                <th><i class="mdi mdi-image"></i> الصورة</th>
                                <th><i class="mdi mdi-settings mdi-spin"></i> التحكم</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($experts->count() > 0)
                                @foreach ($experts as $index => $expert)
                                    <tr>
                                        <td>{{ $expert->id }}</td>
                                        <td>{{ $expert->name_ar }}</td>
                                        <td>{{ $expert->name_en }}</td>
                                        <td>Expert</td>


                                        <td>{{ $expert->email }}</td>
                                        @if ($expert->profile_photo_path && file_exists($expert->profile_photo_path))
                                            <td><img src="{{ asset($expert->profile_photo_path) }}" width="70" height="70"
                                                    style="border-radius: 10px; border:solid 1px black;"></th>
                                        @else
                                            <td><img src="{{ asset('front_end_style/images/profilesf.png') }}" width="70" height="70"></th>
                                        @endif
                                        <td>
                                            <a href="{{ route('super_admin.users-activationSingle', [$expert->id, 'expert']) }}"
                                                class="accept mb-1 btn btn-sm btn-success"><i
                                                    class="mdi mdi-redo-variant"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif

                            @if ($customers->count() > 0)
                                @foreach ($customers as $index => $customer)
                                    <tr>
                                        <td>{{ $customer->id }}</td>
                                        <td>{{ $customer->name_ar }}</td>
                                        <td>{{ $customer->name_en }}</td>
                                        <td>Customer</td>
                                        <td>{{ $customer->email }}</td>
                                        @if ($customer->profile_photo_path && file_exists($customer->profile_photo_path))
                                            <td><img src="{{ asset($customer->profile_photo_path) }}" width="70"
                                                    height="70" style="border-radius: 10px; border:solid 1px black;"></th>
                                            @else
                                            <td><img src="{{ asset('front_end_style/images/profilesf.png') }}" width="70" height="70"></th>
                                        @endif
                                        <td>
                                            <a href="{{ route('super_admin.users-activationSingle', [$customer->id, 'customer']) }}"
                                                class="accept mb-1 btn btn-sm btn-success"><i
                                                    class="mdi mdi-redo-variant"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        @endsection

        @section('admin_javascript')
            <script>
                jQuery(document).ready(function() {
                    jQuery('#hoverable-data-table').DataTable({
                        "aLengthMenu": [
                            [20, 30, 50, 75, -1],
                            [20, 30, 50, 75, "All"]
                        ],
                        "pageLength": 20,
                        "dom": '<"row justify-content-between top-information"lf>rt<"row justify-content-between bottom-information"ip><"clear">'
                    });
                });

            </script>
            <script src="{{ asset('dashboard_files/assets/plugins/data-tables/jquery.datatables.min.js') }}">
            </script>
            <script src="{{ asset('dashboard_files/assets/plugins/data-tables/datatables.bootstrap4.min.js') }}">
            </script>

        @endsection
