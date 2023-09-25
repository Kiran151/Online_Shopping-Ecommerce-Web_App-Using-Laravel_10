@extends('frontend.master')
@section('master')
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="index.html" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                    <span></span> Checkout
                </div>
            </div>
        </div>
        <div class="container mb-80 mt-50">
            <div class="row">
                <div class="col-lg-8 mb-40">
                    <h3 class="heading-2 mb-10">Checkout</h3>
                    <div class="d-flex justify-content-between">
                        <h6 class="text-body">There are <span class="text-brand" id="cart_count">{{ $cart_qty }}</span>
                            products in your cart</h6>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-7">

                    <div class="row">
                        <h4 class="mb-30">Billing Details</h4>
                        <form method="post" action="{{ route('checkout.save') }}">
                            @csrf
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <input type="text" required="" name="name" value="{{ Auth::user()->name }}"
                                        placeholder="User Name *">
                                </div>
                                <div class="form-group col-lg-6">
                                    <input type="email" required="" name="email" value="{{ Auth::user()->email }}"
                                        placeholder="Email *">
                                </div>
                            </div>



                            <div class="row shipping_calculator">
                                <div class="form-group col-lg-6">
                                    <div class="custom_select">
                                        <select id="divisions" name="division" class="form-control select-active"
                                            required="">
                                            <option value="">Select division</option>
                                            @foreach ($divisions as $item)
                                                <option value="{{ $item->id }}">{{ $item->division_name }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-lg-6">
                                    <input required="" type="text" name="phone" value="{{ Auth::user()->phone }}"
                                        placeholder="Phone*">
                                </div>
                            </div>

                            <div class="row shipping_calculator">
                                <div class="form-group col-lg-6">
                                    <div class="custom_select">
                                        <select name="district" id="districts" class="form-control select-active"
                                            required="">
                                            <option value="">Select district</option>


                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-lg-6">
                                    <input required="" type="text" name="post_code" placeholder="Post Code *">
                                </div>
                            </div>


                            <div class="row shipping_calculator">
                                <div class="form-group col-lg-6">
                                    <div class="custom_select">
                                        <select name="state" id="state" class="form-control select-active"
                                            required="">
                                            <option value="">Select state</option>


                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-lg-6">
                                    <input required="" type="text" name="address" value="{{ Auth::user()->address }}"
                                        placeholder="Address *" required="">
                                </div>
                            </div>





                            <div class="form-group mb-30">
                                <textarea rows="5" name="notes" placeholder="Additional information"></textarea>
                            </div>



                    </div>
                </div>


                <div class="col-lg-5">
                    <div class="border p-40 cart-totals ml-30 mb-50">
                        <div class="d-flex align-items-end justify-content-between mb-30">
                            <h4>Your Order</h4>
                            <h6 class="text-muted">Subtotal</h6>
                        </div>
                        <div class="divider-2 mb-30"></div>
                        <div class="table-responsive order_table checkout">
                            <table class="table no-border">
                                <tbody>
                                    @foreach ($carts as $item)
                                        <tr>
                                            <td class="image product-thumbnail"><img
                                                    src="{{ asset('uploads/backend/product/thumbnail/' . $item->attributes->image) }}"
                                                    alt="#"></td>
                                            <td>
                                                <h6 class="w-160 mb-5"><a href="shop-product-full.html"
                                                        class="text-heading">{{ $item->name }}</a></h6></span>
                                                <div class="product-rate-cover">

                                                    <strong>Color : {{ $item->attributes->color }}</strong><br>
                                                    <strong>Size : {{ $item->attributes->size }}</strong>

                                                </div>
                                            </td>
                                            <td>
                                                <h6 class="text-muted pl-20 pr-20">x {{ $item->quantity }}</h6>
                                            </td>
                                            <td>
                                                <h4 class="text-brand">${{ $item->price }}</h4>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>


                            <table class="table no-border">
                                <tbody>
                                    <tr>
                                        <td class="cart_total_label">
                                            <h6 class="text-muted">Subtotal</h6>
                                        </td>
                                        <td class="cart_total_amount">
                                            <h4 class="text-brand text-end">${{ $cart_total }}</h4>
                                        </td>
                                    </tr>

                                    @if (Session::has('coupon'))
                                        <tr>
                                            <td class="cart_total_label">
                                                <h6 class="text-muted">Coupon Name</h6>
                                            </td>
                                            <td class="cart_total_amount">
                                                <h6 class="text-brand text-end">
                                                    {{ Session::get('coupon')['coupon_name'] }}
                                                </h6>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="cart_total_label">
                                                <h6 class="text-muted">Coupon Discount</h6>
                                            </td>
                                            <td class="cart_total_amount">
                                                <h4 class="text-brand text-end">
                                                    ${{ Session::get('coupon')['discount_amount'] }}</h4>
                                            </td>
                                        </tr>
                                    @endif

                                    <tr>
                                        <td class="cart_total_label">
                                            <h6 class="text-muted">Grand Total</h6>
                                        </td>
                                        <td class="cart_total_amount">
                                            <h4 class="text-brand text-end">
                                                ${{ Session::get('coupon') ? Session::get('coupon')['total_amount'] : $cart_total }}
                                            </h4>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>



                        </div>
                    </div>
                    <div class="payment ml-30">
                        <h4 class="mb-30">Payment</h4>
                        <div class="payment_option">
                            <div class="custome-radio">
                                <input class="form-check-input" required="" type="radio" name="payment_option"
                                    id="exampleRadios3" value="stripe" checked="">
                                <label class="form-check-label" for="exampleRadios3" data-bs-toggle="collapse"
                                    data-target="#bankTranfer" aria-controls="bankTranfer">Credit/Debit Card</label>
                            </div>
                            <div class="custome-radio">
                                <input class="form-check-input" value="cash" required="" type="radio"
                                    name="payment_option" id="exampleRadios4" checked="">
                                <label class="form-check-label" for="exampleRadios4" data-bs-toggle="collapse"
                                    data-target="#checkPayment" aria-controls="checkPayment">Cash on delivery</label>
                            </div>
                            {{-- <div class="custome-radio">
                                <input class="form-check-input" value="card" required="" type="radio"
                                    name="payment_option" id="exampleRadios5" checked="">
                                <label class="form-check-label" for="exampleRadios5" data-bs-toggle="collapse"
                                    data-target="#paypal" aria-controls="paypal">Online Getway</label>
                            </div> --}}
                            <div class="custome-radio">
                                <input class="form-check-input" value="phonepe" required="" type="radio"
                                    name="payment_option" id="exampleRadios5" checked="">
                                <label class="form-check-label" for="exampleRadios5" data-bs-toggle="collapse"
                                    data-target="#paypal" aria-controls="paypal">PhonePe</label>
                            </div>
                        </div>
                        <div class="payment-logo d-flex">
                            <img class="mr-15" src="{{ asset('frontend/assets/imgs/theme/icons/PhonePe.svg') }}"
                            alt="">
                            <img class="mr-15" src="{{ asset('frontend/assets/imgs/theme/icons/payment-paypal.svg') }}"
                                alt="">
                            <img class="mr-15" src="{{ asset('frontend/assets/imgs/theme/icons/payment-visa.svg') }}"
                                alt="">
                            <img class="mr-15" src="{{ asset('frontend/assets/imgs/theme/icons/payment-master.svg') }}"
                                alt="">
                            <img src="{{ asset('frontend/assets/imgs/theme/icons/payment-zapper.svg') }}" alt="">
                        </div>
                        <button type="submit" class="btn btn-fill-out btn-block mt-30">Place an Order<i
                                class="fi-rs-sign-out ml-15"></i></button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#divisions').change(function() {
                division_id = $('#divisions').val();
                $.ajax({
                    'type': 'GET',
                    'url': '{{ route('getDistrictAjax') }}',
                    'data': {
                        'division_id': division_id
                    },
                    success: function(data) {
                        $('#state option:not(:first)').remove();
                        $('#districts option:not(:first)').remove();

                        $.each(data, function(key, item) {
                            $('#districts').append(
                                `<option value="${item.id}">${item.district_name}</option>`
                            )
                        });
                    }
                })
            })
        })

        //state
        $(document).ready(function() {
            $('#districts').change(function() {
                console.log('distttt');
                district_id = $('#districts').val();
                $.ajax({
                    'type': 'GET',
                    'url': '{{ route('getStateAjax') }}',
                    'data': {
                        'district_id': district_id
                    },
                    success: function(data) {
                        $('#state option:not(:first)').remove();
                        $.each(data, function(key, item) {
                            $('#state').append(
                                `<option value="${item.id}">${item.state_name}</option>`
                            )
                        });
                    }
                })
            })
        })
    </script>
@endsection
