<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ShippingDistrict;
use App\Models\ShippingState;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function getDistrictAjax(Request $request)
    {
        $division_id = $request->division_id;

        $districts = ShippingDistrict::where('division_id', $division_id)->get();
        return $districts;
    }

    public function getStateAjax(Request $request)
    {

        $district_id = $request->district_id;
        $states = ShippingState::where('district_id', $district_id)->get();

        return $states;
    }

    public function checkoutSave(Request $request)
    {

        $data = array();
        $data['shipping_name'] = $request->name;
        $data['shipping_email'] = $request->email;
        $data['shipping_address'] = $request->address;
        $data['shipping_phone'] = $request->phone;
        $data['shipping_division'] = $request->division;
        $data['shipping_district'] = $request->district;
        $data['shipping_state'] = $request->state;
        $data['post_code'] = $request->post_code;
        $data['notes'] = $request->notes;
        $cart_total = \Cart::getTotal();

        if ($request->payment_option == 'stripe') {
            return view('frontend.payment.stripe', compact('data', 'cart_total'));
        } elseif ($request->payment_option == 'cash') {
            return view('frontend.payment.cash_on_delivery', compact('data', 'cart_total'));

        } elseif ($request->payment_option == 'card') {
            return 'card';

        }elseif('phonepe'){
            return view('frontend.payment.phonepe', compact('data', 'cart_total'));
        }





    }
}