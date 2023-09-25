@extends('admin.admin_dashboard')
@section('admin')
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
                                            <th>SL.NO</th>
                                            <th>VENDOR NAME</th>
                                            <th>IMAGE</th>
                                            <th>SHOP NAME</th>
                                            <th>REGISTER DATE</th>
                                            <th>STATUS</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $item->username }}</td>
                                                <td><img src="{{ !empty($item->image) ? asset('uploads/vendor_images/' . $item->image) : asset('uploads/img/no_image.jpg') }}"
                                                    alt="image" class="img-fluid avatar-md rounded" height="40"
                                                    width="40"></td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{date('Y-m-d',strtotime($item->created_at))}}</td>
                                                <td ><span class="badge rounded-pill  {{$item->status=='active' ? ' bg-light-success text-success' :'bg-light-danger text-danger'}}">{{ $item->status }}</span></td>
                                                <td>
                                                    <div class="d-flex order-actions justify-content-center">
                                                        @if ($item->status=='inactive')
                                                        <a href="{{ route('active.vendor', $item->id) }}"
                                                           title="active" class="bg-primary text-white"><i class="bx bx-like"></i></a>
                                                        @else
                                                            
                                                        <a href="{{ route('inactive.vendor', $item->id) }}" 
                                                            title="inactive"   class="bg-danger text-white"><i class="bx bx-dislike"></i></a>
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
