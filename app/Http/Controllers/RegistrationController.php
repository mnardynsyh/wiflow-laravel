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
            // Fallback untuk teknisi jika akses route ini
            $pendaftarans = Pendaftaran::with(['paket'])
                ->where('id_teknisi', $user->id)
                ->whereIn('status', ['Scheduled', 'Progress']) // Teknisi melihat yg dijadwalkan/proses
                ->latest()
                ->get();
        }

        return view('admin.registers.index', compact('pendaftarans'));
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

        Pendaftaran::create($validated);

        return redirect('/#daftar')->with('success', 'Pendaftaran berhasil dikirim! Tim kami akan segera menghubungi Anda.');
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

        // Validasi Sesuai Enum Database (Case Sensitive)
        $validated = $request->validate([
            'id_teknisi'     => 'nullable|exists:users,id', 
            'tanggal_jadwal' => 'nullable|date',            
            'status'         => 'required|in:Pending,Verified,Scheduled,Progress,Reported,Completed', 
        ]);

        $pendaftaran->update($validated);

        return redirect()->route('pendaftaran.index')->with('success', 'Status pendaftaran berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->delete();

        return redirect()->route('pendaftaran.index')->with('success', 'Data pendaftaran dihapus.');
    }
}