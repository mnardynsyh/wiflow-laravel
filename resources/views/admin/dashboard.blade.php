@extends('layouts.app')

@section('title', 'Admin Command Center')

@section('content')
<div class="space-y-8">

    {{-- 1. KARTU RINGKASAN (STATS OPERASIONAL) --}}
    {{-- Grid diubah jadi 3 kolom karena Revenue dihapus --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Pelanggan</p>
                <p class="text-3xl font-extrabold text-slate-800 mt-1">{{ $totalPendaftar }}</p>
            </div>
            <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                <i class="fas fa-users text-xl"></i>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Perlu Tindakan</p>
                <p class="text-3xl font-extrabold text-amber-500 mt-1">{{ $totalPending }}</p>
                <p class="text-[10px] text-slate-400 mt-1">Menunggu jadwal/verifikasi</p>
            </div>
            <div class="w-12 h-12 rounded-full bg-amber-50 flex items-center justify-center text-amber-500 animate-pulse">
                <i class="fas fa-exclamation-circle text-xl"></i>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Selesai Terpasang</p>
                <p class="text-3xl font-extrabold text-emerald-600 mt-1">{{ $totalSelesai }}</p>
            </div>
            <div class="w-12 h-12 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-600">
                <i class="fas fa-check-double text-xl"></i>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        {{-- 2. LIVE MONITORING (REAL-TIME TRACKING) --}}
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                    <span class="relative flex h-3 w-3">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                    </span>
                    Live Activity (Sedang Dikerjakan)
                </h3>
                <span class="text-xs font-medium text-slate-500 bg-white px-2 py-1 rounded border border-slate-200">
                    Auto-update
                </span>
            </div>
            
            <div class="overflow-x-auto">
                @if($sedangDikerjakan->count() > 0)
                    <table class="w-full text-sm text-left">
                        <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-[10px] tracking-wider">
                            <tr>
                                <th class="px-6 py-3">Teknisi</th>
                                <th class="px-6 py-3">Lokasi Pelanggan</th>
                                <th class="px-6 py-3">Mulai Pukul</th>
                                <th class="px-6 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($sedangDikerjakan as $job)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-700">{{ $job->teknisi->nama ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-slate-800">{{ $job->nama_pelanggan }}</div>
                                    <div class="text-xs text-slate-500 truncate w-48" title="{{ $job->alamat_pemasangan }}">
                                        {{ $job->alamat_pemasangan }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-mono text-slate-600">
                                    {{ \Carbon\Carbon::parse($job->tanggal_jadwal)->format('H:i') }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-600 border border-blue-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                                        Working
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="p-10 text-center text-slate-400 flex flex-col items-center justify-center">
                        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-3">
                            <i class="fas fa-coffee text-2xl text-slate-300"></i>
                        </div>
                        <p class="font-medium">Semua teknisi sedang standby.</p>
                        <p class="text-xs text-slate-400 mt-1">Tidak ada aktivitas pemasangan aktif saat ini.</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- 3. MONITORING BEBAN KERJA (LOAD BALANCING) --}}
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 flex flex-col h-full">
            <h3 class="font-bold text-slate-800 mb-1">Beban Teknisi Hari Ini</h3>
            <p class="text-xs text-slate-500 mb-6">Pastikan pembagian tugas merata.</p>
            
            <div class="space-y-5 flex-grow overflow-y-auto max-h-[300px] pr-2 custom-scrollbar">
                @foreach($bebanTeknisi as $tech)
                    <div class="group">
                        <div class="flex justify-between text-sm mb-2">
                            <span class="font-bold text-slate-700 group-hover:text-blue-600 transition">{{ $tech->nama }}</span>
                            <span class="font-bold text-slate-900 bg-slate-100 px-2 rounded text-xs py-0.5">{{ $tech->jobs_today }} Job</span>
                        </div>
                        {{-- Progress Bar Beban --}}
                        <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                            {{-- Warna: Hijau (1-2), Kuning (3), Merah (>3) --}}
                            @php
                                $color = 'bg-emerald-500';
                                if($tech->jobs_today >= 3) $color = 'bg-amber-500';
                                if($tech->jobs_today > 4) $color = 'bg-red-500';
                                $width = min(($tech->jobs_today / 5) * 100, 100);
                            @endphp
                            <div class="h-full rounded-full {{ $color }} transition-all duration-500" style="width: {{ $width }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-6 pt-4 border-t border-slate-100">
                <a href="{{ route('pendaftaran.index') }}" class="block text-center w-full py-2 bg-slate-50 text-slate-600 hover:bg-slate-100 hover:text-blue-600 text-sm font-bold rounded-lg transition border border-slate-200">
                    Kelola Penugasan
                </a>
            </div>
        </div>

    </div>

    {{-- 4. JADWAL HARI INI (TIMELINE) --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="font-bold text-slate-800">Agenda Pemasangan Hari Ini</h3>
            <span class="text-xs font-bold text-slate-500 bg-slate-100 px-3 py-1 rounded-full">
                {{ now()->translatedFormat('l, d F Y') }}
            </span>
        </div>
        
        <div class="relative border-l-2 border-slate-200 ml-3 space-y-8 pb-2">
            @forelse($jadwalHariIni as $agenda)
                <div class="relative pl-8 group">
                    {{-- Dot Timeline --}}
                    <div class="absolute -left-[9px] top-1 w-4 h-4 rounded-full border-2 border-white ring-1 ring-slate-200 transition-all group-hover:scale-125
                        {{ $agenda->status == 'Completed' ? 'bg-emerald-500' : ($agenda->status == 'Progress' ? 'bg-blue-500 animate-pulse' : 'bg-slate-300') }}">
                    </div>
                    
                    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4 p-3 rounded-lg hover:bg-slate-50 transition border border-transparent hover:border-slate-100">
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-xs font-bold text-slate-500 bg-slate-200 px-2 py-0.5 rounded">
                                    {{ \Carbon\Carbon::parse($agenda->tanggal_jadwal)->format('H:i') }}
                                </span>
                                <h4 class="text-base font-bold text-slate-800">{{ $agenda->nama_pelanggan }}</h4>
                            </div>
                            <p class="text-sm text-slate-500 flex items-center gap-2">
                                <i class="fas fa-box text-xs"></i> {{ $agenda->paket->nama_paket ?? '-' }} 
                                <span class="text-slate-300">|</span>
                                <i class="fas fa-user-hard-hat text-xs"></i> {{ $agenda->teknisi->nama ?? 'Belum Ditunjuk' }}
                            </p>
                        </div>
                        <div>
                            @if($agenda->status == 'Completed')
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700 border border-emerald-200">
                                    <i class="fas fa-check mr-1"></i> Selesai
                                </span>
                            @elseif($agenda->status == 'Progress')
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700 border border-blue-200">
                                    <i class="fas fa-spinner fa-spin mr-1"></i> On Progress
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                    {{ $agenda->status }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="pl-8 text-slate-400 italic py-4">
                    Belum ada jadwal pemasangan untuk hari ini.
                </div>
            @endforelse
        </div>
    </div>

</div>
@endsection