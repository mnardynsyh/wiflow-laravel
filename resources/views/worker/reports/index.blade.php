@extends('layouts.worker')

@section('title', 'Daftar Tugas Saya')

@section('content')
<div class="space-y-6">
    
    {{-- Header Section --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900">Daftar Tugas Saya</h1>
            <p class="text-sm text-gray-500">Semua jadwal instalasi yang ditugaskan kepada Anda.</p>
        </div>
        
        <div class="flex gap-2">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                Total: {{ $assignments->count() }} Tugas
            </span>
        </div>
    </div>

    @if($assignments->isEmpty())
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-16 text-center">
            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-clipboard-check text-slate-400 text-3xl"></i>
            </div>
            <h3 class="text-lg font-bold text-slate-800">Tidak ada tugas aktif</h3>
            <p class="text-slate-500 text-sm mt-1 max-w-sm mx-auto">
                Anda tidak memiliki tanggungan pekerjaan instalasi saat ini.
            </p>
        </div>
    @else
        {{-- Layout 1 Kolom untuk Kartu Memanjang --}}
        <div class="flex flex-col gap-4">
            @foreach($assignments as $job)
                @php 
                    $isToday = \Carbon\Carbon::parse($job->tanggal_jadwal)->isToday(); 
                @endphp
                
                @include('partials.job-card', ['job' => $job, 'priority' => $isToday])
            @endforeach
        </div>
    @endif
</div>
@endsection