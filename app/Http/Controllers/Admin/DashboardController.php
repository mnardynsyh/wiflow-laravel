<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use App\Models\LaporanInstalasi;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{

    public function adminIndex()
    {
        $laporan = LaporanInstalasi::with(['teknisi', 'pendaftaran'])
                    ->latest()
                    ->get();
        
        $jumlahTeknisi = User::where('role', 'teknisi')->count();

        return view('admin.dashboard', compact('laporan', 'jumlahTeknisi'));
    }
}