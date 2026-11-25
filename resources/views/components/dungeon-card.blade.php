{{-- Kartu siswa: masuk dungeon (gambar pintu/pemandangan, judul di atas gambar, grafik lantai) --}}
@props([
    'title',
    'level',
    'total' => 0,
    'rekor' => 0,
    'lantaiMax' => 1,
    'lantaiTotal' => 10,
    'url' => '#',
    'cover' => null,
    'locked' => false,
    'sesiAktif' => false,
    'alasan' => null,
])

@php
    $img  = $cover ?? asset('assets/dungeon/dungeon-door.webp');
    $tag  = $locked ? 'div' : 'a';
    $next = min($lantaiMax + 1, $lantaiTotal);
@endphp

<article class="w-full max-w-sm mx-auto overflow-hidden rounded-[28px] border-4 border-[#0f3a5f] bg-[#f7fcff] font-sans font-bold text-[#0f3a5f] shadow-[0_8px_0_#0f3a5f] flex flex-col justify-between h-full transition-all duration-200 hover:-translate-y-1.5 hover:shadow-[0_14px_0_#0f3a5f] select-none">

    {{-- Banner: gambar + status pill + padlock jika locked + judul di atasnya --}}
    <div class="relative">
        <{{ $tag }} @unless($locked) href="{{ $url }}" aria-label="Masuk dungeon {{ $title }}" @endunless
            class="group relative block h-[230px] overflow-hidden border-b-4 border-[#0f3a5f] bg-[#9bd4f3] focus-visible:outline focus-visible:outline-4 focus-visible:-outline-offset-8 focus-visible:outline-sky-500 cursor-pointer">
            <img src="{{ $img }}" alt="Pemandangan Dungeon {{ $title }}" loading="lazy"
                 class="h-full w-full object-cover object-[50%_45%] transition duration-500 {{ $locked ? 'grayscale brightness-[0.78]' : 'group-hover:scale-105' }}">
            <span class="pointer-events-none absolute inset-x-0 bottom-0 h-[68%] bg-gradient-to-t from-[#081e32]/85 via-[#081e32]/40 to-transparent"></span>

            {{-- Status Pill di sudut kanan atas --}}
            @if ($locked)
                <span class="absolute right-3 top-3 inline-flex items-center gap-1.5 px-3 py-1 rounded-full border-[3px] border-[#0f3a5f] bg-[#fbbf24] text-[#3b2a00] text-xs font-black shadow-[0_2px_0_#0f3a5f]">
                    🔒 Terkunci
                </span>
            @elseif($sesiAktif)
                <span class="absolute right-3 top-3 inline-flex items-center gap-1.5 px-3 py-1 rounded-full border-[3px] border-[#0f3a5f] bg-[#34d399] text-[#053d27] text-xs font-black shadow-[0_2px_0_#0f3a5f] animate-pulse">
                    <span>⚔️</span> Sedang Bermain
                </span>
            @else
                <span class="absolute right-3 top-3 inline-flex items-center gap-1.5 px-3 py-1 rounded-full border-[3px] border-[#0f3a5f] bg-[#34d399] text-[#053d27] text-xs font-black shadow-[0_2px_0_#0f3a5f]">
                    🔓 Terbuka
                </span>
            @endif

            {{-- Icon Gembok di tengah jika Terkunci --}}
            @if ($locked)
                <span class="absolute left-1/2 top-[38%] grid h-[60px] w-[60px] -translate-x-1/2 -translate-y-1/2 place-items-center rounded-full border-4 border-[#0f3a5f] bg-[#fbbf24] text-[#3b2a00] shadow-[0_4px_0_#0f3a5f]" aria-hidden="true">
                    <svg class="h-7 w-7" viewBox="0 0 24 24" fill="currentColor" stroke="#0f3a5f" stroke-width="2" stroke-linejoin="round">
                        <rect x="4" y="11" width="16" height="10" rx="2"/>
                        <path d="M8 11V7a4 4 0 0 1 8 0v4" fill="none" stroke-linecap="round"/>
                    </svg>
                </span>
            @endif
        </{{ $tag }}>

        {{-- Judul & Jenjang di atas gradient gambar --}}
        <div class="pointer-events-none absolute inset-x-5 bottom-4">
            <h2 class="font-display text-xl sm:text-2xl font-bold leading-tight text-white line-clamp-2 [text-shadow:0_2px_0_#0f3a5f,0_0_10px_rgba(8,30,50,.55)]">{{ $title }}</h2>
            <p class="mt-1 text-sm font-semibold text-white/95 [text-shadow:0_1px_0_#0f3a5f,0_0_8px_rgba(8,30,50,.55)]">Jenjang {{ $level }}</p>
        </div>
    </div>

    {{-- Body Kartu: Statistik, Tangga Lantai, Pesan Balon, Tombol Aksi --}}
    <div class="px-5 pb-6 flex-1 flex flex-col justify-between">
        <div>
            {{-- Statistik 3 Kotak --}}
            <div class="mt-[18px] grid grid-cols-3 gap-2.5">
                <div class="rounded-[18px] border-[3px] border-[#0f3a5f] bg-[#e8f6ff] px-1.5 py-2.5 text-center">
                    <div class="text-xs text-[#4f7292] font-bold">Total</div>
                    <div class="font-display text-lg sm:text-xl font-semibold text-[#0f3a5f]">{{ $total }} <small class="text-xs font-bold text-[#4f7292]">soal</small></div>
                </div>
                <div class="rounded-[18px] border-[3px] border-[#0f3a5f] bg-[#e8f6ff] px-1.5 py-2.5 text-center">
                    <div class="text-xs text-[#4f7292] font-bold">Rekor skor</div>
                    <div class="font-display text-lg sm:text-xl font-semibold text-[#b45309]">{{ number_format($rekor, 0, ',', '.') }}</div>
                </div>
                <div class="rounded-[18px] border-[3px] border-[#0f3a5f] bg-[#e8f6ff] px-1.5 py-2.5 text-center">
                    <div class="text-xs text-[#4f7292] font-bold">Lantai max</div>
                    <div class="font-display text-lg sm:text-xl font-semibold text-[#0f3a5f]">Lt. {{ $lantaiMax }}</div>
                </div>
            </div>

            {{-- Perjalanan Lantai (Grafik Tangga) --}}
            <div class="mt-4">
                <div class="flex justify-between text-[13px] text-[#4f7292] font-bold">
                    <span>Perjalanan lantai</span>
                    <b class="text-[#0f3a5f]">Lt. {{ $lantaiMax }} dari {{ $lantaiTotal }}</b>
                </div>
                <div class="mt-2 flex h-[34px] items-end gap-1" aria-hidden="true">
                    @for ($i = 0; $i < $lantaiTotal; $i++)
                        <i class="flex-1 rounded-t-md rounded-b-[3px] border-[2.5px] border-[#0f3a5f] {{ $i < $lantaiMax ? ($locked ? 'bg-slate-400' : 'bg-[#38bdf8]') : 'bg-[#cfe9fb]' }}"
                           style="height: {{ 28 + $i * 7.2 }}%"></i>
                    @endfor
                </div>
            </div>

            {{-- Pesan Bubble (Balon Percakapan) --}}
            <div class="relative mt-[18px] rounded-2xl border-[3px] border-[#0f3a5f] bg-[#fff4cc] px-3.5 py-3 text-sm leading-snug text-[#6b4a00] font-bold" role="status">
                <span class="absolute -top-[10px] left-7 h-[15px] w-[15px] rotate-45 border-l-[3px] border-t-[3px] border-[#0f3a5f] bg-[#fff4cc]"></span>
                @if ($locked)
                    <b>Pintunya masih terkunci.</b> {{ $alasan ?: 'Soalnya belum cukup, minta gurumu menambah soal dulu ya!' }}
                @elseif ($sesiAktif)
                    <b>Petualangan aktif!</b> Lanjutkan perjuanganmu dan raih skor tertinggi!
                @elseif ($rekor > 0)
                    <b>Rekormu {{ number_format($rekor, 0, ',', '.') }}!</b> Bisa naik ke Lt. {{ $next }} dan memecahkannya?
                @else
                    <b>Belum ada rekor.</b> Ayo buka pintunya dan jadi yang pertama menaklukkan Lt. 1!
                @endif
            </div>
        </div>

        {{-- Tombol Aksi 3D Glow --}}
        <{{ $tag }} @unless($locked) href="{{ $url }}" @else aria-disabled="true" @endunless
            class="mt-[18px] flex min-h-[58px] items-center justify-center gap-2.5 rounded-[18px] border-[3px] border-[#0f3a5f] font-display text-[19px] font-semibold
                   {{ $locked
                        ? 'cursor-not-allowed bg-[#cfe9fb] text-[#4f7292] shadow-[0_3px_0_#0f3a5f]'
                        : ($sesiAktif
                            ? 'bg-[#34d399] text-[#053d27] shadow-[0_6px_0_#0f3a5f] hover:brightness-105 active:translate-y-[5px] active:shadow-[0_1px_0_#0f3a5f] animate-pulse'
                            : 'bg-[#38bdf8] text-[#0f3a5f] shadow-[0_6px_0_#0f3a5f] hover:brightness-105 active:translate-y-[5px] active:shadow-[0_1px_0_#0f3a5f] [animation:dungeon-glow_2s_ease-in-out_infinite]') }}">
            @if($locked)
                <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="4" y="11" width="16" height="10" rx="2"/><path d="M8 11V7a4 4 0 0 1 8 0v4"/></svg>
                <span>Belum bisa masuk</span>
            @elseif($sesiAktif)
                <span class="text-xl">⚔️</span>
                <span>Lanjutkan Petualangan</span>
            @else
                <svg class="w-6 h-6 shrink-0" viewBox="0 0 24 24" fill="currentColor" stroke="#0f3a5f" stroke-width="2" stroke-linejoin="round" aria-hidden="true"><path d="M7 7h10a5 5 0 0 1 4.9 6l-.6 3.3a2.6 2.6 0 0 1-4.4 1.3L15 15.5H9L7.1 17.6a2.6 2.6 0 0 1-4.4-1.3L2.1 13A5 5 0 0 1 7 7z"/><path d="M8 10v3M6.5 11.5h3" stroke="#fff"/></svg>
                <span>Masuk Dungeon</span>
            @endif
        </{{ $tag }}>
    </div>
</article>

@once
<style>
@keyframes dungeon-glow {
    50% { filter: drop-shadow(0 0 8px rgba(56, 189, 248, 0.9)); }
}
</style>
@endonce
