@extends('layouts.worker')

@section('title', 'Lapor Hasil Instalasi')

@section('content')
<div class="max-w-xl mx-auto space-y-6">
    
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-gray-900 tracking-tight">Laporan Penyelesaian</h1>
            <p class="text-sm text-gray-500">Kirim bukti instalasi untuk menyelesaikan tugas.</p>
        </div>
        <a href="{{ route('teknisi.assignments.index') }}" class="text-sm font-medium text-slate-500 hover:text-slate-800 bg-white border border-slate-200 px-3 py-1.5 rounded-lg shadow-sm">
            Batal
        </a>
    </div>

    {{-- Kartu Info Pekerjaan (Read Only) --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="bg-slate-50 px-5 py-3 border-b border-slate-200 flex items-center gap-2">
            <i class="fas fa-map-marker-alt text-red-500"></i>
            <span class="text-sm font-bold text-slate-700">Target Instalasi</span>
        </div>
        <div class="p-5">
            <h3 class="text-lg font-bold text-slate-800">{{ $pendaftaran->nama_pelanggan }}</h3>
            <p class="text-sm text-slate-600 mt-1 mb-3 leading-relaxed">{{ $pendaftaran->alamat_pemasangan }}</p>
            
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-100">
                    {{ $pendaftaran->paket->nama_paket ?? 'Paket Unknown' }}
                </span>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                    #{{ $pendaftaran->id }}
                </span>
            </div>
        </div>
    </div>

    {{-- Form Laporan --}}
    <form action="{{ route('teknisi.laporan.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 md:p-6">
        @csrf
        <input type="hidden" name="id_pendaftaran" value="{{ $pendaftaran->id }}">

        <div class="space-y-6">
            
            {{-- Input Foto (Area Tap Besar) --}}
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Foto Bukti (Wajib)</label>
                
                {{-- Preview Image Container --}}
                <div id="image-preview" class="hidden mb-3 relative w-full h-48 bg-slate-100 rounded-lg overflow-hidden border border-slate-200">
                    <img id="preview-img" src="#" alt="Preview" class="w-full h-full object-cover">
                    <button type="button" onclick="resetImage()" class="absolute top-2 right-2 bg-red-600 text-white rounded-full p-1.5 shadow-md hover:bg-red-700 transition">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                </div>

                {{-- Input Area --}}
                <label for="bukti_foto" id="upload-area" class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed border-emerald-300 rounded-xl cursor-pointer bg-emerald-50/50 hover:bg-emerald-50 transition group">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mb-3 group-hover:scale-110 transition">
                            <i class="fas fa-camera text-xl"></i>
                        </div>
                        <p class="text-sm text-slate-600 font-medium group-hover:text-emerald-700">Tap untuk ambil foto</p>
                        <p class="text-xs text-slate-400 mt-1">JPG/PNG, Max 2MB</p>
                    </div>
                    <input id="bukti_foto" type="file" name="bukti_foto" class="hidden" accept="image/*" capture="environment" onchange="previewImage(this)" />
                </label>
                @error('bukti_foto') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
            </div>

            {{-- Input Catatan --}}
            <div>
                <label for="catatan_teknisi" class="block text-sm font-semibold text-slate-700 mb-2">Catatan Pengerjaan</label>
                <textarea name="catatan_teknisi" id="catatan_teknisi" rows="3" 
                          class="w-full px-4 py-3 rounded-xl border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 placeholder-slate-400 text-sm transition shadow-sm" 
                          placeholder="Contoh: Kabel habis 50m, redaman -18dB, modem ditaruh di ruang tamu...">{{ old('catatan_teknisi') }}</textarea>
                @error('catatan_teknisi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Submit Button --}}
            <button type="submit" class="w-full flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3.5 px-4 rounded-xl shadow-lg shadow-emerald-500/20 transition transform active:scale-95">
                <i class="fas fa-paper-plane"></i>
                <span>Kirim Laporan & Selesai</span>
            </button>

        </div>
    </form>
</div>

{{-- Script Sederhana untuk Preview Gambar --}}
<script>
    function previewImage(input) {
        const preview = document.getElementById('preview-img');
        const previewContainer = document.getElementById('image-preview');
        const uploadArea = document.getElementById('upload-area');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                previewContainer.classList.remove('hidden');
                uploadArea.classList.add('hidden'); // Sembunyikan area upload biar rapi
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    function resetImage() {
        const input = document.getElementById('bukti_foto');
        const previewContainer = document.getElementById('image-preview');
        const uploadArea = document.getElementById('upload-area');

        input.value = ''; // Reset input file
        previewContainer.classList.add('hidden');
        uploadArea.classList.remove('hidden');
    }
</script>
@endsection