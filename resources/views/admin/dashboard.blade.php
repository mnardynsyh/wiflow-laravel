@extends('layouts.app')

@section('title', 'Admin Dashboard - Wiflow')
@section('header', 'Dashboard Overview')

@section('content')
<div class="space-y-6">

  <!-- KPI Cards -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
    <!-- Card: Total Laporan -->
    <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-5 flex items-center gap-4">
      <div class="w-14 h-14 rounded-xl bg-emerald-50 flex items-center justify-center">
        <i class="fas fa-check text-2xl text-emerald-600"></i>
      </div>
      <div class="flex-1">
        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Total Laporan</p>
        <div class="mt-1 flex items-baseline gap-3">
          <span class="text-2xl font-extrabold text-slate-800">{{ number_format($laporan->count()) }}</span>
          <span class="text-xs text-slate-400">laporan</span>
        </div>
        <p class="mt-2 text-xs text-slate-400">Update terakhir: {{ $laporan->max('created_at')?->format('d M Y H:i') ?? '-' }}</p>
      </div>
    </div>

    <!-- Card: Teknisi Aktif -->
    <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-5 flex items-center gap-4">
      <div class="w-14 h-14 rounded-xl bg-sky-50 flex items-center justify-center">
        <i class="fas fa-users text-2xl text-sky-600"></i>
      </div>
      <div class="flex-1">
        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Teknisi Aktif</p>
        <div class="mt-1 flex items-baseline gap-3">
          <span class="text-2xl font-extrabold text-slate-800">5</span>
          <span class="text-xs text-slate-400">orang</span>
        </div>
        <p class="mt-2 text-xs text-slate-400">Terakhir diperbarui: --</p>
      </div>
    </div>

    <!-- Card: Server Status -->
    <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-5 flex items-center gap-4">
      <div class="w-14 h-14 rounded-xl bg-amber-50 flex items-center justify-center">
        <i class="fas fa-server text-2xl text-amber-600"></i>
      </div>
      <div class="flex-1">
        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Server Status</p>
        <div class="mt-1 flex items-baseline gap-3">
          <span class="text-2xl font-extrabold text-slate-800">Online</span>
          <span class="text-xs text-slate-400">semua layanan</span>
        </div>
        <p class="mt-2 text-xs text-slate-400">Waktu pengecekan: {{ now()->format('d M Y H:i') }} WIB</p>
      </div>
    </div>
  </div>

  <!-- Laporan Table Card -->
  <div class="bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden">
    <div class="px-6 py-4 flex items-center justify-between bg-slate-50 border-b border-slate-100">
      <div>
        <h3 class="text-sm font-semibold text-slate-800">Laporan Instalasi Terbaru</h3>
        <p class="text-xs text-slate-400 mt-0.5">Daftar laporan terbaru dan tindakan cepat.</p>
      </div>
      <div class="flex items-center gap-3">
        <a href="{{ route('reports.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-lg shadow hover:bg-indigo-700 transition">
          <i class="fas fa-plus"></i>
          <span>Buat Laporan</span>
        </a>
      </div>
    </div>

    <div class="p-6">
      @if(session('success'))
        <div class="mb-4 rounded-lg bg-emerald-50 border-l-4 border-emerald-500 p-4 text-emerald-700">
          <strong>Berhasil!</strong> {{ session('success') }}
        </div>
      @endif

      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-100">
          <thead class="bg-white">
            <tr class="text-xs text-slate-500 uppercase tracking-wider">
              <th class="px-4 py-3 text-left">Tanggal</th>
              <th class="px-4 py-3 text-left">Teknisi</th>
              <th class="px-4 py-3 text-left">ID Pendaftaran</th>
              <th class="px-4 py-3 text-center">Bukti Foto</th>
              <th class="px-4 py-3 text-center">Aksi</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-slate-100">
            @forelse($laporan as $item)
            <tr class="hover:bg-slate-50 transition">
              <td class="px-4 py-4 text-sm">
                <div class="font-semibold text-slate-800">{{ $item->created_at->format('d M Y') }}</div>
                <div class="text-xs text-slate-400 mt-0.5">{{ $item->created_at->format('H:i') }} WIB</div>
              </td>

              <td class="px-4 py-4 text-sm">
                <div class="flex items-center gap-3">
                  <div class="w-9 h-9 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 text-sm font-medium">
                    {{ strtoupper(substr($item->teknisi->nama ?? 'U',0,1)) }}
                  </div>
                  <div>
                    <div class="font-medium text-slate-800">{{ $item->teknisi->nama ?? 'User Terhapus' }}</div>
                    <div class="text-xs text-slate-400">{{ $item->teknisi->email ?? '' }}</div>
                  </div>
                </div>
              </td>

              <td class="px-4 py-4 text-sm">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-sky-50 text-sky-700">
                  #{{ $item->pendaftaran->id ?? '-' }}
                </span>
              </td>

              <td class="px-4 py-4 text-sm text-center">
                @if($item->bukti_foto)
                  <a href="{{ asset('storage/' . $item->bukti_foto) }}" target="_blank" class="inline-flex items-center gap-2 text-sm font-semibold text-indigo-600 hover:text-indigo-700">
                    <i class="fas fa-image"></i>
                    <span>Lihat</span>
                  </a>
                @else
                  <span class="text-xs italic text-slate-400">Tidak ada</span>
                @endif
              </td>

              <td class="px-4 py-4 text-sm text-center">
                <div class="inline-flex items-center gap-2">
                  <a href="{{ route('reports.edit', $item->id) }}" class="inline-flex items-center justify-center w-9 h-9 rounded-lg border border-amber-300 bg-amber-400/10 text-amber-600 hover:bg-amber-50" title="Edit">
                    <i class="fas fa-edit text-sm"></i>
                  </a>

                  <form action="{{ route('reports.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus laporan ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center justify-center w-9 h-9 rounded-lg border border-red-200 bg-red-500/10 text-red-600 hover:bg-red-50" title="Hapus">
                      <i class="fas fa-trash text-sm"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="5" class="px-4 py-8 text-center text-sm text-slate-500 italic">
                Belum ada data laporan yang tersedia.
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
