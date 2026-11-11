@php
  $currentUser = Auth::user();

  // Niere widget hanya untuk Siswa (id_tipeuser = 3) dan Orang Tua (id_tipeuser = 4), serta halaman login
  // TIDAK PERNAH muncul untuk Admin (1) atau Guru (2)
  if ($currentUser && in_array((int) $currentUser->id_tipeuser, [1, 2])) {
      return;
  }

  $isLoginPage = request()->routeIs('login') || request()->is('login');
  $initialPosClass = 'pos-bottom';

  $shouldHideNiere = ($hideNiere ?? false)
    || View::hasSection('hideNiere')
    || request()->routeIs('quiz*')
    || request()->routeIs('siswa.quiz*')
    || request()->routeIs('admin.quiz*')
    || request()->is('quiz*')
    || request()->is('siswa/quiz*')
    || request()->is('admin/quiz*');
@endphp
@if(!$shouldHideNiere)
  <!-- ========================================================
       NIERE – PUSAT INFORMASI (DRAGGABLE IN-PLACE ASSISTANT)
       ======================================================== -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Pixelify+Sans:wght@400;600&display=swap" rel="stylesheet">

  <style>
    /* Scoped styles untuk Niere Widget */
    body:has(#quizPreviewModal:not(.hidden)) #niere-widget-container,
    #niere-widget-container.is-hidden {
      display: none !important;
    }

    body {
      position: relative;
    }

    #niere-widget-container {
      position: absolute !important;
      z-index: 99999 !important;
      width: var(--s) !important;
      height: var(--s) !important;
      margin: 0 !important;
      padding: 0 !important;
      transform: none !important;
      filter: none !important;
      contain: none !important;
      pointer-events: none;
      touch-action: none;

      --page: #eef3ff;
      --bg1: #bcd7ff;
      --bg2: #e3efff;
      --star: #ffffff;
      --ink: #1b2350;
      --panel: #ffffff;
      --line: #3b4fd1;
      --accent: #ffc83d;
      --accent-ink: #1b2350;
      --bubble: #ffffff;
      --bubble-ink: #1b2350;
      --s: 76px;
      --R: 88px;
      --it: 42px;
      font-family: "Pixelify Sans", ui-monospace, Menlo, Consolas, monospace;
      font-size: 15px;
      line-height: 1.4;
      box-sizing: border-box;
      user-select: none;
      -webkit-user-select: none;
    }

    /* Posisi Awal Default:
     - Halaman Login: Pojok Bawah-Kanan (pos-bottom)
     - Selain Halaman Login: Pojok Atas-Kanan (pos-top) dengan margin kiri cukup agar menu radial tidak terpotong tepi layar */
    #niere-widget-container.pos-top {
      top: 135px !important;
      bottom: auto !important;
      right: 70px !important;
      left: auto !important;
    }

    #niere-widget-container.pos-bottom {
      bottom: 20px !important;
      top: auto !important;
      right: 48px !important;
      left: auto !important;
    }

    @media (max-width: 640px) {
      #niere-widget-container {
        --s: 66px;
        --R: 78px;
        --it: 38px;
      }

      #niere-widget-container.pos-top {
        top: 110px !important;
        bottom: auto !important;
        right: 44px !important;
        left: auto !important;
      }

      #niere-widget-container.pos-bottom {
        bottom: calc(14px + env(safe-area-inset-bottom, 0px)) !important;
        top: auto !important;
        right: 44px !important;
        left: auto !important;
      }
    }

    @media (prefers-color-scheme: dark) {
      #niere-widget-container:not([data-theme="light"]) {
        --page: #0a0e24;
        --bg1: #101838;
        --bg2: #1f2c62;
        --star: #9fb0ff;
        --ink: #e8ecff;
        --panel: #11173a;
        --line: #7f93ff;
        --accent: #ffd166;
        --accent-ink: #1b1f3a;
        --bubble: #fff8e1;
        --bubble-ink: #1b1f3a;
      }
    }

    #niere-widget-container[data-theme="dark"] {
      --page: #0a0e24;
      --bg1: #101838;
      --bg2: #1f2c62;
      --star: #9fb0ff;
      --ink: #e8ecff;
      --panel: #11173a;
      --line: #7f93ff;
      --accent: #ffd166;
      --accent-ink: #1b1f3a;
      --bubble: #fff8e1;
      --bubble-ink: #1b1f3a;
    }

    #niere-widget-container * {
      box-sizing: border-box;
    }

    /* Mascot Wrapper */
    .niere-mascot-wrap {
      position: relative;
      width: var(--s);
      height: var(--s);
      pointer-events: auto;
      cursor: grab;
      transition: opacity 0.22s ease, transform 0.22s ease;
    }

    .niere-mascot-wrap.dragging {
      cursor: grabbing;
    }

    .niere-mascot-wrap.dragging #niere-hero {
      transform: scale(1.08) rotate(3deg);
      filter: drop-shadow(0 10px 14px rgba(10, 20, 50, 0.35));
    }

    /* Sprite Button (Transparan, dapat di-drag dan di-klik) */
    .niere-sprite-btn {
      position: relative;
      display: block;
      width: 100%;
      height: 100%;
      padding: 0;
      border: none !important;
      background: transparent !important;
      box-shadow: none !important;
      cursor: inherit;
      outline: none;
      overflow: visible;
      -webkit-tap-highlight-color: transparent;
      transition: transform 0.18s ease;
    }

    .niere-sprite-btn:hover {
      transform: scale(1.08) translateY(-2px);
    }

    .niere-sprite-btn:active {
      transform: scale(0.96) translateY(2px);
    }

    #niere-hero {
      display: block;
      width: 100%;
      height: 100%;
      object-fit: contain;
      image-rendering: pixelated;
      transform-origin: 50% 100%;
      pointer-events: none;
      filter: drop-shadow(0 4px 6px rgba(10, 20, 50, 0.22));
    }

    /* Radial Option Buttons (Membentuk mahkota busur di atas kepala Niere) */
    .niere-opt {
      position: absolute;
      left: 50%;
      top: 50%;
      width: var(--it);
      height: var(--it);
      margin: calc(var(--it)/-2) 0 0 calc(var(--it)/-2);
      background: none;
      border: 0;
      padding: 0;
      cursor: pointer;
      -webkit-tap-highlight-color: transparent;
      transform: translate(0, 0) scale(0.2);
      opacity: 0;
      visibility: hidden;
      transition: transform 0.22s ease-in, opacity 0.18s ease, visibility 0s linear 0.22s;
      z-index: 55;
      pointer-events: auto;
    }

    .niere-ico {
      position: relative;
      display: grid;
      place-items: center;
      width: 100%;
      height: 100%;
      font-size: calc(var(--it) * 0.48);
      line-height: 1;
      color: var(--accent-ink);
      background: var(--accent);
      border: 3px solid var(--line);
      box-shadow: 3px 3px 0 var(--line);
      border-radius: 12px;
      transform-origin: 50% 100%;
      transition: transform 0.25s cubic-bezier(0.3, 2.2, 0.5, 1);
      pointer-events: none;
    }

    .niere-mascot-wrap.open .niere-opt {
      transform: translate(var(--x), var(--y)) scale(1);
      opacity: 1;
      visibility: visible;
      transition: transform 0.45s cubic-bezier(0.34, 1.56, 0.64, 1) var(--d), opacity 0.2s ease var(--d), visibility 0s;
    }

    .niere-mascot-wrap.open .niere-ico {
      animation: niereFloat 1.8s ease-in-out calc(var(--d)*3) infinite;
    }

    @keyframes niereFloat {
      50% {
        transform: translateY(-4px);
      }
    }

    .niere-mascot-wrap.open .niere-opt:hover .niere-ico,
    .niere-mascot-wrap.open .niere-opt:focus-visible .niere-ico {
      background: var(--bubble);
      transform: scale(1.15);
      animation: niereJelly 0.5s both;
    }

    @keyframes niereJelly {
      0% {
        transform: scale(1);
      }

      25% {
        transform: scale(1.25, 0.8);
      }

      50% {
        transform: scale(0.85, 1.2);
      }

      75% {
        transform: scale(1.1, 0.94);
      }

      100% {
        transform: scale(1);
      }
    }

    .niere-mascot-wrap.open .niere-opt:active .niere-ico {
      transform: scale(1.2, 0.75);
    }

    .niere-mascot-wrap.open .niere-opt.go .niere-ico {
      animation: niereSquish 0.25s both;
    }

    @keyframes niereSquish {
      0% {
        transform: scale(1.1);
      }

      40% {
        transform: scale(1.35, 0.6);
      }

      100% {
        transform: scale(0.2);
        opacity: 0;
      }
    }

    .niere-mascot-wrap.open #niere-hero {
      animation: niereHop 0.4s;
    }

    @keyframes niereHop {
      30% {
        transform: scale(1.1, 0.9);
      }

      60% {
        transform: scale(0.95, 1.08) translateY(-4px);
      }

      100% {
        transform: none;
      }
    }

    .niere-mascot-wrap.closing .niere-opt {
      visibility: visible;
      opacity: 0;
      transform: translate(0, 0) scale(0.1);
      transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1) var(--d), opacity 0.25s ease var(--d);
    }

    .niere-mascot-wrap.closing .niere-opt.gone {
      animation: none;
      opacity: 0;
      visibility: hidden;
    }

    /* Tooltip on Radial Option */
    .niere-opt-tip {
      position: absolute;
      bottom: calc(100% + 6px);
      left: 50%;
      transform: translateX(-50%);
      padding: 2px 7px;
      background: var(--line);
      color: #ffffff;
      font-size: 11px;
      font-weight: 600;
      border-radius: 6px;
      white-space: nowrap;
      pointer-events: none;
      opacity: 0;
      visibility: hidden;
      transition: opacity 0.15s ease;
      box-shadow: 2px 2px 0 var(--bubble-ink);
    }

    .niere-opt:hover .niere-opt-tip {
      opacity: 1;
      visibility: visible;
    }

    /* Badge Notifikasi pada Maskot */
    .niere-mascot-notif-badge {
      position: absolute;
      top: -2px;
      right: -2px;
      width: 22px;
      height: 22px;
      background: #ef4444;
      color: #ffffff;
      border: 2.5px solid #ffffff;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 11px;
      font-weight: 800;
      box-shadow: 0 2px 6px rgba(239, 68, 68, 0.45);
      z-index: 60;
      pointer-events: none;
      animation: niereBadgePulse 1.8s infinite;
    }

    @keyframes niereBadgePulse {
      0%, 100% {
        transform: scale(1);
        box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.6);
      }
      50% {
        transform: scale(1.18);
        box-shadow: 0 0 0 6px rgba(239, 68, 68, 0);
      }
    }

    /* Badge Notifikasi pada Ikon Radial */
    .niere-opt-notif-badge {
      position: absolute;
      top: -3px;
      right: -3px;
      background: #ef4444;
      color: #ffffff;
      width: 16px;
      height: 16px;
      border-radius: 50%;
      border: 2px solid #ffffff;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 10px;
      font-weight: 900;
      box-shadow: 0 2px 5px rgba(239, 68, 68, 0.4);
      animation: niereBadgePulse 1.8s infinite;
    }

    /* Speech Bubble (Mengambang di sebelah Niere dan cerdas membalik arah jika Niere di sisi kiri) */
    .niere-bubble {
      position: absolute;
      right: calc(100% + 14px);
      bottom: 0;
      left: auto;
      top: auto;
      width: min(320px, calc(100vw - 110px));
      min-height: 80px;
      padding: 22px 14px 14px;
      background: var(--bubble);
      color: var(--bubble-ink);
      border: 3.5px solid var(--bubble-ink);
      border-radius: 12px;
      box-shadow: 5px 5px 0 var(--line);
      cursor: pointer;
      display: none;
      opacity: 0;
      transform: translateX(12px) scale(0.96);
      transition: opacity 0.2s ease, transform 0.2s ease;
      z-index: 40;
      pointer-events: auto;
    }

    .niere-bubble.show {
      display: block;
      opacity: 1;
      transform: none;
    }

    .niere-bubble::after {
      content: "";
      position: absolute;
      right: -13px;
      bottom: 24px;
      left: auto;
      top: auto;
      width: 18px;
      height: 18px;
      background: var(--bubble);
      border-right: 3.5px solid var(--bubble-ink);
      border-bottom: 3.5px solid var(--bubble-ink);
      transform: rotate(-45deg);
    }

    /* Adaptasi arah balon bicara saat Niere digeser ke sisi kiri layar */
    #niere-widget-container.on-left .niere-bubble {
      right: auto;
      left: calc(100% + 14px);
      transform: translateX(-12px) scale(0.96);
    }

    #niere-widget-container.on-left .niere-bubble.show {
      transform: none;
    }

    #niere-widget-container.on-left .niere-bubble::after {
      right: auto;
      left: -13px;
      border-right: none;
      border-bottom: 3.5px solid var(--bubble-ink);
      border-left: 3.5px solid var(--bubble-ink);
      transform: rotate(45deg);
    }

    @media (max-width: 540px) {
      .niere-bubble {
        bottom: calc(100% + 14px);
        right: 0;
        left: auto;
        width: min(300px, calc(100vw - 32px));
      }

      .niere-bubble::after {
        right: 24px;
        bottom: -11px;
        border-right: 3.5px solid var(--bubble-ink);
        border-bottom: 3.5px solid var(--bubble-ink);
        transform: rotate(45deg);
      }

      /* Jika Niere berada di area atas layar pada ponsel, tampilkan balon di bawah maskot */
      #niere-widget-container.near-top .niere-bubble,
      #niere-widget-container.pos-top:not(.dragging) .niere-bubble {
        top: calc(100% + 14px);
        bottom: auto;
        right: 0;
        left: auto;
      }

      #niere-widget-container.near-top .niere-bubble::after,
      #niere-widget-container.pos-top:not(.dragging) .niere-bubble::after {
        right: 24px;
        top: -11px;
        bottom: auto;
        border-right: none;
        border-bottom: none;
        border-left: 3.5px solid var(--bubble-ink);
        border-top: 3.5px solid var(--bubble-ink);
        transform: rotate(45deg);
      }
    }

    /* Bubble Header & Action Buttons */
    .niere-bubble-header {
      position: absolute;
      top: -16px;
      left: 10px;
      right: 10px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      pointer-events: none;
    }

    .niere-name {
      padding: 1px 9px;
      background: var(--accent);
      color: var(--accent-ink);
      border: 3px solid var(--bubble-ink);
      border-radius: 8px;
      font-weight: 600;
      font-size: 13px;
      pointer-events: auto;
    }

    .niere-bubble-actions {
      display: flex;
      align-items: center;
      gap: 4px;
      pointer-events: auto;
    }

    .niere-btn-mini {
      font-family: inherit;
      font-size: 11px;
      font-weight: 600;
      color: var(--ink);
      background: var(--panel);
      border: 2px solid var(--bubble-ink);
      border-radius: 6px;
      padding: 1px 6px;
      cursor: pointer;
      box-shadow: 2px 2px 0 var(--bubble-ink);
      transition: transform 0.1s ease;
    }

    .niere-btn-mini:active {
      transform: translate(1px, 1px);
      box-shadow: 1px 1px 0 var(--bubble-ink);
    }

    .niere-btn-close {
      background: #fee2e2;
      color: #991b1b;
      border-color: #991b1b;
    }

    #niere-say {
      font-size: 14.5px;
      line-height: 1.45;
      white-space: pre-line;
      word-break: break-word;
    }

    #niere-more {
      position: absolute;
      right: 10px;
      bottom: 2px;
      font-size: 13px;
      visibility: hidden;
    }

    #niere-more.show {
      visibility: visible;
      animation: niereBob 0.8s steps(2) infinite;
    }

    @keyframes niereBob {
      50% {
        transform: translateY(3px);
      }
    }

    @media (prefers-reduced-motion: reduce) {

      #niere-more.show,
      .niere-mascot-wrap.open .niere-ico {
        animation: none;
      }
    }
  </style>

  @php
    $isLoginPage = request()->routeIs('login') || request()->is('login');
    $initialPosClass = 'pos-bottom';

    $currentUser = Auth::user();
    $hasNiereNotif = false;
    $userNotifLines = [];

    if ($currentUser) {
        $userName = $currentUser->nama ?? 'Sobat Arrava';

        if ($currentUser->id_tipeuser == 3) { // Siswa
            $idJenjang = (int) ($currentUser->id_jenjang ?? 0);
            $jenjangLabel = $currentUser->jenjang->nama_tipe ?? ($idJenjang == 1 ? 'SD' : ($idJenjang == 2 ? 'SMP' : ($idJenjang == 3 ? 'SMA' : '')));
            $kuisCount = 0;

            if ($idJenjang > 0) {
                try {
                    $kuisCount = \App\Models\Quiz::published()
                        ->belumKadaluarsa()
                        ->where('id_jenjang', $idJenjang)
                        ->whereDoesntHave('hasil', fn($q) => $q->where('id_user', $currentUser->id_user))
                        ->count();
                } catch (\Exception $e) {}
            }

            $totalPoin = (int) ($currentUser->total_poin ?? 0);

            // Notifikasi Presensi Siswa (Hanya sesuai jenjang aktif siswa)
            try {
                $presensiNotifs = \App\Services\NotifikasiPresensiService::untukSiswa($currentUser);
                foreach ($presensiNotifs as $pn) {
                    $userNotifLines[] = "📢 {$pn['judul']}: {$pn['pesan']}";
                }
            } catch (\Exception $e) {}

            $hasNiereNotif = (count($presensiNotifs) > 0 || $kuisCount > 0);

            $jenjangText = $jenjangLabel ? " ({$jenjangLabel})" : '';
            $userNotifLines[] = "Halo {$userName}! Senang melihatmu kembali belajar di Jenjang{$jenjangText}. ✨";
            if ($kuisCount > 0) {
                $userNotifLines[] = "🔔 Ada {$kuisCount} Kuis aktif jenjang{$jenjangText} yang belum kamu kerjakan! Ayo selesaikan sekarang untuk raih poin EXP! ⚡";
            } else {
                $userNotifLines[] = "✨ Seluruh kuis aktif jenjang{$jenjangText} sudah kamu selesaikan. Pertahankan prestasimu!";
            }
            $userNotifLines[] = "🏆 Poin kamu saat ini: {$totalPoin} EXP. Semangat kumpulkan EXP untuk memuncaki Papan Peringkat!";
        } elseif ($currentUser->id_tipeuser == 4) { // Orang Tua
            // Notifikasi Presensi untuk Orang Tua
            try {
                $targetAnakId = request('siswa_id') ? (int) request('siswa_id') : null;
                $presensiNotifs = \App\Services\NotifikasiPresensiService::untukOrangtua($currentUser, $targetAnakId);
                foreach ($presensiNotifs as $pn) {
                    $userNotifLines[] = "📢 {$pn['judul']}: {$pn['pesan']}";
                }
            } catch (\Exception $e) {}

            $hasNiereNotif = count($presensiNotifs) > 0;

            $userNotifLines[] = "Halo Ayah/Bunda ({$userName})!";
            $userNotifLines[] = "🔔 Pantau presensi dan evaluasi nilai kuis ananda melalui Portal Orang Tua.";
        } else { // Admin dan Guru: tidak ada notifikasi
            $hasNiereNotif = false;
        }
    } else {
        $userNotifLines = [
            "Selamat datang di E-Learning Arrava! 🎓",
            "Silakan masuk ke akunmu untuk mengakses modul belajar, kuis seru, dan notifikasi tugas terbarumu!"
        ];
    }

    $isDashboardSiswa = request()->routeIs('siswa.dashboard') || request()->is('siswa/dashboard*');
    $isDashboardOrangtua = request()->routeIs('orangtua.dashboard') || request()->is('orangtua/dashboard*');
    $isDashboard = ($isDashboardSiswa || $isDashboardOrangtua) && (bool) $currentUser;
    $dashboardRole = $isDashboardSiswa ? 'siswa' : ($isDashboardOrangtua ? 'orangtua' : null);
  @endphp

  @if($isDashboard)
    <!-- ================= NIERE DASHBOARD TOUR SPOTLIGHT & OVERLAY ================= -->
    <div id="niere-tour-overlay" style="display: none; position: fixed; inset: 0; z-index: 99990; pointer-events: auto; background: transparent;">
      <div id="niere-tour-spotlight" style="position: fixed; border-radius: 20px; box-shadow: 0 0 0 9999px rgba(10, 18, 42, 0.65), 0 0 20px rgba(56, 189, 248, 0.6); border: 2.5px solid #38bdf8; pointer-events: none; transition: top 0.35s ease, left 0.35s ease, width 0.35s ease, height 0.35s ease, opacity 0.25s ease; opacity: 0; z-index: 99991;"></div>
    </div>
  @endif

  <!-- ================= NIERE IN-PLACE FLOATING CONTAINER ================= -->
  <div id="niere-widget-container" class="{{ $initialPosClass }}" role="complementary" aria-label="Asisten Niere">
    <!-- Mascot and Radial System -->
    <div class="niere-mascot-wrap" id="niere-mascot">
      <!-- Speech Bubble (Floating directly beside Niere) -->
      <div class="niere-bubble" id="niere-bubble" role="status" aria-live="polite">
        <div class="niere-bubble-header">
          <span class="niere-name" id="niere-name-label">Niere</span>
          <div class="niere-bubble-actions">
            <button type="button" class="niere-btn-mini" id="niere-snd" title="Toggle Suara"
              aria-pressed="true">🔊</button>
            <button type="button" class="niere-btn-mini niere-btn-close" id="niere-close-bubble"
              title="Tutup Balon">✕</button>
          </div>
        </div>
        <div id="niere-say"></div>
        <span id="niere-more">▼</span>

        <!-- Bubble Action Footer (Khusus Notifikasi / Aksi Interaktif) -->
        <div id="niere-bubble-footer" style="display: none; margin-top: 10px; padding-top: 8px; border-top: 1.5px dashed rgba(59,79,209,0.3); gap: 6px; flex-wrap: wrap; align-items: center;">
          <button type="button" id="niere-mark-read-btn" class="niere-btn-mini" style="background: #e0f2fe; color: #0284c7; border: 2px solid #0284c7; font-weight: bold; cursor: pointer; display: inline-flex; align-items: center; gap: 4px; padding: 4px 9px; border-radius: 6px;">
            ✓ Tandai Telah Dibaca
          </button>
          <button type="button" id="niere-open-header-btn" class="niere-btn-mini" style="background: #fef3c7; color: #b45309; border: 2px solid #d97706; font-weight: bold; cursor: pointer; display: inline-flex; align-items: center; gap: 4px; padding: 4px 9px; border-radius: 6px;">
            🔔 Buka Lonceng
          </button>
        </div>

        @if($isDashboard)
        <!-- Tour Navigation Controls (Khusus Mode Tur Pengenalan Dashboard) -->
        <div id="niere-tour-controls" style="display: none; margin-top: 10px; padding-top: 8px; border-top: 1.5px dashed rgba(59,79,209,0.3); flex-direction: column; gap: 8px;">
          <div style="display: flex; align-items: center; justify-content: space-between; font-size: 11px; font-weight: 700; color: #4b5563;">
            <span id="niere-tour-step-counter">Langkah 1 dari 7</span>
            <div id="niere-tour-dots" style="display: flex; gap: 4px; align-items: center;"></div>
          </div>
          <div style="display: flex; align-items: center; justify-content: space-between; gap: 6px;">
            <button type="button" id="niere-tour-prev-btn" class="niere-btn-mini" style="background: #f1f5f9; color: #475569; border: 2px solid #cbd5e1; font-weight: bold; padding: 3px 8px; border-radius: 6px; cursor: pointer;">
              ← Kembali
            </button>
            <div style="display: flex; gap: 4px;">
              <button type="button" id="niere-tour-skip-btn" class="niere-btn-mini" style="background: #fee2e2; color: #991b1b; border: 2px solid #fca5a5; font-weight: bold; padding: 3px 7px; border-radius: 6px; cursor: pointer;">
                Lewati
              </button>
              <button type="button" id="niere-tour-next-btn" class="niere-btn-mini" style="background: #007FBE; color: #ffffff; border: 2px solid #005f8e; font-weight: bold; padding: 3px 10px; border-radius: 6px; cursor: pointer; box-shadow: 1px 1px 0 #005f8e;">
                Lanjut →
              </button>
            </div>
          </div>
        </div>

        <!-- Tour Prompt (Penawaran awal untuk pengguna baru di Dashboard) -->
        <div id="niere-tour-prompt" style="display: none; margin-top: 10px; padding-top: 8px; border-top: 1.5px dashed rgba(59,79,209,0.3); justify-content: flex-end; gap: 6px;">
          <button type="button" id="niere-tour-decline-btn" class="niere-btn-mini" style="background: #f1f5f9; color: #64748b; border: 2px solid #cbd5e1; font-weight: bold; padding: 3px 8px; border-radius: 6px; cursor: pointer;">
            Nanti Saja
          </button>
          <button type="button" id="niere-tour-accept-btn" class="niere-btn-mini" style="background: #007FBE; color: #ffffff; border: 2px solid #005f8e; font-weight: bold; padding: 3px 10px; border-radius: 6px; cursor: pointer; box-shadow: 1px 1px 0 #005f8e;">
            🚀 Mulai Pengenalan
          </button>
        </div>
        @endif
      </div>

      <!-- Mascot Button (TRANSPARAN, dapat di-drag dan di-klik langsung di tempat) -->
      <button type="button" class="niere-sprite-btn" id="niere-sprite" aria-expanded="false"
        aria-label="Niere. Buka Pusat Informasi"
        title="Klik untuk membuka menu, atau geser (drag) untuk memindahkan Niere">
        <img id="niere-hero" alt="Niere Maskot" src="{{ asset('assets/niere/niereIdle.gif') }}">
        <span class="niere-mascot-notif-badge" id="niere-mascot-badge" title="Ada Notifikasi Belum Dibaca!" style="display: none;">0</span>
      </button>
    </div>
  </div>

  <script>
    (function () {
      /* ====== ASET ANIMASI NIERE ====== */
      const SP = {
        idle: "{{ asset('assets/niere/niereIdle.gif') }}",
        talk: "{{ asset('assets/niere/niereTalk.gif') }}",
        type: "{{ asset('assets/niere/talkType.gif') }}",
        shock: "{{ asset('assets/niere/niereShock.gif') }}"
      };

      /* ====== DATA INFORMASI & NOTIFIKASI (MENU BERSIH & BERGUNA) ====== */
      const NOTIF_LINES = @json($userNotifLines);
      const HAS_NOTIF = @json($hasNiereNotif);
      const IS_LOGGED_IN = @json((bool) Auth::check());
      const RAW_PRESENSI_NOTIFS = @json($presensiNotifs ?? []);
      const IS_DASHBOARD = @json((bool) $isDashboard);
      const DASHBOARD_ROLE = @json($dashboardRole);
      const USER_ID = @json($currentUser->id_user ?? 0);
      const USER_NAME = @json($userName ?? 'Sobat Arrava');

      const INFO = [
        {
          id: "notif",
          icon: "🔔",
          label: "Notifikasi",
          hasBadge: HAS_NOTIF,
          lines: NOTIF_LINES
        },
        IS_DASHBOARD ? {
          id: "tour",
          icon: "🧭",
          label: "Pengenalan",
          lines: []
        } : {
          id: "fasilitas",
          icon: "💻",
          label: "Panduan Belajar",
          lines: [
            "Di Arrava kamu bisa belajar mandiri lewat Modul Pembelajaran interaktif (Video & PDF).",
            "Selesaikan Kuis untuk menguji pemahamanmu, kumpulkan EXP, dan raih lencana penghargaan keren!",
            "Pantau posisimu di Papan Peringkat untuk bersaing sehat bersama teman-teman se-jenjang! 🏆"
          ]
        },
        {
          id: "kontak",
          icon: "❓",
          label: "Bantuan",
          lines: [
            "Butuh bantuan seputar materi belajar, akun, atau kuis?",
            "Kamu bisa menghubungi guru pengampu di sekolah atau admin layanan Arrava."
          ]
        }
      ];

      /* ====== KUMPULAN SALAM & KATA MOTIVASI ACAK ====== */
      const GREETINGS = [
        [
          "Halo! Aku Niere, asisten belajarmu di Arrava.",
          "Pilih salah satu ikon di sekelilingku untuk melihat info dan panduan belajar!"
        ],
        [
          "Semangat belajarnya hari ini! ✨",
          "Ingat: setiap langkah kecil yang kamu pelajari hari ini adalah awal dari kesuksesan besarmu!"
        ],
        [
          "Hai! Senang melihatmu kembali belajar. 💪",
          "Orang hebat bukan yang tak pernah gagal, tapi yang tidak pernah berhenti mencoba!"
        ],
        [
          "Lagi fokus belajar materi atau kuis? 🚀",
          "Fokus pada proses dan nikmati belajarmu, hasilnya pasti akan membanggakan!"
        ],
        [
          "Yakinlah dengan kemampuan dirimu! 🌟",
          "Kamu jauh lebih pintar dan tangguh dari yang kamu bayangkan. Terus melangkah ya!"
        ],
        [
          "Buku dan modul adalah jendela duniamu. 📖",
          "Jangan pernah ragu untuk mencoba hal baru dan terus menantang dirimu!"
        ],
        [
          "Waktu belajarmu sangat berharga! ⏰",
          "Yuk manfaatkan hari ini untuk menambah ilmu baru dan mengumpulkan poin EXP!"
        ],
        [
          "Halo sang juara masa depan! 🏆",
          "Konsistensi adalah kuncinya. Sedikit demi sedikit, lama-lama menjadi luar biasa!"
        ]
      ];

      let lastGreetIdx = -1;
      function getRandomGreet() {
        let idx;
        do {
          idx = Math.floor(Math.random() * GREETINGS.length);
        } while (GREETINGS.length > 1 && idx === lastGreetIdx);
        lastGreetIdx = idx;
        return GREETINGS[idx];
      }

      /* ====== ELEMEN DOM ====== */
      const $ = id => document.getElementById(id);
      const root = $("niere-widget-container");
      const mascot = $("niere-mascot");
      const sprite = $("niere-sprite");
      const hero = $("niere-hero");
      const bubble = $("niere-bubble");
      const say = $("niere-say");
      const more = $("niere-more");
      const sndBtn = $("niere-snd");
      const closeBubbleBtn = $("niere-close-bubble");
      const niereNameLabel = $("niere-name-label");
      const tourOverlay = $("niere-tour-overlay");
      const tourSpotlight = $("niere-tour-spotlight");
      const tourControls = $("niere-tour-controls");
      const tourPrompt = $("niere-tour-prompt");
      const tourNextBtn = $("niere-tour-next-btn");
      const tourPrevBtn = $("niere-tour-prev-btn");
      const tourSkipBtn = $("niere-tour-skip-btn");
      const tourAcceptBtn = $("niere-tour-accept-btn");
      const tourDeclineBtn = $("niere-tour-decline-btn");
      const tourCounter = $("niere-tour-step-counter");
      const tourDots = $("niere-tour-dots");

      if (!root || !mascot || !sprite || !hero) return;

      // Pastikan root terpasang langsung di document.body agar tidak terpengaruh transform / container layout halaman
      if (root.parentElement !== document.body) {
        document.body.appendChild(root);
      }
      if (tourOverlay && tourOverlay.parentElement !== document.body) {
        document.body.appendChild(tourOverlay);
      }

      /* ====== STATE ====== */
      let open = false;
      let closing = false;
      let isTourActive = false;
      let tourCurrentStep = 0;
      let tourSteps = [];
      let curLines = [];
      let curLine = 0;
      let typeTimer = null;
      let curPose = "idle";
      let closeT = null;
      let hoverOpenT = null;
      let isMouseInside = false;

      // Sound preference synced with global app audio
      let muted = false;
      try {
        const appSound = localStorage.getItem('arrava_sound_enabled');
        if (appSound !== null) {
          muted = (appSound === 'false');
        }
      } catch (e) { }
      updateSndBtn();

      /* ====== AUDIO BLIP SYNTHESIZER ====== */
      let actx = null;
      function wakeAudio() {
        if (!actx) {
          try {
            const AC = window.AudioContext || window.webkitAudioContext;
            if (AC) actx = new AC();
          } catch (e) { }
        }
        if (actx && actx.state === "suspended") {
          actx.resume().catch(() => { });
        }
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
        } catch (e) { }
      }

      function playPop(i) {
        wakeAudio();
        blip(400 + i * 70, 0.04, 0.05, "triangle");
      }
      function playClick() {
        wakeAudio();
        blip(580, 0.05, 0.06, "square");
      }
      function playTalk() {
        wakeAudio();
        blip(320 + Math.random() * 120, 0.03, 0.03, "sine");
      }

      /* ====== MASCOT POSE ====== */
      function setPose(p) {
        if (curPose === p) return;
        curPose = p;
        hero.src = SP[p] || SP.idle;
      }

      /* ====== RADIAL BUTTONS (MAHKOTA BUSUR - TIDAK MENGHALANGI WAJAH) ====== */
      // 3 opsi (Notifikasi, Panduan Belajar, Bantuan) diletakkan simetris di busur atas Niere
      const optBtns = [];
      function createRadialOptions() {
        mascot.querySelectorAll(".niere-opt").forEach(el => el.remove());
        optBtns.length = 0;

        const isNearTop = root.classList.contains("near-top");
        const isMobile = window.innerWidth <= 640;
        const R = isMobile ? 78 : 90;

        // Busur simetris 3 tombol: sudut 60°, 90°, 120° di atas kepala
        // Jika didekatkan ke ujung atas layar (near-top), busur diarahkan ke bawah (300°, 270°, 240°)
        const angles = isNearTop ? [300, 270, 240] : [60, 90, 120];

        INFO.forEach((item, i) => {
          const btn = document.createElement("button");
          btn.type = "button";
          btn.className = "niere-opt";
          btn.setAttribute("aria-label", item.label);
          btn.title = item.label;

          const angleDeg = angles[i] !== undefined ? angles[i] : 90;
          const angleRad = (angleDeg * Math.PI) / 180;
          const x = Math.round(R * Math.cos(angleRad));
          const y = Math.round(-R * Math.sin(angleRad));
          const delay = (i * 0.045).toFixed(3) + "s";

          // Disimpan dalam satuan piksel eksplisit tanpa ekspresi calc bertanda ganda
          btn.style.setProperty("--x", x + "px");
          btn.style.setProperty("--y", y + "px");
          btn.style.setProperty("--d", delay);

          const isNotif = item.id === "notif";
          const currentUnread = window.arravaNotifData ? (window.arravaNotifData.unreadCount || 0) : (item.hasBadge ? 1 : 0);
          const shouldShowBadge = isNotif ? (currentUnread > 0) : item.hasBadge;
          const badgeHtml = shouldShowBadge
            ? `<span class="niere-opt-notif-badge">!</span>`
            : "";

          btn.innerHTML = `
          <span class="niere-ico">${item.icon}</span>
          ${badgeHtml}
          <span class="niere-opt-tip">${item.label}</span>
        `;

          btn.addEventListener("click", ev => {
            ev.stopPropagation();
            wakeAudio();
            btn.classList.add("go");
            setTimeout(() => btn.classList.remove("go"), 260);

            // Bersihkan badge notifikasi saat menu notifikasi dibuka
            if (item.id === "notif") {
              const mascotBadge = $("niere-mascot-badge");
              if (mascotBadge) mascotBadge.style.display = "none";
              const optBadge = btn.querySelector(".niere-opt-notif-badge");
              if (optBadge) optBadge.style.display = "none";
              item.hasBadge = false;
            }

            selectOption(item);
          });

          mascot.appendChild(btn);
          optBtns.push(btn);
        });
      }

      /* ====== ORIENTASI OTOMATIS BERDASARKAN POSISI ====== */
      function updateOrientation(left, top) {
        const w = window.innerWidth;

        // Jika di sisi kiri layar: balon pindah ke kanan agar tidak keluar layar
        if (left < w / 2) {
          root.classList.add("on-left");
        } else {
          root.classList.remove("on-left");
        }

        // Jika digeser terlalu dekat ke atas (top < 120px): menu radial fanning ke bawah
        const wasNearTop = root.classList.contains("near-top");
        const isNearTop = top < 120;
        if (isNearTop) {
          root.classList.add("near-top");
        } else {
          root.classList.remove("near-top");
        }

        if (isNearTop !== wasNearTop || optBtns.length === 0) {
          createRadialOptions();
        }
      }

      // Set orientasi dan bangun opsi radial berdasarkan posisi awal (pos-top / pos-bottom)
      const initialRect = root.getBoundingClientRect();
      updateOrientation(initialRect.left, initialRect.top);
      if (optBtns.length === 0) {
        createRadialOptions();
      }

      /* ====== DRAG & MOVE SYSTEM ====== */
      let isDragging = false;
      let hasDragged = false;
      let dragStartX = 0, dragStartY = 0;
      let startLeft = 0, startTop = 0;

      function onDragStart(e) {
        // Jangan drag jika menekan tombol opsi atau balon bicara
        if (e.target.closest(".niere-opt") || e.target.closest(".niere-bubble")) return;

        const pt = e.touches ? e.touches[0] : e;
        dragStartX = pt.clientX;
        dragStartY = pt.clientY;

        const rect = root.getBoundingClientRect();
        startLeft = rect.left;
        startTop = rect.top;
        hasDragged = false;
        isDragging = true;

        document.addEventListener("mousemove", onDragMove, { passive: false });
        document.addEventListener("mouseup", onDragEnd);
        document.addEventListener("touchmove", onDragMove, { passive: false });
        document.addEventListener("touchend", onDragEnd);
      }

      function onDragMove(e) {
        if (!isDragging) return;
        const pt = e.touches ? e.touches[0] : e;
        const dx = pt.clientX - dragStartX;
        const dy = pt.clientY - dragStartY;

        if (!hasDragged && Math.hypot(dx, dy) > 5) {
          hasDragged = true;
          mascot.classList.add("dragging");
        }

        if (hasDragged) {
          if (e.cancelable) e.preventDefault();
          const w = root.offsetWidth || 76;
          const h = root.offsetHeight || 76;
          const minL = 16;
          const maxL = window.innerWidth - w - 48;
          const maxT = window.innerHeight - h - 8;

          const newL = Math.max(minL, Math.min(startLeft + dx, maxL));
          const newT = Math.max(8, Math.min(startTop + dy, maxT));

          root.style.setProperty("position", "fixed", "important");
          root.style.setProperty("left", newL + "px", "important");
          root.style.setProperty("top", newT + "px", "important");
          root.style.setProperty("right", "auto", "important");
          root.style.setProperty("bottom", "auto", "important");
          root.style.setProperty("transform", "none", "important");

          updateOrientation(newL, newT);
        }
      }

      function onDragEnd() {
        if (!isDragging) return;
        isDragging = false;
        mascot.classList.remove("dragging");

        if (hasDragged) {
          // Hitung koordinat halaman dokumen (Page Coordinates)
          // agar ketika halaman di-scroll, Niere tetap berhenti di tempat terakhir dia di-drop
          const scrollX = window.pageXOffset || document.documentElement.scrollLeft || 0;
          const scrollY = window.pageYOffset || document.documentElement.scrollTop || 0;
          const rect = root.getBoundingClientRect();
          const pageLeft = Math.round(rect.left + scrollX);
          const pageTop = Math.round(rect.top + scrollY);

          root.style.setProperty("position", "absolute", "important");
          root.style.setProperty("left", pageLeft + "px", "important");
          root.style.setProperty("top", pageTop + "px", "important");
          root.style.setProperty("right", "auto", "important");
          root.style.setProperty("bottom", "auto", "important");
          root.style.setProperty("transform", "none", "important");
        }

        document.removeEventListener("mousemove", onDragMove);
        document.removeEventListener("mouseup", onDragEnd);
        document.removeEventListener("touchmove", onDragMove);
        document.removeEventListener("touchend", onDragEnd);
      }

      // Pasang listener drag pada wrapper maskot
      mascot.addEventListener("mousedown", onDragStart);
      mascot.addEventListener("touchstart", onDragStart, { passive: false });

      /* ====== OPEN & CLOSE RADIAL MENU ====== */
      function setOpen(v) {
        if (isTourActive) return;
        if (open === v) return;
        wakeAudio();

        if (v) {
          clearTimeout(closeT);
          closing = false;
          mascot.classList.remove("closing");
          optBtns.forEach(b => b.classList.remove("gone"));
          mascot.classList.add("open");
          sprite.setAttribute("aria-expanded", "true");
          setPose("idle");
          optBtns.forEach((_, i) => setTimeout(() => playPop(i), i * 45));
          open = true;

          // Jika bubble belum terbuka, beri notifikasi langsung jika ada notifikasi baru, atau sapaan singkat acak
          if (!bubble.classList.contains("show")) {
            if (HAS_NOTIF && INFO.length > 0 && INFO[0].id === 'notif' && INFO[0].hasBadge) {
              sayLines(INFO[0].lines, "talk");
              const mascotBadge = $("niere-mascot-badge");
              if (mascotBadge) mascotBadge.style.display = "none";
              const optBadge = mascot.querySelector(".niere-opt-notif-badge");
              if (optBadge) optBadge.style.display = "none";
              INFO[0].hasBadge = false;
            } else {
              sayLines(getRandomGreet(), "talk");
            }
          }
        } else {
          if (!open) return;
          closing = true;
          mascot.classList.add("closing");
          optBtns.forEach((_, i) => setTimeout(() => playPop(optBtns.length - i), i * 30));
          closeT = setTimeout(() => {
            mascot.classList.remove("open", "closing");
            optBtns.forEach(b => b.classList.add("gone"));
            sprite.setAttribute("aria-expanded", "false");
            closing = false;
            open = false;
          }, 360);
        }
      }

      /* ====== DIALOG & TYPEWRITER ====== */
      function sayLines(lines, poseName) {
        curLines = Array.isArray(lines) ? lines : [lines];
        curLine = 0;
        bubble.classList.add("show");
        typeLine(curLines[0], poseName);
      }

      function typeLine(text, poseName) {
        clearTimeout(typeTimer);
        say.textContent = "";
        more.classList.remove("show");
        setPose(poseName || "talk");

        let idx = 0;
        const len = text.length;

        function step() {
          if (idx < len) {
            say.textContent += text[idx];
            if (text[idx] !== " " && text[idx] !== "\n" && idx % 2 === 0) {
              playTalk();
            }
            idx++;
            typeTimer = setTimeout(step, 20);
          } else {
            setPose("idle");
            if (curLine < curLines.length - 1) {
              more.classList.add("show");
            }
          }
        }
        step();
      }

      function nextDialogue() {
        if (typeTimer && say.textContent.length < (curLines[curLine] || "").length) {
          clearTimeout(typeTimer);
          typeTimer = null;
          say.textContent = curLines[curLine];
          setPose("idle");
          if (curLine < curLines.length - 1) {
            more.classList.add("show");
          }
          return;
        }
        if (curLine < curLines.length - 1) {
          curLine++;
          playClick();
          typeLine(curLines[curLine], "talk");
        } else {
          more.classList.remove("show");
        }
      }

      function selectOption(item) {
        playClick();
        const footer = $("niere-bubble-footer");
        if (tourControls) tourControls.style.display = 'none';
        if (tourPrompt) tourPrompt.style.display = 'none';
        if (niereNameLabel) niereNameLabel.textContent = "Niere";

        if (item.id === "tour") {
          startDashboardTour();
          return;
        }

        if (item.id === "notif") {
          const data = window.arravaNotifData;
          const unreadCount = data ? (data.unreadCount || 0) : 0;
          if (unreadCount > 0) {
            const lines = [
              `Kamu memiliki ${unreadCount} pemberitahuan presensi belum dibaca: 🔔`,
              ...data.unreadItems.map(u => `📢 ${u.judul}:\n${u.pesan}`),
              "Klik tombol 'Tandai Telah Dibaca' di bawah atau buka lonceng 🔔 di header ya!"
            ];
            sayLines(lines, "talk");
            if (footer) footer.style.display = 'flex';
          } else {
            sayLines([
              "Semua notifikasi presensi sudah kamu baca! ✨",
              "Pemberitahuan tetap tersimpan dan bisa dibuka kembali lewat lonceng 🔔 di header atas."
            ], "talk");
            if (footer) footer.style.display = 'none';
          }
          if (typeof window.openHeaderNotifDropdown === 'function') {
            window.openHeaderNotifDropdown();
          }
          return;
        }
        if (footer) footer.style.display = 'none';
        sayLines(item.lines, "talk");
      }

      /* ====== SOUND TOGGLE ====== */
      function updateSndBtn() {
        if (!sndBtn) return;
        sndBtn.textContent = muted ? "🔇" : "🔊";
        sndBtn.setAttribute("aria-pressed", String(!muted));
        try {
          localStorage.setItem('arrava_sound_enabled', String(!muted));
        } catch (e) { }
      }

      sndBtn.onclick = ev => {
        ev.stopPropagation();
        muted = !muted;
        wakeAudio();
        updateSndBtn();
        if (!muted) playClick();
      };

      /* ====== EVENT LISTENERS ====== */
      // 1. Klik pada Mascot: Toggle Buka/Tutup (hanya jika bukan sedang dragging)
      sprite.onclick = ev => {
        ev.stopPropagation();
        if (hasDragged) {
          hasDragged = false;
          return;
        }
        wakeAudio();
        setOpen(!open);
      };

      // 2. Hover pada Mascot: Otomatis membuka menu jika mouse masuk
      mascot.addEventListener("mouseenter", () => {
        if (isDragging || hasDragged || isTourActive) return;
        isMouseInside = true;
        clearTimeout(closeT);
        clearTimeout(hoverOpenT);
        hoverOpenT = setTimeout(() => {
          if (isMouseInside && !open && !isDragging && !isTourActive) {
            setOpen(true);
          }
        }, 180);
      });

      // 3. Mouse keluar dari area Mascot: Grace period sebelum menutup
      mascot.addEventListener("mouseleave", () => {
        isMouseInside = false;
        clearTimeout(hoverOpenT);
        clearTimeout(closeT);
        closeT = setTimeout(() => {
          if (!isMouseInside && open && !isDragging) {
            setOpen(false);
          }
        }, 450);
      });

      // 4. Klik balon bicara untuk memajukan dialog
      bubble.onclick = ev => {
        ev.stopPropagation();
        if (isTourActive) {
          // Jika teks sedang diketik, selesaikan pengetikan langsung
          if (typeTimer && say.textContent.length < (curLines[curLine] || "").length) {
            clearTimeout(typeTimer);
            typeTimer = null;
            say.textContent = curLines[curLine];
            setPose("idle");
          }
          return;
        }
        wakeAudio();
        nextDialogue();
      };

      // 5. Tombol tutup balon
      closeBubbleBtn.onclick = ev => {
        ev.stopPropagation();
        if (isTourActive) {
          finishDashboardTour(false);
          return;
        }
        bubble.classList.remove("show");
        const footer = $("niere-bubble-footer");
        if (footer) footer.style.display = 'none';
        if (tourPrompt) tourPrompt.style.display = 'none';
        clearTimeout(typeTimer);
        setPose("idle");
      };

      // 6. Klik di luar menutup radial menu dan bubble (hanya jika tur tidak aktif)
      document.addEventListener("click", ev => {
        if (isTourActive) return;
        if (!mascot.contains(ev.target)) {
          if (open) setOpen(false);
          if (bubble.classList.contains("show")) {
            bubble.classList.remove("show");
            const footer = $("niere-bubble-footer");
            if (footer) footer.style.display = 'none';
            if (tourPrompt) tourPrompt.style.display = 'none';
            clearTimeout(typeTimer);
            setPose("idle");
          }
        }
      });

      // 7. Keyboard shortcuts
      document.addEventListener("keydown", ev => {
        if (ev.key === "Escape") {
          if (isTourActive) {
            finishDashboardTour(false);
            return;
          }
          if (open) setOpen(false);
          if (bubble.classList.contains("show")) {
            bubble.classList.remove("show");
          }
          return;
        }
        const targetTag = ev.target.tagName;
        if (targetTag === "INPUT" || targetTag === "TEXTAREA" || ev.ctrlKey || ev.metaKey || ev.altKey) return;

        if (isTourActive) {
          if (ev.key === "ArrowRight" || ev.key === "Enter") {
            ev.preventDefault();
            nextTourStep();
          } else if (ev.key === "ArrowLeft") {
            ev.preventDefault();
            prevTourStep();
          }
          return;
        }

        if (ev.key === " " && bubble.classList.contains("show")) {
          ev.preventDefault();
          wakeAudio();
          nextDialogue();
        } else {
          const num = parseInt(ev.key, 10);
          if (num >= 1 && num <= INFO.length) {
            wakeAudio();
            selectOption(INFO[num - 1]);
          }
        }
      });

      window.addEventListener("resize", () => {
        createRadialOptions();
        if (isTourActive) {
          renderTourStep();
        }
        if (hasDragged) {
          const w = root.offsetWidth || 76;
          const maxL = window.innerWidth - w - 48;
          const curL = parseInt(root.style.left, 10);
          if (!isNaN(curL) && curL > maxL) {
            root.style.setProperty("left", Math.max(16, maxL) + "px", "important");
          }
        }
      });

      /* ====== GLOBAL API ====== */
      window.openNiereWidget = function () {
        wakeAudio();
        setOpen(true);
        sayLines(getRandomGreet(), "talk");
      };
      window.closeNiereWidget = function () {
        setOpen(false);
        bubble.classList.remove("show");
      };
      window.toggleNiereWidget = function () {
        if (open) window.closeNiereWidget();
        else window.openNiereWidget();
      };
      window.startNiereTour = function () {
        startDashboardTour();
      };

      // Auto-open via ?open_niere=1
      try {
        if (new URLSearchParams(window.location.search).has('open_niere')) {
          setTimeout(window.openNiereWidget, 400);
        }
      } catch (e) { }

      // ================= SINKRONISASI NOTIFIKASI DENGAN NIERE =================
      function updateNiereBadge(count) {
        // 1. Update mascot head badge
        const mascotBadge = $("niere-mascot-badge");
        if (mascotBadge) {
          if (count > 0) {
            mascotBadge.textContent = count > 9 ? '9+' : count;
            mascotBadge.style.display = 'flex';
          } else {
            mascotBadge.style.display = 'none';
          }
        }

        // 2. Selalu sinkronkan item.hasBadge di array INFO
        INFO.forEach(it => {
          if (it.id === "notif") {
            it.hasBadge = count > 0;
          }
        });

        // 3. Sembunyikan atau tampilkan tanda seru (!) pada semua tombol radial
        const optBadges = mascot ? mascot.querySelectorAll(".niere-opt-notif-badge") : [];
        optBadges.forEach(b => {
          b.style.display = count > 0 ? 'flex' : 'none';
        });

        // 4. Update footer tombol 'Tandai Telah Dibaca' di balon bicara Niere
        const footer = $("niere-bubble-footer");
        if (footer) {
          footer.style.display = count > 0 ? 'flex' : 'none';
        }
      }

      // Handler untuk tombol 'Tandai Telah Dibaca' di dalam balon bicara Niere
      const niereMarkReadBtn = $("niere-mark-read-btn");
      if (niereMarkReadBtn) {
        niereMarkReadBtn.addEventListener("click", ev => {
          ev.stopPropagation();
          wakeAudio();
          playClick();

          // Panggil fungsi global yang menandai semua notif sebagai dibaca
          if (typeof window.markAllNotifAsRead === 'function') {
            window.markAllNotifAsRead();
          } else {
            const userId = '{{ $currentUser->id_user ?? 0 }}';
            const allNotifs = Array.isArray(RAW_PRESENSI_NOTIFS) ? RAW_PRESENSI_NOTIFS : [];
            const allIds = allNotifs.map(n => n.id);
            try {
              localStorage.setItem(`arrava_read_notif_${userId}`, JSON.stringify(allIds));
            } catch(e) {}
            updateNiereBadge(0);
          }

          // Segera sembunyikan semua badge dan tanda seru di Niere
          updateNiereBadge(0);

          // Niere memberi respon ramah
          sayLines([
            "Semua notifikasi sudah kamu tandai telah dibaca! ✨",
            "Pemberitahuan tetap tersimpan dan bisa dibuka kembali lewat lonceng 🔔 header atas ya."
          ], "talk");
        });
      }

      // Handler untuk tombol 'Buka Lonceng' di balon bicara Niere
      const niereOpenHeaderBtn = $("niere-open-header-btn");
      if (niereOpenHeaderBtn) {
        niereOpenHeaderBtn.addEventListener("click", ev => {
          ev.stopPropagation();
          wakeAudio();
          playClick();
          if (typeof window.openHeaderNotifDropdown === 'function') {
            window.openHeaderNotifDropdown();
          }
        });
      }

      function initNiereNotificationGreeting() {
        const userId = '{{ $currentUser->id_user ?? 0 }}';
        const readIds = (() => {
          try { return JSON.parse(localStorage.getItem(`arrava_read_notif_${userId}`) || '[]'); }
          catch(e) { return []; }
        })();

        let unreadItems = [];
        let unreadCount = 0;

        const data = window.arravaNotifData;
        if (data && Array.isArray(data.unreadItems)) {
          unreadItems = data.unreadItems;
          unreadCount = data.unreadCount;
        } else {
          const allNotifs = Array.isArray(RAW_PRESENSI_NOTIFS) ? RAW_PRESENSI_NOTIFS : [];
          unreadItems = allNotifs.filter(n => !readIds.includes(n.id));
          unreadCount = unreadItems.length;
        }

        updateNiereBadge(unreadCount);

        // Jika ADA notifikasi belum dibaca, Niere LANGSUNG berbicara memberikan informasi pesan & jumlahnya
        if (unreadCount > 0) {
          setTimeout(() => {
            if (!open && !bubble.classList.contains("show")) {
              const lines = [
                `Halo {{ $userName ?? 'Sobat Arrava' }}! Ada ${unreadCount} notifikasi presensi{{ $jenjangText ?? '' }} yang belum dibaca: 🔔`,
                ...unreadItems.slice(0, 2).map(u => `📢 ${u.judul || 'Presensi'}:\n${u.pesan || ''}`),
                `Klik 'Tandai Telah Dibaca' di bawah atau buka lonceng 🔔 header atas ya!`
              ];
              sayLines(lines, "talk");
              const footer = $("niere-bubble-footer");
              if (footer) footer.style.display = 'flex';
            }
          }, 800);
        }
      }

      /* ====== LOGIKA PENGUMPULAN & NAVIGASI TUR DASHBOARD ====== */
      const TOUR_STEPS = {
        siswa: [
          {
            selector: "#samudraHeroCard, #galaksiHeroCard",
            title: "Profil & EXP",
            text: "Ini area profilmu! Di sini kamu bisa melihat namamu, jenjang belajar, dan bilah progres EXP. Terus kumpulkan poin EXP dari kuis dan modul untuk menaikkan peringkatmu.",
            pose: "talk"
          },
          {
            selector: "#tourMenuPintasan",
            title: "Menu Pintasan Belajar",
            text: "Ini menu akses cepat! Kamu bisa langsung membuka daftar Modul Belajar, Kuis Latihan, kartu Presensi QR, atau melihat Papan Peringkat se-jenjang.",
            pose: "talk"
          },
          {
            selector: "#tourMateriModul",
            title: "Materi Modul Pembelajaran",
            text: "Di bagian ini, kamu bisa melihat materi pelajaran terbaru yang disiapkan guru, baik berupa video interaktif maupun dokumen PDF.",
            pose: "talk"
          },
          {
            selector: "#tourRiwayatKuis",
            title: "Riwayat Belajar & Kuis",
            text: "Semua hasil kuis yang telah kamu kerjakan akan tercatat rapi di sini, lengkap dengan skor dan tanggal pengerjaannya.",
            pose: "talk"
          },
          {
            selector: "#mainSidebar",
            title: "Menu Navigasi Utama",
            text: "Bilah menu di samping memudahkanmu berpindah halaman kapan saja: Dashboard, Belajar, Kuis, Peringkat, hingga Profil akunmu.",
            pose: "talk"
          },
          {
            selector: "#notifikasiPresensiRoot",
            title: "Lonceng Notifikasi",
            text: "Ikon lonceng ini akan memberitahumu secara langsung saat guru mencatat presensi kelas atau ada pengumuman baru.",
            pose: "shock"
          },
          {
            selector: "#niere-widget-container",
            title: "Pengenalan Selesai!",
            text: "Dan ini aku, Niere! Kamu bisa menggeser posisiku atau mengklik ikon 🧭 di sekelilingku kapan saja jika ingin mengulang pengenalan ini. Selamat belajar ya!",
            pose: "shock"
          }
        ],
        orangtua: [
          {
            selector: "#tourOtStudentCard",
            title: "Profil Siswa",
            text: "Ini kartu informasi ananda. Jika Ayah/Bunda memiliki lebih dari satu anak yang terdaftar di Arrava, Anda dapat memilih profil ananda melalui menu ini.",
            pose: "talk"
          },
          {
            selector: "#tourOtStats",
            title: "Ringkasan Akademik",
            text: "Di sini Ayah/Bunda dapat memantau tiga statistik utama: jumlah kuis yang dikerjakan, modul yang telah selesai dipelajari, serta rata-rata nilai ananda.",
            pose: "talk"
          },
          {
            selector: "#tourOtAktivitas",
            title: "Aktivitas Belajar Terbaru",
            text: "Bagian ini menampilkan riwayat pengerjaan kuis ananda secara langsung, lengkap dengan nilai dan status kelulusan (Tuntas atau Remedial).",
            pose: "talk"
          },
          {
            selector: "#tourOtPerhatian",
            title: "Catatan Pendampingan",
            text: "Area ini memberikan saran pendampingan belajar jika ananda membutuhkan pengulangan materi atau perhatian khusus.",
            pose: "talk"
          },
          {
            selector: "#otSidebar",
            title: "Menu Navigasi Portal",
            text: "Gunakan menu navigasi samping untuk melihat laporan perkembangan nilai, materi pembelajaran, riwayat kuis, pencapaian, dan pengaturan akun.",
            pose: "talk"
          },
          {
            selector: "#notifikasiPresensiRoot",
            title: "Lonceng Notifikasi Presensi",
            text: "Lonceng ini memberikan kabar langsung setiap kali ananda tercatat hadir atau guru memperbarui catatan presensi kelas.",
            pose: "shock"
          },
          {
            selector: "#niere-widget-container",
            title: "Pengenalan Selesai!",
            text: "Aku Niere, asisten pendamping di portal Arrava. Ayah/Bunda bisa mengklik ikon 🧭 di sekelilingku kapan saja untuk memutar kembali pengenalan ini. Semoga bermanfaat!",
            pose: "shock"
          }
        ]
      };

      function dockNiereForTour(isTargetNearBottomRight) {
        root.style.setProperty("position", "fixed", "important");
        root.style.setProperty("z-index", "99999", "important");
        root.style.setProperty("bottom", "20px", "important");
        root.style.setProperty("top", "auto", "important");

        if (isTargetNearBottomRight) {
          root.style.setProperty("left", "24px", "important");
          root.style.setProperty("right", "auto", "important");
          root.classList.add("on-left");
        } else {
          root.style.setProperty("right", "28px", "important");
          root.style.setProperty("left", "auto", "important");
          root.classList.remove("on-left");
        }
      }

      function startDashboardTour() {
        if (!IS_DASHBOARD || !DASHBOARD_ROLE || !TOUR_STEPS[DASHBOARD_ROLE]) return;

        tourSteps = TOUR_STEPS[DASHBOARD_ROLE].filter(st => {
          if (st.selector === "#niere-widget-container") return true;
          return !!document.querySelector(st.selector);
        });

        if (tourSteps.length === 0) return;

        isTourActive = true;
        tourCurrentStep = 0;

        if (open) setOpen(false);

        if (tourOverlay) tourOverlay.style.display = "block";
        if (niereNameLabel) niereNameLabel.textContent = "Niere • Pengenalan";

        dockNiereForTour(false);
        renderTourStep();
      }

      function renderTourStep() {
        if (!isTourActive || !tourSteps[tourCurrentStep]) return;
        const step = tourSteps[tourCurrentStep];
        const targetEl = document.querySelector(step.selector);

        if (targetEl && step.selector !== "#niere-widget-container") {
          targetEl.scrollIntoView({ behavior: "smooth", block: "center", inline: "nearest" });

          setTimeout(() => {
            if (!isTourActive) return;
            const rect = targetEl.getBoundingClientRect();
            const pad = 10;
            const top = Math.max(0, rect.top - pad);
            const left = Math.max(0, rect.left - pad);
            const w = rect.width + pad * 2;
            const h = rect.height + pad * 2;

            if (tourSpotlight) {
              tourSpotlight.style.top = top + "px";
              tourSpotlight.style.left = left + "px";
              tourSpotlight.style.width = w + "px";
              tourSpotlight.style.height = h + "px";
              tourSpotlight.style.opacity = "1";
            }

            const isNearBottomRight = (rect.bottom > window.innerHeight * 0.52) && (rect.right > window.innerWidth * 0.52);
            dockNiereForTour(isNearBottomRight);
          }, 280);
        } else {
          dockNiereForTour(false);
          if (tourSpotlight) {
            tourSpotlight.style.opacity = "0";
          }
        }

        sayLines([step.text], step.pose || "talk");

        if (tourPrompt) tourPrompt.style.display = "none";
        const notifFooter = $("niere-bubble-footer");
        if (notifFooter) notifFooter.style.display = "none";
        if (tourControls) tourControls.style.display = "flex";

        if (tourCounter) {
          tourCounter.textContent = `Langkah ${tourCurrentStep + 1} dari ${tourSteps.length} • ${step.title}`;
        }

        if (tourDots) {
          tourDots.innerHTML = tourSteps.map((_, i) => {
            const active = (i === tourCurrentStep);
            return `<span style="display:inline-block; width:${active ? '14px' : '5px'}; height:5px; border-radius:3px; background:${active ? '#007FBE' : '#cbd5e1'}; transition:all 0.2s ease;"></span>`;
          }).join("");
        }

        if (tourPrevBtn) {
          tourPrevBtn.style.visibility = (tourCurrentStep === 0) ? "hidden" : "visible";
        }
        if (tourNextBtn) {
          if (tourCurrentStep === tourSteps.length - 1) {
            tourNextBtn.textContent = "Selesai ✓";
            tourNextBtn.style.background = "#059669";
            tourNextBtn.style.borderColor = "#047857";
          } else {
            tourNextBtn.textContent = "Lanjut →";
            tourNextBtn.style.background = "#007FBE";
            tourNextBtn.style.borderColor = "#005f8e";
          }
        }
      }

      function nextTourStep() {
        wakeAudio();
        playClick();
        if (tourCurrentStep < tourSteps.length - 1) {
          tourCurrentStep++;
          renderTourStep();
        } else {
          finishDashboardTour(true);
        }
      }

      function prevTourStep() {
        wakeAudio();
        playClick();
        if (tourCurrentStep > 0) {
          tourCurrentStep--;
          renderTourStep();
        }
      }

      function finishDashboardTour(completed) {
        isTourActive = false;
        if (tourOverlay) tourOverlay.style.display = "none";
        if (tourSpotlight) tourSpotlight.style.opacity = "0";
        if (tourControls) tourControls.style.display = "none";
        if (niereNameLabel) niereNameLabel.textContent = "Niere";

        try {
          localStorage.setItem(`arrava_tour_done_${USER_ID}_${DASHBOARD_ROLE}`, "1");
        } catch (e) {}

        if (completed) {
          wakeAudio();
          playPop(2);
          sayLines([
            "Hebat! Kamu sudah mengenal seluruh fitur utama di dashboard. ✨",
            "Ikon 🧭 di sekelilingku selalu siap jika kamu ingin membuka pengenalan ini lagi."
          ], "shock");
        } else {
          bubble.classList.remove("show");
          setPose("idle");
        }

        setTimeout(() => {
          root.style.removeProperty("position");
          root.style.removeProperty("left");
          root.style.removeProperty("top");
          root.style.removeProperty("right");
          root.style.removeProperty("bottom");
          root.className = "{{ $initialPosClass }}";
          updateOrientation(root.getBoundingClientRect().left, root.getBoundingClientRect().top);
        }, 400);
      }

      function checkFirstTimeTourPrompt() {
        if (!IS_DASHBOARD || !DASHBOARD_ROLE) return;
        let tourDone = false;
        try {
          tourDone = !!localStorage.getItem(`arrava_tour_done_${USER_ID}_${DASHBOARD_ROLE}`);
        } catch (e) {}

        if (!tourDone) {
          setTimeout(() => {
            if (open || isTourActive || bubble.classList.contains("show")) return;

            const promptText = (DASHBOARD_ROLE === 'orangtua')
              ? `Halo Ayah/Bunda (${USER_NAME})! Selamat datang di Portal Orang Tua Arrava. 🎓\n\nMau Niere pandu mengenal fitur-fitur di dashboard ini?`
              : `Halo ${USER_NAME}! Selamat datang di Dashboard Arrava. 🎓\n\nMau Niere pandu mengenal fitur-fitur di halaman ini?`;

            sayLines([promptText], "talk");

            if (tourPrompt) tourPrompt.style.display = "flex";
            if (tourControls) tourControls.style.display = "none";
            const notifFooter = $("niere-bubble-footer");
            if (notifFooter) notifFooter.style.display = "none";
          }, 1400);
        }
      }

      // Event listeners tombol tur
      if (tourNextBtn) {
        tourNextBtn.addEventListener("click", ev => {
          ev.stopPropagation();
          nextTourStep();
        });
      }
      if (tourPrevBtn) {
        tourPrevBtn.addEventListener("click", ev => {
          ev.stopPropagation();
          prevTourStep();
        });
      }
      if (tourSkipBtn) {
        tourSkipBtn.addEventListener("click", ev => {
          ev.stopPropagation();
          finishDashboardTour(false);
        });
      }
      if (tourAcceptBtn) {
        tourAcceptBtn.addEventListener("click", ev => {
          ev.stopPropagation();
          if (tourPrompt) tourPrompt.style.display = "none";
          startDashboardTour();
        });
      }
      if (tourDeclineBtn) {
        tourDeclineBtn.addEventListener("click", ev => {
          ev.stopPropagation();
          if (tourPrompt) tourPrompt.style.display = "none";
          try {
            localStorage.setItem(`arrava_tour_done_${USER_ID}_${DASHBOARD_ROLE}`, "1");
          } catch (e) {}
          bubble.classList.remove("show");
          setPose("idle");
        });
      }

      // Pastikan spotlight tetap mengikuti target saat scrolling halaman
      window.addEventListener("scroll", () => {
        if (!isTourActive || !tourSteps[tourCurrentStep]) return;
        const step = tourSteps[tourCurrentStep];
        if (step.selector === "#niere-widget-container") return;
        const targetEl = document.querySelector(step.selector);
        if (targetEl && tourSpotlight) {
          const rect = targetEl.getBoundingClientRect();
          const pad = 10;
          tourSpotlight.style.top = Math.max(0, rect.top - pad) + "px";
          tourSpotlight.style.left = Math.max(0, rect.left - pad) + "px";
          tourSpotlight.style.width = (rect.width + pad * 2) + "px";
          tourSpotlight.style.height = (rect.height + pad * 2) + "px";
        }
      }, { passive: true });

      if (IS_LOGGED_IN) {
        setTimeout(initNiereNotificationGreeting, 350);
        if (IS_DASHBOARD) {
          setTimeout(checkFirstTimeTourPrompt, 1400);
        }
      }

      // Dengarkan event ketika notifikasi dibaca di header
      window.addEventListener('arrava:notif-update', ev => {
        const d = ev.detail;
        if (!d) return;
        updateNiereBadge(d.unreadCount || 0);
      });

      // Dengarkan event ketika notifikasi baru tiba secara REALTIME tanpa refresh
      window.addEventListener('arrava:notif-realtime-arrival', ev => {
        const item = ev.detail;
        if (!item) return;

        const mascotBadge = $("niere-mascot-badge");
        const currentCount = mascotBadge ? (parseInt(mascotBadge.textContent, 10) || 0) : 0;
        updateNiereBadge(currentCount + 1);

        wakeAudio();
        sayLines([
          `Psst! Ada notifikasi presensi baru masuk! 📢`,
          `${item.judul || 'Presensi'}:\n${item.pesan || ''}`,
          `Pemberitahuan ini sudah masuk ke lonceng 🔔 header atas ya!`
        ], "talk");
        const footer = $("niere-bubble-footer");
        if (footer) footer.style.display = 'flex';
      });
    })();
  </script>
@endif