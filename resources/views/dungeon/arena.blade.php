@extends(auth()->user()->isSiswa() ? 'layouts.siswa' : 'layouts.app')

@section('title', 'Arena Dungeon: ' . $mapel->nama_mapel)

@section('hideSidebar', 'true')
@section('hideNiere', 'true')

@php
    $hideSidebar = true;
    $hideNiere = true;
@endphp

@section('header-left')
    <div class="flex items-center justify-between gap-3 w-full">
        <div class="min-w-0 flex items-center gap-2.5 sm:gap-3">
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] sm:text-xs font-bold bg-[#F0F6FF] text-[#007FBE] border border-[#B2E7FC] shrink-0">
                🏰 Dungeon Mode
            </span>
            <div class="min-w-0">
                <h1 class="text-sm sm:text-base font-extrabold text-slate-800 leading-tight truncate" title="Dungeon {{ $mapel->nama_mapel }}">
                    {{ $mapel->nama_mapel }}
                </h1>
                <p class="text-[11px] text-slate-500 font-medium truncate">
                    Petualangan Endless • 3 Hati (Nyawa)
                </p>
            </div>
        </div>

        <div class="shrink-0">
            <a href="{{ route('dungeon.index') }}"
               onclick="return confirm('Apakah kamu yakin ingin meninggalkan petualangan Dungeon? Sesi yang sedang berjalan akan dihentikan.');"
               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-rose-200 bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold text-xs shadow-xs transition">
                <span>✕</span>
                <span class="hidden sm:inline">Keluar Dungeon</span>
            </a>
        </div>
    </div>
@endsection

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
<style>
:root {
    --s: 96px;
    --heart-full: url("{{ asset('assets/dungeon/nyawa/heart-full.png') }}");
    --heart-shine: url("{{ asset('assets/dungeon/nyawa/heart-shine.png') }}");
    --heart-lost: url("{{ asset('assets/dungeon/nyawa/heart-lost.png') }}");
    --heart-dead: url("{{ asset('assets/dungeon/nyawa/heart-dead.png') }}");
}

@media (max-width: 640px) {
    :root {
        --s: 64px;
    }
}

.retro-font {
    font-family: 'Press Start 2P', "Courier New", monospace;
    letter-spacing: 2px;
}

.hearts-row {
    display: flex;
    gap: 16px;
    height: var(--s);
    justify-content: center;
    align-items: center;
}

.heart-slot {
    width: var(--s);
    height: var(--s);
    position: relative;
}

.heart-sprite {
    width: var(--s);
    height: var(--s);
    image-rendering: pixelated;
    background-repeat: no-repeat;
    background-position: 0 0;
    background-image: var(--heart-full);
    background-size: var(--s) var(--s);
}

.heart-sprite[data-state=shine] {
    background-image: var(--heart-shine);
    background-size: calc(var(--s) * 9) var(--s);
}

.heart-sprite[data-state=lost] {
    background-image: var(--heart-lost);
    background-size: calc(var(--s) * 12) var(--s);
}

.heart-sprite[data-state=dead] {
    background-image: var(--heart-dead);
    background-size: var(--s) var(--s);
}

.hud-pixel-heart {
    width: 22px;
    height: 22px;
    image-rendering: pixelated;
    background-repeat: no-repeat;
    background-position: 0 0;
    background-size: 22px 22px;
    background-image: var(--heart-full);
    transition: filter 0.2s ease, opacity 0.2s ease, transform 0.2s ease;
}

.hud-pixel-heart.dead {
    background-image: var(--heart-dead);
    opacity: 0.3;
    filter: grayscale(100%);
    transform: scale(0.9);
}

.countdown-val {
    font-family: 'Press Start 2P', "Courier New", monospace;
    font-size: clamp(40px, 10vw, 76px);
    color: #ffd84d;
    text-shadow: 4px 4px 0 #b38600, 0 0 25px rgba(255, 216, 77, 0.6);
}

.lose-title {
    font-family: 'Press Start 2P', "Courier New", monospace;
    font-size: clamp(18px, 5vw, 32px);
    color: #ff4d57;
    text-shadow: 4px 4px 0 #6b0f1a, 0 0 20px rgba(255, 77, 87, 0.6);
}

@keyframes dungeon-screen-shake {
    0% { transform: translate(0, 0); }
    15% { transform: translate(-10px, 6px); }
    30% { transform: translate(10px, -6px); }
    45% { transform: translate(-8px, 4px); }
    60% { transform: translate(8px, -4px); }
    75% { transform: translate(-4px, 2px); }
    90% { transform: translate(4px, -2px); }
    100% { transform: translate(0, 0); }
}

.screen-shake {
    animation: dungeon-screen-shake 0.45s steps(8) forwards;
}
</style>
@endpush

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6" id="dungeon-app">
    <!-- Header status bar: Hati, Lantai, Multiplier, Skor -->
    <div class="bg-slate-900 text-white rounded-[24px] p-4 md:p-5 mb-6 border-4 border-ink shadow-[0_6px_0_#0f3a5f] flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('dungeon.index') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border-2 border-white/20 bg-white/10 hover:bg-white/20 text-white font-bold text-xs transition active:translate-y-0.5">
                ← Kembali
            </a>
            <div>
                <h1 class="text-xl md:text-2xl font-black font-heading bg-gradient-to-r from-amber-300 to-sky-300 bg-clip-text text-transparent">
                    {{ $mapel->nama_mapel }}
                </h1>
                <span class="text-xs text-slate-400">Dungeon Soal Endless</span>
            </div>
        </div>

        <!-- HUD: Hati (Nyawa), Lantai, Multiplier, Skor -->
        <div class="flex items-center gap-4 md:gap-6">
            <!-- Hati (Nyawa) -->
            <div class="flex flex-col items-center">
                <span class="text-[10px] uppercase font-bold text-slate-400">Hati</span>
                <div class="flex items-center gap-1.5" id="hud-hati">
                    <div id="heart-1" class="hud-pixel-heart" title="Hati 1"></div>
                    <div id="heart-2" class="hud-pixel-heart" title="Hati 2"></div>
                    <div id="heart-3" class="hud-pixel-heart" title="Hati 3"></div>
                </div>
            </div>

            <!-- Lantai -->
            <div class="flex flex-col items-center">
                <span class="text-[10px] uppercase font-bold text-slate-400">Lantai</span>
                <div class="font-extrabold text-lg text-sky-400" id="hud-lantai">
                    Lt. <span id="val-lantai">{{ $sesiAktif->lantai_tertinggi ?? 1 }}</span>
                </div>
            </div>

            <!-- Multiplier -->
            <div class="flex flex-col items-center">
                <span class="text-[10px] uppercase font-bold text-slate-400">Multiplier</span>
                <div class="font-extrabold text-lg text-amber-300" id="hud-multiplier">
                    <span id="val-multiplier">{{ number_format($sesiAktif->multiplier_akhir ?? 1.0, 2) }}</span>x
                </div>
            </div>

            <!-- Skor -->
            <div class="flex flex-col items-center">
                <span class="text-[10px] uppercase font-bold text-slate-400">Skor</span>
                <div class="font-black text-xl text-emerald-400 font-mono" id="hud-skor">
                    <span id="val-skor">{{ number_format($sesiAktif->skor_dungeon ?? 0) }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Container Permainan -->
    <div id="game-arena" class="relative">
        <!-- Overlay Animasi Nyawa Jatuh, Countdown 321 & Nyawa Hancur -->
        <div id="dungeon-anim-overlay" class="fixed inset-0 z-50 flex flex-col items-center justify-center bg-slate-950/85 backdrop-blur-xs p-4 transition-opacity duration-300 hidden select-none">
            <div id="anim-box" class="flex flex-col items-center justify-center max-w-lg w-full text-center">
                <!-- Judul Animasi -->
                <div id="anim-title-text" class="retro-font text-xs sm:text-sm text-sky-400 mb-8 tracking-widest uppercase">
                    PETUALANGAN DUNGEON
                </div>

                <!-- Barisan Hati Animasi -->
                <div class="hearts-row" id="anim-hearts-row" role="img" aria-label="Nyawa Dungeon">
                </div>

                <!-- Teks Countdown / Status (3, 2, 1, MULAI / YOU LOSE / SISA NYAWA) -->
                <div id="anim-countdown-text" class="retro-font countdown-val mt-8 min-h-[90px] flex items-center justify-center">
                </div>
            </div>
        </div>

        @php
            $isLocked = !($statusDungeon['terbuka'] ?? false) && !$isStaff;
            $rekorVal = (int) ($rekorPribadi ?? 0);
            $maxFloorVal = (int) ($lantaiTertinggi ?? 1);
            $doorImg = $mapel->gambar ? asset($mapel->gambar) : asset('images/dungeon-door.jpg');
        @endphp

        <!-- Layar Memulai Petualangan (Tema Card Dungeon) -->
        <div class="{{ $sesiAktif ? 'hidden' : '' }} max-w-xl mx-auto overflow-hidden rounded-[28px] sm:rounded-[32px] border-4 border-ink bg-paper font-sans font-bold text-ink shadow-[0_12px_0_#0f3a5f] transition-all duration-200" id="screen-start">
            {{-- Banner Cover: Pintu Dungeon + Judul Mapel --}}
            <div class="relative block h-[230px] sm:h-[260px] overflow-hidden border-b-4 border-ink bg-sky-200 select-none">
                <img src="{{ $doorImg }}"
                     alt="Pintu Dungeon {{ $mapel->nama_mapel }}"
                     loading="lazy"
                     class="h-full w-full object-cover object-[50%_45%] transition duration-500 {{ $isLocked ? 'grayscale brightness-75' : '' }}">
                <span class="pointer-events-none absolute inset-x-0 bottom-0 h-[75%] bg-gradient-to-t from-slate-950/90 via-slate-900/40 to-transparent"></span>

                {{-- Badges atas cover --}}
                <div class="absolute inset-x-4 top-4 flex items-center justify-between">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full border-2 border-ink bg-white/95 text-ink text-xs font-black shadow-[0_2.5px_0_#0f3a5f]">
                        <span>🏰</span> Dungeon Endless
                    </span>
                    @if($isStaff && request()->boolean('uji_coba'))
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full border-2 border-ink bg-amber-300 text-amber-950 text-xs font-black shadow-[0_2.5px_0_#0f3a5f]">
                            <span>🛠️</span> Uji Coba Staff
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full border-2 border-ink bg-rose-200 text-rose-950 text-xs font-black shadow-[0_2.5px_0_#0f3a5f]">
                            <span>❤️</span> 3 Hati (Nyawa)
                        </span>
                    @endif
                </div>

                @if ($isLocked)
                    <span class="absolute left-1/2 top-[38%] grid h-[64px] w-[64px] -translate-x-1/2 -translate-y-1/2 place-items-center rounded-full border-4 border-ink bg-amber-300 text-ink shadow-[0_4px_0_#0f3a5f]" aria-hidden="true">
                        <svg class="h-8 w-8" viewBox="0 0 24 24" fill="currentColor" stroke="#0f3a5f" stroke-width="2" stroke-linejoin="round"><rect x="4" y="11" width="16" height="10" rx="2"/><path d="M8 11V7a4 4 0 0 1 8 0v4" fill="none" stroke-linecap="round"/></svg>
                    </span>
                @endif

                {{-- Teks Judul di atas banner --}}
                <div class="pointer-events-none absolute inset-x-5 bottom-4">
                    <h2 class="font-display text-2xl sm:text-3xl font-bold leading-tight text-white line-clamp-2 [text-shadow:0_2px_0_#0f3a5f,0_0_12px_rgba(8,30,50,.7)]">
                        {{ $mapel->nama_mapel }}
                    </h2>
                    <p class="mt-1 text-xs sm:text-sm text-white/95 [text-shadow:0_1px_0_#0f3a5f,0_0_8px_rgba(8,30,50,.55)]">
                        Jenjang {{ $mapel->jenjang->nama_jenjang ?? $mapel->jenjang->nama_tipe ?? 'Umum' }} • Siap Memulai Petualangan?
                    </p>
                </div>
            </div>

            {{-- Isi Konten Kartu --}}
            <div class="p-5 sm:p-7 space-y-4 sm:space-y-5">
                {{-- Statistik 3 Kotak Arcade --}}
                <div class="grid grid-cols-3 gap-2.5 sm:gap-3">
                    <div class="rounded-[18px] border-[3px] border-ink bg-sky-50 px-2 py-2.5 text-center">
                        <div class="text-[11px] sm:text-xs text-sky-800/70 font-bold uppercase tracking-wider">Total</div>
                        <div class="font-display text-lg sm:text-xl font-semibold leading-tight text-ink">
                            {{ $statusDungeon['total_soal'] ?? 0 }} <small class="text-xs font-bold text-sky-800/60">soal</small>
                        </div>
                    </div>
                    <div class="rounded-[18px] border-[3px] border-ink bg-sky-50 px-2 py-2.5 text-center">
                        <div class="text-[11px] sm:text-xs text-sky-800/70 font-bold uppercase tracking-wider">Rekor skor</div>
                        <div class="font-display text-lg sm:text-xl font-semibold leading-tight text-amber-700">
                            {{ number_format($rekorVal, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="rounded-[18px] border-[3px] border-ink bg-sky-50 px-2 py-2.5 text-center">
                        <div class="text-[11px] sm:text-xs text-sky-800/70 font-bold uppercase tracking-wider">Lantai max</div>
                        <div class="font-display text-lg sm:text-xl font-semibold leading-tight text-ink">
                            Lt. {{ $maxFloorVal }}
                        </div>
                    </div>
                </div>

                {{-- Grafik Perjalanan Lantai --}}
                <div>
                    <div class="flex justify-between text-xs sm:text-[13px] text-sky-800/70 font-bold">
                        <span>Perjalanan lantai</span>
                        <b class="text-ink">Lt. {{ $maxFloorVal }} dari 10</b>
                    </div>
                    <div class="mt-1.5 flex h-[34px] sm:h-[38px] items-end gap-1.5" aria-hidden="true">
                        @for ($i = 0; $i < 10; $i++)
                            <i class="flex-1 rounded-t-md rounded-b-[3px] border-[2.5px] border-ink {{ $i < $maxFloorVal ? ($isLocked ? 'bg-slate-400' : 'bg-sky-400') : 'bg-sky-200' }}"
                               style="height: {{ 28 + $i * 7.2 }}%"></i>
                        @endfor
                    </div>
                </div>

                {{-- Balon Pesan Komik / Aturan Petualangan --}}
                <div class="relative rounded-2xl border-[3px] border-ink bg-amber-100 px-4 py-3 text-xs sm:text-sm leading-relaxed text-amber-950" role="status">
                    <span class="absolute -top-[10px] left-7 h-[15px] w-[15px] rotate-45 border-l-[3px] border-t-[3px] border-ink bg-amber-100"></span>
                    @if ($isLocked)
                        <b>Pintunya masih terkunci.</b> {{ $statusDungeon['alasan'] ?? 'Soalnya belum cukup, minta gurumu menambah soal dulu ya!' }}
                    @elseif ($rekorVal > 0)
                        <b>Rekormu {{ number_format($rekorVal, 0, ',', '.') }}!</b> Setiap 5 jawaban benar akan menaikkan lantai dan multiplier skormu (hingga 3.0x). Jaga 3 hatimu baik-baik!
                    @else
                        <b>Petualangan Dimulai!</b> Jawab setiap soal dengan tepat. Setiap 5 jawaban benar akan menaikkan lantai dan multiplier skormu. Berhati-hatilah, kamu memiliki 3 hati (nyawa)!
                    @endif
                </div>

                {{-- Tombol Mulai Petualangan 3D Arcade --}}
                <div>
                    @if ($isLocked)
                        <button type="button" disabled
                            class="w-full flex min-h-[58px] sm:min-h-[62px] items-center justify-center gap-2.5 rounded-[18px] border-[3px] border-ink bg-sky-100 text-sky-800/70 shadow-[0_3px_0_#0f3a5f] font-display text-lg sm:text-xl font-semibold cursor-not-allowed">
                            <span>🔒</span>
                            <span>Belum Bisa Masuk</span>
                        </button>
                    @else
                        <button id="btn-mulai" onclick="mulaiPetualangan()"
                            class="w-full flex min-h-[58px] sm:min-h-[62px] items-center justify-center gap-2.5 rounded-[18px] border-[3px] border-ink font-display text-lg sm:text-xl font-semibold bg-sky-400 text-ink shadow-[0_6px_0_#0f3a5f] transition hover:brightness-105 active:translate-y-[5px] active:shadow-[0_1px_0_#0f3a5f] cursor-pointer motion-safe:animate-pulse">
                            <span>🚀</span>
                            <span>Mulai Petualangan</span>
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <!-- Layar Soal Aktif (akan dirender via JS) -->
        <div id="screen-question" class="{{ !$sesiAktif ? 'hidden' : '' }} bg-white rounded-[28px] sm:rounded-[32px] p-6 md:p-8 border-4 border-ink text-ink shadow-[0_8px_0_#0f3a5f]">
            <!-- Bar timer -->
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs uppercase font-bold text-slate-500" id="soal-urutan">Soal Petualangan</span>
                <div class="flex items-center gap-2 text-rose-500 font-bold text-sm">
                    <span>⏳</span> <span id="timer-display">--</span>s
                </div>
            </div>

            <div class="w-full bg-slate-100 dark:bg-slate-700 rounded-full h-2.5 mb-6 overflow-hidden border border-ink/20">
                <div id="timer-bar" class="bg-[#007FBE] h-2.5 transition-all duration-1000 rounded-full" style="width: 100%"></div>
            </div>

            <!-- Teks Soal -->
            <div class="mb-6">
                <div id="soal-foto-container" class="mb-4 hidden">
                    <img id="soal-foto" src="" alt="Foto Soal" class="max-h-72 rounded-2xl mx-auto object-contain border-2 border-ink">
                </div>
                <h3 id="soal-pertanyaan" class="text-xl md:text-2xl font-bold text-ink leading-relaxed">
                    Memuat soal...
                </h3>
            </div>

            <!-- Opsi Pilihan / Input Isian -->
            <div id="soal-opsi-container" class="space-y-3 mb-6">
                <!-- Dinamis via JS -->
            </div>

            <!-- Footer aksi: Menyerah & Lapor Soal -->
            <div class="pt-4 border-t border-slate-200 flex items-center justify-between text-xs">
                <button onclick="bukaModalLapor()" class="text-slate-400 hover:text-rose-500 transition flex items-center gap-1 font-bold cursor-pointer">
                    <span>🚩</span> Laporkan Soal
                </button>
                <button onclick="menyerahPetualangan()" class="text-slate-400 hover:text-slate-700 transition font-bold cursor-pointer">
                    Keluar & Akhiri
                </button>
            </div>
        </div>

        <!-- Layar Ringkasan Akhir (Petualangan Berakhir / Dungeon Tuntas) -->
        <div id="screen-summary" class="hidden max-w-xl mx-auto overflow-hidden rounded-[28px] sm:rounded-[32px] border-4 border-ink bg-paper font-sans font-bold text-ink shadow-[0_12px_0_#0f3a5f] p-6 sm:p-8 text-center">
            <div id="summary-icon" class="w-20 h-20 mx-auto rounded-3xl border-4 border-ink bg-white flex items-center justify-center text-4xl mb-4 shadow-[0_3px_0_#0f3a5f]">
                💀
            </div>
            <h2 id="summary-title" class="font-display text-2xl sm:text-3xl font-bold text-ink">
                Petualangan Berakhir
            </h2>
            <p id="summary-message" class="mt-1 text-xs sm:text-sm text-sky-800/80 font-semibold">
                Perjalananmu di Dungeon terhenti di sini.
            </p>

            <div class="mt-6 grid grid-cols-2 sm:grid-cols-4 gap-3">
                <div class="rounded-[18px] border-[3px] border-ink bg-sky-50 p-3 text-center">
                    <span class="block text-[11px] uppercase font-bold text-sky-800/70">Total Benar</span>
                    <span id="summary-benar" class="font-display text-xl sm:text-2xl font-bold text-emerald-600">0</span>
                </div>
                <div class="rounded-[18px] border-[3px] border-ink bg-sky-50 p-3 text-center">
                    <span class="block text-[11px] uppercase font-bold text-sky-800/70">Lantai</span>
                    <span id="summary-lantai" class="font-display text-xl sm:text-2xl font-bold text-[#007FBE]">Lt. 1</span>
                </div>
                <div class="rounded-[18px] border-[3px] border-ink bg-sky-50 p-3 text-center">
                    <span class="block text-[11px] uppercase font-bold text-sky-800/70">Skor Dungeon</span>
                    <span id="summary-skor" class="font-display text-xl sm:text-2xl font-bold text-amber-700">0</span>
                </div>
                <div class="rounded-[18px] border-[3px] border-ink bg-sky-50 p-3 text-center">
                    <span class="block text-[11px] uppercase font-bold text-sky-800/70">Poin Profil</span>
                    <span id="summary-poin" class="font-display text-xl sm:text-2xl font-bold text-rose-600">+0</span>
                </div>
            </div>

            <div class="mt-7 flex flex-col sm:flex-row items-center justify-center gap-3">
                <a href="{{ route('dungeon.index') }}" class="w-full sm:flex-1 flex min-h-[50px] items-center justify-center rounded-[18px] border-[3px] border-ink bg-white font-display text-base font-semibold text-ink shadow-btn transition hover:brightness-105 active:translate-y-1 active:shadow-btn-down">
                    Kembali ke Menu
                </a>
                <button onclick="mulaiPetualangan()" class="w-full sm:flex-1 flex min-h-[50px] items-center justify-center gap-2 rounded-[18px] border-[3px] border-ink bg-sky-400 font-display text-base font-semibold text-ink shadow-btn transition hover:brightness-105 active:translate-y-1 active:shadow-btn-down motion-safe:animate-pulse cursor-pointer">
                    Main Lagi 🔄
                </button>
            </div>
        </div>
    </div>
</div>
    </div>
</div>

@include('partials.floor-loader')

<script>
    const MAPEL_ID = {{ $mapel->id_mapel }};
    const CSRF_TOKEN = '{{ csrf_token() }}';
    let activeQuestion = null;
    let timerInterval = null;
    let remainingSeconds = 0;
    let totalDuration = 20;
    let currentNyawa = {{ $sesiAktif->nyawa ?? 3 }};
    let currentLantai = {{ $sesiAktif->lantai_tertinggi ?? 1 }};

    // Heart spritesheet engine
    const SHINE_FRAMES = 9;
    const LOST_FRAMES = 12;
    const FRAME_MS = 100;
    let spriteTimer = null;
    let animHearts = [];

    // Audio Effect: Kehilangan Nyawa
    const loseLifeAudio = new Audio('{{ asset("assets/sounds/dungeon/kehilanganNyawaSound.mp3") }}');
    loseLifeAudio.preload = 'auto';

    // Audio Effect: Memulai Petualangan Dungeon
    const startDungeonAudio = new Audio('{{ asset("assets/sounds/dungeon/suaraMulaiDungeon.mp3") }}');
    startDungeonAudio.preload = 'auto';

    function getDungeonAudioVolume() {
        const isMuted = localStorage.getItem('arrava_sound_muted') === 'true' || localStorage.getItem('arrava_sound_enabled') === 'false';
        if (isMuted) return 0;

        let vol = 0.85;
        const storedVol = localStorage.getItem('arrava_sound_volume');
        if (storedVol !== null && !isNaN(parseFloat(storedVol))) {
            vol = parseFloat(storedVol);
        }
        return Math.max(0, Math.min(1, vol));
    }

    function playLoseLifeSound() {
        try {
            const vol = getDungeonAudioVolume();
            if (vol <= 0) return;

            loseLifeAudio.volume = vol;
            loseLifeAudio.currentTime = 0;
            const p = loseLifeAudio.play();
            if (p !== undefined) {
                p.catch(err => {
                    console.warn('Audio play error / blocked:', err);
                });
            }
        } catch (e) {
            console.warn('Lose life audio error:', e);
        }
    }

    function playStartDungeonSound() {
        try {
            const vol = getDungeonAudioVolume();
            if (vol <= 0) return;

            startDungeonAudio.volume = vol;
            startDungeonAudio.currentTime = 0;
            const p = startDungeonAudio.play();
            if (p !== undefined) {
                p.catch(err => {
                    console.warn('Start dungeon audio error / blocked:', err);
                });
            }
        } catch (e) {
            console.warn('Start dungeon audio error:', e);
        }
    }

    // Unlock audio on first user interaction
    document.addEventListener('click', function unlockDungeonAudio() {
        if (loseLifeAudio) {
            loseLifeAudio.load();
        }
        if (startDungeonAudio) {
            startDungeonAudio.load();
        }
        document.removeEventListener('click', unlockDungeonAudio);
    }, { once: true });

    function setHeartFrame(h, f) {
        h.el.style.backgroundPositionX = `calc(var(--s) * ${-f})`;
    }

    function setHeartState(h, state) {
        h.state = state;
        h.f = 0;
        h.el.dataset.state = state;
        setHeartFrame(h, 0);
    }

    function tickHearts() {
        for (let i = 0; i < animHearts.length; i++) {
            const h = animHearts[i];
            if (h.state === 'shine') {
                h.f = (h.f + 1) % SHINE_FRAMES;
                setHeartFrame(h, h.f);
            } else if (h.state === 'lost') {
                h.f++;
                if (h.f >= LOST_FRAMES) {
                    setHeartState(h, 'dead');
                    if (h.done) {
                        const cb = h.done;
                        h.done = null;
                        cb();
                    }
                } else {
                    setHeartFrame(h, h.f);
                }
            }
        }
    }

    function startHeartTicker() {
        if (!spriteTimer) {
            spriteTimer = setInterval(tickHearts, FRAME_MS);
        }
    }

    function triggerShake() {
        const overlay = document.getElementById('dungeon-anim-overlay');
        const row = document.getElementById('anim-hearts-row');
        if (overlay) {
            overlay.classList.remove('screen-shake');
            void overlay.offsetWidth;
            overlay.classList.add('screen-shake');
        }
        if (row) {
            row.animate([
                { transform: 'translateX(0)' },
                { transform: 'translateX(-10px)' },
                { transform: 'translateX(10px)' },
                { transform: 'translateX(-8px)' },
                { transform: 'translateX(8px)' },
                { transform: 'translateX(-4px)' },
                { transform: 'translateX(0)' }
            ], { duration: 400, easing: 'steps(8)' });
        }
        if (navigator.vibrate) {
            try { navigator.vibrate([100, 50, 150]); } catch(e) {}
        }
    }

    function playStartAnimation(onDone) {
        const overlay = document.getElementById('dungeon-anim-overlay');
        const row = document.getElementById('anim-hearts-row');
        const titleEl = document.getElementById('anim-title-text');
        const countdownEl = document.getElementById('anim-countdown-text');

        if (!overlay || !row) {
            if (onDone) onDone();
            return;
        }

        startHeartTicker();

        row.innerHTML = '';
        titleEl.textContent = 'PETUALANGAN DUNGEON';
        titleEl.className = 'retro-font text-xs sm:text-sm text-sky-400 mb-8 tracking-widest uppercase';
        titleEl.style.opacity = '1';
        countdownEl.textContent = '';
        countdownEl.className = 'retro-font countdown-val mt-8 min-h-[90px] flex items-center justify-center';

        overlay.classList.remove('hidden');
        overlay.style.opacity = '0';
        requestAnimationFrame(() => {
            overlay.style.opacity = '1';
        });

        animHearts = [];
        const TOTAL = 3;

        for (let i = 0; i < TOTAL; i++) {
            const slot = document.createElement('div');
            slot.className = 'heart-slot';
            const el = document.createElement('div');
            el.className = 'heart-sprite';
            slot.appendChild(el);
            row.appendChild(slot);

            const h = { el: el, state: 'full', f: 0, done: null };
            animHearts.push(h);

            const dropDelay = i * 250;
            slot.animate([
                { transform: 'translateY(-480px)', opacity: 0, offset: 0 },
                { opacity: 1, offset: 0.1 },
                { transform: 'translateY(0)', offset: 0.6 },
                { transform: 'translateY(-24px)', offset: 0.75 },
                { transform: 'translateY(0)', offset: 0.9 },
                { transform: 'translateY(-6px)', offset: 0.95 },
                { transform: 'translateY(0)', offset: 1 }
            ], {
                duration: 900,
                delay: dropDelay,
                easing: 'linear',
                fill: 'backwards'
            });

            setTimeout(() => {
                setHeartState(h, 'shine');
                h.f = (i * 3) % SHINE_FRAMES;
                setHeartFrame(h, h.f);
            }, dropDelay + 900);
        }

        const totalDropTime = (TOTAL - 1) * 250 + 900 + 150;
        setTimeout(() => {
            runCountdown(countdownEl, () => {
                overlay.style.opacity = '0';
                setTimeout(() => {
                    overlay.classList.add('hidden');
                    if (onDone) onDone();
                }, 300);
            });
        }, totalDropTime);
    }

    function runCountdown(el, onFinish) {
        const steps = [
            { text: '3', color: '#ffd84d', shadow: '#b38600', duration: 700 },
            { text: '2', color: '#ffd84d', shadow: '#b38600', duration: 700 },
            { text: '1', color: '#ffd84d', shadow: '#b38600', duration: 700 },
            { text: 'MULAI!', color: '#10b981', shadow: '#065f46', duration: 500 }
        ];

        let idx = 0;
        function next() {
            if (idx >= steps.length) {
                if (onFinish) onFinish();
                return;
            }
            const s = steps[idx];
            if (s.text === '3') {
                playStartDungeonSound();
            }
            el.textContent = s.text;
            el.style.color = s.color;
            el.style.textShadow = `4px 4px 0 ${s.shadow}, 0 0 25px ${s.color}`;
            el.animate([
                { transform: 'scale(2.2)', opacity: 0 },
                { transform: 'scale(1)', opacity: 1, offset: 0.35 },
                { transform: 'scale(1.08)', offset: 0.7 },
                { transform: 'scale(1)', opacity: 1, offset: 1 }
            ], { duration: 380, easing: 'ease-out' });

            idx++;
            setTimeout(next, s.duration);
        }
        next();
    }

    function playLoseHeartAnimation(prevLives, newLives, isTimeout, onComplete) {
        const overlay = document.getElementById('dungeon-anim-overlay');
        const row = document.getElementById('anim-hearts-row');
        const titleEl = document.getElementById('anim-title-text');
        const countdownEl = document.getElementById('anim-countdown-text');

        if (!overlay || !row) {
            if (onComplete) onComplete();
            return;
        }

        startHeartTicker();

        row.innerHTML = '';
        titleEl.textContent = isTimeout ? '⏳ WAKTU HABIS!' : '❌ JAWABAN SALAH!';
        titleEl.className = 'retro-font text-xs sm:text-sm text-rose-500 mb-8 tracking-widest uppercase';
        titleEl.style.textShadow = '2px 2px 0 #6b0f1a';

        countdownEl.textContent = '';
        countdownEl.className = 'retro-font lose-title mt-8 min-h-[60px] flex items-center justify-center';

        overlay.classList.remove('hidden');
        overlay.style.opacity = '0';
        requestAnimationFrame(() => {
            overlay.style.opacity = '1';
        });

        animHearts = [];
        const TOTAL = 3;
        const targetIndex = Math.max(0, prevLives - 1);

        for (let i = 0; i < TOTAL; i++) {
            const slot = document.createElement('div');
            slot.className = 'heart-slot';
            const el = document.createElement('div');
            el.className = 'heart-sprite';
            slot.appendChild(el);
            row.appendChild(slot);

            const h = { el: el, state: 'full', f: 0, done: null };
            animHearts.push(h);

            if (i < targetIndex) {
                setHeartState(h, 'shine');
                h.f = (i * 3) % SHINE_FRAMES;
                setHeartFrame(h, h.f);
            } else if (i === targetIndex) {
                setHeartState(h, 'full');
            } else {
                setHeartState(h, 'dead');
            }
        }

        setTimeout(() => {
            triggerShake();
            playLoseLifeSound();

            const targetHeart = animHearts[targetIndex];
            targetHeart.done = () => {
                if (newLives <= 0) {
                    countdownEl.textContent = 'YOU LOSE';
                    countdownEl.animate([
                        { opacity: 0, transform: 'scale(0.5)' },
                        { opacity: 1, transform: 'scale(1.2)', offset: 0.6 },
                        { opacity: 1, transform: 'scale(1)' }
                    ], { duration: 600, easing: 'steps(6)' });

                    setTimeout(() => {
                        overlay.style.opacity = '0';
                        setTimeout(() => {
                            overlay.classList.add('hidden');
                            if (onComplete) onComplete();
                        }, 300);
                    }, 1200);
                } else {
                    countdownEl.textContent = `-1 HATI (SISA ${newLives})`;
                    countdownEl.style.fontSize = 'clamp(14px, 4vw, 20px)';
                    countdownEl.style.color = '#ffd84d';
                    countdownEl.style.textShadow = '2px 2px 0 #b38600';

                    setTimeout(() => {
                        overlay.style.opacity = '0';
                        setTimeout(() => {
                            overlay.classList.add('hidden');
                            if (onComplete) onComplete();
                        }, 300);
                    }, 700);
                }
            };

            setHeartState(targetHeart, 'lost');
        }, 250);
    }

    function updateHUD(nyawa, lantai, multiplier, skor) {
        currentNyawa = nyawa;
        currentLantai = lantai;
        for (let i = 1; i <= 3; i++) {
            const h = document.getElementById('heart-' + i);
            if (h) {
                if (i <= nyawa) {
                    h.classList.remove('dead');
                } else {
                    h.classList.add('dead');
                }
            }
        }
        if (document.getElementById('val-lantai')) document.getElementById('val-lantai').innerText = lantai;
        if (document.getElementById('val-multiplier')) document.getElementById('val-multiplier').innerText = parseFloat(multiplier).toFixed(2);
        if (document.getElementById('val-skor')) document.getElementById('val-skor').innerText = parseInt(skor).toLocaleString();
    }

    async function mulaiPetualangan() {
        // Pre-warm audio saat gesture klik pengguna berlangsung
        if (startDungeonAudio) {
            try { startDungeonAudio.load(); } catch (e) {}
        }
        const btnMulai = document.getElementById('btn-mulai');
        if (btnMulai) {
            btnMulai.disabled = true;
            btnMulai.style.pointerEvents = 'none';
        }

        try {
            const res = await fetch(`/dungeon/${MAPEL_ID}/mulai`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    uji_coba: {{ request()->boolean('uji_coba') ? 'true' : 'false' }},
                    id_jenjang: {{ (int) request('jenjang', 0) }}
                })
            });
            const data = await res.json();
            if (data.success && data.soal) {
                const startScreen = document.getElementById('screen-start');
                const summaryScreen = document.getElementById('screen-summary');
                const questionScreen = document.getElementById('screen-question');

                if (startScreen) startScreen.classList.add('hidden');
                if (summaryScreen) summaryScreen.classList.add('hidden');
                if (questionScreen) questionScreen.classList.remove('hidden');

                updateHUD(3, 1, 1.0, 0);

                playStartAnimation(() => {
                    renderSoal(data.soal);
                });
            } else if (data.message) {
                alert(data.message);
                if (btnMulai) {
                    btnMulai.disabled = false;
                    btnMulai.style.pointerEvents = '';
                }
            }
        } catch (e) {
            console.error(e);
            alert('Gagal memulai petualangan. Silakan coba lagi.');
            if (btnMulai) {
                btnMulai.disabled = false;
                btnMulai.style.pointerEvents = '';
            }
        }
    }

    async function loadSoalAktif() {
        try {
            const res = await fetch(`/dungeon/${MAPEL_ID}/aktif`, {
                headers: { 'Accept': 'application/json' }
            });
            const data = await res.json();
            if (data.success && data.soal) {
                renderSoal(data.soal);
            } else if (data.selesai) {
                tampilkanSummary(data.sesi);
            }
        } catch (e) {
            console.error(e);
        }
    }

    function renderSoal(soal) {
        activeQuestion = soal;
        updateHUD(soal.nyawa, soal.lantai, soal.multiplier, soal.skor_dungeon);

        document.getElementById('soal-urutan').innerText = `Soal #${soal.urutan} • Tingkat ${soal.tingkat_soal.toUpperCase()}`;
        document.getElementById('soal-pertanyaan').innerText = soal.pertanyaan;

        if (soal.foto_soal) {
            document.getElementById('soal-foto').src = soal.foto_soal;
            document.getElementById('soal-foto-container').classList.remove('hidden');
        } else {
            document.getElementById('soal-foto-container').classList.add('hidden');
        }

        const container = document.getElementById('soal-opsi-container');
        container.innerHTML = '';

        if (soal.id_jenis_soal === 2) {
            // Isian Singkat
            container.innerHTML = `
                <div class="flex gap-3">
                    <input type="text" id="input-isian" class="flex-1 px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white" placeholder="Ketik jawabanmu di sini...">
                    <button onclick="kirimJawaban(document.getElementById('input-isian').value)" class="px-6 py-3 rounded-xl bg-[#007FBE] hover:bg-[#00689E] text-white font-bold transition">
                        Kirim
                    </button>
                </div>
            `;
        } else {
            // Pilihan Ganda / Benar Salah
            soal.pilihan.forEach(p => {
                const btn = document.createElement('button');
                btn.className = "w-full text-left p-4 rounded-xl border border-slate-200 dark:border-slate-700 hover:border-[#007FBE] hover:bg-[#F0F6FF] dark:hover:bg-blue-950/30 transition flex items-center gap-3 text-slate-800 dark:text-slate-100 font-semibold group";
                btn.onclick = () => kirimJawaban(p.id_pilihan);
                btn.innerHTML = `
                    <span class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-700 group-hover:bg-[#007FBE] group-hover:text-white flex items-center justify-center font-bold text-xs transition">
                        ${p.label}
                    </span>
                    <span>${p.teks_pilihan}</span>
                `;
                container.appendChild(btn);
            });
        }

        // Start timer
        totalDuration = soal.durasi_detik || 20;
        remainingSeconds = totalDuration;
        mulaiTimer();
    }

    function mulaiTimer() {
        clearInterval(timerInterval);
        const timerDisp = document.getElementById('timer-display');
        const timerBar = document.getElementById('timer-bar');

        timerInterval = setInterval(() => {
            remainingSeconds--;
            if (timerDisp) timerDisp.innerText = Math.max(0, remainingSeconds);
            if (timerBar) {
                const pct = (Math.max(0, remainingSeconds) / totalDuration) * 100;
                timerBar.style.width = pct + '%';
                if (pct < 30) {
                    timerBar.className = "bg-rose-500 h-2 transition-all duration-1000";
                }
            }

            if (remainingSeconds <= -2) {
                clearInterval(timerInterval);
                kirimJawaban('[waktu_habis]');
            }
        }, 1000);
    }

    async function kirimJawaban(jawaban) {
        clearInterval(timerInterval);
        if (!activeQuestion) return;

        try {
            const res = await fetch(`/dungeon/${MAPEL_ID}/jawab`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    id_soal: activeQuestion.id_soal,
                    jawaban: jawaban
                })
            });

            const data = await res.json();
            if (data.success && data.hasil) {
                const h = data.hasil;
                const prevNyawa = currentNyawa;
                const newNyawa = h.status_sesi.nyawa;
                const prevLantai = currentLantai;
                const newLantai = h.status_sesi.lantai;

                if (!h.is_benar) {
                    playLoseHeartAnimation(prevNyawa, newNyawa, h.is_timeout, () => {
                        updateHUD(newNyawa, newLantai, h.status_sesi.multiplier, h.status_sesi.skor_dungeon);
                        if (h.status_sesi.selesai) {
                            tampilkanSummary(h.status_sesi);
                        } else if (h.soal_berikutnya) {
                            renderSoal(h.soal_berikutnya);
                        }
                    });
                } else {
                    if (newLantai > prevLantai && typeof FloorLoader !== 'undefined') {
                        FloorLoader.show({
                            from: prevLantai,
                            to: newLantai,
                            duration: 3000,
                            onDone: (to) => {
                                updateHUD(newNyawa, newLantai, h.status_sesi.multiplier, h.status_sesi.skor_dungeon);
                                if (h.status_sesi.selesai) {
                                    tampilkanSummary(h.status_sesi);
                                } else if (h.soal_berikutnya) {
                                    renderSoal(h.soal_berikutnya);
                                }
                            }
                        });
                    } else {
                        updateHUD(newNyawa, newLantai, h.status_sesi.multiplier, h.status_sesi.skor_dungeon);
                        if (h.status_sesi.selesai) {
                            tampilkanSummary(h.status_sesi);
                        } else if (h.soal_berikutnya) {
                            renderSoal(h.soal_berikutnya);
                        }
                    }
                }
            }
        } catch (e) {
            console.error(e);
            alert('Gagal mengirim jawaban.');
        }
    }

    function tampilkanSummary(sesi) {
        const qScreen = document.getElementById('screen-question');
        if (qScreen) qScreen.classList.add('hidden');

        const sScreen = document.getElementById('screen-summary');
        if (sScreen) {
            sScreen.classList.remove('hidden');
            if (document.getElementById('summary-benar')) document.getElementById('summary-benar').innerText = sesi.jumlah_benar || 0;
            if (document.getElementById('summary-lantai')) document.getElementById('summary-lantai').innerText = 'Lt. ' + (sesi.lantai || sesi.lantai_tertinggi || 1);
            if (document.getElementById('summary-skor')) document.getElementById('summary-skor').innerText = (sesi.skor_dungeon || 0).toLocaleString();
            if (document.getElementById('summary-poin')) document.getElementById('summary-poin').innerText = '+' + (sesi.poin_profil_didapat || 0);

            if (sesi.alasan_selesai === 'tuntas') {
                document.getElementById('summary-title').innerText = '🎉 Dungeon Tuntas!';
                document.getElementById('summary-icon').innerText = '🏆';
                document.getElementById('summary-icon').className = 'w-20 h-20 mx-auto rounded-3xl border-4 border-ink bg-amber-300 text-ink flex items-center justify-center text-4xl mb-4 shadow-[0_3px_0_#0f3a5f]';
            }
        }
    }

    async function menyerahPetualangan() {
        if (!confirm('Apakah kamu yakin ingin mengakhiri petualangan ini?')) return;
        try {
            const res = await fetch(`/dungeon/${MAPEL_ID}/selesai`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json'
                }
            });
            const data = await res.json();
            if (data.success) {
                tampilkanSummary(data.sesi);
            }
        } catch (e) {
            console.error(e);
        }
    }

    async function bukaModalLapor() {
        const alasan = prompt('Tuliskan alasan pelaporan soal (misal: kunci salah, typo, ambigu):');
        if (!alasan || !activeQuestion) return;

        try {
            const res = await fetch(`/dungeon/${MAPEL_ID}/lapor`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    id_soal: activeQuestion.id_soal,
                    alasan: alasan
                })
            });
            const data = await res.json();
            alert(data.message || 'Laporan diterima.');
        } catch (e) {
            alert('Gagal mengirim laporan.');
        }
    }

    // Auto load on mount
    document.addEventListener('DOMContentLoaded', () => {
        updateHUD({{ $sesiAktif->nyawa ?? 3 }}, {{ $sesiAktif->lantai_tertinggi ?? 1 }}, {{ $sesiAktif->multiplier_akhir ?? 1.0 }}, {{ $sesiAktif->skor_dungeon ?? 0 }});
        @if($sesiAktif)
            loadSoalAktif();
        @endif
    });
</script>
@endsection
