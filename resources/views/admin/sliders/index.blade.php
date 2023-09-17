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
                                <h3>All Sliders
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
                                <li class="breadcrumb-item active"> Sliders</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid Ends-->
            <div class="col-sm-12">
                <div class="card">
                     <div class="card-header">
                        <a href="{{ route('super_admin.sliders-create') }}" class="btn btn-primary add-row mt-md-0 mt-2">Add New</a>
                        <a href="{{ route('super_admin.sliders-showSoftDelete') }}" class="btn btn-danger add-row mt-md-0 mt-2">Archive </a>
                        </div>
                    <div class="card-body order-datatable">
                        <table class="display" id="basic-1">
                            <thead>
                                <tr>
                                    <th>Title </th>
                                    <th>Desc</th>
                                    <th> Image</th>
                                    <th>Status</th>
                                    <th>Control</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($sliders->count() > 0)
                                    @foreach ($sliders as $index => $slider)
                                    <tr>

                                        <td>{!! isset($slider->title_en) ? $slider->title_en : "<span style='color:red;'>Undefined</span>" !!}</td>
                                        <td>{!! isset($slider->description_en) ? $slider->description_en : "<span style='color:red;'>Undefined</span>" !!}</td>

                                        @if ($slider->image && file_exists($slider->image))
                                            <td>

                                                <div class="d-flex align-items-center">
                                                    <img src="{{ asset($slider->image) }}"
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
                                            @if (isset($slider->status))
                                            @if ($slider->status == 'Active')
                                                <span class="badge badge-success">{{ isset($slider->status) ?  $slider->status : "<span style='color:red;'>Undefined</span>" }}</span>
                                            @else
                                                <span class="badge badge-primary" >{{ isset($slider->status) ?  $slider->status : "<span style='color:red;'>Undefined</span>" }}</span>
                                            @endif
                                        @else
                                            <span style='color:red;'>Undefined</span>
                                        @endif
                                    </td>

                                        <td>
                                            {{-- <a href="{{ route('super_admin.blogs-show', $news_blog->id) }}"class=" text-primary">
                                                <i class="fa fa-eye" title="Show"></i>
                                            </a> --}}

                                            <a href="{{ route('super_admin.sliders-edit', [$slider->id]) }}"class=" btn  btn-success">
                                                <i class="fa fa-edit" title="Edit"></i>
                                            </a>



                                            <a href="{{ route('super_admin.sliders-softDelete', [$slider->id]) }}"class=" btn  btn-danger">
                                                <i class="fa fa-close" title="soft Delete"></i>
                                            </a>
                                            <a href="{{ route('super_admin.sliders-activeInactiveSingle', [$slider->id]) }}" title="Active / Inactive" class=" btn  btn-warning"><i class="fa fa-stop" aria-hidden="true"></i></a>

                                            <a href="{{ route('super_admin.sliders-destroy', [$slider->id]) }}"class="btn  btn-primary">
                                                <i class="fa fa-trash" title="Destroy"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endsection
