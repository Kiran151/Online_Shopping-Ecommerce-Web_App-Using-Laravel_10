<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Jobs\OrderSendMailJob;
use App\Mail\OrderMail;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\User;
use App\Notifications\OrderNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Notification;

class StripeController extends Controller
{
    public function stripePayment(Request $request)
    {
        $data = json_decode($request->data); // The second parameter 'true' makes it return an associative array
        if (Session::has('coupon')) {
            $amount = Session::get('coupon')['total_amount'];
        } else {
            $amount = \Cart::getTotal();
        }

        $stripe = new \Stripe\StripeClient('sk_test_51NfcnhSF6U02PfCglA1HOwWLsyyTGSdMdgLT4VtKAeYVxnpudRZR5vm9xTZtKHUCLyVeUazLqmwN59VRIP1k2CZY0094LvJGbg');


        $token = $_POST['stripeToken'];
        // Create a PaymentMethod using a test card token
        $paymentMethod = $stripe->paymentMethods->create([
            'type' => 'card',
            'card' => [
                'token' => 'tok_visa',
                // Use a test token provided by Stripe
            ],
        ]);
        // Set your secret key. Remember to switch to your live secret key in production.
        // See your keys here: https://dashboard.stripe.com/apikeys
        $pay = $stripe->paymentIntents->create([
            'amount' => $amount * 100,
            'currency' => 'usd',
            'description' => 'test payment',
            'payment_method_types' => ['card'],
            'payment_method' => $paymentMethod->id,
            'metadata' => ['order_id' => uniqid()],
            'confirm' => true,
        ]);
        $intent = $pay->client_secret;

        $order_id = Order::insertGetId([
            'user_id' => Auth::user()->id,
            'division_id' => $data->shipping_division,
            'district_id' => $data->shipping_district,
            'state_id' => $data->shipping_state,
            'name' => $data->shipping_name,
            'email' => $data->shipping_email,
            'phone' => $data->shipping_phone,
            'address' => $data->shipping_address,
            'post_code' => $data->post_code,
            'notes' => $data->notes,
            'payment_type' => $pay->payment_method,
            'payment_method' => 'Stripe',
            'transaction_id' => uniqid(),
            'currency' => $pay->currency,
            'amount' => $amount,
            'order_no' => $pay->metadata->order_id,
            'invoice_no' => '#NT' . mt_rand(10000000, 99999999),
            'order_date' => date('Y-m-d'),
            'order_month' => date('F'),
            'order_year' => date('Y'),
            // 'confirmed_date' => $data->notes,
            // 'processing_date' => $data->notes,
            // 'picked_date' => $data->notes,
            // 'shipped_date' => $data->notes,
            // 'delivered_date' => $data->notes,
            // 'cancel_date' => $data->notes,
            // 'return_date' => $data->notes,
            // 'return_reason' => $data->notes,
            'status' => 'pending',
            'created_at' => date('Y-m-d'),

        ]);

        $carts = \Cart::getContent();
        foreach ($carts as $item) {
            OrderItems::insert([
                'order_id' => $order_id,
                'product_id' => $item->id,
                'vendor_id' => $item->attributes->vendor_id,
                'color' => $item->attributes->color,
                'size' => $item->attributes->size,
                'qty' => $item->quantity,
                'price' => $item->price,
                'created_at' => date('Y-m-d'),
            ]);
        }

        if (Session::has('coupon')) {
            Session::forget('coupon');
        }

        \Cart::clear();

        $notification = array(
            'message' => 'Order Placed Successfully',
            'alert-type' => 'success'
        );

        return redirect('/')->with($notification);




    }


    public function cashPayment(Request $request)
    {
        $user=User::where('role','admin')->get();
        $data = json_decode($request->data); // The second parameter 'true' makes it return an associative array
        if (Session::has('coupon')) {
            $amount = Session::get('coupon')['total_amount'];
        } else {
            $amount = \Cart::getTotal();
        }


        $order_id = Order::insertGetId([
            'user_id' => Auth::user()->id,
            'division_id' => $data->shipping_division,
            'district_id' => $data->shipping_district,
            'state_id' => $data->shipping_state,
            'name' => $data->shipping_name,
            'email' => $data->shipping_email,
            'phone' => $data->shipping_phone,
            'address' => $data->shipping_address,
            'post_code' => $data->post_code,
            'notes' => $data->notes,
            'payment_type' => 'cash_on_delivery',
            'payment_method' => 'Cash on delivery',
            'currency' => 'usd',
            'amount' => $amount,
            'invoice_no' => '#NT' . mt_rand(10000000, 99999999),
            'order_date' => date('Y-m-d'),
            'order_month' => date('F'),
            'order_year' => date('Y'),
            // 'confirmed_date' => $data->notes,
            // 'processing_date' => $data->notes,
            // 'picked_date' => $data->notes,
            // 'shipped_date' => $data->notes,
            // 'delivered_date' => $data->notes,
            // 'cancel_date' => $data->notes,
            // 'return_date' => $data->notes,
            // 'return_reason' => $data->notes,
            'status' => 'pending',
            'created_at' => date('Y-m-d'),

        ]);

      
        // Mailing
        $order = Order::findOrFail($order_id);
        $mail = [
            'invoice_no' => $order->invoice_no,
            'amount' => $amount,
            'name' => $order->name,
            'email' => $order->email,

        ];
          // jobs
          OrderSendMailJob::dispatch($mail,$data->shipping_email);

        // Mail::to($data->shipping_email)->send(new OrderMail($mail));






        $carts = \Cart::getContent();
        foreach ($carts as $item) {
            OrderItems::insert([
                'order_id' => $order_id,
                'product_id' => $item->id,
                'vendor_id' => $item->attributes->vendor_id,
                'color' => $item->attributes->color,
                'size' => $item->attributes->size,
                'qty' => $item->quantity,
                'price' => $item->price,
                'created_at' => date('Y-m-d'),
            ]);
        }

        if (Session::has('coupon')) {
            Session::forget('coupon');
        }

        \Cart::clear();

        //notification
        Notification::send($user,new OrderNotification($data->shipping_name));

        $notification = array(
            'message' => 'Order Placed Successfully',
            'alert-type' => 'success'
        );

        return redirect('/')->with($notification);




    }






}