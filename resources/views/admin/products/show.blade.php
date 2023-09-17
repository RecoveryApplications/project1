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
            <div class="page-body">
              <!-- Container-fluid starts-->
              <div class="container-fluid">
                <div class="page-header">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="page-header-left">
                                <h3> All Products
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
                                <li class="breadcrumb-item active">  All Products</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid Ends-->

                <!-- Container-fluid starts-->
                <div class="profile-content-left pt-5 pb-3 px-3 px-xl-5">
                    <div class="card text-center widget-profile px-0 border-0">
                        <div class="card-img mx-auto rounded-circle">
                            @if (isset($product->image))
                                @if ($product->image && file_exists($product->image))
                                    <img src="{{ asset($product->image) }}" width="100" alt="Image">
                                @else
                                    <img src="{{ asset('front_end_style/images/default.png') }}" width="100"
                                        alt="Image">
                                @endif
                            @elseif(isset($product->image_url))
                                <img src="{{ $product->image_url }}" width="100" alt="Image">
                            @else
                                <img src="{{ asset('front_end_style/images/default.png') }}" width="100" alt="Image">
                            @endif
                        </div>
                        <div class="card-body">
                            <h5 class="py-2 text-dark"> {!! isset($product->name_en) ? $product->name_en : "<span style='color:red;'>Undefined</span>" !!}</h5>
                            <a class="btn btn-primary btn-pill btn-sm my-4"
                                href="{{ isset($product->id) ? route('super_admin.products-edit', [$product->id]) : '#' }}">Update
                                Product <i class="mdi mdi-playlist-edit"></i></a>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">

                    <div class="card tab2-card">
                        <div class="card-body">

                            <ul class="nav nav-tabs tab-coupon" id="myTab" role="tablist">
                                <li class="nav-item"><a class="nav-link active show" id="general-tab" data-bs-toggle="tab"
                                        href="#general" role="tab" aria-controls="general" aria-selected="true"
                                        data-original-title="" title="">Product Info</a></li>
                                <li class="nav-item"><a class="nav-link" id="restriction-tabs" data-bs-toggle="tab"
                                        href="#restriction" role="tab" aria-controls="restriction" aria-selected="false"
                                        data-original-title="" title="">Product Images</a></li>
                                <li class="nav-item"><a class="nav-link" id="usage-tab" data-bs-toggle="tab" href="#usage"
                                        role="tab" aria-controls="usage" aria-selected="false" data-original-title=""
                                        title="">Product Orders</a></li>
                                <li class="nav-item"><a class="nav-link" id="Reviews-tab" data-bs-toggle="tab" href="#Reviews"
                                        role="tab" aria-controls="Reviews" aria-selected="false" data-original-title=""
                                        title="">Product Reviews</a></li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade active show" id="general" role="tabpanel"
                                    aria-labelledby="general-tab">

                                    {{-- ============================================== --}}
                                    {{-- ============= Statistics Counters ============ --}}
                                    {{-- ============================================== --}}
                                    @if (isset($product))
                                        <div class="row mt-4">
                                            {{-- Pendding Orders --}}
                                            <div class="col-xl-6 col-sm-6">
                                                <div class="card card-mini mb-4">
                                                    <div class="card-body">
                                                        <h2 class="mb-1">
                                                            {{ isset($penddingOrders) ? $penddingOrders->count() : 0 }}
                                                            orders
                                                        </h2>
                                                        <h5 style="color: orange;"><i class="mdi mdi-star mdi-spin"></i>
                                                            Pendding
                                                            Orders In Admin
                                                        </h5>

                                                    </div>
                                                </div>
                                            </div>
                                            {{-- Accept Orders --}}
                                            <div class="col-xl-6 col-sm-6">
                                                <div class="card card-mini  mb-4">
                                                    <div class="card-body">
                                                        <h2 class="mb-1">
                                                            {{ isset($acceptedOrders) ? $acceptedOrders->count() : 0 }}
                                                            orders
                                                        </h2>
                                                        <h5 style="color: green;"><i class="mdi mdi-star mdi-spin"></i>
                                                            Accept
                                                            Orders In Admin
                                                        </h5>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    {{-- ================================================= --}}
                                    {{-- ============= Main Product Counters ============= --}}
                                    {{-- ================================================= --}}
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="media widget-media p-4 bg-white border">
                                                <div class="icon rounded-circle mr-4 bg-primary">
                                                    <i class="mdi mdi-timer-sand text-white mdi-spin"></i>
                                                </div>
                                                <div class="media-body align-self-center">
                                                    <h4 class="text-primary mb-2">
                                                        {{ isset($product->cartOperations) ? $product->cartOperations->count() : 0 }}
                                                    </h4>
                                                    <p>All Orders in This Product</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="media widget-media p-4 bg-white border">
                                                <div class="icon rounded-circle bg-success mr-4">
                                                    <i class="mdi mdi-timer-sand text-white mdi-spin"></i>
                                                </div>
                                                <div class="media-body align-self-center">
                                                    <h4 class="text-primary mb-2">
                                                        {{ isset($deliveryOrders) ? $deliveryOrders->count() : 0 }}
                                                    </h4>
                                                    <p>Orders in Delivery</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- ================================================= --}}
                                    {{-- =========== Main Product Information ============ --}}
                                    {{-- ================================================= --}}
                                    <div class="media mt-3 profile-timeline-media">
                                        <div class="media-body">
                                            <h3 class="py-3 text-dark"><i class="mdi mdi-information"></i> Main Product
                                                Information
                                                :</h3>
                                            <table class="table table-hover table-striped">
                                                <thead>
                                                    <tr>
                                                        <th><i class="mdi mdi-account"></i> Name : <span
                                                                style="color:blue;">{!! isset($product->name_en) ? $product->name_en : '<span style="color:red;">Undefined</span>' !!}</span></th>
                                                        <th><i class="mdi mdi-account"></i> Super Category : <span
                                                                style="color:blue;">{!! isset($product->superCategory->name_en)
                                                                    ? $product->superCategory->name_en
                                                                    : '<span style="color:red;">Undefined</span>' !!}</span></th>
                                                    </tr>
                                                    <tr>
                                                        <th><i class="mdi mdi-account"></i> Main Category : <span
                                                                style="color:blue;">{!! isset($product->mainCategory->name_en)
                                                                    ? $product->mainCategory->name_en
                                                                    : '<span style="color:red;">Undefined</span>' !!}</span></th>
                                                        <th><i class="mdi mdi-account"></i> Sub Category : <span
                                                                style="color:blue;">{!! isset($product->subCategory->name_en)
                                                                    ? $product->subCategory->name_en
                                                                    : '<span style="color:red;">Undefined</span>' !!}</span></th>
                                                    </tr>
                                                    <tr>
                                                        <th><i class="mdi mdi-phone"></i> Sale Price : <span
                                                                style="color:blue;">{!! isset($product->sale_price) ? $product->sale_price : '<span style="color:red;">Undefined</span>' !!}</span></th>
                                                        <th><i class="mdi mdi-email"></i> On Sale Price Status : <span
                                                                style="color:blue;">{!! isset($product->on_sale_price_status)
                                                                    ? $product->on_sale_price_status
                                                                    : '<span style="color:red;">Undefined</span>' !!}</span></th>
                                                    </tr>
                                                    <tr>
                                                        <th><i class="mdi mdi-phone"></i> Available Quantity : <span
                                                                style="color:blue;">{!! isset($product->quantity_available)
                                                                    ? $product->quantity_available
                                                                    : '<span style="color:red;">Undefined</span>' !!}</span></th>
                                                        {{-- <th><i class="mdi mdi-email"></i> Limit Quantity : <span
                                                    style="color:blue;">{!! isset($product->quantity_limit) ? $product->quantity_limit : '<span style="color:red;">Undefined</span>' !!}</span></th> --}}
                                                    </tr>
                                                    <tr>
                                                        <th><i class="mdi mdi-phone"></i> On Sale Price : <span
                                                                style="color:blue;">{!! isset($product->on_sale_price) ? $product->on_sale_price : '<span style="color:red;">Undefined</span>' !!}</span></th>
                                                        <th><i class="mdi mdi-phone"></i> Status : <span
                                                                style="color:blue;">{!! isset($product->status) ? $product->status : '<span style="color:red;">Undefined</span>' !!}</span></th>
                                                    </tr>
                                                    <tr>
                                                        <th><i class="mdi mdi-phone"></i> Number of Orders : <span
                                                                style="color:blue;">{!! isset($product->cartOperations)
                                                                    ? $product->cartOperations->count() . ' orders'
                                                                    : '<span style="color:red;">Undefined</span>' !!}</span></th>
                                                    </tr>

                                                    <tr>
                                                        <th><i class="mdi mdi-phone"></i> Private Info : <span
                                                                style="color:blue;">{!! isset($product->private_info) ? $product->private_info : '<span style="color:red;">Undefined</span>' !!}</span></th>
                                                    </tr>

                                                    <tr>
                                                        <th><i class="mdi mdi-clock-outline mdi-spin"></i> Added Since :
                                                            <span style="color:blue;">{!! isset($product->created_at)
                                                                ? $product->created_at->diffForHumans()
                                                                : '<span style="color:red;">Undefined</span>' !!}</span>
                                                        </th>
                                                        <th><i class="mdi mdi-clock-outline mdi-spin"></i> Date & Time of
                                                            Addtion :
                                                            <span style="color:blue;">{!! isset($product->created_at)
                                                                ? date('Y.d.m / h:i A', strtotime($product->created_at))
                                                                : '<span style="color:red;">Undefined</span>' !!}</span>
                                                        </th>
                                                    </tr>
                                                </thead>
                                            </table>

                                            {{-- ================================================= --}}
                                            {{-- ============== Product Description ============== --}}
                                            {{-- ================================================= --}}
                                            <h3 class="py-3 text-dark"><i class="mdi mdi-information"></i> Product Main
                                                Description
                                                AR/EN :</h3>
                                            <table class="table table-hover table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            <p style="color:blue;">
                                                                {{ isset($product->main_description_en) ? $product->main_description_en : '<p style="color:red;">Undefined</p>' }}
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th><span style="color:blue;">{!! isset($product->main_description_ar)
                                                            ? $product->main_description_ar
                                                            : '<span style="color:red;">Undefined</span>' !!}</th>
                                                    </tr>
                                                </thead>
                                            </table>

                                            <h3 class="py-3 text-dark"><i class="mdi mdi-information"></i> Product Sub
                                                Description
                                                AR/EN :</h3>
                                            <table class="table table-hover table-striped">
                                                <thead>
                                                    <tr>
                                                        <th><span style="color:blue;">{!! isset($product->sub_description_en)
                                                            ? $product->sub_description_en
                                                            : '<span style="color:red;">Undefined</span>' !!}</th>
                                                    </tr>
                                                    <tr>
                                                        <th><span style="color:blue;">{!! isset($product->sub_description_ar)
                                                            ? $product->sub_description_ar
                                                            : '<span style="color:red;">Undefined</span>' !!}</th>
                                                    </tr>
                                                </thead>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="restriction" role="tabpanel"
                                    aria-labelledby="restriction-tabs">
                                    <div class="mt-5">
                                        {{-- ============================================== --}}
                                        {{-- ============= Topic Other Images ============= --}}
                                        {{-- ============================================== --}}
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="card card-default"
                                                    style="background-color:rgb(236, 233, 233);">
                                                    <div class="card-body">
                                                        {{-- Card Header : --}}

                                                        {{-- Card Body : --}}
                                                        <div class="card-body">
                                                            {{-- Add Other Images Form --}}
                                                            <form
                                                                action="{{ route('super_admin.products-addImages', $product->id) }}"
                                                                method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                <input type="hidden" name="product_id"
                                                                    value="{{ $product->id }}">

                                                                <div class="form-row">
                                                                    {{-- Product Other Images Input --}}
                                                                    <div class="col-md-6 mb-3">
                                                                        <label class="text-dark font-weight-medium mb-3"
                                                                            for="validationServer01">Product Other Images :
                                                                            <strong class="text-danger"> *
                                                                            </strong></label>
                                                                        <div class="input-group">

                                                                            <input type="file"
                                                                                name="product_other_images[]"
                                                                                class="form-control"
                                                                                id="validationServer01" multiple>
                                                                        </div>
                                                                    </div>

                                                                    {{-- Button --}}
                                                                    <div class="col-md-6 mb-3">
                                                                        <label class="text-dark font-weight-medium mb-3"
                                                                            for="validationServer01">Save Product Other
                                                                            Images :
                                                                        </label>
                                                                        <div class="input-group">

                                                                            <button type="submit"
                                                                                class="btn btn-success btn-sm form-control">Upload
                                                                                Images </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="card-img mx-auto rounded-circle">
                                                            <hr>
                                                            @if (isset($product) && $product->productImages->count() > 0)
                                                                <div class="row">
                                                                    @foreach ($product->productImages as $productImage)
                                                                        @if (isset($productImage->image) && $productImage->image && file_exists($productImage->image))
                                                                            <div class="col-md-4">
                                                                                <img src="{{ asset($productImage->image) }}"
                                                                                    class="img-thumbnail image-preview"
                                                                                    alt="Topic Other Image"
                                                                                    style="border:double 3px black; margin-bottom:5px; margin-top:5px;">
                                                                                <a href="{{ route('super_admin.products-deleteImages', $productImage->id) }}"
                                                                                    class="confirm btn btn-danger btn-sm"><i
                                                                                        class="fa fa-trash"></i> Delete
                                                                                    image</a>
                                                                            </div>
                                                                        @else
                                                                            <div class="col-md-4">
                                                                                <img src="{{ asset('front_end_style/images/default.png') }}"
                                                                                    class="img-thumbnail image-preview"
                                                                                    alt="Topic Other Image"
                                                                                    style="border:double 3px black; margin-bottom:5px; margin-top:5px;">
                                                                            </div>
                                                                        @endif
                                                                    @endforeach
                                                                </div>
                                                            @else
                                                                <h3 style="color:red;">No images uploaded</h3>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="usage" role="tabpanel" aria-labelledby="usage-tab">
                                    <div class="mt-5">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="card-body order-datatable">
                                                <table class="display" id="basic-1">
                                                    <thead>
                                                        <tr>
                                                            <th><i class="mdi mdi-account-question"></i> Post Title</th>
                                                            <th><i class="mdi mdi-account-question"></i> Post Since</th>
                                                            <th><i class="mdi mdi-account-question"></i> Post Date/Time
                                                            </th>
                                                            <th><i class="mdi mdi-account-question"></i> Post Details</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        {{-- Super Admin --}}
                                                        @if (isset($activitylogs))
                                                            @if ($activitylogs->count() > 0)
                                                                @foreach ($activitylogs->sortBy('created_at') as $index => $activitylog)
                                                                    <tr>
                                                                        <td>{!! isset($activitylog->activity_key_type) ? $activitylog->activity_key_type : "<span style='color:red;'>Undefined</span>" !!}</td>
                                                                        <td>{!! isset($activitylog->created_at) ? $activitylog->created_at->diffForHumans() : "<span style='color:red;'>Undefined</span>" !!}</td>
                                                                        {{-- <td>{!! (isset($activitylog->created_at) ?  date('Y.d.m / h:i A', strtotime($activitylog->created_at)) : "<span style='color:red;'>Undefined</span>") !!}</td> --}}
                                                                        <td>{!! isset($activitylog->created_at) ? $activitylog->created_at : "<span style='color:red;'>Undefined</span>" !!}</td>
                                                                        <td>
                                                                            @if (isset($activitylog->id) && isset($activitylog->related_id) && isset($activitylog->model_name))
                                                                                <a href="{{ route('super_admin.activity_logs-show', [$activitylog->id]) }}"
                                                                                    title="Show"
                                                                                    class="mb-1 btn btn-sm btn-primary"><i
                                                                                        class="mdi mdi-eye"></i> View
                                                                                    Details</a>
                                                                            @endif
                                                                            {{-- {!! isset($activitylog->related_id) && isset($activitylog->model_name) ? $activitylog->related_id : "<span style='color:red;'>Undefined</span>" !!} --}}
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
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="Reviews" role="tabpanel" aria-labelledby="Reviews-tab">
                                    <div class="mt-5">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="card-body order-datatable">
                                                <table class="display" id="basic-1">
                                                    <thead>
                                                        <tr>
                                                            <th><i class="mdi mdi-account-question"></i> Name</th>
                                                            <th><i class="mdi mdi-account-question"></i> comment</th>
                                                            <th><i class="mdi mdi-account-question"></i> rate</th>
                                                            <th><i class="mdi mdi-account-question"></i> status</th>
                                                            <th><i class="mdi mdi-account-question"></i> Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        {{-- Super Admin --}}
                                                        @if (isset($rates))
                                                            @if ($rates->count() > 0)
                                                                @foreach ($rates->sortBy('created_at') as $index => $rate)
                                                                    <tr>
                                                                        <td>{{ $rate->customer->name_en }}</td>
                                                                        <td>{{ $rate->comment }}</td>
                                                                        <td>{{ $rate->rate }}</td>

                                                                        @if ($rate->status == 1)
                                                                            <td style="color: #b97d21">Pending</td>
                                                                        @elseif ($rate->status == 2)
                                                                            <td style="color: #009626">Active</td>
                                                                        @else
                                                                            <td style="color: #f32f2f">Rejected</td>
                                                                        @endif

                                                                        <td>
                                                                            <a href="{{ route('super_admin.reviews-update', [$rate->id]) }}"
                                                                                title="Active / Inactive"
                                                                                class="process mb-1 btn btn-sm btn-warning"><i
                                                                                    class="mdi mdi-stop"></i></a>

                                                                            <a href="{{ route('super_admin.reviews-destroy', [$rate->id]) }}"
                                                                                title="Archive"
                                                                                class="confirm mb-1 btn btn-sm btn-danger"><i
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
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- Container-fluid Ends-->
            </div>
        @endsection
