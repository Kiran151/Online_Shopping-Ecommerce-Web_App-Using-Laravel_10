<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class VendorController extends Controller
{
   public function vendorDashboard()
   {
      return view('vendor.index');
   }

   public function vendorLogout(Request $request)
   {
      Auth::guard('web')->logout();

      $request->session()->invalidate();

      $request->session()->regenerateToken();
      $notification = array(
         'message' => 'Logout Successfully',
         'alert-type' => 'info'
      );
      return redirect('vendor/login')->with($notification);
   }

   public function vendorLogin()
   {
      return view('vendor.vendor_login');
   }

   public function vendorProfile()
   {

      $id = Auth::user()->id;
      $data = User::find($id);
      return view('vendor.vendor_profile', compact('data'));
   }

   public function vendorUpdate(Request $request)
   {
      $id = Auth::user()->id;
      $user = User::findOrFail($id);
      $image = $request->file('image');

      if ($request->remove_img == 1) {
         unlink('uploads/vendor_images/' . $user->image);
         $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'short_description' => $request->short_description,
            'image' => ''
         ]);
      }
      if ($image) {
         $fileName = date('YmdHis') . '.' . $image->getClientOriginalExtension();
         $image->move(public_path('uploads/vendor_images'), $fileName);
         $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'short_description' => $request->short_description,
            'image' => $fileName
         ]);
      } else {
         $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'short_description' => $request->short_description,
         ]);
      }
      $notification = array(
         'message' => 'Profile Updated Successfully',
         'alert-type' => 'success'
      );
      return redirect()->back()->with($notification);

   }

   public function vendorChangePassword()
   {

      return view('vendor.vendor_change_password');
   }

   public function vendorUpdatePassword(Request $request)
   {
      $id = Auth::user()->id;
      $user = User::findOrFail($id);

      $request->validate([
         'old_password' => 'required',
         'new_password' => 'required',
         'confirm_password' => 'required|same:new_password',

      ]);

      if (!Hash::check($request->old_password, $user->password)) {
         return back()->with('error', 'Invalid Old Password');
      } else {
         $password = $request->new_password;
         $hash_password = Hash::make($password);
         $user->update(['password' => $hash_password]);
         return back()->with('success', 'Password Changed Successfully');
      }

   }

   public function becomeVendor()
   {

      return view('auth.become_vendor');
   }

   public function registerVendor(Request $request)
   {
      try {
         //code...

         $request->validate([
            'shop_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed'],
         ]);

         User::insert([
            'name' => $request->shop_name,
            'username' => $request->username,
            'phone' => $request->phone,
            'email' => $request->email,
            'role' => 'vendor',
            'status' => 'inactive',
            'password' => Hash::make($request->password),
            'created_at'=>date('Y-m-d')
         ]);



         $notification = array(
            'message' => 'Vendor Registered Successfully',
            'alert-type' => 'info'
         );
      } catch (\Exception $e) {
      }

      return redirect('vendor/login')->with($notification);
   }


}