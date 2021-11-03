<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Models\Product;

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

// Public Routes
Route::get('/products', [ProductController::class, 'index']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/auth', [AuthController::class, 'auth']);

// Protected Routes
Route::group(['middleware'=> ['auth:sanctum']], function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::get('/user/products', [PurchaseController::class, 'getPurchases']);
    Route::post('/user/products', [PurchaseController::class, 'addPurchase']);
    Route::delete('/user/products/{sku}', [PurchaseController::class, 'deletePurchase']);
    Route::post('/logout', [AuthController::class, 'logout']);
});