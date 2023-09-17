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
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="page-header-left">
                                    <h3> <span class="text-primary">Add New Property to</span>  {{ $product->name_en }}
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
                                    <li class="breadcrumb-item">Digital</li>
                                    <li class="breadcrumb-item active"> Add New Property</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- ============================================== --}}
                {{-- ==================== Body ==================== --}}
                {{-- ============================================== --}}
                <div class="content-wrapper">
                    <div class="content">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card card-default">

                                    <div class="card-body">
                                        <form action="{{ route('super_admin.properties-store',$product->id) }}" method="POST" enctype="multipart/form-data" id="createForm">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{$product->id}}">
                                            <div class="row product-adding">

                                            <div class="col-xl-6">

                                                @if (isset($public_color_values_proparty) && $public_color_values_proparty->count() > 0)
                                                @foreach ($public_color_values_proparty as $key => $public_color)
                                                    @if($public_color->values==1)
                                                          {{-- Promo Code --}}
                                                        <div class="form-group row">
                                                            <label class="text-dark font-weight-medium mb-3"
                                                            for="validationServer01">
                                                            <i class="mdi mdi-account"></i> Color : <strong
                                                                class="text-danger"> *
                                                                @error('main_color_id') (
                                                                {{ $message }} ) @enderror</strong>
                                                            </label>
                                                            <div class="input-group">
                                                                <select name="main_color_id" class="form-control digits"
                                                                id="exampleFormControlSelect1">
                                                                    <option value="">Select</option>
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

                                                    @if($public_size->values==1)
                                                            {{-- Promo Value --}}
                                                        <div class="form-group row">
                                                            <label class="text-dark font-weight-medium mb-3"
                                                            for="validationServer01">
                                                            <i class="mdi mdi-account"></i> Size : <strong
                                                                class="text-danger"> *
                                                                @error('main_size_id') (
                                                                {{ $message }} ) @enderror</strong>
                                                            </label>
                                                            <div class="input-group">
                                                                <select name="main_size_id" class="form-control digits"
                                                                id="exampleFormControlSelect1">
                                                                <option value="">Select</option>
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

                                                   {{-- On Sale Price --}}
                                                <div class="form-group row">
                                                    <label class="text-dark font-weight-medium mb-3"
                                                        for="validationServer01">
                                                        <i class="mdi mdi-account"></i> On Sale Price : <strong
                                                            class="text-danger"> * @error('on_sale_price') (
                                                            {{ $message }} ) @enderror</strong>
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
                                                    <label class="text-dark font-weight-medium mb-3"
                                                        for="validationServer01">
                                                        <i class="mdi mdi-account"></i> Available Quantity : <strong
                                                            class="text-danger"> * @error('quantity_available') (
                                                            {{ $message }} ) @enderror
                                                             @error('product_quantity_min') (
                                                            {{ $message }} ) @enderror</strong>
                                                    </label>
                                                    <div class="input-group">
                                                        <input type="number" name="quantity_available" step="1"
                                                            class="form-control @error('quantity_available') is-invalid @enderror"
                                                            id="validationServer01" placeholder="Available Quantity"
                                                            value="{{ old('quantity_available') !== null ? old('quantity_available') : 0 }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                {{-- Expiration Date --}}
                                                <div class="form-group row">
                                                    <label class="text-dark font-weight-medium mb-3"
                                                    for="validationServer01">
                                                    <i class="mdi mdi-account"></i> Sale Price : <strong
                                                        class="text-danger"> * @error('sale_price') (
                                                        {{ $message }} ) @enderror</strong>
                                                </label>
                                                <div class="input-group">
                                                    <input type="number" name="sale_price" step="0.001"
                                                        class="form-control @error('sale_price') is-invalid @enderror"
                                                        id="validationServer01" placeholder="Sale Price"
                                                        value="{{ old('sale_price') !== null ? old('sale_price') : 0 }}">
                                                </div>
                                                </div>

                                                {{-- Status --}}
                                                <div class="form-group row">
                                                    <label class="text-dark font-weight-medium mb-3"
                                                    for="validationServer01">
                                                    <i class="mdi mdi-account-switch"></i> On Sale Price Status :
                                                    <strong class="text-danger"> * @error('on_sale_price_status') (
                                                        {{ $message }} ) @enderror</strong>
                                                </label>
                                                <div class="input-group">
                                                    <select name="on_sale_price_status" class="form-control digits"
                                                    id="exampleFormControlSelect1">
                                                        <option value="">Select Status...</option>
                                                        <option value="1" @if (old('on_sale_price_status') == '1') selected @endif>Active</option>
                                                        <option value="2" @if (old('on_sale_price_status') == '2') selected @endif>Inactive</option>
                                                    </select>
                                                </div>

                                            </div>




                                                {{-- Status --}}
                                                <div class="form-group row">
                                                    <label class="text-dark font-weight-medium mb-3"
                                                        for="validationServer01">
                                                        <i class="mdi mdi-account-switch"></i> Status : <strong
                                                            class="text-danger"> * @error('status') (
                                                            {{ $message }} ) @enderror</strong>
                                                    </label>
                                                    <div class="input-group">

                                                        <select name="status" class="form-control digits"
                                                        id="exampleFormControlSelect1">
                                                            <option value="">Select Status...</option>
                                                            <option value="1" @if (old('status') == '1') selected @endif>Active</option>
                                                            <option value="2" @if (old('status') == '2') selected @endif>Inactive</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                {{-- Image --}}
                                                <div class="form-group row">
                                                    <label class="text-dark font-weight-medium mb-3"
                                                        for="validationServer01">
                                                        <i class="mdi mdi-image"></i> Image : <strong
                                                            class="text-danger"> @error('image')* ( {{ $message }}
                                                            ) @enderror</strong>
                                                    </label>
                                                    <div class="input-group">
                                                        <input type="file" name="image" class="form-control"
                                                            id="validationServer01" placeholder="Image">
                                                    </div>
                                                </div>

                                                {{-- Image URL --}}
                                                <div class="form-group row">
                                                    <label class="text-dark font-weight-medium mb-3"
                                                        for="validationServer01">
                                                        <i class="mdi mdi-image"></i> Image URL : <strong
                                                            class="text-danger"> @error('image_url')* ( {{ $message }}
                                                            ) @enderror</strong>
                                                    </label>
                                                    <div class="input-group">
                                                        <input type="url" name="image_url" class="form-control"
                                                            id="validationServer01" placeholder="Image URL">
                                                    </div>
                                                </div>

                                            </div>
                                            </div>

                                            {{-- Button --}}
                                            <button class="btn btn-primary" type="submit"><i class="mdi mdi-playlist-plus"></i> Add</button>
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

    @section('admin_javascript')

    @endsection
