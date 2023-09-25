<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function userDashboard()
    {
        $id = Auth::user()->id;
        $data = User::findOrFail($id);
        return view('frontend.dashboard', compact('data'));
    }

    public function userLogout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        $notification = array(
            'message' => 'Logout Successfully',
            'alert-type' => 'info'
        );
        return redirect('user/login')->with($notification);
    }


    public function userUpdate(Request $request)
    {
        $id = Auth::user()->id;
        $user = User::findOrFail($id);
        $image = $request->file('image');

        if ($request->remove_img == 1) {
            unlink('uploads/user_images/' . $user->image);
            $user->update([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'image' => ''
            ]);
        }
        if ($image) {
            $fileName = date('YmdHis') . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/user_images'), $fileName);
            $user->update([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'image' => $fileName
            ]);
        } else {
            $user->update([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address
            ]);
        }

        $notification = array(
            'message' => 'User Profile Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);

    }

    public function userUpdatePassword(Request $request)
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

    public function userLogin()
    {
        return view('auth.login');
    }

    public function userRegister()
    {
        return view('auth.register');
    }

}