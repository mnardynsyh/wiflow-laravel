<?php

namespace App\Http\Controllers\Worker;

use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Menampilkan Dashboard Utama (Statistik & Tugas Hari Ini)
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // 1. Statistik
        $stats = [
            // Fix: Gunakan status 'Scheduled' atau 'Progress' sesuai Enum database
            'hari_ini' => Pendaftaran::where('id_teknisi', $user->id)
                ->whereIn('status', ['Scheduled', 'Progress']) 
                ->whereDate('tanggal_jadwal', now()) // Cek tanggal hari ini
                ->count(),
            
            'total_pending' => Pendaftaran::where('id_teknisi', $user->id)
                ->whereIn('status', ['Scheduled', 'Progress'])
                ->count(),
            
            // Selesai = Reported (sudah lapor) atau Completed (sudah ACC admin)
            'selesai_bulan_ini' => Pendaftaran::where('id_teknisi', $user->id)
                ->whereIn('status', ['Reported', 'Completed'])
                ->whereMonth('updated_at', now()->month)
                ->count(),
        ];

        // 2. Ringkasan Tugas Hari Ini (Hanya preview 5 teratas)
        $todayTasks = Pendaftaran::with('paket')
            ->where('id_teknisi', $user->id)
            ->whereIn('status', ['Scheduled', 'Progress']) // Fix status
            ->whereDate('tanggal_jadwal', now())
            ->orderBy('tanggal_jadwal', 'asc')
            ->take(5)
            ->get();

        return view('worker.dashboard', compact('stats', 'todayTasks'));
    }

    /**
     * Menampilkan Riwayat Pekerjaan
     */
    public function history()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Ambil data yang statusnya sudah Reported atau Completed
        $riwayat = Pendaftaran::with(['paket', 'laporanInstalasi'])
            ->where('id_teknisi', $user->id)
            ->whereIn('status', ['Reported', 'Completed'])
            ->latest('updated_at')
            ->get();

        return view('worker.history', compact('riwayat'));
    }
}