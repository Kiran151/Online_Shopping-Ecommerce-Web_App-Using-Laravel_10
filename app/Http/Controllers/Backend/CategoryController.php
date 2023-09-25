<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;


class CategoryController extends Controller
{
    public function allCategories()
    {
        $data = Category::latest()->get();
        return view('admin.category.all_category', compact('data'));
    }

    public function addCategory($id = 0)
    {
        if ($id > 0) {
            $data = Category::findOrFail($id);
            return view('admin.category.add_category', compact('data'));

        }
        return view('admin.category.add_category');
    }

    public function saveCategory(Request $request, $id = 0)
    {
        $image = $request->file('image');
        if ($id > 0) {
            $data = Category::findOrFail($id);

            if ($image) {
                if ($data->category_image) {
                    unlink('uploads/backend/category/' . $data->category_image);

                }
                $fileName = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
                $img = new ImageManager();
                $img->make($image)->resize(120, 120)->save('uploads/backend/category/' . $fileName);
                $data->update([
                    'category_name' => $request->name,
                    'category_slug' => strtolower(str_replace(' ', '-', $request->name)),
                    'category_image' => $fileName,
                ]);
            } else {

                $data->update([
                    'category_name' => $request->name,
                    'category_slug' => strtolower(str_replace(' ', '-', $request->name)),
                ]);
            }
        } else {
            if ($image) {
                $fileName = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
                // $image->move(public_path('uploads/backend/category'), $fileName);
                $img = new ImageManager();
                $img->make($image)->resize(120, 120)->save('uploads/backend/category/' . $fileName);
                Category::insert([
                    'category_name' => $request->name,
                    'category_slug' => strtolower(str_replace(' ', '-', $request->name)),
                    'category_image' => $fileName,
                    'created_at' => date('Y-m-d')
                ]);
            } else {
                Category::insert([
                    'category_name' => $request->name,
                    'category_slug' => strtolower(str_replace(' ', '-', $request->name)),
                    'category_image' => '',
                    'created_at' => date('Y-m-d')
                ]);
            }


        }
        if ($request->remove_img == 1) {
            unlink('uploads/backend/category/' . $data->category_image);
            $data->update([
                'category_image' => '',
            ]);
        }

        $notification = array(
            'message' => 'Category Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect('categories/all')->with($notification);
    }

    public function deleteCategory($id)
    {

        $data = Category::findOrFail($id);
        if ($data->category_image) {
            unlink('uploads/backend/category/' . $data->category_image);
        }
        $data->delete();

        $subCategory = SubCategory::where('category_id', $id)->get();
        foreach ($subCategory as $item) {
            SubCategory::findOrFail($item->id)->delete();
        }


        $notification = array(
            'message' => 'Category Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect('categories/all')->with($notification);

    }
}