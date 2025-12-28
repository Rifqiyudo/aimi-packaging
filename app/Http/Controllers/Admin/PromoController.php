<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PromoController extends Controller
{
    /**
     * Tampilkan daftar promo
     */
    public function index()
    {
        return view('admin.promos.index', [
            'promos' => Promo::latest()->get()
        ]);
    }

    /**
     * Form tambah promo
     */
    public function create()
    {
        return view('admin.promos.create');
    }

    /**
     * Simpan promo baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'code'       => 'required|unique:promos,code',
            'name'       => 'required|string|max:100',
            'type'       => 'required|in:percent,fixed',
            'value'      => 'required|numeric|min:1',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date'
        ]);

        Promo::create([
            'code'       => strtoupper(Str::slug($request->code, '')),
            'name'       => $request->name,
            'type'       => $request->type,
            'value'      => $request->value,
            'start_date' => $request->start_date,
            'end_date'   => $request->end_date,
            'is_active'  => true
        ]);

        return redirect()
            ->route('admin.promos.index')
            ->with('success', 'Promo berhasil ditambahkan');
    }

    /**
     * Form edit promo
     */
    public function edit(Promo $promo)
    {
        return view('admin.promos.edit', compact('promo'));
    }

    /**
     * Update promo
     */
    public function update(Request $request, Promo $promo)
    {
        $request->validate([
            'name'       => 'required|string|max:100',
            'type'       => 'required|in:percent,fixed',
            'value'      => 'required|numeric|min:1',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date'
        ]);

        $promo->update([
            'name'       => $request->name,
            'type'       => $request->type,
            'value'      => $request->value,
            'start_date' => $request->start_date,
            'end_date'   => $request->end_date
        ]);

        return redirect()
            ->route('admin.promos.index')
            ->with('success', 'Promo berhasil diperbarui');
    }

    /**
     * Aktif / Nonaktif promo
     */
    public function toggle(Promo $promo)
    {
        $promo->update([
            'is_active' => !$promo->is_active
        ]);

        return back()->with(
            'success',
            $promo->is_active ? 'Promo diaktifkan' : 'Promo dinonaktifkan'
        );
    }

    /**
     * Hapus promo
     */
    public function destroy(Promo $promo)
    {
        $promo->delete();

        return back()->with('success', 'Promo berhasil dihapus');
    }
}
