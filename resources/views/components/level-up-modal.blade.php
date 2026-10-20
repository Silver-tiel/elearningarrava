@php
    $rankUp = session('rank_up');

    // Fitur preview untuk testing / demonstrasi (lewat URL ?preview_levelup=1)
    if (!$rankUp && request()->has('preview_levelup')) {
        $currentUser = Auth::user();
        $userRank = $currentUser ? $currentUser->rank_tier : [
            'current_rank' => 'Upper Beginner',
            'current_badge_url' => asset('storage/achievements/upper_beginner.png'),
            'current_points' => 150,
        ];
        $rankUp = [
            'old_rank' => 'Lower Beginner',
            'new_rank' => $userRank['current_rank'] ?: 'Upper Beginner',
            'badge_url' => $userRank['current_badge_url'] ?: asset('storage/achievements/upper_beginner.png'),
            'poin' => $userRank['current_points'] ?? 150,
            'poin_diberikan' => 50,
        ];
    }
@endphp

<!-- Modal Pop-up Animasi Level Up -->
<div id="levelUpModal"
     class="{{ $rankUp ? 'flex' : 'hidden' }} fixed inset-0 z-[999999] items-center justify-center p-4 bg-slate-950/80 backdrop-blur-md transition-all duration-300 select-none"
     role="dialog"
     aria-modal="true"
     aria-labelledby="rankUpTitle">

    <!-- Canvas Konfeti Perayaan -->
    <canvas id="rankUpConfettiCanvas" class="pointer-events-none absolute inset-0 h-full w-full z-0"></canvas>

    <!-- Kartu Konten Modal -->
    <div id="levelUpModalCard" class="relative z-10 w-full max-w-lg overflow-hidden rounded-3xl border-2 border-amber-400/50 bg-gradient-to-b from-slate-900 via-[#141b2d] to-[#0a0d16] p-6 sm:p-8 text-center shadow-[0_0_50px_rgba(245,158,11,0.25)] transition-all duration-300 transform scale-95 opacity-0">

        <!-- Background Glow Light Effects -->
        <div class="pointer-events-none absolute -top-24 left-1/2 h-72 w-72 -translate-x-1/2 rounded-full bg-amber-500/30 blur-3xl"></div>
        <div class="pointer-events-none absolute top-1/2 left-1/2 h-80 w-80 -translate-x-1/2 -translate-y-1/2 rounded-full bg-blue-500/15 blur-3xl"></div>

        <!-- Tombol Tutup (X) -->
        <button type="button"
                onclick="closeLevelUpModal()"
                class="absolute top-4 right-4 z-20 flex h-9 w-9 items-center justify-center rounded-full bg-white/10 text-white/70 hover:bg-white/20 hover:text-white transition focus:outline-none"
                aria-label="Tutup">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <!-- ======================================================== -->
        <!-- 1. POP UP RANK YANG DIDAPAT (DI ATAS ANIMASI)             -->
        <!-- ======================================================== -->
        <div class="relative z-10 flex flex-col items-center">
            <!-- Badge Pill "LEVEL UP!" Bersinar -->
            <div class="inline-flex items-center gap-2 rounded-full border border-amber-400/60 bg-gradient-to-r from-amber-500/25 via-yellow-400/30 to-amber-500/25 px-4 py-1 text-xs font-black tracking-widest text-amber-300 shadow-sm shadow-amber-500/30 uppercase animate-pulse">
                <span>✦</span>
                <span>LEVEL UP! RANK BARU TERBUKA</span>
                <span>✦</span>
            </div>

            <!-- Pop up Box Rank yang Diraih -->
            <div class="mt-4 flex items-center justify-center gap-3 sm:gap-4 rounded-2xl bg-white/10 px-5 py-3 border border-amber-300/30 shadow-inner backdrop-blur-sm">
                <img id="rankUpBadgeImg"
                     src="{{ $rankUp['badge_url'] ?? '' }}"
                     alt="Badge"
                     class="{{ empty($rankUp['badge_url']) ? 'hidden' : '' }} h-12 w-12 sm:h-14 sm:w-14 shrink-0 rounded-xl object-contain bg-white/10 p-1 ring-2 ring-amber-400/80 shadow-md">
                
                <div class="text-left">
                    <p class="text-[11px] font-bold uppercase tracking-wider text-amber-300/90">Peringkat Kamu Sekarang</p>
                    <h2 id="rankUpTitle" class="text-xl sm:text-2xl font-black tracking-tight text-white drop-shadow">
                        <span id="rankUpNewRankText" class="bg-gradient-to-r from-amber-200 via-yellow-200 to-amber-400 bg-clip-text text-transparent">
                            {{ $rankUp['new_rank'] ?? 'Peringkat Baru' }}
                        </span>
                    </h2>
                </div>
            </div>

            <!-- Keterangan Transisi Rank -->
            <p id="rankUpSubtitle" class="mt-2 text-xs text-slate-300">
                @if(!empty($rankUp['old_rank']))
                    Naik pangkat dari <span class="text-slate-400 line-through">{{ $rankUp['old_rank'] }}</span> menjadi <strong class="text-amber-300">{{ $rankUp['new_rank'] }}</strong>!
                @else
                    Selamat atas pencapaian tingkat belajar terbarumu!
                @endif
            </p>
        </div>

        <!-- ======================================================== -->
        <!-- 2. ANIMASI LEVEL UP BESAR (DI TENGAH)                    -->
        <!-- ======================================================== -->
        <div class="relative z-10 my-4 sm:my-6 flex items-center justify-center">
            <div class="relative">
                <!-- Aura Efek Radial Glow Emas -->
                <div class="absolute inset-0 rounded-full bg-gradient-to-tr from-amber-500/40 via-yellow-400/30 to-amber-600/40 blur-2xl transform scale-125 pointer-events-none"></div>

                <!-- GIF Animasi Level Up Pixel-Art Besar -->
                <img src="{{ asset('assets/levelUp/littleLevelUp.gif') }}"
                     alt="Animasi Level Up"
                     class="relative z-10 h-48 w-48 sm:h-60 sm:w-60 object-contain select-none transition-transform duration-300 hover:scale-105 filter drop-shadow-[0_10px_20px_rgba(245,158,11,0.3)]"
                     style="image-rendering: pixelated;">
            </div>
        </div>

        <!-- ======================================================== -->
        <!-- 3. FOOTER: REKAP EXP & TOMBOL LANJUTKAN                 -->
        <!-- ======================================================== -->
        <div class="relative z-10 flex flex-col items-center">
            <div class="mb-5 inline-flex items-center gap-2 rounded-xl bg-white/5 px-4 py-2 border border-white/10 text-xs sm:text-sm text-slate-300 shadow-sm">
                <img src="{{ asset('assets/widget/exp.png') }}"
                     alt="EXP"
                     class="h-5 w-5 object-contain"
                     style="image-rendering: pixelated;">
                <span>Total Akumulasi: <strong id="rankUpPoinText" class="text-amber-300 font-bold">{{ isset($rankUp['poin']) ? number_format($rankUp['poin']) : '0' }} EXP</strong></span>
                <span id="rankUpPoinBonusBadge" class="{{ empty($rankUp['poin_diberikan']) ? 'hidden' : '' }} rounded bg-emerald-500/20 px-1.5 py-0.5 text-[11px] font-bold text-emerald-400">
                    +<span id="rankUpPoinBonusText">{{ $rankUp['poin_diberikan'] ?? 0 }}</span> EXP
                </span>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto">
                <button type="button"
                        onclick="closeLevelUpModal()"
                        class="w-full sm:w-auto px-7 py-3 rounded-xl bg-gradient-to-r from-amber-400 via-amber-500 to-orange-500 hover:from-amber-300 hover:to-orange-400 text-slate-950 font-black text-sm shadow-lg shadow-amber-500/30 transition transform hover:-translate-y-0.5 active:translate-y-0 cursor-pointer">
                    Keren, Lanjutkan Belajar! 🚀
                </button>

                <a href="{{ route('siswa.profil') }}"
                   class="w-full sm:w-auto px-5 py-3 rounded-xl bg-white/10 hover:bg-white/15 text-white font-semibold text-sm transition">
                    Lihat di Profil →
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    (function() {
        let confettiInterval = null;

        function launchConfetti() {
            const canvas = document.getElementById('rankUpConfettiCanvas');
            if (!canvas) return;
            const ctx = canvas.getContext('2d');
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;

            const particles = [];
            const colors = ['#f59e0b', '#fbbf24', '#fef08a', '#10b981', '#38bdf8', '#a855f7', '#ffffff'];

            for (let i = 0; i < 90; i++) {
                particles.push({
                    x: canvas.width / 2 + (Math.random() - 0.5) * 100,
                    y: canvas.height / 2 + (Math.random() - 0.5) * 60,
                    vx: (Math.random() - 0.5) * 14,
                    vy: (Math.random() - 0.8) * 14,
                    size: Math.random() * 8 + 4,
                    color: colors[Math.floor(Math.random() * colors.length)],
                    rotation: Math.random() * 360,
                    rotationSpeed: (Math.random() - 0.5) * 8,
                    gravity: 0.28,
                    alpha: 1,
                    decay: Math.random() * 0.008 + 0.004
                });
            }

            function animateConfetti() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                let alive = 0;

                particles.forEach(p => {
                    p.x += p.vx;
                    p.y += p.vy;
                    p.vy += p.gravity;
                    p.rotation += p.rotationSpeed;
                    p.alpha -= p.decay;

                    if (p.alpha > 0) {
                        alive++;
                        ctx.save();
                        ctx.globalAlpha = Math.max(0, p.alpha);
                        ctx.translate(p.x, p.y);
                        ctx.rotate((p.rotation * Math.PI) / 180);
                        ctx.fillStyle = p.color;
                        ctx.fillRect(-p.size / 2, -p.size / 2, p.size, p.size * 0.7);
                        ctx.restore();
                    }
                });

                if (alive > 0) {
                    confettiInterval = requestAnimationFrame(animateConfetti);
                } else {
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                }
            }

            if (confettiInterval) cancelAnimationFrame(confettiInterval);
            animateConfetti();
        }

        window.showRankUpModal = function(data) {
            const modal = document.getElementById('levelUpModal');
            const card = document.getElementById('levelUpModalCard');
            if (!modal || !card) return;

            if (data) {
                if (data.new_rank) {
                    const el = document.getElementById('rankUpNewRankText');
                    if (el) el.textContent = data.new_rank;
                }
                if (data.old_rank) {
                    const sub = document.getElementById('rankUpSubtitle');
                    if (sub) {
                        sub.innerHTML = `Naik pangkat dari <span class="text-slate-400 line-through">${data.old_rank}</span> menjadi <strong class="text-amber-300">${data.new_rank || ''}</strong>!`;
                    }
                }
                if (data.badge_url) {
                    const badge = document.getElementById('rankUpBadgeImg');
                    if (badge) {
                        badge.src = data.badge_url;
                        badge.classList.remove('hidden');
                    }
                }
                if (typeof data.poin !== 'undefined') {
                    const poinText = document.getElementById('rankUpPoinText');
                    if (poinText) poinText.textContent = `${Number(data.poin).toLocaleString('id-ID')} EXP`;
                }
                if (data.poin_diberikan) {
                    const bonusBadge = document.getElementById('rankUpPoinBonusBadge');
                    const bonusText = document.getElementById('rankUpPoinBonusText');
                    if (bonusBadge && bonusText) {
                        bonusText.textContent = data.poin_diberikan;
                        bonusBadge.classList.remove('hidden');
                    }
                }
            }

            modal.classList.remove('hidden');
            modal.classList.add('flex');

            // Trigger animasi masuk
            requestAnimationFrame(() => {
                card.classList.remove('scale-95', 'opacity-0');
                card.classList.add('scale-100', 'opacity-100');
                launchConfetti();
            });

            document.body.classList.add('overflow-hidden');
        };

        window.closeLevelUpModal = function() {
            const modal = document.getElementById('levelUpModal');
            const card = document.getElementById('levelUpModalCard');
            if (!modal || !card) return;

            card.classList.remove('scale-100', 'opacity-100');
            card.classList.add('scale-95', 'opacity-0');

            setTimeout(() => {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
                if (confettiInterval) cancelAnimationFrame(confettiInterval);
                const canvas = document.getElementById('rankUpConfettiCanvas');
                if (canvas) {
                    const ctx = canvas.getContext('2d');
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                }
            }, 250);
        };

        // Tutup saat klik backdrop
        document.addEventListener('click', function(e) {
            const modal = document.getElementById('levelUpModal');
            if (modal && e.target === modal) {
                closeLevelUpModal();
            }
        });

        // Tutup saat tombol Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const modal = document.getElementById('levelUpModal');
                if (modal && !modal.classList.contains('hidden')) {
                    closeLevelUpModal();
                }
            }
        });

        // Buka otomatis jika session atau URL preview ada
        @if($rankUp)
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(() => {
                    window.showRankUpModal();
                }, 300);
            });
        @endif
    })();
</script>
