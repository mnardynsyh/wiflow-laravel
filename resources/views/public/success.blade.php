@extends('layouts.public')

@section('content')
<div class="min-h-screen bg-slate-50 flex items-center justify-center p-4">
    
    <div class="max-w-3xl w-full bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden flex flex-col md:flex-row">
        
        <div class="md:w-5/12 bg-slate-800 p-8 text-white flex flex-col justify-between relative">
            <div class="absolute top-0 left-0 w-full h-1 bg-blue-500"></div>

            <div>
                <div class="w-16 h-16 bg-blue-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-blue-900/50">
                    <i class="fas fa-check text-3xl text-white"></i>
                </div>
                
                <h2 class="text-2xl font-bold tracking-tight mb-2">Pendaftaran Berhasil!</h2>
                <p class="text-slate-400 text-sm leading-relaxed">
                    Data Anda telah tersimpan. Admin kami akan segera memverifikasi permintaan ini.
                </p>
            </div>

            <div class="mt-8">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">ID Pendaftaran Anda</p>
                <div class="bg-slate-700/50 rounded-xl p-4 border border-slate-600/50 flex items-center justify-between group cursor-pointer transition hover:bg-slate-700 hover:border-blue-500/50" onclick="navigator.clipboard.writeText('#{{ str_pad($pendaftaran->id, 5, '0', STR_PAD_LEFT) }}'); alert('ID berhasil disalin!')">
                    <span class="text-2xl font-mono font-bold text-white tracking-wider">
                        #{{ str_pad($pendaftaran->id, 5, '0', STR_PAD_LEFT) }}
                    </span>
                    <i class="far fa-copy text-slate-400 group-hover:text-blue-400 transition"></i>
                </div>
                <p class="text-[10px] text-slate-500 mt-2">*Simpan ID ini untuk pengecekan status.</p>
            </div>
        </div>

        <div class="md:w-7/12 p-8 bg-white flex flex-col h-full justify-between">
            
            <div>
                <div class="flex items-center justify-between mb-6 border-b border-slate-100 pb-4">
                    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wide">
                        Ringkasan Data
                    </h3>
                    <span class="px-2 py-1 rounded text-[10px] font-bold bg-yellow-100 text-yellow-700 border border-yellow-200 uppercase">
                        Pending
                    </span>
                </div>

                <div class="space-y-4">
                    <div class="grid grid-cols-3 gap-2 text-sm">
                        <span class="text-slate-400 font-medium">Nama</span>
                        <span class="col-span-2 font-semibold text-slate-800">{{ $pendaftaran->nama_pelanggan }}</span>
                    </div>
                    <div class="grid grid-cols-3 gap-2 text-sm">
                        <span class="text-slate-400 font-medium">WhatsApp</span>
                        <span class="col-span-2 font-semibold text-slate-800">{{ $pendaftaran->no_hp }}</span>
                    </div>
                    <div class="grid grid-cols-3 gap-2 text-sm">
                        <span class="text-slate-400 font-medium">Paket</span>
                        <span class="col-span-2 font-bold text-blue-600">{{ $pendaftaran->paket->nama_paket ?? '-' }}</span>
                    </div>
                    <div class="grid grid-cols-3 gap-2 text-sm">
                        <span class="text-slate-400 font-medium">Alamat</span>
                        <span class="col-span-2 text-slate-600 leading-relaxed">{{ $pendaftaran->alamat_pemasangan }}</span>
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-slate-100">
                <p class="text-xs text-slate-500 mb-3 font-medium">Tindakan Selanjutnya:</p>
                
                <div class="flex flex-col-reverse sm:flex-row gap-3">
                    @php
                        $adminNumber = '6281234567890'; // Ganti dengan nomor Admin
                        $message = "Halo Admin, saya (ID: #REG-".str_pad($pendaftaran->id, 5, '0', STR_PAD_LEFT).") ingin mengajukan koreksi data pendaftaran.";
                        $waLink = "https://wa.me/$adminNumber?text=" . urlencode($message);
                    @endphp
                    
                    <a href="{{ $waLink }}" target="_blank" class="flex-1 px-4 py-2.5 bg-white border border-slate-300 text-slate-600 text-sm font-bold rounded-xl hover:bg-slate-50 hover:text-red-600 hover:border-red-200 transition text-center flex items-center justify-center gap-2">
                        <i class="fab fa-whatsapp text-lg"></i>
                        Koreksi Data
                    </a>

                    <a href="{{ url('/') }}" class="flex-1 px-4 py-2.5 bg-slate-900 text-white text-sm font-bold rounded-xl hover:bg-slate-800 transition shadow-lg shadow-slate-200 text-center flex items-center justify-center gap-2">
                        <i class="fas fa-check"></i>
                        Selesai
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection