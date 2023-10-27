<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\LoginController;
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

Route::post('/signup', [LoginController::class, 'signUp']);
// Route::get('/user/{id}', [ApiController::class, 'getUser']);

Route::middleware('auth:sanctum')->get('/user/{id}', [ApiController::class, 'getUser']);
Route::middleware('auth:sanctum')->post('/user/{id}', [ApiController::class, 'editUser']);
Route::middleware('auth:sanctum')->delete('/user/{id}', [ApiController::class, 'deleteUser']);
Route::post('/login', [LoginController::class, 'login']);

 