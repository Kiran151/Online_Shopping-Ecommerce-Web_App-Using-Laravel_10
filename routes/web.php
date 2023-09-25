<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\BannerController;
use App\Http\Controllers\Backend\BlogController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\CouponController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\ReportsController;
use App\Http\Controllers\Backend\ReturnController;
use App\Http\Controllers\Backend\ShippingAreaController;
use App\Http\Controllers\Backend\SiteSettingController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\SubCategoryController;
use App\Http\Controllers\Backend\VendorOrderController;
use App\Http\Controllers\Backend\VendorProductController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\CompareController;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Frontend\PaypalController;
use App\Http\Controllers\Frontend\PhonePayController;
use App\Http\Controllers\Frontend\ReviewController;
use App\Http\Controllers\Frontend\StripeController;
use App\Http\Controllers\Frontend\UserOrderController;
use App\Http\Controllers\Frontend\WishListController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorController;
use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('frontend.index');
});

Route::get('index', [IndexController::class, 'index'])->name('index');

Route::middleware(['auth'])->group(function () {
    Route::controller(UserController::class)->group(function () {
        Route::get('user/account', 'userDashboard')->name('user.dashboard');
        Route::get('user/logout', 'userLogout')->name('user.logout');
        Route::post('user/update', 'userUpdate')->name('update.user.profile');
        Route::post('user/update/password', 'userUpdatePassword')->name('user.change.password');
    });


});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Admin Controllers
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::controller(AdminController::class)->group(function () {
        Route::get('admin/dashboard', 'adminDashboard')->name('admin.dashboard');
        Route::get('admin/logout', 'adminLogout')->name('admin.logout');
        Route::get('admin/profile', 'adminProfile')->name('admin.profile');
        Route::post('admin/update', 'adminUpdate')->name('update.profile');
        Route::get('admin/change_password', 'adminChangePassword')->name('admin.change.password');
        Route::post('admin/update/password', 'adminUpdatePassword')->name('change.password');

        //vendor acive inactive routes
        Route::get('admin/vendors', 'allVendors')->name('vendors');
        Route::get('admin/active_vendor/{id}', 'activeVendor')->name('active.vendor');
        Route::get('admin/inactive_vendor/{id}', 'inactiveVendor')->name('inactive.vendor');

        //users
        Route::get('admin/users', 'allUsers')->name('users');
        Route::get('admin/active/{id}', 'activeUser')->name('active.user');
        Route::get('admin/inactive/{id}', 'inactiveUser')->name('inactive.user');

        //Graph
        Route::get('admin/order/graph', 'getOrderGraph')->name('load_order_graph');
        //notification
        Route::get('admin/notifications/read/', 'markAsRead')->name('notification.read');






    });







});


//Vendor Controllers
Route::middleware(['auth', 'role:vendor'])->group(function () {
    Route::controller(VendorController::class)->group(function () {
        Route::get('vendor/dashboard', 'vendorDashboard')->name('vendor.dashboard');
        Route::get('vendor/logout', 'vendorLogout')->name('vendor.logout');
        Route::get('vendor/profile', 'vendorProfile')->name('vendor.profile');
        Route::post('vendor/update', 'vendorUpdate')->name('update.profile');
        Route::get('vendor/change_password', 'vendorChangePassword')->name('vendor.change.password');
        Route::post('vendor/update/password', 'vendorUpdatePassword')->name('change.password');

    });


    //Vendor product Controllers
    Route::controller(VendorProductController::class)->group(function () {
        Route::get('vendor/products/all', 'vendorAllProducts')->name('vendor.all.products');
        Route::get('vendor/products/add/{id?}', 'vendorAddProduct')->name('vendor.add.product');
        Route::get('admin/getSubcategoryAjax', 'getVendorSubcategoryAjax')->name('getvendorSubcategoryAjax');
        Route::post('vendor/product/save/{id?}', 'vendorSaveProduct')->name('vendor.save.product');
        Route::get('vendor/edit/product_images/{id}', 'editProductImages')->name('edit.vendor.multi.images');
        Route::post('vendor/update/product_images', 'updateProductImages')->name('update.vendor.product_images');
        Route::get('vendor/delete/product_image/{id}', 'deleteProductImage')->name('delete.vendor.productImage');
        Route::get('delete/product/{id}', 'deleteProduct')->name('delete.vendor.product');
        Route::get('vendor/active_inactive/product/{id}', 'vendorActiveInactiveProduct')->name('active.inactive.product');

    });

    //Vendor orders
    Route::controller(VendorOrderController::class)->group(function () {
        Route::get('vendor/orders/all', 'vendorAllOrders')->name('vendor.orders');
        Route::get('vendor/orders/details/{id}', 'vendorOrderDetails')->name('vendor.order.details');
        Route::get('vendor/orders/return', 'vendorOrderReturn')->name('vendor.return.orders');
        Route::get('vendor/order/invoice/{id?}', 'vendorOrderInvoice')->name('print_vendor.order.invoice');




    });
    //Vendor Review
    Route::controller(ReviewController::class)->group(function () {
        Route::get('vendor/all_reviews', 'vendorAllReviews')->name('vendor.reviews');
        Route::get('vendor/review/detail/{id}', 'reviewDetailAjax');





    });








});

