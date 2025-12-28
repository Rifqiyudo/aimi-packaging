<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aimi Packaging | Solusi Kemasan Terbaik</title>
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        orange: {
                            500: '#F53003', // Orange Utama Aimi
                            600: '#D92800', // Orange Gelap (Hover)
                            50: '#FFF5F2',  // Orange Background Tipis
                        }
                    },
                    fontFamily: {
                        sans: ['Instrument Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="font-sans text-gray-800 antialiased bg-white flex flex-col min-h-screen">
    
    <nav class="sticky top-0 z-50 bg-white/95 backdrop-blur shadow-sm border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <img src="{{ asset('images/Aimi.png') }}" class="h-10 w-auto" alt="Logo">
                    <span class="text-xl font-bold tracking-tight text-gray-900">Packaging</span>
                </a>
                
                <div class="hidden md:flex items-center gap-8 text-sm font-medium text-gray-600">
                    <a href="{{ route('home') }}" class="hover:text-orange-500 transition">Beranda</a>
                    <a href="#about" class="hover:text-orange-500 transition">Tentang Kami</a>
                    <a href="#katalog" class="hover:text-orange-500 transition">Katalog</a>
                    <a href="#kontak" class="hover:text-orange-500 transition">Kontak</a>
                </div>

                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ Auth::user()->role == 'admin' ? route('admin.dashboard') : '#' }}" class="text-sm font-medium">Halo, {{ Auth::user()->name }}</a>
                        <form action="{{ route('logout') }}" method="POST">@csrf <button class="text-sm text-red-500 hover:text-red-700">Logout</button></form>
                    @else
                        <a href="{{ route('login') }}" class="px-5 py-2.5 text-sm font-bold text-orange-500 border border-orange-500 rounded-full hover:bg-orange-50 transition">Masuk</a>
                        <a href="{{ route('register') }}" class="px-5 py-2.5 text-sm font-bold text-white bg-orange-500 rounded-full hover:bg-orange-600 shadow-lg shadow-orange-500/30 transition">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="grow">
        @yield('content')
    </main>

    <footer class="bg-gray-900 text-white py-12 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-4 gap-8">
            <div class="col-span-1 md:col-span-2">
                <div class="flex items-center gap-2 mb-4">
                    <img src="{{ asset('images/Aimi.png') }}" class="h-8 w-auto bg-white rounded px-1">
                    <span class="text-xl font-bold">Aimi Packaging</span>
                </div>
                <p class="text-gray-400 text-sm leading-relaxed max-w-sm">
                    Mitra terpercaya untuk kebutuhan kemasan bisnis Anda. Kami menyediakan solusi packaging berkualitas tinggi dengan harga kompetitif.
                </p>
            </div>
            <div>
                <h4 class="font-bold text-lg mb-4 text-orange-500">Menu</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li><a href="#" class="hover:text-white">Beranda</a></li>
                    <li><a href="#" class="hover:text-white">Katalog Produk</a></li>
                    <li><a href="#" class="hover:text-white">Tentang Kami</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-lg mb-4 text-orange-500">Hubungi Kami</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li>Surabaya, Jawa Timur</li>
                    <li>support@aimipackaging.com</li>
                    <li>+62 838-2247-6274</li>
                </ul>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-6 mt-12 pt-8 border-t border-gray-800 text-center text-xs text-gray-500">
            © {{ date('Y') }} Aimi Packaging. All rights reserved.
        </div>
    </footer>
</body>
</html>