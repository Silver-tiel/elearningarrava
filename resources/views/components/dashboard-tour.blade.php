@props([
    'role' => 'siswa', // 'siswa' atau 'orangtua'
])

@php
    $user = auth()->user();
    $userId = $user->id_user ?? 0;
    $userName = $user->nama ?? 'Sobat Arrava';
@endphp

<!-- ================= DASHBOARD ONBOARDING TOUR (MANDIRI / TANPA MASKOT NIERE) ================= -->
<div id="dashboard-tour-overlay" style="display: none; position: fixed; inset: 0; z-index: 99990; pointer-events: auto; background: transparent;">
    <!-- Spotlight Box -->
    <div id="dashboard-tour-spotlight" style="position: fixed; border-radius: 18px; box-shadow: 0 0 0 9999px rgba(10, 18, 42, 0.68), 0 0 20px rgba(56, 189, 248, 0.6); border: 2.5px solid #38bdf8; pointer-events: none; transition: top 0.35s ease, left 0.35s ease, width 0.35s ease, height 0.35s ease, opacity 0.25s ease; opacity: 0; z-index: 99991;"></div>
</div>

<!-- Tour Guide Card (Docked in fixed comfortable spot) -->
<div id="dashboard-tour-card" style="display: none; position: fixed; bottom: 24px; right: 28px; z-index: 99995; width: min(360px, calc(100vw - 32px)); background: #ffffff; color: #1b2350; border: 3px solid #1b2350; border-radius: 18px; box-shadow: 5px 5px 0 #3b4fd1; padding: 16px; box-sizing: border-box; pointer-events: auto; font-family: ui-sans-serif, system-ui, -apple-system, sans-serif;">
    
    <!-- Header Card -->
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px; border-bottom: 1.5px dashed rgba(59,79,209,0.25); padding-bottom: 8px;">
        <div style="display: flex; align-items: center; gap: 8px;">
            <span style="display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; border-radius: 8px; background: #E0F2FE; color: #0284C7; font-size: 15px; border: 1.5px solid #BAE6FD;">
                🧭
            </span>
            <span style="background: #ffc83d; color: #1b2350; border: 2px solid #1b2350; border-radius: 6px; padding: 2px 8px; font-weight: 800; font-size: 11px; letter-spacing: 0.02em;">
                Panduan Dashboard
            </span>
        </div>
        <button type="button" id="dashboard-tour-close-btn" style="background: #fee2e2; color: #991b1b; border: 2px solid #991b1b; border-radius: 8px; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: bold; cursor: pointer; transition: all 0.15s;" title="Tutup Panduan">
            ✕
        </button>
    </div>

    <!-- Body / Title & Description -->
    <div style="min-height: 64px;">
        <h4 id="dashboard-tour-title" style="font-size: 14px; font-weight: 800; color: #082765; margin: 0 0 4px 0; line-height: 1.3;">
            Judul Langkah
        </h4>
        <div id="dashboard-tour-say" style="font-size: 13px; line-height: 1.5; color: #465673; word-break: break-word;"></div>
    </div>

    <!-- Controls (Mode Tur Aktif) -->
    <div id="dashboard-tour-controls" style="display: none; margin-top: 12px; padding-top: 10px; border-top: 1.5px dashed rgba(59,79,209,0.25); flex-direction: column; gap: 8px;">
        <div style="display: flex; align-items: center; justify-content: space-between; font-size: 11px; font-weight: 700; color: #64748b;">
            <span id="dashboard-tour-step-counter">Langkah 1 dari 6</span>
            <div id="dashboard-tour-dots" style="display: flex; gap: 4px; align-items: center;"></div>
        </div>
        <div style="display: flex; align-items: center; justify-content: space-between; gap: 6px;">
            <button type="button" id="dashboard-tour-prev-btn" style="background: #f1f5f9; color: #475569; border: 2px solid #cbd5e1; font-weight: bold; padding: 4px 10px; border-radius: 8px; cursor: pointer; font-size: 11px; transition: all 0.15s;">
                ← Kembali
            </button>
            <div style="display: flex; gap: 6px;">
                <button type="button" id="dashboard-tour-skip-btn" style="background: #fee2e2; color: #991b1b; border: 2px solid #fca5a5; font-weight: bold; padding: 4px 9px; border-radius: 8px; cursor: pointer; font-size: 11px; transition: all 0.15s;">
                    Lewati
                </button>
                <button type="button" id="dashboard-tour-next-btn" style="background: #007FBE; color: #ffffff; border: 2px solid #005f8e; font-weight: bold; padding: 4px 14px; border-radius: 8px; cursor: pointer; box-shadow: 1px 1px 0 #005f8e; font-size: 11px; transition: all 0.15s;">
                    Lanjut →
                </button>
            </div>
        </div>
    </div>

    <!-- Prompt (Tawaran awal untuk pengunjung pertama) -->
    <div id="dashboard-tour-prompt" style="display: none; margin-top: 12px; padding-top: 10px; border-top: 1.5px dashed rgba(59,79,209,0.25); justify-content: flex-end; gap: 6px;">
        <button type="button" id="dashboard-tour-decline-btn" style="background: #f1f5f9; color: #64748b; border: 2px solid #cbd5e1; font-weight: bold; padding: 5px 11px; border-radius: 8px; cursor: pointer; font-size: 11px; transition: all 0.15s;">
            Nanti Saja
        </button>
        <button type="button" id="dashboard-tour-accept-btn" style="background: #007FBE; color: #ffffff; border: 2px solid #005f8e; font-weight: bold; padding: 5px 14px; border-radius: 8px; cursor: pointer; box-shadow: 1px 1px 0 #005f8e; font-size: 11px; transition: all 0.15s;">
            🚀 Mulai Panduan
        </button>
    </div>
