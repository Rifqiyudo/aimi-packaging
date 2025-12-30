<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// =================================================================
// 1. IMPORTS CONTROLLERS
// =================================================================

// A. Auth & Public
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HomeController;
use App\Models\Product; // Model Produk untuk Landing Page
use App\Models\News;    // Model Berita untuk Landing Page

// B. Controllers Admin
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\TransactionController as AdminTransactionController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\PromoController as AdminPromoController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\StockController as AdminStockController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;

// C. Controllers Pelanggan
use App\Http\Controllers\Pelanggan\ProductController as PelangganProductController;
use App\Http\Controllers\Pelanggan\CartController;
use App\Http\Controllers\Pelanggan\CheckoutController;
use App\Http\Controllers\Pelanggan\OrderController as PelangganOrderController;


// =================================================================
// 2. LANDING PAGE & HALAMAN PUBLIK
// =================================================================

// Halaman Utama (Welcome)
Route::get('/', function () {
    // 1. Ambil 4 Produk Unggulan
    $featuredProducts = Product::where('is_featured', true)
                                ->where('is_active', true)
                                ->take(4)
                                ->get();
    
    // 2. Ambil 3 Berita Terbaru (Cek dulu apakah table news ada, biar aman)
    $latestNews = collect([]);
    try {
        $latestNews = News::where('is_active', true)->latest()->take(3)->get();
    } catch (\Exception $e) {
        // Jika tabel belum dimigrate, biarkan kosong agar tidak error fatal
    }

    return view('welcome', compact('featuredProducts', 'latestNews'));
})->name('home');

// Halaman Tentang Kami (About Us) - UPDATE PERMINTAAN ANDA
Route::get('/tentang-kami', function () {
    return view('about');
})->name('about');


// =================================================================
// 3. AUTHENTICATION (LOGIN, REGISTER, LOGOUT)
// =================================================================

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');
    
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.process');
});

// Logout harus metode POST dan butuh Auth
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


// =================================================================
// 4. ROLE: ADMIN (DASHBOARD & MANAJEMEN TOKO)
// =================================================================
// Semua route di sini otomatis kena prefix 'admin' dan dicek middleware 'role:admin'

Route::prefix('admin')
    ->middleware(['auth', 'role:admin']) 
    ->group(function () {
        
        // A. Dashboard Utama
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

        // B. Manajemen Produk & Kategori (CRUD Lengkap)
        Route::resource('/products', AdminProductController::class)->names('admin.products');
        Route::resource('/categories', AdminCategoryController::class)->names('admin.categories');

        // C. Manajemen Stok (Inventory)
        Route::get('/stock', [AdminStockController::class, 'index'])->name('admin.stock.index');
        Route::post('/stock/update/{id}', [AdminStockController::class, 'update'])->name('admin.stock.update');

        // D. Manajemen Order (Pesanan Masuk)
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders');
        Route::get('/orders/{id}/edit', [AdminOrderController::class, 'edit'])->name('admin.orders.edit'); 
        Route::put('/orders/{id}', [AdminOrderController::class, 'update'])->name('admin.orders.update'); 
        Route::get('/orders/{id}/resi', [AdminOrderController::class, 'cetakResi'])->name('admin.orders.resi'); 

        // E. Riwayat Transaksi (Keuangan)
        Route::get('/transactions', [AdminTransactionController::class, 'index'])->name('admin.transactions.index');
        Route::delete('/transactions/{id}', [AdminTransactionController::class, 'destroy'])->name('admin.transactions.destroy');

        // F. Kode Promo / Diskon
        Route::resource('/promos', AdminPromoController::class)->names('admin.promos');

        // G. Laporan & Analisa
        Route::get('/reports', [AdminReportController::class, 'index'])->name('admin.reports.index');

        // H. Manajemen User
        Route::resource('/users', AdminUserController::class)->names('admin.users');

        // I. Manajemen Berita / Konten Website
        Route::resource('/news', AdminNewsController::class)->names('admin.news');
    });


// =================================================================
// 5. ROLE: PELANGGAN (BELANJA & TRACKING)
// =================================================================
// Semua route di sini otomatis kena prefix 'pelanggan' dan dicek middleware 'role:pelanggan'

Route::prefix('pelanggan')
    ->middleware(['auth', 'role:pelanggan'])
    ->group(function () {
        
        // A. Katalog Produk (View Khusus Member)
        Route::get('/produk', [PelangganProductController::class, 'index'])->name('pelanggan.products');
        Route::get('/produk/{id}', [PelangganProductController::class, 'show'])->name('pelanggan.products.show');

        // B. Keranjang Belanja (Cart)
        Route::get('/cart', [CartController::class, 'index'])->name('cart');
        Route::post('/cart/add', [CartController::class, 'store'])->name('cart.add');
        Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
        Route::delete('/cart/remove/{id}', [CartController::class, 'destroy'])->name('cart.destroy');

        // C. Checkout (Pembayaran)
        Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
        Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');

        // D. Riwayat Pesanan & Tracking
        Route::get('/orders', [PelangganOrderController::class, 'index'])->name('pelanggan.orders.index'); 
        Route::get('/orders/{id}', [PelangganOrderController::class, 'show'])->name('pelanggan.orders.show'); 
    });