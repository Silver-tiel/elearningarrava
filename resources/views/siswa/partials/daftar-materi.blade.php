<aside class="rounded-2xl sm:rounded-3xl border-2 border-[#DCEFFF] bg-white p-4 h-fit shadow-[0_4px_0_#B2E7FC]">
    <div class="flex items-center justify-between px-2 pb-3 border-b border-[#DCEFFF]">
        <h2 class="text-[15px] font-heading font-black text-[#082765]">Materi Sejenjang 📚</h2>
        <span class="text-[11px] font-bold text-[#007FBE] bg-[#DDF3FF] border border-[#B2E7FC] px-2.5 py-0.5 rounded-full">
            {{ (isset($modulLain) ? $modulLain->count() : 0) + 1 }} Materi
        </span>
    </div>

    <div class="mt-3 space-y-1.5 max-h-[460px] overflow-y-auto">
        {{-- Modul Aktif Saat Ini --}}
        <div class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-left bg-[#DDF3FF] text-[#007FBE] border border-[#B2E7FC] shadow-2xs">
            <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full text-[11px] font-bold bg-[#007FBE] text-white">
                {{ $modul->is_video ? '▶' : '📖' }}
            </span>
            <div class="flex-1 min-w-0">
                <p class="truncate text-[13px] font-black text-[#082765]">{{ $modul->judul_modul }}</p>
                <span class="text-[10px] font-bold text-[#007FBE]">Sedang Dipelajari</span>
            </div>
            <span class="text-[10px] font-bold px-2 py-0.5 rounded-md shrink-0 {{ $modul->is_video ? 'bg-red-50 text-red-600 border border-red-200' : 'bg-emerald-50 text-emerald-700 border border-emerald-200' }}">
                {{ $modul->is_video ? 'Video' : 'PDF' }}
            </span>
        </div>

        {{-- Modul Lainnya --}}
        @if(isset($modulLain) && $modulLain->isNotEmpty())
            <div class="pt-3 pb-1 px-2">
                <p class="text-[11px] font-bold text-[#72839E] uppercase tracking-wider">Materi Lainnya</p>
            </div>
            @foreach($modulLain as $item)
                <a href="{{ route('siswa.modul.materi', $item->id_modul) }}"
                   class="flex items-center gap-3 rounded-xl px-3 py-2 text-left transition text-[#465673] hover:bg-[#F0F6FF] hover:text-[#007FBE]">
                    <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full text-[10px] font-bold bg-[#F0F6FF] text-[#72839E] border border-[#DCEFFF]">
                        {{ $item->is_video ? '▶' : '📄' }}
                    </span>
                    <div class="flex-1 min-w-0">
                        <p class="truncate text-[12px] font-bold text-[#12233F]">{{ $item->judul_modul }}</p>
                        <span class="text-[10px] font-semibold text-[#72839E]">{{ $item->jenjang->nama_tipe ?? '' }}</span>
                    </div>
                    <span class="text-[10px] font-bold px-1.5 py-0.5 rounded shrink-0 {{ $item->is_video ? 'bg-red-50 text-red-600' : 'bg-slate-100 text-[#465673]' }}">
                        {{ $item->is_video ? 'Video' : 'PDF' }}
                    </span>
                </a>
            @endforeach
        @endif
    </div>
</aside>
