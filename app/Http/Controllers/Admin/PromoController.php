<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function index()
    {
        $promos = Promo::latest()->get();
        return view('admin.promos.index', compact('promos'));
    }

    public function create()
    {
        return view('admin.promos.create');
    }

    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'code' => 'required|string|unique:promos,code|max:20',
            'discount_amount' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date', // Tanggal akhir tidak boleh sebelum tanggal mulai
        ], [
            'code.unique' => 'Kode promo ini sudah digunakan.',
            'end_date.after_or_equal' => 'Tanggal berakhir harus setelah tanggal mulai.'
        ]);

        // 2. Simpan ke Database
        Promo::create([
            'code' => strtoupper($request->code), // Paksa jadi huruf besar
            'discount_amount' => $request->discount_amount,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_active' => true
        ]);

        // 3. Redirect
        return redirect()->route('admin.promos.index')->with('success', 'Kode Promo berhasil diterbitkan!');
    }
    
    // ... method destroy, edit, dll ...
}