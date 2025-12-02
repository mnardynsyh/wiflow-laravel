<div class="bg-white rounded-xl shadow-sm border {{ $priority ? 'border-blue-200 ring-1 ring-blue-100' : 'border-slate-200' }} overflow-hidden hover:shadow-md transition group flex flex-col h-full relative">
    
    {{-- Status Strip (Visual Indicator) --}}
    <div class="absolute left-0 top-0 bottom-0 w-1 {{ $priority ? 'bg-blue-500' : 'bg-slate-300' }}"></div>

    {{-- Header Card --}}
    <div class="px-5 py-4 border-b border-slate-100 flex justify-between items-start {{ $priority ? 'bg-blue-50/30' : 'bg-white' }}">
        <div>
            <div class="flex items-center gap-2 text-slate-800 font-bold">
                <i class="far fa-clock {{ $priority ? 'text-blue-600' : 'text-slate-400' }}"></i>
                {{ \Carbon\Carbon::parse($job->tanggal_jadwal)->format('H:i') }} WIB
            </div>
            <div class="text-xs text-slate-500 mt-1">
                {{ \Carbon\Carbon::parse($job->tanggal_jadwal)->translatedFormat('l, d F Y') }}
            </div>
        </div>
        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-100">
            {{ $job->paket->nama_paket ?? 'Paket ?' }}
        </span>
    </div>

    {{-- Body Card --}}
    <div class="p-5 flex-1 flex flex-col">
        <div class="mb-4">
            <h3 class="text-lg font-bold text-gray-900 line-clamp-1" title="{{ $job->nama_pelanggan }}">
                {{ $job->nama_pelanggan }}
            </h3>
            <div class="mt-2 flex items-start gap-2 text-sm text-gray-600">
                <i class="fas fa-map-marker-alt text-red-500 mt-1 flex-shrink-0"></i> 
                <p class="line-clamp-2 leading-relaxed">{{ $job->alamat_pemasangan }}</p>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="mt-auto space-y-3">
            <div class="flex gap-2">
                {{-- Tombol Chat WA --}}
                <a href="https://wa.me/{{ preg_replace('/^0/', '62', $job->no_hp) }}" target="_blank" class="flex-1 bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200 py-2 rounded-lg text-sm font-semibold flex items-center justify-center gap-2 transition">
                    <i class="fab fa-whatsapp text-lg"></i> Chat
                </a>
                
                {{-- Tombol Maps --}}
                @if($job->koordinat)
                <a href="https://www.google.com/maps/search/?api=1&query={{ $job->koordinat }}" target="_blank" class="flex-1 bg-blue-50 text-blue-700 hover:bg-blue-100 border border-blue-200 py-2 rounded-lg text-sm font-semibold flex items-center justify-center gap-2 transition">
                    <i class="fas fa-location-arrow"></i> Rute
                </a>
                @else
                <button disabled class="flex-1 bg-gray-100 text-gray-400 border border-gray-200 py-2 rounded-lg text-sm font-semibold cursor-not-allowed flex items-center justify-center gap-2">
                    <i class="fas fa-map-slash"></i> No Map
                </button>
                @endif
            </div>

            {{-- Tombol Lapor --}}
            <a href="{{ route('teknisi.laporan.create', $job->id) }}" class="flex items-center justify-center gap-2 w-full {{ $priority ? 'bg-blue-600 hover:bg-blue-700 shadow-blue-500/30' : 'bg-slate-700 hover:bg-slate-800' }} text-white px-4 py-3 rounded-xl font-bold shadow-md transition transform active:scale-95">
                <i class="fas fa-camera"></i>
                Selesaikan & Lapor
            </a>
        </div>
    </div>
</div>