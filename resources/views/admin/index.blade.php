@extends('admin.admin_dashboard')
@section('admin')
    @php
        $total_orders = App\Models\Order::count();
        $total_revenue = App\Models\Order::where('return_order', '!=', 2)->sum('amount');
        $users = App\Models\User::where([['role', 'user'], ['status', 'active']])->count();
        $top_orders = App\Models\OrderItems::orderBy('price', 'DESC')
            ->limit(10)
            ->get();
    @endphp
    <div class="page-content">
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
            <div class="col">
                <div class="card radius-10 bg-gradient-deepblue">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <h5 class="mb-0 text-white">{{ $total_orders }}</h5>
                            <div class="ms-auto">
                                <i class='bx bx-cart fs-3 text-white'></i>
                            </div>
                        </div>
                        <div class="progress my-3 bg-light-transparent" style="height:3px;">
                            <div class="progress-bar bg-white" role="progressbar" style="width: 55%" aria-valuenow="25"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="d-flex align-items-center text-white">
                            <p class="mb-0">Total Orders</p>
                            <p class="mb-0 ms-auto">+4.2%<span><i class='bx bx-up-arrow-alt'></i></span></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10 bg-gradient-orange">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <h5 class="mb-0 text-white">${{ $total_revenue }}</h5>
                            <div class="ms-auto">
                                <i class='bx bx-dollar fs-3 text-white'></i>
                            </div>
                        </div>
                        <div class="progress my-3 bg-light-transparent" style="height:3px;">
                            <div class="progress-bar bg-white" role="progressbar" style="width: 55%" aria-valuenow="25"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="d-flex align-items-center text-white">
                            <p class="mb-0">Total Revenue</p>
                            <p class="mb-0 ms-auto">+1.2%<span><i class='bx bx-up-arrow-alt'></i></span></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10 bg-gradient-ohhappiness">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <h5 class="mb-0 text-white">{{ $users }}</h5>
                            <div class="ms-auto">
                                <i class='bx bx-group fs-3 text-white'></i>
                            </div>
                        </div>
                        <div class="progress my-3 bg-light-transparent" style="height:3px;">
                            <div class="progress-bar bg-white" role="progressbar" style="width: 55%" aria-valuenow="25"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="d-flex align-items-center text-white">
                            <p class="mb-0">Users</p>
                            <p class="mb-0 ms-auto">+5.2%<span><i class='bx bx-up-arrow-alt'></i></span></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10 bg-gradient-ibiza">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <h5 class="mb-0 text-white">5630</h5>
                            <div class="ms-auto">
                                <i class='bx bx-envelope fs-3 text-white'></i>
                            </div>
                        </div>
                        <div class="progress my-3 bg-light-transparent" style="height:3px;">
                            <div class="progress-bar bg-white" role="progressbar" style="width: 55%" aria-valuenow="25"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="d-flex align-items-center text-white">
                            <p class="mb-0">Messages</p>
                            <p class="mb-0 ms-auto">+2.2%<span><i class='bx bx-up-arrow-alt'></i></span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end row-->

        <div class="card radius-10">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <h5 class="mb-0">Top Orders</h5>
                    </div>
                    <div class="font-22 ms-auto"><i class="bx bx-dots-horizontal-rounded"></i>
                    </div>
                </div>
                <hr>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Invoice id</th>
                                <th>Product</th>
                                <th>Customer</th>
                                <th>Date</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($top_orders as $item)
                                @php
                                    if ($item['order']->status == 'pending') {
                                        $status = 'Pending';
                                        $status_color = 'text-danger';
                                    } elseif ($item['order']->status == 'confirmed') {
                                        $status = 'Confirmed';
                                        $status_color = 'text-primary';
                                    } elseif ($item['order']->status == 'processing') {
                                        $status = 'Processing';
                                        $status_color = 'text-warning';
                                    } elseif ($item['order']->status == 'delivered') {
                                        $status = 'Delivered';
                                        $status_color = 'text-success';
                                    }
                                    $user = App\Models\User::where('id', $item['order']->user_id)->first();
                                @endphp
                                <tr>
                                    <td>{{ $item['order']->invoice_no }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="recent-product-img">
                                                <img src="{{ asset('uploads/backend/product/thumbnail/' . $item['product']->thumbnail_image) }}"
                                                    alt="">
                                            </div>
                                            <div class="ms-2">
                                                <h6 class="mb-1 font-14">{{ $item['product']->product_name }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $item['order']->order_date }}</td>
                                    <td>${{ $item->price }}</td>
                                    <td>
                                        <div class="d-flex align-items-center {{ $status_color }}"> <i
                                                class="bx bx-radio-circle-marked bx-burst bx-rotate-90 align-middle font-18 me-1"></i>
                                            <span>{{ $status }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex order-actions"> <a href="javascript:;" class=""><i
                                                    class="bx bx-cog"></i></a>
                                            <a href="javascript:;" class="ms-4"><i class="bx bx-down-arrow-alt"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card radius-10">
            <div class="card-tools p-3 d-flex justify-content-between">
                <div>
                    <h5 class="mb-0">Orders</h5>
                </div>
                <select name="" id="order_period" data-control="select2" data-hide-search="true"
                    class="form-select-lg btn btn-secondary text-white btn-border btn-round mr-2 order_filter">
                    <option value="Daily">Daily</option>
                    <option value="Weekly">Weekly</option>
                    <option value="Monthly">Monthly</option>
                    {{-- <option value="Yearly">Yearly</option> --}}
                </select>
            </div>
            <div class="card-body">
                <div id="chart1"></div>
            </div>
        </div>

    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script>
        $(function() {
            load_order_graph_data();
        })
    </script>
    <script>
        function load_order_graph_data() {
            period = $('#order_period').val();
            $.ajax({
                type: 'GET',
                url: "{{ route('load_order_graph') }}",
                data: {
                    'period': period
                },
                success: function(data) {
                    console.log(data);
                    $('#chart1').empty();
                    order_graph(data.datas, data.labels);



                }

            })
        }
    </script>

    <script>
        $('#order_period').change(function() {
            load_order_graph_data()
        })
    </script>

    <script>
        function order_graph(data = [], labels = []) {
            // "use strict";

            var options = {
                series: [{
                    name: 'Orders',
                    data: data
                }],
                chart: {
                    foreColor: '#9ba7b2',
                    height: 360,
                    type: 'line',
                    zoom: {
                        enabled: false
                    },
                    toolbar: {
                        show: false
                    },
                    dropShadow: {
                        enabled: true,
                        top: 3,
                        left: 14,
                        blur: 4,
                        opacity: 0.10,
                    }
                },
                stroke: {
                    width: 5,
                    curve: 'smooth'
                },
                xaxis: {
                    type: 'string',
                    categories: labels,
                },
                // title: {
                //     text: 'Orders',
                //     align: 'left',
                //     style: {
                //         fontSize: "16px",
                //         color: '#666'
                //     }
                // },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shade: 'light',
                        gradientToColors: ['#f41127'],
                        shadeIntensity: 1,
                        type: 'horizontal',
                        opacityFrom: 1,
                        opacityTo: 1,
                        stops: [0, 100, 100, 100]
                    },
                },
                markers: {
                    size: 4,
                    colors: ["#f41127"],
                    strokeColors: "#fff",
                    strokeWidth: 2,
                    hover: {
                        size: 7,
                    }
                },
                colors: ["#f41127"],
                yaxis: {
                    title: {
                        text: 'Orders',
                    },
                }
            };
            var chart = new ApexCharts(document.querySelector("#chart1"), options);
            chart.render();

        }
    </script>
@endsection
