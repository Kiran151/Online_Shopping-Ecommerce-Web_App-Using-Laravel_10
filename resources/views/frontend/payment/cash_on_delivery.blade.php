@extends('frontend.master')
@section('master')
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="index.html" rel="nofollow"><i class="fi-rs-home mr-5"></i>Checkout</a>
                    <span></span> Cash On Delivery
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
                            <h4>Your Order Details</h4>
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
                            <h4>Confirm Order</h4>
                        </div>
                        <div class="divider-2 mb-30"></div>
                        <div class="table-responsive order_table checkout">

                            <form action="{{ route('cash.payment') }}" method="post">
                                @csrf
                                <input type="hidden" name="data" value="{{ json_encode($data) }}">
                                <div class="form-row">
                                    <h5>
                                        Cash On Delivery
                                    </h5>
{{-- 
                                    <div id="card-element">
                                        <!-- A Stripe Element will be inserted here. -->
                                    </div>
                                    <!-- Used to display form errors. -->
                                    <div id="card-errors" role="alert"></div> --}}
                                </div> 
                                    <br>
                                    <button class="btn btn-primary">Submit</button>
                            </form>





                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>
@endsection
