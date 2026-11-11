@php
    $user = auth()->user();
    $userId = $user->id_user ?? 0;
    $userName = $user->nama ?? 'Sobat Arrava';
@endphp

<!-- ================= QUIZ ONBOARDING TOUR (GUIDED BY NIERE) ================= -->
<div id="quiz-tour-overlay" style="display: none; position: fixed; inset: 0; z-index: 99990; pointer-events: auto; background: transparent;">
    <!-- Spotlight Box -->
    <div id="quiz-tour-spotlight" style="position: fixed; border-radius: 18px; box-shadow: 0 0 0 9999px rgba(10, 18, 42, 0.65), 0 0 20px rgba(56, 189, 248, 0.6); border: 2.5px solid #38bdf8; pointer-events: none; transition: top 0.35s ease, left 0.35s ease, width 0.35s ease, height 0.35s ease, opacity 0.25s ease; opacity: 0; z-index: 99991;"></div>
</div>

<!-- Tour Guide Bubble (Docked in fixed comfortable spot) -->
<div id="quiz-tour-bubble" style="display: none; position: fixed; bottom: 24px; right: 28px; z-index: 99995; width: min(340px, calc(100vw - 32px)); background: #ffffff; color: #1b2350; border: 3px solid #1b2350; border-radius: 16px; box-shadow: 5px 5px 0 #3b4fd1; font-family: 'Pixelify Sans', ui-monospace, Menlo, Consolas, monospace; padding: 14px; box-sizing: border-box; pointer-events: auto;">
    <!-- Bubble Header -->
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px; border-bottom: 1.5px dashed rgba(59,79,209,0.25); padding-bottom: 6px;">
        <div style="display: flex; align-items: center; gap: 8px;">
            <img id="quiz-tour-mascot-img" src="{{ asset('assets/niere/niereTalk.gif') }}" alt="Niere" style="width: 32px; height: 32px; object-fit: contain; image-rendering: pixelated;">
            <span style="background: #ffc83d; color: #1b2350; border: 2px solid #1b2350; border-radius: 6px; padding: 1px 7px; font-weight: 700; font-size: 12px;">
                Niere • Panduan Kuis
            </span>
        </div>
        <button type="button" id="quiz-tour-close-btn" style="background: #fee2e2; color: #991b1b; border: 2px solid #991b1b; border-radius: 6px; width: 22px; height: 22px; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: bold; cursor: pointer;" title="Tutup Panduan">
            ✕
        </button>
    </div>

    <!-- Bubble Body / Text -->
    <div id="quiz-tour-say" style="font-size: 14px; line-height: 1.45; min-height: 54px; word-break: break-word;"></div>

    <!-- Controls (Mode Tur Aktif) -->
    <div id="quiz-tour-controls" style="display: none; margin-top: 10px; padding-top: 8px; border-top: 1.5px dashed rgba(59,79,209,0.3); flex-direction: column; gap: 8px;">
        <div style="display: flex; align-items: center; justify-content: space-between; font-size: 11px; font-weight: 700; color: #4b5563;">
            <span id="quiz-tour-step-counter">Langkah 1 dari 5</span>
            <div id="quiz-tour-dots" style="display: flex; gap: 4px; align-items: center;"></div>
        </div>
        <div style="display: flex; align-items: center; justify-content: space-between; gap: 6px;">
            <button type="button" id="quiz-tour-prev-btn" style="background: #f1f5f9; color: #475569; border: 2px solid #cbd5e1; font-weight: bold; padding: 3px 8px; border-radius: 6px; cursor: pointer; font-size: 11px;">
                ← Kembali
            </button>
            <div style="display: flex; gap: 4px;">
                <button type="button" id="quiz-tour-skip-btn" style="background: #fee2e2; color: #991b1b; border: 2px solid #fca5a5; font-weight: bold; padding: 3px 7px; border-radius: 6px; cursor: pointer; font-size: 11px;">
                    Lewati
                </button>
                <button type="button" id="quiz-tour-next-btn" style="background: #007FBE; color: #ffffff; border: 2px solid #005f8e; font-weight: bold; padding: 3px 10px; border-radius: 6px; cursor: pointer; box-shadow: 1px 1px 0 #005f8e; font-size: 11px;">
                    Lanjut →
                </button>
            </div>
        </div>
    </div>

    <!-- Prompt (Tawaran awal untuk pengunjung pertama) -->
    <div id="quiz-tour-prompt" style="display: none; margin-top: 10px; padding-top: 8px; border-top: 1.5px dashed rgba(59,79,209,0.3); justify-content: flex-end; gap: 6px;">
        <button type="button" id="quiz-tour-decline-btn" style="background: #f1f5f9; color: #64748b; border: 2px solid #cbd5e1; font-weight: bold; padding: 4px 9px; border-radius: 6px; cursor: pointer; font-size: 11px;">
            Nanti Saja
        </button>
        <button type="button" id="quiz-tour-accept-btn" style="background: #007FBE; color: #ffffff; border: 2px solid #005f8e; font-weight: bold; padding: 4px 12px; border-radius: 6px; cursor: pointer; box-shadow: 1px 1px 0 #005f8e; font-size: 11px;">
            🚀 Mulai Panduan
        </button>
    </div>
