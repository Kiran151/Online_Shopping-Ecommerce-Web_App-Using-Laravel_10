@extends('admin.admin_dashboard')
@section('admin')
    <div class="page-content">
        <div class="container">
            <div class="main-body">
                <div class="row">
                    <div class="card  d-none">
                        <div class="card-body">
                            <div class="d-flex justify-content-end mb-2">
                                <a href="{{ route('add.slider') }}" class="btn btn-danger mb-2"><i
                                        class="fadeIn animated bx bx-plus-circle"></i>
                                    Add Slider</a>
                            </div>
                            <div class="table-responsive">
                                <table id="example" class="table table-striped table-hover table-bordered"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>SL.NO</th>
                                            <th>SLIDER IMAGE</th>
                                            <th>SLIDER TITLE</th>
                                            <th>SLIDER SUBTITLE</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>
                                                        <div class="recent-product-img">
                                                            <img src="{{ !empty($item->image) ? asset('uploads/backend/slider/' . $item->image) : asset('uploads/img/no_image.jpg') }}"
                                                                alt="">
                                                        </div>
                                                </td>
                                                <td>{!! $item->title !!}</td>
                                                <td>{{ $item->subtitle }}</td>
                                                <td>
                                                    <div class="d-flex order-actions">
                                                        <a href="{{ route('add.slider', $item->id) }}" class="bg-warning"><i
                                                                class="bx bxs-edit"></i></a>
                                                        <a href="{{ route('delete.slider', $item->id) }}" id="delete"
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
