<script src="{{ asset('front_end_style/assets/js/jquery-1.12.3.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script>
<script src="{{ asset('front_end_style/assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('front_end_style/assets/js/jquery.downCount.js') }}"></script>
<script src="{{ asset('front_end_style/assets/js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('front_end_style/assets/js/simplebar.min.js') }}"></script>
<script src="{{ asset('front_end_style/assets/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('front_end_style/assets/js/custom.js') }}"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
    integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
    crossorigin="anonymous"></script>
{{--
<script>
    $(window).on('load', function() {
        setTimeout(function() {
            $('#exampleModal').modal('show');
        }, 2500);
    });




    $(document).ready(function() {

        $(document).on('click', '.quickview', function() {
            item_id = $(this).data("id");

            formData = new FormData();
            formData.append('item_id', item_id);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: "{{ route('getItemDetails') }}",
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success: function(data) {
                        if (data['status'] == true) {

                            $("#product_images_modal").html("");
                            $("#product_images_modal").html(data['output_images']);

                            $("#product_prices_modal").html("");
                            $("#product_prices_modal").html(data['output_prices']);

                            $("#product_colors_modal").html("");
                            $("#product_colors_modal").html(data['output_colors']);

                            $("#product_sizes_modal").html("");
                            $("#product_sizes_modal").html(data['output_sizes']);

                            $("#available_quant_modal").html("");
                            $("#available_quant_modal").html(data['output_quantity']);

                            $("#product_details_modal").html("");
                            $("#product_details_modal").html(data['output_details']);

                            $("#product_buttons_modal").html("");
                            $("#product_buttons_modal").html(data['output_buttons']);

                            $('.product-slick').slick({
                                slidesToShow: 1,
                                slidesToScroll: 1,
                                arrows: true,
                                fade: true,
                                asNavFor: '.slider-nav'
                            });

                            $('.slider-nav').slick({
                                vertical: false,
                                slidesToShow: 3,
                                slidesToScroll: 1,
                                asNavFor: '.product-slick',
                                arrows: false,
                                dots: false,
                                focusOnSelect: true
                            });


                            $('.color-variant li').on('click', function (e) {
                                $(".color-variant li").removeClass("active");
                                $(this).addClass("active");
                            });


                            $('.size-box ul li').on('click', function (e) {
                                $(".size-box ul li").removeClass("active");
                                $('#selectSize').removeClass('cartMove');
                                $(this).addClass("active");
                                $(this).parent().addClass('selected');
                            });


                        } else {
                        swal({
                            icon: 'error',
                            title: 'Ooops',
                            text: data.msg,
                            width: 400,
                        })
                    }
                },
                error: function(data) {
                    // console.log(message);
                    swal({
                        icon: 'error',
                        title: 'please correct The Following :',
                        text: message,
                        width: 400,
                    });
                }
            });


        });


        $(document).on('click', ".product_attribute_modal", function(e) {
            e.preventDefault();

            selected_size = -1;
            selected_color = -1;

            if($("#colors_modal").length){
                color_active = $("#colors_modal").find('.active');
                if(color_active.length && color_active.length > 0){
                    selected_color = color_active.attr('data-color_id_modal');
                }
            }

            if($("#sizes_modal").length){
                size_active = $("#sizes_modal").find('.active');
                if(size_active.length && size_active.length > 0){
                    selected_size = size_active.attr('data-size_id_modal');
                }
            }

            product_id = $("#product_id_modal").val();


            formData = new FormData();
            formData.append('selected_size', selected_size);
            formData.append('selected_color', selected_color);
            formData.append('product_id', product_id);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: "{{ route('getProductAttributeModal') }}",
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function() {
                    $('.ajax-loader').removeClass('hide');
                },
                success: function(data) {
                if (data['status'] == true) {

                    $("#product_images_modal").html("");
                            $("#product_images_modal").html(data['output_images']);

                            $("#product_prices_modal").html("");
                            $("#product_prices_modal").html(data['output_prices']);

                            $("#product_colors_modal").html("");
                            $("#product_colors_modal").html(data['output_colors']);

                            $("#product_sizes_modal").html("");
                            $("#product_sizes_modal").html(data['output_sizes']);

                            $("#available_quant_modal").html("");
                            $("#available_quant_modal").html(data['output_quantity']);

                            $("#product_details_modal").html("");
                            $("#product_details_modal").html(data['output_details']);

                            $("#product_buttons_modal").html("");
                            $("#product_buttons_modal").html(data['output_buttons']);

                            $('.product-slick').slick({
                                slidesToShow: 1,
                                slidesToScroll: 1,
                                arrows: true,
                                fade: true,
                                asNavFor: '.slider-nav'
                            });

                            $('.slider-nav').slick({
                                vertical: false,
                                slidesToShow: 3,
                                slidesToScroll: 1,
                                asNavFor: '.product-slick',
                                arrows: false,
                                dots: false,
                                focusOnSelect: true
                            });


                            $('.color-variant li').on('click', function (e) {
                                $(".color-variant li").removeClass("active");
                                $(this).addClass("active");
                            });


                            $('.size-box ul li').on('click', function (e) {
                                $(".size-box ul li").removeClass("active");
                                $('#selectSize').removeClass('cartMove');
                                $(this).addClass("active");
                                $(this).parent().addClass('selected');
                            });

                } else {


                    htm = '<h4 class="py-3 text-danger">Not Available</h4>';
                    $("#available_quant_modal").html("");
                    $("#available_quant_modal").html(htm);

                    $('.color-variant li').on('click', function (e) {
                        $(".color-variant li").removeClass("active");
                        $(this).addClass("active");
                    });


                    $('.size-box ul li').on('click', function (e) {
                        $(".size-box ul li").removeClass("active");
                        $('#selectSize').removeClass('cartMove');
                        $(this).addClass("active");
                        $(this).parent().addClass('selected');
                    });
                    // swal({
                    //     icon: 'error',
                    //     title: 'Ooops',
                    //     text: data.msg,
                    //     width: 400,
                    // })
                }
                // $('.ajax-loader').addClass('hide');
            },
                error: function(data) {
                    $('.ajax-loader').addClass('hide');
                    swal({
                        icon: 'error',
                        title: 'please correct The Following :',
                        text: message,
                        width: 400,
                    });
                },complete: function() {
                    $('.ajax-loader').addClass('hide');
                }
            });

        });


        $(document).on('click', ".add_to_cartbtn", function(e) {
            e.preventDefault();

            loggedIn = "{{{ Auth::guard('customer')->check() ? 'true' : 'false' }}}";
            // console.log(loggedIn);
            if(loggedIn == 'true'){
                quantity = 0;

                prop_type = $(this).attr('data-prop_type');
                product_id = $(this).attr('data-product_id');
                property_id = $(this).attr('data-property_id');


                if(prop_type == 1){
                    quantity = $('.prod_quant_prop_'+property_id).val();
                }else if(prop_type == -1){
                    quantity = $('.prod_quant_2').val();
                }

                addToCart(prop_type,product_id,property_id,quantity);


            }else{
                window.location.href = "{{ route('customer.loginRegister')}}";
            }
        });





        $(document).on('click', ".add_on_cartbtn", function(e) {
            e.preventDefault();

            loggedIn = "{{{ Auth::guard('customer')->check() ? 'true' : 'false' }}}";
            // console.log(loggedIn);
            if(loggedIn == 'true'){

                quantity = 1;

                prop_type = $(this).attr('data-prop_type');
                product_id = $(this).attr('data-product_id');
                property_id = $(this).attr('data-property_id');


                addToCart(prop_type,product_id,property_id,quantity);


            }else{
                window.location.href = "{{ route('customer.loginRegister')}}";
            }
        });


        $(document).on('click', ".quantity_cart", function(e) {
            e.preventDefault();

            loggedIn = "{{{ Auth::guard('customer')->check() ? 'true' : 'false' }}}";
            console.log(loggedIn);
            if(loggedIn == 'true'){



                product_id = $(this).attr('data-product_id');

                quantityInput = $(this).parent().parent().find("input[name='quantity']");

                quantity = quantityInput.val();

                prop_type = $(this).attr('data-prop_type');
                property_id = $(this).attr('data-property_id');

                addToCart(prop_type,product_id,property_id,quantity);


            }else{
                window.location.href = "{{ route('customer.loginRegister')}}";
            }
        });
        $(document).on('click', ".deleteCartItem", function(e) {
            e.preventDefault();

            var cart_id=$(this).data('cart-id');
            cart_id = $(this).attr('data-cart-id');
            // alert(cart_id);
                 formData = new FormData();
                formData.append('cart_id', cart_id);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: "{{ route('customer.deleteItemToCart') }}",
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success: function(data) {
                    if (data['status'] == true) {
                        Swal.fire({
                            icon: 'success',
                            title: @json( __('api.message_please_Following')),
                            text: @json( __('front_end.message_Item_successfully_deleted_from_cart')),
                            width: 400,
                            showClass: {
                                popup: 'animate__animated animate__fadeInDown'
                            },
                            hideClass: {
                                popup: 'animate__animated animate__fadeOutUp'
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'please correct The Following :',
                            text: 'Item Is Not Deleted Now !!!',
                            width: 400,
                            showClass: {
                                popup: 'animate__animated animate__fadeInDown'
                            },
                            hideClass: {
                                popup: 'animate__animated animate__fadeOutUp'
                            }
                        });
                    }

                    getCart();
                    if($('#current_page').length){
                        getCartPage();
                    }
                },
                error: function(data) {
                    // console.log(message);
                    swal({
                        icon: 'error',
                        title: 'please correct The Following :',
                        text: message,
                        width: 400,
                    });
                }
            });
        });

        $(document).on('click', '.wishlistV2', function() {
            item_id = $(this).attr("wishlist_id");


            formData = new FormData();
            formData.append('wishlist_id', item_id);


            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: "{{ route('customer.wishlist') }}",
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success: function(data) {
                    Swal.fire({
                                icon: 'success',
                                title: @json( __('front_end.message_please_Following')),
                                text: @json( __('front_end.message_Item_successfully_added_to_wishlist')),
                                width: 400,
                                showClass: {
                                    popup: 'animate__animated animate__fadeInDown'
                                },
                                hideClass: {
                                    popup: 'animate__animated animate__fadeOutUp'
                                }
                            });


                },
                error: function(data) {
                    // console.log(message);
                    swal({
                        icon: 'error',
                        title: 'please correct The Following :',
                        text: data.message,
                        width: 400,
                    });
                }
            });


        });

        function addToCart(prop_type,product_id,property_id,quantity){


            formData = new FormData();
            formData.append('prop_type', prop_type);
            formData.append('product_id', product_id);
            formData.append('property_id', property_id);
            formData.append('quantity', quantity);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: "{{ route('customer.addToCartAjax') }}",
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function() {
                    $('.ajax-loader').removeClass('hide');
                },
                success: function(data) {
                if (data['status'] == true) {
                    Swal.fire({
                        icon: 'success',
                        title: 'please correct The Following :',
                        text: 'Item successfully added to cart',
                        width: 400,
                        showClass: {
                            popup: 'animate__animated animate__fadeInDown'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutUp'
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'please correct The Following :',
                        text: 'Item Not Available Now !!!',
                        width: 400,
                        showClass: {
                            popup: 'animate__animated animate__fadeInDown'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutUp'
                        }
                    });
                }

                getCart();
                if($('#current_page').length){
                        getCartPage();
                    }

            },
                error: function(data) {

                    Swal.fire({
                        icon: 'error',
                        title: 'please correct The Following :',
                        text: 'Item Not Available Now !!!',
                        width: 400,
                        showClass: {
                            popup: 'animate__animated animate__fadeInDown'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutUp'
                        }
                    });
                },complete: function() {
                    $('.ajax-loader').addClass('hide');
                }
            });
        }


        function getCart(){
            $.get("{{route('customer.getCartAjax')}}", function(data){
                if(data['status'] == true){

                    $("#cart_header").html("");
                    $("#cart_header").html(data['output']);

                }
            });
        };
        function getCartPage(){
            $.get("{{route('customer.getCartPageAjax')}}", function(data){
                if(data['status'] == true){

                    $("#cart_table").html("");
                    $("#cart_table").html(data['output']);
                    $("#cart_end_total").html("");
                    $("#cart_end_total").html(data['end_total']);

                }
            });
        };

    });


    function openSearch() {
        document.getElementById("search-overlay").style.display = "block";
    }

    function closeSearch() {
        document.getElementById("search-overlay").style.display = "none";
    }
</script> --}}