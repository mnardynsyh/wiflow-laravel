@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Daftar Subscription Plan</h1>
        <a href="{{ route('plans.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow transition">
            + Tambah Plan
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th class="px-6 py-3">Nama Plan</th>
                    <th class="px-6 py-3">Harga</th>
                    <th class="px-6 py-3">Deskripsi</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($plans as $item)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-6 py-4 font-bold text-gray-900">
                        {{ $item->nama_paket }}
                    </td>
                    <td class="px-6 py-4">
                        Rp {{ number_format($item->harga, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 truncate max-w-xs">
                        {{ $item->deskripsi ?? '-' }}
                    </td>
                    <td class="px-6 py-4">
                        @if($item->is_active)
                            <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded">Active</span>
                        @else
                            <span class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded">Inactive</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('plans.edit', $item->id) }}" class="text-yellow-600 hover:text-yellow-900 border border-yellow-600 px-2 py-1 rounded text-xs hover:bg-yellow-50">
                                Edit
                            </a>
                            <form action="{{ route('plans.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus plan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 border border-red-600 px-2 py-1 rounded text-xs hover:bg-red-50">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada plan tersedia.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection