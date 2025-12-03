@extends('layouts.app')

@section('title', 'Buat Laporan Instalasi')

@section('content')
<div class="space-y-6">
    
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Buat Laporan Instalasi</h1>
            <p class="text-sm text-gray-500">Input laporan manual untuk instalasi yang telah selesai.</p>
        </div>
        <a href="{{ route('reports.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-slate-600 hover:text-blue-600 bg-white border border-slate-200 px-4 py-2 rounded-lg shadow-sm transition-all hover:bg-slate-50">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 bg-slate-50 border-b border-slate-100 flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600">
                <i class="fas fa-file-signature"></i>
            </div>
            <h3 class="font-bold text-slate-800">Formulir Laporan</h3>
        </div>

        <div class="p-6 md:p-8">
            <form action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    
                    {{-- Pilihan Pendaftaran --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Pilih Pelanggan / Jadwal</label>
                        <div class="relative">
                            <select name="id_pendaftaran" class="w-full rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500 appearance-none bg-white py-2.5 px-4 pr-8 cursor-pointer">
                                <option value="">-- Pilih Data Pendaftaran --</option>
                                @foreach($pendaftaran as $p)
                                    <option value="{{ $p->id }}" {{ old('id_pendaftaran') == $p->id ? 'selected' : '' }}>
                                        #{{ $p->id }} - {{ $p->nama_pelanggan }} ({{ $p->alamat_pemasangan }})
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-slate-500">
                                <i class="fas fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                        <p class="text-xs text-slate-400 mt-1">Hanya menampilkan pendaftaran dengan status 'Dijadwalkan' atau 'Proses'.</p>
                        @error('id_pendaftaran') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Pilihan Teknisi --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Teknisi Bertugas</label>
                        <div class="relative">
                            <select name="id_teknisi" class="w-full rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500 appearance-none bg-white py-2.5 px-4 pr-8 cursor-pointer">
                                <option value="">-- Pilih Teknisi --</option>
                                @foreach($teknisi as $t)
                                    <option value="{{ $t->id }}" {{ old('id_teknisi') == $t->id ? 'selected' : '' }}>
                                        {{ $t->nama }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-slate-500">
                                <i class="fas fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                        @error('id_teknisi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Catatan --}}
                    <div class="lg:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Catatan Instalasi</label>
                        <textarea name="catatan_teknisi" rows="4" 
                                  class="w-full rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500 py-2.5 px-4 placeholder-slate-400 transition shadow-sm resize-none" 
                                  placeholder="Tuliskan kendala teknis, hasil tes kecepatan, atau detail pemasangan lainnya...">{{ old('catatan_teknisi') }}</textarea>
                        @error('catatan_teknisi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Upload Foto --}}
                    <div class="lg:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Bukti Foto (Wajib)</label>
                        <div class="flex items-center justify-center w-full">
                            <label for="bukti_foto" class="flex flex-col items-center justify-center w-full h-40 border-2 border-slate-300 border-dashed rounded-xl cursor-pointer bg-slate-50 hover:bg-blue-50 hover:border-blue-300 transition group">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <i class="fas fa-cloud-upload-alt text-3xl text-slate-400 group-hover:text-blue-500 mb-2 transition"></i>
                                    <p class="text-sm text-slate-500 group-hover:text-blue-600"><span class="font-semibold">Klik untuk upload</span> atau drag and drop</p>
                                    <p class="text-xs text-slate-400">JPG, PNG (Maks. 2MB)</p>
                                </div>
                                <input id="bukti_foto" name="bukti_foto" type="file" class="hidden" />
                            </label>
                        </div>
                        @error('bukti_foto') <p class="text-red-500 text-xs mt-1 text-center">{{ $message }}</p> @enderror
                    </div>

                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center justify-end gap-3 pt-8 mt-6 border-t border-slate-100">
                    <a href="{{ route('reports.index') }}" class="px-5 py-2.5 rounded-lg border border-slate-300 text-slate-700 font-semibold hover:bg-slate-50 transition active:scale-95">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold shadow-md shadow-blue-500/20 transition transform active:scale-95 flex items-center gap-2">
                        <i class="fas fa-save"></i> Simpan Laporan
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection