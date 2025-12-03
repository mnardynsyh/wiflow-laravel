@extends('layouts.app')

@section('title', 'Edit Laporan Instalasi')

@section('content')
<div class="space-y-6">
    
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Edit Laporan Instalasi</h1>
            <p class="text-sm text-gray-500">Perbarui data laporan jika terdapat kesalahan input atau revisi.</p>
        </div>
        <a href="{{ route('reports.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-slate-600 hover:text-blue-600 bg-white border border-slate-200 px-4 py-2 rounded-lg shadow-sm transition-all hover:bg-slate-50">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 bg-slate-50 border-b border-slate-100 flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center text-amber-600">
                <i class="fas fa-edit"></i>
            </div>
            <h3 class="font-bold text-slate-800">Formulir Perubahan Data</h3>
        </div>

        <div class="p-6 md:p-8">
            <form action="{{ route('reports.update', $laporan->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    
                    {{-- Pilihan Pendaftaran --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Pelanggan / ID Pendaftaran</label>
                        <div class="relative">
                            <select name="id_pendaftaran" class="w-full rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500 appearance-none bg-white py-2.5 px-4 pr-8 cursor-pointer">
                                {{-- Loop pendaftaran, tapi select yang sesuai dengan laporan ini --}}
                                @foreach($pendaftaran as $p)
                                    <option value="{{ $p->id }}" {{ old('id_pendaftaran', $laporan->id_pendaftaran) == $p->id ? 'selected' : '' }}>
                                        #{{ $p->id }} - {{ $p->nama_pelanggan }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-slate-500">
                                <i class="fas fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                        @error('id_pendaftaran') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Pilihan Teknisi --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Teknisi Bertugas</label>
                        <div class="relative">
                            <select name="id_teknisi" class="w-full rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500 appearance-none bg-white py-2.5 px-4 pr-8 cursor-pointer">
                                @foreach($teknisi as $t)
                                    <option value="{{ $t->id }}" {{ old('id_teknisi', $laporan->id_teknisi) == $t->id ? 'selected' : '' }}>
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
                                  class="w-full rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500 py-2.5 px-4 placeholder-slate-400 transition shadow-sm resize-none">{{ old('catatan_teknisi', $laporan->catatan_teknisi) }}</textarea>
                        @error('catatan_teknisi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Upload Foto Baru --}}
                    <div class="lg:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Perbarui Bukti Foto (Opsional)</label>
                        
                        <div class="flex flex-col sm:flex-row gap-6">
                            {{-- Preview Foto Lama --}}
                            @if($laporan->bukti_foto)
                                <div class="w-full sm:w-1/3">
                                    <div class="rounded-lg border border-slate-200 p-2 bg-slate-50">
                                        <p class="text-xs text-slate-500 mb-2 text-center">Foto Saat Ini:</p>
                                        <img src="{{ asset('storage/' . $laporan->bukti_foto) }}" alt="Bukti Lama" class="w-full h-32 object-cover rounded-md">
                                    </div>
                                </div>
                            @endif

                            {{-- Input Foto Baru --}}
                            <div class="flex-1">
                                <div class="flex items-center justify-center w-full">
                                    <label for="bukti_foto" class="flex flex-col items-center justify-center w-full h-32 border-2 border-slate-300 border-dashed rounded-xl cursor-pointer bg-white hover:bg-blue-50 hover:border-blue-300 transition group">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <i class="fas fa-cloud-upload-alt text-2xl text-slate-400 group-hover:text-blue-500 mb-2 transition"></i>
                                            <p class="text-sm text-slate-500 group-hover:text-blue-600"><span class="font-semibold">Klik ganti foto</span> atau drag and drop</p>
                                            <p class="text-xs text-slate-400">Biarkan kosong jika tidak ingin mengubah</p>
                                        </div>
                                        <input id="bukti_foto" name="bukti_foto" type="file" class="hidden" />
                                    </label>
                                </div>
                                @error('bukti_foto') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center justify-end gap-3 pt-8 mt-6 border-t border-slate-100">
                    <a href="{{ route('reports.index') }}" class="px-5 py-2.5 rounded-lg border border-slate-300 text-slate-700 font-semibold hover:bg-slate-50 transition active:scale-95">
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