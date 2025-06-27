<?php

use App\Http\Controllers\Api\CarouselImageController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\ReportController;
use App\Models\Size;
use Illuminate\Support\Facades\Route;

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

Route::get('/sizes', function () {
    return response()->json(Size::all());
});

Route::apiResource('products', ProductController::class)->names('api.products');
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/user', [\App\Http\Controllers\Api\AuthController::class, 'getUser']);
    Route::post('/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);

    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{product}', [ProductController::class, 'update']);
    Route::delete('/products/{product}', [ProductController::class, 'destroy']);
    Route::get('/products/{product}/reviews', [\App\Http\Controllers\Api\ReviewController::class, 'index']);
    Route::middleware('auth:sanctum')->post('/products/{product}/reviews', [\App\Http\Controllers\Api\ReviewController::class, 'store']);

    Route::apiResource('users', UserController::class);
    Route::apiResource('customers', CustomerController::class);
    Route::apiResource('categories', CategoryController::class)->except('show');
    Route::get('/categories/tree', [CategoryController::class, 'getAsTree']);
    Route::get('/countries', [CustomerController::class, 'countries']);
    Route::get('orders', [OrderController::class, 'index']);
    Route::get('orders/statuses', [OrderController::class, 'getStatuses']);
    Route::post('orders/change-status/{order}/{status}', [OrderController::class, 'changeStatus']);
    Route::get('orders/{order}', [OrderController::class, 'view']);
    Route::apiResource('/brands', \App\Http\Controllers\Api\BrandController::class)->names('api.brands');
    // Dashboard Routes
    Route::get('/dashboard/customers-count', [DashboardController::class, 'activeCustomers']);
    Route::get('/dashboard/products-count', [DashboardController::class, 'activeProducts']);
    Route::get('/dashboard/orders-count', [DashboardController::class, 'paidOrders']);
    Route::get('/dashboard/income-amount', [DashboardController::class, 'totalIncome']);
    Route::get('/dashboard/orders-by-country', [DashboardController::class, 'ordersByCountry']);
    Route::get('/dashboard/latest-customers', [DashboardController::class, 'latestCustomers']);
    Route::get('/dashboard/latest-orders', [DashboardController::class, 'latestOrders']);

    // Report routes
    Route::get('/report/orders', [ReportController::class, 'orders']);
    Route::get('/report/customers', [ReportController::class, 'customers']);

    Route::get('/carousel-images', [CarouselImageController::class, 'index']);
    Route::post('/carousel-images', [CarouselImageController::class, 'store']);
    Route::delete('/carousel-images/{id}', [CarouselImageController::class, 'destroy']);
});

Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);
