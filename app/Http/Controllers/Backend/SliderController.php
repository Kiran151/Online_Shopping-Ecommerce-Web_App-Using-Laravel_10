<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Slider;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;

class SliderController extends Controller
{
    public function allSliders()
    {

        $data = Slider::latest()->get();
        return view('admin.slider.all_sliders', compact('data'));
    }

    public function addSlider($id = 0)
    {
        if ($id > 0) {
            $data = Slider::findOrFail($id);
            return view('admin.slider.add_slider', compact('data'));

        }
        return view('admin.slider.add_slider');
    }

    public function saveSlider(Request $request, $id = 0)
    {
        $image = $request->file('image');
        if ($id > 0) {
            $data = Slider::findOrFail($id);

            if ($image) {
                unlink('uploads/backend/slider/' . $data->image);
                $fileName = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
                $img = new ImageManager();
                $img->make($image)->resize(2376, 807)->save('uploads/backend/slider/' . $fileName);
                $data->update([
                    'title' => $request->title,
                    'subtitle' => $request->subtitle,
                    'image' => $fileName,
                ]);
            } else {

                $data->update([
                    'title' => $request->title,
                    'subtitle' => $request->subtitle,
                ]);
            }
        } else {
            if ($image) {
                $fileName = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
                $img = new ImageManager();
                $img->make($image)->resize(2376, 807)->save('uploads/backend/slider/' . $fileName);
                Slider::insert([
                    'title' => $request->title,
                    'subtitle' => $request->subtitle,
                    'image' => $fileName,
                    'created_at' => date('Y-m-d')
                ]);
            } else {
                Slider::insert([
                    'title' => $request->title,
                    'subtitle' => $request->subtitle,
                    'image' => '',
                    'created_at' => date('Y-m-d')
                ]);
            }


        }
        if ($request->remove_img == 1) {
            unlink('uploads/backend/slider/' . $data->image);
            $data->update([
                'image' => '',
            ]);
        }

        $notification = array(
            'message' => 'Slider Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect('admin/all_sliders')->with($notification);
    }

    public function deleteSlider($id)
    {
        $data = Slider::findOrFail($id);
        if ($data->image) {
            unlink('uploads/backend/slider/' . $data->image);

        }
        $data->delete();

        $notification = array(
            'message' => 'Slider Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect('admin/all_sliders')->with($notification);



    }
}