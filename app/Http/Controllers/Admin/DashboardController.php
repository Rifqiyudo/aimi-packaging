<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. KARTU STATISTIK (Ringkasan Angka)
        $totalOrders = Order::count();
        // Hitung pendapatan hanya dari yang sudah bayar (paid)
        $totalRevenue = Order::where('payment_status', 'paid')->sum('total_price');
        $totalProducts = Product::count();
        // Hitung customer (role pelanggan)
        $totalCustomers = User::where('role', 'pelanggan')->count();

        // 2. TABEL PESANAN TERBARU (Ambil 5 transaksi terakhir)
        $recentOrders = Order::with('user')->latest()->take(5)->get();

        // 3. TABEL STOK MENIPIS (Ambil 5 produk dengan stok paling sedikit)
        $lowStockProducts = Product::orderBy('stock', 'asc')->take(5)->get();

        return view('admin.dashboard', compact(
            'totalOrders', 
            'totalRevenue', 
            'totalProducts', 
            'totalCustomers',
            'recentOrders',
            'lowStockProducts'
        ));
    }
}