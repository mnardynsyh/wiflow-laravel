@extends('layouts.worker')

@section('title', 'Lapor Hasil Instalasi')

@section('content')
<div class="space-y-6">
    
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Laporan Penyelesaian</h1>
            <p class="text-sm text-gray-500">Kirim bukti instalasi untuk menyelesaikan tugas #{{ $pendaftaran->id }}.</p>
        </div>
        <a href="{{ route('teknisi.assignments.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-slate-600 hover:text-blue-600 bg-white border border-slate-200 px-4 py-2 rounded-lg shadow-sm transition-all hover:bg-slate-50 w-fit">
            <i class="fas fa-arrow-left"></i> Batal
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- KOLOM 1: Info Target (Read Only) --}}
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden sticky top-24">
                <div class="bg-slate-50 px-5 py-4 border-b border-slate-200 flex items-center gap-2">
                    <i class="fas fa-map-marker-alt text-red-500"></i>
                    <h3 class="font-bold text-slate-700">Target Instalasi</h3>
                </div>
                <div class="p-5 space-y-4">
                    <div>
                        <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Nama Pelanggan</span>
                        <div class="text-lg font-bold text-slate-800">{{ $pendaftaran->nama_pelanggan }}</div>
                    </div>
                    
                    <div>
                        <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Alamat</span>
                        <div class="text-sm text-slate-600 leading-relaxed bg-slate-50 p-3 rounded-lg border border-slate-100">
                            {{ $pendaftaran->alamat_pemasangan }}
                        </div>
                    </div>

                    <div class="pt-2 border-t border-slate-100">
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-slate-500">Paket Layanan</span>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-100">
                                {{ $pendaftaran->paket->nama_paket ?? 'Paket Unknown' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- KOLOM 2: Form Laporan --}}
        <div class="lg:col-span-2">
            <form action="{{ route('teknisi.laporan.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                @csrf
                <input type="hidden" name="id_pendaftaran" value="{{ $pendaftaran->id }}">

                <div class="px-6 py-4 bg-slate-50 border-b border-slate-200 flex items-center gap-2">
                    <i class="fas fa-camera text-emerald-600"></i>
                    <h3 class="font-bold text-slate-800">Formulir Bukti Kerja</h3>
                </div>

                <div class="p-6 space-y-6">
                    
                    {{-- Input Foto (Area Besar untuk Mobile) --}}
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Foto Bukti (Wajib)</label>
                        
                        {{-- Preview Container --}}
                        <div id="image-preview" class="hidden mb-4 relative w-full h-64 bg-slate-100 rounded-xl overflow-hidden border border-slate-200">
                            <img id="preview-img" src="#" alt="Preview" class="w-full h-full object-cover">
                            <div class="absolute top-2 right-2">
                                <button type="button" onclick="resetImage()" class="bg-red-600 text-white rounded-lg p-2 shadow-md hover:bg-red-700 transition flex items-center gap-1 text-xs font-bold">
                                    <i class="fas fa-trash-alt"></i> Hapus
                                </button>
                            </div>
                        </div>

                        {{-- Input Area --}}
                        <label for="bukti_foto" id="upload-area" class="flex flex-col items-center justify-center w-full h-52 border-2 border-dashed border-emerald-300 rounded-xl cursor-pointer bg-emerald-50/30 hover:bg-emerald-50 transition group">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition shadow-sm">
                                    <i class="fas fa-camera text-3xl"></i>
                                </div>
                                <p class="text-base text-slate-700 font-bold group-hover:text-emerald-700">Ketuk untuk ambil foto</p>
                                <p class="text-xs text-slate-500 mt-1">Pastikan foto jelas (JPG/PNG, Max 2MB)</p>
                            </div>
                            <input id="bukti_foto" type="file" name="bukti_foto" class="hidden" accept="image/*" capture="environment" onchange="previewImage(this)" />
                        </label>
                        @error('bukti_foto') 
                            <p class="text-red-500 text-sm mt-2 font-medium flex items-center gap-1">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </p> 
                        @enderror
                    </div>

                    {{-- Input Catatan --}}
                    <div>
                        <label for="catatan_teknisi" class="block text-sm font-bold text-slate-700 mb-2">Catatan Pengerjaan</label>
                        <textarea name="catatan_teknisi" id="catatan_teknisi" rows="4" 
                                  class="w-full px-4 py-3 rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 placeholder-slate-400 text-sm transition shadow-sm resize-none" 
                                  placeholder="Tuliskan detail teknis seperti: Redaman kabel, Serial Number Modem, atau kendala yang ditemui...">{{ old('catatan_teknisi') }}</textarea>
                        @error('catatan_teknisi') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                </div>

                {{-- Footer Action --}}
                <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex justify-end">
                    <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-8 rounded-xl shadow-md hover:shadow-lg transition transform active:scale-95">
                        <i class="fas fa-paper-plane"></i>
                        <span>Kirim Laporan & Selesai</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

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
                uploadArea.classList.add('hidden');
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