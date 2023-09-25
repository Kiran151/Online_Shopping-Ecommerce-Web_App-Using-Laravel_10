@extends('vendor.vendor_dashboard')
@section('vendor')
    <div class="page-content">
        <div class="container">
            <div class="main-body">
                <div class="row">
                    <div class="card  d-none">
                        <div class="card-body">
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
                                            <th>STATUS</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $key => $item)
                                            <tr>
                                                <td>{{ $item['order']->invoice_no }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="recent-product-img">
                                                            <img src="{{ !empty($item['product']->thumbnail_image) ? asset('uploads/backend/product/thumbnail/' . $item['product']->thumbnail_image) : asset('uploads/img/no_image.jpg') }}"
                                                                alt="">
                                                        </div>
                                                        <div class="ms-2">
                                                            <h6 class="mb-1 font-14">{{ $item['product']->product_name }}
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $item['order']->name }}</td>

                                                <td>{{ $item['order']->order_date }}</td>
                                                <td>{{ '$' . $item['order']->amount }}</td>

                                                <td>
                                                    @if ($item['order']->status == 'pending')
                                                        <span
                                                            class="badge rounded-pill bg-danger text-white ">Pending</span>
                                                    @elseif($item['order']->status == 'confirmed')
                                                        <span
                                                            class="badge rounded-pill  bg-primary text-white ">Confirmed</span>
                                                    @elseif($item['order']->status == 'processing')
                                                        <span
                                                            class="badge rounded-pill  bg-warning text-white">Processing</span>
                                                    @elseif($item['order']->status == 'delivered')
                                                        <span
                                                            class="badge rounded-pill  bg-success text-white">Delivered</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex order-actions">
                                                        <a href="{{ route('vendor.order.details', $item->id) }}"
                                                            class="bg-warning"><i class="lni lni-eye fs-5"></i></a>

                                                        <a style="cursor: pointer"
                                                            onclick="print_invoice({{ $item['order']->id }})"
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

                </div>
            </div>
        </div>
    </div>
    <div class="preloaderBg" id="loader-table">
        <div class="preloader"></div>
        <div class="preloader2"></div>
    </div>
    <!-- Add the loading spinner element -->
    <iframe id="printiframe" style="display: none"></iframe>

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
    <script>
        function print_invoice(id) {
            order_id = id;
            var printUrl = "{{ route('print_vendor.order.invoice') }}";
            printUrl = printUrl + "/" + order_id;
            console.log(printUrl);

            $('#printiframe').attr("src", `${printUrl}`).on('load', function() {
                document.getElementById('printiframe').focus();
                document.getElementById('printiframe').contentWindow.print();

            });



        }
    </script>
@endsection
