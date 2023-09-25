<section class="section-padding pb-5">
    <div class="container">
        <div class="section-title wow animate__animated animate__fadeIn">
            <h3 class=""> Featured Products </h3>

        </div>
        <div class="row">
            <div class="col-lg-3 d-none d-lg-flex wow animate__animated animate__fadeIn">
                <div class="banner-img style-2">
                    <div class="banner-text">
                        <h2 class="mb-100">Bring nature into your home</h2>
                        <a href="shop-grid-right.html" class="btn btn-xs">Shop Now <i
                                class="fi-rs-arrow-small-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-12 wow animate__animated animate__fadeIn" data-wow-delay=".4s">
                <div class="tab-content" id="myTabContent-1">
                    <div class="tab-pane fade show active" id="tab-one-1" role="tabpanel" aria-labelledby="tab-one-1">
                        <div class="carausel-4-columns-cover arrow-center position-relative">
                            <div class="slider-arrow slider-arrow-2 carausel-4-columns-arrow"
                                id="carausel-4-columns-arrows"></div>
                            <div class="carausel-4-columns carausel-arrow-center" id="carausel-4-columns">
                                @php
                                    $products = App\Models\Product::where([['featured', 1], ['status', 'active']])->get();
                                @endphp
                                @foreach ($products as $item)
                                    <div class="product-cart-wrap">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href="shop-product-right.html">
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
                                                @php
                                                    $amount = $item->selling_price - $item->discount_price;
                                                    $discount = ($amount / $item->selling_price) * 100;
                                                    $save = 100 - round($discount);
                                                @endphp
                                                <span
                                                    class="{{ $item->discount_price ? 'hot' : 'sale' }}">{{ $item->discount_price ? 'Save ' . $save . '%' : 'Best Sale' }}</span>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a
                                                    href="shop-grid-right.html">{{ $item['category']['category_name'] }}</a>
                                            </div>
                                            <h2><a href="shop-product-right.html">{{ $item->product_name }}</a></h2>
                                            <div class="product-rate d-inline-block">
                                                @php
                                            
                                                //avg rating
                                                $avg_rating = App\Models\Review::where('product_id', $item->id)->avg('rating');
                                                $avg_rating_pct = ($avg_rating / 5) * 100;
                                            @endphp
                                                <div class="product-rating" style="width: {{$avg_rating_pct}}%"></div>
                                            </div>
                                            <div class="product-price mt-10">
                                                <span>${{ $item->selling_price-$item->discount_price }} </span>
                                                @if ($item->discount_price > 0)
                                                    <span
                                                        class="old-price">${{ $item->selling_price + $item->discount_price }}</span>
                                                @endif
                                            </div>
                                            <div class="sold mt-15 mb-15">
                                                <div class="progress mb-5">
                                                    <div class="progress-bar" role="progressbar" style="width: 50%"
                                                        aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <span class="font-xs text-heading"> Sold: 90/120</span>
                                            </div>
                                            <a onclick="addToCart1({{ $item->id}})" class="btn w-100 hover-up"><i
                                                    class="fi-rs-shopping-cart mr-5"></i>Add To Cart</a>
                                        </div>
                                    </div>
                                @endforeach
                                <!--End product Wrap-->
                            </div>
                        </div>
                    </div>
                    <!--End tab-pane-->


                </div>
                <!--End tab-content-->
            </div>
            <!--End Col-lg-9-->
        </div>
    </div>
</section>
