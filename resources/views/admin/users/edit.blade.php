@extends('layouts.app')

@section('title', 'Edit Data User')

@section('content')
<div class="space-y-6">
    
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Edit Data User</h1>
            <p class="text-sm text-gray-500">Perbarui informasi akun administrator atau teknisi.</p>
        </div>
        <a href="{{ route('users.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-slate-600 hover:text-blue-600 bg-white border border-slate-200 px-4 py-2 rounded-lg shadow-sm transition-all hover:bg-slate-50">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 bg-slate-50 border-b border-slate-100 flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center text-amber-600">
                <i class="fas fa-user-edit"></i>
            </div>
            <h3 class="font-bold text-slate-800">Formulir Edit Akun</h3>
        </div>

        <div class="p-6 md:p-8">
            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-8 gap-y-6">
                    
                    {{-- Nama Lengkap --}}
                    <div>
                        <label for="nama" class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="far fa-user text-slate-400"></i>
                            </div>
                            <input type="text" name="nama" id="nama" value="{{ old('nama', $user->nama) }}" 
                                   class="w-full pl-10 pr-4 py-2.5 rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500 placeholder-slate-400 transition shadow-sm" 
                                   placeholder="Nama Lengkap">
                        </div>
                        @error('nama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Alamat Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="far fa-envelope text-slate-400"></i>
                            </div>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" 
                                   class="w-full pl-10 pr-4 py-2.5 rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500 placeholder-slate-400 transition shadow-sm" 
                                   placeholder="contoh@wifinet.id">
                        </div>
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Role --}}
                    <div>
                        <label for="role" class="block text-sm font-semibold text-slate-700 mb-2">Peran (Role)</label>
                        <div class="relative">
                            <select name="role" id="role" class="w-full rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500 appearance-none bg-white py-2.5 pl-4 pr-10 text-slate-700 cursor-pointer">
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrator</option>
                                <option value="teknisi" {{ old('role', $user->role) == 'teknisi' ? 'selected' : '' }}>Teknisi Lapangan</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-slate-500">
                                <i class="fas fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                        @error('role') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Spacer (Agar grid rapi) --}}
                    <div class="hidden lg:block"></div>

                    {{-- Password Section --}}
                    <div class="lg:col-span-2 pt-6 border-t border-slate-100 mt-2">
                        <div class="bg-blue-50 p-4 rounded-lg border border-blue-100 mb-6 flex items-start gap-3">
                            <i class="fas fa-lock text-blue-500 mt-1"></i>
                            <div>
                                <h4 class="text-sm font-semibold text-blue-800">Ubah Password</h4>
                                <p class="text-xs text-blue-600 mt-1">
                                    Kosongkan kolom password di bawah jika Anda tidak ingin mengubah password pengguna ini.
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">Password Baru</label>
                                <input type="password" name="password" id="password" 
                                       class="w-full px-4 py-2.5 rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500 placeholder-slate-400 transition shadow-sm" 
                                       placeholder="Minimal 6 karakter">
                                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center justify-end gap-3 pt-8 mt-6 border-t border-slate-100">
                    <a href="{{ route('users.index') }}" class="px-5 py-2.5 rounded-lg border border-slate-300 text-slate-700 font-semibold hover:bg-slate-50 transition active:scale-95">
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