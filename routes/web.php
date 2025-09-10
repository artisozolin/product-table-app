<?php

use App\Http\Controllers\AssignHomePageController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AssignHomePageController::class, 'index']);
Route::delete('/product/{product}', [ProductController::class, 'destroy'])->name('product.destroy');
