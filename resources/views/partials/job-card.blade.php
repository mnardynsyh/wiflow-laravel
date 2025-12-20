<div class="bg-white rounded-xl shadow-sm border {{ $priority ? 'border-blue-200 ring-1 ring-blue-50' : 'border-slate-200' }} hover:shadow-md transition duration-200 p-4 group">
    <div class="flex flex-col md:flex-row md:items-center gap-4">
        
        {{-- Kolom 1: Waktu & Indikator --}}
        <div class="flex items-center gap-4 md:w-48 shrink-0">
            {{-- Status Strip --}}
            <div class="w-1.5 h-12 rounded-full {{ $priority ? 'bg-blue-500' : 'bg-slate-300' }}"></div>
            
            <div>
                <div class="flex items-center gap-2 text-slate-800 font-bold text-lg leading-none">
                    <i class="far fa-clock {{ $priority ? 'text-blue-600' : 'text-slate-400' }} text-base"></i>
                    {{ \Carbon\Carbon::parse($job->tanggal_jadwal)->format('H:i') }}
                </div>
                <div class="text-xs text-slate-500 font-medium mt-1">
                    {{ \Carbon\Carbon::parse($job->tanggal_jadwal)->translatedFormat('l, d F') }}
                </div>
            </div>
        </div>

        {{-- Kolom 2: Informasi Pelanggan --}}
        <div class="flex-1 min-w-0 border-t md:border-t-0 md:border-l border-slate-100 pt-3 md:pt-0 md:pl-4">
            <div class="flex items-center gap-2 mb-1">
                <h3 class="text-base font-bold text-gray-900 truncate">{{ $job->nama_pelanggan }}</h3>
                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-100 shrink-0">
                    {{ $job->paket->nama_paket ?? 'Unknown' }}
                </span>
            </div>
            <div class="flex items-start gap-1.5 text-sm text-gray-500">
                <i class="fas fa-map-marker-alt text-red-500 mt-0.5 shrink-0"></i> 
                <p class="truncate">{{ $job->alamat_pemasangan }}</p>
            </div>
        </div>

        {{-- Kolom 3: Aksi --}}
        <div class="flex items-center justify-end gap-2 mt-2 md:mt-0 pt-3 md:pt-0 border-t md:border-t-0 border-slate-100 w-full md:w-auto">
            
            {{-- Tombol WA (Tetap Ada) --}}
            <a href="https://wa.me/{{ preg_replace('/^0/', '62', $job->no_hp) }}" target="_blank" 
               class="w-10 h-10 flex items-center justify-center rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-100 hover:scale-105 transition border border-emerald-100" 
               title="Chat WhatsApp">
                <i class="fab fa-whatsapp text-xl"></i>
            </a>

            {{-- Tombol Maps (Tetap Ada) --}}
            @if($job->koordinat)
            <a href="https://www.google.com/maps/search/?api=1&query={{ $job->koordinat }}" target="_blank" 
               class="w-10 h-10 flex items-center justify-center rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 hover:scale-105 transition border border-blue-100" 
               title="Buka Maps">
                <i class="fas fa-location-arrow text-xl"></i>
            </a>
            @else
            <button disabled class="w-10 h-10 flex items-center justify-center rounded-lg bg-slate-100 text-slate-400 cursor-not-allowed">
                <i class="fas fa-map-slash"></i>
            </button>
            @endif

            {{-- LOGIKA TOMBOL DINAMIS (UPDATED) --}}
            <div class="ml-2 flex-1 md:flex-none">
                
                @if($job->status == 'Scheduled')
                    {{-- Opsi 1: Tombol MULAI KERJAKAN --}}
                    <form action="{{ route('teknisi.job.start', $job->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" 
                           class="w-full inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-slate-800 hover:bg-slate-900 text-white text-sm font-bold rounded-lg shadow-sm transition active:scale-95">
                            <i class="fas fa-play text-xs"></i>
                            <span>Mulai OTW</span>
                        </button>
                    </form>

                @elseif($job->status == 'Progress')
                    {{-- Opsi 2: Tombol LAPOR (Hanya muncul jika sudah Progress) --}}
                    <a href="{{ route('teknisi.laporan.create', $job->id) }}" 
                       class="w-full inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-lg shadow-sm shadow-blue-200 transition active:scale-95 animate-pulse">
                        <i class="fas fa-camera"></i>
                        <span>Lapor Hasil</span>
                    </a>
                @endif
                
            </div>
        </div>

    </div>
</div>