//All Login
Route::get('admin/login', [AdminController::class, 'adminLogin'])->name('admin.login')->middleware(RedirectIfAuthenticated::class);
Route::get('vendor/login', [VendorController::class, 'vendorLogin'])->name('vendor.login')->middleware(RedirectIfAuthenticated::class);
Route::get('user/login', [UserController::class, 'userLogin'])->name('user.login')->middleware(RedirectIfAuthenticated::class);
Route::get('user/register', [UserController::class, 'userRegister'])->name('user.register');

//Admin routes
Route::middleware(['auth', 'role:admin'])->group(function () {

    //Brand 
    Route::controller(BrandController::class)->group(function () {
        Route::get('brands/all', 'allBrands')->name('brands');
        Route::get('brands/add/{id?}', 'addBrand')->name('add.brand');
        Route::post('brand/save/{id?}', 'saveBrand')->name('save.brand');
        Route::get('brands/delete/{id}', 'deleteBrand')->name('delete.brand');
    });

    //category
    Route::controller(CategoryController::class)->group(function () {
        Route::get('categories/all', 'allCategories')->name('categories');
        Route::get('category/add/{id?}', 'addCategory')->name('add.category');
        Route::post('category/save/{id?}', 'saveCategory')->name('save.Category');
        Route::get('category/delete/{id}', 'deleteCategory')->name('delete.category');

    });

    //subcategory
    Route::controller(SubCategoryController::class)->group(function () {
        Route::get('subcategories/all', 'allSubCategories')->name('subcategories');
        Route::get('subcategory/add/{id?}', 'addSubCategory')->name('add.subcategory');
        Route::post('subcategory/save/{id?}', 'saveSubCategory')->name('save.SubCategory');
        Route::get('subcategory/delete/{id}', 'deleteSubCategory')->name('delete.subcategory');





    });

    //products
    Route::controller(ProductController::class)->group(function () {
        Route::get('admin/all_products', 'allProducts')->name('products');
        Route::get('admin/add_product/{id?}', 'addProduct')->name('add.product');
        Route::get('admin/getSubcategoryAjax', 'getSubcategoryAjax')->name('getSubcategoryAjax');
        Route::post('save/product/{id?}', 'saveProduct')->name('save.product');
        Route::get('delete/product/{id}', 'deleteProduct')->name('delete.product');
        Route::get('edit/product_images/{id}', 'editProductImages')->name('edit.multi.images');
        Route::post('update/product_images', 'updateProductImages')->name('update.product_images');
        Route::get('delete/product_image/{id}', 'deleteProductImage')->name('delete.productImage');
        Route::get('admin/active_inactive/product/{id}', 'adminActiveInactiveProduct')->name('active.inactive.product');
        Route::get('admin/product/sort/{option}', 'productSortAjax');
        //Stock Manage
        Route::get('admin/product/stock', 'productStock')->name('product.stock');



    });

    //Slider
    Route::controller(SliderController::class)->group(function () {
        Route::get('admin/all_sliders', 'allSliders')->name('sliders');
        Route::get('admin/add_slider/{id?}', 'addSlider')->name('add.slider');
        Route::post('admin/slider/save/{id?}', 'saveSlider')->name('save.slider');
        Route::get('admin/slider/delete/{id}', 'deleteSlider')->name('delete.slider');





    });
    //Banner
    Route::controller(BannerController::class)->group(function () {
        Route::get('admin/all_banners', 'allbanners')->name('banners');
        Route::get('admin/add_banner/{id?}', 'addBanner')->name('add.banner');
        Route::post('admin/banner/save/{id?}', 'saveBanner')->name('save.banner');
        Route::get('admin/banner/delete/{id}', 'deleteBanner')->name('delete.banner');



    });
    //Coupon
    Route::controller(CouponController::class)->group(function () {
        Route::get('admin/all_coupons', 'allCoupons')->name('coupons');
        Route::get('admin/add_coupon/{id?}', 'addCoupon')->name('add.coupon');
        Route::post('admin/save_coupon/{id?}', 'saveCoupon')->name('save.coupon');
        Route::get('admin/delete_coupon/{id}', 'deleteCoupon')->name('delete.coupon');



    });

    //Shipping
    Route::controller(ShippingAreaController::class)->group(function () {

        //Divisions
        Route::get('admin/all_divisions', 'allDivisions')->name('all.divisions');
        Route::get('admin/add_division/{id?}', 'addDivision')->name('add.division');
        Route::post('admin/save_division/{id?}', 'saveDivision')->name('save.division');
        Route::get('admin/delete_division/{id}', 'deleteDivision')->name('delete.division');

        //Districts
        Route::get('admin/all_districts', 'allDistricts')->name('all.districts');
        Route::get('admin/add_district/{id?}', 'addDistrict')->name('add.district');
        Route::post('admin/save_district/{id?}', 'saveDistrict')->name('save.district');
        Route::get('admin/delete_district/{id}', 'deleteDistrict')->name('delete.district');

        //States
        Route::get('admin/all_states', 'allStates')->name('all.states');
        Route::get('admin/add_state/{id?}', 'addState')->name('add.state');
        Route::post('admin/save_state/{id?}', 'saveState')->name('save.state');
        Route::get('admin/getDistrictAjax', 'getDistrictAjax')->name('getDistrictAjax');
        Route::get('admin/delete_state/{id}', 'deleteState')->name('delete.state');





    });


    //Orders
    Route::controller(OrderController::class)->group(function () {
        Route::get('admin/all_orders', 'allOrders')->name('orders');
        Route::get('admin/order/details/{id}', 'orderDetails')->name('admin.order.details');
        Route::get('admin/order/change_status/{id}', 'changeOrderStatus')->name('change.order.status');
        Route::get('admin/order/invoice/{id?}', 'adminOrderInvoice')->name('print_admin.order.invoice');
        Route::get('admin/order/sort_by_date', 'orderSortDate')->name('order.sort.date');



    });

    //Return Orders
    Route::controller(ReturnController::class)->group(function () {
        // Route::get('admin/all_orders', 'allOrders')->name('orders');
        Route::get('admin/return_orders', 'returnOrders')->name('return.orders');
        Route::get('admin/confirm_return/{id}', 'confirmReturn');



    });

    //Reports
    Route::controller(ReportsController::class)->group(function () {
        Route::get('admin/reports', 'reports')->name('reports');
        Route::post('admin/reports/search_by_date', 'searchByDate')->name('search.date');
        Route::post('admin/reports/search_by_month', 'searchByMonth')->name('search.month');
        Route::post('admin/reports/search_by_year', 'searchByYear')->name('search.year');

    });
    //Blogs
    Route::controller(BlogController::class)->group(function () {
        Route::get('admin/blogs', 'blogs')->name('blogs');
        Route::get('admin/blog_categories', 'allBlogCategory')->name('all.blog.category');
        Route::get('admin/blog_category/add/{id?}', 'addBlogCategory')->name('add.blog.category');
        Route::post('admin/blog_category/save/{id?}', 'saveBlogCategory')->name('save.blog.category');
        Route::get('admin/blog/add/{id?}', 'addBlog')->name('add.blog');
        Route::get('admin/blog_category/delete/{id}', 'deleteBlogCategory')->name('delete.blog.category');
        Route::post('admin/blog/save/{id?}', 'saveBlog')->name('save.blog');
        Route::get('admin/blog/delete/{id}', 'deleteBlog')->name('delete.blog');


    });

    //Reviews
    Route::controller(ReviewController::class)->group(function () {
        Route::get('admin/all_reviews', 'allReviews')->name('all.reviews');
        Route::get('admin/active_inactive/review/{id}', 'activeInactiveReview')->name('active.inactive.review');
        Route::get('admin/review/delete/{id}', 'deleteReview')->name('delete.review');



    });

    //Seo
    Route::controller(SiteSettingController::class)->group(function () {
        Route::get('admin/seo/settings', 'seoSetting')->name('seo');
        Route::post('admin/seo/save/{id}', 'saveSeo')->name('save.seo');


    });















});

