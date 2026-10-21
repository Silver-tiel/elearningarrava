@extends('layouts.orangtua')
@include('components.page-loader')

@section('title', 'Dashboard - Portal Orang Tua')
@section('breadcrumb', 'Ringkasan Belajar Siswa')

@section('content')
<div class="px-4 sm:px-6 py-6 max-w-[1400px] mx-auto">

    {{-- =====================================================================
    |  HEADER + SELECTOR SISWA
    ====================================================================== --}}
    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-6">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <h1 class="text-[22px] font-bold text-slate-900 leading-tight">Ringkasan Belajar</h1>
                <span class="inline-block px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-indigo-100 text-indigo-700">Semester Ganjil</span>
            </div>
            <p class="text-sm text-slate-500">Pantau capaian nilai kuis, progres materi, dan aktivitas belajar harian ananda secara berkala.</p>
        </div>

        @if($siswa)
        {{-- Selector & Info Siswa --}}
        <div class="flex items-center gap-3 bg-white border border-slate-200 rounded-xl px-3 py-2 shadow-sm min-w-[240px]">
            <div class="w-9 h-9 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold text-sm shrink-0">
                {{ strtoupper(substr($siswa->nama, 0, 2)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-slate-900 leading-tight truncate">{{ $siswa->nama }}</p>
                <p class="text-[11px] text-slate-400">
                    {{ $siswa->jenjang->nama_tipe ?? '-' }}
                    @if($siswa->nisn) &bull; NISN {{ $siswa->nisn }} @endif
                </p>
            </div>
            @if($siswaList->count() > 1)
            <form method="GET" action="{{ route('orangtua.dashboard') }}" class="shrink-0">
                <select name="siswa_id" onchange="this.form.submit()"
                        class="text-xs border-0 bg-transparent text-slate-500 focus:ring-0 cursor-pointer pr-6">
                    @foreach($siswaList as $s)
                    <option value="{{ $s->id_user }}" {{ $s->id_user == $siswa->id_user ? 'selected' : '' }}>
                        {{ $s->nama }}
                    </option>
                    @endforeach
                </select>
            </form>
            @else
            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
            @endif
        </div>
        @endif
    </div>

    {{-- =====================================================================
    |  EMPTY STATE — belum ada siswa yang dihubungkan
    ====================================================================== --}}
    @if(!$siswa)
    <div class="bg-white rounded-2xl border border-dashed border-slate-200 p-12 text-center">
        <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
        </svg>
        <h3 class="text-base font-semibold text-slate-700 mb-1">Belum ada siswa yang dihubungkan</h3>
        <p class="text-sm text-slate-400">Hubungi administrator untuk menautkan akun orang tua Anda dengan akun siswa.</p>
    </div>

    @else

    {{-- =====================================================================
    |  4 STAT CARDS
    ====================================================================== --}}
    <div class="grid grid-cols-2 xl:grid-cols-4 gap-4 mb-6">

        {{-- Rata-rata Nilai --}}
        <div class="stat-card bg-white rounded-xl border border-slate-100 p-4 relative overflow-hidden">
            <div class="flex items-start justify-between mb-2">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Rata-Rata Nilai</p>
                <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                </svg>
            </div>
            <p class="text-[32px] font-extrabold text-slate-900 leading-none">{{ number_format($stats['avg_nilai'], 1) }}</p>
            <p class="text-[11px] text-slate-400 mt-1">/100</p>
            <div class="mt-2 flex items-center gap-1.5">
                @if($stats['avg_nilai'] >= $stats['kkm'])
                <span class="inline-flex items-center gap-0.5 text-[11px] font-semibold text-emerald-600">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                    di atas KKM ({{ $stats['kkm'] }}.0)
                </span>
                @else
                <span class="inline-flex items-center gap-0.5 text-[11px] font-semibold text-red-500">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                    di bawah KKM ({{ $stats['kkm'] }}.0)
                </span>
                @endif
            </div>
            <div class="mt-2 flex items-center gap-1 text-[11px] text-slate-400">
                <span>Evaluasi Status:</span>
                <span class="font-semibold text-slate-600">{{ $stats['status_eval'] }}</span>
            </div>
        </div>

        {{-- Kuis Dikerjakan --}}
        <div class="stat-card bg-white rounded-xl border border-slate-100 p-4 relative overflow-hidden">
            <div class="flex items-start justify-between mb-2">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Kuis Dikerjakan</p>
                <div class="w-7 h-7 rounded-lg bg-blue-50 flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                </div>
            </div>
            <p class="text-[32px] font-extrabold text-slate-900 leading-none">{{ $stats['total_quiz_dikerjakan'] }}</p>
            <p class="text-[11px] text-slate-400 mt-1">/ {{ $stats['total_quiz_tersedia'] }} Kuis</p>
            <div class="mt-2 w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                <div class="h-1.5 rounded-full bg-blue-500 progress-bar"
                     style="width: {{ min(100, $stats['partisipasi_persen']) }}%"></div>
            </div>
            <p class="text-[11px] text-slate-400 mt-1">
                Partisipasi:
                <span class="font-semibold text-blue-600">{{ $stats['partisipasi_persen'] }}%
                    @if($stats['partisipasi_persen'] >= 80) [Aktif] @elseif($stats['partisipasi_persen'] >= 50) [Sedang] @else [Rendah] @endif
                </span>
            </p>
        </div>

        {{-- Materi Selesai --}}
        <div class="stat-card bg-white rounded-xl border border-slate-100 p-4 relative overflow-hidden">
            <div class="flex items-start justify-between mb-2">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Materi Selesai</p>
                <div class="w-7 h-7 rounded-lg bg-emerald-50 flex items-center justify-center">
                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
            </div>
            <p class="text-[32px] font-extrabold text-slate-900 leading-none">{{ $stats['modul_selesai'] }}</p>
            <p class="text-[11px] text-slate-400 mt-1">/ {{ $stats['total_modul'] }} Modul</p>
            <div class="mt-2 w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                <div class="h-1.5 rounded-full bg-emerald-500 progress-bar"
                     style="width: {{ min(100, $stats['target_kurikulum_persen']) }}%"></div>
            </div>
            <p class="text-[11px] text-slate-400 mt-1">
                Target Kurikulum:
                <span class="font-semibold text-emerald-600">{{ $stats['target_kurikulum_persen'] }}% Ketuntasan</span>
            </p>
        </div>

        {{-- Total Poin --}}
        <div class="stat-card bg-white rounded-xl border border-slate-100 p-4 relative overflow-hidden">
            <div class="flex items-start justify-between mb-2">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Poin</p>
                <svg class="w-5 h-5 text-amber-500" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14H9V8h2v8zm4 0h-2V8h2v8z"/>
                </svg>
            </div>
            <div class="flex items-baseline gap-1.5">
                <p class="text-[32px] font-extrabold text-slate-900 leading-none">{{ number_format($stats['total_poin']) }}</p>
                <span class="text-sm font-bold text-amber-600">XP</span>
            </div>
            @php
                $rankInfo = $siswa->rank_tier;
                $pencapaianCount = $pencapaian->count();
            @endphp
            <p class="text-[11px] text-slate-400 mt-1">
                {{ $pencapaianCount }} Lencana Diraih
            </p>
            <div class="mt-2 text-[11px] text-slate-400">
                Peringkat Kelas:
                <span class="font-semibold text-amber-600">Top {{ $stats['rank_kelas'] }} di Angkatan</span>
            </div>
        </div>

    </div>

    {{-- =====================================================================
    |  GRAFIK TREN NILAI + KETUNTASAN MATA PELAJARAN
    ====================================================================== --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-4 mb-6">

        {{-- Grafik Tren --}}
        <div class="xl:col-span-2 bg-white rounded-xl border border-slate-100 p-5">
            <div class="flex flex-wrap items-start justify-between gap-3 mb-4">
                <div>
                    <h2 class="text-[15px] font-bold text-slate-900">Tren Perkembangan Nilai Kuis</h2>
                    <p class="text-xs text-slate-400 mt-0.5">
                        Komparasi capaian siswa vs standar KKM ({{ $stats['kkm'] }}.0)
                    </p>
                </div>
                {{-- Legend --}}
                <div class="flex flex-wrap items-center gap-4 text-xs">
                    <span class="flex items-center gap-1.5">
                        <span class="w-3 h-3 rounded-full bg-indigo-500 inline-block"></span>
                        <span class="text-slate-600">Nilai {{ $siswa->nama }}</span>
                    </span>
                    <span class="flex items-center gap-1.5">
                        <span class="w-3 h-3 rounded-full bg-red-400 inline-block"></span>
                        <span class="text-slate-600">Batas KKM ({{ $stats['kkm'] }}.0)</span>
                    </span>
                </div>
            </div>

            @if($quizTrend->isEmpty())
            <div class="flex flex-col items-center justify-center h-40 text-slate-300">
                <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                <p class="text-sm">Belum ada data kuis</p>
            </div>
            @else
            {{-- Chart SVG area --}}
            <div class="relative" style="height:200px;" id="chartWrapper">
                <canvas id="quizChart" class="w-full h-full"></canvas>
            </div>
            <div class="flex flex-wrap gap-2 mt-3 justify-center">
                @foreach($quizTrend as $item)
                <span class="text-[10px] text-slate-400 text-center" style="min-width:48px">{{ $item['label'] }}</span>
                @endforeach
            </div>
            @endif
        </div>

        {{-- Ketuntasan Mata Pelajaran --}}
        <div class="bg-white rounded-xl border border-slate-100 p-5">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-[15px] font-bold text-slate-900">Ketuntasan Mata Pelajaran</h2>
                    <p class="text-xs text-slate-400 mt-0.5">target KKM: {{ $stats['kkm'] }}</p>
                </div>
            </div>

            @if($modulProgress->isEmpty())
            <div class="flex flex-col items-center justify-center h-32 text-slate-300">
                <p class="text-sm">Belum ada data modul</p>
            </div>
            @else
            <div class="space-y-4">
                @foreach($modulProgress->take(5) as $mp)
                @php
                    $barColor = match(true) {
                        $mp['avg_nilai'] >= 90 => 'bg-indigo-500',
                        $mp['avg_nilai'] >= 80 => 'bg-blue-500',
                        $mp['avg_nilai'] >= 70 => 'bg-emerald-500',
                        $mp['avg_nilai'] >= 60 => 'bg-amber-500',
                        default => 'bg-red-400',
                    };
                @endphp
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-sm font-medium text-slate-700">{{ $mp['nama'] }}</span>
                        <span class="text-sm font-bold text-slate-900">{{ $mp['persen'] }}%</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                        <div class="{{ $barColor }} h-2 rounded-full progress-bar"
                             style="width: {{ $mp['persen'] }}%"></div>
                    </div>
                    <p class="text-[11px] text-slate-400 mt-0.5">
                        {{ $mp['selesai'] }} Modul Selesai
                        @if($mp['avg_nilai'] > 0) &bull; Rata-rata Nilai {{ $mp['avg_nilai'] }} @endif
                    </p>
                </div>
                @endforeach
            </div>
            @endif

            {{-- Total jam belajar --}}
            <div class="mt-5 flex items-center justify-between bg-slate-50 rounded-xl px-4 py-3">
                <div class="flex items-center gap-2 text-slate-600">
                    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-xs font-medium">Total Jam Belajar Mandiri</span>
                </div>
                <span class="text-sm font-bold text-slate-900">
                    {{ floor($totalJamBelajar / 60) }} Jam {{ $totalJamBelajar % 60 }} Mnt
                </span>
            </div>
        </div>
    </div>

    {{-- =====================================================================
    |  TABEL AKTIVITAS BELAJAR TERBARU
    ====================================================================== --}}
    <div class="bg-white rounded-xl border border-slate-100 p-5 mb-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-[15px] font-bold text-slate-900">Aktivitas Belajar Terbaru</h2>
                <p class="text-xs text-slate-400 mt-0.5">Log pengerjaan kuis dari 7 hari terakhir.</p>
            </div>
            <a href="{{ route('orangtua.dashboard') }}" class="text-xs font-semibold text-indigo-600 hover:underline flex items-center gap-1">
                Buka Log Aktivitas Lengkap
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>

        @if($aktivitas->isEmpty())
        <div class="flex flex-col items-center justify-center py-10 text-slate-300">
            <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            <p class="text-sm">Belum ada aktivitas tercatat</p>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-100">
                        <th class="text-left text-[11px] font-semibold uppercase tracking-wider text-slate-400 pb-2 pr-4">Waktu &amp; Tanggal</th>
                        <th class="text-left text-[11px] font-semibold uppercase tracking-wider text-slate-400 pb-2 pr-4">Mata Pelajaran &amp; Materi</th>
                        <th class="text-left text-[11px] font-semibold uppercase tracking-wider text-slate-400 pb-2 pr-4">Tipe Aktivitas</th>
                        <th class="text-right text-[11px] font-semibold uppercase tracking-wider text-slate-400 pb-2 pr-4">Nilai / Durasi</th>
                        <th class="text-center text-[11px] font-semibold uppercase tracking-wider text-slate-400 pb-2 pr-4">Status</th>
                        <th class="text-right text-[11px] font-semibold uppercase tracking-wider text-slate-400 pb-2">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($aktivitas as $item)
                    @php
                        $badgeClass = match($item['status']) {
                            'Tuntas'   => 'bg-emerald-50 text-emerald-700',
                            'Remedial' => 'bg-red-50 text-red-700',
                            default    => 'bg-blue-50 text-blue-700',
                        };
                        $waktu = $item['waktu'] instanceof \Carbon\Carbon ? $item['waktu'] : \Carbon\Carbon::parse($item['waktu']);
                    @endphp
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="py-3 pr-4">
                            <p class="font-medium text-slate-800 text-[13px]">{{ $waktu->translatedFormat('D, H:i') }} WIB</p>
                            <p class="text-[11px] text-slate-400">{{ $waktu->translatedFormat('d M Y') }}</p>
                        </td>
                        <td class="py-3 pr-4 max-w-[180px]">
                            <p class="font-medium text-slate-800 text-[13px] truncate">{{ $item['judul_quiz'] }}</p>
                            <p class="text-[11px] text-slate-400">Kuis {{ $item['tipe'] }}</p>
                        </td>
                        <td class="py-3 pr-4">
                            <div class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-blue-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                </svg>
                                <span class="text-[13px] text-slate-600">Kuis {{ $item['tipe'] }}</span>
                            </div>
                        </td>
                        <td class="py-3 pr-4 text-right">
                            <p class="font-bold text-slate-900 text-[15px]">{{ number_format($item['nilai'], 1) }}</p>
                            <p class="text-[11px] text-slate-400">
                                {{ $item['poin_didapat'] }} / {{ $item['total_poin'] }} Poin
                            </p>
                        </td>
                        <td class="py-3 pr-4 text-center">
                            <span class="inline-block px-2.5 py-0.5 rounded-full text-[11px] font-semibold {{ $badgeClass }}">
                                {{ $item['status'] }}
                            </span>
                        </td>
                        <td class="py-3 text-right">
                            <button class="text-xs font-medium text-indigo-600 hover:underline">
                                Detail
                                <svg class="w-3 h-3 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

    {{-- =====================================================================
    |  PENCAPAIAN & LENCANA TERBARU
    ====================================================================== --}}
    <div class="bg-white rounded-xl border border-slate-100 p-5 mb-6">
        <div class="flex items-center justify-between mb-1">
            <div>
                <h2 class="text-[15px] font-bold text-slate-900">Pencapaian &amp; Lencana Terbaru</h2>
                <p class="text-xs text-slate-400 mt-0.5">
                    Apresiasi sistem atas konsistensi belajar dan perolehan poin {{ $siswa->nama }}.
                </p>
            </div>
            @if($pencapaian->isNotEmpty())
            <a href="{{ route('orangtua.dashboard') }}" class="text-xs font-semibold text-indigo-600 hover:underline">
                Lihat Semua Lencana ({{ \App\Models\PencapaianUser::where('id_user', $siswa->id_user)->count() }})
            </a>
            @endif
        </div>

        @if($pencapaian->isEmpty())
        <div class="flex flex-col items-center justify-center py-8 text-slate-300 mt-2">
            <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
            </svg>
            <p class="text-sm">Belum ada pencapaian diraih</p>
        </div>
        @else
        <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($pencapaian as $p)
            @php
                $achievement = $p->achievement;
                $poin = $achievement ? $achievement->minimal_poin_achivement : 0;
                $colors = ['bg-blue-50 border-blue-100', 'bg-amber-50 border-amber-100', 'bg-emerald-50 border-emerald-100'];
                $colorClass = $colors[$loop->index % 3];
                $iconColors = ['text-blue-500', 'text-amber-500', 'text-emerald-500'];
                $iconColor  = $iconColors[$loop->index % 3];
            @endphp
            <div class="border {{ $colorClass }} rounded-xl p-4 flex items-start gap-3">
                <div class="w-10 h-10 rounded-xl {{ str_replace('bg-', 'bg-', explode(' ', $colorClass)[0]) }} flex items-center justify-center shrink-0 border {{ explode(' ', $colorClass)[1] }}">
                    @if($achievement && $achievement->gambar_url)
                    <img src="{{ $achievement->gambar_url }}" alt="{{ $p->nama }}" class="w-7 h-7 object-contain">
                    @else
                    <svg class="w-5 h-5 {{ $iconColor }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                    @endif
                </div>
                <div class="min-w-0">
                    <p class="text-[11px] text-slate-400 mb-0.5">
                        {{ \Carbon\Carbon::parse($p->waktu_pencapaian)->translatedFormat('d M Y') }}
                        @if($poin > 0) &bull; <span class="font-semibold {{ $iconColor }}">+{{ number_format($poin) }} XP</span> @endif
                    </p>
                    <h4 class="text-sm font-bold text-slate-900 leading-snug">{{ $p->nama }}</h4>
                    @if($achievement && $achievement->deskripsi)
                    <p class="text-[11px] text-slate-500 mt-0.5 leading-relaxed line-clamp-2">{{ $achievement->deskripsi }}</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    {{-- =====================================================================
    |  PINTASAN LAYANAN AKADEMIK
    ====================================================================== --}}
    <div class="bg-white rounded-xl border border-slate-100 p-5 mb-6">
        <h2 class="text-[15px] font-bold text-slate-900 mb-0.5">Pintasan Layanan Akademik</h2>
        <p class="text-xs text-slate-400 mb-4">Akses cepat menuju buku nilai resmi, materi, riwayat kuis, dan konsultasi wali kelas.</p>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            {{-- Buku Nilai & Rapor --}}
            <a href="{{ route('orangtua.dashboard') }}"
               class="group flex items-center justify-between border border-slate-200 rounded-xl px-4 py-4 hover:border-indigo-300 hover:bg-indigo-50/40 transition">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-slate-100 group-hover:bg-indigo-100 flex items-center justify-center transition">
                        <svg class="w-5 h-5 text-slate-500 group-hover:text-indigo-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-slate-800">Buku Nilai &amp; Rapor</p>
                        <p class="text-[11px] text-slate-400">Transkip kompetensi resmi Kurikulum Merdeka.</p>
                    </div>
                </div>
                <svg class="w-4 h-4 text-slate-300 group-hover:text-indigo-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>

            {{-- Materi Pembelajaran --}}
            <a href="{{ route('orangtua.dashboard') }}"
               class="group flex items-center justify-between border border-slate-200 rounded-xl px-4 py-4 hover:border-indigo-300 hover:bg-indigo-50/40 transition">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-slate-100 group-hover:bg-indigo-100 flex items-center justify-center transition">
                        <svg class="w-5 h-5 text-slate-500 group-hover:text-indigo-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-slate-800">Materi Pembelajaran</p>
                        <p class="text-[11px] text-slate-400">Katalog e-book, video, dan modul interaktif.</p>
                    </div>
                </div>
                <svg class="w-4 h-4 text-slate-300 group-hover:text-indigo-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>

            {{-- Riwayat Kuis --}}
            <a href="{{ route('orangtua.dashboard') }}"
               class="group flex items-center justify-between border border-slate-200 rounded-xl px-4 py-4 hover:border-indigo-300 hover:bg-indigo-50/40 transition">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-slate-100 group-hover:bg-indigo-100 flex items-center justify-center transition">
                        <svg class="w-5 h-5 text-slate-500 group-hover:text-indigo-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-slate-800">Riwayat Kuis</p>
                        <p class="text-[11px] text-slate-400">Analisis butir soal salah dan pembahasan kunci.</p>
                    </div>
                </div>
                <svg class="w-4 h-4 text-slate-300 group-hover:text-indigo-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>

    @endif {{-- end @if($siswa) --}}
</div>
@endsection

@push('scripts')
@if($siswa && $quizTrend->isNotEmpty())
<script>
(function () {
    const canvas = document.getElementById('quizChart');
    if (!canvas) return;

    const rawData = @json($quizTrend->pluck('nilai'));
    const labels  = @json($quizTrend->pluck('label'));
    const kkm     = {{ $stats['kkm'] }};

    const dpr    = window.devicePixelRatio || 1;
    const parent = canvas.parentElement;
    const w      = parent.clientWidth;
    const h      = parent.clientHeight || 200;

    canvas.width  = w * dpr;
    canvas.height = h * dpr;
    canvas.style.width  = w + 'px';
    canvas.style.height = h + 'px';

    const ctx = canvas.getContext('2d');
    ctx.scale(dpr, dpr);

    const padL = 32, padR = 20, padT = 16, padB = 36;
    const innerW = w - padL - padR;
    const innerH = h - padT - padB;

    const minVal  = 0;
    const maxVal  = 100;
    const range   = maxVal - minVal;
    const n       = rawData.length;

    function xOf(i)   { return padL + (i / Math.max(n - 1, 1)) * innerW; }
    function yOf(val) { return padT + (1 - (val - minVal) / range) * innerH; }

    // Grid lines
    ctx.strokeStyle = '#f1f5f9';
    ctx.lineWidth   = 1;
    for (let g = 0; g <= 4; g++) {
        const yy = padT + (g / 4) * innerH;
        ctx.beginPath();
        ctx.moveTo(padL, yy);
        ctx.lineTo(w - padR, yy);
        ctx.stroke();
        const label = Math.round(maxVal - (g / 4) * range);
        ctx.fillStyle = '#94a3b8';
        ctx.font      = '9px Inter, sans-serif';
        ctx.textAlign = 'right';
        ctx.fillText(label, padL - 4, yy + 3);
    }

    // KKM line
    const kkmY = yOf(kkm);
    ctx.setLineDash([5, 4]);
    ctx.strokeStyle = '#f87171';
    ctx.lineWidth   = 1;
    ctx.beginPath();
    ctx.moveTo(padL, kkmY);
    ctx.lineTo(w - padR, kkmY);
    ctx.stroke();
    ctx.setLineDash([]);
    ctx.fillStyle   = '#f87171';
    ctx.font        = '9px Inter, sans-serif';
    ctx.textAlign   = 'left';
    ctx.fillText('KKM ' + kkm, w - padR + 2, kkmY + 3);

    if (n === 0) return;

    // Fill gradient area
    const grad = ctx.createLinearGradient(0, padT, 0, padT + innerH);
    grad.addColorStop(0,   'rgba(99,102,241,0.18)');
    grad.addColorStop(1,   'rgba(99,102,241,0.01)');

    ctx.beginPath();
    ctx.moveTo(xOf(0), yOf(rawData[0]));
    rawData.forEach((v, i) => { if (i > 0) ctx.lineTo(xOf(i), yOf(v)); });
    ctx.lineTo(xOf(n - 1), padT + innerH);
    ctx.lineTo(xOf(0), padT + innerH);
    ctx.closePath();
    ctx.fillStyle = grad;
    ctx.fill();

    // Line
    ctx.beginPath();
    ctx.strokeStyle = '#6366f1';
    ctx.lineWidth   = 2;
    ctx.lineJoin    = 'round';
    ctx.moveTo(xOf(0), yOf(rawData[0]));
    rawData.forEach((v, i) => { if (i > 0) ctx.lineTo(xOf(i), yOf(v)); });
    ctx.stroke();

    // Data points + labels
    rawData.forEach((v, i) => {
        const x = xOf(i), y = yOf(v);
        ctx.beginPath();
        ctx.arc(x, y, 4, 0, Math.PI * 2);
        ctx.fillStyle   = v < kkm ? '#f87171' : '#6366f1';
        ctx.fill();
        ctx.strokeStyle = '#fff';
        ctx.lineWidth   = 1.5;
        ctx.stroke();

        // Value label
        ctx.fillStyle = '#334155';
        ctx.font      = 'bold 9px Inter, sans-serif';
        ctx.textAlign = 'center';
        ctx.fillText(v, x, y - 7);
    });
})();
</script>
@endif
@endpush
