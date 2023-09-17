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
                                <h3>All Sizes
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
                                <li class="breadcrumb-item active"> All Sizes</li>
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
                            <form action="{{ route('super_admin.size-store') }}" method="POST" enctype="multipart/form-data">
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
                                    <th> Size</th>
                                    <th>Control</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($sizes))
                                @if ($sizes->count() > 0)
                                    @foreach ($sizes as $index => $size)
                                        <tr>
                                            <td>{!! isset($size->id) ? $size->id : "<span style='color:red;'>Undefined</span>" !!}</td>
                                            <td id="name_en_td_{{ $size->id }}">{!! isset($size->name_en) ? $size->name_en : "<span style='color:red;'>Undefined</span>" !!}</td>
                                            <td>
                                                <a href="{{ route('super_admin.size-destroy', [$size->id]) }}"class="btn  btn-primary">
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
