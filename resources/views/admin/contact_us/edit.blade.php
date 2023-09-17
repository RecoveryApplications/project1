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
            <div class="breadcrumb-wrapper breadcrumb-contacts">
                <div>
                    <h1>Update Contact Us</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb p-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('super_admin.dashboard') }}">
                                    <span class="mdi mdi-home"></span> dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('super_admin.contact_us-index') }}">
                                    <span class="mdi mdi-account-group"></span> Contact Us
                                </a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">Edit</li>
                        </ol>
                    </nav>
                </div>

                <div class="content-wrapper">
                    <div class="content">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card card-default">
                                    <div class="card-header card-header-border-bottom">

                                    </div>
                                    <div class="card-body">
                                        <form action="{{ route('super_admin.contact_us-update') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-row">

                                                {{-- Email --}}
                                                <div class="col-md-6 mb-3">
                                                    <label class="text-dark font-weight-medium mb-3"
                                                        for="validationServer01">
                                                        <i class="mdi mdi-account"></i> Email : <strong class="text-danger">
                                                            * @error('email')
                                                                ( {{ $message }} )
                                                            @enderror
                                                        </strong>
                                                    </label>
                                                    <div class="input-group">
                                                        <input type="email" name="email" class="form-control"
                                                            id="validationServer01" placeholder="Email"
                                                            value="{!! isset($contact->email) ? $contact->email : "" !!}">
                                                    </div>
                                                </div>

                                                {{-- Phone --}}
                                                <div class="col-md-6 mb-3">
                                                    <label class="text-dark font-weight-medium mb-3"
                                                        for="validationServer01">
                                                        <i class="mdi mdi-account"></i> Phone : <strong class="text-danger">
                                                            * @error('phone')
                                                                ( {{ $message }} )
                                                            @enderror
                                                        </strong>
                                                    </label>
                                                    <div class="input-group">
                                                        <input type="text" name="phone" class="form-control"
                                                            id="validationServer01" placeholder="Phone"
                                                            value="{!! isset($contact->phone) ? $contact->phone : "" !!}">
                                                    </div>
                                                </div>



                                                {{-- Address EN --}}
                                                <div class="col-md-6 mb-3">
                                                    <label class="text-dark font-weight-medium mb-3"
                                                        for="validationServer01">
                                                        <i class="mdi mdi-account"></i> Address EN : <strong
                                                            class="text-danger"> * @error('address_en')
                                                                ( {{ $message }} )
                                                            @enderror
                                                        </strong>
                                                    </label>
                                                    <div class="input-group">
                                                        <input type="text" name="address_en" class="form-control"
                                                            id="validationServer01" placeholder="Address EN"
                                                            value="{!! isset($contact->address_en) ? $contact->address_en : "" !!}">
                                                    </div>
                                                </div>

                                                {{-- Address AR --}}
                                                <div class="col-md-6 mb-3">
                                                    <label class="text-dark font-weight-medium mb-3"
                                                        for="validationServer01">
                                                        <i class="mdi mdi-account"></i> Address AR : <strong
                                                            class="text-danger"> * @error('address_ar')
                                                                ( {{ $message }} )
                                                            @enderror
                                                        </strong>
                                                    </label>
                                                    <div class="input-group">
                                                        <input type="text" name="address_ar" class="form-control"
                                                            id="validationServer01" placeholder="Address AR"
                                                            value="{!! isset($contact->address_ar) ? $contact->address_ar : "" !!}">
                                                    </div>
                                                </div>

                                            </div>
                                            <button class="btn btn-primary" type="submit">Edit</button>
                                        </form>
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
