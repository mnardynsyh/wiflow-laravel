@extends('layouts.worker')

@section('title', 'Profil Saya')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    
    <div class="flex items-center gap-4">
        <div class="w-16 h-16 rounded-full bg-emerald-100 flex items-center justify-center border-4 border-white shadow-sm">
            <span class="text-2xl font-bold text-emerald-600">{{ substr(Auth::user()->nama, 0, 1) }}</span>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Pengaturan Akun</h1>
            <p class="text-sm text-gray-500">Kelola informasi profil dan keamanan akun Anda.</p>
        </div>
    </div>

    <!-- Info Profil (Read Only) -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-bold text-gray-800 mb-4 border-b border-gray-100 pb-2">Informasi Dasar</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Nama Lengkap</label>
                <input type="text" value="{{ Auth::user()->nama }}" readonly class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2 text-slate-600 cursor-not-allowed">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Email</label>
                <input type="text" value="{{ Auth::user()->email }}" readonly class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2 text-slate-600 cursor-not-allowed">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Role</label>
                <span class="inline-flex items-center px-3 py-1.5 rounded-md text-sm font-medium bg-emerald-100 text-emerald-700">
                    Teknisi Lapangan
                </span>
            </div>
        </div>
        <p class="mt-4 text-xs text-amber-600 flex items-center gap-2">
            <i class="fas fa-info-circle"></i> 
            Hubungi Admin jika ingin mengubah data nama atau email.
        </p>
    </div>

    <!-- Ganti Password -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-bold text-gray-800 mb-4 border-b border-gray-100 pb-2">Ganti Password</h2>
        
        <form action="{{ route('teknisi.profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Password Saat Ini</label>
                    <input type="password" name="current_password" id="current_password" required 
                           class="w-full border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 transition shadow-sm">
                    @error('current_password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                        <input type="password" name="password" id="password" required 
                               class="w-full border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 transition shadow-sm">
                        @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required 
                               class="w-full border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 transition shadow-sm">
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 px-6 rounded-lg shadow-md hover:shadow-lg transition transform active:scale-95 flex items-center gap-2">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

</div>
@endsection