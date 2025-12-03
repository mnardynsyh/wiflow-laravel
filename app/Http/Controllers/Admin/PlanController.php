<?php

namespace App\Http\Controllers\Admin;

use App\Models\PaketLayanan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlanController extends Controller
{
    public function index()
    {
        $plans = PaketLayanan::latest()->get();
        return view('admin.plans.index', compact('plans'));
    }

    public function create()
    {
        return view('admin.plans.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_paket' => 'required|string|max:255',
            'harga'      => 'required|numeric|min:0',
            'deskripsi'  => 'nullable|string',
            'is_active'  => 'required|boolean',
        ]);

        PaketLayanan::create($validated);

        return redirect()->route('plans.index')->with('success', 'Plan baru berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $plan = PaketLayanan::findOrFail($id);
        return view('admin.plans.edit', compact('plan'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_paket' => 'required|string|max:255',
            'harga'      => 'required|numeric|min:0',
            'deskripsi'  => 'nullable|string',
            'is_active'  => 'required|boolean',
        ]);

        $plan = PaketLayanan::findOrFail($id);
        $plan->update($validated);

        return redirect()->route('plans.index')->with('success', 'Plan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $plan = PaketLayanan::findOrFail($id);
        $plan->delete();

        return redirect()->route('plans.index')->with('success', 'Plan berhasil dihapus!');
    }
}