<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Invoice</title>

    <style type="text/css">
        * {
            font-family: Verdana, Arial, sans-serif;
        }

        table {
            font-size: x-small;
        }

        tfoot tr td {
            font-weight: bold;
            font-size: x-small;
        }

        .gray {
            background-color: lightgray
        }

        .font {
            font-size: 15px;
        }

        .authority {
            /*text-align: center;*/
            float: right
        }

        .authority h5 {
            margin-top: -10px;
            color: green;
            /*text-align: center;*/
            margin-left: 35px;
        }

        .thanks p {
            color: green;
            ;
            font-size: 16px;
            font-weight: normal;
            font-family: serif;
            margin-top: 20px;
        }
    </style>

</head>

<body>

    <table width="100%" style="background: #F7F7F7; padding:0 20px 0 20px;">
        <tr>
            <td valign="top">
                {{-- <img src="{{public_path('frontend/assets/imgs/theme/logo.svg') }}" alt="" height="40px;" width="40px;"/> --}}
                <h2 style="color: green; font-size: 26px;"><strong>Nest<br>Mart&Grocery</strong></h2>
            </td>
            <td align="right">
                <pre class="font">
               Nest Head Office
               Email:support@nest.com
               Mob: 1245454545
               5171 W <br>Campbell Ave, Utah <br>53127 <br>United States <br>
              
            </pre>
            </td>
        </tr>

    </table>


    <table width="100%" style="background:white; padding:2px;"></table>

    <table width="100%" style="background: #F7F7F7; padding:0 5 0 5px;" class="font">
        <tr>
            <td>
                <p class="font" style="margin-left: 20px;">
                    <strong>Name:</strong> {{ $order->name }} <br>
                    <strong>Email:</strong>{{ $order->email }} <br>
                    <strong>Phone:</strong>{{ $order->phone }} <br>

                    <strong>Address:</strong>{{ $order->address }} <br>
                    <strong>Post Code:</strong> {{ $order->post_code }}
                </p>
            </td>
            <td align="right">
                <p class="font" style="margin-left: 20px;">
                    <strong>Invoice:</strong> {{ $order->invoice_no }} <br>
                    <strong>Order Date:</strong>{{ $order->order_date }} <br>
                    <strong>Delivery Date:</strong>{{ $order->phone }} <br>
                    <strong>Payment Type:</strong>{{ $order->payment_type }} <br>
                    <strong></strong> <br>

                </p>
            </td>
        </tr>
    </table>
    <br />
    <h3>Products</h3>


    <table width="100%">
        <thead style="background-color: green; color:#FFFFFF;">
            <tr class="font">
                <th>Image</th>
                <th>Product Name</th>
                <th>Size</th>
                <th>Color</th>
                <th>Quantity</th>
                <th>Total </th>
            </tr>
        </thead>
        <tbody>


            @foreach ($orderItems as $item)
                <tr class="font">
                    <td align="center">
            <img src="{{ public_path('uploads/backend/product/thumbnail/'.$item['product']->thumbnail_image) }}" height="40px;" width="40px;" alt="">
        </td>
                    <td align="center">{{ $item['product']->product_name }}</td>
                    <td align="center">
                        {{ $item->size }}
                    </td>
                    <td align="center">{{ $item->color }}</td>
                    <td align="center">{{ $item->qty }}</td>
                    <td align="center">${{ $item->price }}</td>
                </tr>
            @endforeach

        </tbody>
    </table>
    <br>
    <table width="100%" style=" padding:0 10px 0 10px;">
        <tr>
            <td align="right">
                <h2><span style="color: green;">Subtotal:</span> ${{ $order->amount }}</h2>
                <h2><span style="color: green;">Total:</span>${{ $order->amount }}</h2>
                {{-- <h2><span style="color: green;">Full Payment PAID</h2> --}}
            </td>
        </tr>
    </table>
    <div class="thanks mt-3">
        <p>Thanks For Buying Products..!!</p>
    </div>
    <div class="authority float-right mt-5">
        <p>-----------------------------------</p>
        <h5>Authority Signature:</h5>
    </div>
</body>

</html>
