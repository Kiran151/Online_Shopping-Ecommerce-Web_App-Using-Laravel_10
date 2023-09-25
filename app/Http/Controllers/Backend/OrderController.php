<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
  public function allOrders()
  {
    $data = Order::orderBy('id', 'DESC')->get();
    return view('admin.order.all_orders', compact('data'));
  }


  public function orderDetails($order_id)
  {

    $order = Order::with('division', 'district', 'state')->where('id', $order_id)->first();
    $orderItem = OrderItems::with('product')->where('order_id', $order_id)->get();


    return view('admin.order.order_details', compact('order', 'orderItem'));
  }


  public function changeOrderStatus($order_id)
  {
    $order = Order::findOrFail($order_id);
    if ($order->status == 'pending') {
      $order->update(['status' => 'confirmed', 'confirmed_date' => date('Y-m-d')]);
      $notification = array(
        'message' => 'Item Confirmed Successfully',
        'alert-type' => 'success'
      );

      return redirect()->back()->with($notification);
    } elseif ($order->status == 'confirmed') {
      $order->update(['status' => 'processing', 'processing_date' => date('Y-m-d')]);
      $notification = array(
        'message' => 'Item Processed Successfully',
        'alert-type' => 'success'
      );

      return redirect()->back()->with($notification);
    } elseif ($order->status == 'processing') {
      
      //managing product quantity
      $products=OrderItems::where('order_id',$order_id)->get();
      foreach ($products as $item) {
       Product::find($item->product_id)->update([
        'product_qty'=>DB::raw('product_qty-'.$item->qty)
       ]);
      }


      $order->update(['status' => 'delivered', 'delivered_date' => date('Y-m-d')]);
      $notification = array(
        'message' => 'Item Delivered Successfully',
        'alert-type' => 'success'
      );

      return redirect()->back()->with($notification);
    } else {
      $notification = array(
        'message' => 'Item Already Delivered',
        'alert-type' => 'info'
      );
      return redirect()->back()->with($notification);
    }
  }



  public function adminOrderInvoice($order_id)
  {

    $order = Order::with('division', 'district', 'state')->where('id', $order_id)->first();
    $orderItem = OrderItems::with('product')->where('order_id', $order_id)->get();

    return view('admin.order.order_invoice', compact('order', 'orderItem'));

  }

  public function orderSortDate(Request $request)
  {
    if ($request->has('from') && $request->has('to')) {

      $data = Order::whereBetween('order_date', [$request->from, $request->to])->get();
    }else{
      $date="2020-01-01";
      $data = Order::whereBetween('order_date', [$date, $request->to])->get();

    }

      $html = '';
      foreach ($data as $key => $item) {

        if ($item->status == 'pending') {
          $status = "Pending";
          $status_color = 'text-danger bg-light-danger text-danger';

        } elseif ($item->status == 'confirmed') {
          $status = "Confirmed";
          $status_color = 'bg-primary';


        } elseif ($item->status == 'processing') {
          $status = "Processing";
          $status_color = 'bg-warning';

        } elseif ($item->status == 'delivered') {
          $status = "Delivered";
          $status_color = 'bg-success';

        }


        $html .= '<tr>';
        $html .= '<td>' . $item->invoice_no . '</td>';

        $html .= '<td>' . $item->name . '</td>';
        $html .= '<td>' . $item->order_date . '</td>';
        $html .= '<td>' . '$' . $item->amount . '</td>';
        $html .= '<td><span
       class="badge rounded-pill '.$status_color.' ">'.$status.'</span></td>';
        $html .= '<td>
        <div class="d-flex order-actions">
            <a href="'.route('admin.order.details', $item->id).'"
                class="bg-warning"><i class="lni lni-eye fs-5"></i></a>

            <a style="cursor: pointer"
                onclick="print_invoice('.$item->id.')"
                class="ms-2 bg-secondary text-white"><i
                    class="bx bx-printer"></i></a>

        </div>
    </td>';

        $html .= '</tr>';
      }
      return $html;








  }
}