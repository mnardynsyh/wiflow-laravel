<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\User;
use App\Models\PaketLayanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $pendaftarans = Pendaftaran::with(['paket', 'teknisi'])->latest()->get();
        } else {
            $pendaftarans = Pendaftaran::with(['paket'])
                ->where('id_teknisi', $user->id)
                ->whereIn('status', ['Scheduled', 'Progress'])
                ->latest()
                ->get();
        }

        return view('admin.registers.index', compact('pendaftarans'));
    }

    public function success($id)
    {
        // Cari data berdasarkan ID
        $pendaftaran = Pendaftaran::with('paket')->findOrFail($id);
        
        return view('public.success', compact('pendaftaran'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pelanggan'    => 'required|string|max:255',
            'nik_pelanggan'     => 'required|numeric',
            'no_hp'             => 'required|string|max:20',
            'alamat_pemasangan' => 'required|string',
            'koordinat'         => 'nullable|string', 
            'id_paket'          => 'required|exists:paket_layanan,id',
        ]);

        // Default status sesuai Enum Database
        $validated['status'] = 'Pending'; 
        $validated['id_teknisi'] = null;  
        $validated['tanggal_jadwal'] = null;

        $pendaftaran = Pendaftaran::create($validated);

        return redirect()->route('pendaftaran.sukses', $pendaftaran->id);
    }

    public function show($id)
    {
        $pendaftaran = Pendaftaran::with(['paket', 'teknisi', 'laporanInstalasi'])->findOrFail($id);
        return view('admin.registers.show', compact('pendaftaran'));
    }

    public function edit($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        $teknisi = User::where('role', 'teknisi')->get(); 

        return view('admin.registers.edit', compact('pendaftaran', 'teknisi'));
    }

    public function update(Request $request, $id)
{
    $pendaftaran = Pendaftaran::findOrFail($id);

    $validated = $request->validate([
        'id_teknisi'     => 'nullable|exists:users,id',
        'tanggal_jadwal' => 'nullable|date',
    ]);

    // 2. LOGIKA OTOMATISASI STATUS
    $newStatus = $pendaftaran->status;

    // Skenario A: Admin menugaskan Teknisi & Jadwal
    if ($request->filled('id_teknisi') && $request->filled('tanggal_jadwal')) {
        if (in_array($pendaftaran->status, ['Pending', 'Verified'])) {
            $newStatus = 'Scheduled';
        }
    }
    
    // Skenario B: Admin membatalkan tugas (kosongkan teknisi)
    elseif (empty($request->id_teknisi) && $pendaftaran->status == 'Scheduled') {
        $newStatus = 'Verified';
    }

    // Skenario C: Admin melakukan finalisasi (Completed)
    if ($request->has('action') && $request->action == 'complete') {
        $newStatus = 'Completed';
    }

    // 3. Gabungkan data
    $validated['status'] = $newStatus;

    // Update Data
    $pendaftaran->update($validated);

    return redirect()->route('pendaftaran.index')
        ->with('success', "Data diperbarui! Status sekarang: $newStatus");
}

    public function destroy($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->delete();

        return redirect()->route('pendaftaran.index')->with('success', 'Data pendaftaran dihapus.');
    }
}