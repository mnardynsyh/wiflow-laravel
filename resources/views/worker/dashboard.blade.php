@extends('layouts.worker')

@section('title', 'Tugas Saya')

@section('content')
<div class="space-y-6">
    
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900">Halo, {{ Auth::user()->nama }} !</h1>
            <p class="text-sm text-gray-500">Ada <span class="font-bold text-emerald-600">{{ $pendaftarans->count() }} tugas</span> instalasi menunggu tindakan Anda.</p>
        </div>
    </div>

    @if($pendaftarans->isEmpty())
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-10 text-center">
            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-coffee text-gray-400 text-3xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-800">Tidak ada tugas aktif</h3>
            <p class="text-gray-500 text-sm mt-1">Anda sedang tidak memiliki jadwal instalasi. Silakan istirahat!</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach($pendaftarans as $job)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition group flex flex-col">

                <div class="bg-slate-50 px-5 py-4 border-b border-gray-100 flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <i class="far fa-calendar-alt text-slate-400"></i>
                        <span class="text-sm font-semibold text-slate-700">
                            {{ \Carbon\Carbon::parse($job->tanggal_jadwal)->translatedFormat('l, d M Y') }}
                        </span>
                    </div>
                    <span class="bg-blue-100 text-blue-700 text-xs px-2.5 py-1 rounded-full font-bold">
                        {{ $job->paket->nama_paket ?? 'Paket ?' }}
                    </span>
                </div>

                {{-- Body Card --}}
                <div class="p-5 flex-1 flex flex-col">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 line-clamp-1" title="{{ $job->nama_pelanggan }}">
                                {{ $job->nama_pelanggan }}
                            </h3>
                            <p class="text-sm text-gray-500 flex items-start gap-1 mt-1">
                                <i class="fas fa-map-marker-alt text-red-400 mt-1"></i> 
                                <span class="line-clamp-2">{{ $job->alamat_pemasangan }}</span>
                            </p>
                        </div>
                        
                        @if($job->koordinat)
                        <a href="https://www.google.com/maps/search/?api=1&query={{ $job->koordinat }}" target="_blank" class="flex-shrink-0 w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 hover:bg-blue-600 hover:text-white transition shadow-sm" title="Buka Maps">
                            <i class="fas fa-location-arrow"></i>
                        </a>
                        @endif
                    </div>

                    <div class="mt-auto">
                        <div class="flex flex-wrap gap-2 text-sm text-gray-600 bg-gray-50 p-3 rounded-lg mb-4">
                            <div class="flex items-center gap-2 w-full">
                                <i class="fab fa-whatsapp text-green-500 text-lg"></i> 
                                <a href="https://wa.me/{{ preg_replace('/^0/', '62', $job->no_hp) }}" target="_blank" class="hover:underline hover:text-green-600 font-medium">
                                    {{ $job->no_hp }}
                                </a>
                            </div>
                        </div>

                        <div class="border-t border-gray-100 pt-4">
                            <a href="{{ route('teknisi.laporan.create', $job->id) }}" class="flex items-center justify-center gap-2 w-full bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2.5 rounded-lg font-semibold transition shadow-md hover:shadow-lg active:scale-95">
                                <i class="fas fa-camera"></i>
                                Upload Laporan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection