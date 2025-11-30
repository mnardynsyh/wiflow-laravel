@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Buat Laporan Instalasi</h2>

        <form action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Pilih Pelanggan / Pendaftaran</label>
                <select name="id_pendaftaran" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 border p-2">
                    <option value="">-- Pilih Data Pendaftaran --</option>
                    @foreach($pendaftaran as $p)
                        <option value="{{ $p->id }}" {{ old('id_pendaftaran') == $p->id ? 'selected' : '' }}>
                            {{ $p->nama_pelanggan }} - {{ $p->alamat_pemasangan }}
                        </option>
                    @endforeach
                </select>
                @error('id_pendaftaran') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Teknisi Bertugas</label>
                <select name="id_teknisi" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 border p-2">
                    <option value="">-- Pilih Teknisi --</option>
                    @foreach($teknisi as $t)
                        <option value="{{ $t->id }}" {{ old('id_teknisi') == $t->id ? 'selected' : '' }}>
                            {{ $t->name }}
                        </option>
                    @endforeach
                </select>
                @error('id_teknisi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Catatan Instalasi</label>
                <textarea name="catatan_teknisi" rows="4" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 border p-2" placeholder="Tuliskan kendala atau detail instalasi...">{{ old('catatan_teknisi') }}</textarea>
                @error('catatan_teknisi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Bukti Foto (Wajib)</label>
                <input type="file" name="bukti_foto" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG. Maks 2MB.</p>
                @error('bukti_foto') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end gap-2">
                <a href="{{ route('reports.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded">Batal</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Simpan Laporan</button>
            </div>
        </form>
    </div>
</div>
@endsection