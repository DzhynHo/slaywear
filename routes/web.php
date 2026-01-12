<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| STRONA GŁÓWNA – DLA WSZYSTKICH (KLIENT FRONTEND)
|--------------------------------------------------------------------------
*/
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');


/*
|--------------------------------------------------------------------------
| ADMIN – ZARZĄDZANIE PRODUKTAMI
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'checkRole:Administrator'])->group(function () {
    Route::resource('products', ProductController::class)->except(['index','show']);
});

/*
|--------------------------------------------------------------------------
| KLIENT – ZAMÓWIENIA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'checkRole:Klient'])->group(function () {
    Route::resource('orders', OrderController::class)->only(['index','store','show']);
});

/*
|--------------------------------------------------------------------------
| PRACOWNIK – OBSŁUGA ZAMÓWIEŃ
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'checkRole:Pracownik'])->group(function () {
    Route::resource('orders', OrderController::class)->only(['update']);
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('admin/products', Admin\ProductController::class);
});
