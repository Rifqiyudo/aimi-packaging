<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil 4 produk unggulan untuk ditampilkan di beranda
        $featuredProducts = Product::where('is_featured', true)->take(4)->get();
        return view('welcome', compact('featuredProducts'));
    }
}