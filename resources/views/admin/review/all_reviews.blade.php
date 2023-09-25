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
                                            <th>SL.NO</th>
                                            <th>PRODUCT</th>
                                            <th>CUSTOMER</th>
                                            <th>RATING</th>
                                            <th>COMMENT</th>
                                            <th>STATUS</th>
                                            <th class="text-center">ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
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
                                                <td>{{ $item['customer']->name }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center fs-6">
                                                        <div class="cursor-pointer">
                                                            <i
                                                                class="bx bxs-star {{ $item->rating == 1 || 2 || 3 || 4 || 5 ? 'text-warning' : 'text-secondary' }} "></i>
                                                            <i
                                                                class="bx bxs-star {{ $item->rating == 2 || 3 || 4 || 5 ? 'text-warning' : 'text-secondary' }}"></i>
                                                            <i
                                                                class="bx bxs-star {{ $item->rating == 3 || 4 || 5 ? 'text-warning' : 'text-secondary' }}"></i>
                                                            <i
                                                                class="bx bxs-star {{ $item->rating == 4 || 5 ? 'text-warning' : 'text-secondary' }}"></i>
                                                            <i
                                                                class="bx bxs-star {{ $item->rating == 5 ? 'text-warning' : 'text-secondary' }}"></i>
                                                        </div>
                                                        <p class="mb-0 ms-1">{{ $item->rating }}</p>
                                                    </div>
                                                </td>
                                                <td>{{ Str::limit($item->comment,20) }}</td>

                                                <td><span
                                                        class="badge rounded-pill {{ $item->status == '1' ? ' bg-light-success text-success' : 'bg-light-danger text-danger' }}">{{ $item->status == '0' ? 'Inactive' : 'Active' }}</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex order-actions">
                                                        <a href="{{ route('admin.order.details', $item->id) }}"
                                                            class="bg-warning"><i class="lni lni-eye fs-5"></i></a>

                                                            @if ($item->status == '0')
                                                            <a href="{{ route('active.inactive.review', $item->id) }}"
                                                                title="approve" class="bg-primary text-white ms-2"><i
                                                                    class="bx bx-like "></i></a>
                                                        @else
                                                            <a href="{{ route('active.inactive.review', $item->id) }}"
                                                                title="disapprove" class="bg-danger text-white ms-2"><i
                                                                    class="bx bx-dislike"></i></a>
                                                        @endif
                                                        <a href="{{ route('delete.review', $item->id) }}" id="delete"
                                                            class="ms-2 bg-danger"><i class="bx bxs-trash"></i></a>
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
@endsection
