@extends('frontend.master')
@section('master')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        @import url('https://fonts.googleapis.com/css?family=Open+Sans&display=swap');


        .card {
            position: relative;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 0.10rem
        }

        .card-header:first-child {
            border-radius: calc(0.37rem - 1px) calc(0.37rem - 1px) 0 0
        }

        .card-header {
            padding: 0.75rem 1.25rem;
            margin-bottom: 0;
            background-color: #fff;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1)
        }

        .track {
            position: relative;
            background-color: #ddd;
            height: 7px;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            margin-bottom: 60px;
            margin-top: 50px
        }

        .track .step {
            -webkit-box-flex: 1;
            -ms-flex-positive: 1;
            flex-grow: 1;
            width: 25%;
            margin-top: -18px;
            text-align: center;
            position: relative
        }

        .track .step.active:before {
            background: #3BB77E
        }

        .track .step::before {
            height: 7px;
            position: absolute;
            content: "";
            width: 100%;
            left: 0;
            top: 18px
        }

        .track .step.active .icon {
            background: #3bbc7f;
            color: #fff
        }

        .track .icon {
            display: inline-block;
            width: 40px;
            height: 40px;
            line-height: 40px;
            position: relative;
            border-radius: 100%;
            background: #ddd
        }

        .track .step.active .text {
            font-weight: 400;
            color: #000
        }

        .track .text {
            display: block;
            margin-top: 7px
        }

        .itemside {
            position: relative;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            width: 100%
        }

        .itemside .aside {
            position: relative;
            -ms-flex-negative: 0;
            flex-shrink: 0
        }

        .img-sm {
            width: 80px;
            height: 80px;
            padding: 7px
        }

        ul.row,
        ul.row-sm {
            list-style: none;
            padding: 0
        }

        .itemside .info {
            padding-left: 15px;
            padding-right: 7px
        }

        .itemside .title {
            display: block;
            margin-bottom: 5px;
            color: #212529
        }

        p {
            margin-top: 0;
            margin-bottom: 1rem
        }

        .btn-warning {
            color: #ffffff;
            background-color: #ee5435;
            border-color: #ee5435;
            border-radius: 1px
        }

        .btn-warning:hover {
            color: #ffffff;
            background-color: #ff2b00;
            border-color: #ff2b00;
            border-radius: 1px
        }
    </style>
    <div class="container mt-4 mb-4">
        <article class="card p-6 rounded-3">
            <header class="card-header"> My Orders / Tracking </header>
            <div class="card-body">
                <h6>Invoice ID: {{ $order->invoice_no }}</h6>
                <article class="card">
                    <div class="card-body row">
                        <div class="col"> <strong>Estimated Delivery time:</strong>
                            <br>{{ date('d F Y', strtotime($order->order_date . ' +7 days')) }}
                        </div>
                        <div class="col"> <strong>Shipping To:</strong> <br> {{ $order->name }}, | <i
                                class="fa fa-phone"></i>
                            {{ $order->phone }} </div>
                        <div class="col"> <strong>Status:</strong> <br> {{ $order->status }} </div>
                        <div class="col"> <strong>Payment:</strong> <br> {{ $order->payment_method }} </div>
                    </div>
                </article>

                <div class="track">
                    <div
                        class="step {{ in_array($order->status, ['pending', 'confirmed', 'processing', 'delivered']) ? 'active' : '' }}">
                        <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text">Pending</span>
                    </div>
                    <div
                        class="step  {{ in_array($order->status, ['confirmed', 'processing', 'delivered']) ? 'active' : '' }}">
                        <span class="icon"> <i class="fa fa-user"></i> </span> <span class="text">
                            Confirmed</span>
                    </div>
                    <div class="step  {{ in_array($order->status, ['processing', 'delivered']) ? 'active' : '' }}"> <span
                            class="icon">
                            <i class="fa fa-truck"></i> </span> <span class="text"> On
                            the way </span> </div>
                    <div class="step {{ $order->status == 'delivered' ? 'active' : '' }}"> <span class="icon"> <i
                                class="fa fa-box"></i> </span> <span class="text">Delivered</span> </div>
                </div>
                <hr>
                <hr>
                <a href="{{ route('index') }}" class="btn btn-warning" data-abc="true"> <i class="fa fa-chevron-left"></i>
                    Back to
                    home</a>
            </div>
        </article>
    </div>
@endsection
