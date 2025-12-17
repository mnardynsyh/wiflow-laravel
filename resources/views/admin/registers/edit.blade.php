@extends('layouts.app')

@section('title', 'Manajemen Pendaftaran')

@section('content')
<div class="space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                #{{ $pendaftaran->id }} - {{ $pendaftaran->nama_pelanggan }}
            </h1>
            <p class="text-sm text-gray-500">Kelola data pendaftaran dan penugasan teknisi.</p>
        </div>
        <a href="{{ route('pendaftaran.index') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 text-sm font-medium">
            <i class="fas fa-arrow-left mr-2"></i>Kembali
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Status Pengerjaan</h3>
        <div class="flex items-center w-full">
            @php
                $steps = ['Pending', 'Verified', 'Scheduled', 'Progress', 'Reported', 'Completed'];
                $currentIdx = array_search($pendaftaran->status, $steps);
            @endphp

            @foreach($steps as $index => $step)
                <div class="flex items-center {{ $loop->last ? '' : 'flex-1' }}">
                    <div class="flex flex-col items-center relative z-10">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold border-2 transition-all
                            {{ $index <= $currentIdx ? 'bg-blue-600 border-blue-600 text-white' : 'bg-white border-gray-300 text-gray-400' }}">
                            @if($index < $currentIdx) <i class="fas fa-check"></i> @else {{ $index + 1 }} @endif
                        </div>
                        <span class="absolute top-10 text-[10px] font-bold uppercase tracking-wide {{ $index <= $currentIdx ? 'text-blue-600' : 'text-gray-400' }}">
                            {{ $step }}
                        </span>
                    </div>
                    
                    @if(!$loop->last)
                        <div class="flex-1 h-1 mx-2 {{ $index < $currentIdx ? 'bg-blue-600' : 'bg-gray-200' }}"></div>
                    @endif
                </div>
            @endforeach
        </div>
        <div class="mb-6"></div> </div>

    <form action="{{ route('pendaftaran.update', $pendaftaran->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="far fa-user text-blue-500"></i> Detail Pelanggan
                    </h3>
                    
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-1">NIK</label>
                            <div class="text-gray-800 font-medium">{{ $pendaftaran->nik_pelanggan }}</div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-1">No HP</label>
                            <div class="text-gray-800 font-medium">{{ $pendaftaran->no_hp }}</div>
                        </div>
                        <div class="col-span-2">
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Alamat</label>
                            <div class="text-gray-800">{{ $pendaftaran->alamat_pemasangan }}</div>
                            @if($pendaftaran->koordinat)
                                <a href="https://www.google.com/maps?q={{ $pendaftaran->koordinat }}" target="_blank" class="text-blue-600 text-xs hover:underline mt-1 inline-flex items-center">
                                    <i class="fas fa-map-marker-alt mr-1"></i> Lihat di Google Maps
                                </a>
                            @endif
                        </div>
                         <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Paket Pilihan</label>
                            <div class="inline-block px-3 py-1 bg-indigo-50 text-indigo-700 rounded-lg text-sm font-bold">
                                {{ $pendaftaran->paket->nama_paket ?? '-' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 border-l-4 border-l-blue-500">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">
                        <i class="fas fa-tasks text-blue-500 mr-2"></i>Dispatching
                    </h3>
                    <p class="text-sm text-gray-500 mb-4">
                        Pilih teknisi dan tanggal untuk menjadwalkan pemasangan. Status akan otomatis berubah menjadi <strong>Scheduled</strong>.
                    </p>

                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Teknisi</label>
                        <select name="id_teknisi" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 py-2.5 bg-gray-50">
                            <option value="">-- Belum Ditugaskan --</option>
                            @foreach($teknisi as $t)
                                <option value="{{ $t->id }}" {{ (old('id_teknisi', $pendaftaran->id_teknisi) == $t->id) ? 'selected' : '' }}>
                                    {{ $t->nama }} ({{ $t->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Jadwal</label>
                        <input type="datetime-local" name="tanggal_jadwal" 
                               value="{{ old('tanggal_jadwal', $pendaftaran->tanggal_jadwal ? \Carbon\Carbon::parse($pendaftaran->tanggal_jadwal)->format('Y-m-d\TH:i') : '') }}"
                               class="w-full rounded-lg border-gray-300 focus:ring-blue-500 bg-gray-50 py-2.5">
                    </div>

                    <button type="submit" class="w-full py-3 px-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-lg shadow-blue-500/30 transition-all flex justify-center items-center gap-2">
                        <i class="fas fa-save"></i> Simpan & Tugaskan
                    </button>
                </div>

                @if($pendaftaran->status == 'Reported')
                <div class="bg-green-50 rounded-xl p-4 border border-green-200">
                    <h4 class="font-bold text-green-800 text-sm mb-2">Laporan Diterima!</h4>
                    <p class="text-xs text-green-700 mb-3">Teknisi telah menyelesaikan pekerjaan. Verifikasi laporan ini?</p>
                    <button type="submit" name="action" value="complete" class="w-full py-2 bg-green-600 text-white text-sm font-bold rounded hover:bg-green-700">
                        <i class="fas fa-check-double mr-1"></i> Selesaikan (Completed)
                    </button>
                </div>
                @endif

            </div>
        </div>
    </form>
</div>
@endsection