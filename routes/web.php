<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\WishlistController;
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

Route::get('/a', [DeliveryController::class, 'estimateDeliveryFee']);
Route::get('/b', [DeliveryController::class, 'getDeliveryTowns']);
Route::get('/c', [DeliveryController::class, 'getDropOffLocations']);
Route::get('/d', [DeliveryController::class, 'getStates']);
Route::get('/e', [DeliveryController::class, 'getCitiesByState']);


Route::get('/email/verify', [VerificationController::class, 'verifyEmail'])
    ->middleware('auth')
    ->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'confirmVerifyEmail'])
    ->middleware(['auth', 'signed'])
    ->name('verification.verify');

Route::post('/email/verification-notification', [VerificationController::class, 'resendVerifyEmail'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.resend');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/{type}/{code}/invoice', [HomeController::class, 'getInvoice'])->name('invoice.get');
Route::get('/shop', [HomeController::class, 'shop'])->name('shop');
Route::post('/shop/filter', [HomeController::class, 'filterShop'])->name('shop.filter');
Route::get('/cart', [HomeController::class, 'cart'])->name('cart');
Route::get('/checkout', [HomeController::class, 'checkout'])->name('checkout')->middleware('profile_completed');
Route::post('/checkout', [HomeController::class, 'processCheckout'])->name('checkout.process')->middleware('profile_completed');
Route::get('/wishlist', [HomeController::class, 'wishlist'])->name('wishlist');
Route::get('/faqs', [HomeController::class, 'faq'])->name('faq');
Route::get('/order-tracking', [HomeController::class, 'orderTracking'])->name('orderTracking');
Route::get('/order/{order:code}/successful', [HomeController::class, 'orderSuccessful'])->name('orderSuccessful');
Route::post('/order-tracking', [HomeController::class, 'trackOrder'])->name('trackOrder');
Route::get('/account', [HomeController::class, 'account'])->name('account')->middleware('auth');
Route::post('/account/update', [HomeController::class, 'updateAccount'])->name('account.update')->middleware('auth');
Route::put('/password/custom/update', [HomeController::class, 'changePassword'])->name('password.custom.update')->middleware('auth');
Route::get('/orders', [HomeController::class, 'orders'])->name('orders')->middleware('auth');
Route::get('/orders/{order:code}/details', [HomeController::class, 'showOrder'])->name('orders.show')->middleware('auth');
Route::get('/product/{product:code}/details', [HomeController::class, 'productDetail'])->name('product.detail');
Route::post('/product/{product}/review/store', [HomeController::class, 'storeReview'])->name('product.review');
Route::get('/recently-viewed', [HomeController::class, 'recentlyViewed'])->name('recentlyViewed');
Route::get('/new-arrivals/{category?}', [ProductController::class, 'newArrivals'])->name('newArrivals');
Route::get('/deals/{category?}', [ProductController::class, 'deals'])->name('deals');
Route::get('/top-selling/{category?}', [ProductController::class, 'topSelling'])->name('topSelling');
Route::get('/categories/{category:name}/products/{subcategory?}', [CategoryController::class, 'getProducts'])->name('category.products');
Route::get('/payment/callback', [PaymentController::class, 'handlePaymentCallback'])->name('payment.callback');
Route::post('/newsletter', [HomeController::class, 'newsletter'])->name('newsletter');
Route::get('/delivery/estimate', [HomeController::class, 'estimateDeliveryCost'])->name('estimateDelivery');

// Ajax routes
Route::get('/product/search/{val}', [HomeController::class, 'searchProduct'])->name('product.search');
Route::get('/cart/fetch', [CartController::class, 'getCart'])->name('cart.fetch');
Route::post('/add-to-cart/{product}', [CartController::class, 'addToCart'])->name('add-to-cart');
Route::post('/remove-from-cart/{product}', [CartController::class, 'removeFromCart'])->name('remove-from-cart');
Route::post('/clear-cart', [CartController::class, 'clearCart'])->name('clear-cart');
Route::post('/update-cart/{product}', [CartController::class, 'updateCartItem'])->name('update-cart');
Route::get('/wishlist/fetch', [WishlistController::class, 'getWishList'])->name('wishlist.fetch');
Route::post('/wishlist/add/{product}', [WishlistController::class, 'wishListProduct'])->name('wishlist.add');
Route::post('/wishlist/remove/{product}', [WishlistController::class, 'removeFromWishlist'])->name('wishlist.remove');
