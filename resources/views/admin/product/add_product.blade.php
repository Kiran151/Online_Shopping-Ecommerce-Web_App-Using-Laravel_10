@extends('admin.admin_dashboard')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">
    <div class="page-content">
        <div class="container">
            <div class="page-title-box">
                <h5 class="page-title">{{ !empty($data) ? 'Edit' : 'Add' }} Product</h5>

            </div>
            <div class="main-body">
                <div class="row">
                    <div class="card">
                        <div class="card-body p-4">
                            <div class="form-body mt-4">
                                <form action="{{ route('save.product', @$data->id) }}" method="post" id="myForm"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <div class="border border-3 p-4 rounded">
                                                <div class="mb-3 form-group">
                                                    <label for="inputProductTitle" class="form-label fw-bold">Product
                                                        Title</label>
                                                    <input type="text" name="product_name"
                                                        value="{{ @$data->product_name }}" class="form-control"
                                                        id="inputProductTitle" placeholder="Enter product title">
                                                </div>
                                                <div class="mb-3 form-group">
                                                    <label for="inputProductTags" class="form-label fw-bold">Product
                                                        Tags</label>
                                                    <input type="text" name="product_tags"
                                                        value="{{ @$data->product_tags }}" data-role="tagsinput"
                                                        class="form-control" id="inputProductTitle">
                                                    {{-- <select name="product_tag" multiple data-role="tagsinput">
                                                    <option value="Beijing">Beijing</option>
                                                    <option value="Cairo">Cairo</option>
                                                </select> --}}
                                                </div>
                                                <div class="mb-3 form-group">
                                                    <label for="inputProductTags" class="form-label fw-bold">Product
                                                        Size</label>
                                                    <input type="text" name="product_size"
                                                        value="{{ @$data->product_size }}" data-role="tagsinput"
                                                        class="form-control" id="inputProductTitle">
                                                </div>
                                                <div class="mb-3 form-group">
                                                    <label for="inputProductTags" class="form-label fw-bold">Product
                                                        Color</label>
                                                    <input type="text" name="product_color"
                                                        value="{{ @$data->product_color }}" data-role="tagsinput"
                                                        class="form-control" id="inputProductTitle">
                                                </div>
                                                <div class="mb-3 form-group">
                                                    <label for="inputProductDescription" class="form-label fw-bold">Short
                                                        Description</label>
                                                    <textarea class="form-control" name="short_description" id="inputProductDescription" rows="3">{{ @$data->short_description }}</textarea>
                                                </div>
                                                <div class="mb-3 form-group">
                                                    <label for="inputProductDescription" class="form-label fw-bold">Long
                                                        Description</label>
                                                    <textarea class="form-control" name="long_description" id="mytextarea" rows="3">{!! @$data->long_description !!}</textarea>
                                                </div>

                                                @if (@$data == null)
                                                    <div class="mb-3 form-group">
                                                        <label for="inputProductDescription"
                                                            class="form-label fw-bold">Product
                                                            Images</label>

                                                        <input id="image-uploadify" type="file" name="multi_img[]"
                                                            multiple>

                                                    </div>
                                                @else
                                                    <div class="mb-3 form-group">
                                                        <label for="inputProductDescription" class="form-label fw-bold">To
                                                            Change Product Multiple Images</label>
                                                        <a href="{{ route('edit.multi.images', @$data->id) }}"
                                                            class="btn btn-primary">Click here</a>

                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="border border-3 p-4 rounded">
                                                <div class="row g-3">
                                                    <div class="col-md-12 form-group">
                                                        <label for="inputPrice" class="form-label fw-bold">Thumbnail
                                                            Image</label>
                                                        <input type="file" name="image" class="dropify"
                                                            data-plugins="dropify" data-height="150"
                                                            data-default-file="{{ !empty($data->thumbnail_image) ? asset('uploads/backend/product/thumbnail/' . $data->thumbnail_image) : url('uploads/img/no_image.jpg') }}" />
                                                    </div>
                                                    <div class="col-md-12 form-group">
                                                        <label for="inputPrice" class="form-label fw-bold">Product
                                                            Price</label>
                                                        <input type="number" value="{{ @$data->selling_price }}"
                                                            name="selling_price" class="form-control" id="inputPrice"
                                                            placeholder="00.00">
                                                    </div>
                                                    <div class="col-md-12 form-group">
                                                        <label for="inputPrice" class="form-label fw-bold">Discount
                                                            Price</label>
                                                        <input type="number" value="{{ @$data->discount_price }}"
                                                            name="discount_price" class="form-control" id="inputPrice"
                                                            placeholder="00.00">
                                                    </div>
                                                    <div class="col-md-12 form-group">
                                                        <label for="inputCompareatprice"
                                                            class="form-label fw-bold">Product
                                                            Code</label>
                                                        <input type="text" value="{{ @$data->product_code }}"
                                                            class="form-control" name="product_code"
                                                            id="inputCompareatprice" placeholder="00.00">
                                                    </div>
                                                    <div class="col-md-12 form-group">
                                                        <label for="inputCompareatprice"
                                                            class="form-label fw-bold">Product
                                                            Quantity</label>
                                                        <input type="number" value="{{ @$data->product_qty }}"
                                                            class="form-control" name="product_qty"
                                                            id="inputCompareatprice" placeholder="0">
                                                    </div>
                                                    <div class="col-12 form-group">
                                                        <label for="inputProductType" class="form-label fw-bold">Product
                                                            Brand</label>
                                                        <select class="form-select" name="brand_id"
                                                            id="inputProductType">
                                                            <option selected disabled>Select Brand</option>
                                                            @foreach ($brands as $item)
                                                                <option value="{{ $item->id }}"
                                                                    {{ @$data->brand_id == $item->id ? 'selected' : '' }}>
                                                                    {{ $item->brand_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-12 form-group">
                                                        <label for="inputVendor" class="form-label fw-bold">Product
                                                            Category</label>
                                                        <select class="form-select" name="category_id" id="category">
                                                            <option selected disabled>Select Category</option>
                                                            @foreach ($categories as $item)
                                                                <option value="{{ $item->id }}"
                                                                    {{ @$data->category_id == $item->id ? 'selected' : '' }}>
                                                                    {{ $item->category_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @php
                                                        if (@$data) {
                                                            $subcategory = App\models\SubCategory::findOrFail(@$data->subcategory_id);
                                                        }
                                                    @endphp
                                                    <div class="col-12 form-group">
                                                        <label for="inputCollection" class="form-label fw-bold">Product
                                                            SubCategory</label>
                                                        <select class="form-select" name="subcategory_id"
                                                            id="subcategory">
                                                            @if (@$data->subcategory_id)
                                                                <option value="{{ @$data->subcategory_id }}" selected>
                                                                    {{ $subcategory->subcategory_name }}</option>
                                                            @else
                                                                <option selected disabled>Select Subcategory</option>
                                                            @endif
                                                        </select>
                                                    </div>
                                                    <div class="col-12 form-group">
                                                        <label for="inputCollection"
                                                            class="form-label fw-bold">Vendor</label>
                                                        <select class="form-select" name="vendor_id"
                                                            id="inputCollection">
                                                            <option selected disabled>Select Vendor</option>
                                                            @foreach ($vendors as $item)
                                                                <option value="{{ $item->id }}"
                                                                    {{ @$data->vendor_id == $item->id ? 'selected' : '' }}>
                                                                    {{ $item->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="hot_deals" value="1" id="flexCheckDefault"
                                                                {{ @$data->hot_deals == 1 ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="flexCheckDefault">Hot
                                                                Deals</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="featured" value="1" id="flexCheckDefault"
                                                                {{ @$data->featured == 1 ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="flexCheckDefault">Featured</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="special_offer" value="1" id="flexCheckDefault"
                                                                {{ @$data->special_offer == 1 ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="flexCheckDefault">Special
                                                                Offer</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="special_deals" value="1" id="flexCheckDefault"
                                                                {{ @$data->special_deals == 1 ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="flexCheckDefault">Special
                                                                Deals</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="d-grid">
                                                            <button type="submit" class="btn btn-primary">Save
                                                                Product</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!--end row-->
                            </div>
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
    <script>
        $('#category').change(function() {
            category_id = $('#category').val();
            $.ajax({
                'type': 'GET',
                'url': '{{ route('getSubcategoryAjax') }}',
                'data': {
                    'category_id': category_id
                },
                success: function(data) {
                    $('#subcategory').empty();
                    data.forEach(item => {
                        $('#subcategory').append(
                            `<option value="${item.id}">${item.subcategory_name}</option>`)
                    });
                }
            })
        })
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#myForm').validate({
                rules: {
                    product_name: {
                        required: true,
                    },
                    product_tag: {
                        required: true,
                    },
                    short_description: {
                        required: true,
                    },
                    long_description: {
                        required: true,
                    },
                    selling_price: {
                        required: true,
                    },
                    category_id: {
                        required: true,
                    },
                    subcategory_id: {
                        required: true,
                    },
                    vendor_id: {
                        required: true,
                    },
                    brand_id: {
                        required: true,
                       },
                    product_qty: {
                        required: true,
                    },


                },
                messages: {
                    product_name: {
                        required: 'This field is required',
                    },
                    image: {
                        required: 'Thumbnail image is required',
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
    {{-- <script>
        $(document).ready(function() {
            $('#image-uploadify').imageuploadify();
    
            // Listen for the imageuploadify `onFileSelect` event
            $('#image-uploadify').on('fileselect', function(event, data) {
                // Extract the selected image names and set them in the hidden input field
                var selectedImages = data.files.map(function(file) {
                    return file.name;
                });
                $('#selected-images').val(JSON.stringify(selectedImages));
            });
        });
    </script> --}}
@endsection
