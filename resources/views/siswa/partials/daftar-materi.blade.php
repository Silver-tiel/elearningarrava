<aside class="rounded-2xl border border-[#e4eaf1] bg-white p-4 h-fit">
    <div class="flex items-center justify-between px-2 pb-3 border-b border-[#edf0f4]">
        <h2 class="text-[15px] font-extrabold text-[#172033]">Daftar Materi</h2>
        <span class="text-[10px] font-bold text-[#3180f7] bg-[#edf5ff] px-2 py-0.5 rounded-full">
            {{ $modul->materiVideo->count() ?: 1 }} Video
        </span>
    </div>

    <div class="mt-3 space-y-1 max-h-[420px] overflow-y-auto">
        @forelse($modul->materiVideo as $index => $item)
            @php
                $isActive = isset($selectedVideo) && $selectedVideo && $selectedVideo->id_materi == $item->id_materi;
            @endphp
            <a href="{{ route('siswa.modul.materi', ['id_modul' => $modul->id_modul, 'v' => $item->id_materi]) }}"
               class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-left transition
                      {{ $isActive ? 'bg-[#edf5ff] text-[#3180f7]' : 'text-[#52617a] hover:bg-[#f7f9fc]' }}">
                <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full text-[11px] font-bold
                    {{ $isActive ? 'bg-[#3180f7] text-white' : 'bg-[#f0f3f8] text-[#8a98ad]' }}">
                    {{ sprintf('%02d', $index + 1) }}
                </span>
                <span class="flex-1 truncate text-[13px] font-semibold">{{ $item->judul }}</span>
                <span class="text-[11px] text-[#8797ae] shrink-0">{{ $item->durasi ?? '' }}</span>
            </a>
        @empty
            @if($modul->youtube_embed_url)
                <div class="p-3 text-xs text-[#3180f7] bg-[#edf5ff] rounded-xl font-medium flex items-center gap-2">
                    ▶ Memutar video utama modul
                </div>
            @else
                <p class="px-3 py-4 text-center text-sm text-[#8797ae]">Belum ada video.</p>
            @endif
        @endforelse
    </div>
</aside>
