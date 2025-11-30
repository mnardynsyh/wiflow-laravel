<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'WifiNet - Internet Cepat & Stabil')</title>
    
    <!-- Tailwind CSS (CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>
    
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
        /* Custom Utilities */
        body { font-family: 'Inter', sans-serif; }
        .glass-nav {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
    </style>

    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-800 flex flex-col min-h-screen">

    <!-- Navbar -->
    <nav class="glass-nav fixed w-full z-50 top-0 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center gap-2">
                    <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center text-white text-xl">
                        <i class="fas fa-wifi"></i>
                    </div>
                    <span class="font-bold text-2xl tracking-tight text-slate-900">WifiNet</span>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex space-x-8 items-center">
                    <a href="{{ url('/#home') }}" class="text-slate-600 hover:text-primary font-medium transition">Home</a>
                    <a href="{{ url('/#paket') }}" class="text-slate-600 hover:text-primary font-medium transition">Paket</a>
                    <a href="{{ url('/#daftar') }}" class="text-slate-600 hover:text-primary font-medium transition">Daftar</a>
                    
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="bg-slate-900 text-white px-5 py-2.5 rounded-full font-medium hover:bg-slate-800 transition shadow-lg shadow-slate-900/20">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-primary font-medium hover:text-secondary">Masuk Staff</a>
                        @endauth
                    @endif
                </div>

                <!-- Mobile Menu Button (Hamburger) -->
                <div class="md:hidden flex items-center">
                    <button class="text-slate-600 hover:text-slate-900 focus:outline-none">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow pt-20">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-white py-12 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <i class="fas fa-wifi text-primary text-xl"></i>
                        <span class="font-bold text-xl">WifiNet</span>
                    </div>
                    <p class="text-slate-400 text-sm leading-relaxed">
                        Penyedia layanan internet ultra-cepat untuk kebutuhan rumah dan bisnis Anda. Stabil, terjangkau, dan terpercaya.
                    </p>
                </div>
                <div>
                    <h3 class="font-semibold text-lg mb-4">Tautan Cepat</h3>
                    <ul class="space-y-2 text-slate-400 text-sm">
                        <li><a href="#home" class="hover:text-white transition">Beranda</a></li>
                        <li><a href="#paket" class="hover:text-white transition">Cek Harga</a></li>
                        <li><a href="#daftar" class="hover:text-white transition">Pendaftaran Baru</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-semibold text-lg mb-4">Hubungi Kami</h3>
                    <ul class="space-y-2 text-slate-400 text-sm">
                        <li><i class="fas fa-phone mr-2"></i> 0812-3456-7890</li>
                        <li><i class="fas fa-envelope mr-2"></i> cs@wifinet.id</li>
                        <li><i class="fas fa-map-marker-alt mr-2"></i> Jl. Teknologi No. 12, Jakarta</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-slate-800 mt-12 pt-8 text-center text-slate-500 text-sm">
                &copy; {{ date('Y') }} WifiNet Indonesia. All Rights Reserved.
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>