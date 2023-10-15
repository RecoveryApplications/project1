<script src="{{ asset('front_end_style/assets/js/jquery-1.12.3.min.js') }}"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script> --}}
<script src="{{ asset('front_end_style/assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('front_end_style/assets/js/jquery.downCount.js') }}"></script>
<script src="{{ asset('front_end_style/assets/js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('front_end_style/assets/js/simplebar.min.js') }}"></script>
<script src="{{ asset('front_end_style/assets/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('front_end_style/assets/js/alertify.min.js') }}"></script>
<script src="{{ asset('front_end_style/assets/js/custom.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
    integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
    crossorigin="anonymous"></script>


<script>
    alertify.set('notifier', 'position', 'top-right');
    @if (Session::has('success'))
        alertify.notify("{{ Session::get('success') }}", 'success', 3);
    @endif

    @if (Session::has('danger'))
        alertify.notify("{{ Session::get('danger') }}", 'error', 3);
    @endif
    @if (Session::has('error'))
        alertify.notify("{{ Session::get('error') }}", 'error', 3);
    @endif
    // check for is there validation errors
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            alertify.notify("{{ $error }}", 'error', 4);
        @endforeach
    @endif
</script>
