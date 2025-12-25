@extends('layouts.app')

@section('title', 'Data Pendaftaran')

@section('content')
<div class="space-y-6">

    {{-- 1. HEADER HALAMAN --}}
    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Data Pendaftaran Masuk</h1>
            <p class="text-sm text-slate-500">Monitoring permintaan pemasangan dan status pengerjaan.</p>
        </div>
        
        {{-- Statistik Sederhana (Opsional - Pemanis Dashboard) --}}
        <div class="flex gap-2 text-sm">
            <span class="px-3 py-1 bg-amber-50 text-amber-600 rounded-lg border border-amber-100 font-bold">
                {{ \App\Models\Pendaftaran::where('status', 'Pending')->count() }} Pending
            </span>
            <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-lg border border-blue-100 font-bold">
                {{ \App\Models\Pendaftaran::where('status', 'Progress')->count() }} Sedang Jalan
            </span>
        </div>
    </div>

    {{-- 2. FILTER & PENCARIAN --}}
    <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-200">
        <form action="{{ route('pendaftaran.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-center">
            
            {{-- Filter Status (Dropdown) --}}
            <div class="w-full md:w-64">
                <div class="relative">
                    <select name="status" onchange="this.form.submit()" 
                            class="w-full pl-3 pr-10 py-2.5 text-sm border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 appearance-none bg-slate-50 cursor-pointer hover:bg-white transition">
                        <option value="Semua" {{ request('status') == 'Semua' ? 'selected' : '' }}>Semua Status</option>
                        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending (Baru)</option>
                        <option value="Scheduled" {{ request('status') == 'Scheduled' ? 'selected' : '' }}>Terjadwal</option>
                        <option value="Progress" {{ request('status') == 'Progress' ? 'selected' : '' }}>Sedang Dikerjakan</option>
                        <option value="Reported" {{ request('status') == 'Reported' ? 'selected' : '' }}>Butuh Verifikasi</option>
                    </select>
                    {{-- Icon Dropdown Custom --}}
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none text-slate-500">
                        <i class="fas fa-chevron-down text-xs"></i>
                    </div>
                </div>
            </div>

            {{-- Search Bar --}}
            <div class="w-full relative flex-1">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari nama pelanggan, nomor HP, atau alamat..." 
                       class="w-full pl-10 pr-10 py-2.5 text-sm border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition shadow-sm">
                <i class="fas fa-search absolute left-3 top-3 text-slate-400"></i>
                
                {{-- Tombol Clear Search --}}
                @if(request('search'))
                    <a href="{{ route('pendaftaran.index', ['status' => request('status')]) }}" 
                       class="absolute right-3 top-3 text-slate-400 hover:text-red-500 transition" title="Hapus pencarian">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- 3. TABEL DATA --}}
    <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 text-slate-600 font-bold uppercase text-[11px] border-b border-slate-200 tracking-wider">
                    <tr>
                        <th class="px-6 py-4 w-16">No</th>
                        <th class="px-6 py-4">Tanggal Masuk</th>
                        <th class="px-6 py-4">Informasi Pelanggan</th>
                        <th class="px-6 py-4">Paket & Lokasi</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pendaftarans as $index => $row)
                    <tr class="hover:bg-slate-50 transition group">
                        
                        <td class="px-6 py-4 text-slate-400 text-xs">
                            {{ $pendaftarans->firstItem() + $index }}
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-slate-700 font-medium">{{ $row->created_at->format('d M Y') }}</div>
                            <div class="text-xs text-slate-400 mt-0.5">{{ $row->created_at->format('H:i') }} WIB</div>
                        </td>

                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-800 text-base">{{ $row->nama_pelanggan }}</div>
                            <div class="text-slate-500 text-xs flex flex-col gap-1 mt-1">
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-phone fa-xs text-slate-300"></i> {{ $row->no_hp }}
                                </span>
                                @if($row->teknisi)
                                    <span class="text-blue-600 font-bold bg-blue-50 px-1.5 py-0.5 rounded w-fit">
                                        <i class="fas fa-user-hard-hat fa-xs mr-1"></i> {{ $row->teknisi->nama }}
                                    </span>
                                @endif
                            </div>
                        </td>

                        <td class="px-6 py-4 max-w-xs">
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-100 mb-1">
                                {{ $row->paket->nama_paket ?? '-' }}
                            </span>
                            <div class="text-xs text-slate-500 truncate mt-1" title="{{ $row->alamat_pemasangan }}">
                                <i class="fas fa-map-marker-alt text-slate-300 mr-1"></i>
                                {{ \Illuminate\Support\Str::limit($row->alamat_pemasangan, 35) }}
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            @php
                                $statusStyle = match($row->status) {
                                    'Pending'   => 'bg-amber-100 text-amber-800 border-amber-200',
                                    'Verified'  => 'bg-sky-100 text-sky-800 border-sky-200',
                                    'Scheduled' => 'bg-purple-100 text-purple-800 border-purple-200',
                                    'Progress'  => 'bg-blue-100 text-blue-800 border-blue-200 animate-pulse',
                                    'Reported'  => 'bg-emerald-100 text-emerald-800 border-emerald-200 ring-2 ring-emerald-50',
                                    'Completed' => 'bg-slate-100 text-slate-600 border-slate-200',
                                    default     => 'bg-gray-100'
                                };
                                
                                $statusLabel = match($row->status) {
                                    'Pending'   => 'Pending',
                                    'Verified'  => 'Terverifikasi',
                                    'Scheduled' => 'Terjadwal',
                                    'Progress'  => 'On Progress',
                                    'Reported'  => 'Verifikasi Laporan',
                                    'Completed' => 'Selesai',
                                    default     => $row->status
                                };
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold border {{ $statusStyle }}">
                                {{ $statusLabel }}
                            </span>
                        </td>

                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end items-center gap-2">
                                
                                {{-- LOGIKA TOMBOL AKSI UTAMA --}}
                                @if(in_array($row->status, ['Pending', 'Verified']))
                                    <a href="{{ route('pendaftaran.edit', $row->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-600 text-white text-xs font-bold rounded-lg hover:bg-blue-700 transition shadow-sm" title="Tugaskan Teknisi">
                                        <span>Proses</span> <i class="fas fa-arrow-right"></i>
                                    </a>

                                @elseif($row->status == 'Reported')
                                    <a href="{{ route('reports.show', $row->laporanInstalasi->id ?? '#') }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-emerald-500 text-white text-xs font-bold rounded-lg hover:bg-emerald-600 transition shadow-sm animate-bounce-slow" title="Cek Laporan">
                                        <i class="fas fa-check-circle"></i> <span>Verifikasi</span>
                                    </a>

                                @elseif($row->status == 'Completed')
                                    <a href="{{ route('pendaftaran.show', $row->id) }}" class="px-3 py-1.5 bg-white border border-slate-200 text-slate-600 text-xs font-bold rounded-lg hover:bg-slate-50 transition">
                                        Detail
                                    </a>

                                @else
                                    {{-- Scheduled / Progress --}}
                                    <a href="{{ route('pendaftaran.edit', $row->id) }}" class="px-3 py-1.5 bg-white border border-slate-200 text-slate-600 text-xs font-bold rounded-lg hover:bg-slate-50 transition" title="Edit Jadwal">
                                        <i class="fas fa-pencil-alt"></i> Edit
                                    </a>
                                @endif

                                {{-- TOMBOL HAPUS (Hanya Icon agar tidak semak) --}}
                                @if(auth()->user()->role == 'admin')
                                <form action="{{ route('pendaftaran.destroy', $row->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini secara permanen?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-8 h-8 flex items-center justify-center text-slate-300 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus Data">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </form>
                                @endif

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center justify-center text-slate-400">
                                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-3">
                                    <i class="fas fa-search text-2xl text-slate-300"></i>
                                </div>
                                <p class="font-medium text-slate-600">Data tidak ditemukan</p>
                                <p class="text-xs">Coba ubah filter atau kata kunci pencarian Anda.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="bg-white border-t border-slate-200 px-6 py-4">
            {{ $pendaftarans->links() }}
        </div>
    </div>
</div>

{{-- CSS Tambahan Kecil untuk Animasi --}}
<style>
    @keyframes bounce-slow {
        0%, 100% { transform: translateY(-3%); animation-timing-function: cubic-bezier(0.8,0,1,1); }
        50% { transform: translateY(0); animation-timing-function: cubic-bezier(0,0,0.2,1); }
    }
    .animate-bounce-slow {
        animation: bounce-slow 2s infinite;
    }
</style>
@endsection