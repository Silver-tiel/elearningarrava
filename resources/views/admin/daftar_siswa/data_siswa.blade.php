@extends('layouts.app')

@section('header')
<h1 class="text-lg font-bold text-gray-900">Manajemen Akun Siswa</h1>

<div class="flex items-center gap-4">
    <!-- Icon Notifikasi -->
    <button class="p-2 text-gray-400 hover:text-gray-600 rounded-lg transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
            </path>
        </svg>
    </button>
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

    {{-- Filter & Search Bar --}}
    <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm">
        <form method="GET" action="{{ route('admin.daftar_siswa') }}" class="flex flex-col md:flex-row gap-4 items-center justify-between">
            <div class="relative w-full md:w-96">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </span>
                <input type="text" name="search" value="{{ request('search') }}"
                    class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white focus:border-transparent transition"
                    placeholder="Cari nama atau email siswa...">
            </div>

            <div class="flex items-center gap-3 w-full md:w-auto">
                <select
                    name="kelas"
                    onchange="filterData(this)"
                    class="w-full md:w-auto bg-slate-50 border border-slate-200 text-slate-600 text-sm rounded-xl px-3.5 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    <option value="">Semua Kelas</option>
                    @foreach($listKelas ?? [] as $k)
                    <option value="{{ $k }}" {{ request('kelas') == $k ? 'selected' : '' }}>
                        {{ $k }}
                    </option>
                    @endforeach
                </select>

                <select
                    name="status"
                    onchange="filterData(this)"
                    class="w-full md:w-auto bg-slate-50 border border-slate-200 text-slate-600 text-sm rounded-xl px-3.5 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    <option value="">Status: Semua</option>
                    <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Status: Aktif</option>
                    <option value="Nonaktif" {{ request('status') == 'Nonaktif' ? 'selected' : '' }}>Status: Nonaktif</option>
                </select>
            </div>
        </form>
    </div>

    <form id="bulk-jenjang-form" method="POST" action="{{ route('admin.siswa.jenjang.massal') }}">
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
                    $status = $siswa->status_akun ?? 'Aktif';
                    $badgeClass = match($status) {
                        'Aktif' => 'bg-emerald-500/90 text-white border-emerald-400',
                        'Nonaktif' => 'bg-rose-500/90 text-white border-rose-400',
                        default => 'bg-amber-500/90 text-white border-amber-400',
                    };
                @endphp
                <div class="siswa-card bg-white rounded-2xl border border-gray-100 shadow-xs hover:shadow-md transition-all duration-200 overflow-hidden flex flex-col group relative"
                     data-id="{{ $siswa->id_user }}"
                     data-nama="{{ strtolower($siswa->nama) }}"
                     data-email="{{ strtolower($siswa->email) }}"
                     data-nisn="{{ $siswa->nisn ?? '' }}">

                    <!-- BANNER ATAS DENGAN STATUS & CHECKBOX -->
                    <div class="h-24 bg-gradient-to-r from-blue-600 via-indigo-600 to-indigo-700 relative p-3.5 flex justify-between items-start">
                        <!-- Checkbox Pilihan Siswa & Jenjang -->
                        <div class="flex items-center gap-2 z-10">
                            <label class="cursor-pointer flex items-center justify-center w-6 h-6 rounded-lg bg-black/20 hover:bg-black/35 backdrop-blur-xs transition border border-white/20 shadow-2xs"
                                   title="Pilih Siswa">
                                <input type="checkbox" name="student_ids[]" value="{{ $siswa->id_user }}"
                                    aria-label="Pilih {{ $siswa->nama }}" data-student-checkbox
                                    class="rounded border-white/50 text-blue-600 focus:ring-blue-500 w-3.5 h-3.5 cursor-pointer">
                            </label>

                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-white/20 text-white backdrop-blur-xs">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                                </svg>
                                <span>{{ $siswa->jenjang->nama_tipe ?? $siswa->kelas ?? 'Siswa' }}</span>
                            </span>
                        </div>

                        <!-- Dropdown Status Interaktif -->
                        <div class="z-10">
                            <select
                                id="select-status-{{ $siswa->id_user }}"
                                data-current-status="{{ $status }}"
                                onchange="confirmStatusChange('{{ $siswa->id_user }}', '{{ addslashes($siswa->nama) }}', this)"
                                class="text-[11px] font-bold px-2.5 py-0.5 rounded-full border border-white/20 focus:outline-none focus:ring-2 cursor-pointer transition shadow-2xs {{ $badgeClass }}">
                                <option value="Aktif" {{ $status == 'Aktif' ? 'selected' : '' }} class="bg-white text-slate-800">Aktif</option>
                                <option value="Nonaktif" {{ $status == 'Nonaktif' ? 'selected' : '' }} class="bg-white text-slate-800">Nonaktif</option>
                            </select>
                        </div>
                    </div>

                    <!-- FOTO / QR SISWA (CARD OVERLAPPING AVATAR DENGAN TOGGLE) -->
                    <div class="relative px-5 pt-0 pb-2">
                        <div class="-mt-12 flex justify-center">
                            <!-- Wadah Foto Profil -->
                            <div id="avatar-photo-{{ $siswa->id_user }}"
                                 class="student-avatar-photo w-24 h-24 rounded-2xl ring-4 ring-white shadow-md bg-white overflow-hidden flex items-center justify-center shrink-0 transition-all duration-300">
                                <a href="{{ route('admin.siswa.profil', $siswa->id_user) }}" class="w-full h-full block">
                                    <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                        src="{{ !empty($siswa->foto_profil) ? \Illuminate\Support\Facades\Storage::url($siswa->foto_profil) : 'https://ui-avatars.com/api/?name=' . urlencode($siswa->nama) . '&background=EFF6FF&color=2563EB' }}"
                                        alt="{{ $siswa->nama }}">
                                </a>
                            </div>

                            <!-- Wadah QR Code (Aktif Saat Toggle) -->
                            <div id="avatar-qr-{{ $siswa->id_user }}"
                                 onclick="openQrPreviewModal('{{ $siswa->id_user }}')"
                                 title="Klik untuk perbesar & unduh QR"
                                 class="student-avatar-qr hidden w-24 h-24 rounded-2xl ring-4 ring-white shadow-md bg-white p-1.5 flex flex-col items-center justify-center shrink-0 cursor-pointer hover:ring-blue-400 hover:scale-105 transition-all duration-300">
                                <div class="w-full h-full flex items-center justify-center [&>svg]:w-full [&>svg]:h-full [&>svg]:max-w-full [&>svg]:max-h-full">
                                    {!! $siswa->qrSvg(90) !!}
                                </div>
                            </div>
                        </div>

                        <!-- IDENTITAS SISWA -->
                        <div class="text-center mt-3">
                            <a href="{{ route('admin.siswa.profil', $siswa->id_user) }}" class="block">
                                <h3 class="text-base font-bold text-slate-800 group-hover:text-blue-600 transition truncate" title="{{ $siswa->nama }}">
                                    {{ $siswa->nama }}
                                </h3>
                            </a>
                            <p class="text-xs text-slate-500 flex items-center justify-center gap-1.5 mt-0.5 truncate" title="{{ $siswa->email }}">
                                <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <span class="truncate">{{ $siswa->email }}</span>
                            </p>
                        </div>

                        <!-- DETAIL INFO (NISN, NO HP, TOTAL POIN, STATUS QR) -->
                        <div class="mt-4 space-y-1.5">
                            <div class="bg-slate-50 rounded-xl px-3 py-2 text-xs flex items-center justify-between border border-slate-100">
                                <span class="text-slate-400 font-medium">NISN</span>
                                <span class="text-slate-700 font-mono font-semibold">{{ $siswa->nisn ?? '-' }}</span>
                            </div>

                            <div class="bg-slate-50 rounded-xl px-3 py-2 text-xs flex items-center justify-between border border-slate-100">
                                <span class="text-slate-400 font-medium">No. HP</span>
                                @if(!empty($siswa->nomor_hp))
                                    <a href="https://wa.me/{{ preg_replace('/^0/', '62', $siswa->nomor_hp) }}"
                                       target="_blank"
                                       title="Hubungi via WhatsApp"
                                       class="text-emerald-600 hover:text-emerald-700 font-semibold flex items-center gap-1 hover:underline">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86.173.086.275.071.376-.043.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.099.824z"/>
                                        </svg>
                                        <span>{{ $siswa->nomor_hp }}</span>
                                    </a>
                                @else
                                    <span class="text-slate-400 italic">-</span>
                                @endif
                            </div>

                            <div class="bg-slate-50 rounded-xl px-3 py-2 text-xs flex items-center justify-between border border-slate-100">
                                <span class="text-slate-400 font-medium">Total Poin</span>
                                <span class="inline-flex items-center gap-1 font-bold text-amber-600 bg-amber-50 px-2 py-0.5 rounded-lg border border-amber-200/60">
                                    ★ {{ number_format($siswa->total_poin ?? 0) }} Poin
                                </span>
                            </div>

                            <div class="bg-slate-50 rounded-xl px-3 py-2 text-xs flex items-center justify-between border border-slate-100">
                                <span class="text-slate-400 font-medium">QR Presensi</span>
                                @if($siswa->qr_dibuat_pada)
                                    <span class="inline-flex items-center gap-1 font-semibold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-200 text-[11px]" title="Dibuat: {{ $siswa->qr_dibuat_pada->format('d M Y H:i') }}">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                        <span>Aktif</span>
                                    </span>
                                @else
                                    <span class="text-slate-400 italic text-[11px]">Belum dibuat</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- FOOTER AKSI TOMBOL -->
                    <div class="mt-auto px-4 py-3 bg-slate-50/70 border-t border-slate-100 flex items-center gap-2">
                        <!-- TOGGLE LIHAT QR PADA CARD -->
                        <button type="button"
                                id="btn-toggle-qr-{{ $siswa->id_user }}"
                                onclick="toggleSingleCardQr('{{ $siswa->id_user }}')"
                                title="Beralih antara Foto dan QR Code"
                                class="student-toggle-btn py-2 px-2.5 text-xs font-semibold rounded-xl bg-white border border-slate-200 text-slate-700 hover:bg-blue-50 hover:border-blue-200 hover:text-blue-600 transition flex items-center justify-center gap-1 shadow-2xs shrink-0">
                            <span id="btn-toggle-icon-{{ $siswa->id_user }}">📱</span>
                            <span id="btn-toggle-text-{{ $siswa->id_user }}">QR</span>
                        </button>

                        <a href="{{ route('admin.siswa.profil', $siswa->id_user) }}"
                            class="flex-1 py-2 px-3 text-xs font-semibold rounded-xl bg-white border border-blue-200 text-blue-600 hover:bg-blue-50 transition flex items-center justify-center gap-1.5 shadow-2xs">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <span>Profil</span>
                        </a>

                        <button type="button"
                                onclick="triggerRegenerateQr('{{ route('admin.qr.regenerate', $siswa->id_user) }}', '{{ addslashes($siswa->nama) }}')"
                                title="Buat ulang QR Presensi untuk {{ $siswa->nama }}"
                                class="py-2 px-2.5 text-xs font-semibold rounded-xl bg-white border border-amber-300 text-amber-700 hover:bg-amber-50 active:bg-amber-100 transition flex items-center justify-center gap-1.5 shadow-2xs shrink-0">
                            <svg class="w-3.5 h-3.5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            <span>Reset</span>
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-2xl border border-dashed border-slate-200 p-12 text-center shadow-xs">
                    <div class="w-16 h-16 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
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
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                <span>Unduh PNG</span>
            </button>
            <button type="button" onclick="cetakQrFromModal()" class="w-full py-2.5 px-3 rounded-xl bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-semibold text-xs transition flex items-center justify-center gap-1.5 shadow-2xs cursor-pointer">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                <span>Cetak Kartu</span>
            </button>
        </div>

        <button type="button" id="modalRegenerateBtn" onclick="" class="mt-3.5 text-xs text-amber-600 hover:text-amber-700 font-medium hover:underline flex items-center gap-1 cursor-pointer">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
            </svg>
            <span>Buat Ulang (Regenerasi) Token QR Ini</span>
        </button>
    </div>
