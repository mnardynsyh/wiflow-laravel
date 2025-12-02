<?php

namespace App\Http\Controllers\Worker;

use App\Models\Pendaftaran;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Menampilkan Dashboard Utama (Statistik)
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // 1. Statistik
        $stats = [
            'hari_ini' => Pendaftaran::where('id_teknisi', $user->id)
                ->where('status', 'dijadwalkan')
                ->whereDate('tanggal_jadwal', today())
                ->count(),
            'total_pending' => Pendaftaran::where('id_teknisi', $user->id)
                ->where('status', 'dijadwalkan')
                ->count(),
            'selesai_bulan_ini' => Pendaftaran::where('id_teknisi', $user->id)
                ->where('status', 'selesai')
                ->whereMonth('updated_at', now()->month)
                ->count(),
        ];

        // 2. Ringkasan Tugas Hari Ini (Hanya preview 5 teratas)
        $todayTasks = Pendaftaran::with('paket')
            ->where('id_teknisi', $user->id)
            ->where('status', 'dijadwalkan')
            ->whereDate('tanggal_jadwal', today())
            ->orderBy('tanggal_jadwal', 'asc')
            ->take(5)
            ->get();

        return view('worker.dashboard', compact('stats', 'todayTasks'));
    }
}