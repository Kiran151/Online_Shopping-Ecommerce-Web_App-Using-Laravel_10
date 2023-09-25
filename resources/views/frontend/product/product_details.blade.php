@extends('frontend.master')
@section('master')
    <style>
        .rate {
            float: left;
            height: 46px;
            padding: 0 10px;
        }

        .rate:not(:checked)>input {
            position: absolute;
            top: -9999px;
        }

        .rate:not(:checked)>label {
            float: right;
            width: 1em;
            overflow: hidden;
            white-space: nowrap;
            cursor: pointer;
            font-size: 30px;
            color: #ccc;
        }

        .rate:not(:checked)>label:before {
            content: '★ ';
        }

        .rate>input:checked~label {
            color: #ffc700;
        }

        .rate:not(:checked)>label:hover,
        .rate:not(:checked)>label:hover~label {
            color: #ffc700;
        }

        .rate>input:checked+label:hover,
        .rate>input:checked+label:hover~label,
        .rate>input:checked~label:hover,
        .rate>input:checked~label:hover~label,
        .rate>label:hover~input:checked~label {
            color: #ffc700;
        }

        /* Modified from: https://github.com/mukulkant/Star-rating-using-pure-css */
    </style>
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="index.html" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                    <span></span> <a href="shop-grid-right.html">{{ $category->category_name }}</a> <span></span>
                    {{ $data->product_name }}
                </div>
            </div>
        </div>
        <div class="container mb-30">
            <div class="row">
                <div class="col-xl-10 col-lg-12 m-auto">
                    <div class="product-detail accordion-detail">
                        <div class="row mb-50 mt-30">
                            <div class="col-md-6 col-sm-12 col-xs-12 mb-md-0 mb-sm-5">
                                <div class="detail-gallery">
                                    <span class="zoom-icon"><i class="fi-rs-search"></i></span>
                                    <!-- MAIN SLIDES -->
                                    <div class="product-image-slider">
                                        @foreach ($productImages as $item)
                                            <figure class="border-radius-10">
                                                <img src="{{ asset('uploads/backend/product/' . $item->image) }}"
                                                    alt="product image" />
                                            </figure>
                                        @endforeach

                                    </div>
                                    <!-- THUMBNAILS -->
                                    <div class="slider-nav-thumbnails">
                                        @foreach ($productImages as $item)
                                            <div><img src="{{ asset('uploads/backend/product/' . $item->image) }}"
                                                    alt="product image" /></div>
                                        @endforeach
                                    </div>
                                </div>
                                <!-- End Gallery -->
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="detail-info pr-30 pl-30">
                                    @if ($data->product_qty > 0)
                                        <span class="stock-status in-stock">in Stock</span>
                                    @else
                                        <span class="stock-status out-stock">Stock Out</span>
                                    @endif
                                    <h2 class="title-detail" id="pro_name">{{ $data->product_name }}</h2>
                                    <div class="product-detail-rating">
                                        <div class="product-rate-cover text-end">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: {{ $avg_rating_pct }}%"></div>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> ({{ $total_ratings }} reviews)</span>
                                        </div>
                                    </div>
                                    <div class="clearfix product-price-cover">
                                        <div class="product-price primary-color float-left">
                                            <span class="current-price text-brand">${{ $data->selling_price }}</span>
                                            <span>
                                                @php
                                                    $amount = $data->selling_price - $data->discount_price;
                                                    $discount = ($amount / $data->selling_price) * 100;
                                                @endphp
                                                <span class="save-price font-md color3 ml-15">{{ round($discount) }}%
                                                    Off</span>
                                                <span
                                                    class="old-price font-md ml-15">${{ $data->selling_price + $data->discount_price }}</span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="short-desc mb-30">
                                        <p class="font-lg">{{ @$data->short_description }}</p>
                                    </div>
                                    @php
                                        $size = $data->product_size;
                                        $sizes = explode(',', $data->product_size);
                                        
                                    @endphp
                                    @if ($data->product_size !== null)
                                        <div class="attr-detail attr-size mb-30">
                                            <strong class="mr-15">Size</strong>
                                            <select class="form-control" name="" id="sizes">
                                                <option disabled selected>Choose Size</option>
                                                @foreach ($sizes as $size)
                                                    <option value="{{ $size }}">{{ $size }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif
                                    @php
                                        $color = $data->product_color;
                                        $colors = explode(',', $data->product_color);
                                    @endphp
                                    @if ($data->product_color !== null)
                                        <div class="attr-detail attr-size mb-30">
                                            <strong class="mr-10">Color</strong>
                                            <select class="form-control" name="" id="colors">
                                                <option disabled selected>Choose Color</option>
                                                @foreach ($colors as $color)
                                                    <option value="{{ $color }}">{{ $color }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif
                                    <div class="detail-extralink mb-50">
                                        <div class="detail-qty border radius">
                                            <a href="#" class="qty-down"><i class="fi-rs-angle-small-down"></i></a>
                                            <input type="text" id="quantity" name="quantity" class="qty-val"
                                                value="1" min="1">
                                            <a href="#" class="qty-up"><i class="fi-rs-angle-small-up"></i></a>
                                        </div>
                                        <div class="product-extra-link2">
                                            <input type="hidden"id="pro_id" value="{{ $data->id }}">
                                            <input type="hidden"id="ven_id" value="{{ $data->vendor_id }}">

                                            <button onclick="saveToCart()" type="submit"
                                                class="button button-add-to-cart"><i class="fi-rs-shopping-cart"></i>Add to
                                                cart</button>
                                            <a aria-label="Add To Wishlist" class="action-btn hover-up"
                                                href="shop-wishlist.html"><i class="fi-rs-heart"></i></a>
                                            <a aria-label="Compare" class="action-btn hover-up" href="shop-compare.html"><i
                                                    class="fi-rs-shuffle"></i></a>
                                        </div>
                                    </div>
                                    <div class="font-xs">
                                        <ul class="mr-50 float-start">
                                            <li class="mb-5">Type: <span
                                                    class="text-brand">{{ $category->category_name }}</span></li>
                                            <li class="mb-5">MFG:<span
                                                    class="text-brand">{{ date('F-Y', strtotime($data->created_at)) }}</span>
                                            </li>
                                            <li>Brand: <span class="text-brand">{{ $data['brand']['brand_name'] }}</span>
                                            </li>
                                        </ul>
                                        <ul class="float-start">
                                            <li class="mb-5">Product Code: <a
                                                    href="#">{{ $data->product_code }}</a></li>
                                            @php
                                                $tagssArray = explode(',', $data->product_tags);
                                            @endphp
                                            <li class="mb-5">Tags: @foreach ($tagssArray as $item)
                                                    <a href="#" class="badge" style="background-color: #3BB77E"
                                                        rel="tag">{{ $item }}</a>
                                                @endforeach
                                            </li>
                                            <li>Stock:<span class="in-stock text-brand ml-5">{{ $data->product_qty }}
                                                    Items
                                                    In Stock</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- Detail Info -->
                            </div>
                        </div>
                        <div class="product-info">
                            <div class="tab-style3">
                                <ul class="nav nav-tabs text-uppercase">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="Description-tab" data-bs-toggle="tab"
                                            href="#Description">Description</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="Additional-info-tab" data-bs-toggle="tab"
                                            href="#Additional-info">Additional info</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="Vendor-info-tab" data-bs-toggle="tab"
                                            href="#Vendor-info">Vendor</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="Reviews-tab" data-bs-toggle="tab"
                                            href="#Reviews">Reviews (3)</a>
                                    </li>
                                </ul>
                                <div class="tab-content shop_info_tab entry-main-content">
                                    <div class="tab-pane fade show active" id="Description">
                                        <div class="">
                                            {!! @$data->long_description !!}
                                            <ul class="product-more-infor mt-30">
                                                <li><span>Type Of Packing</span> Bottle</li>
                                                <li><span>Color</span> {{ $data->product_color }}</li>
                                                <li><span>Quantity Per Case</span> 100ml</li>
                                                <li><span>Ethyl Alcohol</span> 70%</li>
                                                <li><span>Piece In One</span> Carton</li>
                                            </ul>
                                            <hr class="wp-block-separator is-style-dots" />
                                            <p>{{ @$data->short_description }}</p>
                                            <h4 class="mt-30">Packaging & Delivery</h4>
                                            <hr class="wp-block-separator is-style-wide" />
                                            <p>Less lion goodness that euphemistically robin expeditiously bluebird
                                                smugly scratched far while thus cackled sheepishly rigid after due one
                                                assenting regarding censorious while occasional or this more crane went
                                                more as this less much amid overhung anathematic because much held one
                                                exuberantly sheep goodness so where rat wry well concomitantly.</p>
                                            <p>Scallop or far crud plain remarkably far by thus far iguana lewd
                                                precociously and and less rattlesnake contrary caustic wow this near
                                                alas and next and pled the yikes articulate about as less cackled
                                                dalmatian in much less well jeering for the thanks blindly sentimental
                                                whimpered less across objectively fanciful grimaced wildly some wow and
                                                rose jeepers outgrew lugubrious luridly irrationally attractively
                                                dachshund.</p>
                                            <h4 class="mt-30">Suggested Use</h4>
                                            <ul class="product-more-infor mt-30">
                                                <li>Refrigeration not necessary.</li>
                                                <li>Stir before serving</li>
                                            </ul>
                                            <h4 class="mt-30">Other Ingredients</h4>
                                            <ul class="product-more-infor mt-30">
                                                <li>Organic raw pecans, organic raw cashews.</li>
                                                <li>This butter was produced using a LTG (Low Temperature Grinding)
                                                    process</li>
                                                <li>Made in machinery that processes tree nuts but does not process
                                                    peanuts, gluten, dairy or soy</li>
                                            </ul>
                                            <h4 class="mt-30">Warnings</h4>
                                            <ul class="product-more-infor mt-30">
                                                <li>Oil separation occurs naturally. May contain pieces of shell.</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="Additional-info">
                                        <table class="font-md">
                                            <tbody>
                                                <tr class="stand-up">
                                                    <th>Stand Up</th>
                                                    <td>
                                                        <p>35″L x 24″W x 37-45″H(front to back wheel)</p>
                                                    </td>
                                                </tr>
                                                <tr class="folded-wo-wheels">
                                                    <th>Folded (w/o wheels)</th>
                                                    <td>
                                                        <p>32.5″L x 18.5″W x 16.5″H</p>
                                                    </td>
                                                </tr>
                                                <tr class="folded-w-wheels">
                                                    <th>Folded (w/ wheels)</th>
                                                    <td>
                                                        <p>32.5″L x 24″W x 18.5″H</p>
                                                    </td>
                                                </tr>
                                                <tr class="door-pass-through">
                                                    <th>Door Pass Through</th>
                                                    <td>
                                                        <p>24</p>
                                                    </td>
                                                </tr>
                                                <tr class="frame">
                                                    <th>Frame</th>
                                                    <td>
                                                        <p>Aluminum</p>
                                                    </td>
                                                </tr>
                                                <tr class="weight-wo-wheels">
                                                    <th>Weight (w/o wheels)</th>
                                                    <td>
                                                        <p>20 LBS</p>
                                                    </td>
                                                </tr>
                                                <tr class="weight-capacity">
                                                    <th>Weight Capacity</th>
                                                    <td>
                                                        <p>60 LBS</p>
                                                    </td>
                                                </tr>
                                                <tr class="width">
                                                    <th>Width</th>
                                                    <td>
                                                        <p>24″</p>
                                                    </td>
                                                </tr>
                                                <tr class="handle-height-ground-to-handle">
                                                    <th>Handle height (ground to handle)</th>
                                                    <td>
                                                        <p>37-45″</p>
                                                    </td>
                                                </tr>
                                                <tr class="wheels">
                                                    <th>Wheels</th>
                                                    <td>
                                                        <p>12″ air / wide track slick tread</p>
                                                    </td>
                                                </tr>
                                                <tr class="seat-back-height">
                                                    <th>Seat back height</th>
                                                    <td>
                                                        <p>21.5″</p>
                                                    </td>
                                                </tr>
                                                <tr class="head-room-inside-canopy">
                                                    <th>Head room (inside canopy)</th>
                                                    <td>
                                                        <p>25″</p>
                                                    </td>
                                                </tr>
                                                <tr class="pa_color">
                                                    <th>Color</th>
                                                    <td>
                                                        <p>Black, Blue, Red, White</p>
                                                    </td>
                                                </tr>
                                                <tr class="pa_size">
                                                    <th>Size</th>
                                                    <td>
                                                        <p>M, S</p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    @if ($data->vendor_id)
                                        @php
                                            $vendor = App\Models\User::findOrFail($data->vendor_id);
                                        @endphp
                                        <div class="tab-pane fade" id="Vendor-info">
                                            <div class="vendor-logo d-flex mb-30">
                                                <img src="{{ asset('uploads/vendor_images/' . $vendor->image) }}"
                                                    alt="" />
                                                <div class="vendor-name ml-15">
                                                    <h6>
                                                        <a href="vendor-details-2.html">{{ $vendor->name }}</a>
                                                    </h6>
                                                    <div class="product-rate-cover text-end">
                                                        <div class="product-rate d-inline-block">
                                                            <div class="product-rating" style="width: 90%"></div>
                                                        </div>
                                                        <span class="font-small ml-5 text-muted"> (32 reviews)</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <ul class="contact-infor mb-50">
                                                <li><img src="assets/imgs/theme/icons/icon-location.svg"
                                                        alt="" /><strong>Address: </strong>
                                                    <span>{{ $vendor->address }}</span>
                                                </li>
                                                <li><img src="assets/imgs/theme/icons/icon-contact.svg"
                                                        alt="" /><strong>Contact Seller:</strong><span>(+91) -
                                                        {{ $vendor->phone }}</span></li>
                                            </ul>
                                            <div class="d-flex mb-55">
                                                <div class="mr-30">
                                                    <p class="text-brand font-xs">Rating</p>
                                                    <h4 class="mb-0">92%</h4>
                                                </div>
                                                <div class="mr-30">
                                                    <p class="text-brand font-xs">Ship on time</p>
                                                    <h4 class="mb-0">100%</h4>
                                                </div>
                                                <div>
                                                    <p class="text-brand font-xs">Chat response</p>
                                                    <h4 class="mb-0">89%</h4>
                                                </div>
                                            </div>
                                            <p>{{ $vendor->short_description }}</p>
                                        </div>
                                    @else
                                        <div class="tab-pane fade" id="Vendor-info">
                                            <p>No Vendors</p>
                                        </div>
                                    @endif
                                    <div class="tab-pane fade" id="Reviews">
                                        <!--Comments-->
                                        <div class="comments-area">
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    <h4 class="mb-30">Customer questions & answers</h4>
                                                    @php
                                                        $reviews = App\Models\Review::where([['product_id', $data->id], ['status', 1]])->get();
                                                    @endphp
                                                    @foreach ($reviews as $item)
                                                        @php
                                                            $rating_p = ($item->rating / 5) * 100;
                                                        @endphp
                                                        <div class="comment-list">
                                                            <div
                                                                class="single-comment justify-content-between d-flex mb-30">
                                                                <div class="user justify-content-between d-flex">
                                                                    <div class="thumb text-center">
                                                                        <img src="{{ !empty($item['customer']->image) ? asset('uploads/user_images/' . $item['customer']->image) : asset('uploads/img/no_image.jpg') }}"
                                                                            alt="" />
                                                                        <a href="#"
                                                                            class="font-heading text-brand">{{ $item['customer']->name }}</a>
                                                                    </div>
                                                                    <div class="desc">
                                                                        <div class="d-flex justify-content-between mb-10">
                                                                            <div class="d-flex align-items-center">
                                                                                <span
                                                                                    class="font-xs text-muted">{{ date('F d Y', strtotime($item->created_at)) }}</span>
                                                                            </div>
                                                                            <div class="product-rate d-inline-block">
                                                                                <div class="product-rating"
                                                                                    style="width: {{ $rating_p }}%">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <p class="mb-10">{{ $item->comment }}<a
                                                                                href="#" class="reply">Reply</a>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div class="col-lg-4">
                                                    <h4 class="mb-30">Customer reviews</h4>
                                                    <div class="d-flex mb-30">
                                                        <div class="product-rate d-inline-block mr-15">
                                                            <div class="product-rating"
                                                                style="width: {{ $avg_rating_pct }}%"></div>
                                                        </div>
                                                        <h6>{{ $avg_rating }} out of 5</h6>
                                                    </div>
                                                    <div class="progress">
                                                        <span>5 star</span>
                                                        <div class="progress-bar" role="progressbar"
                                                            style="width: {{ @$rating_pct['five_star'] }}%"
                                                            aria-valuenow="{{ @$rating_pct['five_star'] }}"
                                                            aria-valuemin="0" aria-valuemax="100">
                                                            {{ @$rating_pct['five_star'] }}%
                                                        </div>
                                                    </div>
                                                    <div class="progress">
                                                        <span>4 star</span>
                                                        <div class="progress-bar" role="progressbar"
                                                            style="width: {{ @$rating_pct['four_star'] }}%"
                                                            aria-valuenow="{{ @$rating_pct['four_star'] }}"
                                                            aria-valuemin="0" aria-valuemax="100">
                                                            {{ @$rating_pct['four_star'] }}%
                                                        </div>
                                                    </div>
                                                    <div class="progress">
                                                        <span>3 star</span>
                                                        <div class="progress-bar" role="progressbar"
                                                            style="width: {{ @$rating_pct['three_star'] }}%"
                                                            aria-valuenow="{{ @$rating_pct['three_star'] }}"
                                                            aria-valuemin="0" aria-valuemax="100">
                                                            {{ @$rating_pct['three_star'] }}%
                                                        </div>
                                                    </div>
                                                    <div class="progress">
                                                        <span>2 star</span>
                                                        <div class="progress-bar" role="progressbar"
                                                            style="width: {{ @$rating_pct['two_star'] }}%"
                                                            aria-valuenow="{{ @$rating_pct['two_star'] }}"
                                                            aria-valuemin="0" aria-valuemax="100">
                                                            {{ @$rating_pct['two_star'] }}%
                                                        </div>
                                                    </div>
                                                    <div class="progress mb-30">
                                                        <span>1 star</span>
                                                        <div class="progress-bar" role="progressbar"
                                                            style="width: {{ @$rating_pct['one_star'] }}%"
                                                            aria-valuenow="{{ @$rating_pct['one_star'] }}"
                                                            aria-valuemin="0" aria-valuemax="100">
                                                            {{ @$rating_pct['one_star'] }}%
                                                        </div>
                                                    </div>
                                                    <a href="#" class="font-xs text-muted">How are ratings
                                                        calculated?</a>
                                                </div>
                                            </div>
                                        </div>
                                        <!--comment form-->
                                        @guest
                                            <p>Log in first to add a review</p>
                                        @else
                                            <div class="comment-form">
                                                <h4 class="mb-15">Add a review</h4>
                                                {{-- <div class="product-rate d-inline-block mb-30"></div> --}}

                                                <div class="row">
                                                    <div class="col-lg-8 col-md-12">
                                                        <form class="form-contact comment_form" method="post"
                                                            action="{{ route('review') }}" id="commentForm">
                                                            @csrf
                                                            <input type="hidden" name="vendor_id"
                                                                value="{{ @$data->vendor_id }}">
                                                            <input type="hidden" name="product_id"
                                                                value="{{ $data->id }}">

                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="rate">
                                                                        <input type="radio" id="star5" name="rate"
                                                                            value="5"
                                                                            {{ @$user_review->rating == 5 ? 'checked' : '' }} />
                                                                        <label for="star5" title="text">5 stars</label>
                                                                        <input type="radio" id="star4" name="rate"
                                                                            value="4"
                                                                            {{ @$user_review->rating == 4 ? 'checked' : '' }} />
                                                                        <label for="star4" title="text">4 stars</label>
                                                                        <input type="radio" id="star3" name="rate"
                                                                            value="3"
                                                                            {{ @$user_review->rating == 3 ? 'checked' : '' }} />
                                                                        <label for="star3" title="text">3 stars</label>
                                                                        <input type="radio" id="star2" name="rate"
                                                                            value="2"
                                                                            {{ @$user_review->rating == 2 ? 'checked' : '' }} />
                                                                        <label for="star2" title="text">2 stars</label>
                                                                        <input type="radio" id="star1" name="rate"
                                                                            value="1"
                                                                            {{ @$user_review->rating == 1 ? 'checked' : '' }} />
                                                                        <label for="star1" title="text">1 star</label>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <textarea class="form-control w-100" name="comment" id="comment" cols="30" rows="9"
                                                                            placeholder="Write Comment" required>{{ @$user_review->comment }}</textarea>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="form-group">
                                                                <button type="submit"
                                                                    class="button button-contactForm">Submit
                                                                    Review</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endguest
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-60">
                            <div class="col-12">
                                <h2 class="section-title style-1 mb-30">Related products</h2>
                            </div>
                            <div class="col-12">
                                <div class="row related-products">
                                    @foreach ($related_products as $item)
                                        @if ($data->id !== $item->id)
                                            <div class="col-lg-3 col-md-4 col-12 col-sm-6">
                                                <div class="product-cart-wrap hover-up">
                                                    <div class="product-img-action-wrap">
                                                        <div class="product-img product-img-zoom">
                                                            <a href='{{ url("product/details/$item->id/$item->product_slug") }}'
                                                                tabindex="0">
                                                                <img class="default-img"
                                                                    src="{{ asset('uploads/backend/product/thumbnail/' . $item->thumbnail_image) }}"
                                                                    alt="" />
                                                                <img class="hover-img"
                                                                    src="{{ asset('uploads/backend/product/thumbnail/' . $item->thumbnail_image) }}"
                                                                    alt="" />
                                                            </a>
                                                        </div>
                                                        <div class="product-action-1">
                                                            <a aria-label="Quick view" class="action-btn small hover-up"
                                                                data-bs-toggle="modal" data-bs-target="#quickViewModal"><i
                                                                    class="fi-rs-search"></i></a>
                                                            <a aria-label="Add To Wishlist"
                                                                class="action-btn small hover-up"
                                                                href="shop-wishlist.html" tabindex="0"><i
                                                                    class="fi-rs-heart"></i></a>
                                                            <a aria-label="Compare" class="action-btn small hover-up"
                                                                href="shop-compare.html" tabindex="0"><i
                                                                    class="fi-rs-shuffle"></i></a>
                                                        </div>
                                                        <div
                                                            class="product-badges product-badges-position product-badges-mrg">
                                                            <span class="hot">Hot</span>
                                                        </div>
                                                    </div>
                                                    <div class="product-content-wrap">
                                                        <h2><a href='{{ url("product/details/$item->id/$item->product_slug") }}'
                                                                tabindex="0">{{ $item->product_name }}</a></h2>
                                                        <div class="rating-result" title="90%">
                                                            <span> </span>
                                                        </div>
                                                        <div class="product-price">
                                                            <span>${{ $item->selling_price - $item->discount_price }}</span>
                                                            @if ($item->discount_price > 0)
                                                                <span
                                                                    class="old-price">${{ $item->selling_price + $item->discount_price }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
