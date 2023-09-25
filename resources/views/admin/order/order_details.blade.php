@extends('admin.admin_dashboard')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js">
    </script>
    <script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">
    <div class="page-content">
        <div class="container">
            <div class="page-title-box">

            </div>
            <div class="main-body">
                <div class="d-flex justify-content-between mb-2">
                    <h5 class="page-title">Order Details</h5>

                  @if ($order->status !=='delivered')
                  <a href="{{ route('change.order.status',$order->id) }}" class="btn btn-danger mb-2"><i class="bx bx-chevrons-right"></i>
                @if ($order->status == 'pending')
                    Confirm Order
                @elseif($order->status == 'confirmed')
                    Processing
                @elseif($order->status == 'processing')
                   Delivered
                @else
                Delivered successfully
                @endif
            </a>
                  @else
                  @if ($order->return_order=='2')
                  <a href="#" class="btn btn-white mb-2"><i
                    class="bx bx-check-double text-success"></i>Returned Successfully</a>
                    @else
                    <a href="#" class="btn btn-white mb-2"><i
                        class="bx bx-check-double text-success"></i>Delivered Successfully</a>
                  @endif
                  @endif
                
                </div>
                
                <div class="row row-cols-1 row-cols-md-1 row-cols-lg-2 row-cols-xl-2">
                    <div class="col">
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
                                        <h6>Order status:@if ($order->status == 'pending')
                                                <span class="badge rounded-pill bg-light-danger text-danger ">Pending</span>
                                            @elseif($order->status == 'confirmed')
                                                <span
                                                    class="badge rounded-pill  bg-light-primary text-primary ">Confirmed</span>
                                            @elseif($order->status == 'processing')
                                                <span
                                                    class="badge rounded-pill  bg-light-primary text-warning">Processing</span>
                                            @elseif($order->status == 'delivered')
                                                <span
                                                    class="badge rounded-pill  bg-light-primary text-success">Delivered</span>
                                            @endif
                                        </h6>
                                    </div>


                                </div>




                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <h6>Shipping Details</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <h6>Name: {{ $order->name }}</h6>
                                        <h6>Phone: {{ $order->phone }}</h6>
                                        <h6>Email: {{ $order->email }}</h6>
                                        <h6>Address: {{ $order->address }}</h6>
                                    </div>
                                    <div class="col-6">
                                        <h6>District: {{ $order['district']->district_name }}</h6>
                                        <h6>State: {{ $order['state']->state_name }}</h6>
                                        <h6>Division: {{ $order['division']->division_name }}</h6>
                                        <h6>Post Code: {{ $order->post_code }}</h6>
                                    </div>

                                </div>




                            </div>
                        </div>
                    </div>
                </div>
                <div class="row ">
                    <div class="col-md-12">
                        <div class="card">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>vendor</th>
                                        <th>color</th>
                                        <th>size</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
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
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
