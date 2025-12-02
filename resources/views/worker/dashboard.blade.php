@extends('layouts.worker')

@section('title', 'Dashboard Teknisi')

@section('content')
<div class="space-y-8">
    
    {{-- Header & Statistik --}}
    <div>
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-gray-900">Halo, {{ Auth::user()->nama }} 👋</h1>
                <p class="text-sm text-gray-500">Selamat bertugas! Berikut performa Anda hari ini.</p>
            </div>
            <div class="hidden md:block text-sm font-medium text-slate-500 bg-white border border-slate-200 px-3 py-1.5 rounded-lg shadow-sm">
                <i class="far fa-calendar-alt mr-2"></i> {{ now()->translatedFormat('l, d F Y') }}
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Card Hari Ini -->
            <div class="bg-blue-600 rounded-xl p-5 text-white shadow-lg shadow-blue-200">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-blue-100 text-sm font-medium">Jadwal Hari Ini</p>
                        <h3 class="text-3xl font-bold mt-1">{{ $stats['hari_ini'] }}</h3>
                    </div>
                    <div class="p-2 bg-white/20 rounded-lg">
                        <i class="fas fa-calendar-day text-xl"></i>
                    </div>
                </div>
                <p class="text-xs text-blue-100 mt-4">Pelanggan menunggu kedatangan Anda.</p>
            </div>

            <!-- Card Total Pending -->
            <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-slate-500 text-sm font-medium">Total Pending</p>
                        <h3 class="text-3xl font-bold text-slate-800 mt-1">{{ $stats['total_pending'] }}</h3>
                    </div>
                    <div class="p-2 bg-amber-50 text-amber-600 rounded-lg">
                        <i class="fas fa-clock text-xl"></i>
                    </div>
                </div>
                <p class="text-xs text-slate-400 mt-4">Total tugas yang belum selesai.</p>
            </div>

            <!-- Card Selesai Bulan Ini -->
            <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-slate-500 text-sm font-medium">Selesai Bulan Ini</p>
                        <h3 class="text-3xl font-bold text-emerald-600 mt-1">{{ $stats['selesai_bulan_ini'] }}</h3>
                    </div>
                    <div class="p-2 bg-emerald-50 text-emerald-600 rounded-lg">
                        <i class="fas fa-check-circle text-xl"></i>
                    </div>
                </div>
                <p class="text-xs text-slate-400 mt-4">Kinerja yang bagus, pertahankan!</p>
            </div>
        </div>
    </div>

    {{-- Ringkasan Prioritas Hari Ini --}}
    @if($todayTasks->isNotEmpty())
    <div>
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                <i class="fas fa-fire text-red-500"></i> Prioritas Hari Ini
            </h2>
            <a href="{{ route('teknisi.assignments.index') }}" class="text-sm text-blue-600 hover:underline">Lihat Semua Tugas &rarr;</a>
        </div>
        
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">
            @foreach($todayTasks as $job)
                {{-- Menggunakan Partial Card --}}
                @include('teknisi.partials.job-card', ['job' => $job, 'priority' => true])
            @endforeach
        </div>
    </div>
    @endif

</div>
@endsection