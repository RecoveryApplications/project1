{{-- ====================================================================== --}}
{{-- ========================= Start Top Section ========================== --}}
{{-- ====================================================================== --}}
@include('admin.layouts.top')

    {{-- ====================================================================== --}}
    {{-- ============================= Start Header =========================== --}}
    {{-- ====================================================================== --}}
    @include('admin.layouts.header')
    {{-- ====================================================================== --}}
    {{-- ============================= End Header ============================= --}}
    {{-- ====================================================================== --}}
{{-- ====================================================================== --}}
{{-- ========================== Start Main Menu =========================== --}}
{{-- ====================================================================== --}}
@include('admin.layouts.menu')
{{-- ====================================================================== --}}
{{-- ============================ End Main Menu =========================== --}}
{{-- ====================================================================== --}}

{{-- <div class="page-wrapper"> --}}


    <div class="page-body">
    <div class="container-fluid">
        <div class="row">

            {{-- ====================================================================== --}}
            {{-- ============================= Start Content ========================== --}}
            {{-- ====================================================================== --}}
            @yield('content')
            {{-- ====================================================================== --}}
            {{-- ============================= End Content ============================ --}}
            {{-- ====================================================================== --}}
        {{-- </div> --}}



    {{-- ====================================================================== --}}
    {{-- ============================= Start Footer =========================== --}}
    {{-- ====================================================================== --}}
    @include('admin.layouts.footer')
    {{-- ====================================================================== --}}
    {{-- ============================= End Footer ============================= --}}
    {{-- ====================================================================== --}}
{{-- </div> --}}

{{-- ====================================================================== --}}
{{-- ======================= Start Bottom Section ========================= --}}
{{-- ====================================================================== --}}
@include('admin.layouts.bottom')
