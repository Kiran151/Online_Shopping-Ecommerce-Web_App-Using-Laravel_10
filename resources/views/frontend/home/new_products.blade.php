@php
    $product = App\Models\Product::where('status', 'active')
        ->orderBy('id', 'ASC')
        ->limit(10)
        ->get();
@endphp
<section class="product-tabs section-padding position-relative">
    <div class="container">
        <div class="section-title style-2 wow animate__animated animate__fadeIn">
            <h3> New Products </h3>
            <ul class="nav nav-tabs links" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="nav-tab-one" data-bs-toggle="tab" data-bs-target="#tab-one"
                        type="button" role="tab" aria-controls="tab-one" aria-selected="true">All</button>
                </li>
                @php
                    $category = App\Models\Category::orderBy('category_name', 'ASC')
                        ->limit(7)
                        ->get();
                @endphp
                @foreach ($category as $item)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="nav-tab-two" data-bs-toggle="tab"
                            data-bs-target="#category{{ $item->id }}" type="button" role="tab"
                            aria-controls="tab-two" aria-selected="false">{{ $item->category_name }}</button>
                    </li>
                @endforeach
            </ul>
        </div>
        <!--End nav-tabs-->
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="tab-one" role="tabpanel" aria-labelledby="tab-one">
                <div class="row product-grid-4">
                    @foreach ($product as $item)
                        <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                            <div class="product-cart-wrap mb-30 wow animate__animated animate__fadeIn"
                                data-wow-delay=".1s">
                                <div class="product-img-action-wrap">
                                    <div class="product-img product-img-zoom">
                                        <a href='{{ url("product/details/$item->id/$item->product_slug") }}'>
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
                                        <span class="new">New</span>
                                    </div>
                                </div>
                                <div class="product-content-wrap">
                                    @php
                                        $category = App\Models\Category::where('id', $item->category_id)->first();
                                    @endphp
                                    <div class="product-category">
                                        <a href="shop-grid-right.html">{{ $category->category_name }}</a>
                                    </div>
                                    <h2><a
                                            href='{{ url("product/details/$item->id/$item->product_slug") }}'>{{ $item->product_name }}</a>
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
                                        <span class="font-small ml-5 text-muted"> ({{ $avg_rating }})</span>
                                    </div>
                                    @php
                                        $vendor = App\Models\User::where('id', $item->vendor_id)->first();
                                    @endphp
                                    <div>
                                        <span class="font-small text-muted">By <a
                                                href="vendor-details-1.html">{{ $vendor->name }}</a></span>
                                    </div>
                                    <div class="product-card-bottom">
                                        <div class="product-price">
                                            <span>${{ $item->selling_price - $item->discount_price }}</span>
                                            @if ($item->discount_price > 0)
                                                <span
                                                    class="old-price">${{ $item->selling_price + $item->discount_price }}</span>
                                            @endif
                                        </div>
                                        <div class="add-cart">
                                            <a class="add" onclick="addToCart1({{ $item->id }})"><i
                                                    class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <!--end product card-->
                </div>
                <!--End product-grid-4-->
            </div>
            <!--En tab one-->
            @php
                $category = App\Models\Category::orderBy('category_name', 'ASC')
                    ->limit(7)
                    ->get();
            @endphp
            @foreach ($category as $item)
                <div class="tab-pane fade" id="category{{ $item->id }}" role="tabpanel" aria-labelledby="tab-two">
                    <div class="row product-grid-4">
                        @php
                            $products = App\Models\Product::where('category_id', $item->id)->get();
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
                                            <span class="new">New</span>
                                        </div>
                                    </div>
                                    <div class="product-content-wrap">
                                        @php
                                            $category = App\Models\Category::where('id', $item->category_id)->first();
                                        @endphp
                                        <div class="product-category">
                                            <a href="shop-grid-right.html">{{ $category->category_name }}</a>
                                        </div>
                                        <h2><a
                                                href="{{ url("product/details/$item->id/$item->product_slug") }}">{{ $item->product_name }}</a>
                                        </h2>
                                        <div class="product-rate-cover">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: 90%"></div>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> (4.0)</span>
                                        </div>
                                        @php
                                            $vendor = App\Models\User::where('id', $item->vendor_id)->first();
                                        @endphp
                                        <div>
                                            <span class="font-small text-muted">By <a
                                                    href="vendor-details-1.html">{{ $vendor->name }}</a></span>
                                        </div>
                                        <div class="product-card-bottom">
                                            <div class="product-price">
                                                <span>${{ $item->selling_price - $item->discount_price }}</span>
                                                @if ($item->discount_price > 0)
                                                    <span
                                                        class="old-price">${{ $item->selling_price + $item->discount_price }}</span>
                                                @endif
                                            </div>
                                            <div class="add-cart">
                                                <a class="add" onclick="addToCart1({{ $item->id }})"><i
                                                        class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="d-flex justify-content-center">
                                <p>No products for this category</p>
                            </div>
                        @endforelse
                        <!--end product card-->
                    </div>
                    <!--End product-grid-4-->
                </div>
            @endforeach
            <!--En tab two-->
        </div>
        <!--End tab-content-->
    </div>

</section>
