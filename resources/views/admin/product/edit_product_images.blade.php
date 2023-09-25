@extends('admin.admin_dashboard')
@section('admin')
    <div class="page-content">
        <div class="container">
            <div class="main-body">
                <div class="row">
                    <div class="card  d-none">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="" class="table table-striped table-hover table-bordered"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>SL.NO</th>
                                            <th>IMAGE</th>
                                            <th>PRODUCT NAME</th>
                                            <th>UPDATE IMAGE</th>
                                            <th>INSERT NEW</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $key => $item)
                                            <form action="{{ route('update.product_images') }}" method="post"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td><img src="{{ !empty($item->image) ? asset('uploads/backend/product/' . $item->image) : asset('uploads/img/no_image.jpg') }}"
                                                            alt="image" class="img-fluid avatar-md rounded"
                                                            height="40" width="40"></td>
                                                    <td>{{ $product->product_name }}</td>
                                                    <td><input type="file" name="img[{{ $item->id }}]"></td>
                                                    <td> <input type="file" name="new_imgs[]" multiple>
                                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                    </td>
                                                    <td>
                                                        <div class="d-flex order-actions">
                                                            <button title="save" type="submit"
                                                                class="btn btn-secondary"><i
                                                                    class="ms-2 bx bx-save"></i></button>
                                                            <a href="{{ route('delete.productImage', $item->id) }}"
                                                                id="delete" class="ms-2 bg-danger"><i
                                                                    class="bx bxs-trash"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>

                                            </form>
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
