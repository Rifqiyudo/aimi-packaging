<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aimi Packaging - Solusi Kemasan</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="antialiased bg-gray-50 text-gray-800">

    {{-- LOGIKA HITUNG KERANJANG --}}
    @php
        $cartCount = 0;
        if(Auth::check() && Auth::user()->role === 'pelanggan'){
            try {
                $cartCount = \App\Models\Cart::where('user_id', Auth::id())->count();
            } catch(\Exception $e) {}
        }
    @endphp

    {{-- NAVBAR (Hanya muncul jika bukan halaman Admin) --}}
    @if(!request()->is('admin/*'))
    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50 shadow-sm/50 backdrop-blur-md bg-white/90">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center gap-3 group">
                        {{-- LOGO GAMBAR --}}
                        <img src="{{ asset('images/Aimi.png') }}" alt="Logo Aimi" class="h-12 w-auto object-contain group-hover:opacity-80 transition">
                        
                        {{-- Teks Brand (Opsional, bisa dihapus jika logo sudah ada teksnya) --}}
                        <div class="flex flex-col">
                            <span class="font-bold text-xl text-gray-900 tracking-tight leading-none">Aimi<span class="text-orange-600">Packaging</span></span>
                            <span class="text-[10px] text-gray-400 font-medium tracking-wider uppercase">Solusi Kemasan</span>
                        </div>
                    </a>
                </div>

                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-sm font-bold {{ request()->routeIs('home') ? 'text-orange-600' : 'text-gray-600 hover:text-orange-600' }} transition">Beranda</a>
                    <a href="{{ route('about') }}" class="text-sm font-bold {{ request()->routeIs('about') ? 'text-orange-600' : 'text-gray-600 hover:text-orange-600' }} transition">Tentang Kami</a>
                    <a href="{{ route('home') }}#katalog" class="text-sm font-bold text-gray-600 hover:text-orange-600 transition">Katalog</a>
                    <a href="{{ route('home') }}#kontak" class="text-sm font-bold text-gray-600 hover:text-orange-600 transition">Kontak</a>
                </div>

                <div class="flex items-center gap-3">
                    <button class="p-2 text-gray-400 hover:text-gray-600 transition rounded-full hover:bg-gray-100 hidden sm:block" title="Cari Produk">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </button>

                    <div class="h-6 w-px bg-gray-200 mx-2 hidden sm:block"></div>

                    @auth
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 bg-gray-900 text-white px-4 py-2 rounded-full text-xs font-bold hover:bg-gray-800 transition shadow-lg">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                                Ke Dashboard
                            </a>
                        @else
                            <a href="{{ route('cart') }}" class="relative p-2 text-gray-500 hover:text-orange-600 transition group mr-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                @if($cartCount > 0)
                                    <span class="absolute top-0 right-0 inline-flex items-center justify-center px-1.5 py-0.5 text-[10px] font-bold leading-none text-white transform translate-x-1/4 -translate-y-1/4 bg-red-600 rounded-full border-2 border-white">
                                        {{ $cartCount }}
                                    </span>
                                @endif
                            </a>
                        @endif

                        <div class="relative group cursor-pointer ml-1">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-orange-100 flex items-center justify-center text-orange-600 font-bold text-xs border border-orange-200">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            </div>
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform origin-top-right z-50">
                                <div class="px-4 py-3 border-b border-gray-50">
                                    <p class="text-xs text-gray-500">Halo,</p>
                                    <p class="text-sm font-bold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                                </div>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-red-50 rounded-b-xl font-medium transition">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-bold text-gray-600 hover:text-orange-600 transition px-3">Masuk</a>
                        <a href="{{ route('register') }}" class="px-5 py-2.5 text-sm font-bold text-white bg-orange-600 rounded-full hover:bg-orange-700 transition shadow-lg shadow-orange-200 transform hover:-translate-y-0.5">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
    @endif

    <main>
        @yield('content')
    </main>

    {{-- FOOTER GLOBAL --}}
    @if(!request()->is('admin/*'))
    <footer class="bg-gray-900 text-white pt-16 pb-8 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <div class="col-span-1 md:col-span-2">
                    
                    {{-- 2. LOGO BRAND (BAWAH POJOK KIRI) --}}
                    <img src="{{ asset('images/Aimi.png') }}" alt="Logo Aimi" class="h-16 w-auto mb-4 bg-white rounded-lg p-1">
                    
                    <p class="text-gray-400 text-sm leading-relaxed max-w-sm">
                        Partner terpercaya untuk kebutuhan packing bisnis Anda. Menyediakan lakban, bubble wrap, dan perlengkapan lainnya dengan harga grosir.
                    </p>
                </div>
                <div>
                    <h4 class="font-bold text-lg mb-4 text-gray-200">Menu Cepat</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="{{ route('home') }}" class="hover:text-orange-500 transition">Beranda</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-orange-500 transition">Tentang Kami</a></li>
                        <li><a href="#katalog" class="hover:text-orange-500 transition">Katalog Produk</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-lg mb-4 text-gray-200">Hubungi Kami</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li>WhatsApp: +62 821-3225-7239</li>
                        <li>Email: aimipacking45@gmail.com</li>
                        <li>Gresik, Jawa Timur</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center text-xs text-gray-500">
                <p>&copy; {{ date('Y') }} PT. Aimi Plastik Indonesia. All rights reserved.</p>
                <p>Designed for Excellence</p>
            </div>
        </div>
    </footer>
    @endif

</body>
</html>