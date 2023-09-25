@extends('admin.admin_dashboard')
@section('admin')
    <div class="page-content">
        <div class="container">
            <div class="main-body">
                <div class="row">
                    <div class="card  d-none">
                        <div class="card-body">
                            <div class="d-flex justify-content-end mb-2">
                                <div class="col-sm-3 me-1">
                                    <select class="form-select" id="sort_by">
                                        <option selected="">All</option>
                                        <option value="popular">Popular</option>
                                        <option value="low_high">Price Low-High</option>
                                        <option value="high_low">Price High-Low</option>
                                        {{-- <option value="4">Sold Out</option> --}}
                                    </select>
                                </div>
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
                                            <th>PRICE</th>
                                            <th>DISCOUNT</th>
                                            <th>QTY</th>
                                            <th>STATUS</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table_body">
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
        $('#sort_by').change(function() {
            option = $('#sort_by').val();
            $.ajax({
                type: 'GET',
                url: `{{ url('admin/product/sort/${option}') }}`,
                success: function(data) {
                    console.log(data);
                    // $('#example').empty();
                    $('#table_body').html(data);
                }
            })

        })
    </script>
@endsection
