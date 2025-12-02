@extends('layouts.app')

@section('title', 'Daftar Pendaftaran Baru')

@section('content')
<div class="space-y-6">
    
    {{-- Header Section --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">Pendaftaran Masuk</h2>
            <p class="text-sm text-gray-500">Kelola permintaan pemasangan baru dari pelanggan.</p>
        </div>
    </div>

    {{-- Pesan Sukses --}}
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-lg flex items-center gap-2" role="alert">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- Tabel Data --}}
    <div class="bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100">
                <thead class="bg-slate-50">
                    <tr class="text-xs text-slate-500 uppercase tracking-wider">
                        <th scope="col" class="px-6 py-4 text-left font-semibold">No</th>
                        <th scope="col" class="px-6 py-4 text-left font-semibold">Data Pelanggan</th>
                        <th scope="col" class="px-6 py-4 text-left font-semibold">Paket Pilihan</th>
                        <th scope="col" class="px-6 py-4 text-left font-semibold">Jadwal & Teknisi</th>
                        <th scope="col" class="px-6 py-4 text-center font-semibold">Status</th>
                        <th scope="col" class="px-6 py-4 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-100">
                    @forelse($pendaftarans as $index => $item)
                    <tr class="hover:bg-slate-50 transition duration-150">
                        <td class="px-6 py-4 text-sm text-slate-500">
                            {{ $loop->iteration }}
                        </td>
                        
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-slate-800">{{ $item->nama_pelanggan }}</span>
                                <span class="text-xs text-slate-500 flex items-center gap-1 mt-1">
                                    <i class="fab fa-whatsapp text-emerald-500"></i> {{ $item->no_hp }}
                                </span>
                                <span class="text-xs text-slate-400 mt-0.5 line-clamp-1" title="{{ $item->alamat_pemasangan }}">
                                    <i class="fas fa-map-marker-alt text-red-400 mr-1"></i> {{ Str::limit($item->alamat_pemasangan, 30) }}
                                </span>
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-100">
                                <i class="fas fa-wifi mr-1.5"></i>
                                {{ $item->paket->nama_paket ?? 'Paket Dihapus' }}
                            </span>
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex flex-col gap-1">
                                @if($item->tanggal_jadwal)
                                    <div class="text-xs text-slate-700 font-medium">
                                        <i class="far fa-calendar-alt text-slate-400 mr-1"></i> 
                                        {{ \Carbon\Carbon::parse($item->tanggal_jadwal)->format('d M Y') }}
                                    </div>
                                    <div class="text-xs text-slate-500">
                                        <i class="fas fa-user-gear text-slate-400 mr-1"></i>
                                        {{ $item->teknisi->nama ?? 'Belum ada teknisi' }}
                                    </div>
                                @else
                                    <span class="text-xs italic text-slate-400">Belum dijadwalkan</span>
                                @endif
                            </div>
                        </td>

                        <td class="px-6 py-4 text-center">
                            @php
                                $statusClasses = [
                                    'pending' => 'bg-amber-50 text-amber-700 border-amber-200',
                                    'dijadwalkan' => 'bg-blue-50 text-blue-700 border-blue-200',
                                    'selesai' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                    'batal' => 'bg-red-50 text-red-700 border-red-200',
                                ];
                                $statusLabel = [
                                    'pending' => 'Menunggu',
                                    'dijadwalkan' => 'Proses',
                                    'selesai' => 'Selesai',
                                    'batal' => 'Batal',
                                ];
                                $currentClass = $statusClasses[$item->status] ?? 'bg-gray-50 text-gray-700 border-gray-200';
                                $currentLabel = $statusLabel[$item->status] ?? ucfirst($item->status);
                            @endphp
                            <span class="inline-flex items-center justify-center px-3 py-1 rounded-full text-xs font-bold border {{ $currentClass }}">
                                {{ $currentLabel }}
                            </span>
                        </td>

                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                {{-- Tombol Detail --}}
                                <a href="{{ route('pendaftaran.show', $item->id) }}" class="p-2 rounded-lg text-slate-500 hover:bg-slate-100 hover:text-blue-600 transition" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>

                                {{-- Tombol Edit (Verifikasi) - Hanya Admin --}}
                                @if(Auth::user()->role === 'admin')
                                    <a href="{{ route('pendaftaran.edit', $item->id) }}" class="p-2 rounded-lg text-slate-500 hover:bg-amber-50 hover:text-amber-600 transition" title="Proses / Verifikasi">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    
                                    {{-- Tombol Hapus --}}
                                    <form action="{{ route('pendaftaran.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini secara permanen?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg text-slate-500 hover:bg-red-50 hover:text-red-600 transition" title="Hapus Data">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-3">
                                    <i class="fas fa-inbox text-slate-300 text-3xl"></i>
                                </div>
                                <p class="text-slate-500 font-medium">Belum ada pendaftaran baru.</p>
                                <p class="text-slate-400 text-xs mt-1">Data akan muncul saat pelanggan mengisi formulir.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Pagination (Jika pakai paginate di controller) --}}
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50">
            {{-- $pendaftarans->links() --}}
        </div>
    </div>
</div>
@endsection