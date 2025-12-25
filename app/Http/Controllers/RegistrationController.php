<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\User;
use App\Models\PaketLayanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Pendaftaran::with(['paket', 'teknisi'])->latest();

        // Filter Search Global
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_pelanggan', 'like', "%{$search}%")
                  ->orWhere('no_hp', 'like', "%{$search}%")
                  ->orWhere('alamat_pemasangan', 'like', "%{$search}%");
            });
        }

        // FILTER STATUS
        if ($user->role === 'admin') {
            if ($request->filled('status') && $request->status !== 'Semua') {
                $query->where('status', $request->status);
            } else {
                $query->where('status', '!=', 'Completed');
            }
        } else {
            $query->where('id_teknisi', $user->id)
                  ->whereIn('status', ['Scheduled', 'Progress']);
        }

        $pendaftarans = $query->paginate(10)->withQueryString();

        return view('admin.registers.index', compact('pendaftarans'));
    }

    public function riwayat(Request $request)
    {
        // Hanya ambil yang statusnya 'Completed'
        $query = Pendaftaran::with(['paket', 'teknisi'])
                    ->where('status', 'Completed')
                    ->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_pelanggan', 'like', "%{$search}%")
                  ->orWhere('no_hp', 'like', "%{$search}%");
            });
        }

        $pelanggan = $query->paginate(15)->withQueryString();

        return view('admin.registers.history', compact('pelanggan'));
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
            'nik_pelanggan'     => 'required|numeric|digits:16',         
            'no_hp'             => 'required|numeric|digits_between:10,15',
            'alamat_pemasangan' => 'required|string',
            'koordinat'         => 'nullable|string', 
            'id_paket'          => 'required|exists:paket_layanan,id',
        ], [
            // Custom Error Message
            'nik_pelanggan.digits' => 'NIK harus berjumlah tepat 16 digit angka.',
            'nik_pelanggan.numeric' => 'NIK hanya boleh berisi angka.',

            'no_hp.numeric'         => 'Nomor HP hanya boleh berisi angka.',
            'no_hp.digits_between'  => 'Nomor HP tidak valid (harus 10-15 digit).',
        ]);

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
        $pakets  = PaketLayanan::all(); 

        return view('admin.registers.edit', compact('pendaftaran', 'teknisi', 'pakets'));
    }

    public function update(Request $request, $id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);

        // 1. VALIDASI MENYELURUH (Customer Data + Dispatch Data)
        $validated = $request->validate([
            // Data Pelanggan
            'nama_pelanggan'    => 'nullable|string|max:255',
            'nik_pelanggan'     => 'nullable|numeric|digits:16',
            'no_hp'             => 'nullable|numeric|digits_between:10,15',
            'alamat_pemasangan' => 'nullable|string',
            'id_paket'          => 'nullable|exists:paket_layanan,id',
            
            // Data Penugasan
            'id_teknisi'        => 'nullable|exists:users,id',
            'tanggal_jadwal'    => 'nullable|date',
        ], [
            'nik_pelanggan.digits' => 'NIK harus berjumlah tepat 16 digit angka.',
            'nik_pelanggan.numeric' => 'NIK hanya boleh berisi angka.',

            'no_hp.numeric'         => 'Nomor HP hanya boleh berisi angka.',
            'no_hp.digits_between'  => 'Nomor HP tidak valid (harus 10-15 digit).',
        ]);

        // 2. LOGIKA OTOMATISASI STATUS
        $currentStatus = $pendaftaran->status;
        
        // Skenario A: Admin melakukan Penugasan (Dispatch)
        // Jika Teknisi & Tanggal Diisi -> Status jadi Scheduled (Terjadwal)
        if ($request->filled('id_teknisi') && $request->filled('tanggal_jadwal')) {
            if (in_array($currentStatus, ['Pending', 'Verified'])) {
                $validated['status'] = 'Scheduled';
            }
        }
        
        // Skenario B: Admin Membatalkan Penugasan (Hapus Teknisi)
        // Jika tadinya Scheduled -> Balik ke Verified
        elseif (empty($request->id_teknisi) && $currentStatus == 'Scheduled') {
            $validated['status'] = 'Verified';
        }

        // Skenario C: Tombol "Selesaikan" (Manual Action)
        if ($request->action == 'complete') {
            $validated['status'] = 'Completed';
        }

        // 3. EKSEKUSI UPDATE DATABASE
        $pendaftaran->update($validated);

        return redirect()->route('pendaftaran.index')
            ->with('success', 'Data pendaftaran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->delete();

        return redirect()->route('pendaftaran.index')->with('success', 'Data pendaftaran dihapus.');
    }
}