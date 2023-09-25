<div class="modal fade custom-modal" id="quickViewModal" tabindex="-1" aria-labelledby="quickViewModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="btn-close" id="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12 mb-md-0 mb-sm-5">
                        <div class="detail-gallery">
                            <span class="zoom-icon"><i class="fi-rs-search"></i></span>
                            <!-- MAIN SLIDES -->
                            <div class="product-image-slider" id="product-image-slider">
                                {{-- <figure class="border-radius-10">
                                        <img id="image" src="{{ asset('frontend/assets/imgs/shop/product-16-2.jpg') }}"
                                            alt="product image" />
                                    </figure> --}}
                                {{-- <figure class="border-radius-10">
                                        <img src="{{ asset('frontend/assets/imgs/shop/product-16-1.jpg') }}"
                                            alt="product image" />
                                    </figure>
                                    <figure class="border-radius-10">
                                        <img src="{{ asset('frontend/assets/imgs/shop/product-16-3.jpg') }}"
                                            alt="product image" />
                                    </figure>
                                    <figure class="border-radius-10">
                                        <img src="{{ asset('frontend/assets/imgs/shop/product-16-4.jpg') }}"
                                            alt="product image" />
                                    </figure>
                                    <figure class="border-radius-10">
                                        <img src="{{ asset('frontend/assets/imgs/shop/product-16-5.jpg') }}"
                                            alt="product image" />
                                    </figure>
                                    <figure class="border-radius-10">
                                        <img src="{{ asset('frontend/assets/imgs/shop/product-16-6.jpg') }}"
                                            alt="product image" />
                                    </figure>
                                    <figure class="border-radius-10">
                                        <img src="{{ asset('frontend/assets/imgs/shop/product-16-7.jpg') }}"
                                            alt="product image" />
                                    </figure> --}}
                            </div>
                            <!-- THUMBNAILS -->
                            {{-- <div class="slider-nav-thumbnails">
                                <div><img src="{{ asset('frontend/assets/imgs/shop/thumbnail-3.jpg') }}"
                                        alt="product image" /></div>
                                <div><img src="{{ asset('frontend/assets/imgs/shop/thumbnail-4.jpg') }}"
                                        alt="product image" /></div>
                                <div><img src="{{ asset('frontend/assets/imgs/shop/thumbnail-5.jpg') }}"
                                        alt="product image" /></div>
                                <div><img src="{{ asset('frontend/assets/imgs/shop/thumbnail-6.jpg') }}"
                                        alt="product image" /></div>
                                <div><img src="{{ asset('frontend/assets/imgs/shop/thumbnail-7.jpg') }}"
                                        alt="product image" /></div>
                                <div><img src="{{ asset('frontend/assets/imgs/shop/thumbnail-8.jpg') }}"
                                        alt="product image" /></div>
                                <div><img src="{{ asset('frontend/assets/imgs/shop/thumbnail-9.jpg') }}"
                                        alt="product image" /></div>
                            </div> --}}
                        </div>
                        <!-- End Gallery -->
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="detail-info pr-30 pl-30">
                            <div id="stock_status">
                                {{-- <span class="stock-status in-stock"> Sale Off </span> --}}
                            </div>
                            <h3 class="title-detail"><a href="shop-product-right.html" id="p_name"
                                    class="text-heading">Seeds of
                                    Change Organic Quinoa, Brown</a></h3>
                            <div class="product-detail-rating">
                                <div class="product-rate-cover text-end">
                                    <div class="product-rate d-inline-block">
                                        <div class="product-rating" style="width: 90%"></div>
                                    </div>
                                    <span class="font-small ml-5 text-muted"> (32 reviews)</span>
                                </div>
                            </div>
                            <div class="clearfix product-price-cover">
                                <div class="product-price primary-color float-left">
                                    <span class="current-price text-brand">$38</span>
                                    <span>
                                        <span id="discount" class="save-price font-md color3 ml-15">26% Off</span>
                                        <span class="old-price font-md ml-15">$52</span>
                                    </span>
                                </div>
                            </div>
                            <div id="size_field" class="attr-detail attr-size mb-30">
                                <strong class="mr-15">Size</strong>
                                <select class="form-control" name="" id="size">
                                    <option disabled selected>Choose Size</option>

                                </select>
                            </div>

                            <div id="color_field" class="attr-detail attr-size mb-30">
                                <strong class="mr-10">Color</strong>
                                <select class="form-control" name="" id="color">
                                    <option disabled selected>Choose Color</option>

                                </select>
                            </div>
                            <div class="detail-extralink mb-30">
                                <div class="detail-qty border radius">
                                    <a href="#" class="qty-down"><i class="fi-rs-angle-small-down"></i></a>
                                    <input type="text" name="quantity" id="qty" class="qty-val" value="1" min="1">
                                    <a href="#" class="qty-up"><i class="fi-rs-angle-small-up"></i></a>
                                </div>
                                <div class="product-extra-link2">
                                    <input type="hidden"  id="product_id">
                                    <button type="submit" onclick="addToCart()" class="button button-add-to-cart"><i
                                            class="fi-rs-shopping-cart"></i>Add to cart</button>
                                </div>
                            </div>
                            <div class="font-xs">
                                <ul class="mr-50 float-start">
                                    <li class="mb-5">Type: <span id="category" class="text-brand"></span></li>
                                    <li class="mb-5">Vendor:<span id="vendor" class="text-brand"></span>
                                        <input type="hidden" id="vendor_id" name="">
                                    </li>
                                    <li>Brand: <span id="brand" class="text-brand"></span></li>
                                </ul>
                                <ul class="float-start">
                                    <li class="mb-5">Product Code:<span id="product_code" class="text-brand"></span>
                                    </li>

                                    <li class="mb-5" id="tag">
                                        <a href="#" class="badge" style="background-color: #3BB77E"
                                            rel="tag"></a>
                                    </li>
                                    <li>Stock:<span id="stock" class="in-stock text-brand ml-5"> Items
                                            In Stock</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- Detail Info -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
