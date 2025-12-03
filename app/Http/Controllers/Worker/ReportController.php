<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Models\LaporanInstalasi;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{

    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Teknisi mengerjakan tugas yang statusnya 'Scheduled' atau 'Progress'
        $assignments = Pendaftaran::with('paket')
            ->where('id_teknisi', $user->id)
            ->whereIn('status', ['Scheduled', 'Progress']) 
            ->orderBy('tanggal_jadwal', 'asc')
            ->get();

        return view('worker.reports.index', compact('assignments'));
    }
    /**
     * Form Input Laporan (Spesifik untuk 1 Pendaftaran)
     */
    public function create($id_pendaftaran)
    {
        $user = Auth::user();

        $pendaftaran = Pendaftaran::where('id', $id_pendaftaran)
            ->where('id_teknisi', $user->id)
            ->firstOrFail();

        return view('worker.reports.create', compact('pendaftaran'));
    }

    /**
     * Proses Simpan Laporan oleh Teknisi
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'id_pendaftaran' => 'required|exists:pendaftaran,id',
            'catatan_teknisi'=> 'nullable|string',
            'bukti_foto'     => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Verifikasi keamanan (Double check)
        $pendaftaran = Pendaftaran::where('id', $request->id_pendaftaran)
            ->where('id_teknisi', $user->id)
            ->firstOrFail();

        $path = null;
        if ($request->hasFile('bukti_foto')) {
            $path = $request->file('bukti_foto')->store('bukti-instalasi', 'public');
        }

        LaporanInstalasi::create([
            'id_pendaftaran' => $pendaftaran->id,
            'id_teknisi'     => $user->id,
            'catatan_teknisi'=> $request->catatan_teknisi,
            'bukti_foto'     => $path,
        ]);

        $pendaftaran->update(['status' => 'Reported']);

        return redirect()->route('teknisi.dashboard')->with('success', 'Laporan terkirim! Tugas selesai.');
    }
}