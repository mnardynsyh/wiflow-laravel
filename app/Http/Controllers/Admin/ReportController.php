<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use App\Models\LaporanInstalasi;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    /**
     * ADMIN: Lihat Daftar Laporan
     */
    public function index()
    {
        $laporan = LaporanInstalasi::with(['pendaftaran', 'teknisi'])->latest()->get();
        return view('admin.reports.index', compact('laporan'));
    }

    /**
     * ADMIN: Buat Laporan Manual (Opsional/Backup)
     */
    public function create()
    {
        $pendaftaran = Pendaftaran::where('status', 'pending')->get();
        $teknisi = User::where('role', 'teknisi')->get();
        
        return view('admin.reports.create', compact('pendaftaran', 'teknisi'));
    }

    /**
     * ADMIN: Simpan Laporan Manual
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_pendaftaran' => 'required|exists:pendaftaran,id',
            'id_teknisi'     => 'required|exists:users,id',
            'catatan_teknisi'=> 'nullable|string',
            'bukti_foto'     => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('bukti_foto')) {
            $path = $request->file('bukti_foto')->store('bukti-instalasi', 'public');
            $validatedData['bukti_foto'] = $path;
        }

        LaporanInstalasi::create($validatedData);

        // Update status pendaftaran
        $pendaftaran = Pendaftaran::findOrFail($request->id_pendaftaran);
        
        // FIX BUG: Ganti 'selesai' jadi 'Completed' sesuai Enum database
        $pendaftaran->update(['status' => 'Completed']); 

        return redirect()->route('reports.index')->with('success', 'Laporan dibuat & Status diselesaikan (Completed)!');
    }
    
    public function show(string $id)
    {
        $laporan = LaporanInstalasi::with(['pendaftaran', 'teknisi'])->findOrFail($id);
        return view('admin.reports.show', compact('laporan'));
    }

    public function edit(string $id)
    {
        $laporan = LaporanInstalasi::findOrFail($id);
        $pendaftaran = Pendaftaran::all();
        $teknisi = User::all(); // Admin bisa pilih user mana saja

        return view('admin.reports.edit', compact('laporan', 'pendaftaran', 'teknisi'));
    }

    public function update(Request $request, string $id)
    {
        $laporan = LaporanInstalasi::findOrFail($id);
        
        $validatedData = $request->validate([
            'id_pendaftaran' => 'required|exists:pendaftaran,id',
            'id_teknisi'     => 'required|exists:users,id',
            'catatan_teknisi'=> 'nullable|string',
            'bukti_foto'     => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('bukti_foto')) {
            if ($laporan->bukti_foto) Storage::disk('public')->delete($laporan->bukti_foto);
            $path = $request->file('bukti_foto')->store('bukti-instalasi', 'public');
            $validatedData['bukti_foto'] = $path;
        }
        
        $laporan->update($validatedData);
        return redirect()->route('reports.index')->with('success', 'Laporan berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $laporan = LaporanInstalasi::findOrFail($id);
        if ($laporan->bukti_foto) Storage::disk('public')->delete($laporan->bukti_foto);
        $laporan->delete();
        
        return redirect()->route('reports.index')->with('success', 'Laporan berhasil dihapus!');
    }

    public function approve($id)
    {
        $laporan = LaporanInstalasi::findOrFail($id);
        
        // Akses data pendaftaran terkait
        $pendaftaran = $laporan->pendaftaran;

        if ($pendaftaran->status == 'Completed') {
            return back()->with('info', 'Laporan ini sudah diverifikasi sebelumnya.');
        }

        // Update Status Jadi Completed
        $pendaftaran->update(['status' => 'Completed']);

        return back()->with('success', 'Laporan berhasil diverifikasi! Pekerjaan dinyatakan SELESAI.');
    }
}