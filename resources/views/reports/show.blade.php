@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="bg-gray-800 text-white px-6 py-4 flex justify-between items-center">
            <h2 class="text-lg font-bold">Detail Laporan #{{ $laporan->id }}</h2>
            <span class="text-sm text-gray-300">{{ $laporan->created_at->format('d F Y, H:i') }}</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2">
            <div class="p-6 border-r border-gray-100">
                <h3 class="text-gray-700 font-bold border-b pb-2 mb-4">Informasi Pekerjaan</h3>
                
                <div class="mb-4">
                    <p class="text-sm text-gray-500">Nama Pelanggan</p>
                    <p class="font-medium text-lg">{{ $laporan->pendaftaran->nama_pelanggan ?? '-' }}</p>
                </div>

                <div class="mb-4">
                    <p class="text-sm text-gray-500">Alamat Pemasangan</p>
                    <p class="font-medium">{{ $laporan->pendaftaran->alamat_pemasangan ?? '-' }}</p>
                </div>

                <div class="mb-4">
                    <p class="text-sm text-gray-500">Teknisi Bertugas</p>
                    <p class="font-medium text-blue-600">{{ $laporan->teknisi->name ?? '-' }}</p>
                </div>

                <div class="bg-yellow-50 p-4 rounded border border-yellow-200 mt-4">
                    <p class="text-sm text-gray-500 font-bold mb-1">Catatan Teknisi:</p>
                    <p class="text-gray-700 italic">"{{ $laporan->catatan_teknisi ?? 'Tidak ada catatan khusus.' }}"</p>
                </div>
            </div>

            <div class="p-6 bg-gray-50 flex flex-col items-center justify-center">
                <h3 class="text-gray-700 font-bold mb-4 w-full border-b pb-2">Bukti Dokumentasi</h3>
                @if($laporan->bukti_foto)
                    <div class="border-4 border-white shadow-lg rounded-lg overflow-hidden">
                        <img src="{{ asset('storage/' . $laporan->bukti_foto) }}" alt="Bukti Instalasi" class="max-w-full h-auto max-h-[400px]">
                    </div>
                @else
                    <div class="flex flex-col items-center text-gray-400">
                        <i class="fas fa-image text-4xl mb-2"></i>
                        <p>Tidak ada foto dilampirkan</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="bg-gray-100 px-6 py-4 flex justify-end gap-2">
            <a href="{{ route('reports.index') }}" class="text-gray-600 hover:text-gray-900 font-medium py-2 px-4">Kembali</a>
            <a href="{{ route('reports.edit', $laporan->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded shadow">Edit Data</a>
        </div>
    </div>
</div>
@endsection