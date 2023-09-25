@extends('admin.admin_dashboard')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">
    <div class="page-content">
        <div class="container">
            {{-- <div class="page-title-box">
                <h5 class="page-title">{{ !empty($data) ? 'Edit' : 'Add' }} SubCategory</h5>
            </div> --}}
            <div class="main-body">
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('save.seo', @$data->id) }}" method="post"
                                enctype="multipart/form-data" id="myForm">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Meta Title</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary form-group">
                                        <input type="text" name="meta_title" class="form-control"
                                            value="{{ @$data->meta_title }}" />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Meta Author</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary form-group">
                                        <input type="text" name="meta_author" class="form-control"
                                            value="{{ @$data->meta_author }}" />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Meta Keyword</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary form-group">
                                        <input type="text" name="meta_keyword" class="form-control"
                                            value="{{ @$data->meta_keyword }}" />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Meta Description</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary form-group">
                                        <textarea  cols="30" rows="5" name="meta_description" class="form-control"
                                            >{{ @$data->meta_description}}</textarea>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <input type="submit" class="btn btn-primary px-4"
                                        value="{{ !empty($data) ? 'Update' : 'Add' }}" />
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
                    meta_author: {
                        required: true,
                    },
                    meta_keyword: {
                        required: true,
                    },
                    meta_title: {
                        required: true,
                    },
                    meta_description: {
                        required: true,
                    },


                },
                messages: {
                    meta_author: {
                        required: 'This field is required',
                    },


                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
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
