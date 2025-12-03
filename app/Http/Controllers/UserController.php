<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pendaftaran; // Import Model
use App\Models\LaporanInstalasi; // Import Model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Menampilkan daftar user
     */
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Halaman tambah user baru
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Proses simpan user baru
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role'     => 'required|in:admin,teknisi',
        ]);

        $validatedData['password'] = Hash::make($request->password);

        User::create($validatedData);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan!');
    }

    /**
     * Halaman edit user
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Proses update data user
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $rules = [
            'nama'  => 'required|string|max:255',
            'role'  => 'required|in:admin,teknisi',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'min:6';
        }

        $validatedData = $request->validate($rules);

        if ($request->filled('password')) {
            $validatedData['password'] = Hash::make($request->password);
        } else {
            unset($validatedData['password']);
        }

        $user->update($validatedData);

        return redirect()->route('users.index')->with('success', 'Data user berhasil diperbarui!');
    }

    /**
     * Hapus user dengan Pengecekan Relasi
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        
        // 1. Cegah hapus diri sendiri
        if (Auth::id() == $user->id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        // 2. CEK RELASI: Apakah teknisi ini punya riwayat Pendaftaran?
        $hasPendaftaran = Pendaftaran::where('id_teknisi', $user->id)->exists();
        
        // 3. CEK RELASI: Apakah teknisi ini punya riwayat Laporan?
        $hasLaporan = LaporanInstalasi::where('id_teknisi', $user->id)->exists();

        if ($hasPendaftaran || $hasLaporan) {
            return back()->with('error', 'Gagal hapus! User ini memiliki riwayat pekerjaan (Pendaftaran/Laporan). Data historis tidak boleh hilang.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus!');
    }
}