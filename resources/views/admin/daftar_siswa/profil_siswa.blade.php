@extends('layouts.app')

@section('header')
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 py-1">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.daftar_siswa') }}" 
           class="h-9 w-9 flex items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 hover:text-blue-600 transition shadow-xs" 
           title="Kembali ke Daftar Siswa">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
        <div>
            <div class="flex items-center gap-2">
                <span class="text-xs font-semibold uppercase tracking-wider text-blue-600">Admin Telemetri</span>
                <span class="text-slate-300">•</span>
                <span class="text-xs text-slate-500">Profil Siswa</span>
            </div>
            <h1 class="text-lg font-bold text-slate-900 leading-tight">{{ $siswa->nama }}</h1>
        </div>
    </div>

    <div class="flex items-center gap-2.5">
        <a href="{{ route('admin.daftar_siswa') }}" 
           class="px-3.5 py-1.5 rounded-xl border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 text-xs font-semibold transition flex items-center gap-1.5 shadow-xs">
            <span>Daftar Siswa</span>
        </a>
        <button type="button" onclick="openStatusModal()"
           class="px-3.5 py-1.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold transition shadow-xs flex items-center gap-1.5">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            <span>Kelola Akun</span>
        </button>
    </div>
</div>
@endsection

@section('content')
<!-- Include CDN Chart.js untuk grafik interaktif modern -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="p-4 sm:p-6 lg:p-8 space-y-6 max-w-7xl mx-auto">

    @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between shadow-xs">
            <div class="flex items-center gap-3">
                <span class="w-6 h-6 rounded-full bg-emerald-500 text-white flex items-center justify-center text-xs font-bold">✓</span>
                <span class="font-medium text-sm">{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">✕</button>
        </div>
    @endif

    {{-- ============================================================
        1. HERO CARD FUTURISTIK (CYBERNETIC TELEMETRY CARD)
    ============================================================ --}}
    @php
        $rank = $siswa->rank_tier;
        $isAktif = ($siswa->status_akun ?? 'Aktif') === 'Aktif';
    @endphp

    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-slate-950 via-slate-900 to-indigo-950 border border-slate-800 text-white p-6 sm:p-8 shadow-2xl">
        <!-- Ambient Radial Glows -->
        <div class="absolute -top-24 -left-24 w-72 h-72 bg-cyan-500/15 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -right-24 w-80 h-80 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-purple-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <!-- Cyber Grid Line Pattern Overlay -->
        <div class="absolute inset-0 opacity-[0.03] pointer-events-none" style="background-image: linear-gradient(to right, #ffffff 1px, transparent 1px), linear-gradient(to bottom, #ffffff 1px, transparent 1px); background-size: 32px 32px;"></div>

        <div class="relative z-10 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
            <!-- Avatar & Main Identity -->
            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6 text-center sm:text-left">
                <!-- Avatar with glowing futuristic ring -->
                <div class="relative shrink-0">
                    <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-2xl p-1 bg-gradient-to-br from-cyan-400 via-blue-500 to-indigo-600 shadow-lg shadow-cyan-500/25">
                        <img class="w-full h-full rounded-xl object-cover bg-slate-900"
                             src="{{ !empty($siswa->foto_profil) ? \Illuminate\Support\Facades\Storage::url($siswa->foto_profil) : 'https://ui-avatars.com/api/?name=' . urlencode($siswa->nama) . '&background=0f172a&color=38bdf8&size=200' }}"
                             alt="{{ $siswa->nama }}">
                    </div>
                    <!-- Status Pulse Pill -->
                    <div class="absolute -bottom-2 left-1/2 -translate-x-1/2 px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase tracking-wider flex items-center gap-1.5 shadow-md {{ $isAktif ? 'bg-emerald-500/90 text-white border border-emerald-300' : 'bg-rose-500/90 text-white border border-rose-300' }}">
                        <span class="w-1.5 h-1.5 rounded-full bg-white animate-ping"></span>
                        <span>{{ $isAktif ? 'Aktif' : 'Nonaktif' }}</span>
                    </div>
                </div>

                <!-- Info detail -->
                <div class="space-y-2">
                    <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2">
                        <span class="px-2.5 py-0.5 rounded-md text-[10px] font-mono tracking-widest font-bold bg-cyan-950/80 text-cyan-400 border border-cyan-800/80 shadow-xs">
                            ID: #USR-{{ str_pad($siswa->id_user, 5, '0', STR_PAD_LEFT) }}
                        </span>
                        <span class="px-2.5 py-0.5 rounded-md text-[10px] font-semibold bg-indigo-950/80 text-indigo-300 border border-indigo-800/80">
                            Jenjang: {{ $siswa->jenjang->nama_tipe ?? 'Umum' }}
                        </span>
                        @if($siswa->nisn)
                            <span class="px-2.5 py-0.5 rounded-md text-[10px] font-mono bg-slate-800/80 text-slate-300 border border-slate-700">
                                NISN: {{ $siswa->nisn }}
                            </span>
                        @endif
                    </div>

                    <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white flex items-center justify-center sm:justify-start gap-2">
                        <span>{{ $siswa->nama }}</span>
                        @if($siswa->username)
                            <span class="text-sm font-normal text-slate-400">({{ '@' . $siswa->username }})</span>
                        @endif
                    </h2>

                    <p class="text-xs sm:text-sm text-slate-300 flex flex-wrap items-center justify-center sm:justify-start gap-x-4 gap-y-1">
                        <span class="inline-flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            {{ $siswa->email }}
                        </span>
                        @if($siswa->nomor_hp)
                            <span class="inline-flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                {{ $siswa->nomor_hp }}
                            </span>
                        @endif
                        @if($siswa->asal_sekolah)
                            <span class="inline-flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                {{ $siswa->asal_sekolah }}
                            </span>
                        @endif
                    </p>
                </div>
            </div>

            <!-- Futuristic Tier Rank & EXP Card -->
            <div class="w-full lg:w-80 rounded-2xl bg-slate-900/80 border border-cyan-500/30 p-4 backdrop-blur-md shadow-inner space-y-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        @if($rank['current_badge_url'])
                            <img src="{{ $rank['current_badge_url'] }}" alt="{{ $rank['current_rank'] }}" class="w-6 h-6 object-contain">
                        @else
                            <span class="text-amber-400 text-lg">★</span>
                        @endif
                        <span class="text-xs font-bold uppercase tracking-wider text-cyan-300">Rank: {{ $rank['current_rank'] }}</span>
                    </div>
                    <span class="text-xs font-mono font-bold text-amber-400">{{ number_format($siswa->total_poin ?? 0) }} XP</span>
                </div>

                <!-- EXP Progress Bar -->
                <div>
                    <div class="flex justify-between text-[11px] text-slate-400 mb-1">
                        <span>Level Progress</span>
                        <span>{{ $rank['percent'] }}%</span>
                    </div>
                    <div class="w-full h-2.5 rounded-full bg-slate-800 overflow-hidden p-0.5 border border-slate-700">
                        <div class="h-full rounded-full bg-gradient-to-r from-cyan-400 via-blue-500 to-indigo-500 transition-all duration-500 shadow-sm shadow-cyan-500" style="width: {{ $rank['percent'] }}%;"></div>
                    </div>
                    <div class="flex justify-between text-[10px] text-slate-400 mt-1">
                        <span>{{ $rank['is_max'] ? 'Maksimal' : ($rank['points_needed'] . ' XP lagi ke ' . $rank['next_rank']) }}</span>
                        <span>Target: {{ $rank['next_points'] ?? 'MAX' }}</span>
                    </div>
                </div>

                <div class="pt-2 border-t border-slate-800/80 flex items-center justify-between text-xs text-slate-400">
                    <span>Peringkat Jenjang</span>
                    <span class="font-bold text-white bg-slate-800 px-2 py-0.5 rounded-md border border-slate-700">
                        #{{ $peringkat }} dari {{ $totalSiswaJenjang }} Siswa
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================================
        2. STATISTIK TELEMETRI (4 HUD STAT CARDS)
    ============================================================ --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- 1. Total Poin / XP -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs relative overflow-hidden group hover:border-cyan-400 transition-all duration-300">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Skor XP</span>
                <div class="w-9 h-9 rounded-xl bg-cyan-50 text-cyan-600 flex items-center justify-center font-bold text-base shadow-xs">
                    ⚡
                </div>
            </div>
            <div class="mt-3">
                <h3 class="text-2xl font-black text-slate-900 tracking-tight">{{ number_format($siswa->total_poin ?? 0) }}</h3>
                <p class="text-xs text-slate-500 mt-1 flex items-center gap-1">
                    <span class="text-cyan-600 font-bold">Top #{{ $peringkat }}</span> se-jenjang {{ $siswa->jenjang->nama_tipe ?? '' }}
                </p>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-cyan-400 to-blue-500 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-300"></div>
        </div>

        <!-- 2. Tingkat Kelulusan Kuis -->
        @php
            $passRate = $totalPercobaan > 0 ? round(($kuisLulus / $totalPercobaan) * 100, 1) : 0;
        @endphp
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs relative overflow-hidden group hover:border-emerald-400 transition-all duration-300">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Tingkat Kelulusan</span>
                <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-base shadow-xs">
                    ✓
                </div>
            </div>
            <div class="mt-3">
                <h3 class="text-2xl font-black text-slate-900 tracking-tight">{{ $passRate }}%</h3>
                <p class="text-xs text-slate-500 mt-1 flex items-center gap-1">
                    <span class="text-emerald-600 font-bold">{{ $kuisLulus }} Lulus</span> dari {{ $totalPercobaan }} Pengerjaan
                </p>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-emerald-400 to-teal-500 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-300"></div>
        </div>

        <!-- 3. Rata-Rata Nilai Kuis -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs relative overflow-hidden group hover:border-indigo-400 transition-all duration-300">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Rata-rata Nilai</span>
                <div class="w-9 h-9 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-base shadow-xs">
                    🎯
                </div>
            </div>
            <div class="mt-3">
                <h3 class="text-2xl font-black text-slate-900 tracking-tight">{{ $rataRataNilai }} <span class="text-sm font-semibold text-slate-400">/100</span></h3>
                <p class="text-xs text-slate-500 mt-1">
                    Skor Tertinggi: <span class="text-indigo-600 font-bold">{{ $nilaiTertinggi }}</span>
                </p>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-indigo-400 to-purple-500 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-300"></div>
        </div>

        <!-- 4. Modul Selesai -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs relative overflow-hidden group hover:border-amber-400 transition-all duration-300">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Progres Modul</span>
                <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold text-base shadow-xs">
                    📚
                </div>
            </div>
            <div class="mt-3">
                <h3 class="text-2xl font-black text-slate-900 tracking-tight">{{ $progresModulPersen }}%</h3>
                <p class="text-xs text-slate-500 mt-1">
                    <span class="text-amber-600 font-bold">{{ $modulSelesai }}</span> dari {{ $totalModulJenjang }} Modul Tersedia
                </p>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-amber-400 to-orange-500 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-300"></div>
        </div>
    </div>

    {{-- ============================================================
        3. GRAFIK FUTURISTIK (LINE CHART TREN SKOR & DOUGHNUT STATUS)
    ============================================================ --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        <!-- GRAFIK 1: TREN SKOR EVALUASI KUIS (Span 8) -->
        <div class="lg:col-span-8 bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-100 pb-4">
                <div>
                    <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-cyan-500"></span>
                        <span>Grafik Tren Nilai dan Evaluasi Kuis</span>
                    </h3>
                    <p class="text-xs text-slate-500">Pemantauan performa nilai hasil kuis dari setiap percobaan siswa.</p>
                </div>
                <div class="flex items-center gap-3 text-xs text-slate-500">
                    <span class="inline-flex items-center gap-1.5">
                        <span class="w-3 h-0.5 bg-cyan-500"></span> Nilai (%)
                    </span>
                    <span class="inline-flex items-center gap-1.5">
                        <span class="w-3 h-0.5 bg-rose-400 border-dashed border-t"></span> Standar Lulus (70%)
                    </span>
                </div>
            </div>

            <!-- Canvas Chart.js -->
            <div class="relative w-full h-72 sm:h-80">
                @if($chartDataTrend->isNotEmpty())
                    <canvas id="quizTrendChart"></canvas>
                @else
                    <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 space-y-2">
                        <div class="w-12 h-12 rounded-2xl bg-slate-50 border border-slate-200 flex items-center justify-center text-slate-400 text-xl font-bold">
                            📊
                        </div>
                        <p class="text-xs font-semibold text-slate-500">Belum ada riwayat pengerjaan kuis.</p>
                        <p class="text-[11px] text-slate-400">Data grafik akan terisi otomatis setelah siswa menyelesaikan kuis.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- GRAFIK 2: DISTRIBUSI KELULUSAN & AKTIVITAS (Span 4) -->
        <div class="lg:col-span-4 bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm space-y-5">
            <div class="border-b border-slate-100 pb-4">
                <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-indigo-500"></span>
                    <span>Rasio Hasil Kuis</span>
                </h3>
                <p class="text-xs text-slate-500">Komposisi pengerjaan kuis lulus dan belum lulus.</p>
            </div>

            <!-- Doughnut Chart Canvas -->
            <div class="relative w-full h-52 flex items-center justify-center">
                @if($totalPercobaan > 0)
                    <canvas id="performanceDonutChart"></canvas>
                @else
                    <div class="text-center text-slate-400 text-xs">
                        <p>Belum ada data evaluasi</p>
                    </div>
                @endif
            </div>

            <!-- Detail Breakdown -->
            <div class="grid grid-cols-2 gap-3 pt-2 border-t border-slate-100 text-xs">
                <div class="p-3 rounded-xl bg-emerald-50/60 border border-emerald-100 text-emerald-800">
                    <p class="text-[11px] text-emerald-600 font-semibold">Kuis Lulus</p>
                    <p class="text-lg font-black text-emerald-900 mt-0.5">{{ $kuisLulus }}</p>
                </div>
                <div class="p-3 rounded-xl bg-rose-50/60 border border-rose-100 text-rose-800">
                    <p class="text-[11px] text-rose-600 font-semibold">Perlu Remedial</p>
                    <p class="text-lg font-black text-rose-900 mt-0.5">{{ $kuisGagal }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================================
        4. TABEL MISI / RIWAYAT KUIS & VAULT PENGHARGAAN
    ============================================================ --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        <!-- RIWAYAT PENGERJAAN KUIS (Span 7) -->
        <div class="lg:col-span-7 bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div>
                    <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>
                        <span>Log Riwayat Pengerjaan Kuis</span>
                    </h3>
                    <p class="text-xs text-slate-500">Seluruh sesi pengerjaan kuis yang telah diselesaikan oleh siswa.</p>
                </div>
                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-600">
                    Total: {{ $totalPercobaan }}
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="border-b border-slate-100 text-slate-400 uppercase font-semibold">
                            <th class="py-2.5 px-3">Kuis</th>
                            <th class="py-2.5 px-3">Waktu</th>
                            <th class="py-2.5 px-3 text-center">Nilai</th>
                            <th class="py-2.5 px-3 text-center">Poin</th>
                            <th class="py-2.5 px-3 text-center">Status</th>
                            <th class="py-2.5 px-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($quizResults as $hasil)
                            @php
                                $nilai = (float) $hasil->total_poin > 0 ? round(($hasil->poin_didapat / $hasil->total_poin) * 100, 1) : 0;
                                $isLulus = (bool) $hasil->is_lulus;
                            @endphp
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="py-3 px-3 font-semibold text-slate-800">
                                    {{ $hasil->quiz?->judul ?? ('Kuis #' . $hasil->id_quiz) }}
                                </td>
                                <td class="py-3 px-3 text-slate-500">
                                    {{ $hasil->waktu_dapat ? \Illuminate\Support\Carbon::parse($hasil->waktu_dapat)->translatedFormat('d M Y, H:i') : '-' }}
                                </td>
                                <td class="py-3 px-3 text-center font-bold {{ $nilai >= 70 ? 'text-emerald-600' : 'text-rose-600' }}">
                                    {{ $nilai }}%
                                </td>
                                <td class="py-3 px-3 text-center font-semibold text-slate-700">
                                    {{ $hasil->poin_didapat }} / {{ $hasil->total_poin }}
                                </td>
                                <td class="py-3 px-3 text-center">
                                    @if($isLulus)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                            ✓ LULUS
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 border border-amber-200">
                                            REMEDIAL
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-3 text-center">
                                    @if($hasil->id_quiz)
                                        <a href="{{ route('admin.quiz.preview', $hasil->id_quiz) }}" target="_blank"
                                           class="text-blue-600 hover:text-blue-800 font-semibold hover:underline"
                                           title="Pratinjau Kuis">
                                            Lihat Kuis
                                        </a>
                                    @else
                                        <span class="text-slate-400">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-slate-400">
                                    Siswa belum pernah mengerjakan kuis.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- VAULT PENGHARGAAN & DATA AKUN (Span 5) -->
        <div class="lg:col-span-5 space-y-6">

            <!-- PENGHARGAAN / ACHIEVEMENT VAULT -->
            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                        <span class="text-amber-500">🏆</span>
                        <span>Penghargaan &amp; Badges</span>
                    </h3>
                    <span class="text-xs font-semibold text-slate-500">
                        {{ $achievementsUnlocked->count() }} / {{ $allAchievements->count() }} Terbuka
                    </span>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    @forelse($allAchievements as $ach)
                        @php
                            $unlocked = $achievementsUnlocked->firstWhere('id_achievement', $ach->id_achievement);
                        @endphp
                        <div class="p-3 rounded-2xl border transition-all duration-300 {{ $unlocked ? 'bg-gradient-to-br from-amber-50/70 to-yellow-50/40 border-amber-200 text-amber-900 shadow-xs' : 'bg-slate-50/60 border-slate-200/60 text-slate-400 opacity-60' }}">
                            <div class="flex items-center gap-2.5">
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 {{ $unlocked ? 'bg-amber-100 text-amber-600 shadow-xs' : 'bg-slate-200 text-slate-400' }}">
                                    @if($ach->gambar_url)
                                        <img src="{{ $ach->gambar_url }}" alt="{{ $ach->nama_achivement }}" class="w-7 h-7 object-contain {{ $unlocked ? '' : 'grayscale' }}">
                                    @else
                                        <span class="text-base">★</span>
                                    @endif
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="font-bold text-xs truncate {{ $unlocked ? 'text-slate-900' : 'text-slate-500' }}">
                                        {{ $ach->nama_achivement }}
                                    </p>
                                    <p class="text-[10px] text-slate-500 mt-0.5">
                                        {{ $ach->minimal_poin_achivement }} XP
                                    </p>
                                    @if($unlocked)
                                        <span class="inline-block mt-1 text-[9px] font-bold text-emerald-700 bg-emerald-100/70 px-1.5 py-0.2 rounded">
                                            ✓ Terbuka
                                        </span>
                                    @else
                                        <span class="inline-block mt-1 text-[9px] font-medium text-slate-400">
                                            Terkunci
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="col-span-2 text-xs text-slate-400 text-center py-4">Belum ada daftar penghargaan di sistem.</p>
                    @endforelse
                </div>
            </div>

            <!-- DETAIL AKUN & ORANG TUA -->
            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                        <span class="text-blue-500">📋</span>
                        <span>Informasi Tambahan</span>
                    </h3>
                </div>

                <div class="space-y-3 text-xs">
                    <div class="flex justify-between py-1.5 border-b border-slate-100">
                        <span class="text-slate-400">Tanggal Mendaftar</span>
                        <span class="font-semibold text-slate-700">{{ $siswa->created_at ? $siswa->created_at->translatedFormat('d F Y, H:i') : '-' }}</span>
                    </div>
                    <div class="flex justify-between py-1.5 border-b border-slate-100">
                        <span class="text-slate-400">Kelas</span>
                        <span class="font-semibold text-slate-700">{{ $siswa->kelas ?: '-' }}</span>
                    </div>
                    <div class="flex justify-between py-1.5 border-b border-slate-100">
                        <span class="text-slate-400">Akun Orang Tua Terkait</span>
                        <span class="font-semibold text-slate-700">
                            @if($orangtuaList->isNotEmpty())
                                @foreach($orangtuaList as $ot)
                                    <span class="inline-block bg-slate-100 px-2 py-0.5 rounded text-[11px] text-slate-800">
                                        {{ $ot->orangtua->nama ?? ('ID #' . $ot->id_orangtua) }}
                                    </span>
                                @endforeach
                            @else
                                <span class="text-slate-400 font-normal">Belum terhubung</span>
                            @endif
                        </span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- MODAL UBAH STATUS DAN JENJANG SISWA --}}
<div id="statusModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl space-y-5 border border-slate-100 animate-in fade-in zoom-in duration-150">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                <span>⚙️</span>
                <span>Kelola Akun Siswa</span>
            </h3>
            <button onclick="closeStatusModal()" class="text-slate-400 hover:text-slate-600 text-lg">✕</button>
        </div>

        <!-- Form Ubah Jenjang -->
        <form action="{{ route('admin.siswa.jenjang', $siswa->id_user) }}" method="POST" class="space-y-3">
            @csrf
            @method('PATCH')
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Jenjang Pendidikan</label>
                <div class="flex gap-2">
                    <select name="id_jenjang" class="flex-1 px-3 py-2 rounded-xl border border-slate-300 text-xs bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="">-- Belum Ditentukan --</option>
                        @foreach ($jenjangs as $j)
                            <option value="{{ $j->id_jenjang }}" {{ $siswa->id_jenjang == $j->id_jenjang ? 'selected' : '' }}>{{ $j->nama_tipe }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="px-3.5 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs transition">
                        Simpan
                    </button>
                </div>
            </div>
        </form>

        <!-- Form Ubah Status Akun -->
        <form action="{{ route('admin.siswa.status', $siswa->id_user) }}" method="POST" class="space-y-3 pt-3 border-t border-slate-100">
            @csrf
            @method('PATCH')
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Status Akses Akun</label>
                <div class="flex gap-2">
                    <select name="status_akun" class="flex-1 px-3 py-2 rounded-xl border border-slate-300 text-xs bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="Aktif" {{ ($siswa->status_akun ?? 'Aktif') === 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Nonaktif" {{ $siswa->status_akun === 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                    <button type="submit" class="px-3.5 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs transition">
                        Ubah Status
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function openStatusModal() {
        document.getElementById('statusModal').classList.remove('hidden');
    }
    function closeStatusModal() {
        document.getElementById('statusModal').classList.add('hidden');
    }

    // Inisialisasi Chart.js
    document.addEventListener('DOMContentLoaded', function () {
        // --- 1. LINE CHART: TREN SKOR EVALUASI KUIS ---
        const trendCanvas = document.getElementById('quizTrendChart');
        if (trendCanvas) {
            const chartData = @json($chartDataTrend);
            const labels = chartData.map(d => d.judul.length > 20 ? d.judul.substring(0, 18) + '...' : d.judul);
            const scores = chartData.map(d => d.nilai);

            const ctx = trendCanvas.getContext('2d');
            const gradient = ctx.createLinearGradient(0, 0, 0, 280);
            gradient.addColorStop(0, 'rgba(6, 182, 212, 0.35)');
            gradient.addColorStop(1, 'rgba(99, 102, 241, 0.00)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Nilai Siswa (%)',
                            data: scores,
                            borderColor: '#06b6d4',
                            borderWidth: 3,
                            backgroundColor: gradient,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: '#0891b2',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2,
                            pointRadius: 5,
                            pointHoverRadius: 7,
                        },
                        {
                            label: 'Standar Kelulusan (70%)',
                            data: Array(labels.length).fill(70),
                            borderColor: '#f43f5e',
                            borderWidth: 1.5,
                            borderDash: [5, 5],
                            fill: false,
                            pointRadius: 0,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            titleFont: { size: 12, weight: 'bold' },
                            bodyFont: { size: 12 },
                            padding: 10,
                            cornerRadius: 10,
                            callbacks: {
                                label: function(context) {
                                    if (context.datasetIndex === 1) return 'Ambang Kelulusan: 70%';
                                    const item = chartData[context.dataIndex];
                                    return `Nilai: ${item.nilai}% (${item.poin}/${item.total_poin} poin) - ${item.is_lulus ? 'LULUS' : 'REMEDIAL'}`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: {
                                color: '#94a3b8',
                                font: { size: 11 }
                            }
                        },
                        y: {
                            min: 0,
                            max: 100,
                            grid: { color: '#f1f5f9' },
                            ticks: {
                                stepSize: 20,
                                color: '#94a3b8',
                                font: { size: 11 },
                                callback: val => val + '%'
                            }
                        }
                    }
                }
            });
        }

        // --- 2. DOUGHNUT CHART: RASIO KELULUSAN ---
        const donutCanvas = document.getElementById('performanceDonutChart');
        if (donutCanvas) {
            const lulus = {{ $kuisLulus }};
            const gagal = {{ $kuisGagal }};

            new Chart(donutCanvas.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: ['Lulus', 'Perlu Remedial'],
                    datasets: [{
                        data: [lulus, gagal],
                        backgroundColor: ['#10b981', '#f43f5e'],
                        borderWidth: 2,
                        borderColor: '#ffffff',
                        hoverOffset: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                font: { size: 11 },
                                boxWidth: 12,
                                padding: 14
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endsection
