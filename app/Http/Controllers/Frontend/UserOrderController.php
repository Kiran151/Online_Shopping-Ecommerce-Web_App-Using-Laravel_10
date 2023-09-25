<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;


class UserOrderController extends Controller
{
    public function orderView($order_id)
    {

        $order = Order::with('division', 'district', 'state')->where([['id', $order_id], ['user_id', Auth::user()->id]])->first();
        $orderItem = OrderItems::with('product')->where('order_id', $order_id)->get();


        return view('frontend.order.order_view', compact('order', 'orderItem'));
    }


    public function orderInvoice($order_id)
    {
        $order = Order::with('division', 'district', 'state')->where([['id', $order_id], ['user_id', Auth::user()->id]])->first();
        $orderItems = OrderItems::with('product')->where('order_id', $order_id)->get();

        $pdf = Pdf::loadView('frontend.order.order_invoice', compact('order','orderItems'))
        ->setPaper('a4')
        ->setOption([
            'tempDir'=>public_path(),
            'chroot'=>public_path()
        ]);
        return $pdf->download($order->invoice_no.'.pdf');



    }

    public function orderReturn(Request $request, $order_id){

        Order::findOrFail($order_id)->update([
            'return_order'=>1,
            'return_reason'=>$request->return_reason,
            'return_date'=>date('Y-m-d')
        ]);
        

        $notification = array(
            'message' => 'Return order request sended',
            'alert-type' => 'info'
        );
    
          return redirect()->back()->with($notification);
    }



    public function orderTracking(Request $request){
        $invoice_id=$request->invoice_no;
        $order=Order::where('invoice_no',$invoice_id)->first();
        if($order){
            return view('frontend.order.track_order_page',compact('order'));
        }else{
            
        $notification = array(
            'message' => 'Invalid Invoice Number',
            'alert-type' => 'error'
        );
          return redirect()->back()->with($notification);

        }

    }

   
}