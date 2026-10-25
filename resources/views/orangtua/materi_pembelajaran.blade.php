@extends('layouts.orangtua')
@include('components.page-loader')
@section('title', 'Materi Pembelajaran - Portal Orang Tua')
@section('breadcrumb', 'Materi Pembelajaran')

@section('content')
<div class="px-4 sm:px-6 py-6 max-w-[1400px] mx-auto">

    {{-- ================================================================
    |  HEADER + SELECTOR SISWA
    ================================================================ --}}
    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-6">
        <div>
            <nav class="flex items-center gap-1.5 text-xs text-slate-400 mb-1.5">
                <span class="text-slate-500 font-medium">Portal Orang Tua</span>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span>Materi Pembelajaran</span>
            </nav>
            <h1 class="text-[22px] font-extrabold text-slate-900 leading-tight">Materi Pembelajaran</h1>
            <p class="text-sm text-slate-500 mt-0.5 max-w-xl">
                Pantau ketersediaan bahan ajar, modul digital, video interaktif, dan progres ketuntasan belajar ananda secara komprehensif.
            </p>
        </div>

        @if($siswa)
        {{-- Selector Siswa --}}
        <form method="GET" action="{{ route('orangtua.materi-pembelajaran') }}" id="siswaForm" class="shrink-0">
            <input type="hidden" name="tipe"   value="{{ $tipeAktif }}">
            <input type="hidden" name="status" value="{{ $statusAktif }}">
            <input type="hidden" name="q"      value="{{ $searchQuery }}">
            <div class="flex items-center gap-2 bg-white border border-slate-200 rounded-xl px-3 py-2.5 shadow-sm min-w-[260px] cursor-pointer hover:border-indigo-300 transition">
                <div class="w-9 h-9 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold text-sm shrink-0">
                    {{ strtoupper(substr($siswa->nama, 0, 2)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none mb-0.5">Siswa Terpilih</p>
                    <select name="siswa_id" onchange="document.getElementById('siswaForm').submit()"
                            class="w-full text-sm font-semibold text-slate-800 border-0 bg-transparent p-0 focus:ring-0 cursor-pointer">
                        @foreach($siswaList as $s)
                        <option value="{{ $s->id_user }}" {{ $s->id_user == $siswa->id_user ? 'selected' : '' }}>
                            {{ $s->nama }} ({{ $s->jenjang->nama_tipe ?? '-' }})
                        </option>
                        @endforeach
                    </select>
                </div>
                <svg class="w-4 h-4 text-slate-400 shrink-0 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </div>
        </form>
        @endif
    </div>

    {{-- EMPTY STATE --}}
    @if(!$siswa)
    <div class="bg-white rounded-2xl border border-dashed border-slate-200 p-16 text-center">
        <div class="w-14 h-14 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253"/>
            </svg>
        </div>
        <h3 class="text-base font-semibold text-slate-700 mb-1">Belum ada siswa yang dihubungkan</h3>
        <p class="text-sm text-slate-400">Hubungi administrator untuk menautkan akun orang tua dengan akun siswa.</p>
    </div>

    @else

    {{-- ================================================================
    |  4 STAT CARDS
    ================================================================ --}}
    <div class="grid grid-cols-2 xl:grid-cols-4 gap-4 mb-6">

        {{-- Total Materi Terjadwal --}}
        <div class="bg-white rounded-xl border border-slate-100 p-4 hover:shadow-md hover:-translate-y-0.5 transition-all duration-150">
            <div class="flex items-start justify-between mb-3">
                <p class="text-[11px] font-bold uppercase tracking-widest text-slate-400">Total Materi Terjadwal</p>
                <div class="w-7 h-7 rounded-lg bg-indigo-50 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
            </div>
            <div class="flex items-baseline gap-1.5">
                <p class="text-[34px] font-extrabold text-slate-900 leading-none">{{ $stats['total_modul'] }}</p>
                <span class="text-sm font-semibold text-slate-400">Modul</span>
            </div>
            <p class="text-[11px] text-slate-400 mt-2">{{ $stats['tipe_unik'] }} Mata Pelajaran Aktif semester ini</p>
            <div class="mt-2 flex items-center gap-1 text-[11px] font-semibold text-indigo-600">
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Terverifikasi Tim Kurikulum
            </div>
        </div>

        {{-- Materi Selesai --}}
        <div class="bg-white rounded-xl border border-slate-100 p-4 hover:shadow-md hover:-translate-y-0.5 transition-all duration-150">
            <div class="flex items-start justify-between mb-3">
                <p class="text-[11px] font-bold uppercase tracking-widest text-slate-400">Materi Selesai</p>
                <div class="w-7 h-7 rounded-lg bg-emerald-50 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <div class="flex items-baseline gap-1.5">
                <p class="text-[34px] font-extrabold text-slate-900 leading-none">{{ $stats['selesai'] }}</p>
                <span class="text-sm font-semibold text-slate-400">Modul</span>
            </div>
            <div class="mt-2 w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                <div class="h-1.5 rounded-full bg-emerald-500 transition-all duration-700"
                     style="width: {{ $stats['total_modul'] > 0 ? round($stats['selesai']/$stats['total_modul']*100) : 0 }}%"></div>
            </div>
            <p class="text-[11px] text-slate-400 mt-1.5">
                Target Semester:
                <span class="font-semibold text-emerald-600">{{ $stats['target_persen'] }}% Tuntas</span>
            </p>
        </div>

        {{-- Sedang Dipelajari --}}
        <div class="bg-white rounded-xl border border-slate-100 p-4 hover:shadow-md hover:-translate-y-0.5 transition-all duration-150">
            <div class="flex items-start justify-between mb-3">
                <p class="text-[11px] font-bold uppercase tracking-widest text-slate-400">Sedang Dipelajari</p>
                <div class="w-7 h-7 rounded-lg bg-amber-50 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <div class="flex items-baseline gap-1.5">
                <p class="text-[34px] font-extrabold text-slate-900 leading-none">{{ $stats['sedang'] }}</p>
                <span class="text-sm font-semibold text-slate-400">Modul</span>
            </div>
            <p class="text-[11px] text-slate-400 mt-2">Dalam pengerjaan aktif &amp; telah</p>
            <p class="text-[11px] font-semibold text-amber-600 flex items-center gap-1 mt-0.5">
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="2"/></svg>
                {{ $stats['sedang'] }} bab mendekati batas tugas
            </p>
        </div>

        {{-- Belum Dimulai --}}
        <div class="bg-white rounded-xl border border-slate-100 p-4 hover:shadow-md hover:-translate-y-0.5 transition-all duration-150">
            <div class="flex items-start justify-between mb-3">
                <p class="text-[11px] font-bold uppercase tracking-widest text-slate-400">Belum Dimulai</p>
                <div class="w-7 h-7 rounded-lg bg-slate-50 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
            <div class="flex items-baseline gap-1.5">
                <p class="text-[34px] font-extrabold text-slate-900 leading-none">{{ $stats['belum'] }}</p>
                <span class="text-sm font-semibold text-slate-400">Modul</span>
            </div>
            <p class="text-[11px] text-slate-400 mt-2">Jadwal pekan akademik berlanjutnya</p>
            <p class="text-[11px] font-semibold text-slate-500 mt-0.5">Rencana Nilai Akhir 2025</p>
        </div>
    </div>

    {{-- ================================================================
    |  FILTER & SEARCH BAR
    ================================================================ --}}
    <div class="bg-white rounded-xl border border-slate-100 p-4 mb-5">
        <form method="GET" action="{{ route('orangtua.materi-pembelajaran') }}" id="filterForm">
            <input type="hidden" name="siswa_id" value="{{ $siswa->id_user }}">

            <div class="flex flex-col sm:flex-row gap-3 items-start sm:items-center">
                {{-- Search --}}
                <div class="relative flex-1 min-w-0">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="q" value="{{ $searchQuery }}"
                           placeholder="Cari judul materi, topik, atau bab..."
                           class="w-full pl-9 pr-4 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 transition">
                </div>

                {{-- Filter Tipe Modul --}}
                <select name="tipe" onchange="document.getElementById('filterForm').submit()"
                        class="text-sm border border-slate-200 rounded-lg px-3 py-2 text-slate-700 focus:outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 bg-white min-w-[180px]">
                    <option value="">Semua Mata Pelajaran</option>
                    @foreach($tipeList as $tipe)
                    <option value="{{ $tipe->id_tipemodul }}" {{ $tipeAktif == $tipe->id_tipemodul ? 'selected' : '' }}>
                        {{ $tipe->nama_tipe }}
                    </option>
                    @endforeach
                </select>

                {{-- Filter Status --}}
                <select name="status" onchange="document.getElementById('filterForm').submit()"
                        class="text-sm border border-slate-200 rounded-lg px-3 py-2 text-slate-700 focus:outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 bg-white min-w-[150px]">
                    <option value="">Semua Status</option>
                    <option value="selesai"  {{ $statusAktif === 'selesai'  ? 'selected' : '' }}>Selesai</option>
                    <option value="sedang"   {{ $statusAktif === 'sedang'   ? 'selected' : '' }}>Sedang Dipelajari</option>
                    <option value="belum"    {{ $statusAktif === 'belum'    ? 'selected' : '' }}>Belum Dimulai</option>
                </select>

                {{-- Reset --}}
                <a href="{{ route('orangtua.materi-pembelajaran', ['siswa_id' => $siswa->id_user]) }}"
                   title="Reset Filter"
                   class="flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-slate-400 hover:bg-slate-50 hover:text-slate-600 transition shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    <span class="sr-only">Reset Filter</span>
                </a>
            </div>
        </form>

        @if($moduls->total() > 0)
        <p class="text-[12px] text-slate-400 mt-3 flex items-center gap-1">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 010 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h10a1 1 0 010 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h7a1 1 0 010 2H4a1 1 0 01-1-1z"/></svg>
            Menampilkan {{ $moduls->firstItem() }}–{{ $moduls->lastItem() }} dari {{ $moduls->total() }} materi pembelajaran
        </p>
        @endif
    </div>

    {{-- ================================================================
    |  TABEL MATERI
    ================================================================ --}}
    <div class="bg-white rounded-xl border border-slate-100 overflow-hidden mb-5">

        @if($moduls->isEmpty())
        <div class="flex flex-col items-center justify-center py-16 text-slate-300">
            <svg class="w-12 h-12 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
            <p class="text-sm font-medium">Belum ada materi ditemukan</p>
            <p class="text-xs mt-1 text-slate-300">Coba ubah filter atau kata kunci pencarian</p>
        </div>
        @else

        {{-- TABLE HEADER --}}
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/60">
                        <th class="text-left text-[10px] font-bold uppercase tracking-widest text-slate-400 px-5 py-3.5 w-[35%]">Nama Materi &amp; Bab</th>
                        <th class="text-left text-[10px] font-bold uppercase tracking-widest text-slate-400 px-4 py-3.5">Mata Pelajaran</th>
                        <th class="text-left text-[10px] font-bold uppercase tracking-widest text-slate-400 px-4 py-3.5">Format Bahan Ajar</th>
                        <th class="text-center text-[10px] font-bold uppercase tracking-widest text-slate-400 px-4 py-3.5">Status</th>
                        <th class="text-left text-[10px] font-bold uppercase tracking-widest text-slate-400 px-4 py-3.5 w-[15%]">Progres</th>
                        <th class="text-center text-[10px] font-bold uppercase tracking-widest text-slate-400 px-4 py-3.5">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                @foreach($moduls as $modul)
                @php
                    // Warna & ikon tipe modul
                    $tipeName = $modul->tipeModul->nama_tipe ?? 'Lainnya';
                    $tipeConfig = match(true) {
                        str_contains(strtolower($tipeName), 'video') => [
                            'icon'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                            'bg'      => 'bg-red-50',
                            'color'   => 'text-red-500',
                            'label'   => 'Video & Modul Digital',
                        ],
                        str_contains(strtolower($tipeName), 'pdf') || str_contains(strtolower($tipeName), 'modul') => [
                            'icon'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>',
                            'bg'      => 'bg-blue-50',
                            'color'   => 'text-blue-500',
                            'label'   => 'Modul & Latihan Mandiri',
                        ],
                        default => [
                            'icon'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253"/>',
                            'bg'      => 'bg-indigo-50',
                            'color'   => 'text-indigo-500',
                            'label'   => 'Bahan Ajar Interaktif',
                        ],
                    };

                    // Status badge
                    $statusConfig = match($modul->status_label) {
                        'Selesai'          => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-700', 'dot' => 'bg-emerald-500'],
                        'Sedang Dipelajari'=> ['bg' => 'bg-amber-100',   'text' => 'text-amber-700',   'dot' => 'bg-amber-500'],
                        default            => ['bg' => 'bg-slate-100',   'text' => 'text-slate-500',   'dot' => 'bg-slate-400'],
                    };

                    // Progres bar color
                    $barColor = match($modul->status_label) {
                        'Selesai'           => 'bg-indigo-600',
                        'Sedang Dipelajari' => 'bg-amber-500',
                        default             => 'bg-slate-300',
                    };

                    // Label mapel / jenjang
                    $mapelLabel = $modul->jenjang->nama_tipe ?? '-';

                    // Format materi
                    $isVideo = $modul->is_video;
                @endphp
                <tr class="hover:bg-slate-50/50 transition-colors duration-100 group">

                    {{-- Nama Materi & Bab --}}
                    <td class="px-5 py-4">
                        <div class="flex items-start gap-3">
                            <div class="w-9 h-9 rounded-xl {{ $tipeConfig['bg'] }} flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-4.5 h-4.5 {{ $tipeConfig['color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    {!! $tipeConfig['icon'] !!}
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-slate-900 leading-snug line-clamp-2">
                                    {{ $modul->judul_modul }}
                                </p>
                                <p class="text-[11px] text-slate-400 mt-0.5 truncate">
                                    @if($isVideo)
                                    Bab {{ $loop->iteration }} &bull; Video Pembelajaran
                                    @else
                                    Bab {{ $loop->iteration }} &bull; Materi Digital
                                    @endif
                                </p>
                            </div>
                        </div>
                    </td>

                    {{-- Mata Pelajaran --}}
                    <td class="px-4 py-4">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-indigo-50 text-indigo-700 text-[11px] font-semibold rounded-lg border border-indigo-100">
                            {{ $mapelLabel }}
                        </span>
                    </td>

                    {{-- Format Bahan Ajar --}}
                    <td class="px-4 py-4">
                        <div class="flex items-center gap-1.5">
                            <div class="w-6 h-6 {{ $tipeConfig['bg'] }} rounded-lg flex items-center justify-center shrink-0">
                                <svg class="w-3.5 h-3.5 {{ $tipeConfig['color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    {!! $tipeConfig['icon'] !!}
                                </svg>
                            </div>
                            <div>
                                <p class="text-[12px] font-medium text-slate-700">{{ $tipeConfig['label'] }}</p>
                                @if($modul->tipe_file)
                                <p class="text-[10px] text-slate-400">{{ strtoupper($modul->tipe_file) }}</p>
                                @endif
                            </div>
                        </div>
                    </td>

                    {{-- Status --}}
                    <td class="px-4 py-4 text-center">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $statusConfig['dot'] }}"></span>
                            {{ $modul->status_label }}
                        </span>
                    </td>

                    {{-- Progres --}}
                    <td class="px-4 py-4">
                        <div class="flex items-center gap-2">
                            <div class="flex-1 bg-slate-100 rounded-full h-2 overflow-hidden min-w-[60px]">
                                <div class="{{ $barColor }} h-2 rounded-full transition-all duration-700"
                                     style="width: {{ $modul->progres }}%"></div>
                            </div>
                            <span class="text-[12px] font-bold text-slate-700 shrink-0 w-8 text-right">
                                @if($modul->status_label === 'Belum Dimulai')
                                –
                                @else
                                {{ $modul->progres }}%
                                @endif
                            </span>
                        </div>
                    </td>

                    {{-- Aksi --}}
                    <td class="px-4 py-4 text-center">
                        <a href="{{ route('modul.show', $modul->id_modul) }}"
                           class="inline-flex items-center gap-1 text-[12px] font-semibold text-indigo-600 hover:text-indigo-800 transition group-hover:underline">
                            Rincian
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                        </a>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        @if($moduls->hasPages())
        <div class="px-5 py-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3">
            <p class="text-[12px] text-slate-400">
                Menampilkan {{ $moduls->firstItem() }}–{{ $moduls->lastItem() }} dari {{ $moduls->total() }} modul terfilter
            </p>
            <div class="flex items-center gap-1">
                {{-- Prev --}}
                @if($moduls->onFirstPage())
                <span class="h-8 w-8 flex items-center justify-center rounded-lg border border-slate-100 text-slate-300 cursor-not-allowed">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </span>
                @else
                <a href="{{ $moduls->previousPageUrl() }}"
                   class="h-8 w-8 flex items-center justify-center rounded-lg border border-slate-200 text-slate-500 hover:bg-slate-50 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </a>
                @endif

                {{-- Page numbers --}}
                @foreach($moduls->getUrlRange(1, $moduls->lastPage()) as $page => $url)
                <a href="{{ $url }}"
                   class="h-8 w-8 flex items-center justify-center rounded-lg text-xs font-semibold transition
                          {{ $page == $moduls->currentPage()
                              ? 'bg-indigo-600 text-white border border-indigo-600'
                              : 'border border-slate-200 text-slate-500 hover:bg-slate-50' }}">
                    {{ $page }}
                </a>
                @endforeach

                {{-- Next --}}
                @if($moduls->hasMorePages())
                <a href="{{ $moduls->nextPageUrl() }}"
                   class="h-8 w-8 flex items-center justify-center rounded-lg border border-slate-200 text-slate-500 hover:bg-slate-50 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                @else
                <span class="h-8 w-8 flex items-center justify-center rounded-lg border border-slate-100 text-slate-300 cursor-not-allowed">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </span>
                @endif
            </div>
            <p class="text-[12px] text-slate-400 sm:block hidden">Selanjutnya &rarr;</p>
        </div>
        @endif

        @endif {{-- end if moduls not empty --}}
    </div>

    @endif {{-- end if siswa --}}
</div>
@endsection
