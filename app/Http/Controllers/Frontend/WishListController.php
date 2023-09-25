<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\WishList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishListController extends Controller
{
    public function addToWishlist(Request $request, $id)
    {
        if (Auth::check()) {
            $user_id = Auth::user()->id;
            $user = WishList::where([['user_id', $user_id], ['product_id', $id]])->first();

            if (!$user) {
                WishList::insert([
                    'user_id' => $user_id,
                    'product_id' => $id,
                    'created_at' => date('Y-m-d')
                ]);
                $count = WishList::where('user_id', $user_id)->count();
                return response()->json([
                    'success' => 'Item added to wishlist',
                    'count' => $count
                ]);
            } else {
                return response()->json([
                    'error' => 'Item already on wishlist'
                ]);
            }

        } else {
            return response()->json([
                'error' => 'First login your account'
            ]);
        }
    }


    public function allWishlist()
    {
        $user_id = Auth::user()->id;
        $data = WishList::where('user_id', $user_id)->get();
        $products = [];
        foreach ($data as $item) {
            $products[] = Product::findOrFail($item->product_id);
        }

        return view('frontend.wishlist.all_wishlists', compact('data', 'products'));
    }

    public function removeWishlist($id)
    {
        $user_id = Auth::user()->id;
        WishList::where([['user_id', $user_id], ['product_id', $id]])->delete();
        return response()->json([
            'success' => 'Item removed Successfully'
        ]);
    }

    public function getWishlist()
    {
        $user_id = Auth::user()->id;
        $data = WishList::where('user_id', $user_id)->get();
        $products = [];
        foreach ($data as $item) {
            $products[] = Product::findOrFail($item->product_id);
        }
        return response()->json([
            'product' => $products
        ]);
    }
}