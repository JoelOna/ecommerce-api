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

    function getProduct($id){
        $product = Product::find($id);
    
        if (!$product) {
            return response()->json(['error' => 'Producto no encontrado'], 404);
        }
        
        return response()->json(['data' => $product], 200);
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
        $products = Product::paginate(10);
        return response()->json([
            'info' => [
                'first_page' => $products->url(1),
                'last_page' => $products->url($products->lastPage()),
                'next_page' => $products->nextPageUrl(),
                'prev_page' => $products->previousPageUrl(),
                'per_page' => $products->perPage(),
                'to' => $products->lastItem(),
                'total' => $products->total(),
            ],
            'data' => $products->items(),
        ], 200);
    }
    

    function getProductIMG($idProduct) {
        $product = Product::find($idProduct);
        
        if (!$product) {
            return response()->json(['error' => 'Producto no encontrado'], 404);
        }
        $rutaImagen = public_path('/upload/img/products/'.$product->prod_image);  

        if (!file_exists($rutaImagen)) {
            return response()->json(['error' => 'Imagen no encontrada'], 404);
        }

        $tipoContenido = mime_content_type($rutaImagen);

        header("Content-Type: $tipoContenido");
        return response()->file($rutaImagen);
    }

    function addProduct(Request $request){
        if (auth()->user()->tokenCan('auth-token-worker')) { 
            $validator = $request->validate([
                'userId'=>'required|integer',
                'prod_name'=>'required|string',
                'prod_name_en'=>'string',
                'prod_description' => 'required|string|min:10',
                'prod_description_en' => 'required|string|min:10',
                'prod_price' => 'required|decimal:2|min:0',
                'prod_stock_quanitity'=> 'integer|required|min:0',
                'prod_is_active' => 'integer|required|min:0|max:1',
                'prod_rate'=> 'integer|min:1|max:5',
                'prod_opinion'=>'string'
            ]);
        $userId = $request->userId;
        $user = User::find($userId);
        if (!$user || $user->user_type_id > 3 ) {
            return response()->json([
                'message' => 'Unathourized'
            ], 401);
        }
        try {
        $product = new Product;
        $product->prod_name = $request->prod_name;
        $product->prod_name_en = $request->prod_name_en;
        $product->prod_description = $request->prod_description;
        $product->prod_description_en = $request->prod_description_en;
        $product->prod_price = $request->prod_price;
        $product->prod_stock_quantity = $request->prod_stock_quantity;
        $product->prod_is_active = $request->prod_is_active;
        $product->prod_rate = $request->prod_rate;
        $product->prod_opinion = $request->prod_opinion;

        if($request->file('prod_image')){
            $file= $request->file('prod_image');
            $name = str_replace(' ','_',$product->prod_name);
            $filename = $name.'_'.uniqid().'.'.$file->getClientOriginalExtension();
            $file-> move(public_path('upload/img/products'), $filename);
            $product->prod_image = $filename;
        }
        $product->save();
        return response()->json(['data'=>$product,
                                'message'=>'Created successfully!'],200);
    }
      catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
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
        if($request->file('prod_image')){
            $file= $request->file('prod_image');
            $name = str_replace(' ','_',$product->prod_name);
            $filename = $name.'_'.uniqid().'.'.$file->getClientOriginalExtension();
            $file-> move(public_path('upload/img/products'), $filename);
            $product->prod_image = $filename;
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
}