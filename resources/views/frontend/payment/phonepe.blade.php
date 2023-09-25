@extends('frontend.master')
@section('master')
    
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="index.html" rel="nofollow"><i class="fi-rs-home mr-5"></i>Checkout</a>
                    <span></span> Paypal Payment
                </div>
            </div>
        </div>
        <div class="container mb-80 mt-50">
            <div class="row">
                <div class="col-lg-8 mb-40">
                    <h3 class="heading-2 mb-10">Checkout</h3>
                    <div class="d-flex justify-content-between">
                        <h6 class="text-body">There are products in your cart</h6>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="border p-40 cart-totals ml-30 mb-50">
                        <div class="d-flex align-items-end justify-content-between mb-30">
                            <h4>Your Order</h4>
                        </div>
                        <div class="divider-2 mb-30"></div>
                        <div class="table-responsive order_table checkout">





                            <table class="table no-border">
                                <tbody>
                                    @if (Session::has('coupon'))
                                        <tr>
                                            <td class="cart_total_label">
                                                <h6 class="text-muted">Subtotal</h6>
                                            </td>
                                            <td class="cart_total_amount">
                                                <h4 class="text-brand text-end">${{ $cart_total }}</h4>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="cart_total_label">
                                                <h6 class="text-muted">Coupon Name</h6>
                                            </td>
                                            <td class="cart_total_amount">
                                                <h6 class="text-brand text-end">{{ Session::get('coupon')['coupon_name'] }}
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

                                        <tr>
                                            <td class="cart_total_label">
                                                <h6 class="text-muted">Grand Total</h6>
                                            </td>
                                            <td class="cart_total_amount">
                                                <h4 class="text-brand text-end">
                                                    ${{ Session::get('coupon')['total_amount'] }}</h4>
                                            </td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td class="cart_total_label">
                                                <h6 class="text-muted">Subtotal</h6>
                                            </td>
                                            <td class="cart_total_amount">
                                                <h4 class="text-brand text-end">${{ $cart_total }}</h4>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="cart_total_label">
                                                <h6 class="text-muted">Grand Total</h6>
                                            </td>
                                            <td class="cart_total_amount">
                                                <h4 class="text-brand text-end">${{ $cart_total }}</h4>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>





                        </div>
                    </div>
                </div>


                <div class="col-lg-6">
                    <div class="border p-40 cart-totals ml-30 mb-50">
                        <div class="d-flex align-items-end justify-content-between mb-30">
                            <h4>Make Payement</h4>
                        </div>
                        <div class="divider-2 mb-30"></div>
                        <div class="table-responsive order_table checkout">

                            <form action="{{ route('phonepe.payment') }}" method="post" id="payment-form">
                                @csrf
                                <input type="hidden" name="data" value="{{ json_encode($data) }}">
                                <div class="form-row">
                                    <img width="200" height="200" class="mr-15" src="{{ asset('frontend/assets/imgs/theme/icons/PhonePe.svg') }}"
                                    alt="">
                                </div>
                                <br>
                                <button class="btn btn-primary">Confirm Payment</button>
                            </form>





                        </div>
                    </div>
                    {{-- <div class="payment ml-30">
                        <h4 class="mb-30">Payment</h4>
                        <div class="payment_option">
                            <div class="custome-radio">
                                <input class="form-check-input" required="" type="radio" name="payment_option"
                                    id="exampleRadios3" checked="">
                                <label class="form-check-label" for="exampleRadios3" data-bs-toggle="collapse"
                                    data-target="#bankTranfer" aria-controls="bankTranfer">Direct Bank Transfer</label>
                            </div>
                            <div class="custome-radio">
                                <input class="form-check-input" required="" type="radio" name="payment_option"
                                    id="exampleRadios4" checked="">
                                <label class="form-check-label" for="exampleRadios4" data-bs-toggle="collapse"
                                    data-target="#checkPayment" aria-controls="checkPayment">Cash on delivery</label>
                            </div>
                            <div class="custome-radio">
                                <input class="form-check-input" required="" type="radio" name="payment_option"
                                    id="exampleRadios5" checked="">
                                <label class="form-check-label" for="exampleRadios5" data-bs-toggle="collapse"
                                    data-target="#paypal" aria-controls="paypal">Online Getway</label>
                            </div>
                        </div>
                        <div class="payment-logo d-flex">
                            <img class="mr-15" src="assets/imgs/theme/icons/payment-paypal.svg" alt="">
                            <img class="mr-15" src="assets/imgs/theme/icons/payment-visa.svg" alt="">
                            <img class="mr-15" src="assets/imgs/theme/icons/payment-master.svg" alt="">
                            <img src="assets/imgs/theme/icons/payment-zapper.svg" alt="">
                        </div>
                        <a href="#" class="btn btn-fill-out btn-block mt-30">Place an Order<i
                                class="fi-rs-sign-out ml-15"></i></a>
                    </div> --}}
                </div>
            </div>
        </div>
    </main>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

  
@endsection
