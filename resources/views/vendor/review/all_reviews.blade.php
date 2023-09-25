@extends('vendor.vendor_dashboard')
@section('vendor')
    <div class="col">
    </div>
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
                                                <td>{{ Str::limit($item->comment, 20) }}</td>

                                                <td><span
                                                        class="badge rounded-pill {{ $item->status == '1' ? ' bg-light-success text-success' : 'bg-light-danger text-danger' }}">{{ $item->status == '0' ? 'Inactive' : 'Active' }}</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex order-actions">
                                                        <button type="button"
                                                            onclick="reviewModal({{ $item->id }}, '{{ $item['product']->thumbnail_image }}','{{ $item['customer']->name }}')"
                                                            class="btn btn-primary" data-bs-toggle="modal"
                                                            data-bs-target="#exampleModal">View</button>

                                                        {{-- @if ($item->status == '0')
                                                            <a href="{{ route('active.inactive.review', $item->id) }}"
                                                                title="approve" class="bg-primary text-white ms-2"><i
                                                                    class="bx bx-like "></i></a>
                                                        @else
                                                            <a href="{{ route('active.inactive.review', $item->id) }}"
                                                                title="disapprove" class="bg-danger text-white ms-2"><i
                                                                    class="bx bx-dislike"></i></a>
                                                        @endif
                                                        <a href="{{ route('delete.review', $item->id) }}" id="delete"
                                                            class="ms-2 bg-danger"><i class="bx bxs-trash"></i></a> --}}
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
    <!-- Modal -->
    <div class="modal fadel" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Review Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="cad">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img id="image" src="assets/images/gallery/10.png" alt="..." class="card-img">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 id="customer_name" class="card-title">Card title</h5>
                                <p id="comment" class="card-text">This is a wider card with supporting text below as a natural lead-in to
                                    additional content. This content is a little bit longer.</p>
                                    <div id="rating"></div>

                                <p id="date" class="card-text"><small class="text-muted">Last updated 3 mins ago</small>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

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
        function reviewModal(review_id, image,name) {
            $.ajax({
                type: 'GET',
                url: `{{ url('vendor/review/detail/${review_id}') }}`,
                data: {
                    'id': review_id
                },
                success: function(data) {
                    console.log(data);
                    $('#image').attr('src', `{{ asset('uploads/backend/product/thumbnail/${image}') }}`)
                    $('#comment').text(data.comment)
                    $('#date').text(data.created_at)
                    $('#customer_name').text(name)
                    $('#rating').html(`
                    <div class="d-flex align-items-center fs-6">
                                                        <div class="cursor-pointer">
                                                            <i
                                                                class="bx bxs-star ${data.rating == 1 || 2 || 3 || 4 || 5 ? 'text-warning' : 'text-secondary' } "></i>
                                                            <i
                                                                class="bx bxs-star ${data.rating == 2 || 3 || 4 || 5 ? 'text-warning' : 'text-secondary' }"></i>
                                                            <i
                                                                class="bx bxs-star ${data.rating == 3 || 4 || 5 ? 'text-warning' : 'text-secondary' }"></i>
                                                            <i
                                                                class="bx bxs-star ${data.rating == 4 || 5 ? 'text-warning' : 'text-secondary' }"></i>
                                                            <i
                                                                class="bx bxs-star ${data.rating == 5 ? 'text-warning' : 'text-secondary' }"></i>
                                                        </div>
                                                        <p class="mb-0 ms-1">${data.rating }</p>
                                                    </div>
                    `)



                }



            })


        }
    </script>
@endsection
