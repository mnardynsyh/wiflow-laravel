<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\PaketLayanan;
use App\Models\User;
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
                // Logika Teknisi
                $pendaftarans = Pendaftaran::with(['paket'])
                    ->where('id_teknisi', $user->id)
                    ->where('status', 'Scheduled') 
                    
                    ->latest()
                    ->get();
            }

            return view('registers.index', compact('pendaftarans'));
        }


    public function store(Request $request)
    {
        // validasi form guest
        $validated = $request->validate([
            'nama_pelanggan'    => 'required|string|max:255',
            'nik_pelanggan'     => 'required|numeric',
            'no_hp'             => 'required|string|max:20',
            'alamat_pemasangan' => 'required|string',
            'koordinat'         => 'nullable|string',
            'id_paket'          => 'required|exists:paket_layanan,id',
        ]);

        // default value
        $validated['status'] = 'Pending';
        $validated['id_teknisi'] = null;
        $validated['tanggal_jadwal'] = null;


        Pendaftaran::create($validated);

        return redirect('/#daftar')->with('success', 'Pendaftaran berhasil dikirim! Tim kami akan segera menghubungi Anda untuk verifikasi.');
    }

    /**
     * Menampilkan detail pendaftaran (Untuk Admin/Teknisi melihat Lokasi/Maps)
     */
    public function show($id)
    {

        $pendaftaran = Pendaftaran::with(['paket', 'teknisi', 'laporanInstalasi'])->findOrFail($id);
        
        return view('registers.show', compact('pendaftaran'));
    }

    /**
     * Form Edit untuk Admin (Proses Verifikasi & Penugasan)
     */
    public function edit($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        
        $teknisi = User::where('role', 'teknisi')->get();

        return view('registers.edit', compact('pendaftaran', 'teknisi'));
    }

    /**
     * Proses Update oleh Admin (Menentukan Teknisi & Jadwal)
     */
    public function update(Request $request, $id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);

        // validasi input admin
        $validated = $request->validate([
            'id_teknisi'     => 'required|exists:users,id',
            'tanggal_jadwal' => 'required|date',
            'status'         => 'required|in:Pending,Verified,Scheduled,Progress,Reported,Completed'    ,
        ]);

        $pendaftaran->update($validated);

        return redirect()->route('pendaftaran.index')->with('success', 'Berhasil menugaskan teknisi dan menjadwalkan pemasangan!');
    }

    /**
     * Menghapus data (Hanya Admin, jika diperlukan)
     */
    public function destroy($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->delete();

        return redirect()->route('register.index')->with('success', 'Data pendaftaran dihapus.');
    }
}