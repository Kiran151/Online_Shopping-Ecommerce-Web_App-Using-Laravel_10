<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Jobs\OrderSendMailJob;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\User;
use App\Notifications\OrderNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Ixudra\Curl\Facades\Curl;
use Notification;


class PhonePayController extends Controller
{
    public function phonepePayment(Request $request)
    {

        if (Session::has('coupon')) {
            $amount = Session::get('coupon')['total_amount'];
        } else {
            $amount = \Cart::getTotal();
        }


        $data = [
            "merchantId" => "MERCHANTUAT",
            "merchantTransactionId" => "MT7850590068188104",
            "merchantUserId" => "MUID123",
            "amount" => $amount * 100,
            "redirectUrl" => route('phonepe.response'),
            "redirectMode" => "POST",
            "callbackUrl" => route('phonepe.response'),
            "mobileNumber" => "9999999999",
            "paymentInstrument" => [
                "type" => "PAY_PAGE"
            ]
        ];

        $encode = base64_encode(json_encode($data));
        $saltKey = '099eb0cd-02cf-4e2a-8aca-3e6c6aff0399';
        $saltIndex = 1;
        $string = $encode . '/pg/v1/pay' . $saltKey;
        $sha256 = hash('sha256', $string);
        $finalXHeader = $sha256 . '###' . $saltIndex;



        $response = Curl::to('https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/pay')
            ->withHeader('Content-Type:application/json')
            ->withHeader('X-VERIFY:' . $finalXHeader)
            ->withData(json_encode(['request' => $encode]))
            ->post();
        $rData = json_decode($response);


        //insert order details
        $user = User::where('role', 'admin')->get();
        $datas = json_decode($request->data);



        $order_id = Order::insertGetId([
            'user_id' => Auth::user()->id,
            'division_id' => $datas->shipping_division,
            'district_id' => $datas->shipping_district,
            'state_id' => $datas->shipping_state,
            'name' => $datas->shipping_name,
            'email' => $datas->shipping_email,
            'phone' => $datas->shipping_phone,
            'address' => $datas->shipping_address,
            'post_code' => $datas->post_code,
            'notes' => $datas->notes,
            'payment_type' => 'PhonePe',
            'payment_method' => 'PhonePe',
            'currency' => 'usd',
            'amount' => $amount,
            'invoice_no' => '#NT' . mt_rand(10000000, 99999999),
            'order_date' => date('Y-m-d'),
            'order_month' => date('F'),
            'order_year' => date('Y'),
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
        OrderSendMailJob::dispatch($mail, $datas->shipping_email);

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
        Notification::send($user, new OrderNotification($datas->shipping_name));












        return redirect()->to($rData->data->instrumentResponse->redirectInfo->url);

    }


    public function phonePeResponse(Request $request)
    {

        $input = $request->all();
        $saltKey = '099eb0cd-02cf-4e2a-8aca-3e6c6aff0399';
        $saltIndex = 1;


        $finalXHeader = hash('sha256', '/pg/v1/status/' . $input['merchantId'] . '/' . $input['transactionId'] . $saltKey) . '###' . $saltIndex;

        $response = Curl::to('https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/status/' . $input['merchantId'] . '/' . $input['transactionId'] . '')
            ->withHeader('Content-Type:application/json')
            ->withHeader('accept:application/json')
            ->withHeader('X-VERIFY:' . $finalXHeader)
            ->withHeader('X-MERCHANT-ID:' . $input['transactionId'])
            ->get();

        $response = json_decode($response);
        if ($response->success == true) {

            $notification = array(
                'message' => $response->message,
                'alert-type' => 'success'
            );

            return redirect('/')->with($notification);
        } else {

            $notification = array(
                'message' => $response->message,
                'alert-type' => 'error'
            );

            return redirect('/')->with($notification);

        }



    }




}