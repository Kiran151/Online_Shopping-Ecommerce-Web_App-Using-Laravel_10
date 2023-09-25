@extends('vendor.vendor_dashboard')
@section('vendor')
    <div class="page-content">
        <div class="container">
            <div class="main-body">
                <div class="row">
                    <div class="card  d-none">
                        <div class="card-body">
                            <div class="d-flex justify-content-end mb-2">
                                <a href="{{ route('add.product') }}" class="btn btn-danger mb-2"><i
                                        class="fadeIn animated bx bx-plus-circle"></i>
                                    Add Product</a>
                            </div>
                            <div class="table-responsive">
                                <table id="example" class="table table-striped table-hover table-bordered"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>INVOICE</th>
                                            <th>PRODUCT</th>
                                            <th>CUSTOMER</th>
                                            <th>DATE</th>
                                            <th>PRICE</th>
                                            <th>PAYMENT</th>
                                            <th>REASON</th>
                                            <th>STATUS</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $key => $item)
                                           @if ($item['order']->return_order=='1'||$item['order']->return_order=='2')
                                           <tr>
                                            <td>{{ $item['order']->invoice_no }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="recent-product-img">
                                                        <img src="{{ !empty($item['product']->thumbnail_image) ? asset('uploads/backend/product/thumbnail/' .$item['product']->thumbnail_image) : asset('uploads/img/no_image.jpg') }}"
                                                            alt="">
                                                    </div>
                                                    <div class="ms-2">
                                                        <h6 class="mb-1 font-14">{{ $item['product']->product_name }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{  $item['order']->name }}</td>

                                            <td>{{ $item['order']->order_date }}</td>
                                            <td>{{ '$' .  $item['order']->amount }}</td>
                                            <td>{{$item['order']->payment_method }}</td>
                                            <td>{{$item['order']->return_reason }}</td>


                                            <td>
                                                @if ($item['order']->return_order == '1')
                                                    <span class="badge rounded-pill bg-danger">Pending</span>
                                                @elseif($item['order']->return_order == '2')
                                                    <span
                                                        class="badge rounded-pill  bg-success text-white">Completed</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex order-actions">
                                                    <a href="{{ route('vendor.order.details', $item->id) }}"
                                                        class="bg-warning"><i class="lni lni-eye fs-5"></i></a>
                                                    @if ($item->return_order == '1')

                                                    <a title="confirm return" id="confirm_return"
                                                        onclick="confirmreturn({{ $item->id }})"
                                                        class="ms-2 bg-primary text-white"><i
                                                            class="bx bx-check-square"></i></a>
                                                            @endif


                                                </div>
                                            </td>
                                        </tr>
                                           @endif
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="preloaderBg" id="loader-table">
        <div class="preloader"></div>
        <div class="preloader2"></div>
    </div>
    <!-- Add the loading spinner element -->

    <!-- Include jQuery and DataTables scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('.card').removeClass('d-none');

            var table = $('#example').DataTable({
                // Add any DataTable options here
            }).on('draw.dt', function() {
                // Hide the loading spinner when DataTable is fully loaded
            });

            // Show the loading spinner
            $('#loader-table').addClass('d-none');

        });
    </script>
@endsection
