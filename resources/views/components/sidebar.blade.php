@php
    $user = Auth::user();
    // id_tipeuser: 1 = admin, 2 = guru, 3 = siswa
    $idTipe = $user->id_tipeuser ?? 3;
    $isAdmin = in_array($idTipe, [1, 2]);
    $role = $isAdmin ? 'admin' : 'siswa';
@endphp

<style>
    /* =======================================================
       Sidebar Pop-up Icon Tween & Floating Effect
       ======================================================= */
    .sidebar-menu-item {
        position: relative;
        overflow: visible !important;
        transition: background-color 0.18s ease, color 0.18s ease, transform 0.12s ease;
    }

    .sidebar-menu-item:active {
        transform: scale(0.98);
    }

    /* Container pembungkus icon pop-up di sisi kanan link */
    .sidebar-pop-wrap {
        position: absolute;
        right: 4px;
        top: 50%;
        transform: translateY(-50%);
        pointer-events: none;
        z-index: 20;
        line-height: 0;
    }

    /* Kotak pop-up dengan spring tween entry (scale 0.25 -> 1) */
    .sidebar-pop-box {
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transform: scale(0.25) translateY(6px) rotate(-8deg);
        transform-origin: center right;
        transition: opacity 0.28s cubic-bezier(0.34, 1.56, 0.64, 1),
                    transform 0.28s cubic-bezier(0.34, 1.56, 0.64, 1);
        will-change: transform, opacity;
    }

    /* Tampil saat menu di-hover */
    .sidebar-menu-item:hover .sidebar-pop-box {
        opacity: 1;
        transform: scale(1.08) translateY(0) rotate(0deg);
    }

    /* Tampil saat menu sedang aktif di halaman saat ini */
    .sidebar-menu-item.is-active .sidebar-pop-box,
    .sidebar-menu-item[data-active="true"] .sidebar-pop-box {
        opacity: 1;
        transform: scale(1) translateY(0) rotate(0deg);
    }

    /* Sedikit membesar jika menu aktif di-hover lagi */
    .sidebar-menu-item.is-active:hover .sidebar-pop-box,
    .sidebar-menu-item[data-active="true"]:hover .sidebar-pop-box {
        transform: scale(1.08) translateY(0) rotate(0deg);
    }

    /* Gambar Icon Pixel Retro */
    .sidebar-pop-img {
        width: 48px;
        height: 48px;
        object-fit: contain;
        image-rendering: -webkit-optimize-contrast;
        image-rendering: pixelated;
        filter: drop-shadow(0 4px 6px rgba(37, 99, 235, 0.18));
        pointer-events: none;
        user-select: none;
    }

    /* Animasi melayang / bobbing terus-menerus saat icon muncul (Opsi 4) */
    .sidebar-menu-item:hover .sidebar-pop-img,
    .sidebar-menu-item.is-active .sidebar-pop-img,
    .sidebar-menu-item[data-active="true"] .sidebar-pop-img {
        animation: sidebarIconBobFloat 2.2s ease-in-out infinite;
    }

    @keyframes sidebarIconBobFloat {
        0%, 100% {
            transform: translateY(0px) rotate(0deg);
        }
        50% {
            transform: translateY(-4px) rotate(0.8deg);
        }
    }

    /* Tactile press feedback pada icon pop-up saat tombol diklik */
    .sidebar-menu-item:active .sidebar-pop-box {
        transform: scale(0.92) translateY(2px);
        transition: transform 0.08s ease;
    }

    /* =======================================================
       Sidebar Pixel Snow Scene Widget (Inspired by VS Code Pets)
       ======================================================= */
    .sidebar-snow-card {
        transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.2s ease, border-color 0.2s ease;
    }
    .sidebar-snow-card:active {
        transform: scale(0.98);
    }
    .sidebar-snow-pixel-img {
        image-rendering: -webkit-optimize-contrast;
        image-rendering: pixelated;
        image-rendering: -moz-crisp-edges;
        image-rendering: crisp-edges;
    }
</style>

<!-- Backdrop Gelap untuk Layar Kecil (Mobile) -->
<div id="sidebarBackdrop" class="fixed inset-0 z-40 bg-slate-900/40 backdrop-blur-sm transition-opacity duration-300 opacity-0 pointer-events-none lg:hidden"></div>

<aside id="mainSidebar" class="fixed inset-y-0 left-0 z-50 flex h-screen w-64 -translate-x-full flex-col justify-between border-r border-gray-100 bg-white p-4 shadow-2xl transition-transform duration-300 ease-in-out lg:sticky lg:top-0 lg:h-screen lg:translate-x-0 lg:shadow-none lg:z-30 shrink-0 overflow-y-auto overflow-x-hidden">
    <!-- Top Section -->
    <div class="space-y-6">
        <!-- Logo Brand & Tombol Close (Mobile) -->
        <div class="flex items-center justify-between px-2">
            <div class="flex items-center gap-3">
                <div class="bg-blue-600 text-white font-bold rounded-xl text-xl flex items-center justify-center w-10 h-10 shrink-0 shadow-md shadow-blue-500/20">
                    eB
                </div>
                <span class="text-xl font-bold text-gray-900 tracking-tight">eBooks</span>
            </div>

            <!-- Tombol Tutup Sidebar di Layar Kecil -->
            <button id="sidebarClose" type="button" class="flex h-9 w-9 items-center justify-center rounded-xl text-slate-400 hover:bg-slate-100 hover:text-slate-600 transition lg:hidden" aria-label="Tutup Menu">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Navigation Links -->
        <nav class="space-y-1">
            @if ($isAdmin)
                {{-- ================= MENU ADMIN ================= --}}
                @php
                    $actAdminDash   = request()->is('admin/dashboard*') || request()->is('admin');
                    $actAdminSiswa  = request()->is('admin/siswa*') || request()->is('admin/data*');
                    $actAdminModul  = request()->is('admin/modul*');
                    $actAdminQuiz   = request()->is('admin/quiz*') || request()->is('admin/soal*');
                    $actAdminAchieve = request()->is('admin/achievement*');
                    $actAdminGuru   = request()->is('admin/guru*');
                    $actAdminProfil = request()->is('admin/profil*');
                @endphp

                <!-- Dashboard -->
                <a href="{{ route('admin') }}"
                   class="sidebar-menu-item group relative flex items-center justify-between px-3 py-2.5 rounded-xl font-medium text-sm transition {{ $actAdminDash ? 'bg-blue-50 text-blue-600 is-active' : 'text-slate-500 hover:bg-gray-50' }}"
                   data-active="{{ $actAdminDash ? 'true' : 'false' }}">
                    <div class="flex items-center gap-3 relative z-10 min-w-0 pr-12">
                        <svg class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        <span class="truncate">Dashboard</span>
                    </div>
                    <div class="sidebar-pop-wrap">
                        <div class="sidebar-pop-box">
                            <img src="{{ asset('assets/sidebar/sidebarBerandaIcon.webp') }}" alt="Dashboard" class="sidebar-pop-img" draggable="false">
                        </div>
                    </div>
                </a>

                @if($idTipe == 1)
                <!-- Siswa -->
                <a href="{{ route('admin.daftar_siswa') }}"
                   class="sidebar-menu-item group relative flex items-center justify-between px-3 py-2.5 rounded-xl font-medium text-sm transition {{ $actAdminSiswa ? 'bg-blue-50 text-blue-600 is-active' : 'text-slate-500 hover:bg-gray-50' }}"
                   data-active="{{ $actAdminSiswa ? 'true' : 'false' }}">
                    <div class="flex items-center gap-3 relative z-10 min-w-0 pr-12">
                        <svg class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        <span class="truncate">Siswa</span>
                    </div>
                    <div class="sidebar-pop-wrap">
                        <div class="sidebar-pop-box">
                            <img src="{{ asset('assets/sidebar/sidebarProfileIcon.webp') }}" alt="Siswa" class="sidebar-pop-img" draggable="false">
                        </div>
                    </div>
                </a>
                @endif

                <!-- Modul -->
                <a href="{{ route('admin.modul') }}"
                   class="sidebar-menu-item group relative flex items-center justify-between px-3 py-2.5 rounded-xl font-medium text-sm transition {{ $actAdminModul ? 'bg-blue-50 text-blue-600 is-active' : 'text-slate-500 hover:bg-gray-50' }}"
                   data-active="{{ $actAdminModul ? 'true' : 'false' }}">
                    <div class="flex items-center gap-3 relative z-10 min-w-0 pr-12">
                        <svg class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 16.5 5c1.747 0 3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        <span class="truncate">Modul</span>
                    </div>
                    <div class="sidebar-pop-wrap">
                        <div class="sidebar-pop-box">
                            <img src="{{ asset('assets/sidebar/sidebarModulIcon.webp') }}" alt="Modul" class="sidebar-pop-img" draggable="false">
                        </div>
                    </div>
                </a>

                <!-- Quiz -->
                <a href="{{ route('admin.quiz') }}"
                   class="sidebar-menu-item group relative flex items-center justify-between px-3 py-2.5 rounded-xl font-medium text-sm transition {{ $actAdminQuiz ? 'bg-blue-50 text-blue-600 is-active' : 'text-slate-500 hover:bg-gray-50' }}"
                   data-active="{{ $actAdminQuiz ? 'true' : 'false' }}">
                    <div class="flex items-center gap-3 relative z-10 min-w-0 pr-12">
                        <svg class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <span class="truncate">Quiz</span>
                    </div>
                    <div class="sidebar-pop-wrap">
                        <div class="sidebar-pop-box">
                            <img src="{{ asset('assets/sidebar/sidebarQuizIcon.webp') }}" alt="Quiz" class="sidebar-pop-img" draggable="false">
                        </div>
                    </div>
                </a>

                @php $actPresensi = request()->is('guru/presensi*'); @endphp
                <!-- Presensi -->
                <a href="{{ route('guru.presensi.index') }}"
                   class="sidebar-menu-item group relative flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition {{ $actPresensi ? 'bg-blue-50 text-blue-600 is-active' : 'text-slate-500 hover:bg-gray-50' }}"
                   data-active="{{ $actPresensi ? 'true' : 'false' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h6v6H4V4zm10 0h6v6h-6V4zM4 14h6v6H4v-6zm10 0h2v2h-2v-2zm4 0h2v2h-2v-2zm-4 4h2v2h-2v-2zm4 0h2v2h-2v-2z"/></svg>
                    <span class="truncate">Presensi</span>
                </a>

                @if($idTipe == 1)
                @php $actKelas = request()->is('admin/kelas*'); $actQrAdmin = request()->is('admin/qr*'); @endphp
                <!-- Kelas -->
                <a href="{{ route('admin.kelas') }}"
                   class="sidebar-menu-item group relative flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition {{ $actKelas ? 'bg-blue-50 text-blue-600 is-active' : 'text-slate-500 hover:bg-gray-50' }}"
                   data-active="{{ $actKelas ? 'true' : 'false' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-2.13a4 4 0 100-8 4 4 0 000 8zm6 0a3 3 0 100-6M3 11a3 3 0 106 0"/></svg>
                    <span class="truncate">Kelas</span>
                </a>

                <!-- QR Siswa -->
                <a href="{{ route('admin.qr') }}"
                   class="sidebar-menu-item group relative flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition {{ $actQrAdmin ? 'bg-blue-50 text-blue-600 is-active' : 'text-slate-500 hover:bg-gray-50' }}"
                   data-active="{{ $actQrAdmin ? 'true' : 'false' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h6v6H4V4zm10 0h6v6h-6V4zM4 14h6v6H4v-6zm10 0h2v2h-2v-2zm4 0h2v2h-2v-2zm-4 4h2v2h-2v-2zm4 0h2v2h-2v-2z"/></svg>
                    <span class="truncate">QR Siswa</span>
                </a>

                <!-- Penghargaan / Achievement -->
                <a href="{{ route('admin.achievement') }}"
                   class="sidebar-menu-item group relative flex items-center justify-between px-3 py-2.5 rounded-xl font-medium text-sm transition {{ $actAdminAchieve ? 'bg-blue-50 text-blue-600 is-active' : 'text-slate-500 hover:bg-gray-50' }}"
                   data-active="{{ $actAdminAchieve ? 'true' : 'false' }}">
                    <div class="flex items-center gap-3 relative z-10 min-w-0 pr-12">
                        <svg class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                        <span class="truncate">Penghargaan</span>
                    </div>
                    <div class="sidebar-pop-wrap">
                        <div class="sidebar-pop-box">
                            <img src="{{ asset('assets/sidebar/sidebarQuizIcon.webp') }}" alt="Penghargaan" class="sidebar-pop-img" draggable="false">
                        </div>
                    </div>
                </a>

                <!-- Guru -->
                <a href="{{ route('admin.guru') }}"
                   class="sidebar-menu-item group relative flex items-center justify-between px-3 py-2.5 rounded-xl font-medium text-sm transition {{ $actAdminGuru ? 'bg-blue-50 text-blue-600 is-active' : 'text-slate-500 hover:bg-gray-50' }}"
                   data-active="{{ $actAdminGuru ? 'true' : 'false' }}">
                    <div class="flex items-center gap-3 relative z-10 min-w-0 pr-12">
                        <svg class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <span class="truncate">Guru</span>
                    </div>
                    <div class="sidebar-pop-wrap">
                        <div class="sidebar-pop-box">
                            <img src="{{ asset('assets/sidebar/sidebarProfileIcon.webp') }}" alt="Guru" class="sidebar-pop-img" draggable="false">
                        </div>
                    </div>
                </a>
                @endif

                @if($idTipe == 2)
                {{-- Menu Profil hanya untuk Guru --}}
                <!-- Profil -->
                <a href="{{ route('admin.profil') }}"
                   class="sidebar-menu-item group relative flex items-center justify-between px-3 py-2.5 rounded-xl font-medium text-sm transition {{ $actAdminProfil ? 'bg-blue-50 text-blue-600 is-active' : 'text-slate-500 hover:bg-gray-50' }}"
                   data-active="{{ $actAdminProfil ? 'true' : 'false' }}">
                    <div class="flex items-center gap-3 relative z-10 min-w-0 pr-12">
                        <svg class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <span class="truncate">Profil</span>
                    </div>
                    <div class="sidebar-pop-wrap">
                        <div class="sidebar-pop-box">
                            <img src="{{ asset('assets/sidebar/sidebarProfileIcon.webp') }}" alt="Profil" class="sidebar-pop-img" draggable="false">
                        </div>
                    </div>
                </a>
                @endif

            @else
                {{-- ================= MENU SISWA ================= --}}
                @php
                    $actSiswaDash   = request()->is('siswa/dashboard*');
                    $actSiswaBelajar = request()->is('siswa/belajar*');
                    $actSiswaQuiz   = request()->is('siswa/quiz*');
                    $actSiswaProfil = request()->is('siswa/profil*');
                @endphp

                <!-- Dashboard -->
                <a href="{{ route('siswa.dashboard') }}"
                   class="sidebar-menu-item group relative flex items-center justify-between px-3 py-2.5 rounded-xl font-medium text-sm transition {{ $actSiswaDash ? 'bg-blue-50 text-blue-600 is-active' : 'text-slate-500 hover:bg-gray-50' }}"
                   data-active="{{ $actSiswaDash ? 'true' : 'false' }}">
                    <div class="flex items-center gap-3 relative z-10 min-w-0 pr-12">
                        <svg class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        <span class="truncate">Dashboard</span>
                    </div>
                    <div class="sidebar-pop-wrap">
                        <div class="sidebar-pop-box">
                            <img src="{{ asset('assets/sidebar/sidebarBerandaIcon.webp') }}" alt="Dashboard" class="sidebar-pop-img" draggable="false">
                        </div>
                    </div>
                </a>

                <!-- Belajar / Modul -->
                <a href="{{ route('siswa.modul') }}"
                   class="sidebar-menu-item group relative flex items-center justify-between px-3 py-2.5 rounded-xl font-medium text-sm transition {{ $actSiswaBelajar ? 'bg-blue-50 text-blue-600 is-active' : 'text-slate-500 hover:bg-gray-50' }}"
                   data-active="{{ $actSiswaBelajar ? 'true' : 'false' }}">
                    <div class="flex items-center gap-3 relative z-10 min-w-0 pr-12">
                        <svg class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 16.5 5c1.747 0 3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        <span class="truncate">Belajar</span>
                    </div>
                    <div class="sidebar-pop-wrap">
                        <div class="sidebar-pop-box">
                            <img src="{{ asset('assets/sidebar/sidebarModulIcon.webp') }}" alt="Belajar" class="sidebar-pop-img" draggable="false">
                        </div>
                    </div>
                </a>

                <!-- Quiz -->
                <a href="{{ route('siswa.quiz') }}"
                   class="sidebar-menu-item group relative flex items-center justify-between px-3 py-2.5 rounded-xl font-medium text-sm transition {{ $actSiswaQuiz ? 'bg-blue-50 text-blue-600 is-active' : 'text-slate-500 hover:bg-gray-50' }}"
                   data-active="{{ $actSiswaQuiz ? 'true' : 'false' }}">
                    <div class="flex items-center gap-3 relative z-10 min-w-0 pr-12">
                        <svg class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="truncate">Quiz</span>
                    </div>
                    <div class="sidebar-pop-wrap">
                        <div class="sidebar-pop-box">
                            <img src="{{ asset('assets/sidebar/sidebarQuizIcon.webp') }}" alt="Quiz" class="sidebar-pop-img" draggable="false">
                        </div>
                    </div>
                </a>

                <!-- Profil -->
                <a href="{{ route('siswa.profil') }}"
                   class="sidebar-menu-item group relative flex items-center justify-between px-3 py-2.5 rounded-xl font-medium text-sm transition {{ $actSiswaProfil ? 'bg-blue-50 text-blue-600 is-active' : 'text-slate-500 hover:bg-gray-50' }}"
                   data-active="{{ $actSiswaProfil ? 'true' : 'false' }}">
                    <div class="flex items-center gap-3 relative z-10 min-w-0 pr-12">
                        <svg class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <span class="truncate">Profil</span>
                    </div>
                    <div class="sidebar-pop-wrap">
                        <div class="sidebar-pop-box">
                            <img src="{{ asset('assets/sidebar/sidebarProfileIcon.webp') }}" alt="Profil" class="sidebar-pop-img" draggable="false">
                        </div>
                    </div>
                </a>
            @endif
        </nav>
    </div>

    <!-- Bottom Section: Direct Sidebar Pixel Snow Scene + User Info & Logout -->
    <div class="mt-auto space-y-3">
        <!-- Direct Edge-to-Edge Pixel Snow Scene (Tanpa Card, Tanpa Tombol/Text, 1x Putar saat Diklik) -->
        <div class="relative -mx-4 overflow-hidden h-52 sm:h-56 cursor-pointer select-none group bg-transparent transition-transform duration-150 active:scale-[0.98]"
             id="sidebarSnowWidget"
             role="button"
             tabindex="0"
             title="Klik untuk memutar animasi salju"
             aria-label="Animasi Salju Sidebar">

            <!-- 1. Gambar Diam / Normal (WEBP) - Skala diperbesar 110% agar melebihi batas sidebar namun tetap terpotong rapih -->
            <img id="sidebarSnowStatic"
                 src="{{ asset('assets/background/sidebar/sideSnow.webp') }}"
                 alt="Pemandangan Salju Sidebar"
                 class="sidebar-snow-pixel-img absolute inset-0 h-full w-full object-cover object-bottom scale-110 transition-opacity duration-200">

            <!-- 2. Animasi Bergerak (GIF) - Berputar 1 kali saat diklik -->
            <img id="sidebarSnowAnim"
                 src="{{ asset('assets/background/sidebar/sideSnow.gif') }}"
                 data-src="{{ asset('assets/background/sidebar/sideSnow.gif') }}"
                 alt="Animasi Salju Sidebar Bergerak"
                 class="sidebar-snow-pixel-img absolute inset-0 h-full w-full object-cover object-bottom scale-110 opacity-0 pointer-events-none transition-opacity duration-200">
        </div>

        <!-- User Info & Logout Card -->
        <div class="pt-1 flex items-center justify-between">
            <div class="flex items-center gap-3 overflow-hidden">
                <div class="w-9 h-9 rounded-full bg-slate-100 flex items-center justify-center font-bold text-slate-700 shrink-0">
                    {{ strtoupper(substr($user->nama ?? 'U', 0, 1)) }}
                </div>
                <div class="truncate">
                    <h4 class="text-sm font-semibold text-gray-900 leading-tight truncate">{{ $user->nama ?? 'User' }}</h4>
                    <p class="text-xs text-gray-400 capitalize truncate">{{ $role }}</p>
                </div>
            </div>
            <!-- Tombol Logout → buka modal konfirmasi -->
            <button type="button" id="logoutTrigger"
                    class="text-slate-400 hover:text-red-600 p-1.5 rounded-lg hover:bg-red-50 transition shrink-0"
                    title="Keluar" onclick="openLogoutModal()">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
            </button>
        </div>
    </div>
