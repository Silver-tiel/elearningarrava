@props([
    'user' => null,
    'kuisLulus' => 0,
    'modulCount' => 0,
    'quizCount' => 0,
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
    $progressPercent = $rankInfo['percent'] ?? 0;
    $jenjangName = $user->jenjang->nama_jenjang ?? $user->jenjang->nama_tipe ?? 'Umum';
@endphp

<div id="samudraHeroCard"
     class="relative w-full rounded-[24px] overflow-hidden border border-[#DCEFFF] shadow-[0_8px_24px_rgba(6,32,63,0.18)] select-none min-h-[260px] flex flex-col justify-between p-4 sm:p-6"
     style="background-color: #0c4a6e;">
    <!-- 1. Background Image Bawah Laut -->
    <img src="{{ asset('assets/widget/cards/underwaterHeroSection.webp') }}"
         alt="Samudra Arrava"
         class="absolute inset-0 w-full h-full object-cover object-bottom pointer-events-none z-0"
         style="image-rendering: pixelated;">

    <!-- 2. Overlay Gradasi Cahaya Atas -->
    <div class="absolute inset-0 bg-gradient-to-b from-white/20 via-transparent to-transparent pointer-events-none z-1"></div>

    <!-- 3. Ikan-ikan Berenang Bebas & Gelembung Interaktif -->
    <div id="samudraAquarium" class="absolute inset-0 overflow-hidden pointer-events-none z-10">
        <!-- Gelembung Udara -->
        <div class="bubble bubble-1"></div>
        <div class="bubble bubble-2"></div>
        <div class="bubble bubble-3"></div>
        <div class="bubble bubble-4"></div>
        <div class="bubble bubble-5"></div>
        <div class="bubble bubble-6"></div>
        <div class="bubble bubble-7"></div>
    </div>

    <!-- 4. Konten Menimpa Bagian Atas: Profil Siswa & Peleburan Kartu Peringkat & EXP -->
    <div class="relative z-20 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <!-- Kiri: Info Profil Siswa -->
        <div class="flex items-center gap-3.5 min-w-0">
            <a href="{{ route('siswa.profil') }}" class="group relative block shrink-0" title="Buka Profil Siswa">
                <div class="h-14 w-14 sm:h-16 sm:w-16 rounded-full p-[2.5px] bg-white shadow-lg ring-2 ring-white/70 transition duration-200 group-hover:scale-105">
                    <div class="h-full w-full rounded-full overflow-hidden bg-gradient-to-tr from-[#007FBE] to-[#51CDF4] flex items-center justify-center text-white font-bold">
                        @if(!empty($user->foto_profil_url))
                            <img src="{{ $user->foto_profil_url }}"
                                 alt="Foto profil {{ $user->nama ?? 'Siswa' }}"
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
                    <h2 class="text-base sm:text-lg font-extrabold text-white leading-tight truncate drop-shadow-[0_2px_4px_rgba(0,0,0,0.65)]">
                        {{ $user->nama ?? 'Siswa Arrava' }}
                    </h2>
                    <span class="inline-flex items-center gap-1 rounded-full bg-[#D1FAE5] px-2 py-0.5 text-[10.5px] font-bold text-[#047857] shadow-sm border border-emerald-300">
                        <svg class="w-3 h-3 text-[#059669]" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ $jenjangName }}</span>
                    </span>
                </div>
                <p class="mt-1 text-xs font-semibold text-white/95 drop-shadow-[0_1px_3px_rgba(0,0,0,0.7)] flex items-center gap-2 flex-wrap">
                    <span class="inline-flex items-center gap-1 bg-white/20 backdrop-blur-sm px-2 py-0.5 rounded-md border border-white/25">
                        <span>Level:</span> <strong>{{ $rankInfo['current_rank'] }}</strong>
                    </span>
                    <span>•</span>
                    <span>{{ $kuisLulus }} Kuis Selesai</span>
                    <span>•</span>
                    <span>{{ $modulCount }} Modul</span>
                </p>
            </div>
        </div>

        <!-- Kanan: Peleburan Kartu Peringkat & EXP (Glassmorphic) -->
        <div class="w-full lg:w-auto lg:min-w-[360px] xl:min-w-[400px] rounded-2xl bg-white/15 backdrop-blur-md border border-white/25 p-3.5 sm:p-4 text-white shadow-lg">
            <div class="flex items-center justify-between gap-2">
                <span class="text-[11px] font-black uppercase tracking-wider text-white/80">Peringkat &amp; EXP</span>
                <a href="{{ route('siswa.leaderboard') }}"
                   class="inline-flex items-center gap-1.5 rounded-full bg-white/95 backdrop-blur-sm px-2.5 py-0.5 text-xs font-extrabold text-[#B45309] border border-white/60 hover:bg-white transition shadow-xs"
                   title="Lihat Papan Peringkat">
                    @if($rankInfo['current_badge_url'])
                        <img src="{{ $rankInfo['current_badge_url'] }}" alt="{{ $rankInfo['current_rank'] }}" class="h-3.5 w-3.5 object-contain">
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
                <img src="{{ asset('assets/widget/exp.png') }}"
                     alt="EXP"
                     title="EXP Poin"
                     class="h-5 w-5 shrink-0 object-contain select-none"
                     style="image-rendering: pixelated;">

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
            <div class="mt-2.5 flex items-center justify-between border-t border-white/20 pt-2 text-[11px] font-bold text-white/90">
                @if($rankInfo['is_max'])
                    <span class="text-emerald-300">Hebat! Semua tingkat terbuka.</span>
                @else
                    <span>Sisa <strong class="text-white">{{ number_format($rankInfo['points_needed']) }} EXP</strong> lagi</span>
                @endif
                <a href="{{ route('siswa.leaderboard') }}" class="font-extrabold text-amber-300 hover:text-white hover:underline flex items-center gap-1 transition">
                    <span>Lihat leaderboard</span>
                    <span>→</span>
                </a>
            </div>
        </div>
    </div>

    <!-- 5. Konten Menimpa Bagian Bawah: Sapaan Hangat & Quick Shortcuts -->
    <div class="relative z-20 mt-4 sm:mt-6 pt-3 sm:pt-4 flex flex-wrap items-end justify-between gap-4 border-t border-white/15">
        <div class="max-w-md">
            <h1 class="text-lg sm:text-xl font-heading font-black text-white leading-tight drop-shadow-[0_2px_4px_rgba(0,0,0,0.7)]">
                Halo, {{ $user->nama ?? 'Siswa' }} 👋
            </h1>
            <p class="mt-0.5 text-xs sm:text-sm font-medium text-white/90 drop-shadow-[0_1px_2px_rgba(0,0,0,0.6)]">
                Jelajahi materi interaktif, taklukkan kuis seru, dan raih peringkat teratas!
            </p>
        </div>

        <div class="flex items-center gap-2.5">
            <a href="{{ route('siswa.modul') }}"
               class="inline-flex items-center gap-2 rounded-full bg-white/95 backdrop-blur-sm px-4 py-2 text-xs font-extrabold text-[#007FBE] shadow-md border border-white/60 hover:bg-white transition hover:-translate-y-0.5">
                <svg class="w-4 h-4 text-[#007FBE]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 16.5 5c1.747 0 3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <span>Mulai Belajar</span>
            </a>
            <a href="{{ route('siswa.quiz') }}"
               class="inline-flex items-center gap-2 rounded-full bg-[#007FBE] px-4 py-2 text-xs font-extrabold text-white shadow-[0_3px_0_#00628E] border border-[#00628E] hover:bg-[#00628E] transition active:translate-y-0.5 active:shadow-none">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>Latihan Kuis</span>
            </a>
        </div>
    </div>
