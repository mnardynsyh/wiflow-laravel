<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

        // Hash password sebelum simpan
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
            // Ignore id user ini saat cek unique email
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
        ];

        // Jika password diisi, validasi panjangnya
        if ($request->filled('password')) {
            $rules['password'] = 'min:6';
        }

        $validatedData = $request->validate($rules);

        // Jika password diisi, hash password baru
        if ($request->filled('password')) {
            $validatedData['password'] = Hash::make($request->password);
        } else {
            // Jika kosong, hapus key password agar tidak menimpa password lama dengan null/kosong
            unset($validatedData['password']);
        }

        $user->update($validatedData);

        return redirect()->route('users.index')->with('success', 'Data user berhasil diperbarui!');
    }

    /**
     * Hapus user
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        
        // Opsional: Cegah user menghapus dirinya sendiri
        if (Auth::id() == $user->id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus!');
    }
}