</aside>

<script>
    (function() {
        // Expose helper untuk membunyikan suara menu sidebar lewat audio engine utama
        window.playSidebarMenuSound = function(pitchShift, vol) {
            if (window.ArravaHoverSound && window.ArravaHoverSound.playMenuClick) {
                window.ArravaHoverSound.playMenuClick(pitchShift !== undefined ? pitchShift : 0, vol !== undefined ? vol : 0.85);
            }
        };

        // Responsive sidebar drawer logic untuk layar mobile & desktop
        function initResponsiveSidebar() {
            var sidebar = document.getElementById('mainSidebar');
            var backdrop = document.getElementById('sidebarBackdrop');
            var closeBtn = document.getElementById('sidebarClose');
            var toggleBtns = document.querySelectorAll('[data-sidebar-toggle]');

            if (!sidebar || !backdrop) return;

            function openSidebar() {
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('opacity-0', 'pointer-events-none');
                backdrop.classList.add('opacity-100', 'pointer-events-auto');
                document.body.classList.add('overflow-hidden', 'lg:overflow-auto');
            }

            function closeSidebar() {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.remove('opacity-100', 'pointer-events-auto');
                backdrop.classList.add('opacity-0', 'pointer-events-none');
                document.body.classList.remove('overflow-hidden', 'lg:overflow-auto');
            }

            toggleBtns.forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    openSidebar();
                });
            });

            if (closeBtn) {
                closeBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    closeSidebar();
                });
            }

            backdrop.addEventListener('click', closeSidebar);

            window.addEventListener('resize', function() {
                if (window.innerWidth >= 1024) {
                    closeSidebar();
                }
            });
        }

        // Interaktivitas Widget Pixel Snow Sidebar (Putar lonceng natal & animasi salju 1 kali saat diklik)
        function initSidebarSnowInteraction() {
            var widget = document.getElementById('sidebarSnowWidget');
            var staticImg = document.getElementById('sidebarSnowStatic');
            var animImg = document.getElementById('sidebarSnowAnim');

            if (!widget || !staticImg || !animImg) return;

            var SOUND_FILE = "{{ asset('assets/sounds/widgets/jingleSnowSound.wav') }}";
            var currentAudio = null;
            var stopTimer = null;

            function stopAnimation() {
                if (stopTimer) {
                    clearTimeout(stopTimer);
                    stopTimer = null;
                }
                animImg.classList.remove('opacity-100');
                animImg.classList.add('opacity-0');
                staticImg.classList.remove('opacity-0');
            }

            function playOnce() {
                // Hentikan audio sebelumnya jika ada yang sedang berbunyi agar sinkron dari awal
                if (currentAudio) {
                    try {
                        currentAudio.pause();
                        currentAudio.currentTime = 0;
                    } catch (e) {}
                }
                if (stopTimer) {
                    clearTimeout(stopTimer);
                    stopTimer = null;
                }

                // Mulai animasi GIF dari frame pertama (refresh timestamp)
                var baseSrc = animImg.getAttribute('data-src') || animImg.src;
                var cleanSrc = baseSrc.split('?')[0];
                animImg.src = cleanSrc + '?t=' + Date.now();

                // Tampilkan GIF, sembunyikan gambar diam
                staticImg.classList.add('opacity-0');
                animImg.classList.remove('opacity-0');
                animImg.classList.add('opacity-100');

                // Putar suara lonceng jingle (jingleSnowSound.wav)
                try {
                    var audio = new Audio(SOUND_FILE);
                    audio.volume = 0.85;
                    currentAudio = audio;

                    audio.onended = function() {
                        stopAnimation();
                    };

                    audio.onerror = function() {
                        stopTimer = setTimeout(stopAnimation, 3000);
                    };

                    var playPromise = audio.play();
                    if (playPromise !== undefined) {
                        playPromise.catch(function() {
                            stopTimer = setTimeout(stopAnimation, 3000);
                        });
                    }
                } catch (e) {
                    stopTimer = setTimeout(stopAnimation, 3000);
                }

                // Fallback batas waktu maksimal 7 detik sesuai durasi file WAV ~6.2 detik
                stopTimer = setTimeout(stopAnimation, 7000);
            }

            widget.addEventListener('click', function() {
                playOnce();
            });

            widget.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    playOnce();
                }
            });
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() {
                initResponsiveSidebar();
                initSidebarSnowInteraction();
            });
        } else {
            initResponsiveSidebar();
            initSidebarSnowInteraction();
        }
    })();
</script>

