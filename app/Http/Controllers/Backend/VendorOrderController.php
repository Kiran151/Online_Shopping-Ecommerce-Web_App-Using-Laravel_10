<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorOrderController extends Controller
{
   public function vendorAllOrders(){
    $vendor_id=Auth::user()->id;
    $data=OrderItems::where('vendor_id',$vendor_id)->get();
    return view('vendor.order.all_orders',compact('data'));
   }


   public function vendorOrderDetails($order_item_id){
      
      $orderItem = OrderItems::with('product')->where('id', $order_item_id)->get();
      $order_id=$orderItem[0]->order_id;
      $order = Order::with('division', 'district', 'state')->where('id', $order_id)->first();
  
  
      return view('vendor.order.order_details', compact('order', 'orderItem'));

   }


   public function vendorOrderReturn(){
      $vendor_id=Auth::user()->id;
    $data=OrderItems::with('order')->where('vendor_id',$vendor_id)->get();
    return view('vendor.order.all_return_orders',compact('data'));
   }

   public function vendorOrderInvoice($order_id){

      $order = Order::with('division', 'district', 'state')->where('id', $order_id)->first();
      $orderItem = OrderItems::with('product')->where('order_id', $order_id)->get();
  
      return view('admin.order.order_invoice',compact('order', 'orderItem'));
  
    }
}
