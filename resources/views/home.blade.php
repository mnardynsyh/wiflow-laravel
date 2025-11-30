@extends('layouts.public')

@section('title', 'Internet Ultra Cepat - WifiNet')

@push('styles')
<style>
    html { scroll-behavior: smooth; }
    .hero-bg {
        background-image: linear-gradient(to right, rgba(15, 23, 42, 0.9), rgba(15, 23, 42, 0.7)), url('https://images.unsplash.com/photo-1544197150-b99a580bbcbf?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80');
        background-size: cover;
        background-position: center;
    }
</style>
@endpush

@section('content')

    <header id="home" class="hero-bg text-white min-h-[600px] flex items-center relative overflow-hidden">
        <div class="absolute top-0 right-0 -mt-20 -mr-20 w-96 h-96 bg-primary opacity-20 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -mb-20 -ml-20 w-80 h-80 bg-purple-600 opacity-20 rounded-full blur-3xl"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
            <div class="max-w-2xl">
                <span class="inline-block py-1 px-3 rounded-full bg-primary/20 border border-primary/50 text-blue-200 text-sm font-semibold mb-6">
                    🚀 Koneksi Fiber Optik Tercepat
                </span>
                <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight leading-tight mb-6">
                    Jelajahi Dunia Tanpa <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-400">Buffering</span>
                </h1>
                <p class="text-lg text-slate-300 mb-8 leading-relaxed">
                    Nikmati streaming 4K, gaming tanpa lag, dan work from home lancar dengan jaringan fiber optik premium kami.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="#paket" class="px-8 py-4 bg-primary hover:bg-blue-600 text-white rounded-xl font-semibold text-lg transition shadow-lg shadow-blue-600/30 text-center">
                        Lihat Paket Hemat
                    </a>
                    <a href="#daftar" class="px-8 py-4 bg-white/10 hover:bg-white/20 backdrop-blur-sm border border-white/20 text-white rounded-xl font-semibold text-lg transition text-center">
                        Daftar Sekarang
                    </a>
                </div>
            </div>
        </div>
    </header>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 rounded-lg p-4 flex items-center shadow-sm" role="alert">
                <i class="fas fa-check-circle text-green-500 mr-3 text-xl"></i>
                <div>
                    <span class="font-bold block">Sukses!</span>
                    {{ session('success') }}
                </div>
            </div>
        @endif
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-800 rounded-lg p-4 shadow-sm">
                <div class="flex items-center mb-2">
                    <i class="fas fa-exclamation-circle text-red-500 mr-2"></i>
                    <span class="font-bold">Terjadi Kesalahan:</span>
                </div>
                <ul class="list-disc list-inside text-sm ml-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <section id="paket" class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-base text-primary font-semibold tracking-wide uppercase">Pilihan Paket</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-slate-900 sm:text-4xl">
                    Harga Transparan, Tanpa Biaya Tersembunyi
                </p>
                <p class="mt-4 max-w-2xl text-xl text-slate-500 mx-auto">
                    Pilih kecepatan yang sesuai dengan kebutuhan digital rumah Anda.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($pakets as $paket)
                <div class="relative bg-white rounded-2xl shadow-xl hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 border border-slate-100 flex flex-col">
                    <div class="p-8 flex-grow">
                        <h3 class="text-xl font-bold text-slate-900">{{ $paket->nama_paket }}</h3>
                        <p class="mt-4 text-slate-500 text-sm h-12">{{ $paket->deskripsi }}</p>
                        <div class="my-6">
                            <span class="text-4xl font-extrabold text-slate-900">Rp {{ number_format($paket->harga, 0, ',', '.') }}</span>
                            <span class="text-base font-medium text-slate-500">/bulan</span>
                        </div>
                        <ul role="list" class="mt-6 space-y-4">
                            <li class="flex items-start">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-check text-green-500"></i>
                                </div>
                                <p class="ml-3 text-sm text-slate-600">Unlimited Kuota</p>
                            </li>
                            <li class="flex items-start">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-check text-green-500"></i>
                                </div>
                                <p class="ml-3 text-sm text-slate-600">Support 24/7</p>
                            </li>
                            <li class="flex items-start">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-check text-green-500"></i>
                                </div>
                                <p class="ml-3 text-sm text-slate-600">Gratis Instalasi Modem</p>
                            </li>
                        </ul>
                    </div>
                    <div class="p-8 pt-0 mt-auto">
                        <button onclick="pilihPaket({{ $paket->id }})" class="w-full block bg-slate-50 border border-slate-200 rounded-xl py-3 text-sm font-bold text-primary hover:bg-primary hover:text-white transition-colors text-center">
                            Pilih Paket Ini
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="daftar" class="py-20 bg-white relative">
        <div class="absolute inset-0 bg-slate-50 skew-y-3 transform origin-top-right -z-10 h-full"></div>
        
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-slate-100">
                <div class="grid grid-cols-1 md:grid-cols-5">
                    
                    <div class="hidden md:block col-span-2 bg-gradient-to-br from-primary to-secondary p-10 text-white flex flex-col justify-between">
                        <div>
                            <h3 class="text-2xl font-bold mb-4">Bergabung Sekarang</h3>
                            <p class="text-blue-100 mb-6">Isi formulir di samping untuk menjadwalkan pemasangan WiFi di lokasi Anda.</p>
                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center mr-3">
                                        <i class="fas fa-file-alt"></i>
                                    </div>
                                    <span>Isi Data Diri</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center mr-3">
                                        <i class="fas fa-phone"></i>
                                    </div>
                                    <span>Verifikasi Admin</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center mr-3">
                                        <i class="fas fa-tools"></i>
                                    </div>
                                    <span>Pemasangan Teknisi</span>
                                </div>
                            </div>
                        </div>
                        <div class="text-sm text-blue-200 mt-10">
                            Butuh bantuan? <br>
                            <span class="font-bold text-white">WA: 0812-3456-7890</span>
                        </div>
                    </div>

                    <div class="col-span-3 p-8 md:p-10">
                        <div class="md:hidden mb-6">
                            <h3 class="text-2xl font-bold text-slate-900">Formulir Pendaftaran</h3>
                            <p class="text-slate-500">Isi data lengkap untuk berlangganan.</p>
                        </div>

                        <form action="{{ route('pendaftaran.store') }}" method="POST">
                            @csrf
                            
                            <div class="grid grid-cols-1 gap-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap</label>
                                        {{-- Penambahan value="{{ old(...) }}" agar text tidak hilang --}}
                                        <input type="text" name="nama_pelanggan" value="{{ old('nama_pelanggan') }}" required class="w-full rounded-lg border-slate-300 focus:border-primary focus:ring focus:ring-primary/20 transition shadow-sm py-2.5 px-4" placeholder="Sesuai KTP">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-1">NIK (KTP)</label>
                                        <input type="number" name="nik_pelanggan" value="{{ old('nik_pelanggan') }}" required class="w-full rounded-lg border-slate-300 focus:border-primary focus:ring focus:ring-primary/20 transition shadow-sm py-2.5 px-4">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Nomor WhatsApp</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fab fa-whatsapp text-green-500 text-lg"></i>
                                        </div>
                                        <input type="text" name="no_hp" value="{{ old('no_hp') }}" required class="pl-10 w-full rounded-lg border-slate-300 focus:border-primary focus:ring focus:ring-primary/20 transition shadow-sm py-2.5 px-4" placeholder="08...">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Alamat Pemasangan</label>
                                    <textarea name="alamat_pemasangan" rows="3" required class="w-full rounded-lg border-slate-300 focus:border-primary focus:ring focus:ring-primary/20 transition shadow-sm py-2.5 px-4" placeholder="Nama Jalan, RT/RW, Nomor Rumah...">{{ old('alamat_pemasangan') }}</textarea>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Koordinat Lokasi</label>
                                    <div class="flex gap-2">
                                        <input type="text" name="koordinat" id="koordinat" value="{{ old('koordinat') }}" class="flex-grow rounded-lg border-slate-300 bg-slate-50 text-slate-500 focus:border-primary focus:ring focus:ring-primary/20 transition shadow-sm py-2.5 px-4" readonly placeholder="Klik tombol di samping ->">
                                        <button type="button" onclick="getLocation(this)" class="bg-slate-200 hover:bg-slate-300 text-slate-700 px-4 py-2 rounded-lg transition flex items-center gap-2 font-medium">
                                            <i class="fas fa-location-crosshairs text-primary"></i> 
                                            <span class="hidden sm:inline">Ambil Lokasi</span>
                                        </button>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Paket Pilihan</label>
                                    <div class="relative">
                                        <select name="id_paket" id="id_paket" required class="appearance-none w-full rounded-lg border-slate-300 focus:border-primary focus:ring focus:ring-primary/20 transition shadow-sm py-2.5 px-4 bg-white">
                                            <option value="" disabled selected>-- Pilih Paket Layanan --</option>
                                            @foreach($pakets as $paket)
                                                <option value="{{ $paket->id }}" {{ old('id_paket') == $paket->id ? 'selected' : '' }}>
                                                    {{ $paket->nama_paket }} - Rp {{ number_format($paket->harga, 0, ',', '.') }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                            <i class="fas fa-chevron-down text-slate-400"></i>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="w-full bg-primary hover:bg-blue-700 text-white font-bold py-3.5 px-4 rounded-xl shadow-lg shadow-blue-600/30 transition transform hover:-translate-y-0.5 mt-2">
                                    Kirim Pendaftaran
                                </button>
                            </div>
                        </form>
                    </div>
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

        // Efek visual tetap menggunakan class primary Anda
        select.classList.add('ring', 'ring-primary');
        setTimeout(() => select.classList.remove('ring', 'ring-primary'), 1000);

        document.getElementById('daftar').scrollIntoView({ behavior: 'smooth' });
    }

    function getLocation(btn) {
        const originalText = btn.innerHTML;
        
        if (navigator.geolocation) {
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
            // Disable tombol biar gak diklik berkali-kali
            btn.disabled = true;

            navigator.geolocation.getCurrentPosition(
                (position) => {
                    document.getElementById("koordinat").value = position.coords.latitude + ", " + position.coords.longitude;
                    btn.innerHTML = '<i class="fas fa-check"></i> Dapat!';
                    setTimeout(() => {
                        btn.innerHTML = originalText;
                        btn.disabled = false;
                    }, 2000);
                },
                (error) => {
                    alert("Gagal mengambil lokasi. Pastikan GPS aktif.");
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                }
            );
        } else { 
            alert("Geolocation tidak didukung.");
        }
    }
</script>
@endpush