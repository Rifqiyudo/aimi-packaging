@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-gray-50 font-sans">
    @include('components.admin-sidebar')

    <div class="flex-1 p-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Dashboard Admin</h1>
            <p class="text-gray-500">Ringkasan aktivitas toko hari ini.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-green-100 text-green-600 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Pendapatan</p>
                        <h3 class="text-xl font-bold text-gray-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-orange-100 text-orange-600 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Pesanan</p>
                        <h3 class="text-xl font-bold text-gray-900">{{ $totalOrders }} Order</h3>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-blue-100 text-blue-600 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Produk</p>
                        <h3 class="text-xl font-bold text-gray-900">{{ $totalProducts }} Item</h3>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-purple-100 text-purple-600 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Pelanggan</p>
                        <h3 class="text-xl font-bold text-gray-900">{{ $totalCustomers }} User</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-gray-900">Pesanan Terbaru</h3>
                    <a href="{{ route('admin.orders') }}" class="text-sm text-orange-600 hover:text-orange-700 font-medium">Lihat Semua →</a>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-600">
                        <thead class="bg-gray-50 uppercase text-xs font-bold text-gray-500">
                            <tr>
                                <th class="px-4 py-3">Invoice</th>
                                <th class="px-4 py-3">Pelanggan</th>
                                <th class="px-4 py-3">Total</th>
                                <th class="px-4 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($recentOrders as $order)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-mono">#{{ $order->invoice_number }}</td>
                                <td class="px-4 py-3">{{ $order->user->name }}</td>
                                <td class="px-4 py-3 font-bold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 rounded text-xs font-bold 
                                        {{ $order->status == 'completed' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-4 py-4 text-center text-gray-400">Belum ada pesanan masuk.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 h-fit">
                <h3 class="font-bold text-gray-900 mb-4">Stok Menipis (Warning)</h3>
                <div class="space-y-4">
                    @forelse($lowStockProducts as $product)
                    <div class="flex justify-between items-center border-b border-gray-50 pb-2 last:border-0">
                        <div class="flex items-center gap-3">
                            @if($product->image)
                                <img src="{{ asset($product->image) }}" class="w-10 h-10 rounded object-cover bg-gray-100">
                            @else
                                <div class="w-10 h-10 rounded bg-gray-200 flex items-center justify-center text-xs text-gray-500">Img</div>
                            @endif
                            <div>
                                <p class="text-sm font-medium text-gray-900 line-clamp-1 w-32">{{ $product->name }}</p>
                                <p class="text-xs text-gray-500">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        <span class="px-2 py-1 bg-red-100 text-red-600 text-xs font-bold rounded">
                            Sisa: {{ $product->stock }}
                        </span>
                    </div>
                    @empty
                    <p class="text-sm text-green-600">Aman! Tidak ada stok yang menipis.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection