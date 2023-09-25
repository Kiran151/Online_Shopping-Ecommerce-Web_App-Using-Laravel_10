<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function allCoupons()
    {
        $data = Coupon::latest()->get();
        return view('admin.coupon.all_coupons', compact('data'));
    }
    public function addCoupon($id = 0)
    {

        if ($id > 0) {
            $data = Coupon::findOrFail($id);
            return view('admin.coupon.add_coupon', compact('data'));
        }
        return view('admin.coupon.add_coupon');
    }


    public function saveCoupon(Request $request, $id = 0)
    {
        if ($id > 0) {
            Coupon::findOrFail($id)->update([
                'coupon_name' => $request->coupon_name,
                'coupon_discount' => $request->coupon_discount,
                'coupon_validity' => $request->coupon_validity,
            ]);
        } else {
            Coupon::insert([
                'coupon_name' => $request->coupon_name,
                'coupon_discount' => $request->coupon_discount,
                'coupon_validity' => $request->coupon_validity,
                'created_at' => date('Y-m-d')
            ]);
        }
        $notification = array(
            'message' => 'Coupon Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect('admin/all_coupons')->with($notification);
    }

    public function deleteCoupon($id)
    {

        Coupon::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Coupon Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect('admin/all_coupons')->with($notification);
    }
}