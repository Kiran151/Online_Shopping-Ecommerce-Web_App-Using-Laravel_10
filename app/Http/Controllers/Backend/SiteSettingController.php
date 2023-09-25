<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Seo;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
{
   public function seoSetting(){
    $data=Seo::find(1);
    return view('admin.settings.seo',compact('data'));
   }

   public function saveSeo(Request $request,$id){
    Seo::findOrFail($id)->update([
        'meta_title'=>$request->meta_title,
        'meta_author'=>$request->meta_author,
        'meta_keyword'=>$request->meta_keyword,
        'meta_description'=>$request->meta_description,
    ]);
    $notification = array(
        'message' => 'Seo Updated Successfully',
        'alert-type' => 'success'
    );
    return redirect()->back()->with($notification);
   }
}
