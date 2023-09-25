@extends('admin.admin_dashboard')
@section('admin')
<style>
    .narrow-cell {
    max-width: 150px; /* Adjust this value to your desired width */
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
/* In the above CSS code:

max-width sets the maximum width for the cell. You can adjust the value to your preferred width.
overflow: hidden hides any content that overflows the specified width.
text-overflow: ellipsis adds an ellipsis (...) to indicate that there is more content hidden.
white-space: nowrap ensures that the text does not wrap to the next line.
By setting a maximum width and using ellipsis, you can effectively reduce the width of the cell and handle long titles more gracefully. */

</style>
    <div class="page-content">
        <div class="container">
            <div class="main-body">
                <div class="row">
                    <div class="card  d-none">
                        <div class="card-body">
                            <div class="d-flex justify-content-end mb-2">
                                <a href="{{ route('add.blog') }}" class="btn btn-danger mb-2"><i
                                        class="fadeIn animated bx bx-plus-circle"></i>
                                    Add Blog</a>
                            </div>
                            <div class="table-responsive">
                                <table id="example" class="table table-striped table-hover table-bordered"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>SL.NO</th>
                                            <th>IMAGE</th>
                                            <th>BlOG TITLE</th>
                                            <th>BlOG CATEGORY</th>
                                            <th>SHORT DESCRIPTION</th>
                                            <th>LONG DESCRIPTION</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>

                                                    <img src="{{ !empty($item->image) ? asset('uploads/backend/blog/' . $item->image) : asset('uploads/img/no_image.jpg') }}"
                                                        alt="image" class="img-fluid avatar-md rounded" height="40"
                                                        width="40">
                                                </td>
                                                <td class="narrow-cell">{{ $item->title }}</td>
                                                <td>{{ $item['blog_category']->blog_category_name }}</td>
                                                <td class="narrow-cell">{{ $item->short_description }}</td>
                                                <td class="narrow-cell">{{ $item->long_description }}</td>

                                                <td>
                                                    <div class="d-flex order-actions">
                                                        <a href="{{ route('add.blog', $item->id) }}"
                                                            class="bg-warning"><i class="bx bxs-edit"></i></a>
                                                        <a href="{{ route('delete.blog', $item->id) }}" id="delete"
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
