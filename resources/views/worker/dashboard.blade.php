@extends('layouts.worker')

@section('title', 'Dashboard Teknisi')

@section('content')
<div class="space-y-8">
    
    {{-- Header Section --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-gray-200 pb-6">
        <div>
            <h2 class="text-3xl font-extrabold tracking-tight text-gray-900">Halo, {{ Auth::user()->nama }} !</h2>
            <p class="mt-1 text-sm text-gray-500">Selamat bertugas! Berikut ringkasan performa Anda hari ini.</p>
        </div>
        <div class="hidden md:flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-lg shadow-sm text-sm font-medium text-gray-600">
            <i class="far fa-calendar-alt text-gray-400"></i>
            {{ now()->translatedFormat('l, d F Y') }}
        </div>
    </div>

    {{-- KPI Cards (Grid Outline Style) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        
        <!-- Card 1: Jadwal Hari Ini -->
        <div class="relative overflow-hidden bg-white rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-shadow duration-300 group">
            <div class="absolute right-0 top-0 h-full w-1 bg-blue-500"></div> {{-- Aksen Warna --}}
            <div class="p-6 flex items-start justify-between">
                <div>
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1">Jadwal Hari Ini</p>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-extrabold text-slate-800 tracking-tight">{{ $stats['hari_ini'] }}</span>
                        <span class="text-sm font-medium text-slate-400">tugas</span>
                    </div>
                    <div class="mt-4 flex items-center gap-2 text-xs text-slate-500 bg-slate-50 w-fit px-2 py-1 rounded border border-slate-100">
                        <span class="relative flex h-2 w-2">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                        </span>
                        <span>Menunggu kedatangan</span>
                    </div>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-calendar-day text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Card 2: Total Pending -->
        <div class="relative overflow-hidden bg-white rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-shadow duration-300 group">
            <div class="absolute right-0 top-0 h-full w-1 bg-amber-500"></div>
            <div class="p-6 flex items-start justify-between">
                <div>
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1">Total Pending</p>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-extrabold text-slate-800 tracking-tight">{{ $stats['total_pending'] }}</span>
                        <span class="text-sm font-medium text-slate-400">tugas</span>
                    </div>
                    <div class="mt-4 flex items-center gap-2 text-xs text-slate-500 bg-slate-50 w-fit px-2 py-1 rounded border border-slate-100">
                        <i class="fas fa-clock text-amber-500"></i>
                        <span>Total antrian aktif</span>
                    </div>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-600 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-hourglass-half text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Card 3: Selesai Bulan Ini -->
        <div class="relative overflow-hidden bg-white rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-shadow duration-300 group">
            <div class="absolute right-0 top-0 h-full w-1 bg-emerald-500"></div>
            <div class="p-6 flex items-start justify-between">
                <div>
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1">Selesai Bulan Ini</p>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-extrabold text-slate-800 tracking-tight">{{ $stats['selesai_bulan_ini'] }}</span>
                        <span class="text-sm font-medium text-slate-400">instalasi</span>
                    </div>
                    <div class="mt-4 flex items-center gap-2 text-xs text-slate-500 bg-slate-50 w-fit px-2 py-1 rounded border border-slate-100">
                        <i class="fas fa-check-circle text-emerald-500"></i>
                        <span>Kinerja bulan ini</span>
                    </div>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-clipboard-check text-2xl"></i>
                </div>
            </div>
        </div>

    </div>

    
    @if($todayTasks->isNotEmpty())
    <div>
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div class="flex items-center gap-2 text-gray-800">
                <i class="fas fa-fire text-red-500 text-xl"></i>
                <h3 class="text-xl font-bold">Prioritas Hari Ini</h3>
            </div>
            <a href="{{ route('teknisi.assignments.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline transition">
                Lihat Semua Tugas &rarr;
            </a>
        </div>
        
        <div class="flex flex-col gap-4">
            @foreach($todayTasks as $job)
                @include('partials.job-card', ['job' => $job, 'priority' => true])
            @endforeach
        </div>
    </div>
    @endif

</div>
@endsection