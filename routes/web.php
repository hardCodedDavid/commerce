<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

Auth::routes();

Route::get('/email/verify', [App\Http\Controllers\VerificationController::class, 'verifyEmail'])
    ->middleware('auth')
    ->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', [App\Http\Controllers\VerificationController::class, 'confirmVerifyEmail'])
    ->middleware(['auth', 'signed'])
    ->name('verification.verify');

Route::post('/email/verification-notification', [App\Http\Controllers\VerificationController::class, 'resendVerifyEmail'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.resend');

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/shop', [App\Http\Controllers\HomeController::class, 'shop'])->name('shop');
Route::get('/cart', [App\Http\Controllers\HomeController::class, 'cart'])->name('cart');
Route::get('/checkout', [App\Http\Controllers\HomeController::class, 'checkout'])->name('checkout');
Route::get('/wishlist', [App\Http\Controllers\HomeController::class, 'wishlist'])->name('wishlist');
Route::get('/product/{product:code}/details', [App\Http\Controllers\HomeController::class, 'productDetail'])->name('product.detail');
Route::get('/deals/{category?}', [App\Http\Controllers\ProductController::class, 'deals'])->name('deals');
Route::get('/top-selling/{category?}', [App\Http\Controllers\ProductController::class, 'topSelling'])->name('topSelling');
Route::get('/categories/{category:name}/products/{subcategory?}', [App\Http\Controllers\CategoryController::class, 'getProducts'])->name('category.products');
