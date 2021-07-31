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
Route::post('/shop/filter', [App\Http\Controllers\HomeController::class, 'filterShop'])->name('shop.filter');
Route::get('/cart', [App\Http\Controllers\HomeController::class, 'cart'])->name('cart');
Route::get('/checkout', [App\Http\Controllers\HomeController::class, 'checkout'])->name('checkout');
Route::get('/wishlist', [App\Http\Controllers\HomeController::class, 'wishlist'])->name('wishlist');
Route::get('/account', [App\Http\Controllers\HomeController::class, 'account'])->name('account')->middleware('auth');
Route::get('/orders', [App\Http\Controllers\HomeController::class, 'orders'])->name('orders')->middleware('auth');
Route::get('/product/{product:code}/details', [App\Http\Controllers\HomeController::class, 'productDetail'])->name('product.detail');
Route::get('/deals/{category?}', [App\Http\Controllers\ProductController::class, 'deals'])->name('deals');
Route::get('/top-selling/{category?}', [App\Http\Controllers\ProductController::class, 'topSelling'])->name('topSelling');
Route::get('/categories/{category:name}/products/{subcategory?}', [App\Http\Controllers\CategoryController::class, 'getProducts'])->name('category.products');

// Ajax routes
Route::get('/product/search/{val}', [App\Http\Controllers\HomeController::class, 'searchProduct'])->name('product.search');
Route::get('/cart/fetch', [App\Http\Controllers\CartController::class, 'getCart'])->name('cart.fetch');
Route::post('/add-to-cart/{product}', [App\Http\Controllers\CartController::class, 'addToCart'])->name('add-to-cart');
Route::post('/remove-from-cart/{product}', [App\Http\Controllers\CartController::class, 'removeFromCart'])->name('remove-from-cart');
Route::post('/clear-cart', [App\Http\Controllers\CartController::class, 'clearCart'])->name('clear-cart');
Route::post('/update-cart/{product}', [App\Http\Controllers\CartController::class, 'updateCartItem'])->name('update-cart');
Route::get('/wishlist/fetch', [App\Http\Controllers\WishlistController::class, 'getWishList'])->name('wishlist.fetch');
Route::post('/wishlist/add/{product}', [App\Http\Controllers\WishlistController::class, 'wishListProduct'])->name('wishlist.add');
Route::post('/wishlist/remove/{product}', [App\Http\Controllers\WishlistController::class, 'removeFromWishlist'])->name('wishlist.remove');