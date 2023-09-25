<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8" />
    <title>Nest - Invoice</title>
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:title" content="" />
    <meta property="og:type" content="" />
    <meta property="og:url" content="" />
    <meta property="og:image" content="" />
    <!-- Favicon -->
    <link rel="stylesheet" href="{{asset('frontend/assets/css/main.css?v=5.3')}}" />
     <!-- Bootstrap CSS -->
     <link href="{{ asset('adminBackend/assets/css/bootstrap.min.css') }}" rel="stylesheet">
</head>

<body>
    <div class="invoice invoice-content invoice-2">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="invoice-inner">
                        <div class="invoice-info" id="invoice_wrapper">
                            <div class="invoice-header">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="invoice-numb">
                                            <h4 class="invoice-header-1 mb-10 mt-20">Invoice No:<span class="text-brand">{{$order->invoice_no}}</span></h4>
                                            <h6 class="">Date: {{$order->order_date}}</h6>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="invoice-name text-end">
                                            <div class="logo">
                                                <a href="index.html"><img src="{{ asset('frontend/assets/imgs/theme/logo.svg') }}" alt="logo" /></a>
                                                <p class="text-sm text-mutted">205 North Michigan Avenue, Suite 810 <br> Chicago, 60601, USA</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="invoice-top">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="invoice-number">
                                            <h4 class="invoice-title-1 fw-bold mb-10">Invoice To:</h4>
                                            <p class="invoice-addr-1">
                                                <strong>{{$order->name}}</strong> <br />
                                                {{$order->email}} <br />
                                                {{$order->address}}, <br />India
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="invoice-number">
                                            <h4 class="invoice-title-1 fw-bold mb-10">Bill To:</h4>
                                            <p class="invoice-addr-1">
                                                <strong>NestMart Inc</strong> <br />
                                                billing@NestMart.com <br />
                                                205 North Michigan Avenue, <br />Suite 810 Chicago, 60601, USA
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-6">
                                        <h4 class="invoice-title-1 fw-bold mb-10">Order Status:</h4>
                                        <p class="invoice-from-1 text-uppercase">{{$order->status}}</p>
                                    </div>
                                    <div class="col-6">
                                        <h4 class="invoice-title-1 fw-bold mb-10">Payment Method</h4>
                                        <p class="invoice-from-1">Via {{$order->payment_method}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="invoice-center">
                                <div class="">
                                    <table class="table table-striped invoice-table">
                                        <thead class="bg-active">
                                            <tr>
                                                <th class="fw-bold">Item</th>
                                                <th class="text-center fw-bold">Unit Price</th>
                                                <th class="text-center fw-bold">Quantity</th>
                                                <th class="text-right fw-bold">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           @foreach ($orderItem as $item)
                                           <tr>
                                            <td>
                                                {{$item['product']->product_name}}
                                            </td>
                                            <td class="text-center">${{$item->price}}</td>
                                            <td class="text-center">{{$item->qty}}</td>
                                            <td class="text-right">${{$item->qty*$item->price}}</td>
                                        </tr>
                                           @endforeach
                                          
                                            <tr>
                                                <td colspan="3" class="text-end f-w-600">SubTotal</td>
                                                <td class="text-right">${{$order->amount}}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="text-end f-w-600">Tax</td>
                                                <td class="text-right">$00.00</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="text-end fw-bold fs-5">Grand Total</td>
                                                <td class="text-right f-w-600">${{$order->amount}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>