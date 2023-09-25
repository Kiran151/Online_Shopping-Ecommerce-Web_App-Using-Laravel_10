<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Compare;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompareController extends Controller
{
    public function addToCompare(Request $request, $id)
    {
        if (Auth::check()) {
            $user_id = Auth::user()->id;
            $user = Compare::where([['user_id', $user_id], ['product_id', $id]])->first();

            if (!$user) {
                Compare::insert([
                    'user_id' => $user_id,
                    'product_id' => $id,
                    'created_at' => date('Y-m-d')
                ]);
                $count = Compare::where('user_id', $user_id)->count();
                return response()->json([
                    'success' => 'Item added to compare',
                    'count' => $count
                ]);
            } else {
                return response()->json([
                    'error' => 'Item already on compare'
                ]);
            }

        } else {
            return response()->json([
                'error' => 'First login your account'
            ]);
        }
    }

    public function allCompare()
    {
        $user_id = Auth::user()->id;
        $data = Compare::where('user_id', $user_id)->get();
        $products = [];
        foreach ($data as $item) {
            $products[] = Product::findOrFail($item->product_id);
        }

        return view('frontend.compare.all_compares', compact('products'));
    }


    public function getCompare()
    {
        $user_id = Auth::user()->id;
        $data = Compare::where('user_id', $user_id)->get();
        $products = [];
        foreach ($data as $item) {
            $products[] = Product::findOrFail($item->product_id);
        }



        return response()->json([
            'product' => $products
        ]);
    }

    public function removeCompare($id)
    {
        $user_id = Auth::user()->id;
        Compare::where([['user_id', $user_id], ['product_id', $id]])->delete();
        $notification = array(
            'message' => 'Compare removed Successfully',
            'alert-type' => 'success'
        );
        return back()->with($notification);
    }
}