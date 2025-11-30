@extends('layouts.app')

@section('title', 'Admin Dashboard - WifiNet')

@section('content')
<div class="space-y-6">

  <div class="flex items-center justify-between">
      <div>
          <h2 class="text-2xl font-bold tracking-tight text-gray-900">Dashboard Overview</h2>
          <p class="text-sm text-gray-500">Ringkasan aktivitas dan laporan instalasi terkini.</p>
      </div>
  </div>

  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
    <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-5 flex items-center gap-4 transition hover:shadow-md">
      <div class="w-14 h-14 rounded-xl bg-emerald-50 flex items-center justify-center">
        <i class="fas fa-check text-2xl text-emerald-600"></i>
      </div>
      <div class="flex-1">
        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Total Laporan</p>
        <div class="mt-1 flex items-baseline gap-3">
          <span class="text-2xl font-extrabold text-slate-800">{{ number_format($laporan->count()) }}</span>
          <span class="text-xs text-slate-400">laporan</span>
        </div>
        <p class="mt-2 text-xs text-slate-400">
            Terbaru: {{ $laporan->first()?->created_at->format('d M H:i') ?? '-' }}
        </p>
      </div>
    </div>

    <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-5 flex items-center gap-4 transition hover:shadow-md">
      <div class="w-14 h-14 rounded-xl bg-sky-50 flex items-center justify-center">
        <i class="fas fa-users text-2xl text-sky-600"></i>
      </div>
      <div class="flex-1">
        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Teknisi Terdaftar</p>
        <div class="mt-1 flex items-baseline gap-3">
          <span class="text-2xl font-extrabold text-slate-800">{{ $jumlahTeknisi ?? 0 }}</span>
          <span class="text-xs text-slate-400">orang</span>
        </div>
        <p class="mt-2 text-xs text-slate-400">Siap bertugas</p>
      </div>
    </div>

    <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-5 flex items-center gap-4 transition hover:shadow-md">
      <div class="w-14 h-14 rounded-xl bg-amber-50 flex items-center justify-center">
        <i class="fas fa-server text-2xl text-amber-600"></i>
      </div>
      <div class="flex-1">
        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">System Status</p>
        <div class="mt-1 flex items-baseline gap-3">
          <span class="text-2xl font-extrabold text-emerald-600">Online</span>
          <span class="text-xs text-slate-400">Normal</span>
        </div>
        <p class="mt-2 text-xs text-slate-400">Check: {{ now()->format('H:i') }} WIB</p>
      </div>
    </div>
  </div>

  <div class="bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden">
    <div class="px-6 py-4 flex items-center justify-between bg-slate-50 border-b border-slate-100">
      <div>
        <h3 class="text-sm font-semibold text-slate-800">Laporan Instalasi Terbaru</h3>
        <p class="text-xs text-slate-400 mt-0.5">Daftar laporan pekerjaan teknisi.</p>
      </div>
      {{-- 
      <div class="flex items-center gap-3">
        <a href="{{ route('reports.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-lg shadow hover:bg-indigo-700 transition">
          <i class="fas fa-plus"></i>
          <span>Buat Laporan</span>
        </a>
      </div> 
      --}}
    </div>

    <div class="p-0">
      
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-100">
          <thead class="bg-white">
            <tr class="text-xs text-slate-500 uppercase tracking-wider">
              <th class="px-6 py-3 text-left font-semibold">Tanggal</th>
              <th class="px-6 py-3 text-left font-semibold">Teknisi</th>
              <th class="px-6 py-3 text-left font-semibold">ID Daftar</th>
              <th class="px-6 py-3 text-center font-semibold">Bukti</th>
              <th class="px-6 py-3 text-center font-semibold">Aksi</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-slate-100">
            @forelse($laporan as $item)
            <tr class="hover:bg-slate-50 transition">
              <td class="px-6 py-4 text-sm whitespace-nowrap">
                <div class="font-semibold text-slate-800">{{ $item->created_at->format('d M Y') }}</div>
                <div class="text-xs text-slate-400 mt-0.5">{{ $item->created_at->format('H:i') }} WIB</div>
              </td>

              <td class="px-6 py-4 text-sm whitespace-nowrap">
                <div class="flex items-center gap-3">
                  <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 text-xs font-bold border border-indigo-200">
                    {{ strtoupper(substr($item->teknisi->nama ?? 'U',0,1)) }}
                  </div>
                  <div>
                    <div class="font-medium text-slate-800">{{ $item->teknisi->nama ?? 'User Terhapus' }}</div>
                    <div class="text-xs text-slate-400">Teknisi</div>
                  </div>
                </div>
              </td>

              <td class="px-6 py-4 text-sm whitespace-nowrap">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                  #{{ $item->pendaftaran->id ?? '-' }}
                </span>
              </td>

              <td class="px-6 py-4 text-sm text-center whitespace-nowrap">
                @if($item->bukti_foto)
                  <a href="{{ asset('storage/' . $item->bukti_foto) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md text-xs font-medium bg-gray-100 text-gray-700 hover:bg-gray-200 transition">
                    <i class="fas fa-image"></i> Lihat
                  </a>
                @else
                  <span class="text-xs italic text-slate-400">N/A</span>
                @endif
              </td>

              <td class="px-6 py-4 text-sm text-center whitespace-nowrap">
                <div class="flex items-center justify-center gap-2">
                  <a href="{{ route('reports.edit', $item->id) }}" class="text-amber-500 hover:text-amber-600 transition" title="Edit">
                    <i class="fas fa-pencil-alt"></i>
                  </a>

                  <form action="{{ route('reports.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus laporan ini permanen?');" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-400 hover:text-red-600 transition" title="Hapus">
                      <i class="fas fa-trash-alt"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="5" class="px-6 py-12 text-center">
                <div class="flex flex-col items-center justify-center">
                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-3">
                        <i class="fas fa-folder-open text-gray-300 text-2xl"></i>
                    </div>
                    <p class="text-slate-500 font-medium">Belum ada laporan instalasi.</p>
                    <p class="text-slate-400 text-xs mt-1">Laporan teknisi akan muncul di sini setelah diupload.</p>
                </div>
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection