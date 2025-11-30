@extends('layouts.app') {{-- Sesuaikan dengan layout utama Anda --}}

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Daftar Pendaftaran Pasang Baru</h1>
    </div>

    {{-- Pesan Sukses --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th class="px-6 py-3">No</th>
                    <th class="px-6 py-3">Pelanggan</th>
                    <th class="px-6 py-3">Paket</th>
                    <th class="px-6 py-3">Jadwal</th>
                    <th class="px-6 py-3">Teknisi</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendaftarans as $index => $item)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-6 py-4">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-800">{{ $item->nama_pelanggan }}</div>
                        <div class="text-xs">{{ $item->no_hp }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                            {{ $item->paket->nama_paket ?? 'Paket Dihapus' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        {{ $item->tanggal_jadwal ? \Carbon\Carbon::parse($item->tanggal_jadwal)->format('d M Y H:i') : '-' }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $item->teknisi->name ?? 'Belum Ditugaskan' }}
                    </td>
                    <td class="px-6 py-4">
                        @php
                            $colors = [
                                'Pending' => 'bg-yellow-100 text-yellow-800',
                                'Verified' => 'bg-blue-100 text-blue-800',
                                'Scheduled' => 'bg-indigo-100 text-indigo-800',
                                'Progress' => 'bg-orange-100 text-orange-800',
                                'Reported' => 'bg-purple-100 text-purple-800',
                                'Completed' => 'bg-green-100 text-green-800',
                            ];
                            $badgeColor = $colors[$item->status] ?? 'bg-gray-100 text-gray-800';
                        @endphp
                        <span class="{{ $badgeColor }} text-xs font-medium px-2.5 py-0.5 rounded">
                            {{ $item->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center gap-2">
                            {{-- Tombol Detail --}}
                            <a href="{{ route('pendaftaran.show', $item->id) }}" class="text-blue-600 hover:text-blue-900 border border-blue-600 px-2 py-1 rounded text-xs hover:bg-blue-50">
                                Detail
                            </a>

                            {{-- Tombol Edit (Hanya Admin) --}}
                            @if(Auth::user()->role === 'admin')
                                <a href="{{ route('pendaftaran.edit', $item->id) }}" class="text-yellow-600 hover:text-yellow-900 border border-yellow-600 px-2 py-1 rounded text-xs hover:bg-yellow-50">
                                    Proses
                                </a>
                                
                                {{-- Tombol Hapus --}}
                                <form action="{{ route('pendaftaran.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 border border-red-600 px-2 py-1 rounded text-xs hover:bg-red-50">
                                        Hapus
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">Belum ada data pendaftaran.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection