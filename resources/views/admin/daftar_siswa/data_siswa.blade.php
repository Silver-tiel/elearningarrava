@extends('layouts.app')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@600;700;800&family=Figtree:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
    .siswa-card {
        --bg: #eceefb;
        --card: #ffffff;
        --ink: #1b1a3a;
        --muted: #6b6f8d;
        --line: #e4e6f4;
        --soft: #f5f6fc;
        --brand: #2563eb;
        --brand2: #4f46e5;
        --brand-soft: #eff6ff;
        --ok: #0f9d6a;
        --ok-soft: #dcf6ea;
        --danger: #d6314f;
        --danger-soft: #fdeaee;
        --wa: #128c4a;
        position: relative;
        width: 100%;
        background: var(--card);
        border-radius: 28px;
        overflow: hidden;
        border: 1px solid var(--line);
        box-shadow: 0 16px 40px -20px rgba(40, 40, 120, .22);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        font-family: Figtree, system-ui, -apple-system, sans-serif;
        color: var(--ink);
        display: flex;
        flex-direction: column;
    }

    .siswa-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 24px 50px -20px rgba(40, 40, 120, .32);
    }

    .siswa-card svg:not(.hero-qr-box svg) {
        display: inline-block;
        vertical-align: middle;
        flex-shrink: 0 !important;
        width: 18px !important;
        height: 18px !important;
        max-width: 18px !important;
        max-height: 18px !important;
    }

    .siswa-card .badges svg {
        width: 13px !important;
        height: 13px !important;
        max-width: 13px !important;
        max-height: 13px !important;
    }

    .siswa-card .pill.status svg {
        width: 9px !important;
        height: 9px !important;
        max-width: 9px !important;
        max-height: 9px !important;
    }

    .siswa-card .photo-btn svg {
        width: 15px !important;
        height: 15px !important;
        max-width: 15px !important;
        max-height: 15px !important;
    }

    .siswa-card .mini svg {
        width: 14px !important;
        height: 14px !important;
        max-width: 14px !important;
        max-height: 14px !important;
    }

    .siswa-card .toggle svg,
    .siswa-card .sheet-head svg,
    .siswa-card .btn svg {
        width: 16px !important;
        height: 16px !important;
        max-width: 16px !important;
        max-height: 16px !important;
    }

    .siswa-card .mail svg {
        width: 13px !important;
        height: 13px !important;
        max-width: 13px !important;
        max-height: 13px !important;
    }

    .siswa-card .hero-qr-box svg {
        width: 100% !important;
        height: 100% !important;
        max-width: 100% !important;
        max-height: 100% !important;
        display: block;
    }

    /* foto & QR sebagai latar */
    .siswa-card .hero {
        position: relative;
        aspect-ratio: 3/4;
        background: #0f172a;
        color: #fff;
        overflow: hidden;
    }

    .siswa-card .hero-img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.4s ease;
    }

    .siswa-card:hover .hero-img {
        transform: scale(1.03);
    }

    /* Fallback ketika foto siswa tidak ada */
    .siswa-card .hero-fallback {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle at 50% 36%, #2563eb 0%, #1e1b4b 65%, #0f172a 100%);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
        padding-top: 56px;
        color: #fff;
        z-index: 1;
    }

    .siswa-card .hero-fallback-avatar {
        width: 86px;
        height: 86px;
        border-radius: 26px;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.22) 0%, rgba(255, 255, 255, 0.06) 100%);
        border: 2px solid rgba(255, 255, 255, 0.35);
        box-shadow: 0 16px 36px -10px rgba(0, 0, 0, 0.4), inset 0 1px 0 rgba(255, 255, 255, 0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: "Bricolage Grotesque", Figtree, sans-serif;
        font-weight: 800;
        font-size: 38px;
        color: #ffffff;
        text-shadow: 0 2px 6px rgba(0, 0, 0, 0.35);
        margin-bottom: 8px;
        transition: transform 0.3s ease;
    }

    .siswa-card:hover .hero-fallback-avatar {
        transform: scale(1.06);
    }

    .siswa-card .hero-fallback-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 10.5px;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        color: rgba(255, 255, 255, 0.78);
        background: rgba(0, 0, 0, 0.28);
        padding: 3px 10px;
        border-radius: 999px;
        border: 1px solid rgba(255, 255, 255, 0.18);
        backdrop-filter: blur(4px);
    }

    /* Layer QR Code Pada Hero */
    .siswa-card .hero-qr-layer {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle at 50% 36%, #1d4ed8 0%, #1e1b4b 65%, #0f172a 100%);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
        padding-top: 54px;
        z-index: 1;
        cursor: pointer;
    }

    .siswa-card .hero-qr-box {
        background: #ffffff;
        border-radius: 18px;
        padding: 8px;
        box-shadow: 0 16px 36px -10px rgba(0, 0, 0, 0.45);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        width: 126px;
        height: 126px;
        transition: transform 0.25s ease;
        border: 2px solid rgba(255, 255, 255, 0.9);
    }

    .siswa-card:hover .hero-qr-box {
        transform: scale(1.04);
    }

    .siswa-card .hero-qr-badge {
        margin-top: 7px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 10px;
        font-weight: 700;
        color: rgba(255, 255, 255, 0.9);
        background: rgba(0, 0, 0, 0.38);
        padding: 2.5px 10px;
        border-radius: 999px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(4px);
        transition: background 0.15s;
    }

    .siswa-card:hover .hero-qr-badge {
        background: rgba(0, 0, 0, 0.58);
    }

    .siswa-card .hero-qr-badge svg {
        width: 10px !important;
        height: 10px !important;
        max-width: 10px !important;
        max-height: 10px !important;
    }

    .siswa-card .hero::after {
        content: "";
        position: absolute;
        inset: 0;
        z-index: 2;
        background: linear-gradient(to top, rgba(14, 12, 52, .95) 0%, rgba(14, 12, 52, .75) 30%, rgba(14, 12, 52, 0) 62%);
        pointer-events: none;
        transition: opacity 0.3s ease;
    }

    .siswa-card.is-qr-mode .hero::after {
        opacity: 0.85;
    }

    .siswa-card .badges {
        position: absolute;
        top: 14px;
        left: 14px;
        right: 14px;
        z-index: 3;
        display: flex;
        justify-content: space-between;
        align-items: center;
        pointer-events: none;
    }

    .siswa-card .pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 11px;
        border-radius: 999px;
        font-weight: 700;
        font-size: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.18);
        pointer-events: auto;
    }

    .siswa-card .pill.role {
        background: rgba(20, 18, 64, .65);
        color: #fff;
        -webkit-backdrop-filter: blur(8px);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.15);
    }

    .siswa-card .pill.status {
        color: #fff;
        padding: 4px 9px;
    }

    .siswa-card .pill.status select {
        cursor: pointer;
        background: transparent;
        border: 0;
        color: inherit;
        font-weight: 700;
        font-size: 11.5px;
        outline: none;
        appearance: none;
        -webkit-appearance: none;
        padding-right: 14px;
    }

    .siswa-card .check-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        border-radius: 10px;
        background: rgba(20, 18, 64, .65);
        -webkit-backdrop-filter: blur(8px);
        backdrop-filter: blur(8px);
        border: 1.5px solid rgba(255, 255, 255, 0.22);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.18);
        pointer-events: auto;
        cursor: pointer;
        transition: all 0.15s;
    }

    .siswa-card .check-btn:hover {
        background: rgba(20, 18, 64, .85);
        transform: scale(1.05);
    }

    /* Tombol bulat toggle Foto <-> QR */
    .siswa-card .photo-btn {
        position: absolute;
        right: 14px;
        top: 50px;
        z-index: 4;
        width: 34px;
        height: 34px;
        border-radius: 50%;
        border: 1.5px solid rgba(255, 255, 255, .85);
        background: rgba(20, 18, 64, .65);
        color: #fff;
        display: grid;
        place-items: center;
        -webkit-backdrop-filter: blur(8px);
        backdrop-filter: blur(8px);
        transition: all 0.2s;
        cursor: pointer;
        text-decoration: none;
    }

    .siswa-card .photo-btn:hover {
        background: var(--brand);
        transform: scale(1.08);
    }

    /* Identitas dasar di hero */
    .siswa-card .ident {
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 3;
        padding: 0 16px 14px;
        text-align: left;
    }

    .siswa-card .ident h3 {
        margin: 0;
        font-family: "Bricolage Grotesque", Figtree, sans-serif;
        font-weight: 800;
        font-size: 20px;
        letter-spacing: -.02em;
        line-height: 1.2;
        color: #fff;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .siswa-card .mail {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-top: 4px;
        color: rgba(255, 255, 255, .9);
        font-size: 13.5px;
        text-decoration: none;
        font-weight: 600;
        height: 20px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        transition: color 0.15s;
    }

    .siswa-card .mail:hover {
        color: #fff;
        text-decoration: underline;
    }

    /* Tombol buka info */
    .siswa-card .toggle {
        width: 100%;
        margin-top: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        height: 42px;
        border: 0;
        border-radius: 14px;
        background: rgba(255, 255, 255, .96);
        color: #1e3a8a;
        font-weight: 700;
        font-size: 13px;
        box-shadow: 0 8px 20px -8px rgba(0, 0, 0, .45);
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .siswa-card .toggle:hover {
        background: #ffffff;
        transform: translateY(-1px);
    }

    .siswa-card .toggle svg {
        width: 18px;
        height: 18px;
        flex-shrink: 0;
        transition: transform 0.2s;
    }

    /* Panel Bottom Sheet */
    .siswa-card .scrim {
        position: absolute;
        inset: 0;
        z-index: 4;
        background: rgba(10, 10, 40, .48);
        opacity: 0;
        pointer-events: none;
        transition: opacity .3s ease;
    }

    .siswa-card .scrim.open {
        opacity: 1;
        pointer-events: auto;
    }

    .siswa-card .sheet {
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 5;
        display: flex;
        flex-direction: column;
        max-height: calc(100% - 16px);
        background: var(--card);
        border-radius: 26px 26px 0 0;
        box-shadow: 0 -16px 40px -12px rgba(10, 10, 50, .45);
        transform: translateY(105%);
        visibility: hidden;
        transition: transform .38s cubic-bezier(.22, .8, .26, 1), visibility 0s .38s;
    }

    .siswa-card .sheet.open {
        transform: translateY(0);
        visibility: visible;
        transition: transform .38s cubic-bezier(.22, .8, .26, 1), visibility 0s;
    }

    .siswa-card .sheet-head {
        flex: none;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        height: 46px;
        border: 0;
        background: transparent;
        color: var(--brand);
        font-weight: 700;
        font-size: 13.5px;
        border-radius: 26px 26px 0 0;
        cursor: pointer;
    }

    .siswa-card .sheet-head svg {
        width: 18px;
        height: 18px;
        flex-shrink: 0;
        transition: transform 0.2s;
    }

    .siswa-card .grab {
        position: absolute;
        top: 8px;
        left: 50%;
        width: 42px;
        height: 4px;
        margin-left: -21px;
        border-radius: 4px;
        background: var(--line);
    }

    .siswa-card .sheet-body {
        overflow-y: auto;
        display: grid;
        gap: 9px;
        padding: 0 16px 16px;
    }

    /* Baris data */
    .siswa-card .row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        background: var(--soft);
        border: 1px solid var(--line);
        border-radius: 14px;
        padding: 10px 13px;
    }

    .siswa-card .row .k {
        color: var(--muted);
        font-size: 13.5px;
        flex: none;
        font-weight: 500;
    }

    .siswa-card .row .v {
        display: flex;
        align-items: center;
        gap: 6px;
        font-weight: 600;
        font-size: 14px;
        min-width: 0;
    }

    .siswa-card .row a.mailv {
        color: var(--brand);
        text-decoration: none;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .siswa-card .row a.mailv:hover {
        text-decoration: underline;
    }

    .siswa-card .mini {
        width: 30px;
        height: 30px;
        border-radius: 9px;
        border: 1px solid var(--line);
        background: var(--card);
        display: grid;
        place-items: center;
        color: var(--muted);
        flex: none;
        cursor: pointer;
        transition: all 0.15s;
    }

    .siswa-card .mini svg {
        width: 15px;
        height: 15px;
        flex-shrink: 0;
    }

    .siswa-card .mini:hover {
        color: var(--brand);
        border-color: var(--brand);
    }

    .siswa-card .stats {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
    }

    .siswa-card .stat {
        background: var(--brand-soft);
        border-radius: 14px;
        padding: 10px 12px;
    }

    .siswa-card .stat b {
        display: block;
        font-family: "Bricolage Grotesque", Figtree, sans-serif;
        font-size: 20px;
        line-height: 1;
        color: var(--brand);
        font-variant-numeric: tabular-nums;
    }

    .siswa-card .stat span {
        display: block;
        margin-top: 4px;
        font-size: 12px;
        color: var(--muted);
        font-weight: 600;
    }

    .siswa-card .progress-box {
        background: var(--soft);
        border: 1px solid var(--line);
        border-radius: 14px;
        padding: 10px 13px;
    }

    .siswa-card .activity {
        background: var(--soft);
        border: 1px solid var(--line);
        border-radius: 14px;
        padding: 11px 13px;
    }

    .siswa-card .activity small {
        color: var(--muted);
        font-size: 12px;
        font-weight: 600;
        display: block;
    }

    .siswa-card .activity p {
        margin: 3px 0 0;
        font-weight: 700;
        font-size: 13.5px;
        color: var(--ink);
    }

    .siswa-card .actions {
        display: flex;
        gap: 8px;
        padding: 2px 0 0;
    }

    .siswa-card .btn {
        flex: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        height: 42px;
        border-radius: 14px;
        border: 1px solid var(--line);
        background: var(--card);
        color: var(--ink);
        font-weight: 700;
        font-size: 13.5px;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.15s;
    }

    .siswa-card .btn:hover {
        border-color: var(--brand);
        color: var(--brand);
        background: var(--brand-soft);
    }

    .siswa-card .btn svg {
        width: 18px;
        height: 18px;
        flex-shrink: 0;
    }

    .siswa-card .btn.reset-qr {
        flex: none;
        width: auto;
        padding: 0 14px;
        color: #b45309;
        border-color: #fde68a;
        background: #fffbeb;
    }

    .siswa-card .btn.reset-qr:hover {
        border-color: #d97706;
        background: #fef3c7;
    }

    /* Toast Melayang */
    .siswa-toast {
        position: fixed;
        left: 50%;
        bottom: 28px;
        transform: translate(-50%, 20px);
        background: #1b1a3a;
        color: #ffffff;
        padding: 10px 20px;
        border-radius: 999px;
        font-weight: 600;
        font-size: 13.5px;
        opacity: 0;
        pointer-events: none;
        transition: all 0.25s cubic-bezier(.22, .8, .26, 1);
        z-index: 99999;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3);
    }

    .siswa-toast.show {
        opacity: 1;
        transform: translate(-50%, 0);
    }
