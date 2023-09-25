<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Services\getOrderGraphData;
use Notification;

class AdminController extends Controller
{
    private $getOrderGraphData;

    public function __construct(getOrderGraphData $getOrderGraphData)
    {
        $this->getOrderGraphData = $getOrderGraphData;

    }



    public function adminDashboard()
    {
        return view('admin.index');
    }

    public function adminLogin()
    {
        return view('admin.admin_login');
    }

    public function adminLogout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        $notification = array(
            'message' => 'Logout Successfully',
            'alert-type' => 'info'
        );

        return redirect('admin/login')->with($notification);
    }

    public function adminProfile()
    {

        $id = Auth::user()->id;
        $data = User::find($id);
        return view('admin.admin_profile', compact('data'));
    }

    public function adminUpdate(Request $request)
    {
        $id = Auth::user()->id;
        $user = User::findOrFail($id);
        $image = $request->file('image');

        if ($request->remove_img == 1) {
            unlink('uploads/admin_images/' . $user->image);
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
            $image->move(public_path('uploads/admin_images'), $fileName);
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
            'message' => 'Profile Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);

    }

    public function adminChangePassword()
    {

        return view('admin.admin_change_password');
    }

    public function adminUpdatePassword(Request $request)
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

    public function allVendors()
    {
        $data = User::where('role', 'vendor')->get();
        return view('vendor.all_vendors', compact('data'));
    }

    public function activeVendor($id)
    {
        User::findOrFail($id)->update([
            'status' => 'active'
        ]);
        $notification = array(
            'message' => 'Vendor Activated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function inactiveVendor($id)
    {
        User::findOrFail($id)->update([
            'status' => 'inactive'
        ]);
        $notification = array(
            'message' => 'Vendor Inactivated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function allUsers()
    {
        $data = User::where('role', 'user')->get();
        return view('admin.user.all_users', compact('data'));
    }

    public function activeUser($id)
    {
        User::findOrFail($id)->update([
            'status' => 'active'
        ]);
        $notification = array(
            'message' => 'User Activated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function inactiveUser($id)
    {
        User::findOrFail($id)->update([
            'status' => 'inactive'
        ]);
        $notification = array(
            'message' => 'User Inactivated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }


    public function getOrderGraph(Request $request)
    {
        $period = $request->period;
        $data = $this->getOrderGraphData->get($period);

        return response()->json($data);


    }


    public function markAsRead(){
        $user=Auth::user();
        $user->notifications()->delete();


    }
}