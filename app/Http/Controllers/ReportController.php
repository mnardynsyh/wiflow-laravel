<?php

namespace App\Http\Controllers;

use App\Models\LaporanInstalasi;
use App\Models\Pendaftaran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * Menampilkan daftar laporan
     */
    public function index()
    {
        $laporan = LaporanInstalasi::with(['pendaftaran', 'teknisi'])->latest()->get();
        return view('admin.reports.index', compact('laporan'));
    }

    /**
     * Form Buat Laporan
     */
    public function create(Request $request)
    {
        $pendaftaran = Pendaftaran::where('status', 'dijadwalkan')->get();
        $teknisi = User::where('role', 'teknisi')->get();
        
        // Cek jika ada parameter id_pendaftaran (dari tombol 'Upload Laporan' dashboard teknisi)
        $pendaftaranSelected = null;
        if ($request->has('id_pendaftaran')) {
            $pendaftaranSelected = Pendaftaran::find($request->id_pendaftaran);
        }

        return view('admin.reports.create', compact('pendaftaran', 'teknisi', 'pendaftaranSelected'));
    }

    /**
     * Simpan Laporan Baru
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

        // Simpan Laporan
        LaporanInstalasi::create($validatedData);

        $pendaftaran = Pendaftaran::findOrFail($request->id_pendaftaran);
        $pendaftaran->update(['status' => 'selesai']);

        if (Auth::user()->role == 'teknisi') {
            return redirect()->route('teknisi.dashboard')->with('success', 'Laporan berhasil dikirim, tugas selesai!');
        }

        return redirect()->route('reports.index')->with('success', 'Laporan berhasil dibuat!');
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
        $teknisi = User::where('role', 'teknisi')->get();

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
            if ($laporan->bukti_foto) {
                Storage::disk('public')->delete($laporan->bukti_foto);
            }
            $path = $request->file('bukti_foto')->store('bukti-instalasi', 'public');
            $validatedData['bukti_foto'] = $path;
        }
        
        $laporan->update($validatedData);
        return redirect()->route('reports.index')->with('success', 'Laporan berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $laporan = LaporanInstalasi::findOrFail($id);

        if ($laporan->bukti_foto) {
            Storage::disk('public')->delete($laporan->bukti_foto);
        }

        $laporan->pendaftaran->update(['status' => 'dijadwalkan']);

        $laporan->delete();

        return redirect()->route('reports.index')->with('success', 'Laporan berhasil dihapus!');
    }
}