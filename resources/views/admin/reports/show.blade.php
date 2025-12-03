@extends('layouts.app')

@section('title', 'Detail Laporan Instalasi')

@section('content')
<div class="space-y-6">
    
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Detail Laporan #{{ $laporan->id }}</h1>
            <p class="text-sm text-gray-500">
                <i class="far fa-clock mr-1"></i> Diselesaikan pada {{ $laporan->created_at->format('d F Y, H:i') }}
            </p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('reports.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-slate-600 hover:text-blue-600 bg-white border border-slate-200 px-4 py-2 rounded-lg shadow-sm transition-all hover:bg-slate-50">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <a href="{{ route('reports.edit', $laporan->id) }}" class="inline-flex items-center gap-2 text-sm font-medium text-white bg-amber-500 hover:bg-amber-600 px-4 py-2 rounded-lg shadow-sm transition-all">
                <i class="fas fa-pencil-alt"></i> Edit
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- KOLOM KIRI: Bukti Foto & Catatan --}}
        <div class="lg:col-span-1 space-y-6">
            
            {{-- Kartu Foto --}}
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-5 py-3 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
                    <h3 class="font-bold text-slate-700 text-sm">Bukti Dokumentasi</h3>
                    <i class="fas fa-camera text-slate-400"></i>
                </div>
                <div class="p-4">
                    @if($laporan->bukti_foto)
                        <a href="{{ asset('storage/' . $laporan->bukti_foto) }}" target="_blank" class="group relative block rounded-lg overflow-hidden border border-slate-200 shadow-sm">
                            <img src="{{ asset('storage/' . $laporan->bukti_foto) }}" alt="Bukti Instalasi" class="w-full h-auto object-cover transition duration-300 group-hover:scale-105">
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                                <span class="text-white text-xs font-bold bg-black/50 px-3 py-1.5 rounded-full backdrop-blur-sm">
                                    <i class="fas fa-search-plus mr-1"></i> Perbesar
                                </span>
                            </div>
                        </a>
                        <p class="text-center text-xs text-slate-400 mt-2 italic">Klik gambar untuk melihat ukuran penuh</p>
                    @else
                        <div class="h-48 bg-slate-50 rounded-lg border-2 border-dashed border-slate-200 flex flex-col items-center justify-center text-slate-400">
                            <i class="fas fa-image-slash text-3xl mb-2"></i>
                            <span class="text-sm">Tidak ada foto dilampirkan</span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Kartu Catatan --}}
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-5 py-3 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
                    <h3 class="font-bold text-slate-700 text-sm">Catatan Teknisi</h3>
                    <i class="fas fa-sticky-note text-slate-400"></i>
                </div>
                <div class="p-5">
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r-lg">
                        <p class="text-sm text-slate-800 italic leading-relaxed">
                            "{{ $laporan->catatan_teknisi ?? 'Tidak ada catatan khusus yang ditambahkan.' }}"
                        </p>
                    </div>
                </div>
            </div>

        </div>

        {{-- KOLOM KANAN: Detail Informasi --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden h-full">
                <div class="px-6 py-5 border-b border-slate-100 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                        <i class="fas fa-clipboard-list text-lg"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg text-slate-800">Informasi Pekerjaan</h3>
                        <p class="text-xs text-slate-500">Detail teknis terkait instalasi ini.</p>
                    </div>
                </div>
                
                <div class="p-6">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-8">
                        
                        {{-- Nama Pelanggan --}}
                        <div class="col-span-2 md:col-span-1">
                            <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Nama Pelanggan</dt>
                            <dd class="text-base font-semibold text-slate-900 pl-3 border-l-4 border-blue-500">
                                {{ $laporan->pendaftaran->nama_pelanggan ?? 'Data Terhapus' }}
                            </dd>
                        </div>

                        {{-- ID Pendaftaran --}}
                        <div class="col-span-2 md:col-span-1">
                            <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">ID Pendaftaran</dt>
                            <dd>
                                <span class="bg-slate-100 text-slate-600 px-3 py-1 rounded font-mono text-sm font-bold border border-slate-200">
                                    #{{ $laporan->pendaftaran->id ?? 'UNK' }}
                                </span>
                            </dd>
                        </div>

                        {{-- Alamat --}}
                        <div class="col-span-2">
                            <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Alamat Pemasangan</dt>
                            <dd class="text-sm text-slate-700 bg-slate-50 p-4 rounded-lg border border-slate-100 leading-relaxed">
                                {{ $laporan->pendaftaran->alamat_pemasangan ?? '-' }}
                            </dd>
                        </div>

                        <div class="col-span-2 border-t border-dashed border-slate-200"></div>

                        {{-- Teknisi --}}
                        <div>
                            <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Teknisi Bertugas</dt>
                            <dd class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 font-bold text-xs border border-emerald-200">
                                    {{ substr($laporan->teknisi->nama ?? 'T', 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-800">{{ $laporan->teknisi->nama ?? 'Unknown' }}</p>
                                    <p class="text-xs text-slate-500">{{ $laporan->teknisi->email ?? '' }}</p>
                                </div>
                            </dd>
                        </div>

                        {{-- Paket --}}
                        <div>
                            <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Paket Layanan</dt>
                            <dd>
                                <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg text-sm font-medium bg-indigo-50 text-indigo-700 border border-indigo-100">
                                    <i class="fas fa-wifi"></i>
                                    {{ $laporan->pendaftaran->paket->nama_paket ?? 'Unknown Packet' }}
                                </span>
                            </dd>
                        </div>

                    </dl>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection