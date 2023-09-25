<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;

class BannerController extends Controller
{
    public function allbanners()
    {
        $data = Banner::latest()->get();
        return view('admin.banner.all_banners', compact('data'));
    }

    public function addBanner($id = 0)
    {

        if ($id > 0) {
            $data = Banner::findOrFail($id);
            return view('admin.banner.add_banner', compact('data'));

        }
        return view('admin.banner.add_banner');
    }

    public function saveBanner(Request $request, $id = 0)
    {
        $image = $request->file('image');
        if ($id > 0) {
            $data = Banner::findOrFail($id);
            if ($image) {
                unlink('uploads/backend/banner/' . $data->image);
                $fileName = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
                $img = new ImageManager();
                $img->make($image)->resize(768, 450)->save('uploads/backend/banner/' . $fileName);
                $data->update([
                    'title' => $request->title,
                    'url' => $request->url,
                    'image' => $fileName,
                ]);
            } else {

                $data->update([
                    'title' => $request->title,
                    'url' => $request->url,
                ]);
            }
        } else {
            if ($image) {
                $fileName = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
                $img = new ImageManager();
                $img->make($image)->resize(768, 450)->save('uploads/backend/banner/' . $fileName);
                Banner::insert([
                    'title' => $request->title,
                    'url' => $request->url,
                    'image' => $fileName,
                    'created_at' => date('Y-m-d')
                ]);
            } else {
                Banner::insert([
                    'title' => $request->title,
                    'url' => $request->url,
                    'image' => '',
                    'created_at' => date('Y-m-d')
                ]);
            }


        }
        if ($request->remove_img == 1) {
            unlink('uploads/backend/banner/' . $data->image);
            $data->update([
                'image' => '',
            ]);
        }

        $notification = array(
            'message' => 'Banner Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect('admin/all_banners')->with($notification);
    }

    public function deleteBanner($id)
    {
        $data = Banner::findOrFail($id);
        if ($data->image) {
            unlink('uploads/backend/banner/' . $data->image);

        }
        $data->delete();

        $notification = array(
            'message' => 'Banner Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect('admin/all_banners')->with($notification);



    }
}