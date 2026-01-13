<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ============================
// STRONA GŁÓWNA
// ============================
Route::get('/', [ProductController::class, 'index'])->name('home');

// ============================
// AUTORYZACJA (Login / Register / Logout)
// ============================
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [LoginController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [LoginController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ============================
// PROFIL (KAŻDY ZALOGOWANY)
// ============================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ============================
// KLIENT (Klient)
// ============================
// ============================
// KLIENT (Klient)
// ============================
Route::middleware(['auth', 'role:Klient'])->group(function () {
    // Koszyk
    Route::get('/cart', [OrderController::class, 'cart'])->name('cart');
    
    // Usuwanie produktu z koszyka
    Route::post('/cart/remove/{product}', [OrderController::class, 'remove'])->name('cart.remove');

    // Dodaj produkt do koszyka
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');

    // Moje zamówienia
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');

    // Płatność (fake/demo)
    Route::post('/payments', [OrderController::class, 'pay'])->name('payments.pay');
});


// ============================
// PRACOWNIK (Pracownik)
// ============================
Route::middleware(['auth', 'role:Pracownik'])->group(function () {
    Route::get('/orders/manage', [OrderController::class, 'manage'])->name('orders.manage');
    Route::patch('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');
});

// ============================
// ADMINISTRATOR
// ============================
Route::middleware(['auth', 'role:Administrator'])->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // CRUD
    Route::resource('products', ProductController::class);
    Route::resource('users', UserController::class);
    Route::resource('categories', CategoryController::class);

    // Wszystkie zamówienia
    Route::get('/orders/all', [OrderController::class, 'all'])->name('orders.all');
});
