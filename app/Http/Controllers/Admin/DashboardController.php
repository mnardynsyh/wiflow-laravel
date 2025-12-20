<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function adminIndex()
    {
        // 1. STATISTIK UTAMA (OPERASIONAL)
        $totalPendaftar = Pendaftaran::count();
        $totalSelesai   = Pendaftaran::where('status', 'Completed')->count();
        // Pending = Masuk + Terverifikasi (Belum dijadwalkan)
        $totalPending   = Pendaftaran::whereIn('status', ['Pending', 'Verified'])->count();

        // Mengambil teknisi yang status pekerjaannya 'Progress' (Sedang OTW/Pasang)
        $sedangDikerjakan = Pendaftaran::with(['teknisi', 'paket'])
                            ->where('status', 'Progress')
                            ->get();
        // Menghitung berapa job yang dipegang setiap teknisi hari ini
        $bebanTeknisi = User::where('role', 'teknisi')
                        ->withCount(['pendaftaran as jobs_today' => function($query) {
                            $query->whereDate('tanggal_jadwal', Carbon::today());
                        }])
                        ->get();

        // 4. JADWAL HARI INI (Timeline Agenda)
        $jadwalHariIni = Pendaftaran::with(['teknisi', 'paket'])
                         ->whereDate('tanggal_jadwal', Carbon::today())
                         ->orderBy('tanggal_jadwal', 'asc')
                         ->get();

        return view('admin.dashboard', compact(
            'totalPendaftar', 'totalSelesai', 'totalPending',
            'sedangDikerjakan', 'bebanTeknisi', 'jadwalHariIni'
        ));
    }
}