</div>

<script>
    let pendingData = null;
    let isAllQrMode = false;
    let activeModalStudentId = null;

    const studentQrData = {
        @foreach($siswas as $s)
            '{{ $s->id_user }}': {
                name: @json($s->nama),
                nisn: @json($s->nisn ?? '-'),
                jenjang: @json($s->jenjang->nama_tipe ?? $s->kelas ?? 'Siswa'),
                regenerateUrl: @json(route('admin.qr.regenerate', $s->id_user)),
            },
        @endforeach
    };

    function toggleSingleCardQr(id) {
        const photoEl = document.getElementById('avatar-photo-' + id);
        const qrEl = document.getElementById('avatar-qr-' + id);
        const iconEl = document.getElementById('btn-toggle-icon-' + id);
        const textEl = document.getElementById('btn-toggle-text-' + id);

        if (!photoEl || !qrEl) return;

        const isCurrentlyQr = !qrEl.classList.contains('hidden');

        if (isCurrentlyQr) {
            qrEl.classList.add('hidden');
            photoEl.classList.remove('hidden');
            if (iconEl) iconEl.textContent = '📱';
            if (textEl) textEl.textContent = 'QR';
        } else {
            photoEl.classList.add('hidden');
            qrEl.classList.remove('hidden');
            if (iconEl) iconEl.textContent = '👤';
            if (textEl) textEl.textContent = 'Foto';
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
            const photoEl = document.getElementById('avatar-photo-' + id);
            const qrEl = document.getElementById('avatar-qr-' + id);
            const iconEl = document.getElementById('btn-toggle-icon-' + id);
            const textEl = document.getElementById('btn-toggle-text-' + id);

            if (photoEl && qrEl) {
                if (isAllQrMode) {
                    photoEl.classList.add('hidden');
                    qrEl.classList.remove('hidden');
                    if (iconEl) iconEl.textContent = '👤';
                    if (textEl) textEl.textContent = 'Foto';
                } else {
                    qrEl.classList.add('hidden');
                    photoEl.classList.remove('hidden');
                    if (iconEl) iconEl.textContent = '📱';
                    if (textEl) textEl.textContent = 'QR';
                }
            }
        });
    }

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
            const ukuran = 900, pad = 50;
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

    function filterData(select) {
        const form = select.form;
        const search = form.querySelector('[name="search"]').value;
        const kelas = form.querySelector('[name="kelas"]').value;
        const status = form.querySelector('[name="status"]').value;

        if (!search && !kelas && !status) {
            window.location.href = "{{ route('admin.daftar_siswa') }}";
            return;
        }

        form.submit();
    }

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
                // Update dropdown state & styles
                const selectEl = pendingData.selectElement;
                selectEl.setAttribute('data-current-status', pendingData.newStatus);

                // Update badge color class
                selectEl.className = 'text-[11px] font-bold px-2.5 py-0.5 rounded-full border border-white/20 focus:outline-none focus:ring-2 cursor-pointer transition shadow-2xs ';
                if (pendingData.newStatus === 'Aktif') {
                    selectEl.classList.add('bg-emerald-500/90', 'text-white', 'border-emerald-400');
                } else if (pendingData.newStatus === 'Nonaktif') {
                    selectEl.classList.add('bg-rose-500/90', 'text-white', 'border-rose-400');
                } else {
                    selectEl.classList.add('bg-amber-500/90', 'text-white', 'border-amber-400');
                }

                showToast('success', data.message || `Status ${pendingData.name} berhasil diperbarui.`);
            } else {
                showToast('error', data.message || 'Gagal memperbarui status.');
                pendingData.selectElement.value = pendingData.oldStatus;
            }
        })
        .catch(err => {
            console.error(err);
            showToast('error', 'Terjadi kesalahan sistem.');
            pendingData.selectElement.value = pendingData.oldStatus;
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
        const countLabel = allFilteredCheckbox.checked
            ? `Semua {{ $filteredStudentCount }} siswa hasil filter dipilih`
            : `${selectedCount} siswa dipilih`;

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
        const count = applyToAll
            ? {{ $filteredStudentCount }}
            : studentCheckboxes.filter(checkbox => checkbox.checked).length;
        const destination = bulkJenjangSelect.selectedOptions[0].text;
        const scope = applyToAll ? 'semua siswa yang sesuai dengan filter' : `${count} siswa terpilih`;

        bulkJenjangModalDescription.textContent = `Anda akan mengubah jenjang ${scope} menjadi ${destination}. Perubahan ini tidak dapat dibatalkan dari halaman ini.`;
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

    @if (session('success'))
        showToast('success', @json(session('success')));
    @elseif (isset($errors) && $errors->any())
        showToast('error', @json($errors->first()));
    @endif
</script>
@endsection