</style>
@endpush

@section('header')
<h1 class="text-lg font-bold text-gray-900">Manajemen Akun Siswa</h1>

<div class="flex items-center gap-4">
    <!-- Switch Bahasa -->
    <button class="flex items-center gap-1.5 text-xs font-semibold text-gray-600 bg-gray-50 px-2.5 py-1.5 rounded-lg border border-gray-100">
        <span>ID</span>
        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>
</div>
@endsection

@section('content')
<div class="p-8 space-y-6">

    {{-- Judul Halaman --}}
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Manajemen Siswa</h1>
        <p class="text-sm text-slate-500">Kelola data siswa dan ubah status akun terdaftar di platform e-learning.</p>
    </div>

    {{-- Toast Notifikasi AJAX --}}
    <div id="toast-notification" class="hidden p-4 rounded-xl text-sm flex items-center justify-between transition-all duration-300">
        <div class="flex items-center gap-3">
            <svg id="toast-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span id="toast-message" class="font-medium"></span>
        </div>
        <button onclick="hideToast()" class="text-xs opacity-70 hover:opacity-100">✕</button>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-medium">Total Siswa</p>
                <h3 class="text-xl font-bold text-slate-800">{{ $totalSiswa ?? 0 }}</h3>
            </div>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-medium">Aktif</p>
                <h3 id="stat-aktif" class="text-xl font-bold text-slate-800">{{ $totalAktif ?? 0 }}</h3>
            </div>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="p-3 bg-rose-50 text-rose-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7a4 4 0 11-8 0 4 4 0 018 0zM9 14a6 6 0 00-6 6v1h12v-1a6 6 0 00-6-6zM21 12h-6"></path>
                </svg>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-medium">Nonaktif</p>
                <h3 id="stat-nonaktif" class="text-xl font-bold text-slate-800">{{ $totalNonaktif ?? 0 }}</h3>
            </div>
        </div>


    </div>

    {{-- Filter & Search Bar (Gaya Choice Chip Siswa) --}}
    @php
    $activeKelasFilter = trim((string) request('kelas', ''));
    $activeStatusFilter = trim((string) request('status', ''));
    $activeSearchFilter = trim((string) request('search', ''));
    $hasActiveStudentFilter = $activeKelasFilter !== '' || $activeStatusFilter !== '' || $activeSearchFilter !== '';
    @endphp

    <form id="studentFilterForm" method="GET" action="{{ route('admin.daftar_siswa') }}">
        <input type="hidden" name="kelas" id="student-input-kelas" value="{{ $activeKelasFilter }}">
        <input type="hidden" name="status" id="student-input-status" value="{{ $activeStatusFilter }}">

        <x-student-style-filter-bar
            title="Direktori Siswa"
            icon="🎓"
            countId="student-filtered-count"
            countText="{{ $filteredStudentCount }} Siswa"
            searchId="studentSearchInput"
            searchName="search"
            searchValue="{{ request('search') }}"
            searchPlaceholder="Cari nama, NISN, kelas, atau email siswa..."
            resetId="studentResetBtn"
            resetUrl="{{ route('admin.daftar_siswa') }}"
            :showReset="$hasActiveStudentFilter">

            <x-student-style-filter-chip-bar
                id="student-jenjang-chips"
                label="Jenjang"
                chipClass="student-jenjang-chip"
                dataAttr="data-kelas"
                :chips="[
                    ['value' => '', 'label' => 'Semua Jenjang', 'active' => $activeKelasFilter === ''],
                    ['value' => 'SD', 'label' => 'SD', 'active' => strcasecmp($activeKelasFilter, 'SD') === 0],
                    ['value' => 'SMP', 'label' => 'SMP', 'active' => strcasecmp($activeKelasFilter, 'SMP') === 0],
                    ['value' => 'SMA', 'label' => 'SMA', 'active' => strcasecmp($activeKelasFilter, 'SMA') === 0],
                    ['value' => 'Umum', 'label' => 'Umum', 'active' => strcasecmp($activeKelasFilter, 'Umum') === 0],
                ]" />

            <x-student-style-filter-chip-bar
                id="student-status-chips"
                label="Status Akun"
                chipClass="student-status-chip"
                dataAttr="data-status"
                :chips="[
                    ['value' => '', 'label' => 'Semua Status', 'active' => $activeStatusFilter === ''],
                    ['value' => 'Aktif', 'label' => 'Aktif', 'active' => strcasecmp($activeStatusFilter, 'Aktif') === 0],
                    ['value' => 'Nonaktif', 'label' => 'Nonaktif', 'active' => strcasecmp($activeStatusFilter, 'Nonaktif') === 0],
                ]" />
        </x-student-style-filter-bar>
    </form>

    {{-- Tombol Export Excel --}}
    <div class="mb-4 flex justify-end">
        <a
            href="{{ route('admin.siswa.export', request()->only([
            'search',
            'kelas',
            'status'
        ])) }}"
            class="inline-flex items-center gap-2 rounded-xl
               bg-emerald-600 px-5 py-3 text-sm font-bold
               text-white shadow-sm transition
               hover:bg-emerald-700 hover:shadow-md">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor">
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M12 10v6m0 0l-3-3m3 3l3-3
                   m2 8H7a2 2 0 01-2-2V5
                   a2 2 0 012-2h5l5 5v3" />
            </svg>

            Export Excel
        </a>
    </div>

    <form id="bulk-jenjang-form"
        @csrf
        <input type="hidden" name="search" value="{{ request('search') }}">
        <input type="hidden" name="kelas" value="{{ request('kelas') }}">
        <input type="hidden" name="status" value="{{ request('status') }}">
        <input id="all-filtered-input" type="hidden" name="all_filtered" value="0">

        <div class="mb-4 flex flex-col gap-4 rounded-2xl border border-blue-100 bg-blue-50/60 p-4 md:flex-row md:items-end md:justify-between">
            <div class="space-y-3">
                <div>
                    <h2 class="text-sm font-bold text-slate-800">Ubah jenjang siswa secara massal</h2>
                    <p class="mt-1 text-xs text-slate-500">
                        Pilih siswa pada halaman ini, atau terapkan ke semua {{ $filteredStudentCount }} siswa yang cocok dengan filter.
                    </p>
                </div>
                <label class="flex items-center gap-2 text-sm text-slate-700">
                    <input id="all-filtered-checkbox" type="checkbox" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                    Terapkan ke semua hasil filter ({{ $filteredStudentCount }} siswa)
                </label>
            </div>

            <div class="flex flex-col gap-2 sm:flex-row sm:items-end">
                <label class="text-xs font-medium text-slate-600">
                    Jenjang tujuan
                    <select id="bulk-jenjang-select" name="id_jenjang" required disabled
                        class="mt-1 block w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Pilih jenjang</option>
                        @foreach ($jenjangs as $jenjang)
                        <option value="{{ $jenjang->id_jenjang }}">{{ $jenjang->nama_tipe }}</option>
                        @endforeach
                    </select>
                </label>
                <div>
                    <p id="bulk-selection-count" class="mb-1 text-xs text-slate-500">Pilih siswa terlebih dahulu</p>
                    <button id="bulk-jenjang-submit" type="submit" disabled
                        class="rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50">
                        Ubah jenjang
                    </button>
                </div>
            </div>
        </div>

        {{-- Bar Aksi Pilih Semua, Mode Tampilan, & Informasi Halaman --}}
        <div class="bg-white px-4 py-3 rounded-2xl border border-slate-100 shadow-xs flex flex-wrap items-center justify-between gap-3 mb-6">
            <div class="flex items-center gap-4">
                <label class="flex items-center gap-2.5 text-xs font-bold text-slate-700 cursor-pointer select-none">
                    <input id="select-page-students" type="checkbox" aria-label="Pilih semua siswa di halaman ini"
                        class="rounded border-slate-300 text-blue-600 focus:ring-blue-500 w-4 h-4 cursor-pointer">
                    <span>Pilih Semua Siswa</span>
                </label>

                <div class="h-4 w-px bg-slate-200 hidden sm:block"></div>

                {{-- Toggle Mode Tampilan (Foto vs QR) --}}
                <button type="button" id="globalToggleQrBtn" onclick="toggleAllCardsQr()"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-blue-200 bg-blue-50/70 hover:bg-blue-100 text-blue-700 text-xs font-bold transition cursor-pointer shadow-2xs">
                    <span id="globalToggleIcon">📱</span>
                    <span id="globalToggleText">Tampilkan Semua QR</span>
                </button>
            </div>

            <span class="text-xs text-slate-500 font-semibold px-3 py-1 rounded-full bg-blue-50 text-blue-700 border border-blue-100">
                @if(method_exists($siswas, 'firstItem'))
                Menampilkan {{ $siswas->firstItem() ?? 0 }}-{{ $siswas->lastItem() ?? 0 }} dari {{ $siswas->total() }} siswa
                @else
                Total: {{ count($siswas) }} siswa
                @endif
            </span>
        </div>

        {{-- Grid Card Siswa Bertema Mirip Card Guru --}}
        <div id="siswaGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($siswas as $index => $siswa)
            @php
            $rawStatus = trim((string)($siswa->status_akun ?? 'Aktif'));
            $isNonaktif = strcasecmp($rawStatus, 'Nonaktif') === 0;
            $status = $isNonaktif ? 'Nonaktif' : 'Aktif';
            $statusBg = $isNonaktif ? 'var(--danger)' : 'var(--ok)';
            $monitor = $monitoringSiswa->get($siswa->id_user, []);
            $siswaFoto = $siswa->foto_profil_url ?: (!empty($siswa->foto_profil) ? asset('storage/' . ltrim($siswa->foto_profil, '/')) : null);
            $cleanWa = !empty($siswa->nomor_hp) ? preg_replace('/^0/', '62', preg_replace('/[^\d]/', '', $siswa->nomor_hp)) : '';
            @endphp
            <div class="siswa-card"
                id="siswa-card-{{ $siswa->id_user }}"
                data-id="{{ $siswa->id_user }}"
                data-nama="{{ strtolower($siswa->nama) }}"
                data-email="{{ strtolower($siswa->email) }}"
                data-nisn="{{ strtolower($siswa->nisn ?? '') }}"
                data-kelas="{{ strtolower($siswa->kelas ?? ($siswa->jenjang->nama_tipe ?? '')) }}"
                data-jenjang="{{ strtolower($siswa->jenjang->nama_tipe ?? 'Umum') }}">

                <!-- HERO HEADER (ASPECT RATIO 3:4) -->
                <header class="hero">
                    <!-- LAYER 1: FOTO PROFIL -->
                    <div id="hero-photo-layer-{{ $siswa->id_user }}" class="hero-photo-layer">
                        @if(!empty($siswaFoto))
                        <img id="foto-{{ $siswa->id_user }}"
                            src="{{ $siswaFoto }}"
                            alt="Foto {{ $siswa->nama }}"
                            loading="lazy"
                            class="hero-img"
                            onerror="this.style.display='none'; document.getElementById('fallback-{{ $siswa->id_user }}').style.display='flex';">
                        <div id="fallback-{{ $siswa->id_user }}" class="hero-fallback" style="display: none;">
                            <div class="hero-fallback-avatar">
                                {{ strtoupper(substr($siswa->nama ?? 'S', 0, 1)) }}
                            </div>
                            <span class="hero-fallback-badge">Foto Belum Diatur</span>
                        </div>
                        @else
                        <div id="fallback-{{ $siswa->id_user }}" class="hero-fallback" style="display: flex;">
                            <div class="hero-fallback-avatar">
                                {{ strtoupper(substr($siswa->nama ?? 'S', 0, 1)) }}
                            </div>
                            <span class="hero-fallback-badge">Foto Belum Diatur</span>
                        </div>
                        @endif
                    </div>

                    <!-- LAYER 2: QR CODE VIEW (MUNCUL KETIKA MODE QR DIAKTIFKAN) -->
                    <div id="hero-qr-layer-{{ $siswa->id_user }}"
                        class="hero-qr-layer hidden"
                        onclick="openQrPreviewModal('{{ $siswa->id_user }}')"
                        title="Klik untuk memperbesar / cetak QR Presensi">
                        <div class="hero-qr-box" id="avatar-qr-{{ $siswa->id_user }}">
                            {!! $siswa->qrSvg(140) !!}
                        </div>
                        <span class="hero-qr-badge">
                            <svg width="10" height="10" class="w-2.5 h-2.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                            </svg>
                            <span>Pindai / Cetak QR</span>
                        </span>
                    </div>

                    <!-- BADGES ATAS: CHECKBOX + JENJANG (KIRI) & STATUS INTERAKTIF (KANAN) -->
                    <div class="badges">
                        <div class="flex items-center gap-1.5">
                            <label class="check-btn" title="Pilih Siswa (Ubah Massal)">
                                <input type="checkbox" name="student_ids[]" value="{{ $siswa->id_user }}"
                                    aria-label="Pilih {{ $siswa->nama }}" data-student-checkbox
                                    class="rounded border-white/50 text-blue-600 focus:ring-blue-500 w-3.5 h-3.5 cursor-pointer">
                            </label>

                            <span class="pill role">
                                <svg width="12" height="12" class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                                </svg>
                                <span>{{ $siswa->jenjang->nama_tipe ?? $siswa->kelas ?? 'Siswa' }}</span>
                            </span>
                        </div>

                        <div class="pill status" id="pill-status-{{ $siswa->id_user }}" style="background: {{ $statusBg }};">
                            <select id="select-status-{{ $siswa->id_user }}"
                                data-current-status="{{ $status }}"
                                onchange="confirmStatusChange('{{ $siswa->id_user }}', '{{ addslashes($siswa->nama) }}', this)"
                                title="Ubah status siswa">
                                <option value="Aktif" {{ $status === 'Aktif' ? 'selected' : '' }} class="bg-white text-slate-800">● Aktif</option>
                                <option value="Nonaktif" {{ $status === 'Nonaktif' ? 'selected' : '' }} class="bg-white text-slate-800">● Nonaktif</option>
                            </select>
                            <svg width="9" height="9" class="w-2 h-2 shrink-0 -ml-1 pointer-events-none text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m6 9 6 6 6-6" />
                            </svg>
                        </div>
                    </div>

                    <!-- TOMBOL BULAT TOGGLE FOTO <-> QR (SEPERTI KAMERA PADA CARD GURU) -->
                    <button type="button"
                        id="btn-toggle-qr-{{ $siswa->id_user }}"
                        onclick="toggleSingleCardQr('{{ $siswa->id_user }}')"
                        class="photo-btn student-toggle-btn"
                        aria-label="Beralih ke QR Presensi / Foto Profil"
                        title="Beralih ke QR Presensi">
                        <!-- Ikon QR Code (saat mode Foto) -->
                        <svg id="icon-show-qr-{{ $siswa->id_user }}" width="15" height="15" style="width:15px;height:15px;max-width:15px;max-height:15px;flex-shrink:0;" class="w-[15px] h-[15px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="7" height="7" rx="1" />
                            <rect x="14" y="3" width="7" height="7" rx="1" />
                            <rect x="3" y="14" width="7" height="7" rx="1" />
                            <path d="M14 14h3v3h-3z" />
                            <path d="M20 14v3" />
                            <path d="M14 20h6" />
                        </svg>
                        <!-- Ikon Foto Profil (saat mode QR) -->
                        <svg id="icon-show-photo-{{ $siswa->id_user }}" width="15" height="15" style="width:15px;height:15px;max-width:15px;max-height:15px;flex-shrink:0;" class="w-[15px] h-[15px] shrink-0 hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                            <circle cx="12" cy="7" r="4" />
                        </svg>
                    </button>

                    <!-- IDENTITAS SISWA: NAMA, WHATSAPP, & TOMBOL BUKA INFO -->
                    <div class="ident">
                        <a href="{{ route('admin.siswa.profil', $siswa->id_user) }}" class="block">
                            <h3 title="{{ $siswa->nama }}">{{ $siswa->nama }}</h3>
                        </a>

                        @if(!empty($cleanWa))
                        <a class="mail" href="https://wa.me/{{ $cleanWa }}" target="_blank" rel="noopener" title="Kirim Pesan WhatsApp">
                            <svg width="14" height="14" class="w-3.5 h-3.5 shrink-0 text-emerald-400" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86.173.086.275.071.376-.043.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.099.824z" />
                            </svg>
                            <span>{{ $siswa->nomor_hp }}</span>
                        </a>
                        @else
                        <span class="mail text-white/60 text-xs">
                            <span>No. HP belum terdaftar</span>
                        </span>
                        @endif

                        <button type="button"
                            class="toggle btn-open-sheet"
                            data-target="sheet-{{ $siswa->id_user }}"
                            aria-expanded="false"
                            aria-controls="sheet-{{ $siswa->id_user }}">
                            <span>Lihat info lengkap</span>
                            <svg width="18" height="18" style="width:18px;height:18px;max-width:18px;max-height:18px;flex-shrink:0;" class="w-[18px] h-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m6 15 6-6 6 6" />
                            </svg>
                        </button>
                    </div>
                </header>

                <!-- SCRIM BACKDROP -->
                <div class="scrim" id="scrim-{{ $siswa->id_user }}" data-target="sheet-{{ $siswa->id_user }}"></div>

                <!-- PANEL BOTTOM SHEET INFO LENGKAP -->
                <section class="sheet" id="sheet-{{ $siswa->id_user }}" aria-label="Info lengkap {{ $siswa->nama }}" inert>
                    <button type="button"
                        class="sheet-head btn-close-sheet"
                        data-target="sheet-{{ $siswa->id_user }}"
                        aria-expanded="true"
                        aria-controls="sheet-{{ $siswa->id_user }}">
                        <i class="grab"></i>
                        <span>Sembunyikan info</span>
                        <svg width="18" height="18" style="width:18px;height:18px;max-width:18px;max-height:18px;flex-shrink:0;" class="w-[18px] h-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m6 9 6 6 6-6" />
                        </svg>
                    </button>

                    <div class="sheet-body">
                        <!-- BARIS NISN -->
                        <div class="row">
                            <span class="k">NISN</span>
                            <span class="v">
                                <span class="font-mono text-slate-800">{{ $siswa->nisn ?? 'Belum diisi' }}</span>
                                @if(!empty($siswa->nisn))
                                <button type="button"
                                    class="mini btn-copy-nisn"
                                    data-nisn="{{ $siswa->nisn }}"
                                    data-nama="{{ $siswa->nama }}"
                                    aria-label="Salin NISN"
                                    title="Salin NISN">
                                    <svg width="15" height="15" class="w-[15px] h-[15px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="9" y="9" width="11" height="11" rx="2" />
                                        <path d="M5 15V6a2 2 0 0 1 2-2h9" />
                                    </svg>
                                </button>
                                @endif
                            </span>
                        </div>

                        <!-- BARIS EMAIL -->
                        <div class="row">
                            <span class="k">Email</span>
                            @if(!empty($siswa->email))
                            <a class="v mailv" href="mailto:{{ $siswa->email }}" title="{{ $siswa->email }}">
                                {{ $siswa->email }}
                            </a>
                            @else
                            <span class="v text-slate-400 font-normal">Belum ada email</span>
                            @endif
                        </div>

                        <!-- BARIS TOTAL POIN -->
                        <div class="row">
                            <span class="k">Total Poin</span>
                            <span class="v font-bold text-amber-600">
                                ★ {{ number_format($siswa->total_poin ?? 0) }} Poin
                            </span>
                        </div>

                        <!-- 4 STATISTIK UTAMA (MODUL, KUIS, NILAI, HADIR) -->
                        <div class="stats">
                            <div class="stat">
                                <b>{{ $monitor['modul_tuntas'] ?? 0 }}/{{ $monitor['jumlah_modul'] ?? 0 }}</b>
                                <span>Modul tuntas</span>
                            </div>
                            <div class="stat">
                                <b>{{ isset($monitor['rata_nilai']) ? number_format($monitor['rata_nilai'], 1) . '%' : '-' }}</b>
                                <span>Rata-rata kuis</span>
                            </div>
                            <div class="stat">
                                <b>{{ (int) ($monitor['jumlah_kuis'] ?? 0) }}</b>
                                <span>Kuis dikerjakan</span>
                            </div>
                            <div class="stat">
                                <b>{{ (int) ($monitor['jumlah_hadir'] ?? 0) }} kali</b>
                                <span>Kehadiran</span>
                            </div>
                        </div>

                        <!-- PROGRES BELAJAR -->
                        <div class="progress-box">
                            <div class="flex items-center justify-between text-xs mb-1.5">
                                <span class="font-bold text-slate-700">Progres modul</span>
                                <span class="font-extrabold text-blue-600">{{ $monitor['persen_progres'] ?? 0 }}%</span>
                            </div>
                            <div class="h-2 rounded-full bg-slate-200 overflow-hidden">
                                <div class="h-full rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 transition-all duration-500" style="width: {{ $monitor['persen_progres'] ?? 0 }}%"></div>
                            </div>
                        </div>

                        <!-- AKTIVITAS TERAKHIR -->
                        <div class="activity">
                            <small>Aktivitas terakhir</small>
                            <p>{{ ($monitor['aktivitas_terakhir'] ?? null)?->diffForHumans() ?? 'Belum ada aktivitas baru' }}</p>
                            @if($monitor['perlu_perhatian'] ?? false)
                            <small class="text-amber-700 font-bold block mt-1">⚠️ Perlu perhatian: {{ $monitor['perlu_perhatian'] }}</small>
                            @endif
                        </div>

                        <!-- TOMBOL AKSI: LIHAT PROFIL & RESET QR -->
                        <div class="actions">
                            <a href="{{ route('admin.siswa.profil', $siswa->id_user) }}" class="btn" title="Lihat Profil Lengkap">
                                <svg width="18" height="18" style="width:18px;height:18px;max-width:18px;max-height:18px;flex-shrink:0;" class="w-[18px] h-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <span>Profil</span>
                            </a>

                            <button type="button"
                                class="btn reset-qr"
                                onclick="triggerRegenerateQr('{{ route('admin.qr.regenerate', $siswa->id_user) }}', '{{ addslashes($siswa->nama) }}')"
                                title="Buat ulang token QR untuk {{ $siswa->nama }}">
                                <svg width="18" height="18" style="width:18px;height:18px;max-width:18px;max-height:18px;flex-shrink:0;" class="w-[18px] h-[18px] shrink-0 text-amber-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                <span>Reset QR</span>
                            </button>
                        </div>
                    </div>
                </section>
            </div>
            @empty
            <div class="col-span-full bg-white rounded-2xl border border-dashed border-slate-200 p-12 text-center shadow-xs">
                <div class="w-16 h-16 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-800">Tidak ada data siswa ditemukan</h3>
                <p class="text-sm text-slate-500 max-w-sm mx-auto mt-1">Coba sesuaikan kata kunci pencarian atau filter yang dipilih.</p>
            </div>
            @endforelse
        </div>

        {{-- Footer & Pagination --}}
        <div class="mt-6 p-4 bg-white rounded-2xl border border-slate-100 shadow-xs flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-slate-400">
            <div>
                @if(method_exists($siswas, 'firstItem'))
                Menampilkan {{ $siswas->firstItem() ?? 0 }}-{{ $siswas->lastItem() ?? 0 }} dari {{$siswas->total() }} siswa
                @else
                Menampilkan {{ count($siswas) }} siswa
                @endif
            </div>
            <div>
                @if(method_exists($siswas, 'links'))
                {{ $siswas->links() }}
                @endif
            </div>
        </div>
    </form>

    {{-- Form Tersembunyi untuk Regenerasi QR Siswa (Menghindari Nested Form) --}}
    <form id="standalone-regenerate-qr-form" method="POST" action="" class="hidden">
        @csrf
    </form>

