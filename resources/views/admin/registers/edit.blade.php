@extends('layouts.app')

@section('title', 'Edit Data Pendaftaran')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    {{-- HEADER HALAMAN --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 flex items-center gap-2">
                <span class="text-slate-400">#{{ $pendaftaran->id }}</span>
                <span>{{ $pendaftaran->nama_pelanggan }}</span>
            </h1>
            <p class="text-sm text-slate-500">Edit data pelanggan & atur penugasan teknisi.</p>
        </div>
        <a href="{{ route('pendaftaran.index') }}" 
           class="inline-flex items-center justify-center px-4 py-2 bg-white border border-slate-300 rounded-xl text-slate-700 font-bold text-sm hover:bg-slate-50 hover:text-slate-900 transition shadow-sm">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>
    </div>

    {{-- ALERT JIKA SEDANG DIKERJAKAN (UX Warning) --}}
    @if($pendaftaran->status == 'Progress')
    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg shadow-sm flex items-start gap-3">
        <i class="fas fa-info-circle text-blue-500 mt-0.5"></i>
        <div>
            <h3 class="text-sm font-bold text-blue-800">Pekerjaan Sedang Berlangsung</h3>
            <p class="text-xs text-blue-600">Teknisi sedang mengerjakan tugas ini. Mengubah data teknisi sekarang akan mengalihkan tugas ke orang lain (Re-Dispatch).</p>
        </div>
    </div>
    @endif

    <form action="{{ route('pendaftaran.update', $pendaftaran->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- KOLOM KIRI: DATA PELANGGAN --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                        <h3 class="font-bold text-slate-800 flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center">
                                <i class="far fa-id-card"></i>
                            </div>
                            Data Pelanggan
                        </h3>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Informasi Dasar</span>
                    </div>
                    
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        {{-- Input: Nama --}}
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wide ml-1">Nama Lengkap</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400 group-focus-within:text-blue-500 transition">
                                    <i class="far fa-user"></i>
                                </div>
                                <input type="text" name="nama_pelanggan" 
                                       value="{{ old('nama_pelanggan', $pendaftaran->nama_pelanggan) }}" 
                                       class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium focus:bg-white focus:ring-2 focus:ring-blue-100 focus:border-blue-500 transition placeholder-slate-300"
                                       placeholder="Nama pelanggan...">
                            </div>
                        </div>

                        {{-- Input: NIK (KTP) --}}
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wide ml-1">NIK (KTP)</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400 group-focus-within:text-blue-500 transition">
                                    <i class="far fa-address-card"></i>
                                </div>
                                <input type="text" 
                                    inputmode="numeric" 
                                    name="nik_pelanggan" 
                                    value="{{ old('nik_pelanggan', $pendaftaran->nik_pelanggan) }}" 
                                    class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium focus:bg-white focus:ring-2 focus:ring-blue-100 focus:border-blue-500 transition placeholder-slate-300 font-mono"
                                    placeholder="16 digit angka..."
                                    minlength="16"
                                    maxlength="16"
                                    pattern="[0-9]*"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                    
                            </div>
                            @error('nik_pelanggan') <span class="text-xs text-red-500 ml-1 font-bold">{{ $message }}</span> @enderror
                        </div>

                        {{-- Input: No HP --}}
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wide ml-1">No. WhatsApp</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400 group-focus-within:text-green-500 transition">
                                    <i class="fab fa-whatsapp text-lg"></i>
                                </div>
                                <input type="text" name="no_hp" 
                                       value="{{ old('no_hp', $pendaftaran->no_hp) }}" 
                                       class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium focus:bg-white focus:ring-2 focus:ring-green-100 focus:border-green-500 transition placeholder-slate-300"
                                       placeholder="0812...">
                            </div>
                        </div>

                        {{-- Input: Paket --}}
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wide ml-1">Paket Layanan</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400 group-focus-within:text-indigo-500 transition">
                                    <i class="fas fa-box"></i>
                                </div>
                                <select name="id_paket" class="w-full pl-10 pr-10 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-700 focus:bg-white focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500 transition cursor-pointer appearance-none">
                                    @foreach($pakets as $p)
                                        <option value="{{ $p->id }}" {{ $pendaftaran->id_paket == $p->id ? 'selected' : '' }}>
                                            {{ $p->nama_paket }} (Rp {{ number_format($p->harga, 0, ',', '.') }})
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-slate-400">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>

                        {{-- Input: Alamat (Full Width) --}}
                        <div class="md:col-span-2 space-y-1.5">
                            <div class="flex justify-between">
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-wide ml-1">Alamat Pemasangan</label>
                                @if($pendaftaran->koordinat)
                                    <a href="https://www.google.com/maps/search/?api=1&query={{ $pendaftaran->koordinat }}" target="_blank" class="text-[10px] font-bold text-blue-600 hover:underline flex items-center gap-1">
                                        <i class="fas fa-map-marker-alt"></i> Cek Maps
                                    </a>
                                @endif
                            </div>
                            <div class="relative group">
                                <div class="absolute top-3 left-3.5 text-slate-400 group-focus-within:text-blue-500 transition">
                                    <i class="fas fa-home"></i>
                                </div>
                                <textarea name="alamat_pemasangan" rows="3" 
                                          class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium focus:bg-white focus:ring-2 focus:ring-blue-100 focus:border-blue-500 transition placeholder-slate-300 leading-relaxed">{{ old('alamat_pemasangan', $pendaftaran->alamat_pemasangan) }}</textarea>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: PENUGASAN (Status & Teknisi) --}}
            <div class="space-y-6">
                
                {{-- Kartu Status (Bahasa Indonesia) --}}
                <div class="bg-slate-900 rounded-2xl p-6 text-white shadow-xl relative overflow-hidden group">
                    <div class="absolute top-0 right-0 -mr-4 -mt-4 w-24 h-24 bg-white/5 rounded-full blur-2xl group-hover:bg-white/10 transition"></div>
                    
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Status Saat Ini</p>
                    <div class="flex items-center gap-3">
                        @php
                            // Mapping Status ke Bahasa Indonesia
                            $statusIndo = match($pendaftaran->status) {
                                'Pending'   => 'Menunggu',
                                'Scheduled' => 'Terjadwal',
                                'Progress'  => 'Sedang Dikerjakan',
                                'Reported'  => 'Menunggu Verifikasi',
                                'Completed' => 'Selesai',
                                default     => $pendaftaran->status
                            };

                            $statusIcon = match($pendaftaran->status) {
                                'Pending'   => 'fas fa-clock',
                                'Scheduled' => 'fas fa-calendar-check',
                                'Progress'  => 'fas fa-tools',
                                'Reported'  => 'fas fa-clipboard-check',
                                'Completed' => 'fas fa-check-circle',
                                default     => 'fas fa-info-circle'
                            };
                            
                            $statusColor = match($pendaftaran->status) {
                                'Pending'   => 'text-amber-400',
                                'Scheduled' => 'text-purple-400',
                                'Progress'  => 'text-blue-400 animate-pulse',
                                'Reported'  => 'text-emerald-400',
                                'Completed' => 'text-green-400',
                                default     => 'text-slate-400'
                            };
                        @endphp
                        <i class="{{ $statusIcon }} {{ $statusColor }} text-2xl"></i>
                        <span class="text-xl font-bold tracking-tight">{{ $statusIndo }}</span>
                    </div>
                </div>

                {{-- Form Dispatch --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                        <h3 class="font-bold text-slate-800 flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center">
                                <i class="fas fa-tasks"></i>
                            </div>
                            Penugasan Teknisi
                        </h3>
                    </div>
                    
                    <div class="p-6 space-y-5">
                        
                        {{-- Pilih Teknisi --}}
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wide ml-1">Pilih Teknisi</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400 group-focus-within:text-indigo-500 transition">
                                    <i class="fas fa-user-hard-hat"></i>
                                </div>
                                <select name="id_teknisi" class="w-full pl-10 pr-10 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold focus:bg-white focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500 transition cursor-pointer appearance-none">
                                    <option value="">-- Belum Ditugaskan --</option>
                                    @foreach($teknisi as $t)
                                        <option value="{{ $t->id }}" {{ (old('id_teknisi', $pendaftaran->id_teknisi) == $t->id) ? 'selected' : '' }}>
                                            {{ $t->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-slate-400">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>

                        {{-- Tanggal Jadwal --}}
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wide ml-1">Jadwal Pengerjaan</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400 group-focus-within:text-indigo-500 transition">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <input type="datetime-local" name="tanggal_jadwal" 
                                       value="{{ old('tanggal_jadwal', $pendaftaran->tanggal_jadwal ? \Carbon\Carbon::parse($pendaftaran->tanggal_jadwal)->format('Y-m-d\TH:i') : '') }}"
                                       class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold focus:bg-white focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500 transition cursor-pointer">
                            </div>
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="w-full py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg shadow-blue-500/30 transition transform active:scale-95 flex justify-center items-center gap-2">
                                <i class="fas fa-save"></i> 
                                <span>Simpan & Update</span>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Action Tambahan (Verifikasi) --}}
                @if($pendaftaran->status == 'Reported')
                    <div class="bg-emerald-50 rounded-2xl p-6 border border-emerald-100 text-center">
                        <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-3 text-emerald-600 shadow-sm">
                            <i class="fas fa-check-double text-xl"></i>
                        </div>
                        <h4 class="font-bold text-emerald-900">Laporan Diterima</h4>
                        <p class="text-xs text-emerald-700 mb-4 px-2">Teknisi telah melaporkan pekerjaan selesai. Cek bukti foto sebelum verifikasi.</p>
                        
                        <div class="space-y-2">
                            <a href="{{ route('reports.show', $pendaftaran->laporanInstalasi->id ?? '#') }}" target="_blank" class="block w-full py-2 bg-white text-emerald-700 font-bold text-xs rounded-lg border border-emerald-200 hover:bg-emerald-50 transition">
                                Lihat Bukti Laporan
                            </a>
                            <button type="submit" name="action" value="complete" class="w-full py-2.5 bg-emerald-600 text-white font-bold text-sm rounded-lg hover:bg-emerald-700 shadow-md shadow-emerald-200 transition">
                                Verifikasi Selesai
                            </button>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </form>
</div>
@endsection