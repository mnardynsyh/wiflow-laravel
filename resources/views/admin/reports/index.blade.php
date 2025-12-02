@extends('layouts.app')

@section('title', 'Laporan Instalasi')

@section('content')
<div class="space-y-6">

    {{-- Header Section --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">Arsip Laporan Instalasi</h2>
            <p class="text-sm text-gray-500">Rekapitulasi hasil pekerjaan instalasi yang telah selesai dikerjakan teknisi.</p>
        </div>
    </div>

    {{-- Pesan Sukses --}}
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-lg flex items-center gap-2 shadow-sm" role="alert">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- Tabel Data --}}
    <div class="bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100">
                <thead class="bg-slate-50">
                    <tr class="text-xs text-slate-500 uppercase tracking-wider">
                        <th scope="col" class="px-6 py-4 text-left font-semibold">Tanggal Selesai</th>
                        <th scope="col" class="px-6 py-4 text-left font-semibold">Data Pelanggan</th>
                        <th scope="col" class="px-6 py-4 text-left font-semibold">Teknisi Bertugas</th>
                        <th scope="col" class="px-6 py-4 text-center font-semibold">Bukti Foto</th>
                        <th scope="col" class="px-6 py-4 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-100">
                    @forelse($laporan as $item)
                    <tr class="hover:bg-slate-50 transition duration-150">
                        {{-- Kolom Tanggal --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-slate-700">
                                    {{ $item->created_at->format('d M Y') }}
                                </span>
                                <span class="text-xs text-slate-400">
                                    {{ $item->created_at->format('H:i') }} WIB
                                </span>
                            </div>
                        </td>

                        {{-- Kolom Pelanggan --}}
                        <td class="px-6 py-4">
                            <div class="flex flex-col max-w-xs">
                                <span class="text-sm font-bold text-slate-800">
                                    {{ $item->pendaftaran->nama_pelanggan ?? 'Data Terhapus' }}
                                </span>
                                <span class="text-xs text-slate-500 mt-0.5 truncate" title="{{ $item->pendaftaran->alamat_pemasangan ?? '' }}">
                                    <i class="fas fa-map-marker-alt text-red-400 mr-1"></i> 
                                    {{ Str::limit($item->pendaftaran->alamat_pemasangan ?? '-', 30) }}
                                </span>
                                <span class="text-xs text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded border border-indigo-100 w-fit mt-1">
                                    {{ $item->pendaftaran->paket->nama_paket ?? '-' }}
                                </span>
                            </div>
                        </td>

                        {{-- Kolom Teknisi --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold border border-slate-200">
                                    {{ strtoupper(substr($item->teknisi->nama ?? 'U', 0, 1)) }}
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-medium text-slate-700">
                                        {{ $item->teknisi->nama ?? 'User Terhapus' }}
                                    </span>
                                    <span class="text-xs text-slate-400">Teknisi Lapangan</span>
                                </div>
                            </div>
                        </td>

                        {{-- Kolom Bukti Foto --}}
                        <td class="px-6 py-4 text-center">
                            @if($item->bukti_foto)
                                <a href="{{ asset('storage/' . $item->bukti_foto) }}" target="_blank" class="group relative inline-block w-16 h-12 rounded-lg overflow-hidden border border-slate-200 shadow-sm hover:shadow-md transition">
                                    <img src="{{ asset('storage/' . $item->bukti_foto) }}" alt="Bukti" class="w-full h-full object-cover transition transform group-hover:scale-110">
                                    <div class="absolute inset-0 bg-black/20 group-hover:bg-black/0 transition"></div>
                                </a>
                            @else
                                <span class="text-xs italic text-slate-400 bg-slate-50 px-2 py-1 rounded border border-slate-100">
                                    No Image
                                </span>
                            @endif
                        </td>

                        {{-- Kolom Aksi --}}
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <div class="flex items-center justify-center gap-2">
                                {{-- Tombol Detail (Pengganti Edit) --}}
                                <a href="{{ route('reports.show', $item->id) }}" class="p-2 rounded-lg text-slate-500 hover:bg-blue-50 hover:text-blue-600 transition" title="Lihat Detail Lengkap">
                                    <i class="fas fa-eye"></i>
                                </a>

                                {{-- Tombol Hapus --}}
                                <form action="{{ route('reports.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini? Data yang dihapus tidak dapat dikembalikan.')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 rounded-lg text-slate-500 hover:bg-red-50 hover:text-red-600 transition" title="Hapus Laporan">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                    <i class="fas fa-clipboard-list text-slate-300 text-3xl"></i>
                                </div>
                                <h3 class="text-lg font-medium text-slate-900">Belum ada laporan masuk</h3>
                                <p class="text-slate-500 text-sm mt-1 max-w-sm">
                                    Laporan akan muncul di sini setelah teknisi menyelesaikan tugas instalasi dan mengunggah bukti.
                                </p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Pagination (Optional) --}}
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50">
            {{-- $laporan->links() --}}
        </div>
    </div>
</div>
@endsection