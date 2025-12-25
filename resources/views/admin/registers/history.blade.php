@extends('layouts.app')

@section('title', 'Riwayat Pemasangan Selesai')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Data Pelanggan Selesai</h1>
            <p class="text-sm text-slate-500">Arsip pendaftaran yang telah berhasil dipasang.</p>
        </div>
        <div class="px-4 py-2 bg-emerald-50 text-emerald-700 rounded-lg border border-emerald-100 font-bold text-sm shadow-sm">
            <i class="fas fa-check-circle mr-2"></i> Total Terpasang: {{ $pelanggan->total() }}
        </div>
    </div>

    {{-- Search Bar --}}
    <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-200">
        <form action="{{ route('admin.riwayat') }}" method="GET" class="relative">
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="Cari nama pelanggan atau nomor HP..." 
                   class="w-full pl-10 pr-4 py-2.5 text-sm border border-slate-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 transition">
            <i class="fas fa-search absolute left-3 top-3 text-slate-400"></i>
        </form>
    </div>

    {{-- Tabel Riwayat --}}
    <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-slate-50 text-slate-600 font-bold uppercase text-[11px] border-b border-slate-200">
                <tr>
                    <th class="px-6 py-4">Tgl Selesai</th>
                    <th class="px-6 py-4">Pelanggan</th>
                    <th class="px-6 py-4">Paket</th>
                    <th class="px-6 py-4">Teknisi</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($pelanggan as $row)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-4 text-slate-600">
                        {{ $row->updated_at->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-bold text-slate-800">{{ $row->nama_pelanggan }}</div>
                        <div class="text-xs text-slate-500">{{ $row->no_hp }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 bg-indigo-50 text-indigo-700 text-xs font-bold rounded border border-indigo-100">
                            {{ $row->paket->nama_paket ?? '-' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-slate-600">
                        {{ $row->teknisi->nama ?? '-' }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700 border border-emerald-200">
                            <i class="fas fa-check-circle"></i> Selesai
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('pendaftaran.show', $row->id) }}" class="text-slate-500 hover:text-blue-600 font-bold text-xs transition border border-slate-300 px-3 py-1.5 rounded-lg hover:bg-white hover:border-blue-300">
                            Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                        Belum ada data pemasangan yang selesai.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4 border-t border-slate-200">
            {{ $pelanggan->links() }}
        </div>
    </div>
</div>
@endsection