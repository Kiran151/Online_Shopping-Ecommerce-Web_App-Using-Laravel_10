<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;

class BrandController extends Controller
{
    public function allBrands()
    {
        $data = Brand::all();
        return view('admin.brand.all_brands', compact('data'));
    }

    public function addBrand($id = 0)
    {
        if ($id > 0) {
            $data = Brand::findOrFail($id);
            return view('admin.brand.add_brands', compact('data'));

        }

        return view('admin.brand.add_brands');
    }

    public function saveBrand(Request $request, $id = 0)
    {

        $image = $request->file('image');
        if ($id > 0) {
            $data = Brand::findOrFail($id);
            if ($image) {
                $fileName = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
                $img = new ImageManager();
                $img->make($image)->resize(300, 300)->save('uploads/backend/brand/' . $fileName);
                $data->update([
                    'brand_name' => $request->name,
                    'brand_slug' => strtolower(str_replace(' ', '-', $request->name)),
                    'brand_image' => $fileName,
                ]);
            } else {

                $data->update([
                    'brand_name' => $request->name,
                    'brand_slug' => strtolower(str_replace(' ', '-', $request->name)),
                ]);
            }
        } else {
            if ($image) {
                $fileName = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
                // $image->move(public_path('uploads/backend/brand'), $fileName);
                $img = new ImageManager();
                $img->make($image)->resize(300, 300)->save('uploads/backend/brand/' . $fileName);
                Brand::insert([
                    'brand_name' => $request->name,
                    'brand_slug' => strtolower(str_replace(' ', '-', $request->name)),
                    'brand_image' => $fileName,
                    'created_at' => date('Y-m-d')
                ]);
            } else {
                Brand::insert([
                    'brand_name' => $request->name,
                    'brand_slug' => strtolower(str_replace(' ', '-', $request->name)),
                    'brand_image' => '',
                    'created_at' => date('Y-m-d')
                ]);
            }


        }
        if ($request->remove_img == 1) {
            unlink('uploads/backend/brand/' . $data->brand_image);
            $data->update([
                'brand_image' => '',
            ]);
        }

        $notification = array(
            'message' => 'Brand Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect('brands/all')->with($notification);
    }

    public function deleteBrand($id)
    {
        $data = Brand::findOrFail($id);
        if ($data->brand_image) {
            unlink('uploads/backend/brand/' . $data->brand_image);
        }
        $data->delete();
        $notification = array(
            'message' => 'Brand Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect('brands/all')->with($notification);

    }

    
}