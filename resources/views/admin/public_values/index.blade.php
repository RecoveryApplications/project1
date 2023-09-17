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
                                <h3>All public_values
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
                                <li class="breadcrumb-item active">All public_values</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid Ends-->
            <div class="col-sm-12">
                <div class="card">
                     <div class="card-header">
                        {{-- <a href="{{ route('super_admin.public_values-create') }}" class="btn btn-primary add-row mt-md-0 mt-2">Add New</a>
                        <a href="{{ route('super_admin.public_values-showSoftDelete') }}" class="btn btn-danger add-row mt-md-0 mt-2">Archive </a> --}}
                        </div>
                    <div class="card-body order-datatable">
                        <table class="display" id="basic-1">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title </th>
                                    <th>values </th>
                                    <th>Control</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($public_values))
                                @if ($public_values->count() > 0)
                                    @foreach ($public_values as $index => $public_value)
                                    <tr>
                                        <td>{!! isset($public_value->id) ? $public_value->id : "<span style='color:red;'>Undefined</span>" !!}</td>
                                        <td>{!! isset($public_value->title) ? $public_value->title : "<span style='color:red;'>Undefined</span>" !!}</td>
                                        {{-- <td>{!! isset($public_value->values) ? $public_value->values : "<span style='color:red;'>Undefined</span>" !!}</td> --}}
                                        <td>
                                            @if (isset($public_value->values))
                                                @if ($public_value->values == 1  )
                                                    @if( $public_value->title=='Color' || $public_value->title=='Size')
                                                            <span class="badge badge-success">{{ isset($public_value->values) ? 'Active' : "<span style='color:red;'>Undefined</span>" }}</span>
                                                    @else
                                                        <span class="badge badge-primary" >{{ isset($public_value->values) ? 'InActive' : "<span style='color:red;'>Undefined</span>" }}</span>
                                                    @endif
                                                @elseif ($public_value->values == 2 )

                                                    @if( $public_value->title=='Color' && $public_value->title=='Size')
                                                        <span class="badge badge-success">{{ isset($public_value->values) ? 'Active' : "<span style='color:red;'>Undefined</span>" }}</span>
                                                    @else
                                                        <span class="badge badge-primary" >{{ isset($public_value->values) ? 'InActive' : "<span style='color:red;'>Undefined</span>" }}</span>
                                                    @endif

                                                @else
                                                    <span class="badge badge-primary" >{{$public_value->values  }}</span>
                                                @endif
                                            @endif
                                    </td>
                                        <td>
                                            {{-- <a href="{{ route('super_admin.blogs-show', $news_blog->id) }}"class=" text-primary">
                                                <i class="fa fa-eye" title="Show"></i>
                                            </a> --}}

                                            <a  href="{{ route('super_admin.public_values-edit', [$public_value->id]) }}"class=" btn  btn-success">
                                                <i class="fa fa-edit" title="Edit"></i>
                                            </a>
                                            @if( $public_value->title=='Color' || $public_value->title=='Size' )
                                            <a href="{{ route('super_admin.public_values-activeInactiveSingle', [$public_value->id]) }}" title="Active / Inactive" class=" btn  btn-warning"><i class="fa fa-stop" aria-hidden="true"></i></a>
                                            @else
                                            @endif


{{--
                                            <a href="{{ route('super_admin.public_values-softDelete', [$public_value->id]) }}"class=" btn  btn-danger">
                                                <i class="fa fa-close" title="soft Delete"></i>
                                            </a>
                                            <a href="{{ route('super_admin.public_values-activeInactiveSingle', [$public_value->id]) }}" title="Active / Inactive" class=" btn  btn-warning"><i class="fa fa-stop" aria-hidden="true"></i></a>

                                            <a href="{{ route('super_admin.public_values-destroy', [$public_value->id]) }}"class="btn  btn-primary">
                                                <i class="fa fa-trash" title="Destroy"></i>
                                            </a> --}}
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
