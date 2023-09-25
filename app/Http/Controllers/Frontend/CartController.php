<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\ShippingDistrict;
use App\Models\ShippingDivision;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function addToCart(Request $request, $id)
    {
        try {
            //code...

            $product = Product::findOrFail($id);
            if ($product->discount_price == NULL) {

                \Cart::add([
                    'id' => $id,
                    'name' => $request->name,
                    'price' => $product->selling_price,
                    'quantity' => $request->qty,
                    'attributes' => [
                        'image' => $product->thumbnail_image,
                        'size' => $request->color,
                        'color' => $request->size,
                        'vendor_id' => $request->vendor_id
                    ]

                ]);
                return response()->json(['success' => 'Item Successfully Added to Cart']);

            } else {
                \Cart::add([
                    'id' => $id,
                    'name' => $request->name,
                    'price' => $product->selling_price - $product->discount_price,
                    'quantity' => $request->qty,
                    'attributes' => [
                        'image' => $product->thumbnail_image,
                        'size' => $request->color,
                        'color' => $request->size,
                        'vendor_id' => $request->vendor_id

                    ]

                ]);
                return response()->json(['success' => 'Item Successfully Added to Cart']);
            }
        } catch (\Exception $e) {
            dd($e);
        }
    }


    public function addToCart1($id)
    {
        try {

            $product = Product::findOrFail($id);
            $vendor_id = $product->vendor_id;
            if ($product->discount_price == NULL) {

                \Cart::add([
                    'id' => $id,
                    'name' => $product->product_name,
                    'price' => $product->selling_price,
                    'quantity' => 1,
                    'attributes' => [
                        'image' => $product->thumbnail_image,
                        'size' => '..',
                        'color' => '..',
                        'vendor_id' => $vendor_id

                    ]

                ]);
                return response()->json(['success' => 'Item Successfully Added to Cart']);

            } else {
                \Cart::add([
                    'id' => $id,
                    'name' => $product->product_name,
                    'price' => $product->selling_price - $product->discount_price,
                    'quantity' => 1,
                    'attributes' => [
                        'image' => $product->thumbnail_image,
                        'size' => '..',
                        'color' => '..',
                        'vendor_id' => $vendor_id


                    ]

                ]);
                return response()->json(['success' => 'Item Successfully Added to Cart']);
            }

        } catch (\Exception $e) {
            dd($e);
        }
    }


    public function getMiniCart()
    {
        $cart = \Cart::getContent();
        $cart_qty = \Cart::getTotalQuantity();
        $cart_total = \Cart::getTotal();
        $session = Session::get('coupon');

        return response()->json([
            'cart' => $cart,
            'cart_qty' => $cart_qty,
            'cart_total' => $cart_total,
            'session' => $session
        ]);

    }

    public function miniCartRemove($id)
    {
        \Cart::remove($id);
        if (Session::has('coupon')) {
            $coupon_name = Session::get('coupon')['coupon_name'];
            $coupon = Coupon::where('coupon_name', $coupon_name)->first();
            Session::put('coupon', [
                'coupon_name' => $coupon->coupon_name,
                'coupon_discount' => $coupon->coupon_discount,
                'discount_amount' => round(\Cart::getTotal() * $coupon->coupon_discount / 100),
                'total_amount' => round(\Cart::getTotal() - (\Cart::getTotal() * $coupon->coupon_discount / 100))
            ]);

        }

        return response()->json(['success' => 'Item removed successfully']);
    }



    public function myCart()
    {
        $cart_qty = \Cart::getTotalQuantity();
        return view('frontend.cart.cart_page', compact('cart_qty'));
    }


    public function clearCart()
    {
        \Cart::clear();
        if (Session::has('coupon')) {
            $coupon_name = Session::get('coupon')['coupon_name'];
            $coupon = Coupon::where('coupon_name', $coupon_name)->first();
            Session::put('coupon', [
                'coupon_name' => $coupon->coupon_name,
                'coupon_discount' => $coupon->coupon_discount,
                'discount_amount' => round(\Cart::getTotal() * $coupon->coupon_discount / 100),
                'total_amount' => round(\Cart::getTotal() - (\Cart::getTotal() * $coupon->coupon_discount / 100))
            ]);

        }

        $notification = array(
            'message' => 'Cart Cleared Successfully',
            'alert-type' => 'success'
        );
        return back()->with($notification);
    }


    public function cartIncrement($id)
    {
        try {

            $cart = \Cart::get($id);
            \Cart::update($id, array('quantity' => 1));

            if (Session::has('coupon')) {
                $coupon_name = Session::get('coupon')['coupon_name'];
                $coupon = Coupon::where('coupon_name', $coupon_name)->first();
                Session::put('coupon', [
                    'coupon_name' => $coupon->coupon_name,
                    'coupon_discount' => $coupon->coupon_discount,
                    'discount_amount' => round(\Cart::getTotal() * $coupon->coupon_discount / 100),
                    'total_amount' => round(\Cart::getTotal() - (\Cart::getTotal() * $coupon->coupon_discount / 100))
                ]);

            }


        } catch (\Exception $e) {
            dd($e);
        }
        return response()->json(['success' => 'Item quantity incremented']);

    }
    public function cartDecrement($id)
    {
        try {

            $cart = \Cart::get($id);
            \Cart::update($id, array('quantity' => -1));
            if (Session::has('coupon')) {
                $coupon_name = Session::get('coupon')['coupon_name'];
                $coupon = Coupon::where('coupon_name', $coupon_name)->first();
                Session::put('coupon', [
                    'coupon_name' => $coupon->coupon_name,
                    'coupon_discount' => $coupon->coupon_discount,
                    'discount_amount' => round(\Cart::getTotal() * $coupon->coupon_discount / 100),
                    'total_amount' => round(\Cart::getTotal() - (\Cart::getTotal() * $coupon->coupon_discount / 100))
                ]);

            }
        } catch (\Exception $e) {
            dd($e);
        }
        return response()->json(['success' => 'Item quantity decremented']);

    }


    public function applyCoupon(Request $request)
    {
        $coupon_name = $request->coupon_name;
        $coupon = Coupon::where('coupon_name', $coupon_name)->where('coupon_validity', '>=', date('Y-m-d'))->first();

        if ($coupon) {
            Session::put('coupon', [
                'coupon_name' => $coupon->coupon_name,
                'coupon_discount' => $coupon->coupon_discount,
                'discount_amount' => round(\Cart::getTotal() * $coupon->coupon_discount / 100),
                'total_amount' => round(\Cart::getTotal() - (\Cart::getTotal() * $coupon->coupon_discount / 100))
            ]);
            return response()->json(['success' => 'Coupon applied successfully', 'validity' => true]);

        } else {
            return response()->json(['error' => 'Invalid Coupon']);

        }
    }

    public function couponCalc()
    {

        if (Session::has('coupon')) {
            return response()->json([
                'subtotal' => \Cart::getTotal(),
                'coupon_name' => session()->get('coupon')['coupon_name'],
                'coupon_discount' => session()->get('coupon')['coupon_discount'],
                'discount_amount' => session()->get('coupon')['discount_amount'],
                'total_amount' => session()->get('coupon')['total_amount'],
            ]);
        } else {
            return response()->json([
                'total' => \Cart::getTotal()
            ]);
        }

    }

    public function couponRemove()
    {

        Session::forget('coupon');
        return response()->json([
            'success' => 'Coupon removed successfully'
        ]);
    }

    public function checkoutPage()
    {
        if (Auth::check()) {

            if (\Cart::getTotalQuantity() > 0) {

                $carts = \Cart::getContent();
                $cart_qty = \Cart::getTotalQuantity();
                $cart_total = \Cart::getTotal();
                $divisions = ShippingDivision::all();

                return view('frontend.checkout.checkout_page', compact('carts', 'cart_qty', 'cart_total', 'divisions'));

            } else {
                $notification = array(
                    'message' => 'No items in the cart',
                    'alert-type' => 'error'
                );

                return back()->with($notification);
            }

        } else {
            $notification = array(
                'message' => 'Login first',
                'alert-type' => 'error'
            );

            return back()->with($notification);
        }
    }


}