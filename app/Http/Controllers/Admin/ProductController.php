<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;
use Str;

class ProductController extends Controller
{
    public function index()
    {
        return view('admin.products.index', [
            'products' => Product::with('stock','category')->get()
        ]);
    }

    public function store(Request $request)
    {
        $product = Product::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'price' => $request->price,
            'is_active' => true
        ]);

        Stock::create([
            'product_id' => $product->id,
            'quantity' => $request->stock,
            'min_stock' => 5
        ]);

        return back()->with('success','Produk berhasil dibuat');
    }
}
