<!DOCTYPE html>
<html class="no-js" lang="en">
@php
    $seo = App\Models\Seo::find(1);
@endphp

<head>
    <meta charset="utf-8" />
    <title>Nest-Mart&Grocery</title>
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="description" content="{{ $seo->meta_description }}" />
    <meta name="title" content="{{ $seo->meta_title }}" />
    <meta name="author" content="{{ $seo->meta_author }}" />
    <meta name="keyword" content="{{ $seo->meta_keyword }}" />

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:title" content="" />
    <meta property="og:type" content="" />
    <meta property="og:url" content="" />
    <meta property="og:image" content="" />
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('frontend/assets/imgs/theme/favicon.svg') }}" />
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins/animate.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/main.css?v=5.3') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/custom.css') }}" />
    <!-- toastr -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
</head>

<body>
    <!-- Modal -->

    <!-- Quick view -->
    @include('frontend.body.quick_view')
    <!-- Quick view end-->

    <!-- Header  -->
    @include('frontend.body.header')
    <!--End header-->

    <main class="main">
        @yield('master')


    </main>

    <!-- Footer  -->
    @include('frontend.body.footer')
    <!--End Footer-->

    <!-- Preloader Start -->
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="text-center">
                    <img src="{{ asset('frontend/assets/imgs/theme/loading.gif') }}" alt="" />
                </div>
            </div>
        </div>
    </div>
    <!-- Vendor JS-->
    <script src="{{ asset('frontend/assets/js/vendor/modernizr-3.6.0.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/vendor/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/vendor/jquery-migrate-3.3.0.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/vendor/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/slick.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/jquery.syotimer.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/waypoints.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/wow.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/magnific-popup.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/select2.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/counterup.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/images-loaded.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/isotope.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/scrollup.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/jquery.vticker-min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/jquery.theia.sticky.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/jquery.elevatezoom.js') }}"></script>
    <!-- Template  JS -->
    <script src="{{ asset('frontend/assets/js/main.js?v=5.3') }}"></script>
    <script src="{{ asset('frontend/assets/js/shop.js?v=5.3') }}"></script>
    <!-- toastr -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        @if (Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}"
            switch (type) {
                case 'info':
                    toastr.info(" {{ Session::get('message') }} ");
                    break;

                case 'success':
                    toastr.success(" {{ Session::get('message') }} ");
                    break;

                case 'warning':
                    toastr.warning(" {{ Session::get('message') }} ");
                    break;

                case 'error':
                    toastr.error(" {{ Session::get('message') }} ");
                    break;
            }
        @endif
    </script>
    <!-- sweet-alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })


        function modalClick(id) {
            $.ajax({
                url: '{{ route('modal.ajax') }}',
                type: 'GET',
                data: {
                    'id': id
                },
                success: function(data) {
                    console.log(data);
                    $('#product_id').val(data.products.id);
                    $('#p_name').html(data.products.product_name);
                    $('.current-price').html(`$${data.products.selling_price-data.products
                        .discount_price}`);
                    $('.old-price').html(`$${parseInt(data.products.selling_price) + parseInt(data.products
                        .discount_price)}`);
                    $('#vendor').html(data.products.vendor.name);
                    $('#vendor_id').val(data.products.vendor.id);
                    $('#product_code').html(data.products.product_code);
                    $('#category').html(data.products.category.category_name);
                    $('#brand').html(data.products.brand.brand_name);
                    $('#stock').html(`Items In Stock ${data.products.product_qty}`);
                    $('#discount').html(`${data.discount}% Off`);
                    $('#color').empty();
                    $('#size').empty();
                    $('#tag').empty();
                    $('#color').append(`<option disabled selected>Choose Size</option>`)
                    $('#size').append(`<option disabled selected>Choose Size</option>`)
                    data.colors.forEach(item => {
                        $('#color').append(`<option value="${item}">${item}</option>`)
                    });
                    data.sizes.forEach(item => {
                        $('#size').append(`<option value="${item}">${item}</option>`)
                    });
                    data.tags.forEach(item => {
                        $('#tag').append(
                            `<a href="#" class="badge me-1" style="background-color: #3BB77E" rel="tag">${ item }</a>`
                        );

                    })
                    $('#stock_status').empty();
                    if (data.products.product_qty > 0) {
                        $('#stock_status').append('<span class="stock-status in-stock"> Available</span>')

                    } else {
                        $('#stock_status').append('<span class="stock-status out-stock">Out of stock</span>')

                    }

                    if (data.products.product_size == '') {
                        $('#size_field').hide()
                    }
                    if (data.products.product_color == '') {
                        $('#color_field').hide()
                    }



                    $('#product-image-slider .slick-track').empty();

                    // const imageUrl = `{{ asset('uploads/backend/product/thumbnail/${data.image}') }}`;
                    // document.getElementById("image").src = imageUrl;
                    data.image.forEach(item => {
                        $('#product-image-slider .slick-track').append(`<figure class="border-radius-10 slick-slide slick-current slick-active" data-slick-index="0" aria-hidden="false" tabindex="0" style="width: 374px;">
                                    <img id="image" src="{{ asset('uploads/backend/product/${item.image}') }}" alt="product image">
                                </figure>`);
                    });
                    // data.image.forEach(item => {
                    //     $('.slick-cloned').append(
                    //         ` <div><img src="{{ asset('uploads/backend/product/${item.image}') }}"
                //                         alt="product image" /></div>`
                    //     );
                    // });


                },
            });
        }

        //Add to cart
        function addToCart() {
            var product_id = $('#product_id').val();
            var vendor_id = $('#vendor_id').val();
            var product_name = $('#p_name').text();
            var product_color = $('#color option:selected').val();
            var product_size = $('#size option:selected').val();
            var quantity = $('#qty').val();

            $.ajax({
                type: 'POST',
                dataType: 'json',
                data: {
                    name: product_name,
                    color: product_color,
                    size: product_size,
                    qty: quantity,
                    vendor_id: vendor_id
                },
                url: 'cart/data/store/' + product_id,
                success: function(data) {
                    console.log(data);
                    $('#btn-close').click();


                    if ($.isEmptyObject(data.error)) {
                        Swal.fire({
                            position: 'top-end',
                            toast: true,
                            icon: 'success',
                            title: 'Item Added To Cart',
                            showConfirmButton: false,
                            timer: 3000
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!',
                        })
                    }
                    miniCart();



                }
            })



        }
    </script>

    <script>
        function addToCart1(id) {
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: `{{ url('cart/data/save/${id}') }}`,
                success: function(data) {
                    console.log(data);
                    if ($.isEmptyObject(data.error)) {
                        Swal.fire({
                            position: 'top-end',
                            toast: true,
                            icon: 'success',
                            title: 'Item Added To Cart',
                            showConfirmButton: false,
                            timer: 3000
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!',
                        })
                    }
                    miniCart();


                }
            })



        }
    </script>
    <script>
        function miniCart() {
            $.ajax({
                type: 'GET',
                dataType: 'json',
                url: "{{ url('products/mini_cart/all') }}",
                success: function(data) {
                    console.log(data);
                    $('#mini_cart_total').text(`$${data.cart_total}`)
                    $('#mini_cart_count').text(data.cart_qty)
                    $('#mini_cart').empty();
                    $.each(data.cart, function(key, item) {
                        $('#mini_cart').append(`<li>
                                            <div class="shopping-cart-img">
                                                <a href="#"><img alt="Nest"
                                                    src="{{ asset('uploads/backend/product/thumbnail/${item.attributes.image}') }}" /></a>
                                            </div>
                                            <div class="shopping-cart-title">
                                                <h4><a href="shop-product-right.html">${item.name}</a></h4>
                                                <h4><span>${item.quantity} × </span>$${item.price}</h4>
                                            </div>
                                            <div class="shopping-cart-delete">
                                            <a type="submit" onclick="miniCartRemove(${item.id})"><i class="fi-rs-cross-small"></i></a>
                                      </div>
                            </li> `);
                    })

                }
            })
        }
        miniCart();
    </script>
    {{-- miniCart removal --}}
    <script>
        function miniCartRemove(id) {
            $.ajax({
                type: 'GET',
                url: `{{ url('mini_cart/remove/${id}') }}`,
                success: function(data) {
                    if ($.isEmptyObject(data.error)) {
                        Swal.fire({
                            position: 'top-end',
                            toast: true,
                            icon: 'success',
                            title: 'Item Removed Successfully',
                            showConfirmButton: false,
                            timer: 3000
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!',
                        })
                    }
                    miniCart();
                    cartPage();
                    couponCalculation();

                }
            })

        }
    </script>


    {{-- add to cart from product detail page --}}
    <script>
        function saveToCart() {
            var product_id = $('#pro_id').val();
            var vendor_id = $('#ven_id').val();
            var product_name = $('#pro_name').text();
            var product_color = $('#colors option:selected').val();
            var product_size = $('#sizes option:selected').val();
            var quantity = $('#quantity').val();

            $.ajax({
                type: 'POST',
                dataType: 'json',
                data: {
                    name: product_name,
                    color: product_color,
                    size: product_size,
                    qty: quantity,
                    vendor_id: vendor_id
                },
                url: `{{ url('cart/data/store/${product_id}') }}`,
                success: function(data) {
                    console.log(data);

                    if ($.isEmptyObject(data.error)) {
                        Swal.fire({
                            position: 'top-end',
                            toast: true,
                            icon: 'success',
                            title: 'Item Added To Cart',
                            showConfirmButton: false,
                            timer: 3000
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!',
                        })
                    }
                    miniCart();


                }
            })



        }
    </script>


    {{-- add to Wishlist --}}
    <script>
        function addToWishlist(product_id) {

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: `{{ url('add_to_wishlist/${product_id}') }}`,
                success: function(data) {
                    console.log(data);
                    if ($.isEmptyObject(data.error)) {
                        $('#wish_list_count').text(data.count);
                        $('#wish_button').html('<i class="fi-rs-heart text-danger"></i>')
                        Swal.fire({
                            position: 'top-end',
                            toast: true,
                            icon: 'success',
                            title: data.success,
                            showConfirmButton: false,
                            timer: 3000
                        })
                    } else {
                        Swal.fire({
                            position: 'top-end',
                            toast: true,
                            icon: 'error',
                            title: data.error,
                            showConfirmButton: false,
                            timer: 3000
                        })
                    }






                }
            })
        }
    </script>

    {{-- remove wishlist --}}
    <script>
        function removeWishlist(product_id) {
            $.ajax({
                type: 'GET',
                dataType: 'json',
                url: `{{ url('remove_wishlist/${product_id}') }}`,

                success: function(data) {

                    console.log(data);
                    wishlist();
                    Swal.fire({
                        position: 'top-end',
                        toast: true,
                        icon: 'success',
                        title: data.success,
                        showConfirmButton: false,
                        timer: 3000
                    })

                }
            })
        }
    </script>

    {{-- get wishlist data --}}
    <script>
        function wishlist() {
            $.ajax({
                type: 'GET',
                dataType: 'json',
                url: `{{ url('get_wishlist') }}`,
                success: function(data) {
                    console.log(data);
                    $('#tbody').empty()
                    if (data.product == '') {
                        $('#wishlist_products').html('<p>No Products</p>')
                    }
                    data.product.forEach(item => {
                        $('#wishlist_products').append(`<tr class="pt-30">
                                        <td class="custome-checkbox pl-30">
                                            <input class="form-check-input" type="checkbox" name="checkbox"
                                                id="exampleCheckbox1" value="" />
                                            <label class="form-check-label" for="exampleCheckbox1"></label>
                                        </td>
                                        <td class="image product-thumbnail pt-40"><img
                                                src="{{ asset('uploads/backend/product/thumbnail/${item.thumbnail_image}') }}" alt="#" /></td>
                                        <td class="product-des product-name">
                                            <h6><a class="product-name mb-10" href="{{ url('product/details/${item.id}/${item.product_slug}') }}">${item.product_name}</a></h6>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                        </td>
                                        <td class="price" data-title="Price">
                                            <h3 class="text-brand">$${item.selling_price - item.discount_price }</h3>
                                        </td>
                                        <td class="text-center detail-info" data-title="Stock">
                                            <span class="stock-status in-stock mb-0"> In Stock </span>
                                        </td>
                                        <td class="text-right" data-title="Cart">
                                            <button class="btn btn-sm" onclick="addToCart1(${item.id})">Add to cart</button>
                                        </td>
                                        <td class="action text-center" data-title="Remove">
                                            <a onclick="removeWishlist(${item.id})" class="text-body"><i class="fi-rs-trash"></i></a>
                                        </td>
                                    </tr>`)
                    });
                }
            })
        }
        wishlist()
    </script>


    {{-- add to compare --}}
    <script>
        function addToCompare(product_id) {

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: `{{ url('add_to_compare/${product_id}') }}`,
                success: function(data) {
                    console.log(data);
                    if ($.isEmptyObject(data.error)) {
                        Swal.fire({
                            position: 'top-end',
                            toast: true,
                            icon: 'success',
                            title: data.success,
                            showConfirmButton: false,
                            timer: 3000
                        })
                    } else {
                        Swal.fire({
                            position: 'top-end',
                            toast: true,
                            icon: 'error',
                            title: data.error,
                            showConfirmButton: false,
                            timer: 3000
                        })
                    }






                }
            })
        }
    </script>


    <script>
        function getCompare() {
            $.ajax({
                type: 'GET',
                dataType: 'json',
                url: `{{ url('get_compare') }}`,
                success: function(data) {
                    console.log(data);
                    // $('#compare_tbody').empty()
                    // if (data.product == '') {
                    //     $('#compare_table').html('<p>No Products</p>')
                    // }


                    // data.product.forEach(item => {
                    //     $('#compare_table').append(` <tr class="pr_image">
                //                     <td class="text-muted font-sm fw-600 font-heading mw-200">Preview</td>
                //                     <td class="row_img image product-thumbnail pt-40"><img src="{{ asset('uploads/backend/product/thumbnail/${item.thumbnail_image}') }}" alt="compare-img" />
                //                     </td>

                //                 </tr>
                //                 <tr class="pr_title">
                //                     <td class="text-muted font-sm fw-600 font-heading">Name</td>
                //                     <td class="product_name">
                //                         <h6><a href="shop-product-full.html" class="text-heading">${item.product_name}</a></h6>
                //                     </td>

                //                 </tr>
                //                 <tr class="pr_price">
                //                     <td class="text-muted font-sm fw-600 font-heading">Price</td>
                //                     <td class="product_price">
                //                         <h4 class="price text-brand">$${item.selling_price - item.discount_price }</h4>
                //                     </td>

                //                 </tr>
                //                 <tr class="pr_rating">
                //                     <td class="text-muted font-sm fw-600 font-heading">Rating</td>
                //                     <td>
                //                         <div class="rating_wrap">
                //                             <div class="product-rate d-inline-block">
                //                                 <div class="product-rating" style="width: 90%"></div>
                //                             </div>
                //                             <span class="rating_num">(121)</span>
                //                         </div>
                //                     </td>

                //                 </tr>
                //                 <tr class="description">
                //                     <td class="text-muted font-sm fw-600 font-heading">Description</td>
                //                     <td class="row_text font-xs">
                //                         <p class="font-sm text-muted">$${item.short_description}</p>
                //                     </td>
                //                 </tr>
                //                 <tr class="pr_stock">
                //                     <td class="text-muted font-sm fw-600 font-heading">Stock status</td>
                //                     <td class="row_stock"><span class="stock-status in-stock mb-0">In Stock</span></td>

                //                 </tr>
                //                 <tr class="pr_weight">
                //                     <td class="text-muted font-sm fw-600 font-heading">Weight</td>
                //                     <td class="row_weight">320 gram</td>

                //                 </tr>
                //                 <tr class="pr_dimensions">
                //                     <td class="text-muted font-sm fw-600 font-heading">Dimensions</td>
                //                     <td class="row_dimensions">N/A</td>
                //                 </tr>
                //                 <tr class="pr_add_to_cart">
                //                     <td class="text-muted font-sm fw-600 font-heading">Buy now</td>
                //                     <td class="row_btn">
                //                         <button class="btn btn-sm"><i class="fi-rs-shopping-bag mr-5"></i>Add to
                //                             cart</button>
                //                     </td>
                //                 </tr>
                //                 <tr class="pr_remove text-muted">
                //                     <td class="text-muted font-md fw-600"></td>
                //                     <td class="row_remove">
                //                         <a href="#" class="text-muted"><i
                //                                 class="fi-rs-trash mr-5"></i><span>Remove</span> </a>
                //                     </td>
                //                 </tr>`)
                    // });
                }
            })
        }
        getCompare()
    </script>

    <script>
        function cartPage() {
            $.ajax({
                type: 'GET',
                dataType: 'json',
                url: "{{ url('products/mini_cart/all') }}",
                success: function(data) {
                    console.log(data);
                    if (data.session == null) {
                        $('#cart_total').text(`$${data.cart_total}`)

                    }
                    $('#cart_subtotal').text(`$${data.cart_total}`)
                    $('#cart_count').text(data.cart_qty)
                    $('#cart_body').empty();
                    if ($.isEmptyObject(data.cart)) {
                        $('#cart_body').html('<h4 class="mt-2">No Products</h4>');

                    }
                    $.each(data.cart, function(key, item) {
                        $('#cart_table').append(`<tr class="pt-30">
                                <td class="custome-checkbox pl-30">
                                    <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox1" value="">
                                    <label class="form-check-label" for="exampleCheckbox1"></label>
                                </td>
                                <td class="image product-thumbnail pt-40"><img src="{{ asset('uploads/backend/product/thumbnail/${item.attributes.image}') }}" alt="#"></td>
                                <td class="product-des product-name">
                                    <h6 class="mb-5"><a class="product-name mb-10 text-heading" href="shop-product-right.html">${item.name}</a></h6>
                                    <div class="product-rate-cover">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width:90%">
                                            </div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> (4.0)</span>
                                    </div>
                                </td>
                                <td class="price" data-title="Price">
                                    <h4 class="text-body">$${item.price } </h4>
                                </td>
                                <td class="text-center detail-info" data-title="Stock">
                                    <div class="detail-extralink mr-15">
                                        <div class="detail-qty border radius">
                                            <a onclick="cartDecrement(${item.id })" class="qty-down"><i class="fi-rs-angle-small-down"></i></a>
                                            <input type="text" name="quantity" class="qty-val" value="${item.quantity }" min="1">
                                            <a type="submit" onclick="cartIncrement(${item.id })" class="qty-up"><i class="fi-rs-angle-small-up"></i></a>
                                        </div>
                                    </div>
                                </td>
                                <td class="price" data-title="Price">
                                    <h4 class="text-body">${item.attributes.color}</h4>
                                </td>
                                <td class="price" data-title="Price">
                                    <h4 class="text-body">${item.attributes.size}</h4>
                                </td>
                                <td class="price" data-title="Price">
                                    <h4 class="text-brand">$${item.price*item.quantity } </h4>
                                </td>
                                <td class="action text-center" data-title="Remove"><a onclick="miniCartRemove(${item.id})" class="text-body"><i class="fi-rs-trash"></i></a></td>
                            </tr>`);
                    })

                }
            })
        }
        cartPage();
    </script>

    {{-- cart increment --}}
    <script>
        function cartIncrement(cart_id) {

            $.ajax({
                type: 'GET',
                url: `{{ url('cart/cart_increment/${cart_id}') }}`,
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    Swal.fire({
                        position: 'top-end',
                        toast: true,
                        icon: 'success',
                        title: data.success,
                        showConfirmButton: false,
                        timer: 3000
                    })
                    cartPage();
                    miniCart();
                    couponCalculation();

                }

            })
        }
    </script>

    {{-- cart decrement --}}
    <script>
        function cartDecrement(cart_id) {

            $.ajax({
                type: 'GET',
                url: `{{ url('cart/cart_decrement/${cart_id}') }}`,
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    Swal.fire({
                        position: 'top-end',
                        toast: true,
                        icon: 'success',
                        title: data.success,
                        showConfirmButton: false,
                        timer: 3000
                    })
                    cartPage();
                    miniCart();
                    couponCalculation();

                }

            })
        }
    </script>


    {{-- apply coupon --}}
    <script>
        function applyCoupon() {
            var coupon_name = $('#coupon_name').val();
            $.ajax({
                type: 'POST',
                dataType: 'json',
                data: {
                    coupon_name: coupon_name
                },
                url: "{{ url('apply_coupon') }}",

                success: function(data) {
                    console.log(data);
                    if (data.validity == true) {
                        $('#coupon_field').hide();
                    }


                    if ($.isEmptyObject(data.error)) {
                        Swal.fire({
                            position: 'top-end',
                            toast: true,
                            icon: 'success',
                            title: data.success,
                            showConfirmButton: false,
                            timer: 3000
                        })
                    } else {
                        Swal.fire({
                            position: 'top-end',
                            toast: true,
                            icon: 'error',
                            title: data.error,
                            showConfirmButton: false,
                            timer: 3000
                        })
                    }

                }
            })
            couponCalculation()

        }

        // coupon calculaion

        function couponCalculation() {
            $.ajax({
                type: 'GET',
                dataType: 'json',
                url: "{{ url('coupon_calcultion') }}",
                success: function(data) {
                    console.log(data);

                    if (data.total || data.total == 0) {
                        $('#cart_amount_field').html(
                            ` <tr>
                                    <td class="cart_total_label">
                                        <h6 class="text-muted">Subtotal</h6>
                                    </td>
                                    <td class="cart_total_amount">
                                        <h4 class="text-brand text-end" id="cart_subtotal">$${data.total}</h4>
                                    </td>
                                </tr>
                                <tr>
                                    <td scope="col" colspan="2">
                                        <div class="divider-2 mt-10 mb-10"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="cart_total_label">
                                        <h6 class="text-muted">Shipping</h6>
                                    </td>
                                    <td class="cart_total_amount">
                                        <h5 class="text-heading text-end">Free</h4</td> </tr> <tr>
                                    <td class="cart_total_label">
                                        <h6 class="text-muted">Estimate for</h6>
                                    </td>
                                    <td class="cart_total_amount">
                                        <h5 class="text-heading text-end">United Kingdom</h4</td> </tr> <tr>
                                    <td scope="col" colspan="2">
                                        <div class="divider-2 mt-10 mb-10"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="cart_total_label">
                                        <h6 class="text-muted">Total</h6>
                                    </td>
                                    <td class="cart_total_amount">
                                        <h4 class="text-brand text-end" id="cart_total">$${data.total}</h4>
                                    </td>
                                </tr>`
                        )

                    } else {

                        $('#cart_amount_field').html(
                            `<tr>
                                    <td class="cart_total_label">
                                        <h6 class="text-muted">Subtotal</h6>
                                    </td>
                                    <td class="cart_total_amount">
                                        <h4 class="text-brand text-end" id="cart_subtotal">$${data.subtotal}</h4>
                                    </td>
                                </tr>
                                <tr>
                                    <td scope="col" colspan="2">
                                        <div class="divider-2 mt-10 mb-10"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="cart_total_label">
                                        <h6 class="text-muted">Shipping</h6>
                                    </td>
                                    <td class="cart_total_amount">
                                        <h5 class="text-heading text-end">Free</h4</td> </tr> <tr>
                                    <td class="cart_total_label">
                                        <h6 class="text-muted">Estimate for</h6>
                                    </td>
                                    <td class="cart_total_amount">
                                        <h5 class="text-heading text-end">United Kingdom</h4</td> </tr> <tr>
                                   
                                </tr>
                                <tr>
                                    <td class="cart_total_label">
                                        <h6 class="text-muted">Coupon</h6>
                                    </td>
                                    <td class="cart_total_amount">
                                        <h5 class="text-brand text-end">${data.coupon_name}<a type="submit" onclick="couponRemove()"><i title="remove coupon" class="fi-rs-trash text-muted"></i></a></h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="cart_total_label">
                                        <h6 class="text-muted">Coupon Discount</h6>
                                    </td>
                                    <td class="cart_total_amount">
                                        <h4 class="text-brand text-end">$${data.discount_amount}</h4>
                                    </td>
                                </tr>
                                <td scope="col" colspan="2">
                                        <div class="divider-2 mt-10 mb-10"></div>
                                    </td>
                                <tr>
                                    <td class="cart_total_label">
                                        <h6 class="text-muted">Total</h6>
                                    </td>
                                    <td class="cart_total_amount">
                                        <h4 class="text-brand text-end" id="cart_total">$${data.total_amount}</h4>
                                    </td>
                                </tr>`
                        )

                    }
                }
            })
        }
        couponCalculation()
    </script>

    {{-- coupon remove --}}
    <script>
        function couponRemove() {
            $.ajax({
                type: 'GET',
                dataType: 'json',
                url: "{{ url('remove_coupon') }}",
                success: function(data) {
                    $('#coupon_field').show();
                    console.log(data);
                    Swal.fire({
                        position: 'top-end',
                        toast: true,
                        icon: 'success',
                        title: data.success,
                        showConfirmButton: false,
                        timer: 3000
                    })
                    couponCalculation()

                }
            })

        }
    </script>
    <script>
        $(document).ready(function() {
            $("#search-input").on("input", function() {
                let keyword = $(this).val();
                if (keyword.length >= 3) { 
                    $.ajax({
                        url: `{{ url('home/product/search') }}`, 
                        method: "GET",
                        data: {
                            keyword: keyword
                        },
                        success: function(data) {
                            console.log(data);
                            // Update the dropdown card with search results
                            $('#dropdown-card').empty();
                           if(data.length>0){
                            data.forEach(item => {
                                $('#dropdown-card').append(
                                    `<div class="d-flex align-items-center">
                                                  <div class="recent-product-img">
                                                    <a href="{{url('product/details/${item.id}/${item.product_slug}')}}"> 
                                                        <img src="uploads/backend/product/thumbnail/${item.thumbnail_image}"
                                                         alt="" height="40px" width="40px"></a>
                                                      </div>
                                                      <div class="ms-2">
                                                        <h6 class="mb-1 font-14"><a href="{{url('product/details/${item.id}/${item.product_slug}')}}">${item.product_name }</a></h6>
                                                 </div>
                                            </div>`
                                );

                            });
                        
                           }else{
                            $('#dropdown-card').text('Item not found');
                           }


                            $("#dropdown-card").removeClass('d-none');
                        }
                    });
                } else {
                    // Hide the dropdown card if the input length is less than 3 characters
                    $("#dropdown-card").addClass('d-none');
                }
            });

            // Hide the dropdown card when clicking outside the search container
            
            // $(document).on("click", function(event) {
            //     if (!$(event.target).closest(".search-container").length) {
            //         $("#dropdown-card").addClass('d-none');
            //     }
            // });
        });
    </script>
</body>

</html>
