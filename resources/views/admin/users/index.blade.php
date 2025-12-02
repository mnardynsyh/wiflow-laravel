@extends('layouts.app')

@section('title', 'Daftar User')

@section('content')
<div class="space-y-6">

    {{-- Header Section --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">Data Pengguna</h2>
            <p class="text-sm text-gray-500">Kelola akun administrator dan teknisi lapangan.</p>
        </div>
        
        <a href="{{ route('users.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-sm hover:shadow transition-all">
            <i class="fas fa-plus"></i>
            <span>Tambah User Baru</span>
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
                        <th scope="col" class="px-6 py-4 text-left font-semibold">Nama Pengguna</th>
                        <th scope="col" class="px-6 py-4 text-left font-semibold">Email</th>
                        <th scope="col" class="px-6 py-4 text-center font-semibold">Role</th>
                        <th scope="col" class="px-6 py-4 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-100">
                    @forelse($users as $user)
                    <tr class="hover:bg-slate-50 transition duration-150">
                        {{-- Nama & Avatar --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <img class="h-9 w-9 rounded-full object-cover bg-slate-100 border border-slate-200" 
                                     src="https://ui-avatars.com/api/?name={{ urlencode($user->nama) }}&background=random&color=fff&bold=true" 
                                     alt="{{ $user->nama }}">
                                <span class="text-sm font-bold text-slate-800">{{ $user->nama }}</span>
                            </div>
                        </td>

                        {{-- Email --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                            {{ $user->email }}
                        </td>

                        {{-- Role Badge --}}
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            @if($user->role === 'admin')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-purple-50 text-purple-700 border border-purple-100">
                                    <i class="fas fa-user-shield text-[10px]"></i> 
                                    Administrator
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-100">
                                    <i class="fas fa-tools text-[10px]"></i> 
                                    Teknisi
                                </span>
                            @endif
                        </td>

                        {{-- Aksi --}}
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <div class="flex items-center justify-center gap-2">
                                {{-- Edit --}}
                                <a href="{{ route('users.edit', $user->id) }}" class="p-2 rounded-lg text-slate-500 hover:bg-amber-50 hover:text-amber-600 transition" title="Edit User">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>

                                {{-- Delete --}}
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 rounded-lg text-slate-500 hover:bg-red-50 hover:text-red-600 transition" title="Hapus User">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                    <i class="fas fa-users text-slate-300 text-3xl"></i>
                                </div>
                                <h3 class="text-lg font-medium text-slate-900">Belum ada user</h3>
                                <p class="text-slate-500 text-sm mt-1">Tambahkan user baru untuk mulai mengelola sistem.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Pagination --}}
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection