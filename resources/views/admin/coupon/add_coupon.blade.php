@extends('admin.admin_dashboard')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">
    <div class="page-content">
        <div class="container">
            <div class="page-title-box">
                <h5 class="page-title">{{ !empty($data) ? 'Edit' : 'Add' }} Coupon</h5>
            </div>
            <div class="main-body">
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('save.coupon', @$data->id) }}" method="post"
                                enctype="multipart/form-data" id="myForm">
                                @csrf
                               
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Coupon Name</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary form-group">
                                        <input type="text" name="coupon_name" class="form-control"
                                            value="{{ @$data->coupon_name }}" />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Coupon Discount(%)</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary form-group">
                                        <input type="number" min="1" name="coupon_discount" class="form-control"
                                            value="{{ @$data->coupon_discount }}" />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Coupon Validity</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary form-group">
                                        <input type="date" name="coupon_validity" class="form-control"
                                            value="{{@$data->coupon_validity !==null? date('Y-m-d',strtotime( @$data->coupon_validity)):date('Y-m-d') }}" min="{{date('Y-m-d')}}" />
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
                    coupon_name: {
                        required: true,
                    },
                    coupon_discount: {
                        required: true,
                    },
                    coupon_validity: {
                        required: true,
                    },


                },
                messages: {
                    coupon_name: {
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
