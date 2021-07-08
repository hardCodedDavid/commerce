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
use App\Http\Controllers\Admin\ExportController;

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
    // Route::get('/analytics', [HomeController::class, 'index'])->name('dashboard');
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
    Route::get('/transactions/purchases/new', [TransactionController::class, 'createPurchase'])->name('transactions.purchases.create');
    Route::post('/transactions/purchases/store', [TransactionController::class, 'storePurchase'])->name('transactions.purchases.store');
    Route::get('/transactions/purchases/{purchase:code}/edit', [TransactionController::class, 'editPurchase'])->name('transactions.purchases.edit');
    Route::put('/transactions/purchases/{purchase:code}/update', [TransactionController::class, 'updatePurchase'])->name('transactions.purchases.update');
    Route::delete('/transactions/purchases/{purchase:code}/delete', [TransactionController::class, 'destroyPurchase'])->name('transactions.purchases.destroy');
    Route::get('/transactions/purchases/{purchase:code}/invoice', [TransactionController::class, 'purchaseInvoice'])->name('transactions.purchases.invoice');

    Route::get('/transactions/sales', [TransactionController::class, 'sales'])->name('transactions.sales');
    Route::get('/transactions/sales/new', [TransactionController::class, 'createSale'])->name('transactions.sales.create');
    Route::post('/transactions/sales/store', [TransactionController::class, 'storeSale'])->name('transactions.sales.store');
    Route::get('/transactions/sales/{sale:code}/edit', [TransactionController::class, 'editSale'])->name('transactions.sales.edit');
    Route::put('/transactions/sales/{sale:code}/update', [TransactionController::class, 'updateSale'])->name('transactions.sales.update');
    Route::delete('/transactions/sales/{sale:code}/delete', [TransactionController::class, 'destroySale'])->name('transactions.sales.destroy');
    Route::get('/transactions/sales/{sale:code}/invoice', [TransactionController::class, 'saleInvoice'])->name('transactions.sales.invoice');

    Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers');
    Route::post('/suppliers/store', [SupplierController::class, 'store'])->name('suppliers.store');
    Route::put('/suppliers/{supplier}/update', [SupplierController::class, 'update'])->name('suppliers.update');
    Route::delete('/suppliers/{supplier}/delete', [SupplierController::class, 'destroy'])->name('suppliers.destroy');

    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::put('/users/{user}/block', [UserController::class, 'block'])->name('users.block');
    Route::put('/users/{user}/unblock', [UserController::class, 'unBlock'])->name('users.unblock');
    Route::get('/users/{user}/show', [UserController::class, 'show'])->name('users.show');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    Route::put('/orders/{order}/change-state', [OrderController::class, 'changeState'])->name('orders.state.change');
    Route::get('/orders/{order}/show', [OrderController::class, 'show'])->name('orders.show');

    Route::get('/banners', [BannerController::class, 'index'])->name('banners');
    Route::post('/banners/store', [BannerController::class, 'store'])->name('banners.store');
    Route::put('/banners/{banner}/update', [BannerController::class, 'update'])->name('banners.update');
    Route::delete('/banners/{banner}/delete', [BannerController::class, 'destroy'])->name('banners.destroy');

    Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
    Route::post('/categories/store', [CategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{category}/update', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}/delete', [CategoryController::class, 'destroy'])->name('categories.destroy');

    Route::get('/brands', [BrandController::class, 'index'])->name('brands');
    Route::post('/brands/store', [BrandController::class, 'store'])->name('brands.store');
    Route::put('/brands/{brand}/update', [BrandController::class, 'update'])->name('brands.update');
    Route::delete('/brands/{brand}/delete', [BrandController::class, 'destroy'])->name('brands.destroy');

    Route::get('/variations', [VariationController::class, 'index'])->name('variations');
    Route::post('/variations/store', [VariationController::class, 'store'])->name('variations.store');
    Route::put('/variations/{variation}/update', [VariationController::class, 'update'])->name('variations.update');
    Route::delete('/variations/{variation}/delete', [VariationController::class, 'destroy'])->name('variations.destroy');

    Route::get('/administrators', [AdminController::class, 'index'])->name('admins');
    Route::post('/administrators/store', [AdminController::class, 'store'])->name('admins.store');
    Route::put('/administrators/{admin}/update', [AdminController::class, 'update'])->name('admins.update');
    Route::delete('/administrators/{admin}/delete', [AdminController::class, 'destroy'])->name('admins.destroy');

    Route::get('/authorization', [AuthorizationController::class, 'index'])->name('authorization');
    Route::post('/authorization/store', [AuthorizationController::class, 'storeRole'])->name('authorization.role.store');
    Route::put('/authorization/{role}/update', [AuthorizationController::class, 'updateRole'])->name('authorization.role.update');
    Route::delete('/authorization/{role}/delete', [AuthorizationController::class, 'destroyRole'])->name('authorization.role.destroy');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
    Route::get('/notifications/details', [NotificationController::class, 'show'])->name('notifications.show');

    Route::get('/{product}/getProductDetails', [ProductController::class, 'getProductDetails']);
    Route::get('/getSubcategoriesByIds', [CategoryController::class, 'getSubcategoriesByIds']);

    Route::post('/getProductsByAjax', [ProductController::class, 'getProductsByAjax'])->name('products.ajax');
    Route::post('/getPurchasesByAjax', [TransactionController::class, 'getPurchasesByAjax'])->name('purchases.ajax');
    Route::post('/getSalesByAjax', [TransactionController::class, 'getSalesByAjax'])->name('sales.ajax');
    Route::post('/getUsersByAjax', [UserController::class, 'getUsersByAjax'])->name('users.ajax');
    Route::post('/getOrdersByAjax', [OrderController::class, 'getOrdersByAjax'])->name('orders.ajax');

    Route::post('/users/export/download', [ExportController::class, 'exportUsers'])->name('users.export');
    Route::post('/products/export/download', [ExportController::class, 'exportProducts'])->name('products.export');
    Route::post('/purchases/export/download', [ExportController::class, 'exportPurchases'])->name('purchases.export');
    Route::post('/sales/export/download', [ExportController::class, 'exportSales'])->name('sales.export');
});