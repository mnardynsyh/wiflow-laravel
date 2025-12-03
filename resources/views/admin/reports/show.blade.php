@extends('layouts.app')

@section('title', 'Detail Laporan #' . $laporan->id)

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    {{-- Header Navigation --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Detail Laporan Instalasi</h1>
            <p class="text-sm text-gray-500">
                <i class="far fa-clock mr-1"></i> Diselesaikan pada {{ $laporan->created_at->format('d F Y, H:i') }}
            </p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('reports.index') }}" class="px-4 py-2 bg-white border border-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition shadow-sm">
                <i class="fas fa-arrow-left mr-1"></i> Kembali
            </a>
            {{-- Tombol Edit (Hanya jika perlu revisi) --}}
            <a href="{{ route('reports.edit', $laporan->id) }}" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white font-medium rounded-lg transition shadow-sm shadow-amber-500/30">
                <i class="fas fa-pencil-alt mr-1"></i> Edit Data
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- KOLOM KIRI: BUKTI UTAMA --}}
        <div class="lg:col-span-1 space-y-6">
            {{-- Kartu Foto Bukti --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-4 border-b border-gray-100 bg-slate-50 font-bold text-gray-700 flex justify-between items-center">
                    <span>Bukti Foto</span>
                    <i class="fas fa-camera text-slate-400"></i>
                </div>
                <div class="p-4">
                    @if($laporan->bukti_foto)
                        <a href="{{ asset('storage/' . $laporan->bukti_foto) }}" target="_blank" class="group relative block rounded-lg overflow-hidden border border-slate-200 shadow-sm">
                            <img src="{{ asset('storage/' . $laporan->bukti_foto) }}" alt="Bukti Instalasi" class="w-full h-auto object-cover transition duration-300 group-hover:scale-105">
                            <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                                <span class="text-white font-bold text-sm bg-black/50 px-3 py-1 rounded-full backdrop-blur-sm">
                                    <i class="fas fa-search-plus mr-1"></i> Perbesar
                                </span>
                            </div>
                        </a>
                        <p class="text-xs text-center text-gray-400 mt-2 italic">Klik gambar untuk melihat resolusi penuh</p>
                    @else
                        <div class="h-48 bg-slate-50 rounded-lg border-2 border-dashed border-slate-200 flex flex-col items-center justify-center text-slate-400">
                            <i class="fas fa-image-slash text-3xl mb-2"></i>
                            <span class="text-sm">Tidak ada foto dilampirkan</span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Kartu Catatan --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-4 border-b border-gray-100 bg-slate-50 font-bold text-gray-700 flex justify-between items-center">
                    <span>Catatan Teknisi</span>
                    <i class="fas fa-sticky-note text-slate-400"></i>
                </div>
                <div class="p-5">
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r-lg">
                        <p class="text-sm text-gray-800 italic leading-relaxed">
                            "{{ $laporan->catatan_teknisi ?? 'Tidak ada catatan khusus yang ditambahkan oleh teknisi.' }}"
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: DETAIL INFORMASI --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                        <i class="fas fa-clipboard-list text-lg"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg text-gray-800">Informasi Pekerjaan</h3>
                        <p class="text-xs text-gray-500">Detail teknis terkait pendaftaran ini.</p>
                    </div>
                </div>
                
                <div class="p-6">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-8">
                        
                        {{-- Data Pelanggan --}}
                        <div class="col-span-2 md:col-span-1">
                            <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Nama Pelanggan</dt>
                            <dd class="text-base font-semibold text-gray-900 border-l-2 border-blue-500 pl-3">
                                {{ $laporan->pendaftaran->nama_pelanggan ?? '-' }}
                            </dd>
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">ID Pendaftaran</dt>
                            <dd class="flex items-center">
                                <span class="bg-slate-100 text-slate-600 px-3 py-1 rounded font-mono text-sm font-bold border border-slate-200">
                                    #{{ $laporan->pendaftaran->id ?? 'UNK' }}
                                </span>
                            </dd>
                        </div>

                        <div class="col-span-2">
                            <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Alamat Pemasangan</dt>
                            <dd class="text-sm text-gray-700 bg-slate-50 p-3 rounded-lg border border-slate-100">
                                {{ $laporan->pendaftaran->alamat_pemasangan ?? '-' }}
                            </dd>
                        </div>

                        {{-- Data Teknis --}}
                        <div class="col-span-2 border-t border-dashed border-gray-200 my-2"></div>

                        <div>
                            <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Teknisi Bertugas</dt>
                            <dd class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 font-bold text-xs">
                                    {{ substr($laporan->teknisi->name ?? 'T', 0, 1) }}
                                </div>
                                <span class="font-medium text-gray-800">{{ $laporan->teknisi->nama ?? 'Data User Terhapus' }}</span>
                            </dd>
                        </div>

                        <div>
                            <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Paket Layanan</dt>
                            <dd>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-100">
                                    <i class="fas fa-wifi"></i>
                                    {{ $laporan->pendaftaran->paket->nama_paket ?? 'Unknown' }}
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