</div>

<style>
/* CSS Gelembung Udara Samudra */
.bubble {
    position: absolute;
    bottom: -20px;
    background: radial-gradient(circle at 30% 30%, rgba(255, 255, 255, 0.8), rgba(255, 255, 255, 0.2) 60%, rgba(255, 255, 255, 0.05) 100%);
    border: 1px solid rgba(255, 255, 255, 0.4);
    border-radius: 50%;
    pointer-events: none;
    animation: bubbleRise linear infinite;
}
.bubble-1 { width: 14px; height: 14px; left: 12%; animation-duration: 7s; animation-delay: 0s; }
.bubble-2 { width: 8px; height: 8px; left: 28%; animation-duration: 9s; animation-delay: 2s; }
.bubble-3 { width: 16px; height: 16px; left: 45%; animation-duration: 6.5s; animation-delay: 1.5s; }
.bubble-4 { width: 10px; height: 10px; left: 62%; animation-duration: 8s; animation-delay: 3s; }
.bubble-5 { width: 12px; height: 12px; left: 75%; animation-duration: 7.2s; animation-delay: 0.8s; }
.bubble-6 { width: 7px; height: 7px; left: 88%; animation-duration: 9.5s; animation-delay: 4s; }
.bubble-7 { width: 15px; height: 15px; left: 93%; animation-duration: 6.8s; animation-delay: 2.2s; }

@keyframes bubbleRise {
    0% {
        transform: translateY(0) translateX(0);
        opacity: 0;
    }
    15% {
        opacity: 0.7;
    }
    50% {
        transform: translateY(-120px) translateX(8px);
    }
    100% {
        transform: translateY(-300px) translateX(-8px);
        opacity: 0;
    }
}

