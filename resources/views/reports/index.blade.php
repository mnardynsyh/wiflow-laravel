@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Daftar Laporan Instalasi</h1>
        <a href="{{ route('reports.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">
            + Buat Laporan Baru
        </a>
    </div>

    {{-- Pesan Sukses --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th class="px-6 py-3">Tanggal</th>
                    <th class="px-6 py-3">Pelanggan</th>
                    <th class="px-6 py-3">Teknisi</th>
                    <th class="px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                {{-- Kuncinya disini: KITA LOOPING DATA COLLECTION --}}
                @foreach($laporan as $item)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-6 py-4">{{ $item->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-4">{{ $item->pendaftaran->nama_pelanggan ?? '-' }}</td>
                    <td class="px-6 py-4">{{ $item->teknisi->name ?? '-' }}</td>
                    <td class="px-6 py-4">
                        <a href="{{ route('reports.edit', $item->id) }}" class="text-yellow-600 border border-yellow-600 px-2 py-1 rounded">Edit</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection