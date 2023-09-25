@extends('frontend.master')
@section('master')
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="index.html" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                    <span></span> Account
                    <span></span>Orders
                </div>
            </div>
        </div>
        <div class="container mb-80 mt-50">
            <div class="row">
                <div class="col-lg-8 mb-40">
                    <h1 class="heading-2 mb-10">Your Cart</h1>
                    <div class="d-flex justify-content-between">
                        <h6 class="text-body">There are <span class="text-brand" id="cart_count">1</span>
                            products in your cart</h6>
                        <h6 class="text-body"><a href="" class="text-muted"><i class="fi-rs-trash mr-5"></i>Clear
                                Cart</a></h6>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h6>Order Details</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-8">
                                    <h6>Invoice: <span style="color: brown">{{ $order->invoice_no }}</span></h6>
                                    <h6>Amount: ${{ $order->amount }}</h6>
                                    <h6>Payment Method: {{ $order->payment_type }}</h6>
                                    <h6>Order Date: {{ $order->order_date }}</h6>
                                    <h6>Order status: <span class="badge bg-warning">{{ $order->status }}</span></h6>
                                </div>


                            </div>




                        </div>
                    </div>

                </div>

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h6>Shipping Details</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <h6>Name: {{ $order->name }}</h6>
                                    <h6>Phone: {{ $order->phone }}</h6>
                                    <h6>Phone: {{ $order->email }}</h6>
                                    <h6>Address: {{ $order->address }}</h6>
                                    <h6>Division: {{ $order['division']->division_name }}</h6>
                                </div>
                                <div class="col-6">
                                    <h6>District: {{ $order['district']->district_name }}</h6>
                                    <h6>State: {{ $order['state']->state_name }}</h6>
                                    <h6>Post Code: {{ $order->post_code }}</h6>
                                </div>

                            </div>




                        </div>
                    </div>

                </div>

            </div>
        </div>
        <div class="container mb-30 mt-50">
            <div class="row">
                <div class="col-xl-10 col-lg-12 ">
                    <div class="mb-50">
                        <h1 class="heading-2 mb-10">Your Orders</h1>
                        <h6 class="text-body">There are <span class="text-brand">{{ count($orderItem) }}</span> products in
                            this
                            list</h6>
                    </div>
                    <div class="table-responsive shopping-summery">
                        <table class="table table-wishlist ">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>vendor</th>
                                    <th>color</th>
                                    <th>size</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orderItem as $item)
                                    <tr>
                                        <td class="image product-thumbnail pt-30">
                                            <div class="d-flex align-items-center">
                                                <div class="recent-product-img">
                                                    <img src="{{ asset('uploads/backend/product/thumbnail/' . $item['product']->thumbnail_image) }}"
                                                        alt="#" />
                                                </div>
                                                <div class="ms-2">
                                                    <h6 class="mb-1 font-14">{{ $item['product']->product_name }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $item['vendor']->name ?: '..' }}</td>
                                        <td>{{ $item->color }}</td>
                                        <td>{{ $item->size }}</td>
                                        <td>${{ $item->price }}</td>
                                        <td>{{ $item->qty }}</td>
                                        <td class="action text-center" data-title="Remove">
                                            <a onclick="" class="text-body"><i class="fi-rs-trash"></i></a>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @if ($order->status == 'delivered' && $order->return_order !== '1')
                <div class="col-6 form-group mt-4">
                    <form action="{{ route('order.return', $order->id) }}" method="post">
                        @csrf
                        <h4>Order return</h4>
                        <textarea placeholder="Order return reason" class="form-control mt-1" name="return_reason" id="" cols="30"
                            rows="10"></textarea>
                        <button type="submit" class="mt-3">Order Return</button>
                    </form>
                </div>
                @elseif($order->return_order=='1')
                <h5 class="text-danger">Return order processing</h5>
            @endif
        </div>
    </main>
@endsection
