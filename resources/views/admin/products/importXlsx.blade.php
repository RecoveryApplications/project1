@extends('admin.layouts.app')

@section('admin_css')
    <link href="{{ asset('dashboard_files/assets/plugins/data-tables/datatables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard_files/assets/css/sleek.min.css') }}">
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="content">

            <div class="breadcrumb-wrapper breadcrumb-contacts">
                {{-- ============================================== --}}
                {{-- ================== Header ==================== --}}
                {{-- ============================================== --}}
                <div>
                    <h1><i class="mdi mdi-playlist-plus"></i> Add New Product</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb p-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('super_admin.dashboard') }}"> <i class="mdi mdi-home"></i> Dashboard </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('super_admin.products-index') }}"> <i class="mdi mdi-account-group"></i>
                                    All Products </a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page"><i class="mdi mdi-playlist-plus"></i> Add New
                                Product</li>
                        </ol>
                    </nav>
                </div>

                {{-- ============================================== --}}
                {{-- ==================== Body ==================== --}}
                {{-- ============================================== --}}
                <div class="content-wrapper">
                    <div class="content">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card card-default">
                                    <div class="card-header justify-content-between " style="background-color: #4c84ff;">
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ route('super_admin.products-importXlsxStore') }}" method="POST"
                                            enctype="multipart/form-data" id="createForm">
                                            @csrf
                                            <div class="form-row">

                                                <strong class="text-danger"> * @error('file_xlsx')
                                                        (
                                                        {{ $message }} )
                                                    @enderror
                                                </strong>
                                                {{-- import Xlsx --}}
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"
                                                            id="inputGroupFileAddon01">Upload</span>
                                                    </div>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" name="file_xlsx"
                                                            id="inputGroupFile01" aria-describedby="inputGroupFileAddon01"
                                                            accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                                        <label class="custom-file-label" for="inputGroupFile01">Choose file
                                                            ( xlsx , xls )</label>
                                                    </div>
                                                </div>

                                                {{-- Successfully done --}}
                                                <div class="col-12">
                                                    <label class="text-dark font-weight-medium mb-3"
                                                        for="validationServer01"> Successfully done :</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text mdi mdi-book-open"
                                                                id="inputGroupPrepend2"></span>
                                                        </div>
                                                        <textarea style="width: 90% !important" name="successfully_done" class="form-control" rows="5">{!! asset($Successfully) ? $Successfully : '' !!}</textarea>
                                                    </div>
                                                </div>
                                                {{-- Mistakes --}}
                                                <div class="col-12">
                                                    <label class="text-dark font-weight-medium mb-3"
                                                        for="validationServer01"> Mistakes :</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text mdi mdi-book-open"
                                                                id="inputGroupPrepend2"></span>
                                                        </div>
                                                        <textarea style="width: 90% !important" name="mistakes" class="form-control" rows="5">{{ asset($Mistakes) ? $Mistakes : '' }}</textarea>
                                                    </div>
                                                </div>

                                            </div>
                                            {{-- Button --}}
                                            <button type="submit" class="btn btn-success">Success</button>

                                            {{-- Button --}}
                                            <a class="btn btn-primary"
                                                href="{{ asset('dashboard_files\assets\data\jmegoods.xlsx') }}"><i
                                                    class="mdi mdi-playlist-plus"></i> Download Example</a>
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
<script src="https://code.jquery.com/jquery-3.2.1.min.js"
    integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.min.js"></script>
@section('admin_javascript')
    <script>

    </script>
@endsection
