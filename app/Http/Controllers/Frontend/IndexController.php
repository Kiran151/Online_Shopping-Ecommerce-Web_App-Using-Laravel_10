<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Review;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index()
    {
        return view('frontend.index');
    }
    public function productDetails($id, $slug)
    {
        $data = Product::findOrFail($id);
        $category = Category::where('id', $data->category_id)->first();
        $productImages = ProductImage::where('product_id', $id)->get();
        $related_products = Product::where('category_id', $data->category_id)->limit(4)->get();
         //rating pct
        $total_ratings=Review::where('product_id',$id)->where('rating','!=','')->count();
       if ($total_ratings>0) {
        $rating_pct['five_star']=Review::where('product_id',$id)->where('rating',5)->count()/$total_ratings*100;
        $rating_pct['four_star']=Review::where('product_id',$id)->where('rating',4)->count()/$total_ratings*100;
        $rating_pct['three_star']=Review::where('product_id',$id)->where('rating',3)->count()/$total_ratings*100;
        $rating_pct['two_star']=Review::where('product_id',$id)->where('rating',2)->count()/$total_ratings*100;
        $rating_pct['one_star']=Review::where('product_id',$id)->where('rating',1)->count()/$total_ratings*100;
       }else{
        $rating_pct=null;
       }
        //avg rating
        $avg_rating=Review::where('product_id',$id)->avg('rating');
        $avg_rating_pct=($avg_rating/5)*100;

       if (Auth::check()) {
        $user_review=Review::where([['product_id',$id],['user_id',Auth::user()->id]])->first();
       }else{
        $user_review=null;
       }
        





        return view('frontend.product.product_details', compact('data', 'category', 'productImages', 'related_products','rating_pct','avg_rating','avg_rating_pct','total_ratings','user_review'));
    }
    public function vendorDetails($id)
    {
        $data = User::findOrFail($id);
        $products = Product::where('vendor_id', $id)->where('status', 'active')->get();
        return view('frontend.vendor.vendor_details', compact('data', 'products'));
    }

    public function vendorAll()
    {
        $vendors = User::where([['role', 'vendor'], ['status', 'active']])->paginate(8);

        return view('frontend.vendor.vendor_all', compact('vendors'));

    }

    public function categoryWiseProducts($id, $slug)
    {

        $products = Product::where([['category_id', $id], ['status', 'active']])->get();
        $category_name = Category::where('id', $id)->pluck('category_name')->first();
        $new_products = Product::orderBy('id', 'DESC')->where('category_id', $id)->limit(3)->get();
        return view('frontend.category.category_products', compact('products', 'category_name', 'new_products'));
    }

    public function subcategoryWiseProducts($id, $slug)
    {

        $products = Product::where([['subcategory_id', $id], ['status', 'active']])->get();
        $category_name = SubCategory::where('id', $id)->pluck('subcategory_name')->first();
        $new_products = Product::orderBy('id', 'DESC')->where('subcategory_id', $id)->limit(3)->get();
        return view('frontend.category.category_products', compact('products', 'category_name', 'new_products'));

    }

    public function modalAjax(Request $request)
    {
        $id = $request->id;
        $products = Product::with('category', 'brand', 'vendor')->findOrFail($id);
        $images = ProductImage::where('product_id', $id)->get();
        $data['products'] = $products;
        $data['image'] = $images;
        $amount = $products->selling_price - $products->discount_price;
        $discount = ($amount / $products->selling_price) * 100;
        $data['discount'] = 100 - round($discount);
        $colors = $products->product_color;
        $data['colors'] = explode(',', $colors);
        $sizes = $products->product_size;
        $data['sizes'] = explode(',', $sizes);
        $tags = $products->product_size;
        $data['tags'] = explode(',', $tags);


        return $data;
    }


    public function productSearch(Request $request){

        $product_name=$request->keyword;
        $products=Product::where('product_name','LIKE','%'.$product_name.'%')->limit(8)->get();

        return $products;
    }
}