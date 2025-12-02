@extends('layouts.app')

@section('title', 'Admin Dashboard - WifiNet')

@section('content')
<div class="space-y-6">

    {{-- Header Section --}}
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">Dashboard Overview</h2>
            <p class="text-sm text-gray-500">Ringkasan aktivitas dan laporan instalasi terkini.</p>
        </div>
        {{-- Tanggal Hari Ini (Opsional) --}}
        <div class="hidden md:block text-sm text-gray-500 bg-white border border-gray-200 px-3 py-1.5 rounded-lg shadow-sm">
            <i class="far fa-calendar-alt mr-2"></i> {{ now()->translatedFormat('l, d F Y') }}
        </div>
    </div>

    {{-- KPI Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        
        <!-- Card 1: Total Laporan -->
        <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-5 flex items-center gap-4 transition hover:shadow-md">
            <div class="w-14 h-14 rounded-xl bg-emerald-50 flex items-center justify-center border border-emerald-100">
                <i class="fas fa-check-circle text-2xl text-emerald-600"></i>
            </div>
            <div class="flex-1">
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wide">Total Laporan Selesai</p>
                <div class="mt-1 flex items-baseline gap-2">
                    <span class="text-2xl font-extrabold text-slate-800">{{ number_format($laporan->count()) }}</span>
                    <span class="text-xs text-slate-400 font-medium">laporan</span>
                </div>
                <p class="mt-2 text-xs text-slate-400 flex items-center gap-1">
                    <i class="far fa-clock"></i>
                    Terbaru: {{ $laporan->first()?->created_at->format('d M H:i') ?? '-' }}
                </p>
            </div>
        </div>

        <!-- Card 2: Teknisi Terdaftar -->
        <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-5 flex items-center gap-4 transition hover:shadow-md">
            <div class="w-14 h-14 rounded-xl bg-sky-50 flex items-center justify-center border border-sky-100">
                <i class="fas fa-users-cog text-2xl text-sky-600"></i>
            </div>
            <div class="flex-1">
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wide">Teknisi Terdaftar</p>
                <div class="mt-1 flex items-baseline gap-2">
                    {{-- Menggunakan null coalescing operator (??) untuk mencegah error jika variabel belum ada --}}
                    <span class="text-2xl font-extrabold text-slate-800">{{ $jumlahTeknisi ?? 0 }}</span>
                    <span class="text-xs text-slate-400 font-medium">personil</span>
                </div>
                <p class="mt-2 text-xs text-emerald-600 font-medium flex items-center gap-1">
                    <i class="fas fa-circle text-[8px]"></i> Siap bertugas
                </p>
            </div>
        </div>

        <!-- Card 3: System Status -->
        <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-5 flex items-center gap-4 transition hover:shadow-md">
            <div class="w-14 h-14 rounded-xl bg-amber-50 flex items-center justify-center border border-amber-100">
                <i class="fas fa-server text-2xl text-amber-600"></i>
            </div>
            <div class="flex-1">
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wide">Status Sistem</p>
                <div class="mt-1 flex items-baseline gap-2">
                    <span class="text-2xl font-extrabold text-emerald-600">Online</span>
                    <span class="text-xs text-slate-400 font-medium">Stable</span>
                </div>
                <p class="mt-2 text-xs text-slate-400 flex items-center gap-1">
                    <i class="fas fa-sync-alt"></i>
                    Check: {{ now()->format('H:i') }} WIB
                </p>
            </div>
        </div>
    </div>

    {{-- Tabel Laporan Instalasi --}}
    <div class="bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-5 flex flex-col sm:flex-row items-center justify-between bg-white border-b border-slate-100 gap-4">
            <div>
                <h3 class="text-base font-bold text-slate-800">Laporan Instalasi Terbaru</h3>
                <p class="text-xs text-slate-500 mt-1">Memantau hasil pekerjaan teknisi lapangan.</p>
            </div>
            
            <div class="flex items-center gap-3">
                <a href="{{ route('reports.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-sm hover:shadow transition-all">
                    <i class="fas fa-plus"></i>
                    <span>Buat Laporan Manual</span>
                </a>
            </div> 
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100">
                <thead class="bg-slate-50/50">
                    <tr class="text-xs text-slate-500 uppercase tracking-wider">
                        <th scope="col" class="px-6 py-3 text-left font-semibold">Tanggal & Waktu</th>
                        <th scope="col" class="px-6 py-3 text-left font-semibold">Teknisi</th>
                        <th scope="col" class="px-6 py-3 text-left font-semibold">ID Pendaftaran</th>
                        <th scope="col" class="px-6 py-3 text-center font-semibold">Bukti Foto</th>
                        <th scope="col" class="px-6 py-3 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-100">
                    @forelse($laporan as $item)
                    <tr class="hover:bg-slate-50 transition duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-slate-700">{{ $item->created_at->format('d M Y') }}</span>
                                <span class="text-xs text-slate-400">{{ $item->created_at->format('H:i') }} WIB</span>
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 text-xs font-bold border border-indigo-200">
                                    {{ strtoupper(substr($item->teknisi->nama ?? 'U', 0, 1)) }}
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-medium text-slate-700">{{ $item->teknisi->nama ?? 'User Terhapus' }}</span>
                                    <span class="text-xs text-slate-400">Teknisi</span>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="#" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100 hover:bg-blue-100 transition">
                                #{{ $item->pendaftaran->id ?? '-' }}
                            </a>
                        </td>

                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            @if($item->bukti_foto)
                                <a href="{{ asset('storage/' . $item->bukti_foto) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md text-xs font-medium bg-gray-100 text-gray-700 border border-gray-200 hover:bg-white hover:border-blue-300 hover:text-blue-600 transition shadow-sm group">
                                    <i class="fas fa-image group-hover:scale-110 transition-transform"></i> Lihat
                                </a>
                            @else
                                <span class="text-xs italic text-slate-400 bg-slate-50 px-2 py-1 rounded">Tidak ada</span>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('reports.edit', $item->id) }}" class="p-2 rounded-lg text-amber-500 hover:bg-amber-50 transition" title="Edit Laporan">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>

                                <form action="{{ route('reports.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus laporan ini secara permanen?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 rounded-lg text-red-400 hover:bg-red-50 hover:text-red-600 transition" title="Hapus Laporan">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-3">
                                    <i class="fas fa-folder-open text-slate-300 text-3xl"></i>
                                </div>
                                <p class="text-slate-500 font-medium">Belum ada laporan instalasi.</p>
                                <p class="text-slate-400 text-xs mt-1">Data laporan akan muncul di sini setelah teknisi melakukan input.</p>
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