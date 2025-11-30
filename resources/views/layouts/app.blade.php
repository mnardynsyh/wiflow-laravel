<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard - WifiNet')</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js (Untuk Interaksi Sidebar & Dropdown) -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <div x-data="{ sidebarOpen: false, profileOpen: false }">

        @include('partials.sidebar-admin')

        <div class="p-4 sm:ml-64 mt-16">
            
            {{-- Flash Messages Area --}}
            <div class="min-h-[calc(100vh-8rem)]"> 
                @if(session('success'))
                    <div class="mb-4 p-4 text-sm text-green-800 rounded-lg bg-green-50 border border-green-200 flex items-center shadow-sm" role="alert">
                        <i class="fas fa-check-circle mr-2 text-lg"></i>
                        <div><span class="font-bold">Berhasil!</span> {{ session('success') }}</div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 p-4 text-sm text-red-800 rounded-lg bg-red-50 border border-red-200 flex items-center shadow-sm" role="alert">
                        <i class="fas fa-exclamation-circle mr-2 text-lg"></i>
                        <div><span class="font-bold">Error!</span> {{ session('error') }}</div>
                    </div>
                @endif

                <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg bg-white/50">
                    @yield('content')
                </div>
            </div>
        </div>
        <div x-show="sidebarOpen" 
             @click="sidebarOpen = false"
             x-transition.opacity
             class="fixed inset-0 z-30 bg-gray-900/50 sm:hidden">
        </div>

    </div>

    @stack('scripts')
</body>
</html>