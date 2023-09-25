<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function allSubCategories()
    {
        $data = SubCategory::latest()->get();
        return view('admin.subcategory.all_subcategory', compact('data'));
    }

    public function addSubCategory($id = 0)
    {
        if ($id > 0) {
            $data = SubCategory::findOrFail($id);
            $category = $data->category_id;
            $categories = Category::orderBy('category_name', 'ASC')->get();
            return view('admin.subcategory.add_subcategory', compact('categories', 'data', 'category'));

        }
        $categories = Category::orderBy('category_name', 'ASC')->get();
        return view('admin.subcategory.add_subcategory', compact('categories'));
    }

    public function saveSubCategory(Request $request, $id = 0)
    {

        if ($id > 0) {
            SubCategory::findOrFail($id)->update([
                'category_id' => $request->category_id,
                'subcategory_name' => $request->subcategory,
                'subcategory_slug' => strtolower(str_replace(' ', '-', $request->subcategory)),
            ]);
        } else {
            SubCategory::insert([
                'category_id' => $request->category_id,
                'subcategory_name' => $request->subcategory,
                'subcategory_slug' => strtolower(str_replace(' ', '-', $request->subcategory)),
                'created_at' => date('Y-m-d')
            ]);
        }


        $notification = array(
            'message' => 'SubCategory Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect('subcategories/all')->with($notification);
    }

    public function deleteSubCategory($id)
    {
        SubCategory::findOrFail($id)->delete();
        $notification = array(
            'message' => 'SubCategory Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect('subcategories/all')->with($notification);
    }
}