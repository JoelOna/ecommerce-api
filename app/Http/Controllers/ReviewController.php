<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Order;
class ReviewController extends BaseController
{
    use HasApiTokens;
    //
    public function addReview(Request $request){
        if (auth()->user()->tokenCan('auth-token')) {
            $user = $request->user_id;
            $product = $request->product_id;
            
            $hasOrdered = Order::where('order_user_id',$user)
            ->where('order_product_id',$product,)
            ->get();

            if ($hasOrdered) {
                return response()->json([
                    'data' => Review::create($request->all())
                ],200);
            }
            return response()->json([
                'message' => 'You haven\'t buied this product! '
            ],403);

        }
        return response()->json([
            'message' => 'Unathoritzed'
        ],401);
    }

    public function updateReview(Request $request){
        if (auth()->user()->tokenCan('auth-token')) {
            $user = $request->user_id;
            $product = $request->product_id;
            
            $hasOrdered = Order::where('order_user_id',$user)
            ->where('order_product_id',$product,)
            ->get();

            if ($hasOrdered) {
                return response()->json([
                    'data' => Review::update($request->all())
                ],200);
            }
            return response()->json([
                'message' => 'You haven\'t buied this product! '
            ],403);

        }
        return response()->json([
            'message' => 'Unathoritzed'
        ],401);
    }

    public function deleteReview($idReview){
        if (auth()->user()->tokenCan('auth-token-worker')) {
            $review = Review::find($idReview);
                return response()->json([
                    'data' => $review
                ],200);
        }
        return response()->json([
            'message' => 'Unathoritzed'
        ],401);
    }

    public function userReviews($userId){
        if (auth()->user()->tokenCan('auth-token')) {
        $reviews = Review::where('review_user_id',$userId)->get();

        $paginatedReviews = $reviews->paginate(5); 
        return response()->json([
            'info' => [
                'first_page' => $paginatedReviews->url(1),
                'last_page' => $paginatedReviews->url($paginatedReviews->lastPage()),
                'next_page' => $paginatedReviews->nextPageUrl(),
                'prev_page' => $paginatedReviews->previousPageUrl(),
                'per_page' => $paginatedReviews->perPage(),
                'to' => $paginatedReviews->lastItem(),
                'total' => $paginatedReviews->total(),
            ],
            'data' => $paginatedReviews->items(),
        ], 200);
    }
    return response()->json([
        'message' => 'Unathoritzed'
    ],401);
    }

    public function productReviews($productId){
        $reviews = Review::where('review_product_id',$productId)->get();

        $paginatedReviews = $reviews->paginate(5); 
        return response()->json([
            'info' => [
                'first_page' => $paginatedReviews->url(1),
                'last_page' => $paginatedReviews->url($paginatedReviews->lastPage()),
                'next_page' => $paginatedReviews->nextPageUrl(),
                'prev_page' => $paginatedReviews->previousPageUrl(),
                'per_page' => $paginatedReviews->perPage(),
                'to' => $paginatedReviews->lastItem(),
                'total' => $paginatedReviews->total(),
            ],
            'data' => $paginatedReviews->items(),
        ], 200);
    }
}
