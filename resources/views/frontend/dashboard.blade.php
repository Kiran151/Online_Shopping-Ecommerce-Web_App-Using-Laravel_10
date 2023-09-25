@extends('frontend.master')
@section('master')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">
    <main class="main pages">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="index.html" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                    <span></span> Pages <span></span> My Account
                </div>
            </div>
        </div>
        <div class="page-content pt-50 pb-50">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 m-auto">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="dashboard-menu">
                                    <ul class="nav flex-column" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="dashboard-tab" data-bs-toggle="tab"
                                                href="#dashboard" role="tab" aria-controls="dashboard"
                                                aria-selected="false"><i
                                                    class="fi-rs-settings-sliders mr-10"></i>Dashboard</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="orders-tab" data-bs-toggle="tab" href="#orders"
                                                role="tab" aria-controls="orders" aria-selected="false"><i
                                                    class="fi-rs-shopping-bag mr-10"></i>Orders</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="return_orders-tab" data-bs-toggle="tab" href="#return_orders"
                                                role="tab" aria-controls="orders" aria-selected="false"><i
                                                    class="fi-rs-shopping-bag mr-10"></i>Return Orders</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="track-orders-tab" data-bs-toggle="tab"
                                                href="#track-orders" role="tab" aria-controls="track-orders"
                                                aria-selected="false"><i class="fi-rs-shopping-cart-check mr-10"></i>Track
                                                Your Order</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="address-tab" data-bs-toggle="tab" href="#address"
                                                role="tab" aria-controls="address" aria-selected="true"><i
                                                    class="fi-rs-marker mr-10"></i>My Address</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="account-detail-tab" data-bs-toggle="tab"
                                                href="#account-detail" role="tab" aria-controls="account-detail"
                                                aria-selected="true"><i class="fi-rs-user mr-10"></i>Account details</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="change_password-tab" data-bs-toggle="tab"
                                                href="#change_password_detail" role="tab"
                                                aria-controls="change_password_detail" aria-selected="true"><i
                                                    class="fi-rs-user mr-10"></i>Change password</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('user.logout') }}"><i
                                                    class="fi-rs-sign-out mr-10"></i>Logout</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="tab-content account dashboard-content pl-50">
                                    <div class="tab-pane fade active show" id="dashboard" role="tabpanel"
                                        aria-labelledby="dashboard-tab">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="mb-0">Hello {{ $data->name }}!</h3>
                                            </div>
                                            <div class="card-body">
                                                <img src="{{ !empty($data->image) ? asset('uploads/user_images/' . $data->image) : url('uploads/img/no_image.jpg') }}" alt="image" class="img-fluid rounded-circle img-thumbnail" width="120">
                                                <p>
                                                    From your account dashboard. you can easily check &amp; view your <a
                                                        href="#">recent orders</a>,<br />
                                                    manage your <a href="#">shipping and billing addresses</a> and <a
                                                        href="#">edit your password and account details.</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                  @include('frontend.user.orders')
                                  @include('frontend.user.return_orders')

                                   @include('frontend.user.order_tracking')
                                    @include('frontend.user.my_address')
                                 @include('frontend.user.account_details')
                                   @include('frontend.user.change_password')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        $('.dropify').dropify();
    </script>
    <script>
        $(document).ready(function() {
            $('.dropify-clear').on('click', function() {
                $('#remove_img').val(1);
            })
        })
    </script>
@endsection
