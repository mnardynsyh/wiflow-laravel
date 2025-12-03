@extends('layouts.worker')

@section('title', 'Daftar Tugas Saya')

@section('content')
<div class="space-y-6">
    
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900">Tugas Saya</h1>
            <p class="text-sm text-gray-500">Daftar semua pekerjaan instalasi yang ditugaskan kepada Anda.</p>
        </div>
        <span class="bg-blue-100 text-blue-700 text-xs font-bold px-3 py-1 rounded-full">
            {{ $assignments->count() }} Pending
        </span>
    </div>

    @if($assignments->isEmpty())
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-16 text-center">
            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-mug-hot text-slate-400 text-3xl"></i>
            </div>
            <h3 class="text-lg font-bold text-slate-800">Semua Beres!</h3>
            <p class="text-slate-500 text-sm mt-1 max-w-sm mx-auto">
                Tidak ada jadwal instalasi yang tertunda saat ini. Silakan istirahat atau cek kembali nanti.
            </p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach($assignments as $job)
                {{-- Cek apakah jadwal hari ini untuk menandai prioritas --}}
                @php 
                    $isToday = \Carbon\Carbon::parse($job->tanggal_jadwal)->isToday(); 
                @endphp
                
                @include('partials.job-card', ['job' => $job, 'priority' => $isToday])
            @endforeach
        </div>
    @endif

</div>
@endsection