@extends('layouts.app')

@section('title', 'Login - Aimi Packaging')

@section('content')
<div class="min-h-screen flex items-center justify-center p-4">
    <div class="bg-white w-full max-w-md rounded-3xl shadow-2xl overflow-hidden border border-orange-100">
        <div class="p-8">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-12 h-12 bg-orange-100 rounded-xl mb-4 text-orange-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900">Selamat Datang Kembali</h2>
                <p class="text-gray-500 text-sm mt-2">Masuk untuk mengelola pesanan kemasan Anda.</p>
            </div>

            @if($errors->any())
                <div class="mb-4 p-3 bg-red-100 text-red-600 rounded-xl text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login.process') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                    <input type="email" name="email" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition-all" placeholder="nama@email.com">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <input type="password" name="password" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition-all" placeholder="••••••••">
                </div>
                
                <button type="submit" class="w-full py-3 px-4 bg-linear-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-bold rounded-xl shadow-lg shadow-orange-500/30 transition-all transform hover:-translate-y-0.5">
                    Masuk Sekarang
                </button>
            </form>

            <div class="mt-8 text-center">
                <p class="text-sm text-gray-500">Belum punya akun? <a href="{{ route('register') }}" class="text-orange-600 font-bold hover:underline">Daftar disini</a></p>
                <div class="mt-4">
                    <a href="{{ route('home') }}" class="text-xs text-gray-400 hover:text-orange-500">← Kembali ke Beranda</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection