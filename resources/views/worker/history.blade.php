@extends('layouts.worker')

@section('title', 'Riwayat Pekerjaan')

@section('content')
<div class="space-y-6">
    
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900">Riwayat Pekerjaan</h1>
            <p class="text-sm text-gray-500">Daftar instalasi yang telah Anda selesaikan.</p>
        </div>
        <div class="bg-emerald-50 text-emerald-700 px-4 py-2 rounded-lg text-sm font-bold border border-emerald-100">
            Total Selesai: {{ $riwayat->count() }}
        </div>
    </div>

    @if($riwayat->isEmpty())
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-10 text-center">
            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-history text-gray-400 text-3xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-800">Belum ada riwayat</h3>
            <p class="text-gray-500 text-sm mt-1">Anda belum menyelesaikan tugas instalasi apapun.</p>
        </div>
    @else
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100">
                    <thead class="bg-slate-50">
                        <tr class="text-xs text-slate-500 uppercase tracking-wider">
                            <th class="px-6 py-3 text-left font-semibold">Tanggal Selesai</th>
                            <th class="px-6 py-3 text-left font-semibold">Pelanggan</th>
                            <th class="px-6 py-3 text-left font-semibold">Paket</th>
                            <th class="px-6 py-3 text-left font-semibold">Alamat</th>
                            <th class="px-6 py-3 text-center font-semibold">Laporan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @foreach($riwayat as $job)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-slate-900">
                                    {{-- Mengambil tanggal dari laporan instalasi jika ada, atau updated_at pendaftaran --}}
                                    {{ $job->laporanInstalasi ? $job->laporanInstalasi->created_at->format('d M Y') : $job->updated_at->format('d M Y') }}
                                </div>
                                <div class="text-xs text-slate-500">
                                    {{ $job->laporanInstalasi ? $job->laporanInstalasi->created_at->format('H:i') : $job->updated_at->format('H:i') }} WIB
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-slate-900">{{ $job->nama_pelanggan }}</div>
                                <div class="text-xs text-slate-500">NIK: {{ $job->nik_pelanggan }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="bg-blue-100 text-blue-700 text-xs px-2.5 py-1 rounded-full font-bold">
                                    {{ $job->paket->nama_paket ?? '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-slate-600 line-clamp-1 max-w-xs" title="{{ $job->alamat_pemasangan }}">
                                    {{ $job->alamat_pemasangan }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($job->laporanInstalasi && $job->laporanInstalasi->bukti_foto)
                                    <a href="{{ asset('storage/' . $job->laporanInstalasi->bukti_foto) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium inline-flex items-center gap-1">
                                        <i class="fas fa-image"></i> Lihat Bukti
                                    </a>
                                @else
                                    <span class="text-xs text-slate-400 italic">Tidak ada foto</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            {{-- Pagination jika data banyak --}}
            <div class="px-6 py-4 border-t border-slate-100">
                {{-- $riwayat->links() --}}
            </div>
        </div>
    @endif
</div>
@endsection