//Become Vendor Controllers
Route::controller(VendorController::class)->group(function () {
    Route::get('become_vendor/', 'becomeVendor')->name('become.vendor');
    Route::post('vendor/register', 'registerVendor')->name('vendor.register');



});

//Frontend
Route::controller(IndexController::class)->group(function () {
    Route::get('product/details/{id}/{slug}', 'productDetails');
    Route::get('vendor/details/{id}', 'vendorDetails')->name('vendor_detail');
    Route::get('vendor/all/', 'vendorAll')->name('vendor.all');
    Route::get('products/category/{id}/{slug}', 'categoryWiseProducts');
    Route::get('products/subcategory/{id}/{slug}', 'subcategoryWiseProducts');
    Route::get('modal/ajax/', 'modalAjax')->name('modal.ajax');

});

//Add To Cart
Route::post('cart/data/store/{id}', [CartController::class, 'addToCart']);
Route::post('cart/data/save/{id}', [CartController::class, 'addToCart1']);

//Get Mini Cart data
Route::get('products/mini_cart/all', [CartController::class, 'getMiniCart']);
Route::get('mini_cart/remove/{id}', [CartController::class, 'miniCartRemove']);
//Add To Wishlist
Route::post('add_to_wishlist/{id}', [WishListController::class, 'addToWishlist']);


