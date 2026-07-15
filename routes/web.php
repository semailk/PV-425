<?php

use App\Http\Controllers\BasketController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'index'])->name('home');

Route::resource('categories', CategoryController::class);

Route::resource('products', ProductController::class);

Route::get('basket', [BasketController::class, 'index'])->name('basket.index');

Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

Auth::routes();

Route::middleware('auth')->group(function () {
    // Профиль пользователя
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/orders', [ProfileController::class, 'orders'])->name('profile.orders');
    Route::get('/profile/wishlist', [ProfileController::class, 'wishlist'])->name('profile.wishlist');
    Route::get('/profile/settings', [ProfileController::class, 'settings'])->name('profile.settings');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
