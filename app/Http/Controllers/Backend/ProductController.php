<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\OrderItems;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;

class ProductController extends Controller
{
   public function allProducts()
   {
      $data = Product::latest()->get();
      return view('admin.product.all_products', compact('data'));
   }

   public function addProduct($id = 0)
   {
      if ($id > 0) {
         $brands = Brand::latest()->get();
         $categories = Category::latest()->get();
         $vendors = User::where('role', 'vendor')
            ->where('status', 'active')
            ->get();
         $data = Product::findOrFail($id);
         return view('admin.product.add_product', compact('brands', 'categories', 'vendors', 'data'));

      } else {
         $brands = Brand::latest()->get();
         $categories = Category::latest()->get();
         $vendors = User::where('role', 'vendor')
            ->where('status', 'active')
            ->get();

         return view('admin.product.add_product', compact('brands', 'categories', 'vendors'));
      }

   }

   public function getSubcategoryAjax(Request $request)
   {
      $category_id = $request->category_id;
      $subcategories = SubCategory::where('category_id', $category_id)->get();

      return $subcategories;
   }

   public function saveProduct(Request $request, $product_id = 0)
   {
      try {
         if ($product_id > 0) {
            $this->updateProduct($request, $product_id);
         } else {
            $image = $request->file('image');
            $fileName = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img = new ImageManager();
            $img->make($image)->resize(800, 800)->save('uploads/backend/product/thumbnail/' . $fileName);
            $product_id = Product::insertGetId([
               'product_name' => $request->product_name,
               'product_size' => $request->product_size,
               'product_color' => $request->product_color,
               'product_tags' => $request->product_tags,
               'short_description' => $request->short_description,
               'long_description' => $request->long_description,
               'thumbnail_image' => $fileName,
               'selling_price' => $request->selling_price,
               'discount_price' => $request->discount_price,
               'product_code' => $request->product_code,
               'product_qty' => $request->product_qty,
               'product_slug' => strtolower(str_replace(' ', '-', $request->product_name)),
               'brand_id' => $request->brand_id,
               'category_id' => $request->category_id,
               'subcategory_id' => $request->subcategory_id,
               'vendor_id' => $request->vendor_id,
               'hot_deals' => $request->hot_deals,
               'featured' => $request->featured,
               'special_offer' => $request->special_offer,
               'special_deals' => $request->special_deals,
               'status' => 'active',
               'created_at' => date('Y-m-d')


            ]);
         }


         if ($request->file('multi_img')) {
            $this->insertProductImages($product_id, $request->file('multi_img'));
         }
      } catch (\Exception $e) {
      }

      $notification = array(
         'message' => 'Product Updated Successfully',
         'alert-type' => 'success'
      );

      return redirect('admin/all_products')->with($notification);
   }


   public function insertProductImages($product_id, $images = array())
   {

      if ($images) {
         foreach ($images as $image) {
            $fileName = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img = new ImageManager();
            $img->make($image)->resize(1100, 1100)->save('uploads/backend/product/' . $fileName);
            ProductImage::insert([
               'image' => $fileName,
               'product_id' => $product_id,
               'created_at' => date('Y-m-d')
            ]);
         }
      }
   }

   public function updateProduct($request, $product_id)
   {

      $image = $request->file('image');

      $data = Product::findOrFail($product_id);
      $fileName = $data->thumbnail_image ?: '';
      if ($image) {
         $fileName = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
         $img = new ImageManager();
         $img->make($image)->resize(800, 800)->save('uploads/backend/product/thumbnail/' . $fileName);
         unlink('uploads/backend/product/thumbnail/' . $data->thumbnail_image);
      }

      Product::findOrFail($product_id)->update([
         'product_name' => $request->product_name,
         'product_size' => $request->product_size,
         'product_color' => $request->product_color,
         'product_tags' => $request->product_tags,
         'short_description' => $request->short_description,
         'long_description' => $request->long_description,
         'thumbnail_image' => $fileName,
         'selling_price' => $request->selling_price,
         'discount_price' => $request->discount_price,
         'product_code' => $request->product_code,
         'product_qty' => $request->product_qty,
         'product_slug' => strtolower(str_replace(' ', '-', $request->product_name)),
         'brand_id' => $request->brand_id,
         'category_id' => $request->category_id,
         'subcategory_id' => $request->subcategory_id,
         'vendor_id' => $request->vendor_id,
         'hot_deals' => $request->hot_deals,
         'featured' => $request->featured,
         'special_offer' => $request->special_offer,
         'special_deals' => $request->special_deals,
         'status' => 'active',


      ]);
      $notification = array(
         'message' => 'Product Updated Successfully',
         'alert-type' => 'success'
      );

      return redirect('admin/all_products')->with($notification);
   }

