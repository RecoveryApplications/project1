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
                                <h3>Blogs
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
                                <li class="breadcrumb-item active">Blogs</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid Ends-->
            <div class="col-sm-12">
                <div class="card">
                     <div class="card-header">
                        <a href="{{ route('super_admin.blogs-create') }}" class="btn btn-primary add-row mt-md-0 mt-2">Add New</a>
                        <a href="{{ route('super_admin.blogs-showSoftDelete') }}" class="btn btn-danger add-row mt-md-0 mt-2">Archive </a>
                        </div>
                    <div class="card-body order-datatable">
                        <table class="display" id="basic-1">
                            <thead>
                                <tr>
                                    <th>Title EN</th>
                                    <th>Title AR</th>
                                    <th>Status</th>
                                    <th>Main Image</th>
                                    <th>Date</th>
                                    <th>Control</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($news_blogs->count() > 0)
                                @foreach ($news_blogs as $index => $news_blog)
                                    <tr>
                                        <td>{{ isset($news_blog->title_ar) ? $news_blog->title_ar : 'Undefined' }}</td>

                                        <td>{{ isset($news_blog->title_en) ? $news_blog->title_en : 'Undefined' }}</td>

                                        <td>
                                                @if (isset($news_blog->status))
                                                @if ($news_blog->status == 1)
                                                    <span class="badge badge-success">{{ isset($news_blog->status) ? 'Active' : "<span style='color:red;'>Undefined</span>" }}</span>
                                                @else
                                                    <span class="badge badge-primary" >{{ isset($news_blog->status) ? 'InActive' : "<span style='color:red;'>Undefined</span>" }}</span>
                                                @endif
                                            @else
                                                <span style='color:red;'>Undefined</span>
                                            @endif
                                        </td>
                                        @if ($news_blog->image && file_exists($news_blog->image))
                                            <td>

                                                <div class="d-flex align-items-center">
                                                    <img src="{{ asset($news_blog->image) }}"
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
                                        <td>{{ isset($news_blog->created_at) ? $news_blog->created_at : "<span style='color:red;'>Undefined</span>" }}</td>
                                        <td>
                                            {{-- <a href="{{ route('super_admin.blogs-show', $news_blog->id) }}"class=" text-primary">
                                                <i class="fa fa-eye" title="Show"></i>
                                            </a> --}}

                                            <a href="{{ route('super_admin.blogs-edit', $news_blog->id) }}"class=" text-success">
                                                <i class="fa fa-edit" title="Edit"></i>
                                            </a>



                                            <a href="{{ route('super_admin.blogs-softDelete', $news_blog->id) }}"class=" text-danger">
                                                <i class="fa fa-close" title="soft Delete"></i>
                                            </a>
                                            <a href="{{ route('super_admin.blogs-destroy', [$news_blog->id]) }}"class=" text-danger">
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