</div>

{{-- MODAL KONFIRMASI UBAH JENJANG MASSAL --}}
<div id="bulkJenjangModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-slate-900/50 px-4 backdrop-blur-sm transition-opacity">
    <div class="w-full max-w-md space-y-4 rounded-2xl border border-slate-100 bg-white p-6 shadow-xl">
        <div class="flex items-center gap-3">
            <div class="rounded-full bg-amber-50 p-3 text-amber-600">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <div>
                <h3 class="text-base font-bold text-slate-800">Konfirmasi Ubah Jenjang</h3>
                <p class="text-xs text-slate-500">Pastikan pilihan siswa dan jenjang tujuan sudah benar.</p>
            </div>
        </div>

        <p id="bulkJenjangModalDescription" class="text-sm leading-relaxed text-slate-600"></p>

        <div class="flex justify-end gap-3 pt-2">
            <button id="cancelBulkJenjang" type="button" class="rounded-xl px-4 py-2 text-xs font-semibold text-slate-600 transition hover:bg-slate-100">
                Batal
            </button>
            <button id="confirmBulkJenjang" type="button" class="rounded-xl bg-blue-600 px-4 py-2 text-xs font-semibold text-white transition hover:bg-blue-700">
                Ya, Ubah Jenjang
            </button>
        </div>
    </div>
