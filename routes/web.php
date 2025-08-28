<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\KitchenController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\CustomerMenuController;

// Rute untuk Autentikasi (Login, Register, dll.)
Auth::routes();

// ===================================================================
// == RUTE PUBLIK UNTUK PELANGGAN (TIDAK PERLU LOGIN) ==
// ===================================================================
Route::prefix('menu/meja/{table}')->name('customer.')->group(function () {
    Route::get('/', [CustomerMenuController::class, 'showMenu'])->name('menu.table');
    Route::post('/cart/add', [CustomerMenuController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart', [CustomerMenuController::class, 'showCart'])->name('cart.show');
    Route::post('/cart/update', [CustomerMenuController::class, 'updateCart'])->name('cart.update');
    Route::post('/cart/remove', [CustomerMenuController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/order/place', [CustomerMenuController::class, 'placeOrder'])->name('order.place');
});

Route::get('/order/{invoice}/track', [CustomerMenuController::class, 'showTrackingPage'])->name('customer.order.track');
Route::get('/order/{invoice}/status', [CustomerMenuController::class, 'getOrderStatus'])->name('customer.order.status');


// ===================================================================
// == RUTE YANG MEMERLUKAN LOGIN (UNTUK STAFF) ==
// ===================================================================
Route::middleware(['auth'])->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Fitur Kasir (Bisa diakses oleh admin & kasir)
    Route::middleware(['role:admin,kasir'])->group(function () {
        Route::get('order', [OrderController::class, 'index'])->name('order.index');
        Route::post('order/detail', [OrderController::class, 'detail'])->name('order.detail');
        Route::post('order', [OrderController::class, 'store'])->name('order.store');
        Route::get('order/{inv}/cetak', [OrderController::class, 'cetak'])->name('order.cetak');
        Route::get('order/{inv}/print', [OrderController::class, 'print'])->name('order.print');
        Route::post('cart', [CartController::class, 'delete'])->name('cart.delete');
        Route::post('cart/store', [CartController::class, 'store'])->name('cart.store');
         Route::post('/order/{order}/confirm-payment', [App\Http\Controllers\OrderController::class, 'confirmPayment'])->name('order.payment.confirm');
    });

    // Fitur Dapur (Bisa diakses oleh admin & kitchen)
    Route::middleware(['role:admin,kitchen'])->group(function () {
        Route::get('/kitchen', [KitchenController::class, 'index'])->name('kitchen.index');
        Route::post('/kitchen/order/{order}/update', [KitchenController::class, 'updateStatus'])->name('kitchen.status.update');
    });

    // Fitur Admin (Hanya bisa diakses oleh admin)
    Route::middleware(['role:admin'])->group(function () {
        Route::post('category/delete', [CategoryController::class, 'delete'])->name('category.delete');
        Route::resource('category', CategoryController::class);
        Route::post('product/delete', [ProductController::class, 'delete'])->name('product.delete');
        Route::resource('product', ProductController::class);
        Route::get('report', [ReportController::class, 'index'])->name('report.index');
        Route::resource('setting', SettingController::class);
        Route::resource('tax', TaxController::class);
        Route::resource('tables', TableController::class)->except(['create', 'show', 'edit']);
        Route::get('/tables/{id}/qrcode', [TableController::class, 'qrcode'])->name('tables.qrcode');
        Route::post('card/delete', [CardController::class, 'delete'])->name('card.delete');
        Route::resource('card', CardController::class);
        Route::resource('users', App\Http\Controllers\UserController::class);
    });
});