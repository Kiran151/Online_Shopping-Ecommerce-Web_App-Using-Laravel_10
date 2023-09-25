@extends('admin.admin_dashboard')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">
    <div class="page-content">
        <div class="container">
            <div class="page-title-box">
                <h5 class="page-title">{{ !empty($data) ? 'Edit' : 'Add' }} District</h5>
            </div>
            <div class="main-body">
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('save.district', @$data->id) }}" method="post"
                                enctype="multipart/form-data" id="myForm">
                                @csrf

                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">District Name</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary form-group">
                                        <input type="text" name="district_name" class="form-control"
                                            value="{{ @$data->district_name }}" />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Division Name</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary form-group">
                                        <select class="form-select form-control mb-3" name="division"
                                            aria-label="Default select example">
                                            <option disabled selected>Select Division</option>
                                            @foreach ($divisions as $item)
                                                <option {{ @$data->division_id == $item->id ? 'selected' : '' }}
                                                    value="{{ $item->id }}">
                                                    {{ $item->division_name }}
                                                </option>
                                            @endforeach
                                        </select>
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

    <script type="text/javascript">
        $(document).ready(function() {
            $('#myForm').validate({
                rules: {
                    division_name: {
                        required: true,
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