</div>

<script>
(function() {
    const ROLE = @json($role);
    const USER_ID = @json($userId);
    const USER_NAME = @json($userName);

    const TOUR_CONFIGS = {
        siswa: [
            {
                selector: "#samudraHeroCard, #galaksiHeroCard",
                title: "Profil & Progres EXP",
                text: "Ini area profil belajarmu! Di sini kamu bisa melihat identitas jenjang sekolah dan bilah capaian EXP. Selesaikan kuis dan modul untuk terus mengumpulkan EXP!",
            },
            {
                selector: "#tourMenuPintasan",
                title: "Menu Pintasan Cepat",
                text: "Akses cepat untuk membuka Modul Belajar, Kuis Latihan, kartu Presensi QR kelas, hingga Papan Peringkat se-jenjang.",
            },
            {
                selector: "#tourMateriModul",
                title: "Materi & Modul Belajar",
                text: "Daftar materi pelajaran digital yang disiapkan guru, mulai dari video interaktif hingga dokumen panduan PDF.",
            },
            {
                selector: "#tourRiwayatKuis",
                title: "Riwayat Latihan & Kuis",
                text: "Catatan lengkap kuis yang sudah pernah kamu kerjakan, nilai kelulusan, dan tanggal pengerjaannya.",
            },
            {
                selector: "#mainSidebar",
                title: "Menu Navigasi Utama",
                text: "Gunakan bilah menu samping untuk berpindah antar halaman: Dashboard, Belajar, Kuis, Peringkat, dan Pengaturan Profil.",
            },
            {
                selector: "#notifikasiPresensiRoot",
                title: "Lonceng Notifikasi Presensi",
                text: "Ikon lonceng ini akan memberitahumu saat guru membuka sesi presensi kelas atau ada pengumuman baru.",
            },
            {
                selector: "#btnStartDashboardTour",
                title: "Selamat Belajar! 🚀",
                text: "Pengenalan selesai! Kamu sudah siap menggunakan Arrava. Tombol panduan 🧭 di pojok atas siap membantumu kapan saja jika ingin mengulang tur ini.",
            }
        ],
        orangtua: [
            {
                selector: "#tourOtStudentCard",
                title: "Profil Siswa & Pilihan Anak",
                text: "Kartu informasi ananda. Jika Ayah/Bunda memiliki lebih dari satu anak terdaftar di Arrava, Anda dapat beralih profil dengan mudah melalui kartu ini.",
            },
            {
                selector: "#tourOtStats",
                title: "Ringkasan Akademik Ananda",
                text: "Pantau tiga ringkasan utama perkembangan belajar: jumlah kuis yang dikerjakan, modul yang telah selesai dipelajari, dan rata-rata nilai ananda.",
            },
            {
                selector: "#tourOtAktivitas",
                title: "Aktivitas Belajar Terbaru",
                text: "Memantau hasil pengerjaan kuis terbaru ananda, lengkap dengan tanggal, perolehan nilai, dan status kelulusan.",
            },
            {
                selector: "#tourOtPerhatian",
                title: "Catatan Pendampingan",
                text: "Area saran dan masukan pendampingan belajar jika ananda membutuhkan perhatian khusus atau latihan tambahan.",
            },
            {
                selector: "#otSidebar",
                title: "Navigasi Portal Orang Tua",
                text: "Gunakan menu navigasi untuk melihat perkembangan nilai, modul materi, riwayat kuis, dan informasi akun.",
            },
            {
                selector: "#notifikasiPresensiRoot",
                title: "Lonceng Notifikasi Presensi",
                text: "Lonceng ini memberikan pemberitahuan langsung setiap kali ananda tercatat hadir atau guru memperbarui catatan kelas.",
            },
            {
                selector: "#btnStartDashboardTour",
                title: "Siap Mendampingi Ananda! 🌟",
                text: "Panduan selesai! Ayah/Bunda siap memantau perkembangan belajar ananda. Tombol 🧭 di pojok atas dapat diklik kapan saja untuk mengulang tur ini.",
            }
        ]
    };

    const overlay = document.getElementById("dashboard-tour-overlay");
    const spotlight = document.getElementById("dashboard-tour-spotlight");
    const card = document.getElementById("dashboard-tour-card");
    const titleEl = document.getElementById("dashboard-tour-title");
    const sayEl = document.getElementById("dashboard-tour-say");
    const closeBtn = document.getElementById("dashboard-tour-close-btn");
    const controls = document.getElementById("dashboard-tour-controls");
    const promptBox = document.getElementById("dashboard-tour-prompt");
    const prevBtn = document.getElementById("dashboard-tour-prev-btn");
    const nextBtn = document.getElementById("dashboard-tour-next-btn");
    const skipBtn = document.getElementById("dashboard-tour-skip-btn");
    const acceptBtn = document.getElementById("dashboard-tour-accept-btn");
    const declineBtn = document.getElementById("dashboard-tour-decline-btn");
    const counter = document.getElementById("dashboard-tour-step-counter");
    const dotsContainer = document.getElementById("dashboard-tour-dots");

    if (!overlay || !card || !sayEl) return;

    if (overlay.parentElement !== document.body) {
        document.body.appendChild(overlay);
    }
    if (card.parentElement !== document.body) {
        document.body.appendChild(card);
    }

    let isTourActive = false;
    let tourCurrentStep = 0;
    let activeSteps = [];
    const storageKey = `arrava_dashboard_tour_v2_${USER_ID}_${ROLE}`;

    function dockCard(isNearBottomRight) {
        card.style.position = "fixed";
        card.style.bottom = "24px";
        if (isNearBottomRight) {
            card.style.left = "24px";
            card.style.right = "auto";
        } else {
            card.style.right = "28px";
            card.style.left = "auto";
        }
    }

    function renderStep() {
        if (!isTourActive || !activeSteps[tourCurrentStep]) return;
        const step = activeSteps[tourCurrentStep];
        const targetEl = document.querySelector(step.selector);

        if (targetEl && step.selector !== "#btnStartDashboardTour") {
            targetEl.scrollIntoView({ behavior: "smooth", block: "center", inline: "nearest" });

            setTimeout(() => {
                if (!isTourActive) return;
                const rect = targetEl.getBoundingClientRect();
                const pad = 10;
                const top = Math.max(0, rect.top - pad);
                const left = Math.max(0, rect.left - pad);
                const w = rect.width + pad * 2;
                const h = rect.height + pad * 2;

                if (spotlight) {
                    spotlight.style.top = top + "px";
                    spotlight.style.left = left + "px";
                    spotlight.style.width = w + "px";
                    spotlight.style.height = h + "px";
                    spotlight.style.opacity = "1";
                }

                const isNearBottomRight = (rect.bottom > window.innerHeight * 0.52) && (rect.right > window.innerWidth * 0.52);
                dockCard(isNearBottomRight);
            }, 280);
        } else {
            dockCard(false);
            if (spotlight) {
                spotlight.style.opacity = "0";
            }
        }

        if (titleEl) titleEl.textContent = step.title;
        if (sayEl) sayEl.textContent = step.text;

        if (promptBox) promptBox.style.display = "none";
        if (controls) controls.style.display = "flex";

        if (counter) {
            counter.textContent = `Langkah ${tourCurrentStep + 1} dari ${activeSteps.length}`;
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
                nextBtn.textContent = "Selesai ✓";
                nextBtn.style.background = "#059669";
                nextBtn.style.borderColor = "#047857";
            } else {
                nextBtn.textContent = "Lanjut →";
                nextBtn.style.background = "#007FBE";
                nextBtn.style.borderColor = "#005f8e";
            }
        }
    }

    function startTour() {
        const rawSteps = TOUR_CONFIGS[ROLE] || TOUR_CONFIGS.siswa;
        activeSteps = rawSteps.filter(st => {
            if (st.selector === "#btnStartDashboardTour") return true;
            return !!document.querySelector(st.selector);
        });

        if (activeSteps.length === 0) return;

        isTourActive = true;
        tourCurrentStep = 0;

        if (overlay) overlay.style.display = "block";
        if (card) card.style.display = "block";

        dockCard(false);
        renderStep();
    }

    function finishTour(completed) {
        isTourActive = false;
        if (overlay) overlay.style.display = "none";
        if (spotlight) spotlight.style.opacity = "0";
        if (card) card.style.display = "none";

        try {
            localStorage.setItem(storageKey, "1");
        } catch (e) {}
    }

    // Expose Global function to window so buttons can trigger it
    window.startDashboardTour = startTour;

    // First time check
    function checkFirstTimePrompt() {
        let done = false;
        try {
            done = !!localStorage.getItem(storageKey);
        } catch (e) {}

        if (done) return;

        setTimeout(() => {
            if (isTourActive) return;

            dockCard(false);
            if (titleEl) titleEl.textContent = `Selamat Datang, ${USER_NAME}! 👋`;
            if (sayEl) {
                sayEl.textContent = ROLE === "orangtua"
                    ? "Apakah Ayah/Bunda ingin mengikuti tur pengenalan singkat untuk melihat fitur pemantauan belajar ananda di dashboard?"
                    : "Ingin mengikuti tur pengenalan singkat fitur-fitur utama di dashboard Arrava?";
            }

            if (controls) controls.style.display = "none";
            if (promptBox) promptBox.style.display = "flex";
            if (card) card.style.display = "block";
        }, 1200);
    }

    // Event listeners
    if (nextBtn) {
        nextBtn.addEventListener("click", () => {
            if (tourCurrentStep < activeSteps.length - 1) {
                tourCurrentStep++;
                renderStep();
            } else {
                finishTour(true);
            }
        });
    }

    if (prevBtn) {
        prevBtn.addEventListener("click", () => {
            if (tourCurrentStep > 0) {
                tourCurrentStep--;
                renderStep();
            }
        });
    }

    if (skipBtn) skipBtn.addEventListener("click", () => finishTour(false));
    if (closeBtn) closeBtn.addEventListener("click", () => finishTour(false));

    if (acceptBtn) {
        acceptBtn.addEventListener("click", () => {
            if (promptBox) promptBox.style.display = "none";
            startTour();
        });
    }

    if (declineBtn) {
        declineBtn.addEventListener("click", () => {
            finishTour(false);
        });
    }

    // Inisialisasi pengecekan prompt saat halaman siap
    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", checkFirstTimePrompt);
    } else {
        checkFirstTimePrompt();
    }
})();
</script>
