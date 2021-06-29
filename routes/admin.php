<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SalesController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthorizationController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\VariationController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\BannerController;

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

Route::middleware(['guest:admin'])->group(function () {
    Route::get('/login', [\App\Http\Controllers\Auth\AdminLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [\App\Http\Controllers\Auth\AdminLoginController::class, 'login'])->name('login.submit');
    Route::get('/password/reset', [\App\Http\Controllers\Auth\AdminForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/password/reset', [\App\Http\Controllers\Auth\AdminForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/password/reset/{token}', [\App\Http\Controllers\Auth\AdminResetPasswordController::class, 'showResetForm'])->name('password.change.show');
    Route::post('/password/reset/change', [\App\Http\Controllers\Auth\AdminResetPasswordController::class, 'reset'])->name('password.update');
});

Route::middleware(['auth:admin'])->group(function () {
    Route::post('/logout', [\App\Http\Controllers\Auth\AdminLoginController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/analytics', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/products', [ProductController::class, 'index'])->name('products');
    Route::get('/products/new', [ProductController::class, 'create'])->name('products.create');
    Route::get('/products/{product:code}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
    Route::put('/products/{product:code}/update', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product:code}/delete', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::put('/products/{product:code}/feature', [ProductController::class, 'feature'])->name('products.feature');
    Route::put('/products/{product:code}/unlist', [ProductController::class, 'unlist'])->name('products.unlist');
    Route::delete('/products/{product:code}/media/remove', [ProductController::class, 'removeMedia'])->name('products.media.remove');
    Route::get('/products/listed', [ProductController::class, 'listed'])->name('products.listed');
    Route::get('/products/details', [ProductController::class, 'show'])->name('products.details');
    Route::get('/transactions/purchases', [TransactionController::class, 'purchases'])->name('transactions.purchases');
    Route::get('/transactions/purchases/details', [TransactionController::class, 'showPurchase'])->name('transactions.purchases.details');
    Route::get('/transactions/purchases/new', [TransactionController::class, 'createPurchase'])->name('transactions.purchases.create');
    Route::get('/transactions/sales', [TransactionController::class, 'sales'])->name('transactions.sales');
    Route::get('/transactions/sales/details', [TransactionController::class, 'showSale'])->name('transactions.sales.details');
    Route::get('/transactions/sales/new', [TransactionController::class, 'createSale'])->name('transactions.sales.create');
    Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers');
    Route::get('/sales', [SalesController::class, 'index'])->name('sales');
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/users/details', [UserController::class, 'show'])->name('users.details');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    Route::get('/orders/details', [OrderController::class, 'show'])->name('orders.details');
    Route::get('/banners', [BannerController::class, 'index'])->name('banners');
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
    Route::get('/administrators', [AdminController::class, 'index'])->name('admins');
    Route::get('/authorization', [AuthorizationController::class, 'index'])->name('authorization');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
    Route::get('/notifications/details', [NotificationController::class, 'show'])->name('notifications.show');
    Route::get('/brands', [BrandController::class, 'index'])->name('brands');
    Route::get('/variations', [VariationController::class, 'index'])->name('variations');

    Route::get('/getSubcategoriesByIds', [CategoryController::class, 'getSubcategoriesByIds'])->name('categories.subcategories.fetch');
    Route::post('/getProductsByAjax', [ProductController::class, 'getProductsByAjax'])->name('products.ajax');
});