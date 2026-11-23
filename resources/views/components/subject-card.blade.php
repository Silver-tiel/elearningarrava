{{-- Kartu guru: editor soal & syarat membuka dungeon --}}
@props([
    'title', 'level',
    'mudah' => 0, 'sedang' => 0, 'sulit' => 0,
    'minTotal' => 30, 'minTier' => 8,
    'cover' => null,
    'editorUrl' => '#',
    'importUrl' => '#',
    'importOnClick' => null,
    'trialUrl' => '#',
    'icon' => null,
    'hasQuiz' => true,
    'alasan' => null,
])

@php
    $total = $mudah + $sedang + $sulit;
    $tiers = [['Mudah', $mudah, 'bg-emerald-400'], ['Sedang', $sedang, 'bg-amber-400'], ['Sulit', $sulit, 'bg-rose-400']];
    $open  = $total >= $minTotal && collect($tiers)->every(fn ($t) => $t[1] >= $minTier);
    $pct   = min(100, round($total / $minTotal * 100));
    $lack  = collect($tiers)->filter(fn ($t) => $t[1] < $minTier)->map(fn ($t) => $t[0].' ('.($minTier - $t[1]).')')->implode(', ');
    $btn   = 'flex min-h-[50px] items-center justify-center gap-2 rounded-2xl border-[3px] border-ink px-3 py-2 font-display text-sm sm:text-base font-semibold text-ink shadow-btn transition hover:brightness-105 active:translate-y-1 active:shadow-btn-down focus-visible:outline focus-visible:outline-4 focus-visible:outline-offset-2 focus-visible:outline-sky-500 select-none';
@endphp

<article class="w-full max-w-sm mx-auto overflow-hidden rounded-[28px] border-4 border-ink bg-paper font-sans font-bold text-ink shadow-card flex flex-col justify-between h-full transition-all duration-200 hover:-translate-y-1.5 hover:shadow-[0_14px_0_#0f3a5f]">
    <div class="relative h-28 border-b-4 border-ink bg-gradient-to-b from-sky-300 to-sky-100 flex items-center px-5">
        @if ($cover)
            <img src="{{ $cover }}" alt="Sampul {{ $title }}" class="h-full w-full object-cover object-[50%_45%] absolute inset-0" loading="lazy">
            <span class="pointer-events-none absolute inset-0 bg-gradient-to-t from-slate-900/60 via-slate-900/20 to-transparent"></span>
        @else
            <span class="absolute -left-6 top-5 h-16 w-16 rounded-full bg-white/60"></span>
            <span class="absolute left-14 top-3 h-10 w-10 rounded-full bg-white/60"></span>
            <span class="absolute -right-4 bottom-2 h-20 w-20 rounded-full bg-white/50"></span>
        @endif

        <div class="relative z-10 flex items-center gap-3">
            <span class="w-12 h-12 rounded-2xl border-[3px] border-ink bg-white flex items-center justify-center text-2xl shadow-[0_3px_0_#0f3a5f]">
                {{ $icon ?? '📖' }}
            </span>
        </div>

        <span class="absolute right-3 top-3 z-10 rounded-full border-[3px] border-ink px-3 py-1 text-xs font-extrabold shadow-[0_2px_0_#0f3a5f] {{ $open ? 'bg-emerald-400 text-emerald-950' : 'bg-amber-300 text-amber-950' }}">
            {{ $open ? '🔓 Dungeon terbuka!' : '🔒 Belum cukup soal' }}
        </span>
    </div>

    <div class="px-5 pb-6 pt-4 flex-1 flex flex-col justify-between">
        <div>
            <h2 class="font-display text-xl sm:text-2xl font-bold leading-tight line-clamp-2 min-h-[3rem]">{{ $title }}</h2>
            <p class="text-sm text-sky-800/70 mt-1">Jenjang {{ $level }}</p>

            <div class="mt-5 flex items-baseline justify-between text-sm text-sky-800/70">
                <span>Soal aktif terkumpul</span>
                <b class="font-display text-xl font-semibold text-ink">{{ min($total, $minTotal) }} / {{ $minTotal }}</b>
            </div>
            <div class="mt-2 h-6 overflow-hidden rounded-full border-[3px] border-ink bg-sky-100" role="progressbar" aria-label="Soal aktif"
                 aria-valuemin="0" aria-valuemax="{{ $minTotal }}" aria-valuenow="{{ min($total, $minTotal) }}">
                <div class="h-full rounded-full transition-all duration-700 {{ $pct > 0 ? 'border-r-[3px] border-ink' : '' }} {{ $open ? 'bg-emerald-400' : 'bg-amber-300' }}" style="width: {{ $pct }}%"></div>
            </div>

            <div class="mt-4 grid grid-cols-3 gap-2.5">
                @foreach ($tiers as [$name, $v, $color])
                    <div class="rounded-2xl border-[3px] border-ink px-2 py-2.5 text-center {{ $v >= $minTier ? 'bg-white' : 'bg-sky-50' }}">
                        <div class="text-xs text-sky-800/70">{{ $name }}</div>
                        <div class="font-display text-lg sm:text-xl font-semibold leading-tight">{{ $v }}<span class="text-xs text-sky-800/60">/{{ $minTier }}</span></div>
                        <div class="mt-1.5 flex justify-center gap-[3px]" aria-hidden="true">
                            @for ($i = 0; $i < $minTier; $i++)
                                <i class="h-1.5 w-1.5 rounded-full {{ $i < $v ? $color : 'bg-sky-200' }}"></i>
                            @endfor
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-5 rounded-2xl border-[3px] border-ink p-3 text-sm leading-snug {{ $open ? 'bg-emerald-100 text-emerald-900' : 'bg-amber-100 text-amber-900' }}" role="status">
                @if ($open)
                    <b>Hore, misi selesai!</b> Semua tingkat sudah terpenuhi. Dungeon siap dimainkan.
                @else
                    <b>Misi:</b>
                    @if ($total < $minTotal) kumpulkan <b>{{ $minTotal - $total }} soal lagi</b>@endif
                    @if ($total < $minTotal && $lack) dan @endif
                    @if ($lack) penuhi tingkat <b>{{ $lack }}</b>@endif
                    untuk membuka dungeon!
                    @if($alasan)
                        <div class="mt-1 text-xs text-amber-800/90 font-semibold">⚠️ {{ $alasan }}</div>
                    @endif
                @endif
            </div>
        </div>

        <div class="mt-5 grid grid-cols-2 gap-3">
            <a href="{{ $editorUrl }}" class="{{ $btn }} bg-sky-300">
                <span>{{ $hasQuiz ? '📝 Buka Editor' : '➕ Buat Kuis' }}</span>
            </a>
            @if($importOnClick)
                <button type="button" onclick="{{ $importOnClick }}" class="{{ $btn }} bg-white cursor-pointer">
                    <span>📥 Impor Kuis</span>
                </button>
            @else
                <a href="{{ $importUrl }}" class="{{ $btn }} bg-white">
                    <span>📥 Impor Kuis</span>
                </a>
            @endif
            <a href="{{ $trialUrl }}" class="{{ $btn }} col-span-2 bg-amber-300 {{ $open ? 'motion-safe:animate-pulse' : '' }}">
                <span>🛠️ Uji Coba Petualangan</span>
            </a>
        </div>
    </div>
</article>
