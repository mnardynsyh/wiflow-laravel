<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaketLayanan;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Cek apakah pengguna sudah login?
        if (Auth::check()) {
            $user = Auth::user();

            // 2. Jika iya, lempar ke dashboard sesuai role masing-masing
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } 
            
            if ($user->role === 'teknisi') {
                return redirect()->route('teknisi.dashboard');
            }
        }

        // 3. Jika belum login (Tamu/Guest), baru tampilkan Landing Page
        $pakets = PaketLayanan::where('is_active', true)->get();
        
        return view('landing', compact('pakets'));
    }
}