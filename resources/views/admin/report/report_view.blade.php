@extends('admin.admin_dashboard')
@section('admin')
    <div class="page-content">
        <div class="container">
            <div class="main-body">
                <div class="row row-cols-1 row-cols-md-1 row-cols-lg-3 row-cols-xl-3">
                    <form action="{{ route('search.date') }}" method="post">
                        @csrf
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Search by Date</h5>
                                    <label for="" class="form-label">Date</label>
                                    <input type="date" name="date" class="form-control" id="">
                                    <input type="submit" class="btn btn-primary mt-3" value="Submit">
                                </div>


                            </div>
                        </div>
                    </form>
                    <form action="{{ route('search.month') }}" method="post">
                        @csrf
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <h5 class="card-title">Search by Month</h5>
                                        <div class="col-6">
                                            <label for="" class="form-label">Month</label>
                                            <select class="form-select form-control" name="month"
                                                aria-label="Default select example">
                                                <option disabled selected>Month</option>
                                                <option value="January">January</option>
                                                <option value="February">February</option>
                                                <option value="March">March</option>
                                                <option value="April">April</option>
                                                <option value="May">May</option>
                                                <option value="June">June</option>
                                                <option value="July">July</option>
                                                <option value="August">August</option>
                                                <option value="September">September</option>
                                                <option value="October">October</option>
                                                <option value="November">November</option>
                                                <option value="December">December</option>

                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label for="" class="form-label">Year</label>
                                            <select class="form-select form-control" name="month_year"
                                                aria-label="Default select example">
                                                <option disabled selected>Year</option>
                                                <option value="2023">2023</option>
                                                <option value="2024">2024</option>
                                                <option value="2025">2025</option>
                                                <option value="2026">2026</option>
                                                <option value="2027">2027</option>
                                                <option value="2028">2028</option>
                                                <option value="2029">2029</option>
                                                <option value="2030">2030</option>
                                            </select>
                                        </div>

                                    </div>

                                    <input type="submit" class="btn btn-primary mt-3" value="Submit">
                                </div>


                            </div>
                        </div>
                    </form>
                    <form action="{{ route('search.year') }}" method="post">
                        @csrf
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Search by Year</h5>
                                    <label for="" class="form-label">Year</label>
                                    <select class="form-select form-control" name="year"
                                        aria-label="Default select example">
                                        <option disabled selected>Year</option>
                                        <option value="2023">2023</option>
                                        <option value="2024">2024</option>
                                        <option value="2025">2025</option>
                                        <option value="2026">2026</option>
                                        <option value="2027">2027</option>
                                        <option value="2028">2028</option>
                                        <option value="2029">2029</option>
                                        <option value="2030">2030</option>

                                    </select>
                                    <input type="submit" class="btn btn-primary mt-3" value="Submit">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @if (@$data !== null)
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <h5>Orders</h5>
                            @if (@$date !== null)
                                <h5>Date:{{ @$date }}</h5>
                            @elseif(@$month !== null && @$year !== null)
                                <h5>Month:{{ @$month }}</h5>,
                                <h5>Year:{{ @$year }}</h5>
                            @elseif(@$year !== null)
                                <h5>Year:{{ @$year }}</h5>
                            @endif
                        </div>
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-hover table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>INVOICE</th>
                                        {{-- <th>PRODUCT</th> --}}
                                        <th>CUSTOMER</th>
                                        <th>DATE</th>
                                        <th>PRICE</th>
                                        <th>STATUS</th>
                                        <th class="text-center">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $key => $item)
                                        <tr>
                                            <td>{{ $item->invoice_no }}</td>
                                            {{-- <td>
                                        <div class="d-flex align-items-center">
                                            <div class="recent-product-img">
                                                <img src="{{ !empty($item->thumbnail_image) ? asset('uploads/backend/product/thumbnail/' . $item->thumbnail_image) : asset('uploads/img/no_image.jpg') }}"
                                                    alt="">
                                            </div>
                                            <div class="ms-2">
                                                <h6 class="mb-1 font-14">{{ $item->product_name }}</h6>
                                            </div>
                                        </div>
                                    </td> --}}
                                            <td>{{ $item->name }}</td>

                                            <td>{{ $item->order_date }}</td>
                                            <td>{{ '$' . $item->amount }}</td>

                                            <td>
                                                @if ($item->status == 'pending')
                                                    <span
                                                        class="badge rounded-pill bg-light-danger text-danger ">Pending</span>
                                                @elseif($item->status == 'confirmed')
                                                    <span class="badge rounded-pill  bg-primary ">Confirmed</span>
                                                @elseif($item->status == 'processing')
                                                    <span class="badge rounded-pill  bg-warning ">Processing</span>
                                                @elseif($item->status == 'delivered')
                                                    <span class="badge rounded-pill  bg-success ">Delivered</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex order-actions">
                                                    <a href="{{ route('admin.order.details', $item->id) }}"
                                                        class="bg-warning"><i class="lni lni-eye fs-5"></i></a>

                                                    <a style="cursor: pointer"
                                                        onclick="print_invoice({{ $item->id }})"
                                                        class="ms-2 bg-secondary text-white"><i
                                                            class="bx bx-printer"></i></a>

                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
