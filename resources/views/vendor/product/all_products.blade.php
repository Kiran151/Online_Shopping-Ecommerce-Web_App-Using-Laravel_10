@extends('vendor.vendor_dashboard')
@section('vendor')
    <div class="page-content">
        <div class="container">
            <div class="main-body">
                <div class="row">
                    <div class="card  d-none">
                        <div class="card-body">
                            <div class="d-flex justify-content-end mb-2">
                                <a href="{{ route('vendor.add.product') }}" class="btn btn-danger mb-2"><i
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
                                            <th>PRICE</th>
                                            <th>DISCOUNT</th>
                                            <th>QTY</th>
                                            <th>STATUS</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="recent-product-img">
                                                            <img src="{{ !empty($item->thumbnail_image) ? asset('uploads/backend/product/thumbnail/' . $item->thumbnail_image) : asset('uploads/img/no_image.jpg') }}"
                                                                alt="">
                                                        </div>
                                                        <div class="ms-2">
                                                            <h6 class="mb-1 font-14">{{ $item->product_name }}</h6>
                                                        </div>
                                                    </div>

                                                </td>
                                                <td>{{ $item->selling_price }}</td>
                                                @php
                                                    $amount = $item->selling_price - $item->discount_price;
                                                    $discount = ($amount / $item->selling_price) * 100;
                                                @endphp
                                                <td><span
                                                        class="badge bg-primary badge-primary">{{ $item->discount_price ? round($discount) . '%' : 'No discount' }}</span>
                                                </td>
                                                <td>{{ $item->product_qty }}</td>
                                                <td><span
                                                        class="badge rounded-pill {{ $item->status == 'active' ? ' bg-light-success text-success' : 'bg-light-danger text-danger' }}">{{ $item->status == 'inactive' ? 'Inactive' : 'Active' }}</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex order-actions">

                                                        <a href="{{ route('vendor.add.product', $item->id) }}"
                                                            class="bg-warning ms-2"><i class="bx bxs-edit"></i></a>
                                                        <a href="{{ url('delete/product/' . $item->id) }}" id="delete"
                                                            class="ms-2 bg-danger"><i class="bx bxs-trash"></i></a>
                                                        @if ($item->status == 'inactive')
                                                            <a href="{{ route('active.inactive.product', $item->id) }}"
                                                                title="active" class="bg-primary text-white ms-2"><i
                                                                    class="bx bx-like "></i></a>
                                                        @else
                                                            <a href="{{ route('active.inactive.product', $item->id) }}"
                                                                title="inactive" class="bg-danger text-white ms-2"><i
                                                                    class="bx bx-dislike"></i></a>
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
    <div class="preloaderBg " id="loader-table">
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
