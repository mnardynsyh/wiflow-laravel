<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>@yield('title', 'Wiflow Admin')</title>

    {{-- Jika Anda menggunakan Vite (Laravel 11 default) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Font Inter --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Font Awesome (or replace with heroicons / lucide for lighter bundle) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root{
          --sidebar-width: 260px;
        }
        body { font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; }
        /* Smooth scrollbar for desktop */
        ::-webkit-scrollbar { height:8px; width:8px; }
        ::-webkit-scrollbar-thumb { background: rgba(100,116,139,0.28); border-radius: 999px; }
    </style>
</head>
<body class="bg-gray-50 text-slate-800 antialiased">

  <div class="flex h-screen overflow-hidden">
    <!-- SIDEBAR -->
    <aside class="hidden md:flex md:flex-col w-[var(--sidebar-width)] bg-white border-r border-slate-200 shadow-sm">
      <div class="h-16 flex items-center px-6 border-b border-slate-100">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-lg bg-gradient-to-tr from-indigo-600 to-sky-500 flex items-center justify-center text-white text-lg font-semibold shadow">
            <i class="fas fa-wifi"></i>
          </div>
          <div>
            <div class="text-lg font-semibold text-slate-800">WIFLOW</div>
            <div class="text-xs text-slate-400 -mt-0.5">Admin Panel</div>
          </div>
        </div>
      </div>

      <div class="px-4 py-5 border-b border-slate-100 flex items-center gap-3">
        <div class="w-11 h-11 rounded-full bg-gradient-to-tr from-slate-800 to-slate-600 flex items-center justify-center text-white font-medium">A</div>
        <div class="flex-1">
          <div class="text-sm font-semibold text-slate-800">Admin</div>
          <div class="text-xs text-slate-400">Online</div>
        </div>
        <button class="p-2 rounded-md hover:bg-slate-100">
          <i class="fas fa-ellipsis-v text-slate-400"></i>
        </button>
      </div>

      <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-2">
        <div class="text-xs font-semibold text-slate-500 uppercase px-4 mb-1 tracking-wider">Main</div>

        <a href="{{ url('/') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg transition-colors duration-150
          {{ request()->is('/') ? 'bg-indigo-600 text-white shadow-md' : 'text-slate-700 hover:bg-slate-50' }}">
          <span class="w-8 text-center"><i class="fas fa-home"></i></span>
          <span class="font-medium">Dashboard</span>
        </a>

        <a href="{{ route('reports.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg transition-colors duration-150
          {{ request()->routeIs('reports.*') ? 'bg-indigo-600 text-white shadow-md' : 'text-slate-700 hover:bg-slate-50' }}">
          <span class="w-8 text-center"><i class="fas fa-file-alt"></i></span>
          <span class="font-medium">Laporan Instalasi</span>
        </a>

        <a href="{{ route('users.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg transition-colors duration-150
          {{ request()->routeIs('users.*') ? 'bg-indigo-600 text-white shadow-md' : 'text-slate-700 hover:bg-slate-50' }}">
          <span class="w-8 text-center"><i class="fas fa-users"></i></span>
          <span class="font-medium">Data Teknisi</span>
        </a>

        <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg text-slate-700 hover:bg-slate-50 transition">
          <span class="w-8 text-center"><i class="fas fa-cog"></i></span>
          <span class="font-medium">Pengaturan</span>
        </a>
      </nav>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <div class="px-4 py-4 border-t border-slate-100">
        <a href="#" 
          onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
          class="flex items-center gap-3 px-3 py-2 rounded-md text-red-600 hover:bg-red-50 transition">
            <i class="fas fa-sign-out-alt w-5"></i>
            <span class="font-medium">Logout</span>
        </a>
    </div>
    </aside>

    <!-- CONTENT -->
    <div class="flex-1 flex flex-col min-w-0">
      <!-- HEADER -->
      <header class="sticky top-0 z-10 bg-white border-b border-slate-200">
        <div class="max-w-full mx-auto px-4 md:px-6 lg:px-8 h-16 flex items-center justify-between">
          <div class="flex items-center gap-4">
            <button class="md:hidden p-2 rounded-md text-slate-600 hover:bg-slate-100" aria-label="Open menu">
              <i class="fas fa-bars"></i>
            </button>
            <div>
              <h1 class="text-lg font-semibold text-slate-800">@yield('header', 'Overview')</h1>
              <p class="text-xs text-slate-400 -mt-0.5">@yield('subheader', '')</p>
            </div>
          </div>

          <div class="flex items-center gap-3">
            <div class="relative">
              <input type="text" placeholder="Cari..." class="w-52 md:w-72 pl-10 pr-3 py-2 bg-slate-50 border border-slate-100 rounded-lg text-sm focus:outline-none focus:ring-1 focus:ring-indigo-300">
              <i class="fas fa-search absolute left-3 top-2.5 text-slate-400"></i>
            </div>

            <button class="p-2 rounded-full hover:bg-slate-100" title="Notifications">
              <i class="fas fa-bell text-slate-500"></i>
            </button>

            <div class="flex items-center gap-3">
              <button class="flex items-center gap-2 px-3 py-1.5 bg-indigo-600 text-white rounded-lg shadow-sm hover:shadow-md transition">
                <i class="fas fa-plus"></i>
                <span class="text-sm font-medium">Tambah</span>
              </button>

              <div class="flex items-center gap-2">
                <img src="https://ui-avatars.com/api/?name=Admin&background=3b82f6&color=fff" alt="avatar" class="w-9 h-9 rounded-full shadow-sm">
              </div>
            </div>
          </div>
        </div>
      </header>

      <!-- MAIN -->
      <main class="flex-1 overflow-y-auto p-6">
        <div class="max-w-full mx-auto">
          {{-- Example content wrapper --}}
          <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="col-span-2 space-y-6">
              <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm">
                @yield('content')
              </div>
            </div>

            <aside class="space-y-6">
              <div class="bg-white border border-slate-100 rounded-2xl p-4 shadow-sm">
                <h3 class="text-sm font-semibold text-slate-800">Ringkasan</h3>
                <div class="mt-3 text-sm text-slate-600">
                  Statistik singkat atau card kecil di sini.
                </div>
              </div>

              <div class="bg-white border border-slate-100 rounded-2xl p-4 shadow-sm">
                <h3 class="text-sm font-semibold text-slate-800">Aktivitas Terbaru</h3>
                <ul class="mt-3 text-sm text-slate-600 space-y-3">
                  <li>Permintaan #123 diproses</li>
                  <li>Teknisi baru ditambahkan</li>
                </ul>
              </div>
            </aside>
          </div>
        </div>
      </main>
    </div>
  </div>

</body>
</html>
