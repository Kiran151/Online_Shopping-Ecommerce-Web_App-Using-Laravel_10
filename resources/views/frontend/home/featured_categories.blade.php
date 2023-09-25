<section class="popular-categories section-padding">
    <div class="container wow animate__animated animate__fadeIn">
        <div class="section-title">
            <div class="title">
                <h3>Featured Categories</h3>
            </div>
            <div class="slider-arrow slider-arrow-2 flex-right carausel-10-columns-arrow" id="carausel-10-columns-arrows">
            </div>
        </div>
        <div class="carausel-10-columns-cover position-relative">
            <div class="carausel-10-columns" id="carausel-10-columns">
                @php
                    $categories = App\Models\Category::all();
                @endphp
                @foreach ($categories as $item)
                    <div class="card-2 bg-9 wow animate__animated animate__fadeInUp" data-wow-delay=".1s">
                        <figure class="img-hover-scale overflow-hidden">
                            <a href="{{ url("products/category/$item->id/$item->category_slug") }}"><img
                                    src="{{ asset('uploads/backend/category/' . $item->category_image) }}"
                                    alt="" /></a>
                        </figure>
                        <h6><a href="{{ url("products/category/$item->id/$item->category_slug") }}">{{ $item->category_name }}</a></h6>
                        @php
                        $product_count = App\Models\Product::where('category_id', $item->id)->count();
                    @endphp
                        <span>{{$product_count}}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
