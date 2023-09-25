@extends('frontend.master')
@section('master')

<main class="main">
    <div class="page-header mt-30 mb-75">
        <div class="container">
            <div class="archive-header">
                <div class="row align-items-center">
                    <div class="col-xl-3">
                        <h1 class="mb-15">Blog & News</h1>
                        <div class="breadcrumb">
                            <a href="index.html" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                            <span></span> Blog & News
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <div class="page-content mb-50">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="shop-product-fillter mb-50 pr-30">
                        <div class="totall-product">
                            <h3>
                                <img class="w-36px mr-10" src="assets/imgs/theme/icons/category-1.svg" alt="" />
                              {{@$category->blog_category_name?:'All Blogs'}}
                            </h3>
                        </div>
                        <div class="sort-by-product-area">
                            <div class="sort-by-cover mr-10">
                                <div class="sort-by-product-wrap">
                                    <div class="sort-by">
                                        <span><i class="fi-rs-apps"></i>Show:</span>
                                    </div>
                                    <div class="sort-by-dropdown-wrap">
                                        <span> 50 <i class="fi-rs-angle-small-down"></i></span>
                                    </div>
                                </div>
                                <div class="sort-by-dropdown">
                                    <ul>
                                        <li><a class="active" href="#">50</a></li>
                                        <li><a href="#">100</a></li>
                                        <li><a href="#">150</a></li>
                                        <li><a href="#">200</a></li>
                                        <li><a href="#">All</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="sort-by-cover">
                                <div class="sort-by-product-wrap">
                                    <div class="sort-by">
                                        <span><i class="fi-rs-apps-sort"></i>Sort:</span>
                                    </div>
                                    <div class="sort-by-dropdown-wrap">
                                        <span>Featured <i class="fi-rs-angle-small-down"></i></span>
                                    </div>
                                </div>
                                <div class="sort-by-dropdown">
                                    <ul>
                                        <li><a class="active" href="#">Featured</a></li>
                                        <li><a href="#">Newest</a></li>
                                        <li><a href="#">Most comments</a></li>
                                        <li><a href="#">Release Date</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="loop-grid loop-list pr-30 mb-50">
                       @foreach ($blogs as $item)
                       <article class="wow fadeIn animated hover-up mb-30 animated">
                        <div class="post-thumb" style="background-image: url({{ !empty($item->image) ? asset('uploads/backend/blog/' . $item->image) : asset('uploads/img/no_image.jpg') }})">
                            <div class="entry-meta">
                                <a class="entry-meta meta-2" href="blog-category-grid.html"><i class="fi-rs-play-alt"></i></a>
                            </div>
                        </div>
                        <div class="entry-content-2 pl-50">
                            <h3 class="post-title mb-20">
                                <a href="blog-post-right.html">{{$item->title}}</a>
                            </h3>
                            <p class="post-exerpt mb-40">{{$item->short_description}}</p>
                            <div class="entry-meta meta-1 font-xs color-grey mt-10 pb-10">
                                <div>
                                    <span class="post-on">{{date('d F Y',strtotime($item->created_at))}}</span>
                                    <span class="hit-count has-dot">126k Views</span>
                                </div>
                                <a href="blog-post-right.html" class="text-brand font-heading font-weight-bold">Read more <i class="fi-rs-arrow-right"></i></a>
                            </div>
                        </div>
                    </article>
                       @endforeach
                    </div>
                    {{$blogs->links('frontend.custom_pagination')}}
                    {{-- <div class="pagination-area mt-15 mb-sm-5 mb-lg-0">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-start">
                                <li class="page-item">
                                    <a class="page-link" href="#"><i class="fi-rs-arrow-small-left"></i></a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item active"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link dot" href="#">...</a></li>
                                <li class="page-item"><a class="page-link" href="#">6</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#"><i class="fi-rs-arrow-small-right"></i></a>
                                </li>
                            </ul>
                        </nav>
                    </div> --}}
                </div>
                <div class="col-lg-3 primary-sidebar sticky-sidebar">
                    <div class="widget-area">
                        <div class="sidebar-widget-2 widget_search mb-50">
                            <div class="search-form">
                                <form action="#">
                                    <input type="text" placeholder="Search…" />
                                    <button type="submit"><i class="fi-rs-search"></i></button>
                                </form>
                            </div>
                        </div>
                        <div class="sidebar-widget widget-category-2 mb-50">
                            <h5 class="section-title style-1 mb-30">Category</h5>
                            <ul>
                                @foreach ($blog_categories as $item)
                                @php
                                    $count=App\Models\Blog::where('category_id',$item->id)->count();
                                @endphp
                                <li>
                                    <a href="{{url('blogs/'.$item->id)}}"> <img src="{{asset('frontend/assets/imgs/theme/icons/category-1.svg')}}" alt="" />{{$item->blog_category_name}}</a><span class="count">{{$count}}</span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        <!-- Product sidebar Widget -->
                        <div class="sidebar-widget product-sidebar mb-50 p-30 bg-grey border-radius-10">
                            <h5 class="section-title style-1 mb-30">Trending Now</h5>
                            <div class="single-post clearfix">
                                <div class="image">
                                    <img src="{{asset('frontend/assets/imgs/shop/thumbnail-3.jpg')}}" alt="#" />
                                </div>
                                <div class="content pt-10">
                                    <h5><a href="shop-product-detail.html">Chen Cardigan</a></h5>
                                    <p class="price mb-0 mt-5">$99.50</p>
                                    <div class="product-rate">
                                        <div class="product-rating" style="width: 90%"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="single-post clearfix">
                                <div class="image">
                                    <img src="{{asset('frontend/assets/imgs/shop/thumbnail-4.jpg')}}" alt="#" />
                                </div>
                                <div class="content pt-10">
                                    <h6><a href="shop-product-detail.html">Chen Sweater</a></h6>
                                    <p class="price mb-0 mt-5">$89.50</p>
                                    <div class="product-rate">
                                        <div class="product-rating" style="width: 80%"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="single-post clearfix">
                                <div class="image">
                                    <img src="{{asset('frontend/assets/imgs/shop/thumbnail-5.jpg')}}" alt="#" />
                                </div>
                                <div class="content pt-10">
                                    <h6><a href="shop-product-detail.html">Colorful Jacket</a></h6>
                                    <p class="price mb-0 mt-5">$25</p>
                                    <div class="product-rate">
                                        <div class="product-rating" style="width: 60%"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="single-post clearfix">
                                <div class="image">
                                    <img src="{{asset('frontend/assets/imgs/shop/thumbnail-6.jpg')}}" alt="#" />
                                </div>
                                <div class="content pt-10">
                                    <h6><a href="shop-product-detail.html">Lorem, ipsum</a></h6>
                                    <p class="price mb-0 mt-5">$25</p>
                                    <div class="product-rate">
                                        <div class="product-rating" style="width: 60%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="sidebar-widget widget_instagram mb-50">
                            <h5 class="section-title style-1 mb-30">Gallery</h5>
                            <div class="instagram-gellay">
                                <ul class="insta-feed">
                                    <li>
                                        <a href="#"><img class="border-radius-5" src="{{asset('frontend/assets/imgs/shop/thumbnail-1.jpg')}}" alt="" /></a>
                                    </li>
                                    <li>
                                        <a href="#"><img class="border-radius-5" src="{{asset('frontend/assets/imgs/shop/thumbnail-2.jpg')}}" alt="" /></a>
                                    </li>
                                    <li>
                                        <a href="#"><img class="border-radius-5" src="{{asset('frontend/assets/imgs/shop/thumbnail-3.jpg')}}" alt="" /></a>
                                    </li>
                                    <li>
                                        <a href="#"><img class="border-radius-5" src="{{asset('frontend/assets/imgs/shop/thumbnail-4.jpg')}}" alt="" /></a>
                                    </li>
                                    <li>
                                        <a href="#"><img class="border-radius-5" src="{{asset('frontend/assets/imgs/shop/thumbnail-5.jpg')}}" alt="" /></a>
                                    </li>
                                    <li>
                                        <a href="#"><img class="border-radius-5" src="{{asset('frontend/assets/imgs/shop/thumbnail-6.jpg')}}" alt="" /></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!--Tags-->
                        <div class="sidebar-widget widget-tags mb-50 pb-10">
                            <h5 class="section-title style-1 mb-30">Popular Tags</h5>
                            <ul class="tags-list">
                                <li class="hover-up">
                                    <a href="blog-category-grid.html"><i class="fi-rs-cross mr-10"></i>Cabbage</a>
                                </li>
                                <li class="hover-up">
                                    <a href="blog-category-grid.html"><i class="fi-rs-cross mr-10"></i>Broccoli</a>
                                </li>
                                <li class="hover-up">
                                    <a href="blog-category-grid.html"><i class="fi-rs-cross mr-10"></i>Smoothie</a>
                                </li>
                                <li class="hover-up">
                                    <a href="blog-category-grid.html"><i class="fi-rs-cross mr-10"></i>Fruit</a>
                                </li>
                                <li class="hover-up mr-0">
                                    <a href="blog-category-grid.html"><i class="fi-rs-cross mr-10"></i>Salad</a>
                                </li>
                                <li class="hover-up mr-0">
                                    <a href="blog-category-grid.html"><i class="fi-rs-cross mr-10"></i>Appetizer</a>
                                </li>
                            </ul>
                        </div>
                        <div class="banner-img wow fadeIn mb-50 animated d-lg-block d-none">
                            <img src="assets/imgs/banner/banner-11.png" alt="" />
                            <div class="banner-text">
                                <span>Oganic</span>
                                <h4>
                                    Save 17% <br />
                                    on <span class="text-brand">Oganic</span><br />
                                    Juice
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
    
@endsection