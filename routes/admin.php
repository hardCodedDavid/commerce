<?php

use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Auth\AdminForgotPasswordController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\AdminResetPasswordController;
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
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminLoginController::class, 'login'])->name('login.submit');
    Route::get('/password/reset', [AdminForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/password/reset', [AdminForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/password/reset/{token}', [AdminResetPasswordController::class, 'showResetForm'])->name('password.change.show');
    Route::post('/password/reset/change', [AdminResetPasswordController::class, 'reset'])->name('password.update');
});

Route::middleware(['auth:admin'])->group(function () {
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/products', [ProductController::class, 'index'])->name('products')->middleware('permission:View Products');
    Route::get('/products/new', [ProductController::class, 'create'])->name('products.create')->middleware('permission:Add Products');
    Route::get('/products/{product:code}/show', [ProductController::class, 'show'])->name('products.show')->middleware('permission:View Products');
    Route::get('/products/{product:code}/edit', [ProductController::class, 'edit'])->name('products.edit')->middleware('permission:Edit Products');
    Route::post('/products/store', [ProductController::class, 'store'])->name('products.store')->middleware('permission:Add Products');
    Route::put('/products/{product:code}/update', [ProductController::class, 'update'])->name('products.update')->middleware('permission:Edit Products');
    Route::delete('/products/{product:code}/delete', [ProductController::class, 'destroy'])->name('products.destroy')->middleware('permission:Delete Products');
    Route::put('/products/{product:code}/feature', [ProductController::class, 'feature'])->name('products.feature')->middleware('permission:List Products');
    Route::put('/products/{product:code}/unlist', [ProductController::class, 'unlist'])->name('products.unlist')->middleware('permission:Unlist Products');
    Route::delete('/products/{product:code}/media/remove', [ProductController::class, 'removeMedia'])->name('products.media.remove')->middleware('permission:Edit Products');
    Route::get('/products/listed', [ProductController::class, 'listed'])->name('products.listed')->middleware('permission:View Products');
    Route::get('/products/details', [ProductController::class, 'show'])->name('products.details')->middleware('permission:View Products');

    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews')->middleware('permission:View Reviews');
    Route::put('/reviews/{review}/{action}', [ReviewController::class, 'action'])->name('reviews.action')->middleware('permission:Approve Reviews');

    Route::get('/subscriptions', [AdminController::class, 'subscriptions'])->name('subscriptions')->middleware('permission:View Subscriptions');
    Route::post('/subscriptions', [AdminController::class, 'sendMail'])->name('sendMail')->middleware('permission:Send Newsletter');
    Route::delete('/subscriptions/{sub}', [AdminController::class, 'deleteSubscription'])->name('deleteSubscription')->middleware('permission:Delete Subscriptions');

    Route::get('/transactions/purchases', [TransactionController::class, 'purchases'])->name('transactions.purchases')->middleware('permission:View Purchases');
    Route::get('/transactions/purchases/new', [TransactionController::class, 'createPurchase'])->name('transactions.purchases.create')->middleware('permission:Add Purchases');
    Route::post('/transactions/purchases/store', [TransactionController::class, 'storePurchase'])->name('transactions.purchases.store')->middleware('permission:Add Purchases');
    Route::get('/transactions/purchases/{purchase:code}/edit', [TransactionController::class, 'editPurchase'])->name('transactions.purchases.edit')->middleware('permission:Edit Purchases');
    Route::put('/transactions/purchases/{purchase:code}/update', [TransactionController::class, 'updatePurchase'])->name('transactions.purchases.update')->middleware('permission:Edit Purchases');
    Route::delete('/transactions/purchases/{purchase:code}/delete', [TransactionController::class, 'destroyPurchase'])->name('transactions.purchases.destroy')->middleware('permission:Delete Purchases');
    Route::get('/transactions/purchases/{purchase:code}/invoice', [TransactionController::class, 'purchaseInvoice'])->name('transactions.purchases.invoice')->middleware('permission:View Purchases');

    Route::get('/transactions/sales', [TransactionController::class, 'sales'])->name('transactions.sales')->middleware('permission:View Sales');
    Route::get('/transactions/sales/new', [TransactionController::class, 'createSale'])->name('transactions.sales.create')->middleware('permission:Add Sales');
    Route::post('/transactions/sales/store', [TransactionController::class, 'storeSale'])->name('transactions.sales.store')->middleware('permission:Add Sales');
    Route::get('/transactions/sales/{sale:code}/edit', [TransactionController::class, 'editSale'])->name('transactions.sales.edit')->middleware('permission:Edit Sales');
    Route::put('/transactions/sales/{sale:code}/update', [TransactionController::class, 'updateSale'])->name('transactions.sales.update')->middleware('permission:Edit Sales');
    Route::delete('/transactions/sales/{sale:code}/delete', [TransactionController::class, 'destroySale'])->name('transactions.sales.destroy')->middleware('permission:Delete Sales');
    Route::get('/transactions/sales/{sale:code}/invoice', [TransactionController::class, 'saleInvoice'])->name('transactions.sales.invoice')->middleware('permission:View Sales');

    Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers')->middleware('permission:View Suppliers');
    Route::post('/suppliers/store', [SupplierController::class, 'store'])->name('suppliers.store')->middleware('permission:Add Suppliers');
    Route::put('/suppliers/{supplier}/update', [SupplierController::class, 'update'])->name('suppliers.update')->middleware('permission:Edit Suppliers');
    Route::delete('/suppliers/{supplier}/delete', [SupplierController::class, 'destroy'])->name('suppliers.destroy')->middleware('permission:Delete Suppliers');

    Route::get('/users', [UserController::class, 'index'])->name('users')->middleware('permission:View Users');
    Route::put('/users/{user}/block', [UserController::class, 'block'])->name('users.block')->middleware('permission:Block Users');
    Route::put('/users/{user}/unblock', [UserController::class, 'unBlock'])->name('users.unblock')->middleware('permission:Unblock Users');
    Route::get('/users/{user}/show', [UserController::class, 'show'])->name('users.show')->middleware('permission:View Users');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders')->middleware('permission:View Orders');
    Route::put('/orders/{order}/change-state', [OrderController::class, 'changeState'])->name('orders.state.change')->middleware('permission:Process Orders');
    Route::post('/orders/{order}/update', [OrderController::class, 'update'])->name('orders.update')->middleware('permission:Process Orders');
    Route::get('/orders/{order}/show', [OrderController::class, 'show'])->name('orders.show')->middleware('permission:View Orders');

    Route::get('/banners', [BannerController::class, 'index'])->name('banners')->middleware('permission:View Banners');
    Route::post('/banners/store', [BannerController::class, 'store'])->name('banners.store')->middleware('permission:Add Banners');
    Route::put('/banners/{banner}/update', [BannerController::class, 'update'])->name('banners.update')->middleware('permission:Edit Banners');
    Route::delete('/banners/{banner}/delete', [BannerController::class, 'destroy'])->name('banners.destroy')->middleware('permission:Delete Banners');

    Route::delete('/categories/banners/{categoryBanner}/delete', [CategoryController::class, 'destroyBanner'])->name('categories.banners.destroy')->middleware('permission:Edit Categories');
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories')->middleware('permission:View Categories');
    Route::post('/categories/store', [CategoryController::class, 'store'])->name('categories.store')->middleware('permission:Add Categories');
    Route::put('/categories/{category}/update', [CategoryController::class, 'update'])->name('categories.update')->middleware('permission:Edit Categories');
    Route::delete('/categories/{category}/delete', [CategoryController::class, 'destroy'])->name('categories.destroy')->middleware('permission:Delete Categories');

    Route::get('/brands', [BrandController::class, 'index'])->name('brands')->middleware('permission:View Brands');
    Route::post('/brands/store', [BrandController::class, 'store'])->name('brands.store')->middleware('permission:Add Brands');
    Route::put('/brands/{brand}/update', [BrandController::class, 'update'])->name('brands.update')->middleware('permission:Edit Brands');
    Route::delete('/brands/{brand}/delete', [BrandController::class, 'destroy'])->name('brands.destroy')->middleware('permission:Delete Brands');

    Route::get('/variations', [VariationController::class, 'index'])->name('variations')->middleware('permission:View Variations');
    Route::post('/variations/store', [VariationController::class, 'store'])->name('variations.store')->middleware('permission:Add Variations');
    Route::put('/variations/{variation}/update', [VariationController::class, 'update'])->name('variations.update')->middleware('permission:Edit Variations');
    Route::delete('/variations/{variation}/delete', [VariationController::class, 'destroy'])->name('variations.destroy')->middleware('permission:Delete Variations');

    Route::get('/administrators', [AdminController::class, 'index'])->name('admins')->middleware('permission:View Administrators');
    Route::post('/administrators/store', [AdminController::class, 'store'])->name('admins.store')->middleware('permission:Add Administrators');
    Route::put('/administrators/{admin}/update', [AdminController::class, 'update'])->name('admins.update')->middleware('permission:Edit Administrators');
    Route::delete('/administrators/{admin}/delete', [AdminController::class, 'destroy'])->name('admins.destroy')->middleware('permission:Delete Administrators');

    Route::get('/authorization', [AuthorizationController::class, 'index'])->name('authorization')->middleware('permission:View Roles');
    Route::post('/authorization/store', [AuthorizationController::class, 'storeRole'])->name('authorization.role.store')->middleware('permission:Add Roles');
    Route::put('/authorization/{role}/update', [AuthorizationController::class, 'updateRole'])->name('authorization.role.update')->middleware('permission:Edit Roles');
    Route::delete('/authorization/{role}/delete', [AuthorizationController::class, 'destroyRole'])->name('authorization.role.destroy')->middleware('permission:Delete Roles');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
    Route::get('/notifications/details', [NotificationController::class, 'show'])->name('notifications.show');

    Route::get('/{product}/getProductDetails', [ProductController::class, 'getProductDetails']);
    Route::get('/getSubcategoriesByIds', [CategoryController::class, 'getSubcategoriesByIds']);
    Route::get('/{supplier}/getSupplierDetails', [SupplierController::class, 'getSupplierDetails']);

    Route::post('/getProductsByAjax', [ProductController::class, 'getProductsByAjax'])->name('products.ajax')->middleware('permission:View Products');
    Route::post('/getPurchasesByAjax', [TransactionController::class, 'getPurchasesByAjax'])->name('purchases.ajax')->middleware('permission:View Purchases');
    Route::post('/getSalesByAjax', [TransactionController::class, 'getSalesByAjax'])->name('sales.ajax')->middleware('permission:View Sales');
    Route::post('/getUsersByAjax', [UserController::class, 'getUsersByAjax'])->name('users.ajax')->middleware('permission:View Users');
    Route::post('/getOrdersByAjax', [OrderController::class, 'getOrdersByAjax'])->name('orders.ajax')->middleware('permission:View Orders');

    Route::post('/users/export/download', [ExportController::class, 'exportUsers'])->name('users.export')->middleware('permission:Export Users');
    Route::post('/products/export/download', [ExportController::class, 'exportProducts'])->name('products.export')->middleware('permission:Export Products');
    Route::post('/purchases/export/download', [ExportController::class, 'exportPurchases'])->name('purchases.export')->middleware('permission:Export Purchases');
    Route::post('/sales/export/download', [ExportController::class, 'exportSales'])->name('sales.export')->middleware('permission:Export Sales');

    Route::get('/settings', [HomeController::class, 'settings'])->name('settings')->middleware('permission:Update Settings');
    Route::post('/settings/business/update', [HomeController::class, 'updateBusiness'])->name('business.update')->middleware('permission:Update Settings');
    Route::put('/settings/locations/update', [HomeController::class, 'updateLocations'])->name('location.update')->middleware('permission:Update Settings');
    Route::post('/settings/bank/update', [HomeController::class, 'updateBank'])->name('bank.update')->middleware('permission:Update Settings');

    Route::get('/profile', [HomeController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [HomeController::class, 'updateProfile'])->name('profile.update');
    Route::post('/password/custom/change', [HomeController::class, 'changePasssword'])->name('password.custom.update');
    Route::get('/{type}/{code}/invoice/send', [HomeController::class, 'sendInvoiceLinkToMail'])->name('invoice.send');
});
