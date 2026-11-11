@props([
    'user' => null,
    'kuisLulus' => 0,
    'modulCount' => 0,
    'quizCount' => 0,
    'heroKey' => 'samudra',
    'expCardClass' => 'bg-white/15 backdrop-blur-md border border-white/25',
    'pointerPassthrough' => false,
    'primaryBtnClass' => 'bg-white/95 backdrop-blur-sm text-[#007FBE] border border-white/60 hover:bg-white',
    'primaryBtnIconClass' => 'text-[#007FBE]',
    'secondaryBtnClass' => 'bg-[#007FBE] text-white shadow-[0_3px_0_#00628E] border border-[#00628E] hover:bg-[#00628E]',
])

@php
    $rankInfo = $user ? $user->rank_tier : [
        'current_rank' => 'Pemula',
        'current_badge_url' => null,
        'next_rank' => null,
        'next_badge_url' => null,
        'current_points' => 0,
        'next_points' => null,
        'points_needed' => 0,
        'percent' => 0,
        'is_max' => false,
    ];
    $jenjangName = $user->jenjang->nama_jenjang ?? $user->jenjang->nama_tipe ?? 'Umum';
    $rowPointerClass = $pointerPassthrough ? 'pointer-events-none' : '';
    $interactiveClass = $pointerPassthrough ? 'pointer-events-auto' : '';
    $nextHero = $heroKey === 'galaksi' ? 'samudra' : 'galaksi';
    $nextHeroShort = $nextHero === 'galaksi' ? 'Galaksi' : 'Samudra';
@endphp

<!-- Konten Menimpa Bagian Atas: Profil Siswa & Peleburan Kartu Peringkat & EXP -->
<div class="relative z-20 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 {{ $rowPointerClass }}">
    <!-- Kiri: Info Profil Siswa -->
    <div class="flex items-center gap-3.5 min-w-0">
        <a href="{{ route('siswa.profil') }}" class="group relative block shrink-0 {{ $interactiveClass }}" title="Buka Profil Siswa">
            <div
                class="h-14 w-14 sm:h-16 sm:w-16 rounded-full p-[2.5px] bg-white shadow-lg ring-2 ring-white/70 transition duration-200 group-hover:scale-105">
                <div
                    class="h-full w-full rounded-full overflow-hidden bg-gradient-to-tr from-[#007FBE] to-[#51CDF4] flex items-center justify-center text-white font-bold">
                    @if(!empty($user->foto_profil_url))
                        <img src="{{ $user->foto_profil_url }}" alt="Foto profil {{ $user->nama ?? 'Siswa' }}"
                            class="h-full w-full object-cover">
                    @else
                        <span class="text-xl sm:text-2xl font-extrabold tracking-tight text-white">
                            {{ strtoupper(substr($user->nama ?? 'S', 0, 1)) }}
                        </span>
                    @endif
                </div>
            </div>
        </a>
        <div class="min-w-0">
            <div class="flex items-center gap-2 flex-wrap">
                <h2
                    class="text-base sm:text-lg font-extrabold text-white leading-tight truncate drop-shadow-[0_2px_4px_rgba(0,0,0,0.65)]">
                    {{ $user->nama ?? 'Siswa Arrava' }}
                </h2>
                <span
                    class="inline-flex items-center gap-1 rounded-full bg-[#D1FAE5] px-2 py-0.5 text-[10.5px] font-bold text-[#047857] shadow-sm border border-emerald-300">
                    <svg class="w-3 h-3 text-[#059669]" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    <span>{{ $jenjangName }}</span>
                </span>
            </div>
            <div
                class="mt-1 text-xs font-semibold text-white/95 drop-shadow-[0_1px_3px_rgba(0,0,0,0.7)] flex items-center gap-2 flex-wrap">
                <span
                    class="inline-flex items-center gap-1 bg-white/20 backdrop-blur-sm px-2 py-0.5 rounded-md border border-white/25">
                    <span>Level:</span> <strong>{{ $rankInfo['current_rank'] }}</strong>
                </span>
                <span>•</span>
                <span>{{ $kuisLulus }} Kuis Selesai</span>
                <span>•</span>
                <span>{{ $modulCount }} Modul</span>
                @if($user)
                    <span>•</span>
                    <form action="{{ route('siswa.profil.hero_theme') }}" method="POST" class="inline-flex {{ $interactiveClass }}">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="hero_theme" value="{{ $nextHero }}">
                        <input type="hidden" name="redirect_to" value="dashboard">
                        <button type="submit"
                            title="Ganti tema hero ke {{ $nextHeroShort }} Piksel"
                            class="inline-flex items-center gap-1 rounded-md bg-white/20 hover:bg-white/30 backdrop-blur-sm px-2 py-0.5 border border-white/30 text-[11px] font-bold text-white transition cursor-pointer">
                            <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            <span>Ganti Hero ({{ $nextHeroShort }})</span>
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <!-- Kanan: Peleburan Kartu Peringkat & EXP (Glassmorphic) -->
    <div
        class="w-full lg:w-auto lg:min-w-[360px] xl:min-w-[400px] rounded-2xl {{ $expCardClass }} p-3.5 sm:p-4 text-white shadow-lg">
        <div class="flex items-center justify-between gap-2">
            <span class="text-[11px] font-black uppercase tracking-wider text-white/80">Peringkat &amp; EXP</span>
            <a href="{{ route('siswa.leaderboard') }}"
                class="inline-flex items-center gap-1.5 rounded-full bg-white/95 backdrop-blur-sm px-2.5 py-0.5 text-xs font-extrabold text-[#B45309] border border-white/60 hover:bg-white transition shadow-xs {{ $interactiveClass }}"
                title="Lihat Papan Peringkat">
                @if($rankInfo['current_badge_url'])
                    <img src="{{ $rankInfo['current_badge_url'] }}" alt="{{ $rankInfo['current_rank'] }}"
                        class="h-3.5 w-3.5 object-contain">
                @else
                    <span class="text-[#D97706]">★</span>
                @endif
                <span>{{ $rankInfo['current_rank'] }}</span>
            </a>
        </div>

        <!-- Angka EXP & Status Target Rank -->
        <div class="mt-2 flex items-baseline justify-between gap-2">
            <div class="flex items-baseline gap-1.5">
                <span class="text-2xl sm:text-3xl font-heading font-black text-white leading-none">
                    {{ number_format($rankInfo['current_points']) }}
                </span>
                <span class="text-xs font-extrabold uppercase tracking-wider text-amber-300">EXP</span>
            </div>
            <div class="text-right text-[11px] font-bold text-white/90">
                @if($rankInfo['is_max'])
                    <span class="text-emerald-300 font-extrabold">Tingkat Tertinggi 👑</span>
                @else
                    <span>Menuju <strong class="text-white font-black">{{ $rankInfo['next_rank'] }}</strong></span>
                    <span class="block text-[10px] text-white/75 font-semibold">
                        {{ number_format($rankInfo['current_points']) }} / {{ number_format($rankInfo['next_points']) }}
                    </span>
                @endif
            </div>
        </div>

        <!-- EXP Bar dengan Icon Widget EXP -->
        <div class="mt-2 flex items-center gap-2">
            <img src="{{ asset('assets/widget/exp.png') }}" alt="EXP" title="EXP Poin"
                class="h-5 w-5 shrink-0 object-contain select-none" style="image-rendering: pixelated;">

            <div class="relative h-2.5 flex-1 overflow-hidden rounded-full bg-black/25 ring-1 ring-white/30">
                <div class="h-full rounded-full bg-gradient-to-r from-amber-400 via-orange-400 to-amber-500 shadow-sm transition-all duration-500"
                    style="width: {{ $rankInfo['percent'] }}%;">
                </div>
            </div>

            <span class="shrink-0 text-xs font-black text-amber-300 min-w-[34px] text-right">
                {{ $rankInfo['percent'] }}%
            </span>
        </div>

        <!-- Footer: Sisa EXP & Link Leaderboard -->
        <div
            class="mt-2.5 flex items-center justify-between border-t border-white/20 pt-2 text-[11px] font-bold text-white/90">
            @if($rankInfo['is_max'])
                <span class="text-emerald-300">Hebat! Semua tingkat terbuka.</span>
            @else
                <span>Sisa <strong class="text-white">{{ number_format($rankInfo['points_needed']) }} EXP</strong>
                    lagi</span>
            @endif
            <a href="{{ route('siswa.leaderboard') }}"
                class="font-extrabold text-amber-300 hover:text-white hover:underline flex items-center gap-1 transition {{ $interactiveClass }}">
                <span>Lihat leaderboard</span>
                <span>→</span>
            </a>
        </div>
    </div>
