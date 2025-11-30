@extends('layouts.worker')

@section('title', 'Profil Saya')

@section('content')
<div class="space-y-6">
    
    <!-- Header -->
    <div class="flex items-center gap-4">
        <div class="w-16 h-16 rounded-full bg-emerald-100 flex items-center justify-center border-4 border-white shadow-sm flex-shrink-0">
            <span class="text-2xl font-bold text-emerald-600">{{ substr(Auth::user()->nama, 0, 1) }}</span>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Pengaturan Akun</h1>
            <p class="text-sm text-gray-500">Kelola informasi profil dan keamanan akun Anda.</p>
        </div>
    </div>

    <!-- Form Ganti Info Dasar -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-bold text-gray-800 mb-4 border-b border-gray-100 pb-2">Informasi Dasar</h2>
        
        <form action="{{ route('teknisi.profile.update.info') }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="nama" value="{{ Auth::user()->nama }}" required
                           class="w-full border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 transition shadow-sm">
                    @error('nama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ Auth::user()->email }}" required
                           class="w-full border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 transition shadow-sm">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Role (Tidak dapat diubah)</label>
                    <span class="inline-flex items-center px-3 py-2 rounded-md text-sm font-medium bg-gray-100 text-gray-600 border border-gray-200 w-full">
                        Teknisi Lapangan
                    </span>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 px-6 rounded-lg shadow-md hover:shadow-lg transition transform active:scale-95 flex items-center gap-2">
                    <i class="fas fa-save"></i> Simpan Profil
                </button>
            </div>
        </form>
    </div>

    <!-- Form Reset Password -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-bold text-gray-800 mb-4 border-b border-gray-100 pb-2">Reset Password</h2>
        <div class="mb-4 p-3 bg-amber-50 text-amber-800 text-sm rounded-lg border border-amber-100 flex items-start gap-2">
            <i class="fas fa-exclamation-triangle mt-0.5"></i>
            <span>Password lama tidak diperlukan. Masukkan password baru Anda langsung di bawah ini.</span>
        </div>
        
        <form action="{{ route('teknisi.profile.update.password') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                    <input type="password" name="password" id="password" required placeholder="Minimal 6 karakter"
                           class="w-full border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 transition shadow-sm">
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required placeholder="Ulangi password baru"
                           class="w-full border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 transition shadow-sm">
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white font-bold py-2.5 px-6 rounded-lg shadow-md hover:shadow-lg transition transform active:scale-95 flex items-center gap-2">
                    <i class="fas fa-key"></i> Atur Ulang Password
                </button>
            </div>
        </form>
    </div>

</div>
@endsection