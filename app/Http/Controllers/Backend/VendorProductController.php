<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;

class VendorProductController extends Controller
{
    public function vendorAllProducts()
    {

        $id = Auth::user()->id;
        $data = Product::where('vendor_id', $id)->latest()->get();
        return view('vendor.product.all_products', compact('data'));
    }

    public function vendorAddProduct($id = 0)
    {
        if ($id > 0) {
            $brands = Brand::latest()->get();
            $categories = Category::latest()->get();
            $data = Product::findOrFail($id);
            return view('vendor.product.add_product', compact('brands', 'categories', 'data'));

        } else {
            $brands = Brand::latest()->get();
            $categories = Category::latest()->get();
            return view('vendor.product.add_product', compact('brands', 'categories'));
        }
    }

    public function getVendorSubcategoryAjax(Request $request)
    {
        $category_id = $request->category_id;
        $subcategories = SubCategory::where('category_id', $category_id)->get();

        return $subcategories;
    }

    public function vendorSaveProduct(Request $request, $product_id = 0)
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
                    'vendor_id' => Auth::user()->id,
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

        return redirect('vendor/products/all')->with($notification);
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
            'vendor_id' => Auth::user()->id,
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

        return redirect('vendor/products/all')->with($notification);
    }

    public function insertProductImages($product_id, $images = array())
    {

        if ($images) {
            foreach ($images as $image) {
                $fileName = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
                $img = new ImageManager();
                $img->make($image)->resize(400, 400)->save('uploads/backend/product/' . $fileName);
                ProductImage::insert([
                    'image' => $fileName,
                    'product_id' => $product_id,
                    'created_at' => date('Y-m-d')
                ]);
            }
        }
    }

    public function editProductImages($id)
    {
        $data = ProductImage::where('product_id', $id)->get();
        $product = Product::findOrFail($id);
        return view('vendor.product.edit_product_images', compact('data', 'product'));
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
                $imge->make($img)->resize(400, 400)->save('uploads/backend/product/' . $fileName);
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

    public function vendorActiveInactiveProduct($id)
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


}