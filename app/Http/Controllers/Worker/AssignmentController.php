<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use Illuminate\Support\Facades\Auth;

class AssignmentController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Teknisi mengerjakan tugas yang statusnya 'Scheduled' atau 'Progress'
        $assignments = Pendaftaran::with('paket')
            ->where('id_teknisi', $user->id)
            ->whereIn('status', ['Scheduled', 'Progress']) 
            ->orderBy('tanggal_jadwal', 'asc')
            ->get();

        return view('worker.assignment', compact('assignments'));
    }
}