</div>

{{-- MODAL PERINGATAN KONFIRMASI UBAH STATUS --}}
<div id="statusModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-slate-900/50 backdrop-blur-sm transition-opacity">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl space-y-4 border border-slate-100 animate-in fade-in zoom-in duration-150">
        <div class="flex items-center gap-3">
            <div class="p-3 bg-amber-50 text-amber-600 rounded-full">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <div>
                <h3 class="text-base font-bold text-slate-800">Konfirmasi Perubahan Status</h3>
                <p class="text-xs text-slate-500">Tindakan ini mempengaruhi akses siswa ke sistem.</p>
            </div>
        </div>

        <p id="modalDescription" class="text-sm text-slate-600 leading-relaxed"></p>

        <div class="flex justify-end gap-3 pt-2">
            <button onclick="closeModal()" class="px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-xl transition">
                Batal
            </button>
            <button id="btnConfirmSubmit" onclick="submitStatusUpdate()" class="px-4 py-2 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition flex items-center gap-2">
                <span>Ya, Ubah Status</span>
            </button>
        </div>
    </div>
</div>

{{-- MODAL PREVIEW QR CODE SISWA --}}
<div id="qrPreviewModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4 transition-all duration-200">
    <div class="bg-white rounded-3xl max-w-sm w-full p-6 shadow-2xl border border-slate-100 flex flex-col items-center text-center relative">
        <!-- Tombol Tutup -->
        <button type="button" onclick="closeQrPreviewModal()" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 p-1.5 rounded-full hover:bg-slate-100 transition cursor-pointer">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <!-- Badge & Header -->
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-100 mb-2">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            <span id="modalQrJenjang">Jenjang</span>
        </span>
        <h3 id="modalQrNama" class="text-lg font-bold text-slate-800 leading-snug">Nama Siswa</h3>
        <p id="modalQrNisn" class="text-xs text-slate-500 font-mono mt-0.5">NISN: -</p>

        <!-- Wadah QR SVG Besar -->
        <div class="my-4 p-4 bg-white rounded-2xl border-2 border-slate-100 shadow-inner flex items-center justify-center">
            <div id="modalQrSvgContainer" class="w-52 h-52 flex items-center justify-center [&>svg]:w-full [&>svg]:h-full">
                <!-- SVG dimuat dinamis -->
            </div>
        </div>

        <p class="text-[11px] text-slate-400 max-w-xs leading-relaxed mb-4">
            QR code presensi kehadiran kelas siswa. Pindai langsung menggunakan scanner presensi guru.
        </p>

        <!-- Action Buttons -->
        <div class="w-full grid grid-cols-2 gap-2">
            <button type="button" onclick="unduhQrFromModal()" class="w-full py-2.5 px-3 rounded-xl bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white font-semibold text-xs transition flex items-center justify-center gap-1.5 shadow-sm cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                <span>Unduh PNG</span>
            </button>
            <button type="button" onclick="cetakQrFromModal()" class="w-full py-2.5 px-3 rounded-xl bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-semibold text-xs transition flex items-center justify-center gap-1.5 shadow-2xs cursor-pointer">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                <span>Cetak Kartu</span>
            </button>
        </div>

        <button type="button" id="modalRegenerateBtn" onclick="" class="mt-3.5 text-xs text-amber-600 hover:text-amber-700 font-medium hover:underline flex items-center gap-1 cursor-pointer">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
            </svg>
            <span>Buat Ulang (Regenerasi) Token QR Ini</span>
        </button>
    </div>
