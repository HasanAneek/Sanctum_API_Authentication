<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ProductController;
use \App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::resource('products',ProductController::class);

//Public routes
Route::get('/products',[ProductController::class,'index']);
Route::post('/login',[AuthController::class,'login']);
Route::post('/register',[AuthController::class,'register']);
Route::get('products/search/{name}',[ProductController::class,'search']);

//Private route
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/products',[ProductController::class,'store']);
    Route::put('/products/{product}',[ProductController::class,'update']);
    Route::delete('/products/{product}',[ProductController::class,'destroy']);
    Route::post('/logout',[AuthController::class,'logout']);
});

