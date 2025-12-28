<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Pelanggan\ProductController as PelangganProductController;
use App\Http\Controllers\Pelanggan\CartController;
use App\Models\Product; // <--- WAJIB DITAMBAHKAN

/*
|--------------------------------------------------------------------------
| LANDING PAGE (WELCOME)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    // Mengambil 4 produk unggulan yang aktif untuk ditampilkan di halaman depan
    $featuredProducts = Product::where('is_featured', true)
                                ->where('is_active', true)
                                ->take(4)
                                ->get();

    return view('welcome', compact('featuredProducts'));
})->name('home');

/*
|--------------------------------------------------------------------------
| AUTHENTICATION
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.process');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')->name('logout');

/*
|--------------------------------------------------------------------------
| ROLE: ADMIN (MENGGANTIKAN ADMIN + KARYAWAN)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        
        // Manajemen Produk (CRUD)
        Route::resource('/products', AdminProductController::class)->names('admin.products');
        
        // Manajemen Order (Proses Pesanan)
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders');
        Route::patch('/orders/{id}', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.update');
    });

/*
|--------------------------------------------------------------------------
| ROLE: PELANGGAN
|--------------------------------------------------------------------------
*/
Route::prefix('pelanggan')
    ->middleware(['auth', 'role:pelanggan'])
    ->group(function () {
        // Katalog & Belanja
        Route::get('/produk', [PelangganProductController::class, 'index'])->name('pelanggan.products');
        Route::get('/cart', [CartController::class, 'index'])->name('cart');
        
        // Order History
        Route::get('/orders', function() {
            return view('pelanggan.orders.index');
        })->name('pelanggan.orders');
    });