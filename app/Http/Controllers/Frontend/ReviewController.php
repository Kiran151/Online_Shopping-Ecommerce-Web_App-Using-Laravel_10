<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function saveReview(Request $request)
    {
        $user_id = Auth::user()->id;
        $product_id = $request->product_id;
        $vendor_id = $request->vendor_id;
        $comment = $request->comment;
        $rating = $request->rate;

        $user_has_review = Review::where([['user_id', $user_id], ['product_id', $product_id]])->first();
        if ($user_has_review) {
            Review::findOrFail($user_has_review->id)->update([
                'user_id' => $user_id,
                'product_id' => $product_id,
                'vendor_id' => $vendor_id,
                'comment' => $comment,
                'rating' => $rating,
                'created_at' => date('Y-m-d')
            ]);

        } else {
            Review::insert([
                'user_id' => $user_id,
                'product_id' => $product_id,
                'vendor_id' => $vendor_id,
                'comment' => $comment,
                'rating' => $rating,
                'created_at' => date('Y-m-d')
            ]);
        }



        $notification = array(
            'message' => 'Review Added Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    }

    public function allReviews()
    {

        $data = Review::latest()->get();

        return view('admin.review.all_reviews', compact('data'));
    }


    public function activeInactiveReview($review_id)
    {
        $review = Review::findOrFail($review_id);

        if ($review->status == 0) {
            $review->update(['status' => 1]);
            $notification = array(
                'message' => 'Review Activated Successfully',
                'alert-type' => 'success'
            );
        } else {
            $review->update(['status' => 0]);
            $notification = array(
                'message' => 'Review Deactivated Successfully',
                'alert-type' => 'success'
            );
        }


        return redirect()->back()->with($notification);

    }

    public function deleteReview($id)
    {
        Review::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Review Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);

    }


    public function vendorAllReviews()
    {

        $data = Review::where('vendor_id',Auth::id())->get();

        return view('vendor.review.all_reviews', compact('data'));
    }

public function reviewDetailAjax($review_id){

    $data=Review::findOrFail($review_id);
    return $data;
}

}