   public function editProductImages($id)
   {
      $data = ProductImage::where('product_id', $id)->get();
      $product = Product::findOrFail($id);
      return view('admin.product.edit_product_images', compact('data', 'product'));
   }
   public function updateProductImages(Request $request)
   {

      $image = $request->file('img');
      if ($image) {
         foreach ($image as $id => $img) {
            $data = ProductImage::findOrFail($id);
            unlink('uploads/backend/product/' . $data->image);
            $fileName = hexdec(uniqid()) . '.' . $img->getClientOriginalExtension();
            $imge = new ImageManager();
            $imge->make($img)->resize(1100, 1100)->save('uploads/backend/product/' . $fileName);
            $data->update([
               'image' => $fileName
            ]);

         }
      }
      $images = $request->file('new_imgs');
      if ($images) {
         foreach ($images as $img) {
            $fileName = hexdec(uniqid()) . '.' . $img->getClientOriginalExtension();
            $imge = new ImageManager();
            $imge->make($img)->resize(400, 400)->save('uploads/backend/product/' . $fileName);
            $product_id = $request->product_id;
            ProductImage::insert([
               'image' => $fileName,
               'product_id' => $product_id,
               'created_at' => date('Y-m-d')
            ]);
         }
      }
      $notification = array(
         'message' => 'Product Image Updated Successfully',
         'alert-type' => 'success'
      );

      return back()->with($notification);


   }


   public function deleteProductImage($id)
   {
      $data = ProductImage::findOrFail($id);
      unlink('uploads/backend/product/' . $data->image);
      $data->delete();
      $notification = array(
         'message' => 'Product Image Updated Successfully',
         'alert-type' => 'success'
      );

      return back()->with($notification);

   }

   public function deleteProduct($id)
   {
      $data = Product::findOrFail($id);
      $product_images = ProductImage::where('product_id', $id)->get();
      unlink('uploads/backend/product/thumbnail/' . $data->thumbnail_image);

      foreach ($product_images as $item) {
         unlink('uploads/backend/product/' . $item->image);
      }

      $data->delete();
      ProductImage::where('product_id', $id)->delete();
      $notification = array(
         'message' => 'Product Deleted Successfully',
         'alert-type' => 'success'
      );

      return back()->with($notification);

   }

   public function adminActiveInactiveProduct($id)
   {
      $product = Product::findOrFail($id);
      if ($product->status == 'active') {
         $product->update([
            'status' => 'inactive'
         ]);
      } else {
         $product->update([
            'status' => 'active'
         ]);
      }

      $notification = array(
         'message' => 'Product Updated Successfully',
         'alert-type' => 'success'
      );

      return back()->with($notification);

   }
   public function get_product_sort_data($option){
      if($option=='low_high'){
         $data=Product::orderBy('selling_price','ASC')->get();
         return $data;
      }elseif ($option=='high_low') {
         $data=Product::orderBy('selling_price','DESC')->get();
         return $data;
      }elseif ($option=='popular') {
         $popularProducts = Product::withCount('orders')
    ->orderByDesc('orders_count')
    ->get();
    return $popularProducts;
      }else{
         $data=Product::orderBy('id','ASC')->get();
         return $data;
      }
   }

   public function productSortAjax($option)
   {

      if ($option !=='') {

         $data = $this->get_product_sort_data($option);
         $html = '';
         foreach ($data as $key => $item) {
            $amount = $item->selling_price - $item->discount_price;
            $discount = ($amount / $item->selling_price) * 100;
            //image
            if ($item->thumbnail_image) {
               $product_image = url('uploads/backend/product/thumbnail/' . $item->thumbnail_image);
            } else {
               $product_image = url('uploads/img/no_image.jpg');
            }
            //status
            if ($item->status == 'active') {
               $status_color = ' bg-light-success text-success';
               $status_name = 'Active';
            } else {
               $status_color = 'bg-light-danger text-danger';
               $status_name = 'Inactive';
            }

            //discount
            if ($item->discount_price) {
               $discount = round($discount) . '%';
            } else {
               $discount = 'No discount';
            }




            $html .= '<tr>';
            $html .= '<td>' . $key + '1' . '</td>';
            $html .= '<td>
            <div class="d-flex align-items-center">
            <div class="recent-product-img">
                <img src="' . $product_image . ' "
                    alt="">
            </div>
            <div class="ms-2">
                <h6 class="mb-1 font-14">' . $item->product_name . '</h6>
            </div>
        </div>
        </td>';
            $html .= '<td>' . $item->selling_price . '</td>';

            $html .= '<td><span
            class="badge bg-primary badge-primary">' . $discount . '</span></td>';
            $html .= '<td>' . $item->product_qty . '</td>';
            $html .= ' <td><span
            class="badge rounded-pill ' . $status_color . '">' . $status_name . '</span></td>';
            $html .= '<td>
            <div class="d-flex order-actions">
                <a href="' . route('add.product', $item->id) . '"
                    class="bg-warning"><i class="lni lni-eye fs-5"></i></a>
                <a href="' . route('add.product', $item->id) . '"
                    class="bg-primary ms-2"><i
                        class="text-white bx bxs-edit"></i></a>
                <a href="' . route('delete.product', $item->id) . '" id="delete"
                    class="ms-2 bg-danger"><i class="bx bxs-trash"></i></a>
               

            </div>
        </td>';

            $html .= '</tr>';
         }
         return $html;


      }


   }

   public function productStock(){

      $data=Product::latest()->get();

      return view('admin.product.product_stocks',compact('data'));
   }

}