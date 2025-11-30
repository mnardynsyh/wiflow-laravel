<?php

namespace App\Http\Controllers\Worker;

use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class DashboardController extends Controller
{
    /**
     * Menampilkan Dashboard Teknisi (Daftar Tugas)
     */
    public function index()
    {
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
        $user = Auth::user();

        // Ambil data yang sudah selesai dikerjakan oleh teknisi ini
        $riwayat = Pendaftaran::with(['paket', 'laporanInstalasi'])
            ->where('id_teknisi', $user->id)
            ->where('status', 'selesai')
            ->latest('updated_at') // Urutkan dari yang baru selesai
            ->get();

        return view('teknisi.history', compact('riwayat'));
    }

    /**
     * Halaman Profil
     */
    public function profile()
    {
        return view('teknisi.profile');
    }

    /**
     * Proses Ganti Password
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        // Cek password lama
        if (!Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => 'Password saat ini salah.',
            ]);
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Password berhasil diperbarui!');
    }
}