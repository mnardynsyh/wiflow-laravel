@extends('layouts.app')

@section('title', 'Edit Paket Layanan')

@section('content')
<div class="max-w-3xl mx-auto">
    
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Edit Paket Layanan</h1>
            <p class="text-sm text-gray-500">Perbarui informasi harga atau deskripsi paket ini.</p>
        </div>
        <a href="{{ route('plans.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-slate-600 hover:text-blue-600 bg-white border border-slate-200 px-4 py-2 rounded-lg shadow-sm transition-all hover:bg-slate-50">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 bg-slate-50 border-b border-slate-100 flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center text-amber-600">
                <i class="fas fa-edit"></i>
            </div>
            <h3 class="font-bold text-slate-800">Edit Informasi Paket</h3>
        </div>

        <div class="p-6 md:p-8">
            <form action="{{ route('plans.update', $plan->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    
                    {{-- Nama Paket --}}
                    <div>
                        <label for="nama_paket" class="block text-sm font-semibold text-slate-700 mb-2">Nama Paket</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-tag text-slate-400"></i>
                            </div>
                            <input type="text" name="nama_paket" id="nama_paket" value="{{ old('nama_paket', $plan->nama_paket) }}" 
                                   class="w-full pl-10 pr-4 py-2.5 rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500 placeholder-slate-400 transition shadow-sm" 
                                   placeholder="Contoh: Super Fiber 50 Mbps">
                        </div>
                        @error('nama_paket') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Harga --}}
                    <div>
                        <label for="harga" class="block text-sm font-semibold text-slate-700 mb-2">Harga Bulanan</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-slate-500 font-bold text-sm">Rp</span>
                            </div>
                            <input type="number" name="harga" id="harga" value="{{ old('harga', $plan->harga) }}" 
                                   class="w-full pl-10 pr-4 py-2.5 rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500 placeholder-slate-400 transition shadow-sm" 
                                   placeholder="150000">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-slate-400 text-sm">/bulan</span>
                            </div>
                        </div>
                        @error('harga') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Deskripsi --}}
                    <div>
                        <label for="deskripsi" class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi & Keunggulan</label>
                        <textarea name="deskripsi" id="deskripsi" rows="4" 
                                  class="w-full px-4 py-2.5 rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500 placeholder-slate-400 transition shadow-sm resize-none" 
                                  placeholder="Jelaskan detail kecepatan, kuota, atau bonus alat...">{{ old('deskripsi', $plan->deskripsi) }}</textarea>
                        <p class="text-xs text-slate-400 mt-1">Maksimal 255 karakter.</p>
                        @error('deskripsi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Status --}}
                    <div class="bg-amber-50 p-4 rounded-lg border border-amber-100">
                        <label for="is_active" class="block text-sm font-semibold text-amber-800 mb-2">Status Publikasi</label>
                        <div class="relative">
                            <select name="is_active" id="is_active" class="w-full rounded-lg border-amber-200 focus:ring-amber-500 focus:border-amber-500 bg-white py-2.5 px-4 pr-8 text-slate-700 cursor-pointer">
                                <option value="1" {{ old('is_active', $plan->is_active) == '1' ? 'selected' : '' }}>Aktif (Tampil di Web)</option>
                                <option value="0" {{ old('is_active', $plan->is_active) == '0' ? 'selected' : '' }}>Non-Aktif (Sembunyikan)</option>
                            </select>
                        </div>
                        <p class="text-xs text-amber-700 mt-2 flex items-center gap-1.5">
                            <i class="fas fa-info-circle"></i> 
                            Mengubah status menjadi Non-Aktif akan menyembunyikan paket ini dari publik.
                        </p>
                    </div>

                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center justify-end gap-3 pt-8 mt-6 border-t border-slate-100">
                    <a href="{{ route('plans.index') }}" class="px-5 py-2.5 rounded-lg border border-slate-300 text-slate-700 font-semibold hover:bg-slate-50 transition active:scale-95">
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