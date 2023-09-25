<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;


class PaypalController extends Controller
{
    public function paypalPayment(Request $request)
    {
        try {

            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $paypal_token = $provider->getAccessToken();
            $response = $provider->createOrder([
                "intent" => "CAPTURE",
                "application_context" => [
                    "return_url" => route('paypal.payment'),
                    "cancel_url" => route('paypal.payment')
                ],
                "purchase_units" => [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => "100.00"
                    ]
                ]
            ]);
            //code...
        } catch (\Exception $e) {
            dd($e);
        }




    }

}