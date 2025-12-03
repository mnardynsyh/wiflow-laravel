<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'WifiNet - Internet Cepat & Stabil')</title>
    
    <!-- Tailwind CSS (CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js (Untuk Interaksi UI) -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Google Fonts (Inter) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: '#2563eb', // Blue 600
                        secondary: '#1e40af', // Blue 800
                    }
                }
            }
        }
    </script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass-nav {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
        }
        [x-cloak] { display: none !important; }
    </style>

    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-800 flex flex-col min-h-screen" x-data="{ mobileMenuOpen: false }">

    <!-- Navbar -->
    <nav class="glass-nav fixed w-full z-50 top-0 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <a href="{{ url('/') }}" class="flex-shrink-0 flex items-center gap-2 group">
                    <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center text-white text-xl shadow-lg shadow-blue-500/30">
                        <i class="fas fa-wifi"></i>
                    </div>
                    <span class="font-bold text-2xl tracking-tight text-slate-900 group-hover:text-primary transition-colors">WifiNet</span>
                </a>

                <!-- Desktop Menu -->
                <div class="hidden md:flex space-x-8 items-center">
                    <a href="{{ url('/#home') }}" class="text-sm font-medium text-slate-600 hover:text-primary transition">Home</a>
                    <a href="{{ url('/#paket') }}" class="text-sm font-medium text-slate-600 hover:text-primary transition">Paket</a>
                    <a href="{{ url('/#daftar') }}" class="text-sm font-medium text-slate-600 hover:text-primary transition">Daftar</a>
                    
                    @if (Route::has('login'))
                        @auth
                            @if(Auth::user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="bg-slate-900 text-white px-5 py-2.5 rounded-full text-sm font-medium hover:bg-slate-800 transition shadow-lg shadow-slate-900/20">Dashboard Admin</a>
                            @else
                                <a href="{{ route('teknisi.dashboard') }}" class="bg-emerald-600 text-white px-5 py-2.5 rounded-full text-sm font-medium hover:bg-emerald-700 transition shadow-lg shadow-emerald-600/20">Dashboard Teknisi</a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="text-primary text-sm font-bold hover:text-secondary px-4 py-2 border border-blue-100 rounded-full hover:bg-blue-50 transition">Masuk Staff</a>
                        @endauth
                    @endif
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-slate-600 hover:text-slate-900 focus:outline-none p-2 rounded-lg hover:bg-slate-100">
                        <i class="fas" :class="mobileMenuOpen ? 'fa-times' : 'fa-bars'"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div x-show="mobileMenuOpen" 
             x-collapse 
             @click.away="mobileMenuOpen = false"
             class="md:hidden bg-white border-t border-slate-100 shadow-xl">
            <div class="px-4 pt-2 pb-4 space-y-1">
                <a href="{{ url('/#home') }}" class="block px-3 py-2 rounded-md text-base font-medium text-slate-700 hover:text-primary hover:bg-blue-50">Home</a>
                <a href="{{ url('/#paket') }}" class="block px-3 py-2 rounded-md text-base font-medium text-slate-700 hover:text-primary hover:bg-blue-50">Paket</a>
                <a href="{{ url('/#daftar') }}" class="block px-3 py-2 rounded-md text-base font-medium text-slate-700 hover:text-primary hover:bg-blue-50">Daftar</a>
                <div class="border-t border-slate-100 my-2 pt-2">
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="block w-full text-center px-4 py-3 rounded-lg bg-slate-900 text-white font-bold">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="block w-full text-center px-4 py-3 rounded-lg bg-primary text-white font-bold">Login Staff</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow pt-20">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-white py-16 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center gap-2 mb-6">
                        <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center text-white">
                            <i class="fas fa-wifi"></i>
                        </div>
                        <span class="font-bold text-2xl">WifiNet</span>
                    </div>
                    <p class="text-slate-400 text-sm leading-relaxed max-w-sm">
                        Menghadirkan koneksi internet fiber optik tercepat dan terstabil untuk menunjang produktivitas digital keluarga dan bisnis Anda.
                    </p>
                </div>
                <div>
                    <h3 class="font-bold text-lg mb-6 text-white">Tautan</h3>
                    <ul class="space-y-3 text-slate-400 text-sm">
                        <li><a href="#home" class="hover:text-primary transition duration-300">Beranda</a></li>
                        <li><a href="#paket" class="hover:text-primary transition duration-300">Pilihan Paket</a></li>
                        <li><a href="#daftar" class="hover:text-primary transition duration-300">Pendaftaran</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-bold text-lg mb-6 text-white">Hubungi Kami</h3>
                    <ul class="space-y-4 text-slate-400 text-sm">
                        <li class="flex items-start gap-3">
                            <i class="fas fa-phone mt-1 text-primary"></i> 
                            <span>0812-3456-7890</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-envelope mt-1 text-primary"></i> 
                            <span>cs@wifinet.id</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-map-marker-alt mt-1 text-primary"></i> 
                            <span>Jl. Teknologi Digital No. 12</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-slate-800 mt-16 pt-8 text-center">
                <p class="text-slate-500 text-sm">&copy; {{ date('Y') }} WifiNet Indonesia. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>