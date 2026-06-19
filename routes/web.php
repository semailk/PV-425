<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('category.update');
Route::resource('categories', CategoryController::class);
