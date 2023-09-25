@extends('frontend.master')
@section('master')
    @include('frontend.home.home_slider')
    <!--End hero slider-->
    @include('frontend.home.featured_categories')

    <!--End category slider-->
    @include('frontend.home.banners')
    <!--End banners-->
    @include('frontend.home.new_products')

    <!--Products Tabs-->

    @include('frontend.home.featured_products')



    <!--End Best Sales-->



    <!--Category -->

    @php
        $categories = App\Models\Category::all();
    @endphp
    @foreach ($categories as $item)
        <section class="product-tabs section-padding position-relative">
            <div class="container">
                <div class="section-title style-2 wow animate__animated animate__fadeIn">
                    <h3>{{ $item->category_name }} Category </h3>

                </div>
                <!--End nav-tabs-->
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="tab-one" role="tabpanel" aria-labelledby="tab-one">
                        <div class="row product-grid-4">
                            @php
                                $products = App\Models\Product::where('category_id', $item->id)
                                    ->limit(5)
                                    ->get();
                            @endphp
                            @forelse ($products as $item)
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap mb-30 wow animate__animated animate__fadeIn"
                                        data-wow-delay=".1s">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href="{{ url("product/details/$item->id/$item->product_slug") }}">
                                                    <img class="default-img"
                                                        src="{{ asset('uploads/backend/product/thumbnail/' . $item->thumbnail_image) }}"
                                                        alt="" />
                                                    <img class="hover-img"
                                                        src="{{ asset('uploads/backend/product/thumbnail/' . $item->thumbnail_image) }}"
                                                        alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label="Add To Wishlist" id="wish_button" class="action-btn"
                                                    onclick="addToWishlist({{ $item->id }})">
                                                    @php
                                                        if (Auth::check()) {
                                                            $user_id = Auth::user()->id;
                                                            $wish = App\Models\WishList::where([['product_id', $item->id], ['user_id', $user_id]])->first();
                                                        } else {
                                                            $wish = null;
                                                        }
                                                    @endphp
                                                    @if ($wish !== null)
                                                        <i class="fi-rs-heart text-danger"></i>
                                                    @else
                                                        <i class="fi-rs-heart"></i>
                                                    @endif
                                                </a>
                                                <a aria-label="Compare" class="action-btn"
                                                    onclick="addToCompare({{ $item->id }})"><i
                                                        class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn"
                                                    onclick="modalClick({{ $item->id }})" data-bs-toggle="modal"
                                                    data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="hot">Hot</span>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href="shop-grid-right.html">{{ $item['category']['category_name'] }}</a>
                                            </div>
                                            <h2><a
                                                    href="{{ url("product/details/$item->id/$item->product_slug") }}">{{ $item->product_name }}</a>
                                            </h2>
                                            <div class="product-rate-cover">
                                                @php
                                            
                                                //avg rating
                                                $avg_rating = App\Models\Review::where('product_id', $item->id)->avg('rating');
                                                $avg_rating_pct = ($avg_rating / 5) * 100;
                                            @endphp
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: {{$avg_rating_pct}}%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> ({{$avg_rating}})</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a
                                                        href="vendor-details-1.html">{{ $item['vendor']['name'] }}</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>${{ $item->selling_price-$item->discount_price }}</span>
                                                    @if ($item->discount_price > 0)
                                                    <span
                                                        class="old-price">${{ $item->selling_price + $item->discount_price }}</span>
                                                @endif
                                                </div>
                                                <div class="add-cart">
                                                    <a class="add" href="shop-cart.html"><i
                                                            class="fi-rs-shopping-cart mr-5"></i>Add</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p>No Products</p>
                            @endforelse
                            <!--end product card-->

                        </div>
                        <!--End product-grid-4-->
                    </div>


                </div>
                <!--End tab-content-->
            </div>


        </section>
    @endforeach
    <!--End TV Category -->





    <!-- Tshirt Category -->

    {{-- <section class="product-tabs section-padding position-relative">
        <div class="container">
            <div class="section-title style-2 wow animate__animated animate__fadeIn">
                <h3>Tshirt Category </h3>

            </div>
            <!--End nav-tabs-->
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="tab-one" role="tabpanel" aria-labelledby="tab-one">
                    <div class="row product-grid-4">



                        <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                            <div class="product-cart-wrap mb-30 wow animate__animated animate__fadeIn"
                                data-wow-delay=".1s">
                                <div class="product-img-action-wrap">
                                    <div class="product-img product-img-zoom">
                                        <a href="{{ url("product/details/$item->id/$item->product_slug") }}">
                                            <img class="default-img"
                                                src="{{ asset('frontend/') }}assets/imgs/shop/product-1-1.jpg"
                                                alt="" />
                                            <img class="hover-img"
                                                src="{{ asset('frontend/') }}assets/imgs/shop/product-1-2.jpg"
                                                alt="" />
                                        </a>
                                    </div>
                                    <div class="product-action-1">
                                        <a aria-label="Add To Wishlist" class="action-btn" href="shop-wishlist.html"><i
                                                class="fi-rs-heart"></i></a>
                                        <a aria-label="Compare" class="action-btn" href="shop-compare.html"><i
                                                class="fi-rs-shuffle"></i></a>
                                        <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal"
                                            data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                    </div>
                                    <div class="product-badges product-badges-position product-badges-mrg">
                                        <span class="hot">Hot</span>
                                    </div>
                                </div>
                                <div class="product-content-wrap">
                                    <div class="product-category">
                                        <a href="shop-grid-right.html">Snack</a>
                                    </div>
                                    <h2><a href="{{ url("product/details/$item->id/$item->product_slug") }}">Seeds of Change Organic Quinoa, Brown, </a></h2>
                                    <div class="product-rate-cover">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 90%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> (4.0)</span>
                                    </div>
                                    <div>
                                        <span class="font-small text-muted">By <a
                                                href="vendor-details-1.html">NestFood</a></span>
                                    </div>
                                    <div class="product-card-bottom">
                                        <div class="product-price">
                                            <span>$28.85</span>
                                            <span class="old-price">$32.8</span>
                                        </div>
                                        <div class="add-cart">
                                            <a class="add" href="shop-cart.html"><i
                                                    class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end product card-->



                        <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                            <div class="product-cart-wrap mb-30 wow animate__animated animate__fadeIn"
                                data-wow-delay=".2s">
                                <div class="product-img-action-wrap">
                                    <div class="product-img product-img-zoom">
                                        <a href="{{ url("product/details/$item->id/$item->product_slug") }}">
                                            <img class="default-img"
                                                src="{{ asset('frontend/') }}assets/imgs/shop/product-2-1.jpg"
                                                alt="" />
                                            <img class="hover-img"
                                                src="{{ asset('frontend/') }}assets/imgs/shop/product-2-2.jpg"
                                                alt="" />
                                        </a>
                                    </div>
                                    <div class="product-action-1">
                                        <a aria-label="Add To Wishlist" class="action-btn" href="shop-wishlist.html"><i
                                                class="fi-rs-heart"></i></a>
                                        <a aria-label="Compare" class="action-btn" href="shop-compare.html"><i
                                                class="fi-rs-shuffle"></i></a>
                                        <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal"
                                            data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                    </div>
                                    <div class="product-badges product-badges-position product-badges-mrg">
                                        <span class="sale">Sale</span>
                                    </div>
                                </div>
                                <div class="product-content-wrap">
                                    <div class="product-category">
                                        <a href="shop-grid-right.html">Hodo Foods</a>
                                    </div>
                                    <h2><a href="{{ url("product/details/$item->id/$item->product_slug") }}">All Natural Italian-Style Chicken Meatballs</a>
                                    </h2>
                                    <div class="product-rate-cover">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 80%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> (3.5)</span>
                                    </div>
                                    <div>
                                        <span class="font-small text-muted">By <a
                                                href="vendor-details-1.html">Stouffer</a></span>
                                    </div>
                                    <div class="product-card-bottom">
                                        <div class="product-price">
                                            <span>$52.85</span>
                                            <span class="old-price">$55.8</span>
                                        </div>
                                        <div class="add-cart">
                                            <a class="add" href="shop-cart.html"><i
                                                    class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end product card-->
                        <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                            <div class="product-cart-wrap mb-30 wow animate__animated animate__fadeIn"
                                data-wow-delay=".3s">
                                <div class="product-img-action-wrap">
                                    <div class="product-img product-img-zoom">
                                        <a href="{{ url("product/details/$item->id/$item->product_slug") }}">
                                            <img class="default-img"
                                                src="{{ asset('frontend/') }}assets/imgs/shop/product-3-1.jpg"
                                                alt="" />
                                            <img class="hover-img"
                                                src="{{ asset('frontend/') }}assets/imgs/shop/product-3-2.jpg"
                                                alt="" />
                                        </a>
                                    </div>
                                    <div class="product-action-1">
                                        <a aria-label="Add To Wishlist" class="action-btn" href="shop-wishlist.html"><i
                                                class="fi-rs-heart"></i></a>
                                        <a aria-label="Compare" class="action-btn" href="shop-compare.html"><i
                                                class="fi-rs-shuffle"></i></a>
                                        <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal"
                                            data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                    </div>
                                    <div class="product-badges product-badges-position product-badges-mrg">
                                        <span class="new">New</span>
                                    </div>
                                </div>
                                <div class="product-content-wrap">
                                    <div class="product-category">
                                        <a href="shop-grid-right.html">Snack</a>
                                    </div>
                                    <h2><a href="{{ url("product/details/$item->id/$item->product_slug") }}">Angie’s Boomchickapop Sweet & Salty Kettle
                                            Corn</a></h2>
                                    <div class="product-rate-cover">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 85%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> (4.0)</span>
                                    </div>
                                    <div>
                                        <span class="font-small text-muted">By <a
                                                href="vendor-details-1.html">StarKist</a></span>
                                    </div>
                                    <div class="product-card-bottom">
                                        <div class="product-price">
                                            <span>$48.85</span>
                                            <span class="old-price">$52.8</span>
                                        </div>
                                        <div class="add-cart">
                                            <a class="add" href="shop-cart.html"><i
                                                    class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end product card-->
                        <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                            <div class="product-cart-wrap mb-30 wow animate__animated animate__fadeIn"
                                data-wow-delay=".4s">
                                <div class="product-img-action-wrap">
                                    <div class="product-img product-img-zoom">
                                        <a href="{{ url("product/details/$item->id/$item->product_slug") }}">
                                            <img class="default-img"
                                                src="{{ asset('frontend/') }}assets/imgs/shop/product-4-1.jpg"
                                                alt="" />
                                            <img class="hover-img"
                                                src="{{ asset('frontend/') }}assets/imgs/shop/product-4-2.jpg"
                                                alt="" />
                                        </a>
                                    </div>
                                    <div class="product-action-1">
                                        <a aria-label="Add To Wishlist" class="action-btn" href="shop-wishlist.html"><i
                                                class="fi-rs-heart"></i></a>
                                        <a aria-label="Compare" class="action-btn" href="shop-compare.html"><i
                                                class="fi-rs-shuffle"></i></a>
                                        <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal"
                                            data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                    </div>
                                </div>
                                <div class="product-content-wrap">
                                    <div class="product-category">
                                        <a href="shop-grid-right.html">Vegetables</a>
                                    </div>
                                    <h2><a href="{{ url("product/details/$item->id/$item->product_slug") }}">Foster Farms Takeout Crispy Classic Buffalo </a>
                                    </h2>
                                    <div class="product-rate-cover">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 90%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> (4.0)</span>
                                    </div>
                                    <div>
                                        <span class="font-small text-muted">By <a
                                                href="vendor-details-1.html">NestFood</a></span>
                                    </div>
                                    <div class="product-card-bottom">
                                        <div class="product-price">
                                            <span>$17.85</span>
                                            <span class="old-price">$19.8</span>
                                        </div>
                                        <div class="add-cart">
                                            <a class="add" href="shop-cart.html"><i
                                                    class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end product card-->


                        <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                            <div class="product-cart-wrap mb-30 wow animate__animated animate__fadeIn"
                                data-wow-delay=".5s">
                                <div class="product-img-action-wrap">
                                    <div class="product-img product-img-zoom">
                                        <a href="{{ url("product/details/$item->id/$item->product_slug") }}">
                                            <img class="default-img"
                                                src="{{ asset('frontend/') }}assets/imgs/shop/product-5-1.jpg"
                                                alt="" />
                                            <img class="hover-img"
                                                src="{{ asset('frontend/') }}assets/imgs/shop/product-5-2.jpg"
                                                alt="" />
                                        </a>
                                    </div>
                                    <div class="product-action-1">
                                        <a aria-label="Add To Wishlist" class="action-btn" href="shop-wishlist.html"><i
                                                class="fi-rs-heart"></i></a>
                                        <a aria-label="Compare" class="action-btn" href="shop-compare.html"><i
                                                class="fi-rs-shuffle"></i></a>
                                        <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal"
                                            data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                    </div>
                                    <div class="product-badges product-badges-position product-badges-mrg">
                                        <span class="best">-14%</span>
                                    </div>
                                </div>
                                <div class="product-content-wrap">
                                    <div class="product-category">
                                        <a href="shop-grid-right.html">Pet Foods</a>
                                    </div>
                                    <h2><a href="{{ url("product/details/$item->id/$item->product_slug") }}">Blue Diamond Almonds Lightly Salted
                                            Vegetables</a></h2>
                                    <div class="product-rate-cover">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 90%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> (4.0)</span>
                                    </div>
                                    <div>
                                        <span class="font-small text-muted">By <a
                                                href="vendor-details-1.html">NestFood</a></span>
                                    </div>
                                    <div class="product-card-bottom">
                                        <div class="product-price">
                                            <span>$23.85</span>
                                            <span class="old-price">$25.8</span>
                                        </div>
                                        <div class="add-cart">
                                            <a class="add" href="shop-cart.html"><i
                                                    class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end product card-->

                    </div>
                    <!--End product-grid-4-->
                </div>


            </div>
            <!--End tab-content-->
        </div>


    </section> --}}
    <!--End Tshirt Category -->








    <!-- Computer Category -->

    {{-- <section class="product-tabs section-padding position-relative">
        <div class="container">
            <div class="section-title style-2 wow animate__animated animate__fadeIn">
                <h3>Computer Category </h3>

            </div>
            <!--End nav-tabs-->
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="tab-one" role="tabpanel" aria-labelledby="tab-one">
                    <div class="row product-grid-4">



                        <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                            <div class="product-cart-wrap mb-30 wow animate__animated animate__fadeIn"
                                data-wow-delay=".1s">
                                <div class="product-img-action-wrap">
                                    <div class="product-img product-img-zoom">
                                        <a href="{{ url("product/details/$item->id/$item->product_slug") }}">
                                            <img class="default-img"
                                                src="{{ asset('frontend/') }}assets/imgs/shop/product-1-1.jpg"
                                                alt="" />
                                            <img class="hover-img"
                                                src="{{ asset('frontend/') }}assets/imgs/shop/product-1-2.jpg"
                                                alt="" />
                                        </a>
                                    </div>
                                    <div class="product-action-1">
                                        <a aria-label="Add To Wishlist" class="action-btn" href="shop-wishlist.html"><i
                                                class="fi-rs-heart"></i></a>
                                        <a aria-label="Compare" class="action-btn" href="shop-compare.html"><i
                                                class="fi-rs-shuffle"></i></a>
                                        <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal"
                                            data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                    </div>
                                    <div class="product-badges product-badges-position product-badges-mrg">
                                        <span class="hot">Hot</span>
                                    </div>
                                </div>
                                <div class="product-content-wrap">
                                    <div class="product-category">
                                        <a href="shop-grid-right.html">Snack</a>
                                    </div>
                                    <h2><a href="{{ url("product/details/$item->id/$item->product_slug") }}">Seeds of Change Organic Quinoa, Brown, </a></h2>
                                    <div class="product-rate-cover">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 90%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> (4.0)</span>
                                    </div>
                                    <div>
                                        <span class="font-small text-muted">By <a
                                                href="vendor-details-1.html">NestFood</a></span>
                                    </div>
                                    <div class="product-card-bottom">
                                        <div class="product-price">
                                            <span>$28.85</span>
                                            <span class="old-price">$32.8</span>
                                        </div>
                                        <div class="add-cart">
                                            <a class="add" href="shop-cart.html"><i
                                                    class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end product card-->



                        <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                            <div class="product-cart-wrap mb-30 wow animate__animated animate__fadeIn"
                                data-wow-delay=".2s">
                                <div class="product-img-action-wrap">
                                    <div class="product-img product-img-zoom">
                                        <a href="{{ url("product/details/$item->id/$item->product_slug") }}">
                                            <img class="default-img"
                                                src="{{ asset('frontend/') }}assets/imgs/shop/product-2-1.jpg"
                                                alt="" />
                                            <img class="hover-img"
                                                src="{{ asset('frontend/') }}assets/imgs/shop/product-2-2.jpg"
                                                alt="" />
                                        </a>
                                    </div>
                                    <div class="product-action-1">
                                        <a aria-label="Add To Wishlist" class="action-btn" href="shop-wishlist.html"><i
                                                class="fi-rs-heart"></i></a>
                                        <a aria-label="Compare" class="action-btn" href="shop-compare.html"><i
                                                class="fi-rs-shuffle"></i></a>
                                        <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal"
                                            data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                    </div>
                                    <div class="product-badges product-badges-position product-badges-mrg">
                                        <span class="sale">Sale</span>
                                    </div>
                                </div>
                                <div class="product-content-wrap">
                                    <div class="product-category">
                                        <a href="shop-grid-right.html">Hodo Foods</a>
                                    </div>
                                    <h2><a href="{{ url("product/details/$item->id/$item->product_slug") }}">All Natural Italian-Style Chicken Meatballs</a>
                                    </h2>
                                    <div class="product-rate-cover">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 80%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> (3.5)</span>
                                    </div>
                                    <div>
                                        <span class="font-small text-muted">By <a
                                                href="vendor-details-1.html">Stouffer</a></span>
                                    </div>
                                    <div class="product-card-bottom">
                                        <div class="product-price">
                                            <span>$52.85</span>
                                            <span class="old-price">$55.8</span>
                                        </div>
                                        <div class="add-cart">
                                            <a class="add" href="shop-cart.html"><i
                                                    class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end product card-->
                        <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                            <div class="product-cart-wrap mb-30 wow animate__animated animate__fadeIn"
                                data-wow-delay=".3s">
                                <div class="product-img-action-wrap">
                                    <div class="product-img product-img-zoom">
                                        <a href="{{ url("product/details/$item->id/$item->product_slug") }}">
                                            <img class="default-img"
                                                src="{{ asset('frontend/') }}assets/imgs/shop/product-3-1.jpg"
                                                alt="" />
                                            <img class="hover-img"
                                                src="{{ asset('frontend/') }}assets/imgs/shop/product-3-2.jpg"
                                                alt="" />
                                        </a>
                                    </div>
                                    <div class="product-action-1">
                                        <a aria-label="Add To Wishlist" class="action-btn" href="shop-wishlist.html"><i
                                                class="fi-rs-heart"></i></a>
                                        <a aria-label="Compare" class="action-btn" href="shop-compare.html"><i
                                                class="fi-rs-shuffle"></i></a>
                                        <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal"
                                            data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                    </div>
                                    <div class="product-badges product-badges-position product-badges-mrg">
                                        <span class="new">New</span>
                                    </div>
                                </div>
                                <div class="product-content-wrap">
                                    <div class="product-category">
                                        <a href="shop-grid-right.html">Snack</a>
                                    </div>
                                    <h2><a href="{{ url("product/details/$item->id/$item->product_slug") }}">Angie’s Boomchickapop Sweet & Salty Kettle
                                            Corn</a></h2>
                                    <div class="product-rate-cover">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 85%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> (4.0)</span>
                                    </div>
                                    <div>
                                        <span class="font-small text-muted">By <a
                                                href="vendor-details-1.html">StarKist</a></span>
                                    </div>
                                    <div class="product-card-bottom">
                                        <div class="product-price">
                                            <span>$48.85</span>
                                            <span class="old-price">$52.8</span>
                                        </div>
                                        <div class="add-cart">
                                            <a class="add" href="shop-cart.html"><i
                                                    class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end product card-->
                        <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                            <div class="product-cart-wrap mb-30 wow animate__animated animate__fadeIn"
                                data-wow-delay=".4s">
                                <div class="product-img-action-wrap">
                                    <div class="product-img product-img-zoom">
                                        <a href="{{ url("product/details/$item->id/$item->product_slug") }}">
                                            <img class="default-img"
                                                src="{{ asset('frontend/') }}assets/imgs/shop/product-4-1.jpg"
                                                alt="" />
                                            <img class="hover-img"
                                                src="{{ asset('frontend/') }}assets/imgs/shop/product-4-2.jpg"
                                                alt="" />
                                        </a>
                                    </div>
                                    <div class="product-action-1">
                                        <a aria-label="Add To Wishlist" class="action-btn" href="shop-wishlist.html"><i
                                                class="fi-rs-heart"></i></a>
                                        <a aria-label="Compare" class="action-btn" href="shop-compare.html"><i
                                                class="fi-rs-shuffle"></i></a>
                                        <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal"
                                            data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                    </div>
                                </div>
                                <div class="product-content-wrap">
                                    <div class="product-category">
                                        <a href="shop-grid-right.html">Vegetables</a>
                                    </div>
                                    <h2><a href="{{ url("product/details/$item->id/$item->product_slug") }}">Foster Farms Takeout Crispy Classic Buffalo </a>
                                    </h2>
                                    <div class="product-rate-cover">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 90%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> (4.0)</span>
                                    </div>
                                    <div>
                                        <span class="font-small text-muted">By <a
                                                href="vendor-details-1.html">NestFood</a></span>
                                    </div>
                                    <div class="product-card-bottom">
                                        <div class="product-price">
                                            <span>$17.85</span>
                                            <span class="old-price">$19.8</span>
                                        </div>
                                        <div class="add-cart">
                                            <a class="add" href="shop-cart.html"><i
                                                    class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end product card-->


                        <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                            <div class="product-cart-wrap mb-30 wow animate__animated animate__fadeIn"
                                data-wow-delay=".5s">
                                <div class="product-img-action-wrap">
                                    <div class="product-img product-img-zoom">
                                        <a href="{{ url("product/details/$item->id/$item->product_slug") }}">
                                            <img class="default-img"
                                                src="{{ asset('frontend/') }}assets/imgs/shop/product-5-1.jpg"
                                                alt="" />
                                            <img class="hover-img"
                                                src="{{ asset('frontend/') }}assets/imgs/shop/product-5-2.jpg"
                                                alt="" />
                                        </a>
                                    </div>
                                    <div class="product-action-1">
                                        <a aria-label="Add To Wishlist" class="action-btn" href="shop-wishlist.html"><i
                                                class="fi-rs-heart"></i></a>
                                        <a aria-label="Compare" class="action-btn" href="shop-compare.html"><i
                                                class="fi-rs-shuffle"></i></a>
                                        <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal"
                                            data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                    </div>
                                    <div class="product-badges product-badges-position product-badges-mrg">
                                        <span class="best">-14%</span>
                                    </div>
                                </div>
                                <div class="product-content-wrap">
                                    <div class="product-category">
                                        <a href="shop-grid-right.html">Pet Foods</a>
                                    </div>
                                    <h2><a href="{{ url("product/details/$item->id/$item->product_slug") }}">Blue Diamond Almonds Lightly Salted
                                            Vegetables</a></h2>
                                    <div class="product-rate-cover">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 90%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> (4.0)</span>
                                    </div>
                                    <div>
                                        <span class="font-small text-muted">By <a
                                                href="vendor-details-1.html">NestFood</a></span>
                                    </div>
                                    <div class="product-card-bottom">
                                        <div class="product-price">
                                            <span>$23.85</span>
                                            <span class="old-price">$25.8</span>
                                        </div>
                                        <div class="add-cart">
                                            <a class="add" href="shop-cart.html"><i
                                                    class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end product card-->

                    </div>
                    <!--End product-grid-4-->
                </div>


            </div>
            <!--End tab-content-->
        </div>


    </section> --}}
    <!--End Computer Category -->




















    <section class="section-padding mb-30">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-4 col-md-6 mb-sm-5 mb-md-0 wow animate__animated animate__fadeInUp"
                    data-wow-delay="0">
                    <h4 class="section-title style-1 mb-30 animated animated"> Hot Deals </h4>
                    <div class="product-list-small animated animated">
                        @php
                            $hot_deals = App\Models\Product::where('status', 'active')
                                ->where('hot_deals', 1)
                                ->limit(3)
                                ->get();
                        @endphp
                        @foreach ($hot_deals as $item)
                            <article class="row align-items-center hover-up">
                                <figure class="col-md-4 mb-0">
                                    <a href="{{ url("product/details/$item->id/$item->product_slug") }}"><img
                                            src="{{ asset('uploads/backend/product/thumbnail/' . $item->thumbnail_image) }}"
                                            alt="" /></a>
                                </figure>
                                <div class="col-md-8 mb-0">
                                    <h6>
                                        <a
                                            href="{{ url("product/details/$item->id/$item->product_slug") }}">{{ $item->product_name }}</a>
                                    </h6>
                                    <div class="product-rate-cover">
                                        <div class="product-rate d-inline-block">
                                            @php
                                            
                                                //avg rating
                                                $avg_rating = App\Models\Review::where('product_id', $item->id)->avg('rating');
                                                $avg_rating_pct = ($avg_rating / 5) * 100;
                                            @endphp
                                            <div class="product-rating" style="width:{{ $avg_rating_pct}}%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> ({{$avg_rating}})</span>
                                    </div>
                                    <div class="product-price">
                                        <span>${{ $item->selling_price }}</span>
                                        <span class="old-price">${{ $item->selling_price + $item->discount_price }}</span>
                                    </div>
                                </div>
                            </article>
                        @endforeach

                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 mb-md-0 wow animate__animated animate__fadeInUp"
                    data-wow-delay=".1s">
                    <h4 class="section-title style-1 mb-30 animated animated"> Special Offer </h4>
                    <div class="product-list-small animated animated">
                        @php
                            $special_offer = App\Models\Product::where('status', 'active')
                                ->where('special_offer', 1)
                                ->limit(3)
                                ->get();
                        @endphp
                        @foreach ($special_offer as $item)
                            <article class="row align-items-center hover-up">
                                <figure class="col-md-4 mb-0">
                                    <a href="{{ url("product/details/$item->id/$item->product_slug") }}"><img
                                            src="{{ asset('uploads/backend/product/thumbnail/' . $item->thumbnail_image) }}"
                                            alt="" /></a>
                                </figure>
                                <div class="col-md-8 mb-0">
                                    <h6>
                                        <a
                                            href="{{ url("product/details/$item->id/$item->product_slug") }}">{{ $item->product_name }}</a>
                                    </h6>
                                    <div class="product-rate-cover">
                                        <div class="product-rate d-inline-block">
                                            @php
                                            
                                                //avg rating
                                                $avg_rating = App\Models\Review::where('product_id', $item->id)->avg('rating');
                                                $avg_rating_pct = ($avg_rating / 5) * 100;
                                            @endphp
                                            <div class="product-rating" style="width: {{$avg_rating_pct}}%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> ({{$avg_rating}})</span>
                                    </div>
                                    <div class="product-price">
                                        <span>${{ $item->selling_price }}</span>
                                        <span class="old-price">${{ $item->selling_price + $item->discount_price }}</span>
                                    </div>
                                </div>
                            </article>
                        @endforeach

                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 mb-sm-5 mb-md-0 d-none d-lg-block wow animate__animated animate__fadeInUp"
                    data-wow-delay=".2s">
                    <h4 class="section-title style-1 mb-30 animated animated">Recently added</h4>
                    <div class="product-list-small animated animated">
                        @php
                            $recently_added = App\Models\Product::where('status', 'active')
                                ->orderBy('created_at', 'DESC')
                                ->limit(3)
                                ->get();
                        @endphp
                        @foreach ($recently_added as $item)
                            <article class="row align-items-center hover-up">
                                <figure class="col-md-4 mb-0">
                                    <a href="{{ url("product/details/$item->id/$item->product_slug") }}"><img
                                            src="{{ asset('uploads/backend/product/thumbnail/' . $item->thumbnail_image) }}"
                                            alt="" /></a>
                                </figure>
                                <div class="col-md-8 mb-0">
                                    <h6>
                                        <a
                                            href="{{ url("product/details/$item->id/$item->product_slug") }}">{{ $item->product_name }}</a>
                                    </h6>
                                    <div class="product-rate-cover">
                                        <div class="product-rate d-inline-block">
                                            @php
                                            //avg rating
                                            $avg_rating = App\Models\Review::where('product_id', $item->id)->avg('rating');
                                            $avg_rating_pct = ($avg_rating / 5) * 100;
                                        @endphp
                                            <div class="product-rating" style="width: {{$avg_rating_pct}}%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> ({{$avg_rating}})</span>
                                    </div>
                                    <div class="product-price">
                                        <span>${{ $item->selling_price }}</span>
                                        <span class="old-price">${{ $item->selling_price + $item->discount_price }}</span>
                                    </div>
                                </div>
                            </article>
                        @endforeach

                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 mb-sm-5 mb-md-0 d-none d-xl-block wow animate__animated animate__fadeInUp"
                    data-wow-delay=".3s">
                    <h4 class="section-title style-1 mb-30 animated animated"> Special Deals </h4>
                    <div class="product-list-small animated animated">
                        @php
                            $special_deals = App\Models\Product::where('status', 'active')
                                ->where('special_deals', 1)
                                ->limit(3)
                                ->get();
                        @endphp
                        @foreach ($special_deals as $item)
                            <article class="row align-items-center hover-up">
                                <figure class="col-md-4 mb-0">
                                    <a href="{{ url("product/details/$item->id/$item->product_slug") }}"><img
                                            src="{{ asset('uploads/backend/product/thumbnail/' . $item->thumbnail_image) }}"
                                            alt="" /></a>
                                </figure>
                                <div class="col-md-8 mb-0">
                                    <h6>
                                        <a
                                            href="{{ url("product/details/$item->id/$item->product_slug") }}">{{ $item->product_name }}</a>
                                    </h6>
                                    <div class="product-rate-cover">
                                        <div class="product-rate d-inline-block">
                                            @php
                                            
                                            //avg rating
                                            $avg_rating = App\Models\Review::where('product_id', $item->id)->avg('rating');
                                            $avg_rating_pct = ($avg_rating / 5) * 100;
                                        @endphp
                                            <div class="product-rating" style="width: {{$avg_rating_pct}}%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> ({{$avg_rating}})</span>
                                    </div>
                                    <div class="product-price">
                                        <span>${{ $item->selling_price }}</span>
                                        <span class="old-price">${{ $item->selling_price + $item->discount_price }}</span>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End 4 columns-->

    <!--Vendor List -->
    @include('frontend.home.vendors_list')
    <!--End Vendor List -->

@endsection
