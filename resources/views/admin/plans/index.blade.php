@extends('layouts.app')

@section('title', 'Manajemen Paket Layanan')

@section('content')
<div class="space-y-6">

    {{-- Header Section --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">Paket Layanan Internet</h2>
            <p class="text-sm text-gray-500">Atur harga dan deskripsi paket yang akan ditampilkan di Landing Page.</p>
        </div>
        
        <a href="{{ route('plans.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-sm hover:shadow transition-all">
            <i class="fas fa-plus"></i>
            <span>Tambah Paket Baru</span>
        </a>
    </div>

    {{-- Pesan Sukses --}}
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-lg flex items-center gap-2 shadow-sm" role="alert">
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
                        <th scope="col" class="px-6 py-4 text-left font-semibold">Nama Paket</th>
                        <th scope="col" class="px-6 py-4 text-left font-semibold">Harga Bulanan</th>
                        <th scope="col" class="px-6 py-4 text-left font-semibold">Deskripsi</th>
                        <th scope="col" class="px-6 py-4 text-center font-semibold">Status</th>
                        <th scope="col" class="px-6 py-4 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-100">
                    @forelse($plans as $item)
                    <tr class="hover:bg-slate-50 transition duration-150">
                        {{-- Nama Paket --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-600 flex-shrink-0">
                                    <i class="fas fa-wifi text-lg"></i>
                                </div>
                                <span class="text-sm font-bold text-slate-800">{{ $item->nama_paket }}</span>
                            </div>
                        </td>

                        {{-- Harga --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-bold text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-100">
                                Rp {{ number_format($item->harga, 0, ',', '.') }}
                            </span>
                        </td>

                        {{-- Deskripsi --}}
                        <td class="px-6 py-4">
                            <p class="text-xs text-slate-500 line-clamp-2 max-w-xs" title="{{ $item->deskripsi }}">
                                {{ $item->deskripsi ?? 'Tidak ada deskripsi' }}
                            </p>
                        </td>

                        {{-- Status --}}
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            @if($item->is_active)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                    Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-600 border border-slate-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                    Non-Aktif
                                </span>
                            @endif
                        </td>

                        {{-- Aksi --}}
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <div class="flex items-center justify-center gap-2">
                                {{-- Edit --}}
                                <a href="{{ route('plans.edit', $item->id) }}" class="p-2 rounded-lg text-slate-500 hover:bg-amber-50 hover:text-amber-600 transition" title="Edit Paket">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>

                                {{-- Hapus --}}
                                <form action="{{ route('plans.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus paket ini? Paket yang sedang digunakan pelanggan sebaiknya dinonaktifkan saja.')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 rounded-lg text-slate-500 hover:bg-red-50 hover:text-red-600 transition" title="Hapus Paket">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                    <i class="fas fa-tags text-slate-300 text-3xl"></i>
                                </div>
                                <h3 class="text-lg font-medium text-slate-900">Belum ada paket layanan</h3>
                                <p class="text-slate-500 text-sm mt-1 max-w-sm">
                                    Tambahkan paket internet agar pelanggan bisa mulai mendaftar di halaman depan.
                                </p>
                                <a href="{{ route('plans.create') }}" class="mt-4 text-blue-600 hover:text-blue-700 font-medium text-sm">
                                    + Tambah Paket Sekarang
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Pagination jika diperlukan --}}
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50">
            {{-- $plans->links() --}}
        </div>
    </div>
</div>
@endsection