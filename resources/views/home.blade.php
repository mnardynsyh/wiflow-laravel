@extends('layouts.public')

@section('title', 'WifiNet - Internet Fiber Optik Tanpa Batas')

@push('styles')
<style>
    html { scroll-behavior: smooth; }
    .hero-bg {
        background-image: linear-gradient(135deg, rgba(15, 23, 42, 0.95) 0%, rgba(30, 58, 138, 0.9) 100%), url('https://images.unsplash.com/photo-1544197150-b99a580bbcbf?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
    }
    .blob {
        position: absolute;
        filter: blur(80px);
        z-index: 0;
        opacity: 0.4;
    }
    /* Animasi untuk Toast */
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    .toast-animate {
        animation: slideIn 0.4s ease-out forwards;
    }
</style>
@endpush

@section('content')

    {{-- 
        FLOATING ALERTS (TOAST) 
        Menggunakan Alpine.js untuk auto-hide dan dismiss
    --}}
    <div class="fixed top-24 right-5 z-50 flex flex-col gap-3 w-full max-w-sm pointer-events-none">
        
        {{-- Success Alert --}}
        @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
             class="pointer-events-auto bg-white border-l-4 border-emerald-500 shadow-2xl rounded-lg p-4 flex items-start gap-3 transform transition-all duration-300 toast-animate">
            <div class="text-emerald-500 mt-0.5">
                <i class="fas fa-check-circle text-xl"></i>
            </div>
            <div class="flex-1">
                <h4 class="font-bold text-gray-800 text-sm">Berhasil!</h4>
                <p class="text-gray-600 text-sm mt-1">{{ session('success') }}</p>
            </div>
            <button @click="show = false" class="text-gray-400 hover:text-gray-600 transition">
                <i class="fas fa-times"></i>
            </button>
        </div>
        @endif

        {{-- Error Alert --}}
        @if ($errors->any())
        <div x-data="{ show: true }" x-show="show" 
             class="pointer-events-auto bg-white border-l-4 border-red-500 shadow-2xl rounded-lg p-4 flex items-start gap-3 transform transition-all duration-300 toast-animate">
            <div class="text-red-500 mt-0.5">
                <i class="fas fa-exclamation-circle text-xl"></i>
            </div>
            <div class="flex-1">
                <h4 class="font-bold text-gray-800 text-sm">Periksa Input Anda</h4>
                <ul class="mt-1 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li class="text-gray-600 text-xs flex items-center gap-1">
                            <i class="fas fa-dot-circle text-[6px]"></i> {{ $error }}
                        </li>
                    @endforeach
                </ul>
            </div>
            <button @click="show = false" class="text-gray-400 hover:text-gray-600 transition">
                <i class="fas fa-times"></i>
            </button>
        </div>
        @endif
    </div>

    <!-- Hero Section -->
    <header id="home" class="hero-bg text-white min-h-[700px] flex items-center relative overflow-hidden">
        <!-- Abstract Shapes -->
        <div class="blob bg-blue-500 w-96 h-96 rounded-full top-0 right-0 -mr-20 -mt-20 animate-pulse"></div>
        <div class="blob bg-purple-600 w-80 h-80 rounded-full bottom-0 left-0 -ml-20 -mb-20 animate-pulse" style="animation-delay: 2s;"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full pt-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="max-w-2xl">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-500/10 border border-blue-400/30 text-blue-200 text-sm font-semibold mb-8 backdrop-blur-sm">
                        <span class="flex h-2 w-2 relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                        </span>
                        Jaringan Fiber Optik #1 Terstabil
                    </div>
                    
                    <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight leading-tight mb-6">
                        Internet Tanpa <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-400">Batasan.</span>
                    </h1>
                    
                    <p class="text-lg text-slate-300 mb-10 leading-relaxed max-w-lg">
                        Streaming 4K lancar, gaming low latency, dan upload super cepat. Solusi konektivitas terbaik untuk rumah pintar dan bisnis Anda.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="#paket" class="group relative px-8 py-4 bg-blue-600 hover:bg-blue-500 text-white rounded-2xl font-bold text-lg transition-all shadow-lg shadow-blue-600/30 hover:shadow-blue-600/50 flex items-center justify-center gap-2 overflow-hidden">
                            <span class="relative z-10">Cek Paket</span>
                            <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform relative z-10"></i>
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-indigo-600 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        </a>
                        <a href="#daftar" class="px-8 py-4 bg-white/5 hover:bg-white/10 backdrop-blur-md border border-white/10 text-white rounded-2xl font-bold text-lg transition flex items-center justify-center">
                            Daftar Sekarang
                        </a>
                    </div>

                    <div class="mt-12 pt-8 border-t border-white/10 flex flex-wrap gap-8 text-sm text-slate-400">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-blue-500/20 flex items-center justify-center text-blue-400">
                                <i class="fas fa-check"></i>
                            </div>
                            Gratis Instalasi
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-blue-500/20 flex items-center justify-center text-blue-400">
                                <i class="fas fa-headset"></i>
                            </div>
                            Support 24/7
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-blue-500/20 flex items-center justify-center text-blue-400">
                                <i class="fas fa-tachometer-alt"></i>
                            </div>
                            Unlimited Kuota
                        </div>
                    </div>
                </div>
                
                <!-- Spacer for Grid Balance -->
                <div class="hidden lg:block relative h-full min-h-[400px]"></div>
            </div>
        </div>
    </header>

    <!-- Pricing Section -->
    <section id="paket" class="py-24 bg-slate-50 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-20">
                <span class="text-blue-600 font-bold tracking-wider uppercase text-sm">Pilihan Paket Terbaik</span>
                <h2 class="mt-3 text-4xl md:text-5xl font-extrabold text-slate-900 tracking-tight">
                    Simpel, Transparan, <br> <span class="text-blue-600">Terjangkau.</span>
                </h2>
                <p class="mt-4 text-xl text-slate-500">
                    Pilih kecepatan yang sesuai dengan kebutuhan digital Anda. Semua paket sudah termasuk modem WiFi 5Ghz.
                </p>
            </div>

            @if($pakets->isEmpty())
                <div class="text-center py-12 bg-white rounded-2xl border border-dashed border-slate-300">
                    <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400">
                        <i class="fas fa-box-open text-3xl"></i>
                    </div>
                    <p class="text-slate-500 font-medium">Belum ada paket layanan yang tersedia saat ini.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($pakets as $paket)
                    <div class="group relative bg-white rounded-[2rem] p-8 shadow-xl shadow-slate-200/50 hover:shadow-2xl hover:shadow-blue-900/10 transition-all duration-300 border border-slate-100 hover:-translate-y-2 flex flex-col h-full">
                        <!-- Decor Header -->
                        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-blue-400 to-indigo-500 rounded-t-[2rem] opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        
                        <div class="mb-6">
                            <h3 class="text-2xl font-bold text-slate-900 group-hover:text-blue-600 transition-colors">{{ $paket->nama_paket }}</h3>
                            <p class="text-slate-500 text-sm mt-2 min-h-[40px] line-clamp-2">{{ $paket->deskripsi }}</p>
                        </div>

                        <div class="flex items-baseline mb-8">
                            <span class="text-5xl font-extrabold text-slate-900 tracking-tight">
                                {{ number_format($paket->harga / 1000, 0) }}k
                            </span>
                            <span class="text-slate-400 font-medium ml-2">/ bulan</span>
                        </div>

                        <ul class="space-y-4 mb-8 flex-1">
                            <li class="flex items-center text-slate-600 text-sm">
                                <div class="w-6 h-6 rounded-full bg-blue-50 flex items-center justify-center mr-3 flex-shrink-0">
                                    <i class="fas fa-check text-blue-500 text-xs"></i>
                                </div>
                                Internet Unlimited
                            </li>
                            <li class="flex items-center text-slate-600 text-sm">
                                <div class="w-6 h-6 rounded-full bg-blue-50 flex items-center justify-center mr-3 flex-shrink-0">
                                    <i class="fas fa-wifi text-blue-500 text-xs"></i>
                                </div>
                                Modem WiFi High Speed
                            </li>
                            <li class="flex items-center text-slate-600 text-sm">
                                <div class="w-6 h-6 rounded-full bg-blue-50 flex items-center justify-center mr-3 flex-shrink-0">
                                    <i class="fas fa-headset text-blue-500 text-xs"></i>
                                </div>
                                Prioritas Support
                            </li>
                        </ul>

                        <button onclick="pilihPaket({{ $paket->id }})" class="w-full py-4 rounded-xl border-2 border-slate-100 text-slate-700 font-bold hover:border-blue-600 hover:bg-blue-600 hover:text-white transition-all duration-300 flex items-center justify-center gap-2 group-hover:border-blue-200">
                            Pilih Paket
                            <i class="fas fa-arrow-right text-sm opacity-0 group-hover:opacity-100 -translate-x-2 group-hover:translate-x-0 transition-all"></i>
                        </button>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <!-- Registration Section -->
    <section id="daftar" class="py-24 bg-white relative overflow-hidden">
        <!-- Background Decor -->
        <div class="absolute top-0 left-0 w-full h-full bg-slate-50 skew-y-3 origin-top-right transform -translate-y-20 z-0"></div>
        
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="bg-white rounded-[2.5rem] shadow-2xl overflow-hidden border border-slate-100 flex flex-col md:flex-row">
                
                <!-- Sidebar (Info) -->
                <div class="md:w-2/5 bg-slate-900 p-12 text-white flex flex-col justify-between relative overflow-hidden">
                    <!-- Decor Circles -->
                    <div class="absolute top-0 right-0 -mr-10 -mt-10 w-40 h-40 bg-blue-600 rounded-full opacity-20 blur-2xl"></div>
                    <div class="absolute bottom-0 left-0 -ml-10 -mb-10 w-40 h-40 bg-purple-600 rounded-full opacity-20 blur-2xl"></div>

                    <div class="relative z-10">
                        <h3 class="text-3xl font-bold mb-2">Mulai Berlangganan</h3>
                        <p class="text-slate-400 mb-8">Lengkapi data diri Anda untuk penjadwalan instalasi oleh teknisi profesional kami.</p>
                        
                        <div class="space-y-6">
                            <div class="flex items-start">
                                <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center flex-shrink-0 mr-4 border border-white/5">
                                    <i class="fas fa-user-edit text-blue-400 text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold">1. Isi Formulir</h4>
                                    <p class="text-sm text-slate-400">Data diri & lokasi pemasangan.</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center flex-shrink-0 mr-4 border border-white/5">
                                    <i class="fas fa-clipboard-check text-blue-400 text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold">2. Verifikasi</h4>
                                    <p class="text-sm text-slate-400">Admin kami akan memvalidasi area.</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center flex-shrink-0 mr-4 border border-white/5">
                                    <i class="fas fa-truck-fast text-blue-400 text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold">3. Instalasi</h4>
                                    <p class="text-sm text-slate-400">Teknisi datang ke lokasi Anda.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="relative z-10 mt-12 pt-8 border-t border-white/10">
                        <p class="text-sm text-slate-400">Butuh bantuan langsung?</p>
                        <a href="https://wa.me/6281234567890" class="text-lg font-bold text-white hover:text-blue-400 transition flex items-center gap-2 mt-1">
                            <i class="fab fa-whatsapp text-green-500"></i> 0812-3456-7890
                        </a>
                    </div>
                </div>

                <!-- Form -->
                <div class="md:w-3/5 p-8 md:p-12 bg-white">
                    <div class="mb-8">
                        <h3 class="text-2xl font-bold text-slate-900">Formulir Pendaftaran</h3>
                        <p class="text-slate-500">Pastikan data yang Anda masukkan valid sesuai identitas.</p>
                    </div>

                    <form action="{{ route('pendaftaran.store') }}" method="POST">
                        @csrf
                        
                        <div class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                {{-- Nama Lengkap --}}
                                <div class="space-y-1">
                                    <label class="text-sm font-semibold text-slate-700 ml-1">Nama Lengkap</label>
                                    <input type="text" name="nama_pelanggan" value="{{ old('nama_pelanggan') }}" required 
                                        class="w-full rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all py-3 px-4 font-medium text-slate-800 placeholder-slate-400" 
                                        placeholder="Sesuai KTP">
                                </div>

                                {{-- NIK (DIPERBAIKI) --}}
                                <div class="space-y-1">
                                    <label class="text-sm font-semibold text-slate-700 ml-1">NIK (KTP)</label>
                                    <input type="text" 
                                        name="nik_pelanggan" 
                                        value="{{ old('nik_pelanggan') }}" 
                                        required 
                                        inputmode="numeric" 
                                        pattern="[0-9]*" 
                                        minlength="16" 
                                        maxlength="16"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                        class="w-full rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all py-3 px-4 font-medium text-slate-800 placeholder-slate-400 font-mono" 
                                        placeholder="Harus 16 digit angka">
                                    @error('nik_pelanggan')
                                        <p class="text-red-500 text-xs ml-1 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="space-y-1">
                                <label class="text-sm font-semibold text-slate-700 ml-1">Nomor WhatsApp</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <span class="text-slate-400 font-bold text-sm">+62</span>
                                    </div>
                                    <input type="text" 
                                        name="no_hp" 
                                        value="{{ old('no_hp') }}" 
                                        required 
                                        inputmode="numeric"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                        class="w-full rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all py-3 pl-14 pr-4 font-medium text-slate-800 placeholder-slate-400" 
                                        placeholder="812...">
                                        @error('no_hp')
                                        <p class="text-red-500 text-xs ml-1 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="space-y-1">
                                <label class="text-sm font-semibold text-slate-700 ml-1">Alamat Pemasangan</label>
                                <textarea name="alamat_pemasangan" rows="3" required 
                                        class="w-full rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all py-3 px-4 font-medium text-slate-800 placeholder-slate-400 resize-none" 
                                        placeholder="Jalan, No. Rumah, RT/RW, Kelurahan, Kecamatan">{{ old('alamat_pemasangan') }}</textarea>
                            </div>

                            <div class="space-y-1">
                                <label class="text-sm font-semibold text-slate-700 ml-1">Koordinat Lokasi</label>
                                <div class="flex gap-2">
                                    <div class="relative flex-grow">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <i class="fas fa-map-pin text-slate-400"></i>
                                        </div>
                                        <input type="text" name="koordinat" id="koordinat" value="{{ old('koordinat') }}" readonly 
                                            class="w-full rounded-xl border-slate-200 bg-slate-100 text-slate-500 cursor-not-allowed py-3 pl-10 pr-4 font-medium" 
                                            placeholder="Otomatis terisi...">
                                    </div>
                                    <button type="button" onclick="getLocation(this)" 
                                            class="bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 px-5 rounded-xl transition-all font-semibold flex items-center gap-2 flex-shrink-0 active:scale-95">
                                        <i class="fas fa-location-crosshairs"></i> 
                                        <span class="hidden sm:inline">Ambil Lokasi</span>
                                    </button>
                                </div>
                                <p class="text-xs text-slate-400 ml-1">*Wajib klik tombol ambil lokasi saat berada di rumah.</p>
                            </div>

                            <div class="space-y-1">
                                <label class="text-sm font-semibold text-slate-700 ml-1">Paket Pilihan</label>
                                <div class="relative">
                                    <select name="id_paket" id="id_paket" required 
                                            class="appearance-none w-full rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all py-3 px-4 font-medium text-slate-800 cursor-pointer">
                                        <option value="" disabled selected>-- Pilih Paket Layanan --</option>
                                        @foreach($pakets as $paket)
                                            <option value="{{ $paket->id }}" {{ old('id_paket') == $paket->id ? 'selected' : '' }}>
                                                {{ $paket->nama_paket }} - Rp {{ number_format($paket->harga, 0, ',', '.') }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-500">
                                        <i class="fas fa-chevron-down"></i>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold text-lg py-4 px-6 rounded-xl shadow-xl shadow-blue-600/20 hover:shadow-blue-600/40 transition-all transform hover:-translate-y-1 mt-4">
                                Kirim Pendaftaran <i class="fas fa-paper-plane ml-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
<script>
    function pilihPaket(id) {
        const select = document.getElementById('id_paket');
        select.value = id;

        // Visual feedback
        select.classList.remove('bg-slate-50');
        select.classList.add('bg-blue-50', 'border-blue-300', 'text-blue-700');
        setTimeout(() => {
            select.classList.add('bg-slate-50');
            select.classList.remove('bg-blue-50', 'border-blue-300', 'text-blue-700');
        }, 1500);

        document.getElementById('daftar').scrollIntoView({ behavior: 'smooth' });
    }

    function getLocation(btn) {
        const originalContent = btn.innerHTML;
        
        if (navigator.geolocation) {
            btn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i>';
            btn.disabled = true;
            btn.classList.add('opacity-75', 'cursor-not-allowed');

            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const lat = position.coords.latitude.toFixed(6);
                    const long = position.coords.longitude.toFixed(6);
                    
                    document.getElementById("koordinat").value = `${lat}, ${long}`;
                    
                    // Success state
                    btn.innerHTML = '<i class="fas fa-check"></i>';
                    btn.classList.remove('bg-blue-50', 'text-blue-700');
                    btn.classList.add('bg-green-50', 'text-green-600', 'border-green-200');
                    
                    setTimeout(() => {
                        btn.innerHTML = originalContent;
                        btn.disabled = false;
                        btn.classList.remove('opacity-75', 'cursor-not-allowed', 'bg-green-50', 'text-green-600', 'border-green-200');
                        btn.classList.add('bg-blue-50', 'text-blue-700');
                    }, 2000);
                },
                (error) => {
                    alert("Gagal mengambil lokasi. Pastikan izin GPS diberikan.");
                    btn.innerHTML = originalContent;
                    btn.disabled = false;
                    btn.classList.remove('opacity-75', 'cursor-not-allowed');
                }
            );
        } else { 
            alert("Browser Anda tidak mendukung Geolocation.");
        }
    }
</script>
@endpush