</div>

<script>
(function() {
    const USER_ID = @json($userId);
    const USER_NAME = @json($userName);

    const SP = {
        talk: "{{ asset('assets/niere/niereTalk.gif') }}",
        idle: "{{ asset('assets/niere/niereIdle.gif') }}",
        shock: "{{ asset('assets/niere/niereShock.gif') }}"
    };

    const overlay = document.getElementById("quiz-tour-overlay");
    const spotlight = document.getElementById("quiz-tour-spotlight");
    const bubble = document.getElementById("quiz-tour-bubble");
    const say = document.getElementById("quiz-tour-say");
    const mascotImg = document.getElementById("quiz-tour-mascot-img");
    const closeBtn = document.getElementById("quiz-tour-close-btn");
    const controls = document.getElementById("quiz-tour-controls");
    const promptBox = document.getElementById("quiz-tour-prompt");
    const prevBtn = document.getElementById("quiz-tour-prev-btn");
    const nextBtn = document.getElementById("quiz-tour-next-btn");
    const skipBtn = document.getElementById("quiz-tour-skip-btn");
    const acceptBtn = document.getElementById("quiz-tour-accept-btn");
    const declineBtn = document.getElementById("quiz-tour-decline-btn");
    const counter = document.getElementById("quiz-tour-step-counter");
    const dotsContainer = document.getElementById("quiz-tour-dots");
    const startTourBtn = document.getElementById("btnStartQuizTour");

    if (!overlay || !bubble || !say) return;

    if (overlay.parentElement !== document.body) {
        document.body.appendChild(overlay);
    }
    if (bubble.parentElement !== document.body) {
        document.body.appendChild(bubble);
    }

    let isTourActive = false;
    let tourCurrentStep = 0;
    let activeSteps = [];
    let typeTimer = null;

    // Sound
    let muted = false;
    try {
        const appSound = localStorage.getItem('arrava_sound_enabled');
        if (appSound !== null) muted = (appSound === 'false');
    } catch (e) {}

    let actx = null;
    function wakeAudio() {
        if (!actx) {
            try {
                const AC = window.AudioContext || window.webkitAudioContext;
                if (AC) actx = new AC();
            } catch (e) {}
        }
        if (actx && actx.state === "suspended") actx.resume().catch(() => {});
    }

    function blip(freq, dur, vol, type) {
        if (muted || !actx) return;
        try {
            const now = actx.currentTime;
            const osc = actx.createOscillator();
            const gain = actx.createGain();
            osc.type = type || "sine";
            osc.frequency.setValueAtTime(freq || 440, now);
            gain.gain.setValueAtTime(vol || 0.05, now);
            gain.gain.exponentialRampToValueAtTime(0.0001, now + (dur || 0.05));
            osc.connect(gain);
            gain.connect(actx.destination);
            osc.start(now);
            osc.stop(now + (dur || 0.05));
        } catch (e) {}
    }
    function playClick() { wakeAudio(); blip(580, 0.05, 0.06, "square"); }
    function playPop(i) { wakeAudio(); blip(400 + i * 70, 0.04, 0.05, "triangle"); }
    function playTalk() { wakeAudio(); blip(320 + Math.random() * 120, 0.03, 0.03, "sine"); }

    const ALL_STEPS = [
        {
            selector: "#quiz-search-input",
            title: "Pencarian Kuis Cepat",
            text: "Ketik nama kuis atau materi yang ingin kamu latih di sini untuk menemukannya dengan cepat tanpa perlu mencari satu per satu.",
            pose: "talk"
        },
        {
            selector: "#quizFilterBar",
            title: "Penyaring Mata Pelajaran & Tingkat",
            text: "Gunakan filter ini untuk menyaring kuis berdasarkan mata pelajaran, tingkat kesulitan (Mudah, Sedang, Sulit), atau mengurutkan dari yang terbaru.",
            pose: "talk"
        },
        {
            selector: "#tourQuizCard",
            title: "Kartu Informasi Kuis",
            text: "Setiap kartu kuis menampilkan mata pelajaran, tingkat kesulitan, jenis soal, serta total poin EXP yang bisa kamu peroleh saat berhasil lulus.",
            pose: "talk"
        },
        {
            selector: "#tourQuizCard [data-quiz-start], #tourQuizCard a[href*='detail']",
            title: "Pratinjau & Memulai Kuis",
            text: "Klik tombol 'Kerjakan' untuk membuka pratinjau kuis, membaca aturan waktu, dan memasukkan token jika kuis dikunci oleh guru.",
            pose: "talk"
        },
        {
            selector: "#btnStartQuizTour",
            title: "Siap Berlatih!",
            text: "Kamu sudah siap! Pilih kuis favoritmu, kerjakan dengan teliti, dan kumpulkan EXP sebanyak mungkin untuk memuncaki peringkat. Selamat berlatih!",
            pose: "shock"
        }
    ];

    function typeWriter(text, poseName) {
        clearTimeout(typeTimer);
        say.textContent = "";
        if (mascotImg) mascotImg.src = SP[poseName] || SP.talk;

        let idx = 0;
        const len = text.length;

        function step() {
            if (idx < len) {
                say.textContent += text[idx];
                if (text[idx] !== " " && text[idx] !== "\n" && idx % 2 === 0) {
                    playTalk();
                }
                idx++;
                typeTimer = setTimeout(step, 18);
            } else {
                if (mascotImg) mascotImg.src = SP.idle;
            }
        }
        step();
    }

    function dockBubbleForQuiz(isTargetNearBottomRight) {
        bubble.style.position = "fixed";
        bubble.style.bottom = "24px";
        if (isTargetNearBottomRight) {
            bubble.style.left = "24px";
            bubble.style.right = "auto";
        } else {
            bubble.style.right = "28px";
            bubble.style.left = "auto";
        }
    }

    function startQuizTour() {
        activeSteps = ALL_STEPS.filter(st => {
            if (st.selector === "#btnStartQuizTour") return true;
            return !!document.querySelector(st.selector);
        });

        if (activeSteps.length === 0) return;

        isTourActive = true;
        tourCurrentStep = 0;

        overlay.style.display = "block";
        bubble.style.display = "block";
        if (promptBox) promptBox.style.display = "none";
        if (controls) controls.style.display = "flex";

        dockBubbleForQuiz(false);
        renderStep();
    }

    function renderStep() {
        if (!isTourActive || !activeSteps[tourCurrentStep]) return;
        const step = activeSteps[tourCurrentStep];
        const targetEl = document.querySelector(step.selector);

        if (targetEl && step.selector !== "#btnStartQuizTour") {
            targetEl.scrollIntoView({ behavior: "smooth", block: "center", inline: "nearest" });

            setTimeout(() => {
                if (!isTourActive) return;
                const rect = targetEl.getBoundingClientRect();
                const pad = 10;
                spotlight.style.top = Math.max(0, rect.top - pad) + "px";
                spotlight.style.left = Math.max(0, rect.left - pad) + "px";
                spotlight.style.width = (rect.width + pad * 2) + "px";
                spotlight.style.height = (rect.height + pad * 2) + "px";
                spotlight.style.opacity = "1";

                const isNearBottomRight = (rect.bottom > window.innerHeight * 0.52) && (rect.right > window.innerWidth * 0.52);
                dockBubbleForQuiz(isNearBottomRight);
            }, 280);
        } else {
            dockBubbleForQuiz(false);
            if (spotlight) spotlight.style.opacity = "0";
        }

        typeWriter(step.text, step.pose || "talk");

        if (counter) {
            counter.textContent = `Langkah ${tourCurrentStep + 1} dari ${activeSteps.length} • ${step.title}`;
        }

        if (dotsContainer) {
            dotsContainer.innerHTML = activeSteps.map((_, i) => {
                const active = (i === tourCurrentStep);
                return `<span style="display:inline-block; width:${active ? '14px' : '5px'}; height:5px; border-radius:3px; background:${active ? '#007FBE' : '#cbd5e1'}; transition:all 0.2s ease;"></span>`;
            }).join("");
        }

        if (prevBtn) {
            prevBtn.style.visibility = (tourCurrentStep === 0) ? "hidden" : "visible";
        }
        if (nextBtn) {
            if (tourCurrentStep === activeSteps.length - 1) {
                nextBtn.textContent = "Mulai Belajar ✓";
                nextBtn.style.background = "#059669";
                nextBtn.style.borderColor = "#047857";
            } else {
                nextBtn.textContent = "Lanjut →";
                nextBtn.style.background = "#007FBE";
                nextBtn.style.borderColor = "#005f8e";
            }
        }
    }

    function nextStep() {
        playClick();
        if (tourCurrentStep < activeSteps.length - 1) {
            tourCurrentStep++;
            renderStep();
        } else {
            finishQuizTour(true);
        }
    }

    function prevStep() {
        playClick();
        if (tourCurrentStep > 0) {
            tourCurrentStep--;
            renderStep();
        }
    }

    function finishQuizTour(completed) {
        isTourActive = false;
        overlay.style.display = "none";
        spotlight.style.opacity = "0";
        if (controls) controls.style.display = "none";

        try {
            localStorage.setItem(`arrava_tour_quiz_list_${USER_ID}`, "1");
        } catch (e) {}

        if (completed) {
            playPop(2);
            typeWriter("Selamat berlatih kuis! Kamu bisa menekan tombol '🧭 Panduan Kuis' kapan saja jika butuh panduan ini kembali. ✨", "shock");
            setTimeout(() => {
                bubble.style.display = "none";
            }, 3200);
        } else {
            bubble.style.display = "none";
        }
    }

    function checkFirstTimeQuizPrompt() {
        let tourDone = false;
        try {
            tourDone = !!localStorage.getItem(`arrava_tour_quiz_list_${USER_ID}`);
        } catch (e) {}

        if (!tourDone) {
            setTimeout(() => {
                if (isTourActive || bubble.style.display === "block") return;

                dockBubbleForQuiz(false);
                bubble.style.display = "block";
                if (controls) controls.style.display = "none";
                if (promptBox) promptBox.style.display = "flex";

                typeWriter(`Halo ${USER_NAME}! Selamat datang di Ruang Kuis Arrava. 🎯\n\nMau Niere pandu cara memilih dan memulai latihan kuis?`, "talk");
            }, 1200);
        }
    }

    // Event Listeners
    if (nextBtn) nextBtn.addEventListener("click", ev => { ev.stopPropagation(); nextStep(); });
    if (prevBtn) prevBtn.addEventListener("click", ev => { ev.stopPropagation(); prevStep(); });
    if (skipBtn) skipBtn.addEventListener("click", ev => { ev.stopPropagation(); finishQuizTour(false); });
    if (closeBtn) closeBtn.addEventListener("click", ev => { ev.stopPropagation(); finishQuizTour(false); });

    if (acceptBtn) {
        acceptBtn.addEventListener("click", ev => {
            ev.stopPropagation();
            if (promptBox) promptBox.style.display = "none";
            startQuizTour();
        });
    }

    if (declineBtn) {
        declineBtn.addEventListener("click", ev => {
            ev.stopPropagation();
            try {
                localStorage.setItem(`arrava_tour_quiz_list_${USER_ID}`, "1");
            } catch (e) {}
            bubble.style.display = "none";
        });
    }

    if (startTourBtn) {
        startTourBtn.addEventListener("click", ev => {
            ev.preventDefault();
            startQuizTour();
        });
    }

    // Keyboard support
    document.addEventListener("keydown", ev => {
        if (!isTourActive) return;
        if (ev.key === "Escape") {
            finishQuizTour(false);
        } else if (ev.key === "ArrowRight" || ev.key === "Enter") {
            ev.preventDefault();
            nextStep();
        } else if (ev.key === "ArrowLeft") {
            ev.preventDefault();
            prevStep();
        }
    });

    // Dynamic scroll tracking
    window.addEventListener("scroll", () => {
        if (!isTourActive || !activeSteps[tourCurrentStep]) return;
        const step = activeSteps[tourCurrentStep];
        if (step.selector === "#btnStartQuizTour") return;
        const targetEl = document.querySelector(step.selector);
        if (targetEl && spotlight) {
            const rect = targetEl.getBoundingClientRect();
            const pad = 10;
            spotlight.style.top = Math.max(0, rect.top - pad) + "px";
            spotlight.style.left = Math.max(0, rect.left - pad) + "px";
            spotlight.style.width = (rect.width + pad * 2) + "px";
            spotlight.style.height = (rect.height + pad * 2) + "px";
        }
    }, { passive: true });

    // Window resize
    window.addEventListener("resize", () => {
        if (isTourActive) renderStep();
    });

    // Auto-prompt on first visit
    setTimeout(checkFirstTimeQuizPrompt, 500);

    // Global hook
    window.startQuizTour = startQuizTour;
})();
</script>

