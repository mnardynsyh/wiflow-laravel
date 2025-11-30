<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  mixed ...$roles  Daftar role yang diizinkan (misal: 'admin', 'teknisi')
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Cek apakah role user ada dalam daftar role yang diizinkan
        if (in_array($user->role, $roles)) {
            return $next($request);
        }
        // jika role tidak sesuai, redirect atau tampilkan pesan error
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard')->with('error', 'Anda tidak memiliki akses ke halaman teknisi.');
        } 
        
        if ($user->role === 'teknisi') {
            return redirect()->route('teknisi.dashboard')->with('error', 'Halaman ini khusus Admin.');
        }

        abort(403, 'Akses Ditolak. Anda tidak memiliki izin untuk halaman ini.');
    }
}