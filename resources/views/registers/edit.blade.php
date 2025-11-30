@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-3xl mx-auto bg-white shadow-md rounded-lg p-6">
        <h2 class="text-xl font-bold mb-4 border-b pb-2">Proses Pendaftaran: {{ $pendaftaran->nama_pelanggan }}</h2>

        <form action="{{ route('pendaftaran.update', $pendaftaran->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                {{-- Info Readonly --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Alamat Pemasangan</label>
                    <p class="mt-1 p-2 bg-gray-100 rounded text-sm text-gray-600">{{ $pendaftaran->alamat_pemasangan }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Paket Dipilih</label>
                    <p class="mt-1 p-2 bg-gray-100 rounded text-sm text-gray-600">{{ $pendaftaran->paket->nama_paket ?? '-' }}</p>
                </div>

                {{-- Input Teknisi --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Pilih Teknisi</label>
                    <select name="id_teknisi" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2">
                        <option value="">-- Pilih Teknisi --</option>
                        @foreach($teknisi as $t)
                            <option value="{{ $t->id }}" {{ $pendaftaran->id_teknisi == $t->id ? 'selected' : '' }}>
                                {{ $t->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_teknisi') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Input Tanggal Jadwal --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Jadwal Pemasangan</label>
                    <input type="datetime-local" name="tanggal_jadwal" 
                           value="{{ $pendaftaran->tanggal_jadwal ? \Carbon\Carbon::parse($pendaftaran->tanggal_jadwal)->format('Y-m-d\TH:i') : '' }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2">
                    @error('tanggal_jadwal') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Input Status --}}
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Status Pengerjaan</label>
                    <select name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2">
                        {{-- Value disesuaikan dengan Enum di Database Migration --}}
                        <option value="Pending" {{ $pendaftaran->status == 'Pending' ? 'selected' : '' }}>Pending (Baru Masuk)</option>
                        <option value="Verified" {{ $pendaftaran->status == 'Verified' ? 'selected' : '' }}>Verified (Data Valid)</option>
                        <option value="Scheduled" {{ $pendaftaran->status == 'Scheduled' ? 'selected' : '' }}>Scheduled (Dijadwalkan)</option>
                        <option value="Progress" {{ $pendaftaran->status == 'Progress' ? 'selected' : '' }}>Progress (Sedang Dikerjakan)</option>
                        <option value="Reported" {{ $pendaftaran->status == 'Reported' ? 'selected' : '' }}>Reported (Laporan Masuk)</option>
                        <option value="Completed" {{ $pendaftaran->status == 'Completed' ? 'selected' : '' }}>Completed (Selesai)</option>
                    </select>
                    @error('status') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('pendaftaran.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 transition">Batal</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection