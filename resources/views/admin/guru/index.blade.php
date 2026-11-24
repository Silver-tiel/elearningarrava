@extends('layouts.app')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@600;700;800&family=Figtree:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
.guru-card {
  --bg:#eceefb; --card:#ffffff; --ink:#1b1a3a; --muted:#6b6f8d; --line:#e4e6f4; --soft:#f5f6fc;
  --brand:#3447e6; --brand2:#5a3fd8; --brand-soft:#eaedff; --ok:#0f9d6a; --ok-soft:#dcf6ea;
  --danger:#d6314f; --danger-soft:#fdeaee; --wa:#128c4a; --petal:#e879f9;
  position: relative;
  width: 100%;
  background: var(--card);
  border-radius: 28px;
  overflow: hidden;
  border: 1px solid var(--line);
  box-shadow: 0 16px 40px -20px rgba(40,40,120,.22);
  transition: transform 0.25s ease, box-shadow 0.25s ease;
  font-family: Figtree, system-ui, -apple-system, sans-serif;
  color: var(--ink);
}
.guru-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 24px 50px -20px rgba(40,40,120,.32);
}

/* foto sebagai latar */
.guru-card .hero {
  position: relative;
  aspect-ratio: 3/4;
  background: #141240;
  color: #fff;
  overflow: hidden;
}
.guru-card .hero-img {
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
  transition: transform 0.4s ease;
}
.guru-card:hover .hero-img {
  transform: scale(1.03);
}

/* Fallback ketika foto guru tidak ada */
.guru-card .hero-fallback {
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
  background: radial-gradient(circle at 50% 36%, #3a4de6 0%, #201e63 65%, #0f0d36 100%);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  color: #fff;
  padding-bottom: 74px;
  z-index: 1;
}
.guru-card .hero-fallback-avatar {
  width: 96px;
  height: 96px;
  border-radius: 28px;
  background: linear-gradient(135deg, rgba(255,255,255,0.22) 0%, rgba(255,255,255,0.06) 100%);
  border: 2px solid rgba(255,255,255,0.35);
  box-shadow: 0 16px 36px -10px rgba(0,0,0,0.4), inset 0 1px 0 rgba(255,255,255,0.4);
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: "Bricolage Grotesque", Figtree, sans-serif;
  font-weight: 800;
  font-size: 42px;
  color: #ffffff;
  text-shadow: 0 2px 6px rgba(0,0,0,0.35);
  margin-bottom: 10px;
  transition: transform 0.3s ease;
}
.guru-card:hover .hero-fallback-avatar {
  transform: scale(1.06);
}
.guru-card .hero-fallback-badge {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  font-size: 11px;
  font-weight: 700;
  letter-spacing: 0.04em;
  text-transform: uppercase;
  color: rgba(255,255,255,0.78);
  background: rgba(0,0,0,0.28);
  padding: 3px 11px;
  border-radius: 999px;
  border: 1px solid rgba(255,255,255,0.18);
  backdrop-filter: blur(4px);
}

.guru-card .hero::after {
  content: "";
  position: absolute;
  inset: 0;
  z-index: 2;
  background: linear-gradient(to top, rgba(14,12,52,.95) 0%, rgba(14,12,52,.75) 30%, rgba(14,12,52,0) 62%);
  pointer-events: none;
}
.guru-card .badges {
  position: absolute;
  top: 16px;
  left: 16px;
  right: 16px;
  z-index: 3;
  display: flex;
  justify-content: space-between;
  align-items: center;
  pointer-events: none;
}
.guru-card .pill {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 6px 12px;
  border-radius: 999px;
  font-weight: 700;
  font-size: 12.5px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.18);
  pointer-events: auto;
}
.guru-card .pill.role {
  background: rgba(20,18,64,.65);
  color: #fff;
  -webkit-backdrop-filter: blur(8px);
  backdrop-filter: blur(8px);
  border: 1px solid rgba(255,255,255,0.15);
}
.guru-card .pill.status {
  color: #fff;
}
.guru-card .pill.status i {
  width: 7px;
  height: 7px;
  border-radius: 50%;
  background: #fff;
  display: block;
}
.guru-card .ident {
  position: absolute;
  left: 0;
  right: 0;
  bottom: 0;
  z-index: 3;
  padding: 0 18px 18px;
  text-align: left;
}
.guru-card .ident h3 {
  margin: 0;
  font-family: "Bricolage Grotesque", Figtree, sans-serif;
  font-weight: 800;
  font-size: 22px;
  letter-spacing: -.02em;
  line-height: 1.15;
  color: #fff;
  text-shadow: 0 2px 4px rgba(0,0,0,0.3);
  overflow: hidden;
  text-overflow: ellipsis;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
}
.guru-card .mail {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  margin-top: 8px;
  color: rgba(255,255,255,.9);
  font-size: 14px;
  text-decoration: none;
  font-weight: 600;
  transition: color 0.15s;
}
.guru-card .mail:hover {
  color: #fff;
  text-decoration: underline;
}
.guru-card .photo-btn {
  position: absolute;
  right: 16px;
  top: 60px;
  z-index: 3;
  width: 40px;
  height: 40px;
  border-radius: 50%;
  border: 1.5px solid rgba(255,255,255,.85);
  background: rgba(20,18,64,.62);
  color: #fff;
  display: grid;
  place-items: center;
  -webkit-backdrop-filter: blur(8px);
  backdrop-filter: blur(8px);
  transition: all 0.2s;
  cursor: pointer;
  text-decoration: none;
}
.guru-card .photo-btn:hover {
  background: var(--brand);
  transform: scale(1.08);
}

.guru-card svg {
  display: inline-block;
  vertical-align: middle;
  flex-shrink: 0;
  max-width: 100%;
  max-height: 100%;
}

/* tombol buka info */
.guru-card .toggle {
  width: 100%;
  margin-top: 14px;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  height: 44px;
  border: 0;
  border-radius: 16px;
  background: rgba(255,255,255,.96);
  color: #2a2f9e;
  font-weight: 700;
  font-size: 13.5px;
  box-shadow: 0 10px 24px -10px rgba(0,0,0,.5);
  cursor: pointer;
  transition: all 0.2s ease;
}
.guru-card .toggle:hover {
  background: #ffffff;
  transform: translateY(-1px);
}
.guru-card .toggle svg {
  width: 18px;
  height: 18px;
  flex-shrink: 0;
  transition: transform 0.2s;
}

/* panel yang naik dari bawah */
.guru-card .scrim {
  position: absolute;
  inset: 0;
  z-index: 4;
  background: rgba(10,10,40,.48);
  opacity: 0;
  pointer-events: none;
  transition: opacity .3s ease;
}
.guru-card .scrim.open {
  opacity: 1;
  pointer-events: auto;
}
.guru-card .sheet {
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
  box-shadow: 0 -16px 40px -12px rgba(10,10,50,.45);
  transform: translateY(105%);
  visibility: hidden;
  transition: transform .38s cubic-bezier(.22,.8,.26,1), visibility 0s .38s;
}
.guru-card .sheet.open {
  transform: translateY(0);
  visibility: visible;
  transition: transform .38s cubic-bezier(.22,.8,.26,1), visibility 0s;
}
.guru-card .sheet-head {
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
.guru-card .sheet-head svg {
  width: 18px;
  height: 18px;
  flex-shrink: 0;
  transition: transform 0.2s;
}
.guru-card .grab {
  position: absolute;
  top: 8px;
  left: 50%;
  width: 42px;
  height: 4px;
  margin-left: -21px;
  border-radius: 4px;
  background: var(--line);
}
.guru-card .sheet-body {
  overflow-y: auto;
  display: grid;
  gap: 9px;
  padding: 0 16px 16px;
}

/* data rows */
.guru-card .row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 10px;
  background: var(--soft);
  border: 1px solid var(--line);
  border-radius: 14px;
  padding: 10px 13px;
}
.guru-card .row .k {
  color: var(--muted);
  font-size: 13.5px;
  flex: none;
  font-weight: 500;
}
.guru-card .row .v {
  display: flex;
  align-items: center;
  gap: 6px;
  font-weight: 600;
  font-size: 14px;
  font-variant-numeric: tabular-nums;
  min-width: 0;
}
.guru-card .row a.v {
  color: var(--wa);
  text-decoration: none;
}
.guru-card .row a.v:hover {
  text-decoration: underline;
}
.guru-card .mailv {
  color: var(--brand);
  text-decoration: none;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}
.guru-card .row a.mailv:hover {
  text-decoration: underline;
}
.guru-card .mini {
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
.guru-card .mini svg {
  width: 15px;
  height: 15px;
  flex-shrink: 0;
}
.guru-card .mini:hover {
  color: var(--brand);
  border-color: var(--brand);
}

.guru-card .stats {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 8px;
}
.guru-card .stat {
  background: var(--brand-soft);
  border-radius: 14px;
  padding: 10px 12px;
}
.guru-card .stat b {
  display: block;
  font-family: "Bricolage Grotesque", Figtree, sans-serif;
  font-size: 24px;
  line-height: 1;
  color: var(--brand);
  font-variant-numeric: tabular-nums;
}
.guru-card .stat span {
  display: block;
  margin-top: 4px;
  font-size: 12px;
  color: var(--muted);
  font-weight: 600;
}

.guru-card .activity {
  background: var(--soft);
  border: 1px solid var(--line);
  border-radius: 14px;
  padding: 11px 13px;
}
.guru-card .activity small {
  color: var(--muted);
  font-size: 12px;
  font-weight: 600;
}
.guru-card .activity p {
  margin: 3px 0 0;
  font-weight: 700;
  font-size: 14px;
  color: var(--ink);
}
.guru-card .activity p span {
  color: var(--muted);
  font-weight: 500;
}

.guru-card .actions {
  display: flex;
  gap: 8px;
  padding: 2px 0 0;
}
.guru-card .btn {
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
.guru-card .btn svg {
  width: 18px;
  height: 18px;
  flex-shrink: 0;
}
.guru-card .btn:hover {
  border-color: var(--brand);
  color: var(--brand);
  background: var(--brand-soft);
}
.guru-card .btn.del {
  flex: none;
  width: 42px;
  height: 42px;
  padding: 0;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  color: var(--danger);
  border-color: var(--danger-soft);
  background: var(--danger-soft);
}
.guru-card .btn.del svg {
  width: 18px;
  height: 18px;
  flex-shrink: 0;
}
.guru-card .btn.del:hover {
  border-color: var(--danger);
  background: #fbd6de;
}

/* DIALOG KONFIRMASI HAPUS */
dialog.guru-delete-dlg {
  border: 1px solid #e4e6f4;
  border-radius: 24px;
  background: #ffffff;
  color: #1b1a3a;
  padding: 24px;
  max-width: 380px;
  width: calc(100% - 32px);
  box-shadow: 0 24px 60px -15px rgba(20,20,50,.35);
  font-family: Figtree, system-ui, sans-serif;
}
dialog.guru-delete-dlg::backdrop {
  background: rgba(10,10,30,.6);
  backdrop-filter: blur(4px);
}
dialog.guru-delete-dlg h2 {
  margin: 0 0 8px;
  font-family: "Bricolage Grotesque", Figtree, sans-serif;
  font-size: 22px;
  font-weight: 800;
  color: #1b1a3a;
}
dialog.guru-delete-dlg p {
  margin: 0 0 20px;
  color: #6b6f8d;
  font-size: 14px;
  line-height: 1.5;
}
dialog.guru-delete-dlg .acts {
  display: flex;
  gap: 10px;
}
dialog.guru-delete-dlg .btn-dlg {
  flex: 1;
  height: 44px;
  border-radius: 12px;
  font-weight: 700;
  font-size: 14px;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  border: 1px solid #e4e6f4;
  background: #f5f6fc;
  color: #1b1a3a;
  transition: all 0.15s;
}
dialog.guru-delete-dlg .btn-dlg:hover {
  background: #eaedff;
}
dialog.guru-delete-dlg .btn-dlg.danger {
  background: #d6314f;
  border-color: #d6314f;
  color: #fff;
}
dialog.guru-delete-dlg .btn-dlg.danger:hover {
  background: #b5223c;
}

/* TOAST */
.guru-toast {
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
  transition: all 0.25s cubic-bezier(.22,.8,.26,1);
  z-index: 99999;
  box-shadow: 0 10px 25px -5px rgba(0,0,0,0.3);
}
.guru-toast.show {
  opacity: 1;
  transform: translate(-50%, 0);
}
</style>
@endpush

@section('content')

<div class="p-6 sm:p-8 space-y-6">

    <!-- HEADER & ACTION -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                Data Guru
            </h1>
            <p class="text-sm text-slate-500 mt-1">
                Kelola data pengajar, foto profil, dan akun login guru di Bimbel Arrava.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.guru.create') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-semibold text-sm
                      hover:bg-indigo-700 transition shadow-sm hover:shadow">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                <span>Tambah Guru & Akun</span>
            </a>
        </div>
    </div>

    <!-- NOTIFIKASI SUKSES -->
    @if(session('success'))
    <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-medium flex items-center justify-between shadow-2xs">
        <div class="flex items-center gap-2.5">
            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
        <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">✕</button>
    </div>
    @endif

    <!-- FILTER & PENCARIAN (GAYA CHOICE CHIP SISWA) -->
    <x-student-style-filter-bar
        title="Data Pengajar"
        icon="👨‍🏫"
        searchId="searchInput"
        searchName="q"
        searchPlaceholder="Cari nama, email, NIK, atau no. telepon guru..."
        resetId="guruResetBtn"
        :showReset="false">

        <x-slot:headerActions>
            <span class="inline-flex items-center px-3 py-1 rounded-full bg-white border border-[#DCEFFF] text-[11px] font-extrabold text-[#465673] shadow-xs">
                Total:&nbsp;<span id="total-count">{{ $gurus->count() }}</span>&nbsp;Guru
            </span>
        </x-slot:headerActions>

        <x-student-style-filter-chip-bar
            id="guru-filter-chips"
            label="Filter"
            chipClass="guru-filter-chip"
            dataAttr="data-guru-filter"
            :chips="[
                ['value' => 'Semua', 'label' => 'Semua', 'active' => true],
                ['value' => 'Aktif', 'label' => 'Aktif', 'active' => false],
                ['value' => 'Nonaktif', 'label' => 'Nonaktif', 'active' => false],
                ['value' => 'Tanpa Akun', 'label' => 'Tanpa Akun', 'active' => false],
                ['value' => 'Ada Email', 'label' => 'Ada Email', 'active' => false],
                ['value' => 'Ada Telepon', 'label' => 'Ada Telepon', 'active' => false],
            ]" />
    </x-student-style-filter-bar>

    <!-- GRID KARTU INTERAKTIF PENGAJAR -->
    @if($gurus->isNotEmpty())
        <div id="guruGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($gurus as $guru)
                @php
                    $guruStatus = $guru->user ? ($guru->user->status_akun ?? 'Aktif') : 'Tanpa Akun';
                    $guruStatusKey = $guru->user
                        ? (strcasecmp($guruStatus, 'Nonaktif') === 0 ? 'nonaktif' : 'aktif')
                        : 'tanpa_akun';

                    $statusBg = match($guruStatusKey) {
                        'aktif' => 'var(--ok)',
                        'nonaktif' => 'var(--danger)',
                        default => '#f59e0b',
                    };

                    $rawTelepon = $guru->no_telepon ? preg_replace('/[^\d]/', '', $guru->no_telepon) : '';
                    $waTelepon = !empty($rawTelepon) ? preg_replace('/^0/', '62', $rawTelepon) : '';
                    $nikRaw = (string) ($guru->nik ?? '');
                    $nikMasked = strlen($nikRaw) >= 8
                        ? substr($nikRaw, 0, 4) . ' ' . substr($nikRaw, 4, 4) . ' •••• ••••'
                        : ($nikRaw ?: 'Belum diisi');
                @endphp

                <article class="guru-card"
                         id="guru-card-{{ $guru->id_guru }}"
                         data-guru-id="{{ $guru->id_guru }}"
                         data-nama="{{ strtolower($guru->nama) }}"
                         data-email="{{ strtolower($guru->user?->email ?? '') }}"
                         data-nik="{{ strtolower($guru->nik ?? '') }}"
                         data-telepon="{{ strtolower($guru->no_telepon ?? '') }}"
                         data-status="{{ $guruStatusKey }}"
                         data-has-email="{{ !empty($guru->user?->email) ? '1' : '0' }}"
                         data-has-telepon="{{ !empty($guru->no_telepon) ? '1' : '0' }}"
                         aria-label="Kartu data pengajar {{ $guru->nama }}">

                    <!-- FOTO LATAR (HERO) DENGAN ANTISIPASI FALLBACK -->
                    <header class="hero">
                        @if(!empty($guru->foto_url))
                            <img id="foto-{{ $guru->id_guru }}"
                                 src="{{ $guru->foto_url }}"
                                 alt="Foto {{ $guru->nama }}"
                                 loading="lazy"
                                 class="hero-img"
                                 onerror="this.style.display='none'; document.getElementById('fallback-{{ $guru->id_guru }}').style.display='flex';">
                            <!-- Fallback terselubung jika URL foto gagal memuat -->
                            <div id="fallback-{{ $guru->id_guru }}" class="hero-fallback" style="display: none;">
                                <div class="hero-fallback-avatar">
                                    {{ strtoupper(substr($guru->nama ?? 'G', 0, 1)) }}
                                </div>
                                <span class="hero-fallback-badge">Foto Belum Diatur</span>
                            </div>
                        @else
                            <!-- Fallback langsung jika belum ada foto -->
                            <div id="fallback-{{ $guru->id_guru }}" class="hero-fallback" style="display: flex;">
                                <div class="hero-fallback-avatar">
                                    {{ strtoupper(substr($guru->nama ?? 'G', 0, 1)) }}
                                </div>
                                <span class="hero-fallback-badge">Foto Belum Diatur</span>
                            </div>
                        @endif

                        <!-- BADGES: ROLE & STATUS -->
                        <div class="badges">
                            <span class="pill role">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m9 7-5 5 5 5M15 7l5 5-5 5"/>
                                </svg>
                                <span>Pengajar</span>
                            </span>
                            <span class="pill status" style="background: {{ $statusBg }};">
                                <i></i>
                                <span>{{ $guruStatus }}</span>
                            </span>
                        </div>

                        <!-- TOMBOL CEPAT GANTI FOTO / EDIT PROFIL -->
                        <a href="{{ route('admin.guru.edit', $guru->id_guru) }}"
                           class="photo-btn"
                           aria-label="Ganti foto / Edit profil {{ $guru->nama }}"
                           title="Ganti foto / Edit profil {{ $guru->nama }}">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 8h3l2-3h6l2 3h3v11H4z"/>
                                <circle cx="12" cy="13" r="3.5"/>
                            </svg>
                        </a>

                        <!-- IDENTITAS DASAR: NAMA, WHATSAPP, & TOMBOL BUKA INFO -->
                        <div class="ident">
                            <h3 title="{{ $guru->nama }}">{{ $guru->nama }}</h3>

                            @if(!empty($waTelepon))
                                <a class="mail" href="https://wa.me/{{ $waTelepon }}" target="_blank" rel="noopener" title="Kirim Pesan WhatsApp">
                                    <svg class="w-3.5 h-3.5 text-emerald-400" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86.173.086.275.071.376-.043.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.099.824z"/>
                                    </svg>
                                    <span>{{ $guru->no_telepon }}</span>
                                </a>
                            @else
                                <span class="mail text-white/60 text-xs">
                                    <span>No. HP belum terdaftar</span>
                                </span>
                            @endif

                            <button type="button"
                                    class="toggle btn-open-sheet"
                                    data-target="sheet-{{ $guru->id_guru }}"
                                    aria-expanded="false"
                                    aria-controls="sheet-{{ $guru->id_guru }}">
                                <span>Lihat info lengkap</span>
                                <svg width="18" height="18" class="w-[18px] h-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m6 15 6-6 6 6"/>
                                </svg>
                            </button>
                        </div>
                    </header>

                    <!-- SCRIM BACKDROP -->
                    <div class="scrim" id="scrim-{{ $guru->id_guru }}" data-target="sheet-{{ $guru->id_guru }}"></div>

                    <!-- PANEL BOTTOM SHEET INFO LENGKAP -->
                    <section class="sheet" id="sheet-{{ $guru->id_guru }}" aria-label="Info lengkap {{ $guru->nama }}" inert>
                        <button type="button"
                                class="sheet-head btn-close-sheet"
                                data-target="sheet-{{ $guru->id_guru }}"
                                aria-expanded="true"
                                aria-controls="sheet-{{ $guru->id_guru }}">
                            <i class="grab"></i>
                            <span>Sembunyikan info</span>
                            <svg width="18" height="18" class="w-[18px] h-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m6 9 6 6 6-6"/>
                            </svg>
                        </button>

                        <div class="sheet-body">
                            <!-- BARIS EMAIL -->
                            <div class="row">
                                <span class="k">Email</span>
                                @if(!empty($guru->user?->email))
                                    <a class="v mailv" href="mailto:{{ $guru->user->email }}" title="{{ $guru->user->email }}">
                                        {{ $guru->user->email }}
                                    </a>
                                @else
                                    <span class="v text-slate-400 font-normal">Belum ada email</span>
                                @endif
                            </div>

                            <!-- BARIS NIK DENGAN FITUR TOGGLE & SALIN -->
                            <div class="row">
                                <span class="k">NIK</span>
                                <span class="v">
                                    <span id="nik-text-{{ $guru->id_guru }}"
                                          data-full="{{ $nikRaw }}"
                                          data-masked="{{ $nikMasked }}"
                                          data-shown="false">
                                        {{ $nikMasked }}
                                    </span>
                                    @if(!empty($nikRaw))
                                        <button type="button"
                                                class="mini btn-toggle-nik"
                                                data-target="nik-text-{{ $guru->id_guru }}"
                                                aria-label="Tampilkan / Sembunyikan NIK"
                                                title="Lihat / Tutup NIK">
                                            <svg width="15" height="15" class="w-[15px] h-[15px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7S2 12 2 12z"/>
                                                <circle cx="12" cy="12" r="3"/>
                                            </svg>
                                        </button>
                                        <button type="button"
                                                class="mini btn-copy-nik"
                                                data-full="{{ $nikRaw }}"
                                                data-nama="{{ $guru->nama }}"
                                                aria-label="Salin NIK"
                                                title="Salin NIK">
                                            <svg width="15" height="15" class="w-[15px] h-[15px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <rect x="9" y="9" width="11" height="11" rx="2"/>
                                                <path d="M5 15V6a2 2 0 0 1 2-2h9"/>
                                            </svg>
                                        </button>
                                    @endif
                                </span>
                            </div>

                            <!-- 4 STATISTIK UTAMA (MODUL, KUIS, KELAS AKTIF, SISWA) -->
                            <div class="stats">
                                <div class="stat">
                                    <b>{{ (int) ($guru->moduls_count ?? 0) }}</b>
                                    <span>Modul</span>
                                </div>
                                <div class="stat">
                                    <b>{{ (int) ($guru->quizzes_count ?? 0) }}</b>
                                    <span>Kuis</span>
                                </div>
                                <div class="stat">
                                    <b>{{ (int) ($guru->kelas_aktif_count ?? 0) }}</b>
                                    <span>Kelas aktif</span>
                                </div>
                                <div class="stat">
                                    <b>{{ (int) ($guru->siswa_diajar_count ?? 0) }}</b>
                                    <span>Siswa diampu</span>
                                </div>
                            </div>

                            <!-- KOTAK AKTIVITAS KONTEN TERAKHIR -->
                            <div class="activity">
                                <small>Aktivitas konten terakhir</small>
                                @if($guru->aktivitas_konten_terakhir)
                                    <p>
                                        Memperbarui {{ $guru->aktivitas_konten_terakhir['jenis'] }}
                                        <span>– {{ \Illuminate\Support\Carbon::parse($guru->aktivitas_konten_terakhir['waktu'])->diffForHumans() }}</span>
                                    </p>
                                @else
                                    <p>Belum ada aktivitas <span>– konten baru</span></p>
                                @endif
                            </div>

                            <!-- TOMBOL AKSI: EDIT & HAPUS -->
                            <div class="actions">
                                <a href="{{ route('admin.guru.edit', $guru->id_guru) }}" class="btn" title="Edit Data Pengajar">
                                    <svg width="18" height="18" class="w-[18px] h-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M4 20h4L19 9l-4-4L4 16z"/>
                                        <path d="m13.5 6.5 4 4"/>
                                    </svg>
                                    <span>Edit data</span>
                                </a>

                                <button type="button"
                                        class="btn del btn-trigger-delete"
                                        data-guru-id="{{ $guru->id_guru }}"
                                        data-guru-nama="{{ $guru->nama }}"
                                        data-delete-url="{{ route('admin.guru.destroy', $guru->id_guru) }}"
                                        aria-label="Hapus pengajar {{ $guru->nama }}"
                                        title="Hapus Pengajar">
                                    <svg width="18" height="18" class="w-[18px] h-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M4 7h16M10 11v6M14 11v6M6 7l1 13h10l1-13M9 7V4h6v3"/>
                                    </svg>
                                </button>
                            </div>
                                        <path d="M4 7h16M10 11v6M14 11v6M6 7l1 13h10l1-13M9 7V4h6v3"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </section>
                </article>
            @endforeach
        </div>

        <!-- EMPTY STATE HASIL PENCARIAN -->
        <div id="noResults" class="hidden bg-white rounded-2xl border-2 border-[#DCEFFF] p-12 text-center shadow-xs">
            <svg class="w-12 h-12 text-[#007FBE]/40 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <p class="text-base font-bold text-[#082765]">Guru tidak ditemukan</p>
            <p class="text-xs font-semibold text-[#465673] mt-1">Coba ubah kata kunci pencarian atau filter status yang dipilih.</p>
            <button type="button" onclick="resetGuruFilters()"
                class="mt-4 inline-flex items-center gap-1.5 rounded-full bg-[#007FBE] hover:bg-[#00679A] px-4 py-2 text-xs font-extrabold text-white shadow-[0_2px_0_#005580] transition cursor-pointer">
                Reset Filter
            </button>
        </div>
    @else
        <!-- KOSONG (EMPTY STATE) -->
        <div class="bg-white rounded-2xl border border-dashed border-slate-200 p-12 text-center shadow-xs">
            <div class="w-16 h-16 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800">Belum Ada Data Guru</h3>
            <p class="text-sm text-slate-500 max-w-sm mx-auto mt-1 mb-6">
                Belum ada pengajar yang ditambahkan ke sistem. Tambahkan guru baru untuk mengelola kelas dan kuis.
            </p>
            <a href="{{ route('admin.guru.create') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-semibold text-sm hover:bg-indigo-700 transition shadow-sm">
                <span>+ Tambah Guru Pertama</span>
            </a>
        </div>
    @endif

</div>

<!-- DIALOG MODAL KONFIRMASI HAPUS -->
<dialog id="deleteGuruDialog" class="guru-delete-dlg">
    <h2 id="deleteGuruModalTitle">Hapus data pengajar?</h2>
    <p>Data pengajar beserta relasinya ke modul dan kelas akan dihapus dan tidak bisa dikembalikan.</p>
    <form id="deleteGuruForm" method="POST" action="">
        @csrf
        @method('DELETE')
        <div class="acts">
            <button type="button" class="btn-dlg" id="btnCancelDelete">Batal</button>
            <button type="submit" class="btn-dlg danger" id="btnConfirmDelete">Hapus</button>
        </div>
    </form>
</dialog>

<!-- FLOATING TOAST NOTIFIKASI -->
<div class="guru-toast" id="guruToast" role="status" aria-live="polite"></div>

<script>
    // ==========================================
    // TOAST NOTIFIKASI
    // ==========================================
    const toast = document.getElementById('guruToast');
    let toastTimer;
    function showToast(message) {
        if (!toast) return;
        toast.textContent = message;
        toast.classList.add('show');
        clearTimeout(toastTimer);
        toastTimer = setTimeout(() => {
            toast.classList.remove('show');
        }, 2200);
    }

    // ==========================================
    // BOTTOM SHEET (BUKA / TUTUP PANEL INFO)
    // ==========================================
    function setSheetOpen(sheetId, isOpen) {
        const sheet = document.getElementById(sheetId);
        if (!sheet) return;
        const card = sheet.closest('.guru-card');
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

    // Delegasi klik tombol buka / tutup sheet & scrim
    document.addEventListener('click', (e) => {
        const openBtn = e.target.closest('.btn-open-sheet');
        if (openBtn) {
            const targetId = openBtn.getAttribute('data-target');
            if (targetId) setSheetOpen(targetId, true);
            return;
        }

        const closeBtn = e.target.closest('.btn-close-sheet');
        if (closeBtn) {
            const targetId = closeBtn.getAttribute('data-target');
            if (targetId) setSheetOpen(targetId, false);
            return;
        }

        const scrim = e.target.closest('.scrim');
        if (scrim) {
            const targetId = scrim.getAttribute('data-target');
            if (targetId) setSheetOpen(targetId, false);
            return;
        }
    });

    // Tutup panel aktif jika menekan Escape
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            document.querySelectorAll('.guru-card .sheet.open').forEach(sheet => {
                setSheetOpen(sheet.id, false);
            });
        }
    });

    // ==========================================
    // NIK: SEMBUNYIKAN / TAMPILKAN / SALIN
    // ==========================================
    function formatNik(nik) {
        return nik.replace(/(\d{4})(?=\d)/g, '$1 ');
    }

    document.addEventListener('click', (e) => {
        // Toggle NIK (Lihat / Sembunyi)
        const toggleNikBtn = e.target.closest('.btn-toggle-nik');
        if (toggleNikBtn) {
            const targetId = toggleNikBtn.getAttribute('data-target');
            const nikEl = document.getElementById(targetId);
            if (!nikEl) return;

            const isShown = nikEl.getAttribute('data-shown') === 'true';
            const fullNik = nikEl.getAttribute('data-full') || '';
            const maskedNik = nikEl.getAttribute('data-masked') || '';

            if (isShown) {
                nikEl.textContent = maskedNik;
                nikEl.setAttribute('data-shown', 'false');
                toggleNikBtn.setAttribute('title', 'Tampilkan NIK');
            } else {
                nikEl.textContent = formatNik(fullNik);
                nikEl.setAttribute('data-shown', 'true');
                toggleNikBtn.setAttribute('title', 'Sembunyikan NIK');
            }
            return;
        }

        // Salin NIK
        const copyNikBtn = e.target.closest('.btn-copy-nik');
        if (copyNikBtn) {
            const fullNik = copyNikBtn.getAttribute('data-full') || '';
            const nama = copyNikBtn.getAttribute('data-nama') || 'Guru';
            if (!fullNik) return;

            function onCopySuccess() {
                showToast(`NIK ${nama} disalin ✓`);
            }
            function onCopyFail() {
                showToast('Gagal menyalin NIK');
            }

            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(fullNik).then(onCopySuccess, onCopyFail);
            } else {
                try {
                    const temp = document.createElement('textarea');
                    temp.value = fullNik;
                    temp.style.position = 'fixed';
                    temp.style.opacity = '0';
                    document.body.appendChild(temp);
                    temp.select();
                    const res = document.execCommand('copy');
                    document.body.removeChild(temp);
                    if (res) onCopySuccess(); else onCopyFail();
                } catch (err) {
                    onCopyFail();
                }
            }
            return;
        }
    });

    // ==========================================
    // MODAL DIALOG KONFIRMASI HAPUS
    // ==========================================
    const deleteDlg = document.getElementById('deleteGuruDialog');
    const deleteForm = document.getElementById('deleteGuruForm');
    const deleteTitle = document.getElementById('deleteGuruModalTitle');
    const cancelDeleteBtn = document.getElementById('btnCancelDelete');

    document.addEventListener('click', (e) => {
        const delBtn = e.target.closest('.btn-trigger-delete');
        if (delBtn) {
            const guruNama = delBtn.getAttribute('data-guru-nama') || 'Pengajar';
            const deleteUrl = delBtn.getAttribute('data-delete-url') || '';

            if (deleteTitle) deleteTitle.textContent = `Hapus data ${guruNama}?`;
            if (deleteForm) deleteForm.action = deleteUrl;

            if (deleteDlg) {
                if (typeof deleteDlg.showModal === 'function') {
                    deleteDlg.showModal();
                } else {
                    deleteDlg.setAttribute('open', '');
                }
            }
        }
    });

    if (cancelDeleteBtn && deleteDlg) {
        cancelDeleteBtn.addEventListener('click', () => {
            if (typeof deleteDlg.close === 'function') {
                deleteDlg.close();
            } else {
                deleteDlg.removeAttribute('open');
            }
        });
    }

    // ==========================================
    // FILTER & SEARCH CLIENT-SIDE
    // ==========================================
    let activeGuruFilter = 'Semua';

    function filterCards() {
        const searchInput = document.getElementById('searchInput');
        const query = (searchInput?.value || '').toLowerCase().trim();
        const cards = document.querySelectorAll('.guru-card');
        let visibleCount = 0;

        cards.forEach(card => {
            const nama = card.getAttribute('data-nama') || '';
            const email = card.getAttribute('data-email') || '';
            const nik = card.getAttribute('data-nik') || '';
            const telepon = card.getAttribute('data-telepon') || '';
            const status = card.getAttribute('data-status') || '';
            const hasEmail = card.getAttribute('data-has-email') === '1';
            const hasTelepon = card.getAttribute('data-has-telepon') === '1';

            const matchesQuery = query === ''
                || nama.includes(query)
                || email.includes(query)
                || nik.includes(query)
                || telepon.includes(query);

            let matchesChip = true;
            if (activeGuruFilter === 'Aktif') matchesChip = status === 'aktif';
            else if (activeGuruFilter === 'Nonaktif') matchesChip = status === 'nonaktif';
            else if (activeGuruFilter === 'Tanpa Akun') matchesChip = status === 'tanpa_akun';
            else if (activeGuruFilter === 'Ada Email') matchesChip = hasEmail;
            else if (activeGuruFilter === 'Ada Telepon') matchesChip = hasTelepon;

            if (matchesQuery && matchesChip) {
                card.style.display = '';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        const totalEl = document.getElementById('total-count');
        if (totalEl) {
            totalEl.textContent = visibleCount;
        }

        const noResults = document.getElementById('noResults');
        if (noResults) {
            noResults.classList.toggle('hidden', !(visibleCount === 0 && cards.length > 0));
        }

        const resetBtn = document.getElementById('guruResetBtn');
        const isDirty = query !== '' || activeGuruFilter !== 'Semua';
        if (resetBtn) {
            resetBtn.classList.toggle('hidden', !isDirty);
            resetBtn.classList.toggle('inline-flex', isDirty);
        }
    }

    function resetGuruFilters() {
        const filterHelper = window.ArravaStudentFilter;
        const searchInput = document.getElementById('searchInput');
        const searchClear = document.getElementById('searchInputClear');
        const chipsContainer = document.getElementById('guru-filter-chips');

        activeGuruFilter = 'Semua';
        if (searchInput) searchInput.value = '';
        if (searchClear) {
            searchClear.classList.add('hidden');
            searchClear.classList.remove('inline-flex');
        }
        if (filterHelper && chipsContainer) {
            filterHelper.setActiveChip(chipsContainer, activeGuruFilter, 'data-guru-filter');
        }
        filterCards();
    }

    document.addEventListener('DOMContentLoaded', () => {
        const filterHelper = window.ArravaStudentFilter;
        const searchInput = document.getElementById('searchInput');
        const searchClear = document.getElementById('searchInputClear');
        const chipsContainer = document.getElementById('guru-filter-chips');
        const resetBtn = document.getElementById('guruResetBtn');

        if (filterHelper) {
            filterHelper.bindSearchClear(searchInput, searchClear, filterCards);
        }
        if (chipsContainer) {
            chipsContainer.addEventListener('click', (e) => {
                const btn = e.target.closest('[data-guru-filter]');
                if (!btn) return;
                activeGuruFilter = btn.getAttribute('data-guru-filter') || 'Semua';
                if (filterHelper) {
                    filterHelper.setActiveChip(chipsContainer, activeGuruFilter, 'data-guru-filter');
                }
                filterCards();
            });
        }
        if (resetBtn) {
            resetBtn.addEventListener('click', resetGuruFilters);
        }
    });
</script>

@endsection
