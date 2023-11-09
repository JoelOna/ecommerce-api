<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Product;
use App\Models\Products_categories;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class ProductController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    function getProduct(Request $request){
        return response()->json(['data' =>Product::find($request->id)],200) ;
    }

    function getProducts(){
        return response()->json(['data' =>Product::all()],200);
    }

    function getRelatedProducts(Request $request){
        $productId = $request->productId;
        $product = Products_categories::where($productId, 'product_id');

        if(!$product){
            return response()->json([ 'message'=>"No product found with this id"],404);
        }
        $relatedProducts = Products_categories::where($product->category_id,'category_id')->limit(5);

        return response()->json([
            'data' => $relatedProducts
        ],200);
    }
    function getProductsPaginated(){
        return Product::paginate(10);
    }

    function addProduct(Request $request){
        if (auth()->user()->tokenCan('auth-token-worker')) {
        $userId = $request->userId;
        $user = User::find($userId);
        if (!$user || $user->user_type_id > 3 ) {
            return response()->json([
                'message' => 'Unathourized'
            ], 401);
        }
        return response()->json(['data'=>Product::create($request->all()),
                                'message'=>'Created successfully!'],200);
    }
        return response()->json([
            'message' => 'Unathourized'
        ], 401);
    }
    function updateProduct(Request $request){
        if (auth()->user()->tokenCan('auth-token-worker')) {
        $userId = $request->userId;
        $user = User::find($userId);

        if (!$user || $user->user_type_id >= 3 ) {
            return response()->json([
                'message' => 'Unathourized'
            ], 401);
        }
        $productId = $request->id;
        $product = Product::find($productId);
    
        if(!$product) {
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        }
        
        $product->update($request->all());
    
        return response()->json([
            'message' => 'Product updated successfully',
            'data' => $product
        ], 200);
        }
    
        return response()->json([
            'message' => 'Unathourized'
        ],401);
    
    }
    function deleteProduct (Request $request){
        $userId = $request->userId;
        $user = User::find($userId);

        if (!$user || $user->user_type_id >= 3 ) {
            return response()->json([
                'message' => 'Unathourized'
            ], 401);
        }
        $productId = $request->id;
        $product = Product::find($productId);

        if(!$product){
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        }

        $product->delete();

        return response()->json([
            'message' => 'Product deleted successfully',
            'data' => $product
        ], 200);
    }
}