/* Fish animation styling */
.samudra-fish {
    position: absolute;
    pointer-events: auto;
    cursor: pointer;
    image-rendering: pixelated;
    transition: transform 0.2s cubic-bezier(0.2, 0.8, 0.2, 1);
    filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.25));
}
</style>

<script>
(function() {
    const hero = document.getElementById('samudraHeroCard');
    const aquarium = document.getElementById('samudraAquarium');
    if (!hero || !aquarium) return;

    const fishData = [
        { src: '{{ asset("assets/widget/cards/fish1.webp") }}', size: 36, speed: 28, yRatio: 0.38 },
        { src: '{{ asset("assets/widget/cards/fish2.webp") }}', size: 32, speed: 34, yRatio: 0.52 },
        { src: '{{ asset("assets/widget/cards/fish3.webp") }}', size: 48, speed: 22, yRatio: 0.44 },
        { src: '{{ asset("assets/widget/cards/fish4.webp") }}', size: 34, speed: 32, yRatio: 0.65 },
        { src: '{{ asset("assets/widget/cards/fish5.webp") }}', size: 38, speed: 26, yRatio: 0.72 },
        { src: '{{ asset("assets/widget/cards/fish6.webp") }}', size: 42, speed: 24, yRatio: 0.48 },
        { src: '{{ asset("assets/widget/cards/fish7.webp") }}', size: 46, speed: 25, yRatio: 0.58 },
        { src: '{{ asset("assets/widget/cards/fish8.webp") }}', size: 35, speed: 30, yRatio: 0.62 },
        { src: '{{ asset("assets/widget/cards/fish9.webp") }}', size: 36, speed: 27, yRatio: 0.40 },
    ];

    const fishElements = [];

    fishData.forEach((data, index) => {
        const img = document.createElement('img');
        img.src = data.src;
        img.className = 'samudra-fish';
        img.style.width = data.size + 'px';
        img.style.height = 'auto';

        const dir = (index % 2 === 0) ? 1 : -1;
        const initialX = Math.random() * (aquarium.clientWidth || 600);
        const initialY = (aquarium.clientHeight || 260) * data.yRatio + (Math.random() * 20 - 10);

        const fishState = {
            el: img,
            x: initialX,
            y: initialY,
            dir: dir,
            speed: data.speed,
            baseSpeed: data.speed,
            yBase: initialY,
            phase: Math.random() * Math.PI * 2,
            fleeTimeout: null,
        };

        img.style.transform = `translate(${fishState.x}px, ${fishState.y}px) scaleX(${fishState.dir})`;
        aquarium.appendChild(img);
        fishElements.push(fishState);
    });

    let lastTime = performance.now();

    function loop(currentTime) {
        const dt = Math.min((currentTime - lastTime) / 1000, 0.1);
        lastTime = currentTime;

        const containerW = aquarium.clientWidth || 800;
        const containerH = aquarium.clientHeight || 260;

        fishElements.forEach(f => {
            // Renang horizontal
            f.x += f.dir * f.speed * dt;

            // Berbalik arah saat menabrak batas
            if (f.x > containerW - 40 && f.dir > 0) {
                f.dir = -1;
            } else if (f.x < 10 && f.dir < 0) {
                f.dir = 1;
            }

            // Gerak vertikal bergelombang alami (bobbing)
            f.phase += dt * 2.2;
            const bobbing = Math.sin(f.phase) * 6;
            const currentY = Math.max(70, Math.min(containerH - 50, f.yBase + bobbing));

            f.el.style.transform = `translate(${f.x}px, ${currentY}px) scaleX(${f.dir})`;
        });

        requestAnimationFrame(loop);
    }

    requestAnimationFrame(loop);

    // Efek Kaget / Kabur saat cursor mendekati ikan
    hero.addEventListener('mousemove', (e) => {
        const rect = aquarium.getBoundingClientRect();
        const mouseX = e.clientX - rect.left;
        const mouseY = e.clientY - rect.top;

        fishElements.forEach(f => {
            const dx = f.x - mouseX;
            const dy = f.y - mouseY;
            const dist = Math.sqrt(dx * dx + dy * dy);

            if (dist < 90) {
                // Kabur menjauhi mouse
                f.dir = dx >= 0 ? 1 : -1;
                f.speed = f.baseSpeed * 3;

                clearTimeout(f.fleeTimeout);
                f.fleeTimeout = setTimeout(() => {
                    f.speed = f.baseSpeed;
                }, 1200);
            }
        });
    });
})();
</script>

