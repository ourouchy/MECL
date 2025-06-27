<?php

use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use App\Models\CarouselImage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::view('/about', 'about')->name('about');
Route::view('/adoption-program', 'adoption-program')->name('adoption');
Route::view('/contact', 'contact')->name('contact');

Route::middleware(['guestOrVerified'])->group(function () {
    // Landing Page (Welcome Page)


    Route::get('/brands', [\App\Http\Controllers\BrandController::class, 'index'])->name('brands.index');
    Route::get('/brands/{brand:slug}', [\App\Http\Controllers\BrandController::class, 'show'])->name('brands.show');
// Create a CartMiniController or use CartController
    Route::get('/cart/mini', [CartController::class, 'mini']);

    // Products & Categories (Unified Under /products)
    Route::prefix('/products')->name('products.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index'); // All Products
        Route::get('/category/{category:slug}', [ProductController::class, 'byCategory'])->name('byCategory'); // Category Filter
        Route::get('/{product:slug}', [ProductController::class, 'view'])->name('view'); // Single Product Page
        Route::post('/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    });


    // Cart Routes
    Route::prefix('/cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add/{product:slug}', [CartController::class, 'add'])->name('add');
        Route::post('/remove/{product:slug}', [CartController::class, 'remove'])->name('remove');
        Route::post('/update-quantity/{product:slug}', [CartController::class, 'updateQuantity'])->name('update-quantity');

    });
    Route::prefix('/cart')->name('cart.')->group(function () {
        Route::post('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
        Route::post('/checkout/{order}', [CheckoutController::class, 'checkoutOrder'])->name('checkout-order');
    });
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/failure', [CheckoutController::class, 'failure'])->name('checkout.failure');
});

Route::middleware(['auth', 'verified'])->group(function() {
    Route::get('/profile', [ProfileController::class, 'view'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'store'])->name('profile.update');
    Route::post('/profile/password-update', [ProfileController::class, 'passwordUpdate'])->name('profile_password.update');

    Route::get('/orders', [OrderController::class, 'index'])->name('order.index');
    Route::get('/orders/{order}', [OrderController::class, 'view'])->name('order.view');
});

Route::post('/webhook/stripe', [CheckoutController::class, 'webhook']);
Route::get('/get-carousel-images', [App\Http\Controllers\CarouselController::class, 'getImages']);

require __DIR__ . '/auth.php';
