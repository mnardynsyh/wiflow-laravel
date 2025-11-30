@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-xl mx-auto bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Edit Plan</h2>

        <form action="{{ route('plans.update', $plan->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Nama Plan</label>
                <input type="text" name="nama_paket" value="{{ old('nama_paket', $plan->nama_paket) }}" class="w-full border-gray-300 rounded-lg shadow-sm border p-2">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Harga</label>
                <input type="number" name="harga" value="{{ old('harga', $plan->harga) }}" class="w-full border-gray-300 rounded-lg shadow-sm border p-2">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi</label>
                <textarea name="deskripsi" rows="3" class="w-full border-gray-300 rounded-lg shadow-sm border p-2">{{ old('deskripsi', $plan->deskripsi) }}</textarea>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                <select name="is_active" class="w-full border-gray-300 rounded-lg shadow-sm border p-2">
                    <option value="1" {{ $plan->is_active == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ $plan->is_active == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="flex justify-end gap-2">
                <a href="{{ route('plans.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded">Batal</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update Plan</button>
            </div>
        </form>
    </div>
</div>
@endsection