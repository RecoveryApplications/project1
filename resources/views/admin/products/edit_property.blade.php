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
                <!-- Container-fluid starts-->
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="page-header-left">
                                    <h3>Update Product <span class="text-danger">{{ $property->product->name_en }}
                                            Properties</span>
                                        {{-- <small>Multikart Admin panel</small> --}}
                                    </h3>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <ol class="breadcrumb pull-right">
                                    <li class="breadcrumb-item">
                                        <a href="index.html">
                                            <i data-feather="home"></i>
                                        </a>
                                    </li>
                                    {{-- <li class="breadcrumb-item">Coupons </li> --}}
                                    <li class="breadcrumb-item active">Edit
                                        Property</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Container-fluid Ends-->

                {{-- ============================================== --}}
                {{-- =================== Body ===================== --}}
                {{-- ============================================== --}}
                <div class="content-wrapper">
                    <div class="content">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card card-default">
                                    <div class="card-header justify-content-between ">
                                        {{-- <h2 style="color:white;"><i class="mdi mdi-star mdi-spin"></i> طلبات سحب الرصيد : </h2> --}}
                                    </div>
                                    <div class="card-body">
                                        {{-- print errors if exists --}}

                                        @if ($errors->any())
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                @foreach ($errors->all() as $error)
                                                    <strong>Error!</strong> {{ $error }}
                                                @endforeach
                                            </div>
                                        @endif

                                        <form action="{{ route('super_admin.property-update', [$property->id]) }}"
                                            method="POST" id="updateForm" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-row row product-adding">
                                                <input type="hidden" id="product_id" name="product_id"
                                                    value="{{ $property->product->id }}">
                                                <input type="hidden" id="product_id" name="property_id"
                                                    value="{{ $property->id }}">

                                                @if (isset($public_color_values_proparty) && $public_color_values_proparty->count() > 0)
                                                    @foreach ($public_color_values_proparty as $key => $public_color)
                                                        @if ($public_color->values == 1)
                                                            {{-- Name AR --}}
                                                            <div class="mb-3 col-md-6">
                                                                <label class="mb-3 text-dark font-weight-medium"
                                                                    for="validationServer01">
                                                                    <i class="mdi mdi-account"></i> Color : <strong
                                                                        class="text-danger">
                                                                        *
                                                                        @error('main_color_id')
                                                                            ({{ $message }})
                                                                        @enderror
                                                                    </strong>
                                                                </label>
                                                                <div class="input-group">
                                                                    <select name="main_color_id" class="form-control"
                                                                        id="inlineFormCustomSelectPref">
                                                                        @if (isset($colors) && $colors->count() > 0)
                                                                            @foreach ($colors as $color)
                                                                                <option value="{{ $color->id }}"
                                                                                    style="font-weight: bolder ;color: {{ $color->color_code }}">
                                                                                    {{ $color->name_en }}</option>
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        @else
                                                        @endif
                                                    @endforeach
                                                @endif


                                                @if (isset($public_size_values_proparty) && $public_size_values_proparty->count() > 0)
                                                    @foreach ($public_size_values_proparty as $key => $public_size)
                                                        @if ($public_size->values == 1)
                                                            {{-- Name EN --}}
                                                            <div class="mb-3 col-md-6">
                                                                <label class="mb-3 text-dark font-weight-medium"
                                                                    for="validationServer01">
                                                                    <i class="mdi mdi-account"></i> Size : <strong
                                                                        class="text-danger">
                                                                        *
                                                                        @error('main_size_id')
                                                                            ({{ $message }})
                                                                        @enderror
                                                                    </strong>
                                                                </label>
                                                                <div class="input-group">
                                                                    <select name="main_size_id" class="form-control"
                                                                        id="inlineFormCustomSelectPref">
                                                                        @if (isset($sizes) && $sizes->count() > 0)
                                                                            @foreach ($sizes as $size)
                                                                                <option value="{{ $size->id }}">
                                                                                    {{ $size->name_en }}</option>
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        @else
                                                        @endif
                                                    @endforeach
                                                @endif

                                                {{-- Sale Price --}}
                                                <div class="mb-3 col-md-6">
                                                    <label class="mb-3 text-dark font-weight-medium"
                                                        for="validationServer01">
                                                        <i class="mdi mdi-account"></i> Sale Price : <strong
                                                            class="text-danger"> * @error('sale_price')
                                                                ( {{ $message }} )
                                                            @enderror
                                                        </strong>
                                                    </label>
                                                    <div class="input-group">
                                                        <input type="number" name="sale_price" step="0.001"
                                                            class="form-control @error('sale_price') is-invalid @enderror"
                                                            id="validationServer01" placeholder="Sale Price"
                                                            value="{{ isset($property->sale_price) ? $property->sale_price : null }}">
                                                    </div>
                                                </div>

                                                {{-- On Sale Price Status --}}
                                                <div class="mb-3 col-md-6">
                                                    <label class="mb-3 text-dark font-weight-medium"
                                                        for="validationServer01">
                                                        <i class="mdi mdi-account-switch"></i> On Sale Price Status :
                                                        <strong class="text-danger"> * @error('on_sale_price_status')
                                                                ( {{ $message }} )
                                                            @enderror
                                                        </strong>
                                                    </label>
                                                    <div class="input-group">
                                                        <select name="on_sale_price_status"
                                                            class="form-control @error('on_sale_price_status') is-invalid @enderror"
                                                            id="inlineFormCustomSelectPref">
                                                            <option value="">Select Status...</option>
                                                            <option value="1"
                                                                @if ($property->on_sale_price_status == 'Active') selected @endif>Active
                                                            </option>
                                                            <option value="2"
                                                                @if ($property->on_sale_price_status == 'Inactive') selected @endif>Inactive
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>

                                                {{-- On Sale Price --}}
                                                <div class="mb-3 col-md-6">
                                                    <label class="mb-3 text-dark font-weight-medium"
                                                        for="validationServer01">
                                                        <i class="mdi mdi-account"></i> On Sale Price : <strong
                                                            class="text-danger"> * @error('on_sale_price')
                                                                ( {{ $message }} )
                                                            @enderror
                                                        </strong>
                                                    </label>
                                                    <div class="input-group">
                                                        <input type="number" name="on_sale_price" step="0.001"
                                                            class="form-control @error('on_sale_price') is-invalid @enderror"
                                                            id="validationServer01" placeholder="On Sale Price"
                                                            value="{{ isset($property->on_sale_price) ? $property->on_sale_price : $property->on_sale_price }}">
                                                    </div>
                                                </div>

                                                {{-- Available Quantity --}}
                                                <div class="mb-3 col-md-6">
                                                    <label class="mb-3 text-dark font-weight-medium"
                                                        for="validationServer01">
                                                        <i class="mdi mdi-account"></i> Available Quantity : <strong
                                                            class="text-danger"> * @error('quantity_available')
                                                                ( {{ $message }} )
                                                            @enderror
                                                        </strong>
                                                    </label>
                                                    <div class="input-group">
                                                        <input type="number" name="quantity_available" step="1"
                                                            class="form-control @error('quantity_available') is-invalid @enderror"
                                                            id="validationServer01" placeholder="Available Quantity"
                                                            value="{{ $property->quantity_available }}">
                                                    </div>
                                                </div>

                                                {{-- Limit Quantity --}}
                                                {{-- <div class="mb-3 col-md-6">
                                                    <label class="mb-3 text-dark font-weight-medium"
                                                        for="validationServer01">
                                                        <i class="mdi mdi-account"></i> Limit Quantity : <strong class="text-danger"> * @error('quantity_limit') ( {{ $message }} ) @enderror</strong>
                                                    </label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text mdi mdi-account" id="inputGroupPrepend2"></span>
                                                        </div>
                                                        <input type="number" name="quantity_limit" step="1" class="form-control @error('quantity_limit') is-invalid @enderror" id="validationServer01"
                                                        placeholder="Limit Quantity" value="{{ $property->quantity_limit }}">
                                                    </div>
                                                </div> --}}
                                                {{-- Status --}}
                                                <div class="mb-3 col-md-6">
                                                    <label class="mb-3 text-dark font-weight-medium"
                                                        for="validationServer01">
                                                        <i class="mdi mdi-account-switch"></i> Status : <strong
                                                            class="text-danger"> * @error('status')
                                                                ( {{ $message }} )
                                                            @enderror
                                                        </strong>
                                                    </label>
                                                    <div class="input-group">
                                                        <select name="status"
                                                            class="form-control @error('status') is-invalid @enderror"
                                                            id="inlineFormCustomSelectPref">
                                                            <option value="">Select Status...</option>
                                                            <option value="1"
                                                                @if (isset($property->status) && $property->status == 'Active') selected @endif>Active
                                                            </option>
                                                            <option value="2"
                                                                @if (isset($property->status) && $property->status == 'Inactive') selected @endif>Inactive
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>

                                                {{-- Image Filed --}}
                                                <div class="mb-3 col-md-6">
                                                    <label class="mb-3 text-dark font-weight-medium"
                                                        for="validationServer01">
                                                        <i class="mdi mdi-image"></i> Image : <strong class="text-danger">
                                                            @error('image')
                                                                * ( {{ $message }} )
                                                            @enderror
                                                        </strong>
                                                    </label>
                                                    <div class="input-group">
                                                        <input type="file" name="image" class="form-control"
                                                            id="validationServer01" placeholder="Image">
                                                    </div>
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label class="mb-3 text-dark font-weight-medium"
                                                        for="validationServer01">
                                                        <i class="mdi mdi-image"></i> Image URL : <strong
                                                            class="text-danger"> @error('image_url')
                                                                ( {{ $message }} )
                                                            @enderror
                                                        </strong>
                                                    </label>
                                                    <div class="input-group">
                                                        <input type="url" name="image_url" class="form-control"
                                                            id="validationServer01" value="{{ $property->image_url }}"
                                                            placeholder="Image URL">
                                                    </div>
                                                </div>

                                                {{-- Display Image --}}
                                                <div class="mb-3 col-md-6">
                                                    @if (isset($property->image))
                                                        @if ($property->image && file_exists($property->image))
                                                            <img src="{{ asset($property->image) }}" width="100"
                                                                height="100"
                                                                style="border-radius: 10px; border:solid 1px black;">
                                                        @else
                                                            <img src="{{ asset('front_end_style/images/default.png') }}"
                                                                width="100" height="100">
                                                        @endif
                                                    @elseif(isset($property->image_url))
                                                        <img src="{{ $property->image_url }}" width="100"
                                                            height="100">
                                                    @else
                                                        <img src="{{ asset('front_end_style/images/default.png') }}"
                                                            width="100" height="70">
                                                    @endif
                                                </div>

                                            </div>

                                            {{-- Button --}}
                                            <button class="btn btn-primary" type="submit"><i
                                                    class="mdi mdi-content-save-all"></i> Save Updates</button>
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
@section('admin_javascript')
    <script>
        $(document).ready(function() {
            super_id = $("#super_category_id").val();
            if (super_id != "") {
                setTimeout(() => {
                    getMainCategories();
                }, 500);
            }


            setTimeout(() => {
                main_id = $("#main_category_id").val();
                if (main_id !== "") {
                    getSubCategories();
                }

            }, 1000);
        });

        $(document).on("change", "#super_category_id", function() {

            getMainCategories();

        });

        $(document).on("change", "#main_category_id", function() {

            getSubCategories();

        });

        function getMainCategories() {

            super_category_id = $("#super_category_id").val();

            formData = new FormData();
            formData.append('super_category_id', super_category_id);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: "{{ route('super_admin.getMainCategories') }}",
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success: function(data) {
                    if (data['status'] == true) {
                        old_main = $("#old_main").val();
                        // console.log(old_main);
                        $("#main_category_id").html('');
                        html = '<option value="">Select Main Category....</option>';
                        for (let key = 0; key < data.mainCategories.length; key++) {
                            // console.log(data.mainCategories[key]['id']);
                            if (old_main == data.mainCategories[key]['id']) {
                                html += '<option value="' + data.mainCategories[key]['id'] + '" selected>' +
                                    data.mainCategories[key]['name_en'] + '</option>';
                            } else {
                                html += '<option value="' + data.mainCategories[key]['id'] + '">' + data
                                    .mainCategories[key]['name_en'] + '</option>';
                            }
                        }
                        $("#main_category_id").html(html);

                    }
                },
                error: function(data) {

                }
            });
        }


        function getSubCategories() {

            main_category_id = $("#main_category_id").val();

            formData = new FormData();
            formData.append('main_category_id', main_category_id);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: "{{ route('super_admin.getSubCategories') }}",
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success: function(data) {
                    if (data['status'] == true) {
                        old_sub = $("#old_sub").val();
                        // console.log(old_main);
                        $("#sub_category_id").html('');
                        html = '<option value="">Select Sub Category....</option>';
                        for (let key = 0; key < data.subCategories.length; key++) {
                            // console.log(data.mainCategories[key]['id']);
                            if (old_sub == data.subCategories[key]['id']) {
                                html += '<option value="' + data.subCategories[key]['id'] + '" selected>' + data
                                    .subCategories[key]['name_en'] + '</option>';
                            } else {
                                html += '<option value="' + data.subCategories[key]['id'] + '">' + data
                                    .subCategories[key]['name_en'] + '</option>';
                            }
                        }
                        $("#sub_category_id").html(html);

                    }
                },
                error: function(data) {

                }
            });
        }
    </script>
@endsection
