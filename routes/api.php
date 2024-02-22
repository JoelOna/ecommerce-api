<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Auth::routes(['verify' => true]);

/** USER */
Route::post('/signup', [LoginController::class, 'signUp']);
// Route::middleware(['auth:sanctum','verified'])->get('/user/{id}', [ApiController::class, 'getUser']);
// Route::middleware(['auth:sanctum','verified'])->put('/user', [ApiController::class, 'editUser']);
// Route::middleware(['auth:sanctum','verified'])->delete('/user', [ApiController::class, 'deleteUser']);
Route::middleware('auth:sanctum')->get('/user/{user_name}', [ApiController::class, 'getUser']);
Route::get('/user-review/{id}', [ApiController::class, 'getUserById']);
Route::middleware('auth:sanctum')->put('/user', [ApiController::class, 'editUser']);
Route::middleware('auth:sanctum')->delete('/user', [ApiController::class, 'deleteUser']);
Route::post('/logout', [LoginController::class, 'logout']);
Route::post('/login', [LoginController::class, 'login']);

/** PRODUCTS */
Route::get('/product/{id}', [ProductController::class, 'getProduct']);
Route::get('/product-image/{idProduct}', [ProductController::class, 'getProductIMG']);
// Route::get('/products', [ProductController::class, 'getProducts']);
Route::get('/products', [ProductController::class, 'getProductsPaginated']);
Route::middleware('auth:sanctum')->post('/product', [ProductController::class, 'addProduct']);
Route::middleware('auth:sanctum')->put('/product', [ProductController::class, 'updateProduct']);
Route::middleware('auth:sanctum')->delete('/product/id', [ProductController::class, 'deleteProduct']);

/** Categories */
Route::get('/categories',[CategoryController::class, 'getCategories']);
Route::post('/category',[CategoryController::class, 'addCategory']);
Route::put('/category',[CategoryController::class, 'editCategory']);
Route::delete('/category',[CategoryController::class, 'deleteCategory']);

/** Reviews */
Route::get('/reviews/{productId}',[ReviewController::class, 'productReviews']);
Route::post('/review',[ReviewController::class, 'addReview']);
Route::middleware('auth:sanctum')->get('/reviews/user/{userId}',[ReviewController::class, 'userReviews']);
Route::middleware('auth:sanctum')->delete('/reviews/delete/{idReview}',[ReviewController::class, 'deleteReview']);
 