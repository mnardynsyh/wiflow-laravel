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
            'hari_ini' => Pendaftaran::where('id_teknisi', $user->id)
                ->whereIn('status', ['Scheduled', 'Progress']) 
                ->whereDate('tanggal_jadwal', now())
                ->count(),
            
            'total_pending' => Pendaftaran::where('id_teknisi', $user->id)
                ->whereIn('status', ['Scheduled', 'Progress'])
                ->count(),
            
            'selesai_bulan_ini' => Pendaftaran::where('id_teknisi', $user->id)
                ->whereIn('status', ['Reported', 'Completed'])
                ->whereMonth('updated_at', now()->month)
                ->count(),
        ];

        // 2. Ringkasan Tugas Hari Ini
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

        $riwayat = Pendaftaran::with(['paket', 'laporanInstalasi'])
            ->where('id_teknisi', $user->id)
            ->whereIn('status', ['Reported', 'Completed'])
            ->latest('updated_at')
            ->get();

        return view('worker.history', compact('riwayat'));
    }
}