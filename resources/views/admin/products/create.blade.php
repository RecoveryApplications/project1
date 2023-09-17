@extends('admin.layouts.app')

@section('admin_css')
    <link href="{{ asset('dashboard_files/assets/plugins/data-tables/datatables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard_files/assets/css/sleek.min.css') }}">
@endsection
@if ($errors->any())

            @foreach ($errors->all() as $error)
                @php
                    dump($error)
                @endphp
            @endforeach
@endif

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
                                    <h3>Add New Product
                                        {{-- <small>Multikart Admin panel</small> --}}
                                    </h3>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <ol class="breadcrumb pull-right">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('super_admin.dashboard') }}">
                                            <i data-feather="home"></i>
                                        </a>
                                    </li>
                                    {{-- <li class="breadcrumb-item">Sales</li> --}}
                                    <li class="breadcrumb-item active">Add New Product</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Container-fluid Ends-->

                {{-- ============================================== --}}
                {{-- ==================== Body ==================== --}}
                {{-- ============================================== --}}
                <div class="content-wrapper">
                    <div class="content">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card card-default">
                                    <div class="card-body">
                                        <form action="{{ route('super_admin.products-store') }}" method="POST"
                                            enctype="multipart/form-data" id="createForm">
                                            @csrf
                                            <div class="form-row">
                                                <input type="hidden" id="old_main" value="{{ old('main_category_id') }}">
                                                <input type="hidden" id="old_sub" value="{{ old('sub_category_id') }}">
                                                <input type="hidden" id="old_brand" value="{{ old('brand_id') }}">
                                                <div class="row product-adding">
                                                    <div class="col-xl-6">
                                                        {{-- Name EN --}}
                                                        <div class="form-group row">
                                                            <label class="mb-3 text-dark font-weight-medium"
                                                                for="validationServer01">
                                                                <i class="mdi mdi-account"></i> Name EN: <strong
                                                                    class="text-danger"> * @error('name_en')
                                                                        (
                                                                        {{ $message }} )
                                                                    @enderror
                                                                </strong>
                                                            </label>
                                                            <div class="input-group">

                                                                <input type="text" name="name_en"
                                                                    class="form-control @error('name_en') is-invalid @enderror"
                                                                    id="validationServer01" placeholder="Name EN"
                                                                    value="{{ old('name_en') }}">
                                                            </div>
                                                        </div>
                                                        {{-- Name AR --}}
                                                        <div class="form-group row">
                                                            <label class="mb-3 text-dark font-weight-medium"
                                                                for="validationServer01">
                                                                <i class="mdi mdi-account"></i> Name AR: <strong
                                                                    class="text-danger"> * @error('name_ar')
                                                                        (
                                                                        {{ $message }} )
                                                                    @enderror
                                                                </strong>
                                                            </label>
                                                            <div class="input-group">

                                                                <input type="text" name="name_ar"
                                                                    class="form-control @error('name_ar') is-invalid @enderror"
                                                                    id="validationServer01" placeholder="Name AR"
                                                                    value="{{ old('name_ar') }}">
                                                            </div>
                                                        </div>
                                                        {{-- Main Category --}}
                                                        <div class="form-group row">
                                                            <label class="mb-3 text-dark font-weight-medium"
                                                                for="validationServer01">Main Category :</label>
                                                            <div class="col-xl-12 col-sm-12">
                                                                <select name="main_category_id" class="form-control digits"
                                                                    id="main_category_id">
                                                                    <option value="" selected>Choose...</option>
                                                                    @if (isset($categories) && $categories->count() > 0)
                                                                        @foreach ($categories as $category)
                                                                            <option value="{{ $category->id }}">
                                                                                {{ $category->name_en }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>

                                                        </div>

                                                        {{-- Sub Category --}}
                                                        <div class="form-group row">
                                                            <label class="mb-3 text-dark font-weight-medium"
                                                                for="validationServer01">
                                                                <i class="mdi mdi-account"></i> Sub Category : <strong
                                                                    class="text-danger"> @error('sub_category_id')
                                                                        (
                                                                        {{ $message }} )
                                                                    @enderror
                                                                </strong>
                                                            </label>
                                                            <div class="input-group">

                                                                <select name="sub_category_id" id="sub_category_id"
                                                                    class="form-control selectpicker"
                                                                    data-live-search="true">
                                                                    <option value="">Select Sub Category....</option>
                                                                </select>
                                                            </div>
                                                        </div>


                                                        {{-- Brand --}}
                                                        <div class="form-group row">
                                                            <label class="mb-3 text-dark font-weight-medium"
                                                                for="validationServer01">
                                                                <i class="mdi mdi-account"></i> Brand : <strong
                                                                    class="text-danger"> * @error('brand_id')
                                                                        (
                                                                        {{ $message }} )
                                                                    @enderror
                                                                </strong>
                                                            </label>
                                                            <div class="input-group">

                                                                <select name="brand_id" id="brand_id"
                                                                    class="form-control selectpicker"
                                                                    data-live-search="true">
                                                                    <option value="">Select Brand....</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        @if (isset($public_color_values_proparty) && $public_color_values_proparty->count() > 0)
                                                            @foreach ($public_color_values_proparty as $key => $public_color)
                                                                @if ($public_color->values == 1)
                                                                    {{-- Colors --}}
                                                                    <div class="form-group row">
                                                                        <label class="mb-3 text-dark font-weight-medium"
                                                                            for="validationServer01">
                                                                            <i class="mdi mdi-account"></i> Color : <strong
                                                                                class="text-danger"> * @error('color_id')
                                                                                    ({{ $message }})
                                                                                @enderror
                                                                            </strong>
                                                                        </label>
                                                                        <div class="input-group">

                                                                            <select name="color_id" id="color_id"
                                                                                class="form-control">

                                                                                <option value="">Select Color....
                                                                                </option>
                                                                                @if (isset($colors) && $colors->count() > 0)
                                                                                    @foreach ($colors as $color)
                                                                                        <option
                                                                                            value="{{ $color->id }}"
                                                                                            @if (old('color_id') == $color->id) selected @endif>
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
                                                                    {{-- Size --}}
                                                                    <div class="form-group row">
                                                                        <label class="mb-3 text-dark font-weight-medium"
                                                                            for="validationServer01">
                                                                            <i class="mdi mdi-account"></i> size : <strong
                                                                                class="text-danger"> * @error('size_id')
                                                                                    ({{ $message }})
                                                                                @enderror
                                                                            </strong>
                                                                        </label>
                                                                        <div class="input-group">

                                                                            <select name="size_id" id="size_id"
                                                                                class="form-control">

                                                                                <option value="">Select Size....
                                                                                </option>
                                                                                @if (isset($sizes) && $sizes->count() > 0)
                                                                                    @foreach ($sizes as $size)
                                                                                        <option
                                                                                            value="{{ $size->id }}"
                                                                                            @if (old('size_id') == $size->id) selected @endif>
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


                                                        {{-- Gender --}}
                                                        <div class="form-group row">
                                                            <label class="mb-3 text-dark font-weight-medium"
                                                                for="validationServer01">
                                                                <i class="mdi mdi-account"></i> Gender: <strong
                                                                    class="text-danger"> * @error('gender')
                                                                        (
                                                                        {{ $message }} )
                                                                    @enderror
                                                                </strong>
                                                            </label>
                                                            <div class="input-group">

                                                                <select name="gender" id="gender"
                                                                    class="form-control selectpicker">
                                                                    <option value="">Select Gender....</option>
                                                                    <option value="1"
                                                                        @if (old('gender') == 1) selected @endif>
                                                                        Male</option>
                                                                    <option value="2"
                                                                        @if (old('gender') == 2) selected @endif>
                                                                        FeMale</option>
                                                                </select>
                                                            </div>
                                                        </div>



                                                    </div>
                                                    <div class="col-xl-6">
                                                        {{-- Sale Price --}}
                                                        <div class="form-group row">
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
                                                                    value="{{ old('sale_price') !== null ? old('sale_price') : 0 }}">
                                                            </div>
                                                        </div>

                                                        {{-- On Sale Price Status --}}
                                                        <div class="form-group row">
                                                            <label class="mb-3 text-dark font-weight-medium"
                                                                for="validationServer01">
                                                                <i class="mdi mdi-account-switch"></i> On Sale Price Status
                                                                : <strong class="text-danger"> *
                                                                    @error('on_sale_price_status')
                                                                        ( {{ $message }} )
                                                                    @enderror
                                                                </strong>
                                                            </label>
                                                            <div class="input-group">
                                                                {{-- <select name="main_category_id" class="form-control digits" --}}
                                                                <select name="on_sale_price_status"
                                                                    class="form-control digits @error('on_sale_price_status') is-invalid @enderror"
                                                                    id="inlineFormCustomSelectPref">
                                                                    <option value="">Select Status...</option>
                                                                    <option value="1"
                                                                        @if (old('on_sale_price_status') == '1') selected @endif>
                                                                        Active</option>
                                                                    <option value="2"
                                                                        @if (old('on_sale_price_status') == '2') selected @endif>
                                                                        Inactive</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        {{-- On Sale Price --}}
                                                        <div class="form-group row">
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
                                                                    value="{{ old('on_sale_price') !== null ? old('on_sale_price') : 0 }}">
                                                            </div>
                                                        </div>

                                                        {{-- Available Quantity --}}
                                                        <div class="form-group row">
                                                            <label class="mb-3 text-dark font-weight-medium"
                                                                for="validationServer01">
                                                                <i class="mdi mdi-account"></i> Available Quantity :
                                                                <strong class="text-danger"> * @error('quantity_available')
                                                                        ( {{ $message }} )
                                                                    @enderror
                                                                </strong>
                                                            </label>
                                                            <div class="input-group">

                                                                <input type="number" name="quantity_available"
                                                                    step="1"
                                                                    class="form-control @error('quantity_available') is-invalid @enderror"
                                                                    id="validationServer01"
                                                                    placeholder="Available Quantity"
                                                                    value="{{ old('quantity_available') !== null ? old('quantity_available') : 0 }}">
                                                            </div>
                                                        </div>

                                                        {{-- Limit Quantity --}}
                                                        {{-- <div class="form-group row">
                                                    <label class="mb-3 text-dark font-weight-medium"
                                                        for="validationServer01">
                                                        <i class="mdi mdi-account"></i> Limit Quantity : <strong class="text-danger"> * @error('quantity_limit') ( {{ $message }} ) @enderror</strong>
                                                    </label>
                                                    <div class="input-group">

                                                        <input type="number" name="quantity_limit" step="1" class="form-control @error('quantity_limit') is-invalid @enderror" id="validationServer01"
                                                        placeholder="Limit Quantity" value="{{ (old('quantity_limit') !== null) ? old('quantity_limit') : 0 }}">
                                                    </div>
                                                </div> --}}

                                                        {{-- featured flag --}}
                                                        <div class="form-group row">
                                                            <label class="mb-3 text-dark font-weight-medium"
                                                                for="validationServer01">
                                                                <i class="mdi mdi-account"></i> Featured Flag : <strong
                                                                    class="text-danger">
                                                                    @error('quantity_limit')
                                                                        ( {{ $message }} )
                                                                    @enderror
                                                                </strong>
                                                            </label>
                                                            <div class="input-group">

                                                                <input type="text" name="featured_flag" step="1"
                                                                    class="form-control @error('featured_flag') is-invalid @enderror"
                                                                    id="validationServer01" placeholder="Featured Flag"
                                                                    value="{{ old('featured_flag') !== null ? old('featured_flag') : null }}">
                                                            </div>
                                                        </div>


                                                        {{-- Image --}}
                                                        <div class="form-group row">
                                                            <label class="mb-3 text-dark font-weight-medium"
                                                                for="validationServer01">
                                                                <i class="mdi mdi-image"></i> Image : <strong
                                                                    class="text-danger"> @error('image')
                                                                        * ( {{ $message }} )
                                                                    @enderror
                                                                </strong>
                                                            </label>
                                                            <div class="input-group">

                                                                <input type="file" name="image" class="form-control"
                                                                    id="validationServer01" placeholder="Image">
                                                            </div>
                                                        </div>

                                                        {{-- Image URL --}}
                                                        <div class="form-group row">
                                                            <label class="mb-3 text-dark font-weight-medium"
                                                                for="validationServer01">
                                                                <i class="mdi mdi-image"></i> Image URL : <strong
                                                                    class="text-danger"> @error('image_url')
                                                                        ( {{ $message }} )
                                                                    @enderror
                                                                </strong>
                                                            </label>
                                                            <div class="input-group">

                                                                <input type="url" name="image_url"
                                                                    class="form-control" id="validationServer01"
                                                                    placeholder="Image URL">
                                                            </div>
                                                        </div>
                                                        {{-- weight --}}
                                                        <div class="form-group row">
                                                            <label class="mb-3 text-dark font-weight-medium"
                                                                for="validationServer01">
                                                                <i class="mdi mdi-account"></i> Weight : <strong
                                                                    class="text-danger"> @error('weight')
                                                                        ( {{ $message }} )
                                                                    @enderror
                                                                </strong>
                                                            </label>
                                                            <div class="input-group">

                                                                <input type="number" name="weight" step="0.001"
                                                                    class="form-control @error('weight') is-invalid @enderror"
                                                                    id="validationServer01" placeholder="Sale Price"
                                                                    value="{{ old('weight') !== null ? old('weight') : 0 }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- Status --}}
                                                    <div class="form-group row">
                                                        <div class="mb-3 col-md-6">
                                                            <label for="exampleFormControlSelect1"
                                                                class="mb-0 col-xl-12 col-sm-4">Status :</label>
                                                            <div class="col-xl-12 col-sm-7">
                                                                <select name="status" class="form-control digits"
                                                                    id="exampleFormControlSelect1">
                                                                    <option value="2" selected>Choose...</option>
                                                                    <option value="1"
                                                                        @if (old('status') == '1') selected @endif>
                                                                        Active</option>
                                                                    <option value="2"
                                                                        @if (old('status') == '2') selected @endif>
                                                                        Inactive</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    {{-- Main Description EN --}}
                                                    <div class="col-12">
                                                        <label class="mb-3 text-dark font-weight-medium"
                                                            for="validationServer01">
                                                            Main Description EN: <strong class="text-danger"> *
                                                                @error('main_description_en')
                                                                    - {{ $message }}
                                                                @enderror
                                                            </strong>
                                                        </label>
                                                        <div class="input-group">

                                                            <textarea style="width: 90% !important" name="main_description_en" class="form-control" rows="5">{{ old('main_description_en') }}</textarea>
                                                        </div>
                                                    </div>
                                                    {{-- Main Description AR --}}
                                                    <div class="col-12">
                                                        <label class="mb-3 text-dark font-weight-medium"
                                                            for="validationServer01">
                                                            Main Description AR: <strong class="text-danger"> *
                                                                @error('main_description_ar')
                                                                    - {{ $message }}
                                                                @enderror
                                                            </strong>
                                                        </label>
                                                        <div class="input-group">

                                                            <textarea style="width: 90% !important" name="main_description_ar" class="form-control" rows="5">{{ old('main_description_ar') }}</textarea>
                                                        </div>
                                                    </div>

                                                    {{-- Private Info EN --}}
                                                    <div class="col-12">
                                                        <label class="mb-3 text-dark font-weight-medium"
                                                            for="validationServer01">
                                                            Private Info : <strong class="text-danger"> *
                                                                @error('private_info')
                                                                    - {{ $message }}
                                                                @enderror
                                                            </strong>
                                                        </label>
                                                        <div class="input-group">

                                                            <textarea style="width: 90% !important" name="private_info" class="form-control" rows="5">{{ old('private_info') }}</textarea>
                                                        </div>
                                                    </div>

                                                    {{-- Sub Description EN --}}
                                                    <div class="col-12">
                                                        <label class="mb-3 text-dark font-weight-medium"
                                                            for="validationServer01">
                                                            Sub Description EN: <strong class="text-danger"> *
                                                                @error('sub_description_en')
                                                                    - {{ $message }}
                                                                @enderror
                                                            </strong>
                                                        </label>
                                                        <div class="input-group">

                                                            <textarea style="width: 90% !important" name="sub_description_en" class="form-control" rows="5">{{ old('sub_description_en') }}</textarea>
                                                        </div>
                                                    </div>
                                                    {{-- Sub Description AR --}}
                                                    <div class="col-12">
                                                        <label class="mb-3 text-dark font-weight-medium"
                                                            for="validationServer01">
                                                            Sub Description AR: <strong class="text-danger"> *
                                                                @error('sub_description_ar')
                                                                    - {{ $message }}
                                                                @enderror
                                                            </strong>
                                                        </label>
                                                        <div class="input-group">

                                                            <textarea style="width: 90% !important" name="sub_description_ar" class="form-control" rows="5">{{ old('sub_description_ar') }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="mt-5 col-12">
                                                        {{-- seo title AR --}}
                                                        <div class="mb-3 form-group row">
                                                            <label for="validationCustom01"
                                                                class="mb-0 col-xl-3 col-sm-4">SEO Title AR :</label>
                                                            <div class="col-xl-8 col-sm-7">
                                                                <input name="seo_title_ar"
                                                                    class="form-control @error('seo_title_ar') is-invalid @enderror"
                                                                    id="validationCustom01" type="text"
                                                                    value="{{ old('seo_title_ar') }}"
                                                                    placeholder="seo_title_ar">
                                                            </div>
                                                            <div class="valid-feedback">Looks good!</div>
                                                        </div>
                                                        {{-- seo title En --}}
                                                        <div class="mb-3 form-group row">
                                                            <label for="validationCustom01"
                                                                class="mb-0 col-xl-3 col-sm-4">SEO Title EN :</label>
                                                            <div class="col-xl-8 col-sm-7">
                                                                <input name="seo_title_en"
                                                                    class="form-control @error('seo_title_en') is-invalid @enderror"
                                                                    id="validationCustom01" type="text"
                                                                    value="{{ old('seo_title_en') }}"
                                                                    placeholder="seo_title_en">
                                                            </div>
                                                            <div class="valid-feedback">Looks good!</div>
                                                        </div>
                                                        {{-- Meta Desc AR --}}
                                                        <div class="mb-3 form-group row">
                                                            <label for="validationCustom01"
                                                                class="mb-0 col-xl-3 col-sm-4">Meta Desc AR:</label>
                                                            <div class="col-xl-8 col-sm-7">
                                                                <input name="meta_desc_ar"
                                                                    class="form-control @error('meta_desc_ar') is-invalid @enderror"
                                                                    id="validationCustom01" type="text"
                                                                    value="{{ old('meta_desc_ar') }}"
                                                                    placeholder="meta_desc_ar">
                                                            </div>
                                                            <div class="valid-feedback">Looks good!</div>
                                                        </div>
                                                        {{-- Meta Desc EN --}}
                                                        <div class="mb-3 form-group row">
                                                            <label for="validationCustom01"
                                                                class="mb-0 col-xl-3 col-sm-4">Meta Desc AR:</label>
                                                            <div class="col-xl-8 col-sm-7">
                                                                <input name="meta_desc_en"
                                                                    class="form-control @error('meta_desc_en') is-invalid @enderror"
                                                                    id="validationCustom01" type="text"
                                                                    value="{{ old('meta_desc_en') }}"
                                                                    placeholder="meta_desc_en">
                                                            </div>
                                                            <div class="valid-feedback">Looks good!</div>
                                                        </div>
                                                        {{-- SEO Meta data AR --}}
                                                        <div class="mb-3 form-group row">
                                                            <label for="validationCustom01"
                                                                class="mb-0 col-xl-3 col-sm-4">keywords AR:</label>
                                                            <div class="col-xl-8 col-sm-7">
                                                                <input name="keywords_ar"
                                                                    class="form-control @error('keywords_ar') is-invalid @enderror"
                                                                    id="validationCustom01" type="text"
                                                                    value="{{ old('keywords_ar') }}"
                                                                    placeholder="keywords_ar">
                                                            </div>
                                                            <div class="valid-feedback">Looks good!</div>
                                                        </div>
                                                        {{-- SEO Meta data EN --}}
                                                        <div class="mb-3 form-group row">
                                                            <label for="validationCustom01"
                                                                class="mb-0 col-xl-3 col-sm-4">keywords EN:</label>
                                                            <div class="col-xl-8 col-sm-7">
                                                                <input name="keywords_en"
                                                                    class="form-control @error('keywords_en') is-invalid @enderror"
                                                                    id="validationCustom01" type="text"
                                                                    value="{{ old('keywords_en') }}"
                                                                    placeholder="keywords_en">
                                                            </div>

                                                            <div class="valid-feedback">Looks good!</div>
                                                            <div class="mt-4 offset-xl-3 offset-sm-4">
                                                                <button type="submit"
                                                                    class="btn btn-primary">Add</button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                                {{-- Button --}}
                                                {{-- <button class="btn btn-primary" type="submit"><i class="mdi mdi-playlist-plus"></i> Add</button> --}}
                                        </form>
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
            $(document).ready(function() {

                setTimeout(() => {
                    main_id = $("#main_category_id").val();
                    if (main_id !== "") {
                        getSubCategories();
                        getBrand();
                    }

                }, 1000);
            });

            // $(document).on("change","#super_category_id",function(){

            //     getMainCategories();

            // });

            $(document).on("change", "#main_category_id", function() {

                getSubCategories();
                getBrand();

            });






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

                            old_brand = $("#old_brand").val();
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
                            $('.selectpicker').selectpicker('refresh');


                        }
                    },
                    error: function(data) {

                    }
                });
            }

            function getBrand() {

                main_category_id = $("#main_category_id").val();

                formData = new FormData();
                formData.append('main_category_id', main_category_id);

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    url: "{{ route('super_admin.getBrand') }}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function(data) {
                        if (data['status'] == true) {
                            // old_sub = $("#old_sub").val();

                            old_brand = $("#old_brand").val();
                            $("#brand_id").html('');
                            html = '<option value="">SelectBrand....</option>';
                            for (let key = 0; key < data.brands.length; key++) {
                                // console.log(data.mainCategories[key]['id']);
                                if (old_brand == data.brands[key]['id']) {
                                    html += '<option value="' + data.brands[key]['id'] + '" selected>' + data
                                        .brands[key]['name_en'] + '</option>';
                                } else {
                                    html += '<option value="' + data.brands[key]['id'] + '">' + data.brands[key][
                                        'name_en'
                                    ] + '</option>';
                                }
                            }
                            $("#brand_id").html(html);
                            $('.selectpicker').selectpicker('refresh');


                        }
                    },
                    error: function(data) {

                    }
                });
            }
        </script>
    @endsection
