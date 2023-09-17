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
                                <h3>All reviews
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
                                <li class="breadcrumb-item active"> reviews</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid Ends-->
            <div class="col-sm-12">
                <div class="card">
                     
                    <div class="card-body order-datatable">
                        <table class="display" id="basic-1">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Customer Name</th>
                                    <th>Product Name</th>
                                    <th>comment</th>
                                    <th>rate</th>
                                    <th>Status</th>
                                    <th>created_at</th>
                                    <th> Active</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($reviews))
                                @if ($reviews->count() > 0)
                                    @foreach ($reviews as $review)
                                        <tr>
                                            <td>{{ $review->id }} </td>

                                            <td>{{ $review->customer->name_en }} </td>
                                            <td>{{ $review->product->name_en }} </td>
                                            <td>{{ $review->comment }} </td>
                                            <td>
                                                <span class="fa fa-star {{$review->rate>0 ?'checked':''}}"></span>
                                                <span class="fa fa-star {{$review->rate>1 ?'checked':''}}"></span>
                                                <span class="fa fa-star {{$review->rate>2 ?'checked':''}}"></span>
                                                <span class="fa fa-star {{$review->rate>3 ?'checked':''}}"></span>
                                                <span class="fa fa-star {{$review->rate>4 ?'checked':''}}"></span>
                                            </td>
                                            <td>
                                                @if ($review->status == 1)
                                                <td style="color: #b97d21">Pending</td>
                                            @elseif ($review->status == 2)
                                                <td style="color: #009626">Active</td>
                                            @else
                                                <td style="color: #f32f2f">Rejected</td>
                                            @endif
                                        </td>
                                            <td>{{ $review->created_at }} </td>
                                            <td>
                                                <a href="{{ route('super_admin.reviews-update', [$review->id]) }}"
                                                    title="Active / Inactive" class="process mb-1 btn btn-sm btn-warning"><i
                                                        class="mdi mdi-stop"></i></a>

                                                <a href="{{ route('super_admin.reviews-destroy', [$review->id]) }}"
                                                    title="Archive" class="confirm mb-1 btn btn-sm btn-danger"><i
                                                        class="mdi mdi-close"></i></a>
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
