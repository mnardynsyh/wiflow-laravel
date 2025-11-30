<?php

namespace App\Http\Controllers\Worker;

use App\Models\Pendaftaran;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class DashboardController extends Controller
{
    /**
     *  Dashboard Teknisi (Daftar Tugas)
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $pendaftarans = Pendaftaran::with('paket')
            ->where('id_teknisi', $user->id)
            ->where('status', 'dijadwalkan')
            ->orderBy('tanggal_jadwal', 'asc')
            ->get();

        return view('worker.dashboard', compact('pendaftarans'));
    }

    /**
     * Halaman Riwayat Pekerjaan (Status: Selesai)
     */
    public function history()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $riwayat = Pendaftaran::with(['paket', 'laporanInstalasi'])
            ->where('id_teknisi', $user->id)
            ->where('status', 'selesai')
            ->latest('updated_at')
            ->get();

        return view('worker.history', compact('riwayat'));
    }

    /**
     * Halaman Profil
     */
    public function profile()
    {
        return view('worker.profile');
    }

    /**
     * Update Info Dasar (Nama & Email)
     */
    public function updateInfo(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'nama'  => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
        ]);

        $user->update($validated);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Ganti Password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Password berhasil direset!');
    }
}