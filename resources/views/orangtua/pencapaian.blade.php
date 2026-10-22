@extends('layouts.orangtua')
@include('components.page-loader')

@section('title', 'Pencapaian & Apresiasi Belajar - Portal Orang Tua')
@section('breadcrumb', 'Pantau Siswa Terhubung')

@section('content')
<div class="px-4 sm:px-6 py-6 max-w-[1400px] mx-auto">

    {{-- ================================================================
    |  HEADER + BREADCRUMB + SELECTOR SISWA
    ================================================================ --}}
    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-6">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="inline-flex items-center gap-1 text-[11px] font-bold uppercase tracking-widest text-indigo-600">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                    Evaluasi Kompetensi Mandiri
                </span>
            </div>
            <h1 class="text-[22px] font-extrabold text-slate-900 leading-tight">Pencapaian &amp; Apresiasi Belajar</h1>
            <p class="text-sm text-slate-500 mt-0.5 max-w-xl">
                Pantau pengakuan kompetensi kurikular, konsistensi kedisiplinan, dan lencana apresiasi ananda
                berdasarkan keaktifan sistematis di platform Arrava E-Learning.
            </p>
        </div>

        @if($siswa)
        {{-- Selector Siswa --}}
        <form method="GET" action="{{ route('orangtua.pencapaian') }}" id="siswaForm" class="shrink-0">
            <input type="hidden" name="tab"      value="{{ $filterTab }}">
            <input type="hidden" name="kategori" value="{{ $filterKategori }}">
            <input type="hidden" name="q"        value="{{ $searchQuery }}">
            <div class="flex items-center gap-2 bg-white border border-slate-200 rounded-xl px-3 py-2.5 shadow-sm min-w-[240px] hover:border-indigo-300 transition cursor-pointer">
                <div class="w-9 h-9 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold text-sm shrink-0">
                    {{ strtoupper(substr($siswa->nama, 0, 2)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none mb-0.5">Ananda</p>
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
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806"/>
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

        {{-- Total Akumulasi Poin --}}
        <div class="bg-white rounded-xl border border-slate-100 p-4 hover:shadow-md hover:-translate-y-0.5 transition-all duration-150">
            <div class="flex items-start justify-between mb-3">
                <p class="text-[11px] font-bold uppercase tracking-widest text-slate-400">Total Akumulasi Poin</p>
                <div class="w-7 h-7 rounded-lg bg-amber-50 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-amber-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14H9V8h2v8zm4 0h-2V8h2v8z"/>
                    </svg>
                </div>
            </div>
            <div class="flex items-baseline gap-1.5">
                <p class="text-[32px] font-extrabold text-slate-900 leading-none">{{ number_format($stats['total_poin']) }}</p>
                <span class="text-sm font-bold text-amber-600">XP</span>
            </div>
            <div class="mt-2 flex items-center gap-1.5 text-[11px]">
                <svg class="w-3 h-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                </svg>
                <span class="font-semibold text-emerald-600">+{{ number_format(max(0, $stats['total_poin'] - 1240)) }} XP Bulan Februari</span>
            </div>
            <div class="mt-2 text-[11px] text-slate-400">
                Peringkat Kelas:
                <span class="font-bold text-indigo-600">Top {{ $stats['rank_kelas'] }} Angkatan {{ now()->year }}</span>
            </div>
        </div>

        {{-- Lencana Diperoleh --}}
        <div class="bg-white rounded-xl border border-slate-100 p-4 hover:shadow-md hover:-translate-y-0.5 transition-all duration-150">
            <div class="flex items-start justify-between mb-3">
                <p class="text-[11px] font-bold uppercase tracking-widest text-slate-400">Lencana Diperoleh</p>
                <div class="w-7 h-7 rounded-lg bg-indigo-50 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                    </svg>
                </div>
            </div>
            <div class="flex items-baseline gap-1.5">
                <p class="text-[32px] font-extrabold text-slate-900 leading-none">{{ $stats['total_lencana'] }}</p>
                <span class="text-sm font-semibold text-slate-400">/ {{ $stats['total_achievement'] }} Total Lencana</span>
            </div>
            <div class="mt-2 w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                @php $pctLencana = $stats['total_achievement'] > 0 ? round($stats['total_lencana'] / $stats['total_achievement'] * 100) : 0; @endphp
                <div class="h-1.5 rounded-full bg-indigo-500 transition-all duration-700" style="width: {{ $pctLencana }}%"></div>
            </div>
            <p class="text-[11px] text-slate-400 mt-1.5">
                Tingkat Kelulusan <span class="font-semibold text-slate-700">{{ $pctLencana }}% Tuntas</span>
            </p>
        </div>

        {{-- Target Aktif Berjalan --}}
        <div class="bg-white rounded-xl border border-slate-100 p-4 hover:shadow-md hover:-translate-y-0.5 transition-all duration-150">
            <div class="flex items-start justify-between mb-3">
                <p class="text-[11px] font-bold uppercase tracking-widest text-slate-400">Target Aktif Berjalan</p>
                <div class="w-7 h-7 rounded-lg bg-sky-50 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
            <div class="flex items-baseline gap-1.5">
                <p class="text-[32px] font-extrabold text-slate-900 leading-none">{{ $stats['belum_diraih'] }}</p>
                <span class="text-sm font-semibold text-slate-400">Kompetensi</span>
            </div>
            <p class="text-[11px] text-slate-400 mt-2">Mendekati ambang syarat tuntas</p>
            <p class="text-[11px] font-semibold text-amber-600 flex items-center gap-1 mt-0.5">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
                Streak Kuis {{ $stats['kuis_lulus'] }} Hari
            </p>
            <p class="text-[11px] text-slate-400 mt-0.5">Target Terdepan</p>
        </div>

        {{-- Tingkat Penguasaan / Level --}}
        <div class="bg-white rounded-xl border border-slate-100 p-4 hover:shadow-md hover:-translate-y-0.5 transition-all duration-150">
            <div class="flex items-start justify-between mb-3">
                <p class="text-[11px] font-bold uppercase tracking-widest text-slate-400">Tingkat Penguasaan</p>
                <div class="w-7 h-7 rounded-lg {{ $stats['level']['bg'] }} flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 {{ $stats['level']['warna'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
            </div>
            <div class="flex items-baseline gap-2">
                <p class="text-[32px] font-extrabold text-slate-900 leading-none">Level {{ $stats['level']['level'] }}</p>
                <span class="text-sm font-bold {{ $stats['level']['warna'] }}">▪ {{ $stats['level']['nama'] }}</span>
            </div>
            <p class="text-[11px] text-slate-400 mt-2">Pelajaran Sains &amp; Bahasa Madya</p>
            @if($stats['poin_next_level'])
            <p class="text-[11px] text-slate-400 mt-1">
                Target Lanjutan:
                <span class="font-semibold text-slate-600">Level {{ $stats['level']['level'] + 1 }} ({{ number_format($stats['poin_next_level']) }} XP)</span>
            </p>
            @else
            <p class="text-[11px] font-semibold text-emerald-600 mt-1">Level Tertinggi Dicapai! 🎉</p>
            @endif
        </div>
    </div>

    {{-- ================================================================
    |  FILTER TABS + SEARCH
    ================================================================ --}}
    <div class="bg-white rounded-xl border border-slate-100 p-4 mb-5">
        <form method="GET" action="{{ route('orangtua.pencapaian') }}" id="filterForm" class="flex flex-col sm:flex-row gap-3 items-start sm:items-center">
            <input type="hidden" name="siswa_id" value="{{ $siswa->id_user }}">

            {{-- Tabs --}}
            <div class="flex items-center gap-1 bg-slate-100 rounded-xl p-1 shrink-0">
                @php
                    $tabs = [
                        ['val' => 'semua',  'label' => 'Semua Pencapaian (' . ($diraih->count() + $belumDiraih->count()) . ')'],
                        ['val' => 'diraih', 'label' => 'Telah Diperoleh (' . $diraih->count() . ')'],
                        ['val' => 'belum',  'label' => 'Belum Diperoleh / Terkunci (' . $belumDiraih->count() . ')'],
                    ];
                @endphp
                @foreach($tabs as $tab)
                <button type="submit" name="tab" value="{{ $tab['val'] }}"
                        class="px-3 py-1.5 rounded-lg text-xs font-semibold transition whitespace-nowrap
                               {{ $filterTab === $tab['val']
                                   ? 'bg-indigo-600 text-white shadow-sm'
                                   : 'text-slate-500 hover:text-slate-700 hover:bg-white' }}">
                    {{ $tab['label'] }}
                </button>
                @endforeach
            </div>

            <div class="flex items-center gap-2 flex-1 min-w-0">
                {{-- Search --}}
                <div class="relative flex-1">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="q" value="{{ $searchQuery }}"
                           placeholder="Cari lencana / syarat..."
                           class="w-full pl-9 pr-4 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 transition">
                </div>

                {{-- Reset --}}
                <a href="{{ route('orangtua.pencapaian', ['siswa_id' => $siswa->id_user]) }}"
                   class="flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-slate-400 hover:bg-slate-50 hover:text-slate-600 transition shrink-0"
                   title="Reset Filter">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                </a>
            </div>
        </form>
    </div>

    {{-- ================================================================
    |  GRID KARTU PENCAPAIAN
    ================================================================ --}}
    @php
        $displayItems = match($filterTab) {
            'diraih' => $diraih->values(),
            'belum'  => $belumDiraih->values(),
            default  => $semuaItems,
        };
    @endphp

    @if($displayItems->isEmpty())
    <div class="bg-white rounded-2xl border border-dashed border-slate-200 p-14 text-center">
        <svg class="w-12 h-12 text-slate-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0"/>
        </svg>
        <p class="text-sm font-semibold text-slate-400">Belum ada pencapaian ditemukan</p>
        <p class="text-xs text-slate-300 mt-1">Coba ubah filter atau kata kunci</p>
    </div>
    @else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($displayItems as $item)
        @php
            $isDiraih = ($item['status'] === 'tercapai');
            $isSedang = ($item['status'] === 'sedang');
            $isTerkunci = ($item['status'] === 'terkunci');

            // Warna palet bergilir
            $palettes = [
                ['border' => 'border-blue-100',   'bg' => 'bg-blue-50',    'icon' => 'bg-blue-100',    'text' => 'text-blue-600',   'badge_bg' => 'bg-blue-50',    'badge_text' => 'text-blue-600'],
                ['border' => 'border-amber-100',   'bg' => 'bg-amber-50',   'icon' => 'bg-amber-100',   'text' => 'text-amber-600',  'badge_bg' => 'bg-amber-50',   'badge_text' => 'text-amber-600'],
                ['border' => 'border-emerald-100', 'bg' => 'bg-emerald-50', 'icon' => 'bg-emerald-100', 'text' => 'text-emerald-600','badge_bg' => 'bg-emerald-50', 'badge_text' => 'text-emerald-600'],
                ['border' => 'border-purple-100',  'bg' => 'bg-purple-50',  'icon' => 'bg-purple-100',  'text' => 'text-purple-600', 'badge_bg' => 'bg-purple-50',  'badge_text' => 'text-purple-600'],
                ['border' => 'border-sky-100',     'bg' => 'bg-sky-50',     'icon' => 'bg-sky-100',     'text' => 'text-sky-600',    'badge_bg' => 'bg-sky-50',     'badge_text' => 'text-sky-600'],
                ['border' => 'border-rose-100',    'bg' => 'bg-rose-50',    'icon' => 'bg-rose-100',    'text' => 'text-rose-600',   'badge_bg' => 'bg-rose-50',    'badge_text' => 'text-rose-600'],
            ];
            $p = $palettes[$loop->index % count($palettes)];

            // Jika terkunci, grayscale
            if ($isTerkunci) {
                $p = ['border' => 'border-slate-100', 'bg' => 'bg-slate-50', 'icon' => 'bg-slate-100', 'text' => 'text-slate-400', 'badge_bg' => 'bg-slate-100', 'badge_text' => 'text-slate-400'];
            }
        @endphp

        <div class="relative bg-white border {{ $p['border'] }} rounded-2xl p-5 hover:shadow-md hover:-translate-y-0.5 transition-all duration-150 flex flex-col gap-3 {{ $isTerkunci ? 'opacity-70' : '' }}">

            {{-- Status badge (pojok kanan atas) --}}
            <div class="absolute top-4 right-4 flex flex-col items-end gap-1">
                @if($isDiraih)
                <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 text-[10px] font-bold px-2 py-0.5 rounded-full border border-emerald-100">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                    Tercapai
                </span>
                @elseif($isSedang)
                <span class="inline-flex items-center gap-1 bg-amber-50 text-amber-700 text-[10px] font-bold px-2 py-0.5 rounded-full border border-amber-100">
                    <svg class="w-3 h-3 animate-pulse" fill="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/></svg>
                    Sedang Berjalan
                </span>
                @else
                <span class="inline-flex items-center gap-1 bg-slate-100 text-slate-500 text-[10px] font-bold px-2 py-0.5 rounded-full">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    Terkunci
                </span>
                @endif

                @if($item['poin'] > 0)
                <span class="text-[10px] font-bold {{ $p['text'] }} mt-0.5">+{{ number_format($item['poin']) }} XP</span>
                @endif
            </div>

            {{-- Icon + Nama --}}
            <div class="flex items-start gap-3 pr-20">
                <div class="w-11 h-11 {{ $p['icon'] }} rounded-xl flex items-center justify-center shrink-0 border {{ $p['border'] }}">
                    @if(!empty($item['gambar_url']))
                    <img src="{{ $item['gambar_url'] }}" alt="{{ $item['nama'] }}" class="w-7 h-7 object-contain">
                    @else
                    <svg class="w-5 h-5 {{ $p['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0"/>
                    </svg>
                    @endif
                </div>
                <div class="min-w-0">
                    <h3 class="text-[14px] font-bold text-slate-900 leading-snug line-clamp-2">{{ $item['nama'] }}</h3>
                    @if($isDiraih && $item['waktu'])
                    <p class="text-[11px] text-slate-400 mt-0.5">
                        Diperoleh {{ \Carbon\Carbon::parse($item['waktu'])->translatedFormat('d M Y') }}
                    </p>
                    @elseif($isSedang || $isTerkunci)
                    <p class="text-[11px] text-slate-400 mt-0.5">Syarat: {{ number_format($item['poin']) }} XP</p>
                    @endif
                </div>
            </div>

            {{-- Deskripsi --}}
            <p class="text-[12px] text-slate-500 leading-relaxed line-clamp-2">{{ $item['deskripsi'] }}</p>

            {{-- Progres bar (hanya untuk belum/sedang) --}}
            @if(!$isDiraih && isset($item['progres']))
            <div>
                <div class="flex items-center justify-between mb-1">
                    <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wide">Status Pemenuhan</p>
                    <span class="text-[11px] font-bold text-slate-600">{{ $item['progres'] }}%</span>
                </div>
                <div class="w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                    <div class="h-1.5 rounded-full {{ $isSedang ? 'bg-amber-400' : 'bg-slate-300' }} transition-all duration-700"
                         style="width: {{ $item['progres'] }}%"></div>
                </div>
                @if($isTerkunci)
                <p class="text-[10px] text-slate-400 mt-1">Menunggu Jadwal UTS Maret</p>
                @endif
            </div>
            @endif

            {{-- Footer: tombol rincian --}}
            <div class="flex items-center justify-between pt-1 border-t border-slate-50 mt-auto">
                <div></div>
                <button type="button"
                        class="inline-flex items-center gap-1 text-[12px] font-semibold {{ $isDiraih ? $p['text'] : 'text-slate-400' }} hover:underline transition">
                    Rincian
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    @endif {{-- end if siswa --}}
</div>
@endsection
