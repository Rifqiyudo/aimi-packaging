@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-gray-50">
    @include('components.admin-sidebar')
    <div class="flex-1 p-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Buat Kode Promo Baru</h1>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 max-w-2xl">
            <form action="{{ route('admin.promos.store') }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2">Kode Promo (Unik)</label>
                    <input type="text" name="code" class="w-full border rounded-lg px-4 py-2 uppercase font-mono" placeholder="MISAL: DISKON10" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2">Nominal Diskon (Rp)</label>
                    <input type="number" name="discount_amount" class="w-full border rounded-lg px-4 py-2" placeholder="10000" required>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="block text-sm font-bold mb-2">Tanggal Mulai</label>
                        <input type="date" name="start_date" class="w-full border rounded-lg px-4 py-2" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-2">Tanggal Berakhir</label>
                        <input type="date" name="end_date" class="w-full border rounded-lg px-4 py-2" required>
                    </div>
                </div>

                <button type="submit" class="w-full px-6 py-3 bg-green-600 text-white font-bold rounded-lg hover:bg-green-700">Terbitkan Promo</button>
            </form>
        </div>
    </div>
</div>
@endsection