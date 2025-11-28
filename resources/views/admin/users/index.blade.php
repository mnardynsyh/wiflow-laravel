@extends('layouts.app')

@section('title', 'Daftar User')
@section('header', 'Manajemen User')

@section('content')
    
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-gray-700 text-lg font-semibold">Data Pengguna</h3>
        <a href="{{ route('users.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition transform hover:scale-105">
            <i class="fas fa-plus mr-2"></i> Tambah User
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded shadow-sm" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
        <table class="min-w-full leading-normal">
            <thead>
                <tr class="bg-gray-50 text-gray-600 text-xs uppercase font-bold tracking-wider">
                    <th class="px-6 py-4 text-left">Nama</th>
                    <th class="px-6 py-4 text-left">Email</th>
                    <th class="px-6 py-4 text-center">Role</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($users as $user)
                <tr class="hover:bg-blue-50 transition duration-150">
                    <td class="px-6 py-4 whitespace-no-wrap font-medium text-gray-900">{{ $user->nama }}</td>
                    <td class="px-6 py-4 whitespace-no-wrap text-gray-600">{{ $user->email }}</td>
                    <td class="px-6 py-4 whitespace-no-wrap text-center">
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->role == 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-no-wrap text-center text-sm">
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 mx-2 transition" onclick="return confirm('Hapus user ini?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        <a href="{{ route('users.edit', $user->id) }}" class="text-blue-500 hover:text-blue-700 mx-2 transition">
                            <i class="fas fa-edit"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-5 py-5 bg-white border-t flex flex-col xs:flex-row items-center xs:justify-between">
            {{ $users->links() }}
        </div>
    </div>

@endsection