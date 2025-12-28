<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        return view('pelanggan.products.index', [
            'products' => Product::with('stock','category')
                ->where('is_active', true)
                ->paginate(12)
        ]);
    }

    public function show($slug)
    {
        $product = Product::with([
            'reviews.user',
            'stock',
            'category'
        ])->where('slug', $slug)->firstOrFail();

        return view('pelanggan.products.show', compact('product'));
    }
}
