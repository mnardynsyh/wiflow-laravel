@extends('layouts.app')

@section('title', 'Detail Pendaftaran #' . $pendaftaran->id)

@section('content')
<div class="max-w-6xl mx-auto">
    
    {{-- Header Navigation --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Detail Pendaftaran #{{ $pendaftaran->id }}</h1>
            <p class="text-sm text-gray-500">Informasi lengkap permintaan instalasi pelanggan.</p>
        </div>
        <a href="{{ route('pendaftaran.index') }}" class="text-sm font-medium text-gray-600 hover:text-blue-600 flex items-center gap-2 transition bg-white border border-gray-200 px-4 py-2 rounded-lg shadow-sm hover:shadow">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- KOLOM KIRI: Informasi Utama --}}
        <div class="lg:col-span-2 space-y-6">
            
            {{-- Card 1: Data Pelanggan --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-slate-50 flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600">
                        <i class="far fa-user"></i>
                    </div>
                    <h3 class="font-bold text-gray-800">Data Pelanggan</h3>
                </div>
                <div class="p-6">
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-6">
                        <div>
                            <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Nama Lengkap</dt>
                            <dd class="text-base font-semibold text-slate-800">{{ $pendaftaran->nama_pelanggan }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Nomor Identitas (NIK)</dt>
                            <dd class="text-base font-medium text-slate-800">{{ $pendaftaran->nik_pelanggan ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Kontak WhatsApp</dt>
                            <dd>
                                <a href="https://wa.me/{{ preg_replace('/^0/', '62', $pendaftaran->no_hp) }}" target="_blank" class="inline-flex items-center gap-2 text-emerald-600 hover:text-emerald-700 font-medium bg-emerald-50 px-3 py-1 rounded-full text-sm border border-emerald-100 transition">
                                    <i class="fab fa-whatsapp text-lg"></i> {{ $pendaftaran->no_hp }}
                                </a>
                            </dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Alamat Pemasangan</dt>
                            <dd class="text-sm text-slate-700 bg-slate-50 p-4 rounded-xl border border-slate-200 leading-relaxed">
                                {{ $pendaftaran->alamat_pemasangan }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            {{-- Card 2: Lokasi / Peta --}}
            @if($pendaftaran->koordinat)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-slate-50 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-red-100 flex items-center justify-center text-red-500">
                            <i class="fas fa-map-marked-alt"></i>
                        </div>
                        <h3 class="font-bold text-gray-800">Lokasi Pemasangan</h3>
                    </div>
                    <a href="https://www.google.com/maps/search/?api=1&query={{ $pendaftaran->koordinat }}" target="_blank" class="text-xs font-bold text-blue-600 hover:underline">
                        Buka Google Maps <i class="fas fa-external-link-alt ml-1"></i>
                    </a>
                </div>
                {{-- Embed Map --}}
                <div class="relative h-64 bg-slate-100">
                    <iframe 
                        width="100%" 
                        height="100%" 
                        frameborder="0" 
                        scrolling="no" 
                        marginheight="0" 
                        marginwidth="0" 
                        src="https://maps.google.com/maps?q={{ $pendaftaran->koordinat }}&z=15&output=embed">
                    </iframe>
                </div>
            </div>
            @endif

            {{-- Card 3: Laporan Hasil (Hanya muncul jika sudah ada laporan) --}}
            @if($pendaftaran->laporanInstalasi)
            <div class="bg-white rounded-xl shadow-sm border border-emerald-200 overflow-hidden ring-1 ring-emerald-100">
                <div class="px-6 py-4 border-b border-emerald-100 bg-emerald-50 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-emerald-200 flex items-center justify-center text-emerald-700">
                            <i class="fas fa-clipboard-check"></i>
                        </div>
                        <h3 class="font-bold text-emerald-900">Laporan Penyelesaian</h3>
                    </div>
                    <span class="text-xs font-bold text-emerald-700 bg-white border border-emerald-200 px-3 py-1 rounded-full">
                        {{ $pendaftaran->laporanInstalasi->created_at->format('d M Y, H:i') }}
                    </span>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Catatan Teknisi</h4>
                        <div class="text-sm text-slate-700 italic bg-slate-50 p-4 rounded-lg border border-slate-200">
                            "{{ $pendaftaran->laporanInstalasi->catatan_teknisi ?? 'Tidak ada catatan khusus.' }}"
                        </div>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Bukti Foto</h4>
                        @if($pendaftaran->laporanInstalasi->bukti_foto)
                            <a href="{{ asset('storage/' . $pendaftaran->laporanInstalasi->bukti_foto) }}" target="_blank" class="group block relative rounded-lg overflow-hidden border border-slate-200 shadow-sm hover:shadow-md transition">
                                <img src="{{ asset('storage/' . $pendaftaran->laporanInstalasi->bukti_foto) }}" alt="Bukti Foto" class="w-full h-32 object-cover transition transform group-hover:scale-105">
                                <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                                    <span class="text-white text-sm font-bold bg-black/50 px-3 py-1 rounded-full backdrop-blur-sm">
                                        <i class="fas fa-search-plus mr-1"></i> Perbesar
                                    </span>
                                </div>
                            </a>
                        @else
                            <div class="h-32 bg-slate-50 rounded-lg border border-dashed border-slate-300 flex items-center justify-center text-slate-400 text-sm">
                                Tidak ada foto
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif

        </div>

        {{-- KOLOM KANAN: Status & Info Teknis --}}
        <div class="lg:col-span-1 space-y-6">
            
            {{-- Card Status --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Status Pengerjaan</h3>
                
                @php
                    $statusStyles = [
                        'pending' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'border' => 'border-amber-200', 'icon' => 'fa-clock'],
                        'dijadwalkan' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-700', 'border' => 'border-blue-200', 'icon' => 'fa-calendar-check'],
                        'selesai' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'border' => 'border-emerald-200', 'icon' => 'fa-check-circle'],
                        'batal' => ['bg' => 'bg-red-50', 'text' => 'text-red-700', 'border' => 'border-red-200', 'icon' => 'fa-times-circle'],
                    ];
                    $style = $statusStyles[$pendaftaran->status] ?? $statusStyles['pending'];
                @endphp

                <div class="flex flex-col items-center justify-center p-6 rounded-xl border {{ $style['border'] }} {{ $style['bg'] }} mb-6">
                    <i class="fas {{ $style['icon'] }} text-3xl mb-2 {{ $style['text'] }}"></i>
                    <span class="text-xl font-bold uppercase {{ $style['text'] }}">{{ $pendaftaran->status }}</span>
                </div>

                @if($pendaftaran->status == 'pending' && Auth::user()->role == 'admin')
                    <a href="{{ route('pendaftaran.edit', $pendaftaran->id) }}" class="flex items-center justify-center w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg transition shadow-lg shadow-blue-500/20 gap-2">
                        <i class="fas fa-edit"></i> Proses Sekarang
                    </a>
                @endif
            </div>

            {{-- Card Info Teknis --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-slate-50">
                    <h3 class="font-bold text-gray-800 text-sm">Informasi Teknis</h3>
                </div>
                <div class="p-6 space-y-5">
                    
                    {{-- Paket --}}
                    <div>
                        <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Paket Layanan</dt>
                        <dd class="flex items-center gap-2 bg-indigo-50 px-3 py-2 rounded-lg border border-indigo-100 text-indigo-700">
                            <i class="fas fa-wifi"></i>
                            <span class="font-semibold">{{ $pendaftaran->paket->nama_paket ?? 'Unknown Packet' }}</span>
                        </dd>
                    </div>
                    
                    {{-- Teknisi --}}
                    <div class="pt-4 border-t border-dashed border-gray-200">
                        <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Teknisi Bertugas</dt>
                        <dd>
                            @if($pendaftaran->teknisi)
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold border-2 border-white shadow-sm">
                                        {{ substr($pendaftaran->teknisi->nama, 0, 1) }}
                                    </div>
                                    <div class="overflow-hidden">
                                        <p class="text-sm font-bold text-gray-800 truncate">{{ $pendaftaran->teknisi->nama }}</p>
                                        <p class="text-xs text-gray-500 truncate">{{ $pendaftaran->teknisi->email }}</p>
                                    </div>
                                </div>
                            @else
                                <span class="text-sm text-slate-400 italic flex items-center gap-1">
                                    <i class="fas fa-exclamation-circle"></i> Belum ditugaskan
                                </span>
                            @endif
                        </dd>
                    </div>

                    {{-- Jadwal --}}
                    <div class="pt-4 border-t border-dashed border-gray-200">
                        <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Jadwal Instalasi</dt>
                        <dd class="font-medium text-slate-800">
                            @if($pendaftaran->tanggal_jadwal)
                                <div class="flex items-center gap-2 mb-1">
                                    <i class="far fa-calendar-alt text-blue-500"></i>
                                    {{ \Carbon\Carbon::parse($pendaftaran->tanggal_jadwal)->translatedFormat('l, d F Y') }}
                                </div>
                                <div class="flex items-center gap-2 text-sm text-slate-500 ml-6">
                                    <i class="far fa-clock"></i>
                                    {{ \Carbon\Carbon::parse($pendaftaran->tanggal_jadwal)->format('H:i') }} WIB
                                </div>
                            @else
                                <span class="text-slate-400 italic text-sm">Belum dijadwalkan</span>
                            @endif
                        </dd>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection