@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-gray-50 font-sans text-gray-800">
    @include('components.admin-sidebar')

    <div class="flex-1 p-8 overflow-y-auto h-screen">
        
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Buat Kode Promo Baru</h1>
            <a href="{{ route('admin.promos.index') }}" class="text-gray-500 hover:text-orange-600 font-bold transition">
                &larr; Kembali
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 max-w-3xl mx-auto">
            <form action="{{ route('admin.promos.store') }}" method="POST">
                @csrf
                
                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Kode Promo (Unik)</label>
                    <input type="text" name="code" 
                           class="w-full border-gray-300 rounded-xl px-4 py-3 uppercase font-mono tracking-wider focus:ring-orange-500 focus:border-orange-500 transition" 
                           placeholder="CONTOH: RAMADHAN2025" required>
                </div>

                {{-- PILIHAN PRODUK (BARU) --}}
                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Target Produk</label>
                    <select name="product_id" class="w-full border-gray-300 rounded-xl px-4 py-3 focus:ring-orange-500 focus:border-orange-500 transition">
                        <option value="">-- Berlaku Untuk Semua Produk (Global) --</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-400 mt-2">Biarkan kosong jika promo berlaku untuk total keranjang belanja.</p>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nominal Potongan (Rp)</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500 font-bold">Rp</span>
                        <input type="number" name="discount_amount" 
                               class="w-full pl-10 border-gray-300 rounded-xl px-4 py-3 focus:ring-orange-500 focus:border-orange-500 transition" 
                               placeholder="10000" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Tanggal Mulai</label>
                        <input type="date" name="start_date" class="w-full border-gray-300 rounded-xl px-4 py-3 focus:ring-orange-500 focus:border-orange-500 transition" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Tanggal Berakhir</label>
                        <input type="date" name="end_date" class="w-full border-gray-300 rounded-xl px-4 py-3 focus:ring-orange-500 focus:border-orange-500 transition" required>
                    </div>
                </div>

                <button type="submit" class="w-full px-6 py-3.5 bg-orange-600 text-white font-bold rounded-xl hover:bg-orange-700 transition shadow-lg shadow-orange-200">
                    Terbitkan Promo
                </button>
            </form>
        </div>
    </div>
</div>
@endsection