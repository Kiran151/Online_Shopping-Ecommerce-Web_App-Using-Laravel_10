@extends('admin.admin_dashboard')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">
    <div class="page-content">
        <div class="container">
            <div class="page-title-box">
                <h5 class="page-title">{{ !empty($data) ? 'Edit' : 'Add' }} Blog</h5>

            </div>
            <div class="main-body">
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('save.blog',@$data->id) }}" method="post" enctype="multipart/form-data" id="myForm">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Image</h6>
                                    </div>
                                    <div class="col-sm-2 text-secondary form-group">
                                        <input type="hidden" name="remove_img" id="remove_img" value="">
                                        <input type="file" name="image" class="dropify" data-plugins="dropify"
                                            data-height="150"
                                            data-default-file="{{ !empty($data->image) ? asset('uploads/backend/blog/' . $data->image) : url('uploads/img/no_image.jpg') }}" />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Blog Title</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary form-group">
                                        <input type="text" name="title" class="form-control"
                                            value="{{ @$data->title }}" />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Blog Category</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary form-group">
                                        <select class="form-select form-control mb-3" name="blog_category_id"
                                        aria-label="Default select example">
                                        <option disabled selected>Select Category</option>
                                        @foreach ($categories as $item)
                                            <option value="{{ $item->id }}"
                                                {{ @$category_id == $item->id ? 'selected' : '' }}>
                                                {{ $item->blog_category_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Short Description</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary form-group">
                                        <textarea class="form-control" name="short_description" id="inputProductDescription" rows="3">{{ @$data->short_description }}</textarea>

                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Long Description</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary form-group">
                                        <textarea class="form-control" name="long_description" id="inputProductDescription" rows="3">{{ @$data->long_description }}</textarea>

                                    </div>
                                </div>
                                <div class="text-end">
                                    <input type="submit" class="btn btn-primary px-4" value="{{ !empty($data) ? 'Update' : 'Add' }}" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('.dropify').dropify();
    </script>
    <script>
        $(document).ready(function() {
            $('.dropify-clear').on('click', function() {
                $('#remove_img').val(1);
            })
        })
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#myForm').validate({
                rules: {
                    title: {
                        required: true,
                    },
                    blog_category_id: {
                        required: true,
                    },
                    short_description: {
                        required: true,
                    },
                    long_description: {
                        required: true,
                    },
                   
                 
                },
                messages: {
                    name: {
                        required: 'This field is required',
                    },
                  

                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group')  .append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
            });
        });
    </script>
@endsection
