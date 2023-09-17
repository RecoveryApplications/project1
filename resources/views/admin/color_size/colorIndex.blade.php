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
            <!-- Container-fluid starts-->
            <div class="container-fluid">
                <div class="page-header">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="page-header-left">
                                <h3>All Colors
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
                                <li class="breadcrumb-item active"> All Colors</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid Ends-->
            <div class="col-sm-12">
                <div class="card">
                     <div class="card-header">
                        <div style="margin-top: 2%;margin-left: 2%;border: 1px solid rgb(202, 181, 202);padding: 20px;width: 90%;">
                            <form action="{{ route('super_admin.color-store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row product-adding">
                                    {{-- Name EN --}}
                                    <div class="col-md-6 mb-6">
                                        <label class="text-dark font-weight-medium mb-3" for="validationServer01">
                                            <i class="mdi mdi-account"></i> Name : <strong class="text-danger"> *
                                                @error('name_en') (
                                                {{ $message }} ) @enderror</strong>
                                        </label>
                                        <div class="input-group">
                                            <input type="text" name="name_en"
                                                class="form-control @error('name_en') is-invalid @enderror" id="validationServer01"
                                                placeholder="Name EN" value="{{ old('name_en') }}">
                                        </div>
                                    </div>

                                     {{-- Image --}}
                                     <div class="col-md-6 mb-3">
                                        <label class="text-dark font-weight-medium mb-3"
                                            for="validationServer01">
                                            <i class="mdi mdi-image"></i> Image : <strong class="text-danger"> @error('image')* ( {{ $message }} ) @enderror</strong>
                                        </label>
                                        <div class="input-group">
                                            <input type="file" name="image" class="form-control" id="validationServer01" placeholder="Image">
                                        </div>
                                    </div>
                                     {{-- Color Code --}}
                                     <div class="col-md-2 mb-3">
                                        <label class="text-dark font-weight-medium mb-3" for="validationServer01">
                                            <i class="mdi mdi-account"></i> Color  : <strong class="text-danger"> *
                                                @error('color_code') (
                                                {{ $message }} ) @enderror</strong>
                                        </label>
                                        <div class="input-group">

                                            <input type="color" name="color_code"
                                                class="form-control @error('color_code') is-invalid @enderror"
                                                placeholder="Color" value="{{ old('color_code') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <button class="btn btn-primary" type="submit" style="margin-top: 9.5%;width: 50%;"><i class="mdi mdi-playlist-plus"></i> Add</button>
                                    </div>

                                </div>
                            </form>
                        </div>
                        </div>
                    <div class="card-body order-datatable">
                        <table class="display" id="basic-1">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th> Name EN</th>
                                    <th> Color </th>
                                    <th> Updated By </th>
                                    <th> Image </th>
                                    <th>Control</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($colors))
                                @if ($colors->count() > 0)
                                    @foreach ($colors as $index => $color)
                                        <tr>
                                            <td>{!! isset($color->id) ? $color->id : "<span style='color:red;'>Undefined</span>" !!}</td>
                                            <td id="name_en_td_{{ $color->id }}">{!! isset($color->name_en) ? $color->name_en : "<span style='color:red;'>Undefined</span>" !!}</td>
                                            <td>{!! isset($color->color_code) ? '<div id="color_div_'.$color->id.'" style ="width : 50%; height: 25px; background-color: ' . $color->color_code . '" ></div>' : "<span style='color:red;'>None</span>" !!}</td>
                                            <td>{!! isset($color->user->name_en) ? $color->user->name_en : "<span style='color:red;'>Undefined</span>" !!}</td>
                                            @if ($color->image && file_exists($color->image))
                                            <td>

                                                <div class="d-flex align-items-center">
                                                    <img src="{{ asset($color->image) }}"
                                                        alt="" class="img-fluid img-60 me-2 blur-up lazyloaded">
                                                </div>
                                            </td>
                                            @else
                                            <td>

                                                <div class="d-flex align-items-center">
                                                    <img src="{{ asset('dashboard_files/assets/images/fashion/product/19.jpg') }}"
                                                        alt="" class="img-fluid img-60 me-2 blur-up lazyloaded">
                                                </div>
                                            </td>
                                        @endif
                                            <td>
                                                {{-- <button id="edit_{{ $color->id }}" data-toggle="modal" data-target="#colors_edit_modal" style="cursor: pointer;" class="mb-1 btn btn-sm btn-success edit_color"
                                                data-id="{{ $color->id }}" data-name_ar="{{ $color->name_ar }}" data-name_en="{{ $color->name_en }}"
                                                data-color_code="{{ $color->color_code }}"><i class="mdi mdi-playlist-edit"></i> Edit </button> --}}
                                                <a href="{{ route('super_admin.color-destroy', [$color->id]) }}"class="btn  btn-primary">
                                                    <i class="fa fa-trash" title="Destroy"></i>
                                                </a>
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
        @endsection
