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
            <a href="{{ route('vendor.dashboard') }}">
                <div class="parent-icon"><i class='bx bx-home-circle'></i>
                </div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>
        @if (Auth::user()->status == 'active')
            <li>
                <a href="{{ route('vendor.all.products') }}">
                    <div class="parent-icon"><i class="bx bx-cube"></i>
                    </div>
                    <div class="menu-title">Products</div>
                </a>

            </li>
            <li>
                <a href="{{ route('vendor.orders') }}">
                    <div class="parent-icon"><i class="bx bx-cart-alt"></i>
                    </div>
                    <div class="menu-title">Orders</div>
                </a>
            </li>
            <li>
                <a href="{{ route('vendor.return.orders') }}">
                    <div class="parent-icon"><i class="bx bx-transfer"></i>
                    </div>
                    <div class="menu-title">Return Orders</div>
                </a>
            </li>
            <li>
                <a href="{{ route('vendor.reviews') }}">
                    <div class="parent-icon"><i class="bx bx-message-square-edit"></i>
                    </div>
                    <div class="menu-title">Rating&Review</div>
                </a>
            </li>
    </ul>
    <!--end navigation-->
    @endif

</div>