//user routes
Route::middleware(['auth', 'role:user'])->group(function () {

    Route::controller(WishListController::class)->group(function () {
        Route::get('wishlist', 'allWishlist')->name('wishlist');
        Route::get('remove_wishlist/{id}', 'removeWishlist');
        Route::get('get_wishlist', 'getWishlist');


    });

    Route::controller(CompareController::class)->group(function () {
        Route::post('add_to_compare/{id}', 'addToCompare');
        Route::get('compare', 'allCompare')->name('compare');
        Route::get('get_compare', 'getCompare');
        Route::get('remove/compare/{id}', 'removeCompare')->name('removeCompare');


    });

    Route::controller(CartController::class)->group(function () {
        Route::get('mycart', 'myCart')->name('mycart');
        Route::get('clear_cart', 'clearCart')->name('clear-cart');
        Route::get('cart/cart_increment/{id}', 'cartIncrement');
        Route::get('cart/cart_decrement/{id}', 'cartDecrement');
        Route::post('apply_coupon', 'applyCoupon');
        Route::get('coupon_calcultion', 'couponCalc');
        Route::get('remove_coupon', 'couponRemove');
        Route::get('cart/checkout_page', 'checkoutPage')->name('checkout');


    });

    Route::controller(CheckoutController::class)->group(function () {
        Route::get('user/getDistrictAjax', 'getDistrictAjax')->name('getDistrictAjax');
        Route::get('user/getStateAjax', 'getStateAjax')->name('getStateAjax');
        Route::post('user/checkout/save', 'checkoutSave')->name('checkout.save');


    });

    Route::controller(StripeController::class)->group(function () {
        Route::post('user/checkout/stripe_payment', 'stripePayment')->name('stripe.payment');
        Route::post('user/checkout/cash_on_delivery', 'cashPayment')->name('cash.payment');



    });

    // Route::controller(PaypalController::class)->group(function () {
    //     Route::post('user/checkout/paypal_payment', 'paypalPayment')->name('paypal.payment');




    // });
   

    Route::controller(UserOrderController::class)->group(function () {
        Route::get('user/orders/view/{id}', 'orderView')->name('order.view');
        Route::get('user/orders/invoice/{id}', 'orderInvoice')->name('order.invoice');
        Route::post('user/order/return/{id}', 'orderReturn')->name('order.return');
        Route::post('user/order/tracking', 'orderTracking')->name('order.track');






    });

    //Blogs
    Route::controller(BlogController::class)->group(function () {
        Route::get('home/blogs', 'blogsPage')->name('frontend.blogs');
        Route::get('blogs/{id}', 'categoryblogPage');



    });
    //Review
    Route::controller(ReviewController::class)->group(function () {
        Route::post('home/product/save_review', 'saveReview')->name('review');



    });



});

Route::controller(PhonePayController::class)->group(function () {
    Route::post('user/checkout/phonepe_payment', 'phonepePayment')->name('phonepe.payment');
    Route::any('phonepe-response', 'phonePeResponse')->name('phonepe.response');





});

//product search
Route::controller(IndexController::class)->group(function () {
    Route::get('home/product/search', 'productSearch')->name('product.search');

});


require __DIR__ . '/auth.php';