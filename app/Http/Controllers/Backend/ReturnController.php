<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReturnController extends Controller
{

    public function returnOrders()
    {

        $data = Order::where('return_order', 1)->orWhere('return_order', 2)->orderBy('id', 'DESC')->get();

        return view('admin.order.all_return_orders', compact('data'));
    }


    public function confirmReturn($order_id)
    {

        Order::findOrFail($order_id)->update([
            'return_order' => 2
        ]);

        $products = OrderItems::where('order_id', $order_id)->get();
        foreach ($products as $item) {
            Product::find($item->product_id)->update([
                'product_qty' => DB::raw('product_qty+' . $item->qty)
            ]);
        }

        return redirect()->back();
    }
}