</div>

<!-- FLOATING TOAST NOTIFIKASI SISWA -->
<div class="siswa-toast" id="siswaToast" role="status" aria-live="polite"></div>

<script>
    let pendingData = null;
    let isAllQrMode = false;
    let activeModalStudentId = null;

    const studentQrData = {
        @foreach($siswas as $s)
        '{{ $s->id_user }}': {
            name: @json($s -> nama),
            nisn: @json($s -> nisn ?? '-'),
            jenjang: @json($s -> jenjang ? ($s -> nama_tipe ?? $s -> kelas ?? 'Siswa') : 'Siswa'),
        },
        @endforeach
    };

    function toggleSingleCardQr(id) {
        const photoLayer = document.getElementById('hero-photo-layer-' + id);
        const qrLayer = document.getElementById('hero-qr-layer-' + id);
        const iconQr = document.getElementById('icon-show-qr-' + id);
        const iconPhoto = document.getElementById('icon-show-photo-' + id);
        const btn = document.getElementById('btn-toggle-qr-' + id);

        if (!photoLayer || !qrLayer) return;

        const isCurrentlyQr = !qrLayer.classList.contains('hidden');

        if (isCurrentlyQr) {
            qrLayer.classList.add('hidden');
            photoLayer.classList.remove('hidden');
            if (iconQr) iconQr.classList.remove('hidden');
            if (iconPhoto) iconPhoto.classList.add('hidden');
            if (btn) btn.setAttribute('title', 'Beralih ke QR Presensi');
        } else {
            photoLayer.classList.add('hidden');
            qrLayer.classList.remove('hidden');
            if (iconQr) iconQr.classList.add('hidden');
            if (iconPhoto) iconPhoto.classList.remove('hidden');
            if (btn) btn.setAttribute('title', 'Beralih ke Foto Profil');
        }
    }

    function toggleAllCardsQr() {
        isAllQrMode = !isAllQrMode;

        const globalIcon = document.getElementById('globalToggleIcon');
        const globalText = document.getElementById('globalToggleText');

        if (globalIcon && globalText) {
            if (isAllQrMode) {
                globalIcon.textContent = '👤';
                globalText.textContent = 'Tampilkan Semua Foto';
            } else {
                globalIcon.textContent = '📱';
                globalText.textContent = 'Tampilkan Semua QR';
            }
        }

        const cards = document.querySelectorAll('.siswa-card');
        cards.forEach(card => {
            const id = card.getAttribute('data-id');
            const photoLayer = document.getElementById('hero-photo-layer-' + id);
            const qrLayer = document.getElementById('hero-qr-layer-' + id);
            const iconQr = document.getElementById('icon-show-qr-' + id);
            const iconPhoto = document.getElementById('icon-show-photo-' + id);
            const btn = document.getElementById('btn-toggle-qr-' + id);

            if (photoLayer && qrLayer) {
                if (isAllQrMode) {
                    photoLayer.classList.add('hidden');
                    qrLayer.classList.remove('hidden');
                    if (iconQr) iconQr.classList.add('hidden');
                    if (iconPhoto) iconPhoto.classList.remove('hidden');
                    if (btn) btn.setAttribute('title', 'Beralih ke Foto Profil');
                } else {
                    qrLayer.classList.add('hidden');
                    photoLayer.classList.remove('hidden');
                    if (iconQr) iconQr.classList.remove('hidden');
                    if (iconPhoto) iconPhoto.classList.add('hidden');
                    if (btn) btn.setAttribute('title', 'Beralih ke QR Presensi');
                }
            }
        });
    }

    // ==========================================
    // TOAST NOTIFIKASI SISWA
    // ==========================================
    const siswaToast = document.getElementById('siswaToast');
    let siswaToastTimer;

    function showSiswaToast(message) {
        if (!siswaToast) return;
        siswaToast.textContent = message;
        siswaToast.classList.add('show');
        clearTimeout(siswaToastTimer);
        siswaToastTimer = setTimeout(() => {
            siswaToast.classList.remove('show');
        }, 2200);
    }

    // ==========================================
    // BOTTOM SHEET SISWA (BUKA / TUTUP PANEL INFO)
    // ==========================================
    function setSiswaSheetOpen(sheetId, isOpen) {
        const sheet = document.getElementById(sheetId);
        if (!sheet) return;
        const card = sheet.closest('.siswa-card');
        const scrim = card ? card.querySelector('.scrim') : null;
        const toggleBtn = card ? card.querySelector('.btn-open-sheet') : null;

        sheet.classList.toggle('open', isOpen);
        if (scrim) scrim.classList.toggle('open', isOpen);

        if (isOpen) {
            sheet.removeAttribute('inert');
        } else {
            sheet.setAttribute('inert', '');
        }

        if (toggleBtn) {
            toggleBtn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        }
    }

    // Delegasi klik sheet open, sheet close, scrim, dan salin NISN
    document.addEventListener('click', (e) => {
        const openBtn = e.target.closest('.btn-open-sheet');
        if (openBtn) {
            const targetId = openBtn.getAttribute('data-target');
            if (targetId) setSiswaSheetOpen(targetId, true);
            return;
        }

        const closeBtn = e.target.closest('.btn-close-sheet');
        if (closeBtn) {
            const targetId = closeBtn.getAttribute('data-target');
            if (targetId) setSiswaSheetOpen(targetId, false);
            return;
        }

        const scrim = e.target.closest('.scrim');
        if (scrim) {
            const targetId = scrim.getAttribute('data-target');
            if (targetId) setSiswaSheetOpen(targetId, false);
            return;
        }

        // Salin NISN
        const copyNisnBtn = e.target.closest('.btn-copy-nisn');
        if (copyNisnBtn) {
            const nisn = copyNisnBtn.getAttribute('data-nisn') || '';
            const nama = copyNisnBtn.getAttribute('data-nama') || 'Siswa';
            if (!nisn) return;

            function onCopySuccess() {
                showSiswaToast(`NISN ${nama} disalin ✓`);
            }

            function onCopyFail() {
                showSiswaToast('Gagal menyalin NISN');
            }

            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(nisn).then(onCopySuccess, onCopyFail);
            } else {
                try {
                    const temp = document.createElement('textarea');
                    temp.value = nisn;
                    temp.style.position = 'fixed';
                    temp.style.opacity = '0';
                    document.body.appendChild(temp);
                    temp.select();
                    const res = document.execCommand('copy');
                    document.body.removeChild(temp);
                    if (res) onCopySuccess();
                    else onCopyFail();
                } catch (err) {
                    onCopyFail();
                }
            }
            return;
        }
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            document.querySelectorAll('.siswa-card .sheet.open').forEach(sheet => {
                setSiswaSheetOpen(sheet.id, false);
            });
        }
    });

    function openQrPreviewModal(id) {
        const data = studentQrData[id];
        if (!data) return;

        activeModalStudentId = id;
        document.getElementById('modalQrNama').textContent = data.name;
        document.getElementById('modalQrNisn').textContent = 'NISN: ' + data.nisn;
        document.getElementById('modalQrJenjang').textContent = data.jenjang;

        const cardQr = document.querySelector('#avatar-qr-' + id + ' svg');
        const container = document.getElementById('modalQrSvgContainer');
        if (cardQr && container) {
            container.innerHTML = cardQr.outerHTML;
            const svgInModal = container.querySelector('svg');
            if (svgInModal) {
                svgInModal.setAttribute('width', '208');
                svgInModal.setAttribute('height', '208');
            }
        }

        const regBtn = document.getElementById('modalRegenerateBtn');
        if (regBtn) {
            regBtn.onclick = function() {
                triggerRegenerateQr(data.regenerateUrl, data.name);
            };
        }

        document.getElementById('qrPreviewModal').classList.remove('hidden');
    }

    function closeQrPreviewModal() {
        document.getElementById('qrPreviewModal').classList.add('hidden');
        activeModalStudentId = null;
    }

    function unduhQrFromModal() {
        if (!activeModalStudentId) return;
        const data = studentQrData[activeModalStudentId];
        const svg = document.querySelector('#modalQrSvgContainer svg');
        if (!svg) {
            alert('QR code tidak ditemukan.');
            return;
        }

        svg.setAttribute('xmlns', 'http://www.w3.org/2000/svg');
        const xml = new XMLSerializer().serializeToString(svg);
        const img = new Image();
        img.onload = function() {
            const ukuran = 900,
                pad = 50;
            const canvas = document.createElement('canvas');
            canvas.width = ukuran;
            canvas.height = ukuran;
            const ctx = canvas.getContext('2d');
            ctx.fillStyle = '#ffffff';
            ctx.fillRect(0, 0, ukuran, ukuran);
            ctx.imageSmoothingEnabled = false;
            ctx.drawImage(img, pad, pad, ukuran - pad * 2, ukuran - pad * 2);

            canvas.toBlob(function(blob) {
                if (!blob) return;
                const a = document.createElement('a');
                a.href = URL.createObjectURL(blob);
                const safeName = (data.name || 'siswa').toLowerCase().replace(/[^a-z0-9]+/g, '-');
                a.download = `QR-Presensi-${safeName}.png`;
                document.body.appendChild(a);
                a.click();
                a.remove();
                setTimeout(() => URL.revokeObjectURL(a.href), 1000);
            }, 'image/png');
        };
        img.src = 'data:image/svg+xml;charset=utf-8,' + encodeURIComponent(xml);
    }

    function cetakQrFromModal() {
        if (!activeModalStudentId) return;
        const data = studentQrData[activeModalStudentId];
        const svg = document.querySelector('#modalQrSvgContainer svg');
        if (!svg) return;

        svg.setAttribute('xmlns', 'http://www.w3.org/2000/svg');
        const svgHtml = svg.outerHTML;

        const printWindow = window.open('', '_blank', 'width=600,height=700');
        if (!printWindow) {
            alert('Pop-up terblokir oleh browser. Izinkan pop-up untuk mencetak kartu QR.');
            return;
        }

        printWindow.document.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <title>Cetak QR Presensi - ${data.name}</title>
                <style>
                    body {
                        font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        min-height: 100vh;
                        margin: 0;
                        background: #f8fafc;
                    }
                    .card {
                        background: #fff;
                        border: 2px solid #e2e8f0;
                        border-radius: 20px;
                        padding: 32px;
                        text-align: center;
                        width: 320px;
                        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
                    }
                    .badge {
                        display: inline-block;
                        padding: 4px 12px;
                        background: #eff6ff;
                        color: #1d4ed8;
                        border-radius: 9999px;
                        font-size: 11px;
                        font-weight: 700;
                        margin-bottom: 12px;
                        border: 1px solid #bfdbfe;
                    }
                    h2 {
                        margin: 0 0 4px;
                        font-size: 18px;
                        color: #0f172a;
                    }
                    p {
                        margin: 0 0 20px;
                        font-size: 13px;
                        color: #64748b;
                        font-family: monospace;
                    }
                    .qr-wrap {
                        display: flex;
                        justify-content: center;
                        margin-bottom: 20px;
                    }
                    .qr-wrap svg {
                        width: 220px;
                        height: 220px;
                    }
                    .footer {
                        font-size: 11px;
                        color: #94a3b8;
                        line-height: 1.4;
                    }
                    @media print {
                        body { background: #fff; }
                        .card { border: 2px solid #000; box-shadow: none; }
                    }
                </style>
            </head>
            <body>
                <div class="card">
                    <div class="badge">${data.jenjang}</div>
                    <h2>${data.name}</h2>
                    <p>NISN: ${data.nisn}</p>
                    <div class="qr-wrap">
                        ${svgHtml}
                    </div>
                    <div class="footer">
                        Kartu Presensi Siswa Arrava<br>Pindai untuk presensi kehadiran kelas
                    </div>
                </div>
                <script>
                    window.onload = function() {
                        window.print();
                        window.onafterprint = function() { window.close(); };
                    };
                <\/script>
            </body>
            </html>
        `);
        printWindow.document.close();
    }

    function triggerRegenerateQr(url, name) {
        if (confirm('Buat ulang QR untuk ' + name + '? QR lama tidak akan berlaku lagi.')) {
            const form = document.getElementById('standalone-regenerate-qr-form');
            form.action = url;
            form.submit();
        }
    }

    function submitStudentFilterForm() {
        const form = document.getElementById('studentFilterForm');
        if (!form) return;

        const search = (form.querySelector('[name="search"]')?.value || '').trim();
        const kelas = (form.querySelector('[name="kelas"]')?.value || '').trim();
        const status = (form.querySelector('[name="status"]')?.value || '').trim();

        if (!search && !kelas && !status) {
            window.location.href = "{{ route('admin.daftar_siswa') }}";
            return;
        }

        form.submit();
    }

    (function initStudentChoiceChipFilters() {
        const filterHelper = window.ArravaStudentFilter;
        const form = document.getElementById('studentFilterForm');
        const searchInput = document.getElementById('studentSearchInput');
        const searchClear = document.getElementById('studentSearchInputClear');
        const jenjangContainer = document.getElementById('student-jenjang-chips');
        const statusContainer = document.getElementById('student-status-chips');
        const inputKelas = document.getElementById('student-input-kelas');
        const inputStatus = document.getElementById('student-input-status');
        const resetBtn = document.getElementById('studentResetBtn');
        const initialServerSearch = @json(trim((string) request('search', '')));
        let searchSubmitTimer = null;

        function filterVisibleStudentCards() {
            if (!searchInput) return;
            const keyword = searchInput.value.toLowerCase().trim();
            document.querySelectorAll('.siswa-card').forEach(card => {
                const nama = card.dataset.nama || '';
                const nisn = card.dataset.nisn || '';
                const kelas = card.dataset.kelas || '';
                const email = card.dataset.email || '';
                const jenjang = card.dataset.jenjang || '';

                const matches = keyword === '' ||
                    nama.includes(keyword) ||
                    nisn.includes(keyword) ||
                    kelas.includes(keyword) ||
                    email.includes(keyword) ||
                    jenjang.includes(keyword);

                card.style.display = matches ? 'flex' : 'none';
            });
        }

        if (jenjangContainer && inputKelas) {
            jenjangContainer.addEventListener('click', (e) => {
                const btn = e.target.closest('[data-kelas]');
                if (!btn) return;
                const val = btn.getAttribute('data-kelas') || '';
                inputKelas.value = val;
                if (filterHelper) {
                    filterHelper.setActiveChip(jenjangContainer, val, 'data-kelas');
                }
                submitStudentFilterForm();
            });
        }

        if (statusContainer && inputStatus) {
            statusContainer.addEventListener('click', (e) => {
                const btn = e.target.closest('[data-status]');
                if (!btn) return;
                const val = btn.getAttribute('data-status') || '';
                inputStatus.value = val;
                if (filterHelper) {
                    filterHelper.setActiveChip(statusContainer, val, 'data-status');
                }
                submitStudentFilterForm();
            });
        }

        if (filterHelper && searchInput) {
            filterHelper.bindSearchClear(searchInput, searchClear, () => {
                filterVisibleStudentCards();
                if (searchSubmitTimer) clearTimeout(searchSubmitTimer);
                const current = searchInput.value.trim();
                if (current === '' && initialServerSearch !== '') {
                    submitStudentFilterForm();
                    return;
                }
                if (current !== initialServerSearch) {
                    searchSubmitTimer = setTimeout(submitStudentFilterForm, 600);
                }
            });
        }

        if (form && searchInput) {
            form.addEventListener('submit', (e) => {
                if (searchSubmitTimer) clearTimeout(searchSubmitTimer);
                if (!searchInput.value.trim() && !inputKelas?.value.trim() && !inputStatus?.value.trim()) {
                    e.preventDefault();
                    window.location.href = "{{ route('admin.daftar_siswa') }}";
                }
            });
        }

        if (resetBtn) {
            resetBtn.addEventListener('click', () => {
                window.location.href = "{{ route('admin.daftar_siswa') }}";
            });
        }
    })();

    // Modal Confirmation Logic
    function confirmStatusChange(id, name, selectElement) {
        const newStatus = selectElement.value;
        const oldStatus = selectElement.getAttribute('data-current-status');

        if (newStatus === oldStatus) return;

        pendingData = {
            id: id,
            name: name,
            newStatus: newStatus,
            oldStatus: oldStatus,
            selectElement: selectElement
        };

        let message = `Apakah Anda yakin ingin mengubah status <strong>${name}</strong> dari <span class="font-semibold text-slate-700">${oldStatus}</span> menjadi <span class="font-semibold text-blue-600">${newStatus}</span>?`;

        if (newStatus === 'Nonaktif') {
            message += `<br><span class="text-xs text-rose-500 mt-2 block">⚠️ Siswa ini tidak akan bisa login ke platform e-learning selama statusnya nonaktif.</span>`;
        }

        document.getElementById('modalDescription').innerHTML = message;
        document.getElementById('statusModal').classList.remove('hidden');
    }

    function closeModal() {
        if (pendingData) {
            // Revert select back to previous status if cancelled
            pendingData.selectElement.value = pendingData.oldStatus;
            const pillEl = document.getElementById('pill-status-' + pendingData.id);
            if (pillEl) {
                pillEl.style.background = (pendingData.oldStatus === 'Nonaktif') ? 'var(--danger)' : 'var(--ok)';
            }
            pendingData = null;
        }
        document.getElementById('statusModal').classList.add('hidden');
    }

    // Process Status Update via AJAX (Fetch API)
    function submitStatusUpdate() {
        if (!pendingData) return;

        const btn = document.getElementById('btnConfirmSubmit');
        btn.disabled = true;
        btn.innerText = 'Memproses...';

        const url = "{{ route('admin.siswa.status', ':id') }}".replace(':id', pendingData.id);

        fetch(url, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    status: pendingData.newStatus
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update dropdown state & pill background
                    const selectEl = pendingData.selectElement;
                    selectEl.setAttribute('data-current-status', pendingData.newStatus);
                    selectEl.value = pendingData.newStatus;

                    const pillEl = document.getElementById('pill-status-' + pendingData.id);
                    if (pillEl) {
                        pillEl.style.background = (pendingData.newStatus === 'Nonaktif') ? 'var(--danger)' : 'var(--ok)';
                    }

                    showToast('success', data.message || `Status ${pendingData.name} berhasil diperbarui.`);
                } else {
                    showToast('error', data.message || 'Gagal memperbarui status.');
                    pendingData.selectElement.value = pendingData.oldStatus;
                    const pillEl = document.getElementById('pill-status-' + pendingData.id);
                    if (pillEl) {
                        pillEl.style.background = (pendingData.oldStatus === 'Nonaktif') ? 'var(--danger)' : 'var(--ok)';
                    }
                }
            })
            .catch(err => {
                console.error(err);
                showToast('error', 'Terjadi kesalahan sistem.');
                pendingData.selectElement.value = pendingData.oldStatus;
                const pillEl = document.getElementById('pill-status-' + pendingData.id);
                if (pillEl) {
                    pillEl.style.background = (pendingData.oldStatus === 'Nonaktif') ? 'var(--danger)' : 'var(--ok)';
                }
            })
            .finally(() => {
                btn.disabled = false;
                btn.innerText = 'Ya, Ubah Status';
                pendingData = null;
                document.getElementById('statusModal').classList.add('hidden');
            });
    }

    function showToast(type, message) {
        const toast = document.getElementById('toast-notification');
        const toastMessage = document.getElementById('toast-message');

        toastMessage.innerText = message;
        toast.className = 'p-4 rounded-xl text-sm flex items-center justify-between transition-all duration-300 ';

        if (type === 'success') {
            toast.classList.add('bg-emerald-50', 'border', 'border-emerald-200', 'text-emerald-700');
        } else {
            toast.classList.add('bg-rose-50', 'border', 'border-rose-200', 'text-rose-700');
        }

        toast.classList.remove('hidden');
        setTimeout(() => hideToast(), 4000);
    }

    function hideToast() {
        document.getElementById('toast-notification').classList.add('hidden');
    }

    const bulkForm = document.getElementById('bulk-jenjang-form');
    const allFilteredCheckbox = document.getElementById('all-filtered-checkbox');
    const allFilteredInput = document.getElementById('all-filtered-input');
    const bulkJenjangSelect = document.getElementById('bulk-jenjang-select');
    const bulkJenjangSubmit = document.getElementById('bulk-jenjang-submit');
    const bulkSelectionCount = document.getElementById('bulk-selection-count');
    const studentCheckboxes = Array.from(document.querySelectorAll('[data-student-checkbox]'));
    const selectPageStudents = document.getElementById('select-page-students');
    const bulkJenjangModal = document.getElementById('bulkJenjangModal');
    const bulkJenjangModalDescription = document.getElementById('bulkJenjangModalDescription');
    const confirmBulkJenjang = document.getElementById('confirmBulkJenjang');
    const cancelBulkJenjang = document.getElementById('cancelBulkJenjang');

    function updateBulkJenjangButton() {
        const hasSelection = allFilteredCheckbox.checked || studentCheckboxes.some(checkbox => checkbox.checked);
        const selectedCount = studentCheckboxes.filter(checkbox => checkbox.checked).length;
        const countLabel = allFilteredCheckbox.checked ?
            `Semua {{ $filteredStudentCount }} siswa hasil filter dipilih` :
            `${selectedCount} siswa dipilih`;

        bulkJenjangSelect.disabled = !hasSelection;
        bulkJenjangSubmit.disabled = !hasSelection || !bulkJenjangSelect.value;
        allFilteredInput.value = allFilteredCheckbox.checked ? '1' : '0';
        bulkSelectionCount.textContent = hasSelection ? countLabel : 'Pilih siswa terlebih dahulu';
    }

    studentCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', () => {
            selectPageStudents.checked = studentCheckboxes.length > 0 && studentCheckboxes.every(item => item.checked);
            selectPageStudents.indeterminate = studentCheckboxes.some(item => item.checked) && !selectPageStudents.checked;
            updateBulkJenjangButton();
        });
    });

    selectPageStudents.addEventListener('change', () => {
        studentCheckboxes.forEach(checkbox => {
            checkbox.checked = selectPageStudents.checked;
        });
        updateBulkJenjangButton();
    });

    allFilteredCheckbox.addEventListener('change', updateBulkJenjangButton);
    bulkJenjangSelect.addEventListener('change', updateBulkJenjangButton);

    bulkForm.addEventListener('submit', event => {
        event.preventDefault();

        const applyToAll = allFilteredCheckbox.checked;

        const count = applyToAll ? {
                {
                    (int) $filteredStudentCount
                }
            } :
            studentCheckboxes.filter(checkbox => checkbox.checked).length;

        const destination = bulkJenjangSelect.selectedOptions[0].text;
        const scope = applyToAll ?
            'semua siswa yang sesuai dengan filter' :
            `${count} siswa terpilih`;

        bulkJenjangModalDescription.textContent =
            `Anda akan mengubah jenjang ${scope} menjadi ${destination}. Perubahan ini tidak dapat dibatalkan dari halaman ini.`;

        bulkJenjangModal.classList.remove('hidden');
    });

    cancelBulkJenjang.addEventListener('click', () => {
        bulkJenjangModal.classList.add('hidden');
    });

    confirmBulkJenjang.addEventListener('click', () => {
        confirmBulkJenjang.disabled = true;
        confirmBulkJenjang.textContent = 'Memproses...';
        bulkForm.submit();
    });

    @if(session('success'))
    showToast('success', @json(session('success')));
    @elseif($errors -> any())
    showToast('error', @json($errors -> first()));
    @endif
</script>
@endsection