<nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 shadow-sm">
    <div class="px-3 py-3 lg:px-5 lg:pl-3 h-16 flex items-center justify-between">
        <div class="flex items-center justify-start rtl:justify-end">
            
            {{-- Mobile Toggle Button --}}
            <button @click="sidebarOpen = !sidebarOpen" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200">
                <span class="sr-only">Open sidebar</span>
                <i class="fas fa-bars text-xl"></i>
            </button>

            {{-- Logo Brand --}}
            <a href="{{ route('teknisi.dashboard') }}" class="flex ms-2 md:me-24 items-center gap-2">
                <div class="w-8 h-8 bg-emerald-600 rounded-lg flex items-center justify-center text-white shadow-md">
                    <i class="fas fa-tools"></i>
                </div>
                <span class="self-center text-xl font-bold sm:text-2xl whitespace-nowrap text-gray-800 tracking-tight">
                    Wifi<span class="text-emerald-600">Net</span> <span class="text-xs bg-emerald-100 text-emerald-700 border border-emerald-200 px-2 py-0.5 rounded ml-1">TEKNISI</span>
                </span>
            </a>
        </div>

        {{-- User Profile Dropdown --}}
        <div class="flex items-center relative">
            <div class="flex items-center ms-3">
                <div>
                    <button @click="profileOpen = !profileOpen" @click.outside="profileOpen = false" type="button" class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-emerald-100 transition-all">
                        <span class="sr-only">Open user menu</span>
                        <img class="w-9 h-9 rounded-full object-cover border-2 border-white shadow-sm" 
                             src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->nama ?? 'Teknisi') }}&background=059669&color=FFFFFF&bold=true" 
                             alt="user photo">
                    </button>
                </div>
                
                {{-- Dropdown Menu --}}
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
                        <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->nama ?? 'Teknisi Lapangan' }}</p>
                        <p class="text-xs text-gray-500 truncate font-medium">Teknisi</p>
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

{{-- === BAGIAN 2: SIDEBAR === --}}
<aside id="logo-sidebar" 
       class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform bg-white border-r border-gray-200 sm:translate-x-0"
       :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
       aria-label="Sidebar">
       
    <div class="h-full pb-4 overflow-y-auto flex flex-col justify-between font-sans">
        
        <ul class="space-y-1 font-medium px-3">
            
            <div class="px-2 mb-2 mt-2 text-[11px] font-bold text-gray-400 uppercase tracking-widest">
                Job Desk
            </div>

            {{-- 1. Dashboard (Statistik) --}}
            <li>
                <a href="{{ route('teknisi.dashboard') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 
                   {{ request()->routeIs('teknisi.dashboard') 
                       ? 'bg-emerald-50 text-emerald-700 font-bold shadow-sm ring-1 ring-emerald-200' 
                       : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    
                    <i class="fa-solid fa-chart-pie w-6 text-center text-[18px] transition duration-200 
                       {{ request()->routeIs('teknisi.dashboard') ? 'text-emerald-600' : 'text-gray-400' }}"></i>
                    <span class="flex-1 whitespace-nowrap">Dashboard</span>
                </a>
            </li>

            {{-- 2. Tugas Saya (Daftar Lengkap) --}}
            <li>
                <a href="{{ route('teknisi.assignments.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 
                   {{ request()->routeIs('teknisi.assignments.*') 
                       ? 'bg-emerald-50 text-emerald-700 font-bold shadow-sm ring-1 ring-emerald-200' 
                       : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    
                    <i class="fa-solid fa-clipboard-list w-6 text-center text-[18px] transition duration-200 
                       {{ request()->routeIs('teknisi.assignments.*') ? 'text-emerald-600' : 'text-gray-400' }}"></i>
                    <span class="flex-1 whitespace-nowrap">Tugas Saya</span>
                </a>
            </li>

            {{-- 3. Riwayat Pekerjaan --}}
            <li>
                <a href="{{ route('teknisi.history') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 
                   {{ request()->routeIs('teknisi.history') 
                       ? 'bg-emerald-50 text-emerald-700 font-bold shadow-sm ring-1 ring-emerald-200' 
                       : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    
                    <i class="fa-solid fa-clock-rotate-left w-6 text-center text-[18px] transition duration-200 
                       {{ request()->routeIs('teknisi.history') ? 'text-emerald-600' : 'text-gray-400' }}"></i>
                    <span class="flex-1 whitespace-nowrap">Riwayat Pekerjaan</span>
                </a>
            </li>

            <div class="px-2 mb-2 mt-6 text-[11px] font-bold text-gray-400 uppercase tracking-widest">
                Pengaturan
            </div>

            {{-- 4. Profil Saya --}}
             <li>
                <a href="{{ route('teknisi.profile') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 
                   {{ request()->routeIs('teknisi.profile') 
                       ? 'bg-emerald-50 text-emerald-700 font-bold shadow-sm ring-1 ring-emerald-200' 
                       : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    
                    <i class="fa-solid fa-user-gear w-6 text-center text-[18px] transition duration-200 
                       {{ request()->routeIs('teknisi.profile') ? 'text-emerald-600' : 'text-gray-400' }}"></i>
                    <span class="flex-1 whitespace-nowrap">Profil Saya</span>
                </a>
            </li>

        </ul>

        {{-- FOOTER SIDEBAR --}}
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