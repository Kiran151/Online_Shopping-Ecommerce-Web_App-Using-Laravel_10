@extends('frontend.master')
@section('master')
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="index.html" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                    <span></span> Shop <span></span> Compare
                </div>
            </div>
        </div>
        <div class="container mb-80 mt-50">
            <div class="row">
                <div class="col-xl-10 col-lg-12 m-auto">
                    <h1 class="heading-2 mb-10">Products Compare</h1>
                    <h6 class="text-body mb-40">There are <span class="text-brand">3</span> products to compare</h6>
                    <div class="table-responsive">
                        <table class="table text-center table-compare" id="compare_table">
                            <tbody id="compare_tbody">
                                <tr class="pr_image">
                                    <td class="text-muted font-sm fw-600 font-heading mw-200">Preview</td>
                                    @foreach ($products as $item)
                                        <td class="row_img image product-thumbnail pt-40"><img
                                                src="{{ asset('uploads/backend/product/thumbnail/' . $item->thumbnail_image) }}" />
                                        </td>
                                    @endforeach

                                </tr>
                                <tr class="pr_title">
                                    <td class="text-muted font-sm fw-600 font-heading">Name</td>
                                    @foreach ($products as $item)
                                    <td class="product_name">
                                        <h6><a href="shop-product-full.html" class="text-heading">{{$item->product_name}}</a></h6>
                                    </td>
                                    @endforeach


                                </tr>
                                <tr class="pr_price">
                                    <td class="text-muted font-sm fw-600 font-heading">Price</td>
                                    @foreach ($products as $item)
                                    <td class="product_price">
                                        <h4 class="price text-brand">${{$item->selling_price - $item->discount_price}}</h4>
                                    </td>
                                    @endforeach

                                </tr>
                                <tr class="pr_rating">
                                    <td class="text-muted font-sm fw-600 font-heading">Rating</td>
                                    @foreach ($products as $item)
                                    <td>
                                        <div class="rating_wrap">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: 90%"></div>
                                            </div>
                                            <span class="rating_num">(121)</span>
                                        </div>
                                    </td>
                                    @endforeach

                                </tr>
                                <tr class="description">
                                    <td class="text-muted font-sm fw-600 font-heading">Description</td>
                                    @foreach ($products as $item)
                                    <td class="row_text font-xs">
                                        <p class="font-sm text-muted">{{$item->short_description}}</p>
                                    </td>
                                    @endforeach
                                </tr>
                                <tr class="pr_stock">
                                    <td class="text-muted font-sm fw-600 font-heading">Stock status</td>
                                    @foreach ($products as $item)
                                    <td class="row_stock"><span class="stock-status in-stock mb-0">In Stock</span></td>
                                    @endforeach

                                </tr>
                                <tr class="pr_weight">
                                    <td class="text-muted font-sm fw-600 font-heading">Weight</td>
                                    @foreach ($products as $item)
                                    <td class="row_weight">320 gram</td>
                                    @endforeach

                                </tr>
                                <tr class="pr_dimensions">
                                    <td class="text-muted font-sm fw-600 font-heading">Dimensions</td>
                                    @foreach ($products as $item)
                                    <td class="row_dimensions">N/A</td>
                                    @endforeach
                                </tr>
                                <tr class="pr_add_to_cart">
                                    <td class="text-muted font-sm fw-600 font-heading">Buy now</td>
                                    @foreach ($products as $item)
                                    <td class="row_btn">
                                        <button class="btn btn-sm" onclick="addToCart1({{ $item->id}})"><i class="fi-rs-shopping-bag mr-5"></i>Add to
                                            cart</button>
                                    </td>
                                    @endforeach
                                </tr>
                                <tr class="pr_remove text-muted">
                                    <td class="text-muted font-md fw-600"></td>
                                    @foreach ($products as $item)
                                    <td class="row_remove">
                                        <a href="{{route('removeCompare',$item->id)}}" class="text-muted"><i
                                                class="fi-rs-trash mr-5"></i><span>Remove</span> </a>
                                    </td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
