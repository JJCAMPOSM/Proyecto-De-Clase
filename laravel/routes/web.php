<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Rutas para el portal de clientes externos de MACUIN.
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

// Autenticación
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('forgot-password');

// Catálogo
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');

// Carrito / Nueva Solicitud
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

// Mis Pedidos
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
