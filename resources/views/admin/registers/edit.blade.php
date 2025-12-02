@extends('layouts.app')

@section('title', 'Proses Pendaftaran')

@section('content')
<div class="max-w-4xl mx-auto">
    
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Verifikasi & Penugasan</h1>
            <p class="text-sm text-gray-500">Atur jadwal dan tugaskan teknisi untuk permintaan ini.</p>
        </div>
        <a href="{{ route('pendaftaran.index') }}" class="text-sm text-gray-600 hover:text-gray-900 flex items-center gap-1 transition">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 md:p-8">
            <form action="{{ route('pendaftaran.update', $pendaftaran->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- INFO PELANGGAN (Sama seperti sebelumnya) --}}
                <div class="mb-8">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2 pb-2 border-b border-gray-100">
                        <i class="far fa-id-card text-blue-500"></i> Data Pelanggan
                    </h3>
                    
                    <div class="bg-slate-50 rounded-xl p-5 border border-slate-200 grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-8">
                        <div>
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Nama Pelanggan</span>
                            <div class="text-slate-800 font-semibold text-lg">{{ $pendaftaran->nama_pelanggan }}</div>
                        </div>
                        <div class="md:col-span-2">
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Alamat Pemasangan</span>
                            <div class="text-slate-700">{{ $pendaftaran->alamat_pemasangan }}</div>
                        </div>
                        <div>
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Paket</span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-indigo-100 text-indigo-700">
                                {{ $pendaftaran->paket->nama_paket ?? 'Unknown' }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- FORM INPUT ADMIN --}}
                <div class="mb-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2 pb-2 border-b border-gray-100">
                        <i class="fas fa-tasks text-blue-500"></i> Tindakan Admin
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        {{-- Pilih Teknisi --}}
                        <div>
                            <label for="id_teknisi" class="block text-sm font-semibold text-gray-700 mb-2">Tugaskan Teknisi</label>
                            <div class="relative">
                                <select name="id_teknisi" id="id_teknisi" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 appearance-none bg-white py-2.5 px-4 pr-8">
                                    <option value="">-- Pilih Teknisi --</option>
                                    @foreach($teknisi as $t)
                                        <option value="{{ $t->id }}" {{ (old('id_teknisi', $pendaftaran->id_teknisi) == $t->id) ? 'selected' : '' }}>
                                            {{ $t->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-500">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                            @error('id_teknisi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Jadwal --}}
                        <div>
                            <label for="tanggal_jadwal" class="block text-sm font-semibold text-gray-700 mb-2">Jadwal Pemasangan</label>
                            <input type="datetime-local" name="tanggal_jadwal" id="tanggal_jadwal"
                                   value="{{ old('tanggal_jadwal', $pendaftaran->tanggal_jadwal ? \Carbon\Carbon::parse($pendaftaran->tanggal_jadwal)->format('Y-m-d\TH:i') : '') }}"
                                   class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 py-2.5 px-4">
                            @error('tanggal_jadwal') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Status Pengerjaan (ENUM FIXED) --}}
                        <div class="md:col-span-2">
                            <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Update Status</label>
                            <div class="relative">
                                <select name="status" id="status" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 appearance-none bg-white py-2.5 px-4 pr-8">
                                    {{-- Value harus SAMA PERSIS dengan database Enum --}}
                                    <option value="Pending" {{ $pendaftaran->status == 'Pending' ? 'selected' : '' }}>Pending (Menunggu Verifikasi)</option>
                                    <option value="Verified" {{ $pendaftaran->status == 'Verified' ? 'selected' : '' }}>Verified (Data Valid)</option>
                                    <option value="Scheduled" {{ $pendaftaran->status == 'Scheduled' ? 'selected' : '' }}>Scheduled (Tugaskan Teknisi)</option>
                                    <option value="Progress" {{ $pendaftaran->status == 'Progress' ? 'selected' : '' }}>Progress (Sedang Dikerjakan)</option>
                                    <option value="Reported" {{ $pendaftaran->status == 'Reported' ? 'selected' : '' }}>Reported (Laporan Masuk)</option>
                                    <option value="Completed" {{ $pendaftaran->status == 'Completed' ? 'selected' : '' }}>Completed (Selesai Final)</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-500">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                            <div class="mt-2 flex items-start gap-2 text-xs text-slate-500 bg-blue-50 p-2 rounded border border-blue-100">
                                <i class="fas fa-info-circle text-blue-500 mt-0.5"></i>
                                <span>
                                    Pilih <strong>Scheduled</strong> agar muncul di dashboard Teknisi. <br>
                                    Pilih <strong>Completed</strong> setelah Anda memverifikasi laporan teknisi.
                                </span>
                            </div>
                            @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-100">
                    <a href="{{ route('pendaftaran.index') }}" class="px-5 py-2.5 rounded-lg border border-gray-300 text-gray-700 font-semibold hover:bg-gray-50 transition">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold shadow-md shadow-blue-500/20 transition transform active:scale-95 flex items-center gap-2">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection