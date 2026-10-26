<aside class="rounded-2xl border border-[#e4eaf1] bg-white p-4 h-fit">
    <div class="flex items-center justify-between px-2 pb-3 border-b border-[#edf0f4]">
        <h2 class="text-[15px] font-extrabold text-[#172033]">Materi Sejenjang</h2>
        <span class="text-[10px] font-bold text-[#3180f7] bg-[#edf5ff] px-2 py-0.5 rounded-full">
            {{ (isset($modulLain) ? $modulLain->count() : 0) + 1 }} Materi
        </span>
    </div>

    <div class="mt-3 space-y-1.5 max-h-[460px] overflow-y-auto">
        {{-- Modul Aktif Saat Ini --}}
        <div class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-left bg-[#edf5ff] text-[#3180f7] border border-[#d6e7ff]">
            <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full text-[11px] font-bold bg-[#3180f7] text-white">
                {{ $modul->is_video ? '▶' : '📖' }}
            </span>
            <div class="flex-1 min-w-0">
                <p class="truncate text-[13px] font-bold">{{ $modul->judul_modul }}</p>
                <span class="text-[10px] font-semibold text-[#3180f7]">Sedang Dipelajari</span>
            </div>
            <span class="text-[10px] font-bold px-1.5 py-0.5 rounded shrink-0 {{ $modul->is_video ? 'bg-red-100 text-red-600' : 'bg-emerald-100 text-emerald-700' }}">
                {{ $modul->is_video ? 'Video' : 'PDF' }}
            </span>
        </div>

        {{-- Modul Lainnya --}}
        @if(isset($modulLain) && $modulLain->isNotEmpty())
            <div class="pt-2 pb-1 px-2">
                <p class="text-[11px] font-bold text-[#8a98ad] uppercase tracking-wider">Materi Lainnya</p>
            </div>
            @foreach($modulLain as $item)
                <a href="{{ route('siswa.modul.materi', $item->id_modul) }}"
                   class="flex items-center gap-3 rounded-xl px-3 py-2 text-left transition text-[#52617a] hover:bg-[#f7f9fc]">
                    <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full text-[10px] font-bold bg-[#f0f3f8] text-[#8a98ad]">
                        {{ $item->is_video ? '▶' : '📄' }}
                    </span>
                    <div class="flex-1 min-w-0">
                        <p class="truncate text-[12px] font-medium text-[#2d3748]">{{ $item->judul_modul }}</p>
                        <span class="text-[10px] text-[#8797ae]">{{ $item->jenjang->nama_tipe ?? '' }}</span>
                    </div>
                    <span class="text-[10px] font-semibold px-1.5 py-0.5 rounded shrink-0 {{ $item->is_video ? 'bg-red-50 text-red-600' : 'bg-slate-100 text-slate-600' }}">
                        {{ $item->is_video ? 'Video' : 'PDF' }}
                    </span>
                </a>
            @endforeach
        @endif
    </div>
</aside>
