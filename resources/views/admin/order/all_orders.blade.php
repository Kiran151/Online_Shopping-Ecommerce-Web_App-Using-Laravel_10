@extends('admin.admin_dashboard')
@section('admin')
    <div class="page-content">
        <div class="container">
            <div class="main-body">
                <div class="row">
                    <div class="card  d-none">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <div class="col-8 text-start">

                                    <div class="row ">
                                        <label for="inputFromDate" class="col-md-2 col-form-label text-md-end fw-bold">From
                                            Date</label>
                                        <div class="col-md-4">
                                            <input type="date" name="from" class="form-control" id="inputFromDate">
                                        </div>
                                        <label for="inputToDate" class="col-md-2 col-form-label text-md-end fw-bold">To Date</label>
                                        <div class="col-md-4">
                                            <input type="date" name="to" class="form-control" id="inputToDate">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3 text-end">
                                    <a href="{{ route('add.product') }}" class="btn btn-danger mb-2"><i
                                            class="fadeIn animated bx bx-plus-circle"></i>
                                        Add Product</a>
                                </div>

                            </div>
                            <div class="table-responsive">
                                <table id="example" class="table table-striped table-hover table-bordered"
                                    style="width:100%">
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
                                    <tbody id="order_body">
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

                </div>
            </div>
        </div>
    </div>
    <!-- Add the loading spinner element -->

    <div class="preloaderBg" id="loader-table">
        <div class="preloader"></div>
        <div class="preloader2"></div>
    </div>
    <!-- iframe -->

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
            var printUrl = "{{ route('print_admin.order.invoice') }}";
            printUrl = printUrl + "/" + order_id;
            console.log(printUrl);

            $('#printiframe').attr("src", `${printUrl}`).on('load', function() {
                document.getElementById('printiframe').focus();
                document.getElementById('printiframe').contentWindow.print();

            });



        }
    </script>
    <script>
        $('#inputToDate').change(function() {
            from = $('#inputFromDate').val();
            to = $('#inputToDate').val();

            $.ajax({
                type: 'GET',
                url: `{{ url('admin/order/sort_by_date') }}`,
                data: {
                    'from': from,
                    'to': to
                },
                success: function(data) {
                    console.log(data);
                    $('#order_body').html(data);
                }
            })

        })
    </script>
@endsection
