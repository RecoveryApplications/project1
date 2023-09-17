@extends('admin.layouts.app')

{{-- @section('admin_css')
    <link href="{{ asset('resources/dashboard_files/assets/plugins/data-tables/datatables.bootstrap4.min.css') }}"
        rel="stylesheet">
    <link href="{{ asset('resources/dashboard_files/assets/css/sleek.min.css') }}">
@endsection --}}

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css">
    {{-- ============================================== --}}
    {{-- ================== Header ==================== --}}
    {{-- ============================================== --}}
    <div class="page-body">
        <!-- Container-fluid starts-->
        <div class="container-fluid">
          <div class="page-header">
              <div class="row">
                  <div class="col-lg-6">
                      <div class="page-header-left">
                          <h3> Property Details
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
                          <li class="breadcrumb-item active">  Property Details</li>
                      </ol>
                  </div>
              </div>
          </div>
      <!-- Container-fluid Ends-->

        {{-- <div>
            <a href="{{ route('super_admin.property-edit', $property->id) }}" class="btn btn-primary btn-pill btn-sm my-4"><i
                    class="mdi mdi-playlist-edit"></i> Edit This Property </a>
        </div> --}}
    </div>


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
                        swal("Oops !!!", "{!! Session::get('danger') !!}", "error", {
                            button: "Close",
                        });
                    </script>
                @endif
            </div>

            {{-- ================================================================================================= --}}
            {{-- ========================================= Left Section ========================================== --}}
            {{-- ================================================================================================= --}}
            <div class="col-lg-12 col-xl-12">
                <div class="profile-content-left pt-5 pb-3 px-3 px-xl-5">
                    <div class="card text-center widget-profile px-0 border-0">
                        <div class="card-img mx-auto rounded-circle">
                            @if (isset($property->image))
                                @if ($property->image && file_exists($property->image))
                                    <img src="{{ asset($property->image) }}" width="100" alt="Image">
                                @else
                                    <img src="{{ asset('front_end_style/images/default.png') }}" width="100" alt="Image">
                                @endif
                            @elseif(isset($property->image_url))
                                <img src="{{ $property->image_url }}" width="100" alt="Image">
                            @else
                                <img src="{{ asset('front_end_style/images/default.png') }}" width="100" alt="Image">
                            @endif
                        </div>

                        <div class="card-body">
                            <h5 class="py-2 text-dark"> {!! isset($product->name_en) ? $product->name_en : "<span style='color:red;'>Undefined</span>" !!}</h5>
                            <a href="{{ route('super_admin.property-edit', $property->id) }}" class="btn btn-primary btn-pill btn-sm my-4"><i class="mdi mdi-playlist-edit"></i> Edit This Property </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================================================================================================= --}}
            {{-- ========================================== Right Section ========================================= --}}
            {{-- ================================================================================================= --}}
            <div class="col-lg-12 col-xl-12">
                 <!-- Container-fluid starts-->
                 <div class="container-fluid">
                    <div class="card tab2-card">
                        <div class="card-body">
                            <ul class="nav nav-tabs tab-coupon" id="myTab" role="tablist">
                                <li class="nav-item"><a class="nav-link active show" id="general-tab"
                                        data-bs-toggle="tab" href="#general" role="tab" aria-controls="general"
                                        aria-selected="true" data-original-title="" title=""> Property Info</a></li>
                                <li class="nav-item"><a class="nav-link" id="restriction-tabs" data-bs-toggle="tab"
                                        href="#restriction" role="tab" aria-controls="restriction" aria-selected="false"
                                        data-original-title="" title="">Property Images</a></li>
                                <li class="nav-item"><a class="nav-link" id="usage-tab" data-bs-toggle="tab"
                                        href="#usage" role="tab" aria-controls="usage" aria-selected="false"
                                        data-original-title="" title="">Product Orders</a></li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                  {{-- ============================================== --}}
                        {{-- ============= All Error Messages ============= --}}
                        {{-- ============================================== --}}
                        <div class="mt-3">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <h3>Please correct the following errors : </h3>
                                    <hr>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>- {{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>

                        {{-- ============================================================================== --}}
                        {{-- =========================== Product Info Tab Body ============================ --}}
                        {{-- ============================================================================== --}}

                                <div class="tab-pane fade active show" id="general" role="tabpanel"
                                    aria-labelledby="general-tab">
                                        {{-- ================================================= --}}
                                        {{-- =========== Main Product Information ============ --}}
                                        {{-- ================================================= --}}
                                        <div class="media mt-3 profile-timeline-media">
                                            <div class="media-body">
                                                <h3 class="py-3 text-dark"><i class="mdi mdi-information"></i> Main Product Information
                                                    :</h3>
                                                <table class="table table-hover table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th><i class="mdi mdi-settings mdi-spin"></i> Name : <span
                                                                    style="color:blue;">{!! isset($product->name_en) ? $product->name_en : '<span style="color:red;">Undefined</span>' !!}</span></th>
                                                        </tr>
                                                        <tr>

                                                        <th><i class="mdi mdi-settings mdi-spin"></i> Main Category : <span
                                                                    style="color:blue;">{!! isset($product->mainCategory->name_en) ? $product->mainCategory->name_en : '<span style="color:red;">Undefined</span>' !!}</span></th>
                                                        </tr>
                                                        <tr>
                                                            <th><i class="mdi mdi-settings mdi-spin"></i> Sub Category : <span
                                                                    style="color:blue;">{!! isset($product->subCategory->name_en) ? $product->subCategory->name_en : '<span style="color:red;">Undefined</span>' !!}</span></th>
                                                            <th><i class="mdi mdi-settings mdi-spin"></i> Property Size : <span
                                                                    style="color:blue;">{!! isset($property->size->name_en) ? $property->size->name_en : '<span style="color:red;">Undefined</span>' !!}</span></th>
                                                        </tr>
                                                        <tr>
                                                            <th class="row"><i class="mdi mdi-settings mdi-spin" style="width:5%"></i> Property Color : <span style="color:blue;width:auto;">{!! isset($property->color->name_en) ? $property->color->name_en : '<span style="color:red;">Undefined</span>' !!}</span>
                                                                <i class="mdi mdi-settings mdi-spin" style="width: 5%"></i> Property Color : <div style="background:@if(isset($property->color->color_code)) {{ $property->color->color_code }}; @endif width: 25%;height: 20px;margin-top: 5px;margin-left: 10px;"></div>
                                                            </th>
                                                                <th><i class="mdi mdi-settings mdi-spin"></i> Number of Orders : <span
                                                                        style="color:blue;">{!! isset($property->cartOperations) ? $property->cartOperations->count() . ' orders' : '<span style="color:red;">Undefined</span>' !!}</span></th>
                                                        </tr>

                                                        <tr>
                                                            <th><i class="mdi mdi-settings mdi-spin"></i> Sale Price : <span
                                                                    style="color:blue;">{!! isset($property->sale_price) ? $property->sale_price : '<span style="color:red;">Undefined</span>' !!}</span></th>
                                                            <th><i class="mdi mdi-settings mdi-spin"></i> On Sale Price Status : <span
                                                                    style="color:blue;">{!! isset($property->on_sale_price_status) ? $property->on_sale_price_status : '<span style="color:red;">Undefined</span>' !!}</span></th>
                                                        </tr>
                                                        <tr>
                                                            <th><i class="mdi mdi-settings mdi-spin"></i> Available Quantity : <span
                                                                    style="color:blue;">{!! isset($property->quantity_available) ? $property->quantity_available : '<span style="color:red;">Undefined</span>' !!}</span></th>
                                                            {{-- <th><i class="mdi mdi-settings mdi-spin"></i> Limit Quantity : <span
                                                                    style="color:blue;">{!! isset($property->quantity_limit) ? $property->quantity_limit : '<span style="color:red;">Undefined</span>' !!}</span></th> --}}
                                                        </tr>
                                                        <tr>
                                                            <th><i class="mdi mdi-settings mdi-spin"></i> On Sale Price : <span
                                                                    style="color:blue;">{!! isset($property->on_sale_price) ? $property->on_sale_price : '<span style="color:red;">Undefined</span>' !!}</span></th>
                                                            <th><i class="mdi mdi-settings mdi-spin"></i> Status : <span
                                                                    style="color:blue;">{!! isset($property->status) ? $property->status : '<span style="color:red;">Undefined</span>' !!}</span></th>
                                                        </tr>
                                                        <tr>
                                                            <th><i class="mdi mdi-clock-outline mdi-spin"></i> Added Since : <span
                                                                    style="color:blue;">{!! isset($property->created_at) ? $property->created_at->diffForHumans() : '<span style="color:red;">Undefined</span>' !!}</span></th>
                                                            <th><i class="mdi mdi-clock-outline mdi-spin"></i> Date & Time of Addtion :
                                                                <span style="color:blue;">{!! isset($property->created_at) ? date('Y.d.m / h:i A', strtotime($property->created_at)) : '<span style="color:red;">Undefined</span>' !!}</span>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                </table>

                                                {{-- ================================================= --}}
                                                {{-- ============== Product Description ============== --}}
                                                {{-- ================================================= --}}
                                                <h3 class="py-3 text-dark"><i class="mdi mdi-information"></i> Product Main Description :</h3>
                                                <table class="table table-hover table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th><span style="color:blue;">{!! isset($product->main_description_en) ? $product->main_description_en : '<span style="color:red;">Undefined</span>' !!}</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                                <h3 class="py-3 text-dark"><i class="mdi mdi-information"></i> Product Sub Description :</h3>
                                                <table class="table table-hover table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th><span style="color:blue;">{!! isset($product->sub_description_en) ? $product->sub_description_en : '<span style="color:red;">Undefined</span>' !!}</th>
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
                                                <div class="card card-default" >
                                                    <div class="card-body">
                                                        {{-- Card Header : --}}
                                                        <div class="card-header card-header-border-bottom"
                                                           >
                                                            <h2 >Property Other Images :</h2>
                                                        </div>
                                                        {{-- Card Body : --}}
                                                        <div class="card-body">
                                                            {{-- Add Other Images Form --}}
                                                            <form
                                                                action="{{ route('super_admin.properties-addImages', $property->id) }}"
                                                                method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                <input type="hidden" name="property_id"
                                                                    value="{{ $property->id }}">

                                                                <div class="form-row">
                                                                    {{-- property Other Images Input --}}
                                                                    <div class="col-md-6 mb-3">
                                                                        <label class="text-dark font-weight-medium mb-3"
                                                                            for="validationServer01">Property Other Images : <strong
                                                                                class="text-danger"> * </strong></label>
                                                                        <div class="input-group">
                                                                            <input type="file" name="property_other_images[]"
                                                                                class="form-control" id="validationServer01"
                                                                                multiple>
                                                                        </div>
                                                                    </div>

                                                                    {{-- Button --}}
                                                                    <div class="col-md-6 mb-3">
                                                                        <label class="text-dark font-weight-medium mb-3"
                                                                            for="validationServer01">Save Property Other Images :
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
                                                            @if (isset($property) && $property->propertyImages->count() > 0)
                                                                <div class="row">
                                                                    @foreach ($property->propertyImages as $productImage)
                                                                        @if (isset($productImage->image) && $productImage->image && file_exists($productImage->image))
                                                                            <div class="col-md-4">
                                                                                <img src="{{ asset($productImage->image) }}"
                                                                                    class="img-thumbnail image-preview"
                                                                                    alt="Topic Other Image"
                                                                                    style="width: 250px;height: 250px;;border:double 3px black; margin-bottom:5px; margin-top:5px;">
                                                                                <a href="{{ route('super_admin.properties-deleteImages', $productImage->id) }}"
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
                                                <table id="hoverable-data-table_1" class="table table-hover table-striped">
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

                        </div>
                    </div>
                </div>
                <!-- Container-fluid Ends-->
            </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"></script>

@endsection

@section('admin_javascript')
    <script>
        jQuery(document).ready(function() {
            jQuery('#hoverable-data-table_1').DataTable({
                "aLengthMenu": [
                    [20, 30, 50, 75, -1],
                    [20, 30, 50, 75, "All"]
                ],
                "pageLength": 20,
                "dom": '<"row justify-content-between top-information"lf>rt<"row justify-content-between bottom-information"ip><"clear">',
                "order": [
                    [2, "desc"]
                ]
            });
            jQuery('#hoverable-data-table_2').DataTable({
                "aLengthMenu": [
                    [20, 30, 50, 75, -1],
                    [20, 30, 50, 75, "All"]
                ],
                "pageLength": 20,
                "dom": '<"row justify-content-between top-information"lf>rt<"row justify-content-between bottom-information"ip><"clear">',
                "order": [
                    [2, "desc"]
                ]
            });
            jQuery('#hoverable-data-table_3').DataTable({
                "aLengthMenu": [
                    [20, 30, 50, 75, -1],
                    [20, 30, 50, 75, "All"]
                ],
                "pageLength": 20,
                "dom": '<"row justify-content-between top-information"lf>rt<"row justify-content-between bottom-information"ip><"clear">',
                "order": [
                    [2, "desc"]
                ]
            });
        });
    </script>
    <script src="{{ asset('dashboard_files/assets/plugins/data-tables/jquery.datatables.min.js') }}">
    </script>
    <script src="{{ asset('dashboard_files/assets/plugins/data-tables/datatables.bootstrap4.min.js') }}">
    </script>

@endsection
