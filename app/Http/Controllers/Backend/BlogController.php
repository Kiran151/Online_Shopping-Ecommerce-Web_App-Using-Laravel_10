<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;

class BlogController extends Controller
{
    public function allBlogCategory()
    {

        $data = BlogCategory::all();

        return view('admin.blog.all_blog_categories', compact('data'));
    }


    public function addBlogCategory($id = 0)
    {

        if ($id > 0) {
            $data = BlogCategory::findOrFail($id);
            return view('admin.blog.add_blog_category', compact('data'));
        } else {
            return view('admin.blog.add_blog_category');
        }
    }


    public function saveBlogCategory(Request $request, $id = 0)
    {
        if ($id > 0) {
            $data = BlogCategory::findOrFail($id);
            $data->update([
                'blog_category_name' => $request->name
            ]);

        } else {
            BlogCategory::insert([
                'blog_category_name' => $request->name,
                'created_at' => date('Y-m-d')
            ]);
        }
        $notification = array(
            'message' => 'Blog Category Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect('admin/blog_categories')->with($notification);
    }

    public function blogs()
    {
        $data = Blog::all();
        return view('admin.blog.all_blogs', compact('data'));


    }


    public function addBlog($id = 0)
    {
        $categories = BlogCategory::all();
        if ($id > 0) {
            $data = Blog::findOrFail($id);
            $category_id = $data->category_id;
            return view('admin.blog.add_blog', compact('data', 'categories', 'category_id'));
        } else {
            return view('admin.blog.add_blog', compact('categories'));


        }
    }

    public function deleteBlogCategory($id)
    {

        BlogCategory::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Blog Category Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect('admin/blog_categories')->with($notification);

    }

    public function saveBlog(Request $request, $id = 0)
    {
        $image = $request->file('image');
        if ($id > 0) {
            $data = Blog::findOrFail($id);

            if ($image) {
                if ($data->image) {
                    unlink('uploads/backend/blog/' . $data->image);

                }
                $fileName = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
                $img = new ImageManager();
                $img->make($image)->resize(1103, 906)->save('uploads/backend/blog/' . $fileName);
                $data->update([
                    'title' => $request->title,
                    'title_slug' => strtolower(str_replace(' ', '-', $request->title)),
                    'image' => $fileName,
                    'category_id' => $request->blog_category_id,
                    'short_description' => $request->short_description,
                    'long_description' => $request->long_description,
                ]);
            } else {

                $data->update([
                    'title' => $request->title,
                    'title_slug' => strtolower(str_replace(' ', '-', $request->title)),
                    'category_id' => $request->blog_category_id,
                    'short_description' => $request->short_description,
                    'long_description' => $request->long_description,
                ]);
            }
        } else {
            if ($image) {
                $fileName = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
                // $image->move(public_path('uploads/backend/category'), $fileName);
                $img = new ImageManager();
                $img->make($image)->resize(1103, 906)->save('uploads/backend/blog/' . $fileName);
                Blog::insert([
                    'title' => $request->title,
                    'title_slug' => strtolower(str_replace(' ', '-', $request->title)),
                    'image' => $fileName,
                    'category_id' => $request->blog_category_id,
                    'short_description' => $request->short_description,
                    'long_description' => $request->long_description,
                    'created_at' => date('Y-m-d')
                ]);
            } else {
                Blog::insert([
                    'title' => $request->title,
                    'title_slug' => strtolower(str_replace(' ', '-', $request->title)),
                    'image' => '',
                    'category_id' => $request->blog_category_id,
                    'short_description' => $request->short_description,
                    'long_description' => $request->long_description,
                    'created_at' => date('Y-m-d')
                ]);
            }


        }
        if ($request->remove_img == 1) {
            unlink('uploads/backend/blog/' . $data->image);
            $data->update([
                'image' => '',
            ]);
        }

        $notification = array(
            'message' => 'Blog Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect('admin/blogs')->with($notification);
    }


    public function deleteBlog($id)
    {

        Blog::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Blog Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect('admin/blogs')->with($notification);

    }


    public function blogsPage()
    {
        $blog_categories = BlogCategory::all();
        $blogs = Blog::latest()->paginate(6);
        return view('frontend.blog.blogs', compact('blog_categories', 'blogs'));
    }

    public function categoryblogPage($blog_category_id)
    {
        $blog_categories = BlogCategory::all();
        $blogs = Blog::where('category_id', $blog_category_id)->paginate(6);
        $category = BlogCategory::findOrFail($blog_category_id);
        return view('frontend.blog.blogs', compact('blog_categories', 'blogs', 'category'));
    }


}