@extends('admin.admin_dashboard')
@section('admin')
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
                                            {{-- <th>PRODUCT</th> --}}
                                            <th>CUSTOMER</th>
                                            <th>REQUESTED DATE</th>
                                            <th>RETURN REASON</th>
                                            <th>PAYMENT</th>
                                            <th>STATUS</th>
                                            <th class="text-center">ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $key => $item)
                                            <tr>
                                                <td>{{ $item->invoice_no }}</td>

                                                <td>{{ $item->name }}</td>

                                                <td>{{ $item->return_date }}</td>
                                                <td>{{ $item->return_reason }}</td>
                                                <td>{{ $item->payment_method }}</td>

                                                <td>
                                                    @if ($item->return_order == '1')
                                                        <span class="badge rounded-pill bg-danger">Pending</span>
                                                    @elseif($item->return_order == '2')
                                                        <span
                                                            class="badge rounded-pill  bg-success text-white">Completed</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex order-actions">
                                                        <a href="{{ route('admin.order.details', $item->id) }}"
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
        function confirmreturn(order_id) {

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to Confirm Return!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href=`{{ url('admin/confirm_return/${order_id}') }}`;
                    Swal.fire(
                        'Confirmed!',
                        'Order Return Confirmed.',
                        'success'
                    )
                }
            })

            // Swal.fire({
            //     title: 'Are you sure?',
            //     text: "Do you want to Confirm Return?",
            //     icon: 'warning',
            //     showCancelButton: true,
            //     showConfirmButton:false,
            //     confirmButtonColor: '#3085d6',
            //     cancelButtonColor: '#d33',
            //     footer: `<a href="{{ url('admin/confirm_return/${order_id}') }}">Yes</a>`
            // })
        }
    </script>
@endsection
