@extends('layouts.app')

@section('title', 'Admin Dashboard - WifiNet')

@section('content')
<div class="space-y-8">

    {{-- Header Section --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-gray-200 pb-6">
        <div>
            <h2 class="text-3xl font-extrabold tracking-tight text-gray-900">Dashboard</h2>
            <p class="mt-1 text-sm text-gray-500">Ringkasan operasional dan aktivitas terbaru.</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="hidden md:flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-lg shadow-sm text-sm font-medium text-gray-600">
                <i class="far fa-calendar-alt text-gray-400"></i>
                {{ now()->translatedFormat('l, d F Y') }}
            </div>
            {{-- Tombol Laporan Cepat --}}
            <a href="{{ route('reports.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-lg shadow-lg shadow-blue-600/20 transition-all transform hover:-translate-y-0.5">
                <i class="fas fa-plus"></i>
                <span>Input Laporan</span>
            </a>
        </div>
    </div>

    {{-- KPI Cards --}}
    {{-- Update grid-cols-2 menjadi grid-cols-3 agar muat 3 kartu --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        
        <!-- Card 1: Pendaftaran Baru (Ditambahkan) -->
        <div class="relative overflow-hidden bg-white rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-shadow duration-300 group">
            <div class="absolute right-0 top-0 h-full w-1 bg-amber-500"></div> {{-- Aksen warna --}}
            <div class="p-6 flex items-start justify-between">
                <div>
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1">Pendaftaran Baru</p>
                    <div class="flex items-baseline gap-2">
                        {{-- Mengambil jumlah status Pending langsung dari Model --}}
                        <span class="text-4xl font-extrabold text-slate-800 tracking-tight">
                            {{ \App\Models\Pendaftaran::where('status', 'Pending')->count() }}
                        </span>
                        <span class="text-sm font-medium text-slate-400">permintaan</span>
                    </div>
                    <div class="mt-4 flex items-center gap-2 text-xs text-slate-500 bg-slate-50 w-fit px-2 py-1 rounded border border-slate-100">
                        <span class="relative flex h-2 w-2">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-500"></span>
                        </span>
                        <span>Menunggu verifikasi</span>
                    </div>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-600 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-inbox text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Card 2: Total Laporan -->
        <div class="relative overflow-hidden bg-white rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-shadow duration-300 group">
            <div class="absolute right-0 top-0 h-full w-1 bg-emerald-500"></div> {{-- Aksen warna --}}
            <div class="p-6 flex items-start justify-between">
                <div>
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1">Total Selesai</p>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-extrabold text-slate-800 tracking-tight">{{ number_format($laporan->count()) }}</span>
                        <span class="text-sm font-medium text-slate-400">laporan</span>
                    </div>
                    <div class="mt-4 flex items-center gap-2 text-xs text-slate-500 bg-slate-50 w-fit px-2 py-1 rounded border border-slate-100">
                        <i class="far fa-clock text-emerald-500"></i>
                        <span>Terbaru: {{ $laporan->first()?->created_at->format('d M') ?? '-' }}</span>
                    </div>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-clipboard-check text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Card 3: Teknisi Terdaftar -->
        <div class="relative overflow-hidden bg-white rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-shadow duration-300 group">
            <div class="absolute right-0 top-0 h-full w-1 bg-blue-500"></div> {{-- Aksen warna --}}
            <div class="p-6 flex items-start justify-between">
                <div>
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1">Tim Teknisi</p>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-extrabold text-slate-800 tracking-tight">{{ $jumlahTeknisi ?? 0 }}</span>
                        <span class="text-sm font-medium text-slate-400">personil</span>
                    </div>
                    <div class="mt-4 flex items-center gap-2 text-xs text-slate-500 bg-slate-50 w-fit px-2 py-1 rounded border border-slate-100">
                        <i class="fas fa-circle text-blue-500 text-[8px]"></i>
                        <span>Siap bertugas</span>
                    </div>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-users-gear text-2xl"></i>
                </div>
            </div>
        </div>

    </div>

    {{-- Section Title --}}
    <div class="flex items-center gap-2 text-gray-800 mb-2">
        <i class="fas fa-history text-blue-600"></i>
        <h3 class="text-lg font-bold">Riwayat Laporan Terbaru</h3>
    </div>

    {{-- Tabel Laporan Instalasi --}}
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal & Waktu</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Teknisi</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">ID & Paket</th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Bukti</th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($laporan as $item)
                    <tr class="hover:bg-slate-50/80 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-gray-800">{{ $item->created_at->format('d M Y') }}</span>
                                <div class="flex items-center gap-1.5 mt-1">
                                    <i class="far fa-clock text-gray-400 text-xs"></i>
                                    <span class="text-xs text-gray-500 font-medium">{{ $item->created_at->format('H:i') }} WIB</span>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-100 to-indigo-100 flex items-center justify-center text-blue-600 text-xs font-bold border border-blue-200 shadow-sm">
                                    {{ strtoupper(substr($item->teknisi->nama ?? 'U', 0, 1)) }}
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-semibold text-gray-800">{{ $item->teknisi->nama ?? 'User Terhapus' }}</span>
                                    <span class="text-xs text-gray-500">Teknisi Lapangan</span>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex flex-col gap-1">
                                <span class="inline-flex items-center w-fit px-2.5 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-600 border border-gray-200">
                                    #{{ $item->pendaftaran->id ?? '-' }}
                                </span>
                                @if($item->pendaftaran && $item->pendaftaran->paket)
                                    <span class="text-xs font-medium text-blue-600 flex items-center gap-1">
                                        <i class="fas fa-wifi text-[10px]"></i> {{ Str::limit($item->pendaftaran->paket->nama_paket, 20) }}
                                    </span>
                                @endif
                            </div>
                        </td>

                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            @if($item->bukti_foto)
                                <a href="{{ asset('storage/' . $item->bukti_foto) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium bg-white text-gray-700 border border-gray-300 hover:bg-gray-50 hover:text-blue-600 hover:border-blue-300 transition shadow-sm group">
                                    <i class="fas fa-image text-gray-400 group-hover:text-blue-500 transition-colors"></i> 
                                    <span>Lihat Foto</span>
                                </a>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-500">
                                    -
                                </span>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('reports.edit', $item->id) }}" class="p-2 rounded-lg text-gray-400 hover:text-amber-600 hover:bg-amber-50 transition" title="Edit Laporan">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>

                                <form action="{{ route('reports.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus laporan ini secara permanen?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition" title="Hapus Laporan">
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
                                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-4 border border-slate-100">
                                    <i class="fas fa-folder-open text-slate-300 text-3xl"></i>
                                </div>
                                <h3 class="text-base font-semibold text-gray-900">Belum ada data laporan</h3>
                                <p class="text-slate-500 text-sm mt-1 max-w-sm mx-auto">
                                    Laporan instalasi akan muncul di sini setelah teknisi menyelesaikan tugas di lapangan.
                                </p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection