<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use App\Models\Product; // <--- Import Model Product
use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function index()
    {
        // Load relasi product agar nama produk muncul di tabel
        $promos = Promo::with('product')->latest()->get();
        return view('admin.promos.index', compact('promos'));
    }

    public function create()
    {
        // Ambil list produk untuk dropdown
        $products = Product::where('is_active', true)->select('id', 'name')->get();
        return view('admin.promos.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:promos,code|max:20',
            'product_id' => 'nullable|exists:products,id', // Validasi baru
            'discount_amount' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        Promo::create([
            'code' => strtoupper($request->code),
            'product_id' => $request->product_id, // Simpan ID produk (atau null)
            'discount_amount' => $request->discount_amount,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_active' => true
        ]);

        return redirect()->route('admin.promos.index')->with('success', 'Kode Promo berhasil diterbitkan!');
    }

    // ... method destroy dll tetap sama ...
    public function destroy($id)
    {
        Promo::findOrFail($id)->delete();
        return redirect()->route('admin.promos.index')->with('success', 'Promo dihapus.');
    }
}