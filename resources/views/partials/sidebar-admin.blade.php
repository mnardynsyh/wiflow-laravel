<nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 shadow-sm">
    <div class="px-3 py-3 lg:px-5 lg:pl-3 h-16 flex items-center justify-between">
        <div class="flex items-center justify-start rtl:justify-end">
            
            <button @click="sidebarOpen = !sidebarOpen" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200">
                <span class="sr-only">Open sidebar</span>
                <i class="fas fa-bars text-xl"></i>
            </button>

            <a href="{{ route('admin.dashboard') }}" class="flex ms-2 md:me-24 items-center gap-2">
                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white shadow-md">
                    <i class="fas fa-wifi"></i>
                </div>
                <span class="self-center text-xl font-bold sm:text-2xl whitespace-nowrap text-gray-800 tracking-tight">
                    Wifi<span class="text-blue-600">Net</span> <span class="text-xs bg-gray-100 text-gray-500 px-2 py-0.5 rounded border ml-1">ADMIN</span>
                </span>
            </a>
        </div>

        <div class="flex items-center relative">
            <div class="flex items-center ms-3">
                <div>
                    <button @click="profileOpen = !profileOpen" @click.outside="profileOpen = false" type="button" class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-blue-100 transition-all">
                        <span class="sr-only">Open user menu</span>
                        {{-- Avatar default jika user belum punya foto --}}
                        <img class="w-9 h-9 rounded-full object-cover border-2 border-white shadow-sm" 
                             src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Admin') }}&background=2563EB&color=FFFFFF&bold=true" 
                             alt="user photo">
                    </button>
                </div>
                
                <div x-show="profileOpen" 
                     x-cloak
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="transform opacity-0 scale-95"
                     x-transition:enter-end="transform opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="transform opacity-100 scale-100"
                     x-transition:leave-end="transform opacity-0 scale-95"
                     class="absolute right-0 top-10 z-50 my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow-xl border border-gray-100 w-56 origin-top-right">
                    
                    <div class="px-4 py-3 bg-gray-50 rounded-t-lg">
                        <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->name ?? 'Administrator' }}</p>
                        <p class="text-xs text-gray-500 truncate font-medium">{{ Auth::user()->email }}</p>
                    </div>
                    <ul class="py-1">
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="w-full">
                                @csrf
                                <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                    <i class="fa-solid fa-right-from-bracket mr-2 text-red-400"></i> Keluar
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>

<aside id="logo-sidebar" 
       class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform bg-white border-r border-gray-200 sm:translate-x-0"
       :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
       aria-label="Sidebar">
       
    <div class="h-full pb-4 overflow-y-auto flex flex-col justify-between font-sans">
        
        <ul class="space-y-1 font-medium px-3">
            
            <div class="px-2 mb-2 mt-2 text-[11px] font-bold text-gray-400 uppercase tracking-widest">
                Utama
            </div>

            <li>
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 
                   {{ request()->routeIs('admin.dashboard') 
                       ? 'bg-blue-50 text-blue-700 font-bold shadow-sm ring-1 ring-blue-200' 
                       : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    
                    <i class="fa-solid fa-chart-line w-6 text-center text-[18px] transition duration-200 
                       {{ request()->routeIs('admin.dashboard') ? 'text-blue-600' : 'text-gray-400' }}"></i>
                    <span class="flex-1 whitespace-nowrap">Dashboard</span>
                </a>
            </li>

            <div class="px-2 mb-2 mt-6 text-[11px] font-bold text-gray-400 uppercase tracking-widest">
                Manajemen Layanan
            </div>

            <li>
                <a href="{{ route('pendaftaran.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 
                   {{ request()->routeIs('pendaftaran.*') 
                       ? 'bg-blue-50 text-blue-700 font-bold shadow-sm ring-1 ring-blue-200' 
                       : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    
                    <i class="fa-solid fa-clipboard-check w-6 text-center text-[18px] transition duration-200 
                       {{ request()->routeIs('pendaftaran.*') ? 'text-blue-600' : 'text-gray-400' }}"></i>
                    <span class="flex-1 whitespace-nowrap">Pendaftaran Baru</span>
                </a>
            </li>

            <li>
                <a href="{{ route('reports.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 
                   {{ request()->routeIs('reports.*') 
                       ? 'bg-blue-50 text-blue-700 font-bold shadow-sm ring-1 ring-blue-200' 
                       : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    
                    <i class="fa-solid fa-file-invoice w-6 text-center text-[18px] transition duration-200 
                       {{ request()->routeIs('reports.*') ? 'text-blue-600' : 'text-gray-400' }}"></i>
                    <span class="flex-1 whitespace-nowrap">Laporan Instalasi</span>
                </a>
            </li>

            <div class="px-2 mb-2 mt-6 text-[11px] font-bold text-gray-400 uppercase tracking-widest">
                Data Master
            </div>

            {{-- MENU BARU: PAKET LAYANAN --}}
            <li>
                <a href="{{ route('plans.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 
                   {{ request()->routeIs('plans.*') 
                       ? 'bg-blue-50 text-blue-700 font-bold shadow-sm ring-1 ring-blue-200' 
                       : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    
                    <i class="fa-solid fa-tags w-6 text-center text-[18px] transition duration-200 
                       {{ request()->routeIs('plans.*') ? 'text-blue-600' : 'text-gray-400' }}"></i>
                    <span class="flex-1 whitespace-nowrap">Paket Layanan</span>
                </a>
            </li>

            <li>
                <a href="{{ route('users.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 
                   {{ request()->routeIs('users.*') 
                       ? 'bg-blue-50 text-blue-700 font-bold shadow-sm ring-1 ring-blue-200' 
                       : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    
                    <i class="fa-solid fa-users-gear w-6 text-center text-[18px] transition duration-200 
                       {{ request()->routeIs('users.*') ? 'text-blue-600' : 'text-gray-400' }}"></i>
                    <span class="flex-1 whitespace-nowrap">Kelola User</span>
                </a>
            </li>

        </ul>

        <div class="px-3 pb-6 mt-4 border-t border-gray-100 pt-6">
            <form action="{{ route('logout') }}" method="POST" class="w-full">
                @csrf
                <button type="submit"
                        class="flex items-center gap-3 px-3 py-2.5 w-full text-left rounded-lg transition-all duration-200 text-gray-600 hover:bg-red-50 hover:text-red-600 group">
                    <i class="fa-solid fa-right-from-bracket w-6 text-center text-[18px] transition group-hover:translate-x-1"></i>
                    <span class="flex-1 whitespace-nowrap font-medium">Keluar</span>
                </button>
            </form>
        </div>
    </div>
</aside>