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
                                <h3>Seo Operations
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
                                <li class="breadcrumb-item active">Seo Operations</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid Ends-->
            <div class="col-sm-12">
                <div class="card">
                     <div class="card-header">
                        <h3>List Seo Operations : </h3>
                    </div>
                    <div class="card-body order-datatable">
                        <table class="display" id="basic-1">
                            <thead>
                                <tr>
                                    <th>Page Name</th>
                                    <th>Last Update By</th>
                                    <th>Last Update</th>
                                    <th>keywords Ar</th>
                                    <th>keywords En</th>
                                    <th>Control</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($operations))
                                @if ($operations->count() > 0)
                               @foreach ($operations as $index => $operation)
                                    <tr>
                                        <td>{!! isset($operation->page_name) ? $operation->page_name : "<span style='color:red;'>Undefined</span>" !!}</td>

                                        <td>{!! isset($operation->user->name_en) ? $operation->user->name_en : "<span style='color:red;'>Undefined</span>" !!}</td>


                                        <td>{!! isset($operation->updated_at) ? $operation->updated_at : "<span style='color:red;'>Undefined</span>" !!}</td>
                                        <td>{!! isset($operation->keywords_ar) ? $operation->keywords_ar : "<span style='color:red;'>Undefined</span>" !!}</td>
                                        <td>{!! isset($operation->keywords_en) ? $operation->keywords_en : "<span style='color:red;'>Undefined</span>" !!}</td>

                                        <td>

                                            <a href="{{ route('super_admin.seo_operations-edit', $operation->id) }}"class=" text-success">
                                                <i class="fa fa-edit" title="Edit"></i>
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