</div>

<!-- Konten Menimpa Bagian Bawah: Sapaan Hangat & Quick Shortcuts -->
<div
    class="relative z-20 mt-4 sm:mt-6 pt-3 sm:pt-4 flex flex-wrap items-end justify-between gap-4 border-t border-white/15 {{ $rowPointerClass }}">
    <div class="max-w-md">
        <h1
            class="text-lg sm:text-xl font-heading font-black text-white leading-tight drop-shadow-[0_2px_4px_rgba(0,0,0,0.7)]">
            Halo, {{ $user->nama ?? 'Siswa' }} 👋
        </h1>
        <p class="mt-0.5 text-xs sm:text-sm font-medium text-white/90 drop-shadow-[0_1px_2px_rgba(0,0,0,0.6)]">
            Jelajahi materi interaktif, taklukkan kuis seru, dan raih peringkat teratas!
        </p>
    </div>

    <div class="flex items-center gap-2.5">
        <a href="{{ route('siswa.modul') }}"
            class="inline-flex items-center gap-2 rounded-full px-4 py-2 text-xs font-extrabold shadow-md transition hover:-translate-y-0.5 {{ $primaryBtnClass }} {{ $interactiveClass }}">
            <svg class="w-4 h-4 {{ $primaryBtnIconClass }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 16.5 5c1.747 0 3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
            </svg>
            <span>Mulai Belajar</span>
        </a>
        <a href="{{ route('siswa.quiz') }}"
            class="inline-flex items-center gap-2 rounded-full px-4 py-2 text-xs font-extrabold transition active:translate-y-0.5 active:shadow-none {{ $secondaryBtnClass }} {{ $interactiveClass }}">
            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>Latihan Kuis</span>
        </a>
    </div>
</div>

