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
                                <h3>All Properties
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
                                <li class="breadcrumb-item active"> All Properties</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid Ends-->
            <div class="col-sm-12">
                <div class="card">
                     <div class="card-header">
                        <a href="{{ route('super_admin.properties-create',$product->id) }}" class="btn btn-primary add-row mt-md-0 mt-2">Add New</a>
                        <a href="{{ route('super_admin.properties-showSoftDelete',$product->id) }}" class="btn btn-danger add-row mt-md-0 mt-2">Archive </a>
                        </div>

                    <div class="card-body order-datatable">
                        <table class="display" id="basic-1">
                            <thead>
                                <tr>
                                    <th>#</th>


                                    @if (isset($public_color_values_proparty) && $public_color_values_proparty->count() > 0)
                                        @foreach ($public_color_values_proparty as $key => $public_color)
                                            @if($public_color->values==1)
                                                <th> Color Name</th>
                                                <th> Color</th>
                                            @else
                                            @endif

                                        @endforeach
                                     @endif

                                    @if (isset($public_size_values_proparty) && $public_size_values_proparty->count() > 0)
                                        @foreach ($public_size_values_proparty as $key => $public_size)
                                        
                                            @if($public_size->values==1)
                                                <th> Size</th>
                                            @else
                                            @endif

                                        @endforeach
                                    @endif

                                    <th> Status </th>
                                    <th> Available Quantity </th>
                                    <th> Control </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($product))
                                @if(isset($product->properties) && $product->properties->count() > 0)
                                    @foreach ($product->properties as $key => $property)
                                        <tr>
                                            <td>{{ $key += 1 }}</td>
                                            @if (isset($public_color_values_proparty) && $public_color_values_proparty->count() > 0)
                                            @foreach ($public_color_values_proparty as $key => $public_color)
                                                @if($public_color->values==1)
                                                <td>{!! isset($property->color->name_en) ? $property->color->name_en : '<span class="text-danger">Undefined</span>' !!} </td>
                                                <td>{!! isset($property->color->name_en) ? '<div style="width: 50%;height: 20px; background-color:'.$property->color->color_code.'"</div>' : '<span class="text-danger">Undefined</span>' !!} </td>

                                                @else
                                                @endif



                                            @endforeach
                                        @endif

                                            @if (isset($public_size_values_proparty) && $public_size_values_proparty->count() > 0)
                                            @foreach ($public_size_values_proparty as $key => $public_size)
                                                @if($public_size->values==1)
                                                <td>{!! isset($property->size->name_en) ? $property->size->name_en : '<span class="text-danger">Undefined</span>' !!}</td>
                                                @else
                                                @endif



                                            @endforeach
                                        @endif

                                            <td>{{ $property->status }}</td>
                                            <td>{{ $property->quantity_available }}</td>
                                            {{-- <td>{{ $property->quantity_limit }}</td> --}}
                                            <td>
                                                <a href="{{ route('super_admin.property-show', [$property->id]) }}"
                                                    title="Show" class="mb-1 btn btn-sm btn-info"> <i class="fa fa-eye" aria-hidden="true"></i></a>
                                                <a href="{{ route('super_admin.property-edit', [$property->id]) }}"class=" btn  btn-success">
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
