<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaketLayanan;

class HomeController extends Controller
{
    public function index()
    {
        $pakets = PaketLayanan::where('is_active', true)->get();
        
        return view('home', compact('pakets'));
    }
}