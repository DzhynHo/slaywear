<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Strona główna - lista produktów
Route::get('/', [ProductController::class, 'index'])->name('home');

// Dashboard (np. dla admina)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Trasy wymagające zalogowania
Route::middleware('auth')->group(function () {

    // Profil użytkownika
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Zamówienia
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');

     Route::get('/cart', [OrderController::class, 'cart'])->name('cart');
    Route::post('/cart/pay', [OrderController::class, 'pay'])->name('cart.pay');
});


// Trasy autoryzacji (login, register itd.)
require __DIR__ . '/auth.php';
