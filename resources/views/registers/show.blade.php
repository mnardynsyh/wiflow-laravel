@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="bg-gray-800 px-6 py-4 flex justify-between items-center">
            <h2 class="text-white text-lg font-semibold">Detail Pendaftaran #{{ $pendaftaran->id }}</h2>
            <span class="px-3 py-1 rounded text-xs font-bold bg-white text-gray-800">
                {{ $pendaftaran->status }}
            </span>
        </div>

        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Kolom Kiri: Data Pelanggan --}}
            <div>
                <h3 class="text-gray-700 font-bold border-b pb-2 mb-3">Data Pelanggan</h3>
                <dl class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Nama:</dt>
                        <dd class="font-medium text-gray-900">{{ $pendaftaran->nama_pelanggan }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">NIK:</dt>
                        <dd class="font-medium text-gray-900">{{ $pendaftaran->nik_pelanggan ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">No HP:</dt>
                        <dd class="font-medium text-gray-900">{{ $pendaftaran->no_hp }}</dd>
                    </div>
                    <div class="mt-2">
                        <dt class="text-gray-500 mb-1">Alamat:</dt>
                        <dd class="p-2 bg-gray-50 rounded border text-gray-700">{{ $pendaftaran->alamat_pemasangan }}</dd>
                    </div>
                    @if($pendaftaran->koordinat)
                    <div class="mt-3">
                        <a href="https://www.google.com/maps/search/?api=1&query={{ $pendaftaran->koordinat }}" target="_blank" class="flex items-center gap-2 text-blue-600 hover:underline">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Buka di Google Maps
                        </a>
                    </div>
                    @endif
                </dl>
            </div>

            {{-- Kolom Kanan: Data Teknis & Jadwal --}}
            <div>
                <h3 class="text-gray-700 font-bold border-b pb-2 mb-3">Data Teknis</h3>
                <dl class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Paket Layanan:</dt>
                        <dd class="font-medium text-gray-900">{{ $pendaftaran->paket->nama_paket ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Teknisi Bertugas:</dt>
                        <dd class="font-medium text-gray-900">{{ $pendaftaran->teknisi->name ?? 'Belum ditentukan' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Jadwal:</dt>
                        <dd class="font-medium text-gray-900">
                            {{ $pendaftaran->tanggal_jadwal ? \Carbon\Carbon::parse($pendaftaran->tanggal_jadwal)->format('d F Y, H:i') : 'Belum dijadwalkan' }}
                        </dd>
                    </div>
                </dl>
                
                {{-- Jika ada laporan (opsional) --}}
                @if($pendaftaran->laporanInstalasi)
                <div class="mt-4 pt-4 border-t">
                    <h4 class="text-sm font-bold text-gray-700 mb-2">Laporan Teknisi</h4>
                    <p class="text-xs text-gray-600 italic">"{{ $pendaftaran->laporanInstalasi->isi_laporan ?? 'Tidak ada catatan' }}"</p>
                </div>
                @endif
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-50 border-t flex justify-end">
            <a href="{{ route('pendaftaran.index') }}" class="text-gray-600 hover:text-gray-900 font-medium text-sm">Kembali ke Daftar</a>
        </div>
    </div>
</div>
@endsection