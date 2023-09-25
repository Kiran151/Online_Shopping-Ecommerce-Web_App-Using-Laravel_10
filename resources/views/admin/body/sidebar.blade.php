<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="{{ asset('frontend/assets/imgs/theme/favicon.svg') }}" class="logo-icon" alt="logo icon">
        </div>
        <div>
            <h4 class="logo-text">Nest</h4>
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
        </div>
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <div class="parent-icon"><i class='bx bx-home-circle'></i>
                </div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>
        <li>
            <a href="{{ route('brands') }}">
                <div class="parent-icon"><i class="bx bx-category"></i>
                </div>
                <div class="menu-title">Brand</div>
            </a>
        </li>
        <li>
            <a href="{{ route('categories') }}">
                <div class="parent-icon"><i class="bx bx-layer"></i>
                </div>
                <div class="menu-title">Category</div>
            </a>
        </li>
        <li>
            <a href="{{ route('subcategories') }}">
                <div class="parent-icon"><i class="bx bx-intersect"></i>
                </div>
                <div class="menu-title">SubCategory</div>
            </a>
        </li>
        <li>
            <a href="{{ route('vendors') }}">
                <div class="parent-icon"><i class="bx bx-group"></i>
                </div>
                <div class="menu-title">Vendors</div>
            </a>
        </li>
        <li>
            <a href="{{ route('users') }}">
                <div class="parent-icon"><i class="bx bx-user"></i>
                </div>
                <div class="menu-title">Users</div>
            </a>
        </li>
        <li>
            <a href="{{ route('products') }}">
                <div class="parent-icon"><i class="bx bx-cube"></i>
                </div>
                <div class="menu-title">Products</div>
            </a>
        </li>
        <li>
            <a href="{{ route('sliders') }}">
                <div class="parent-icon"><i class="bx bx-images"></i>
                </div>
                <div class="menu-title">Slider</div>
            </a>
        </li>
        <li>
            <a href="{{ route('banners') }}">
                <div class="parent-icon"><i class="bx bx-photo-album"></i>
                </div>
                <div class="menu-title">Banner</div>
            </a>
        </li>
        <li>
            <a href="{{ route('coupons') }}">
                <div class="parent-icon"><i class="bx bx-purchase-tag-alt"></i>
                </div>
                <div class="menu-title">Coupons</div>
            </a>
        </li>
        <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class="bx bx-directions"></i>
                </div>
                <div class="menu-title">Shipping</div>
            </a>
            <ul>
                <li> <a href="{{route('all.divisions')}}"><i class="bx bx-right-arrow-alt"></i>Divisions</a>
                </li>
                <li> <a href="{{route('all.districts')}}"><i class="bx bx-right-arrow-alt"></i>Districts</a>
                </li>
                <li> <a href="{{route('all.states')}}"><i class="bx bx-right-arrow-alt"></i>States</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="{{ route('orders') }}">
                <div class="parent-icon"><i class="bx bx-cart-alt"></i>
                </div>
                <div class="menu-title">Orders</div>
            </a>
        </li>
        <li>
            <a href="{{ route('return.orders') }}">
                <div class="parent-icon"><i class="bx bx-transfer"></i>
                </div>
                <div class="menu-title">Return Orders</div>
            </a>
        </li>
        <li>
            <a href="{{ route('reports') }}">
                <div class="parent-icon"><i class="bx bx-bar-chart-square"></i>
                </div>
                <div class="menu-title">Reports</div>
            </a>
        </li>
        <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class="bx bx-detail"></i>
                </div>
                <div class="menu-title">Blog</div>
            </a>
            <ul>
                <li> <a href="{{ route('blogs') }}"><i class="bx bx-right-arrow-alt"></i>Blogs</a>
                </li>
                <li> <a href="{{route('all.blog.category')}}"><i class="bx bx-right-arrow-alt"></i>Blog Category</a>
                </li>
                
            </ul>
        </li>
        <li>
            <a href="{{ route('all.reviews') }}">
                <div class="parent-icon"><i class="bx bx-message-square-edit"></i>
                </div>
                <div class="menu-title">Rating&Review</div>
            </a>
        </li>
        <li>
            <a href="{{ route('seo') }}">
                <div class="parent-icon"><i class="bx bx-spreadsheet"></i>
                </div>
                <div class="menu-title">Seo</div>
            </a>
        </li>
        {{-- <li>
            <a href="{{ route('product.stock') }}">
                <div class="parent-icon"><i class="bx bx-spreadsheet"></i>
                </div>
                <div class="menu-title">Product Stock</div>
            </a>
        </li> --}}
        

    </ul>
    <!--end navigation-->
</div>
