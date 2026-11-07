@extends('layouts.app')

@section('header')
<h1 class="text-lg font-bold text-slate-800">Presensi</h1>
@endsection

@section('content')
@php
    /**
     * @var int $totalKelas
     * @var \Illuminate\Support\Collection<int, \App\Models\SesiPresensi> $sesiHariIni
     * @var \Illuminate\Support\Collection<string, \Illuminate\Support\Collection<int, \App\Models\SesiPresensi>> $riwayatPerTanggal
     * @var string $rentang
     * @var int|null $hari
     * @var array<int, string> $namaHari
     */
    $hariIniStr = now()->toDateString();
    $sessionSummaryPerDate = [];
    foreach ($riwayatPerTanggal as $tgl => $sesiList) {
        $sessionSummaryPerDate[$tgl] = [
            'count' => $sesiList->count(),
            'presensi_count' => $sesiList->sum('presensi_count'),
            'kelas' => $sesiList->map(fn($s) => $s->kelas?->nama ?? '-')->values()->all(),
        ];
    }
    $sessionSummaryPerDate[$hariIniStr] = [
        'count' => $sesiHariIni->count(),
        'presensi_count' => $sesiHariIni->sum('presensi_count'),
        'kelas' => $sesiHariIni->map(fn($s) => $s->kelas?->nama ?? '-')->values()->all(),
    ];
@endphp
<div class="p-4 sm:p-8 max-w-7xl pb-24">
    @include('guru.presensi._flash')

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        {{-- ============ KOLOM KIRI: DAFTAR KELAS & RIWAYAT PRESENSI ============ --}}
        <div class="lg:col-span-7 xl:col-span-8 min-w-0">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-slate-800">Presensi</h2>
                <p class="text-sm text-slate-500 mt-1">Sesi presensi dibuat <b>otomatis</b> pada hari aktif kelas dan hanya bisa dipindai <b>hari itu saja</b>, sesuai jadwal dan masa berlaku kelas. Setelah lewat hari, datanya tetap tersimpan di Riwayat.</p>
            </div>

            @if($totalKelas === 0)
                <div class="rounded-2xl border border-amber-200 bg-amber-50 p-5 text-amber-900">
                    Anda belum ditugaskan ke kelas mana pun. Hubungi admin untuk penugasan kelas.
                </div>
            @else
                {{-- ============ KELAS HARI INI ============ --}}
                <div class="mb-10">
                    <h3 class="font-bold text-slate-800 mb-1">Kelas hari ini</h3>
                    <p class="text-sm text-slate-500 mb-3">{{ now()->locale('id')->translatedFormat('l, d F Y') }}</p>
                    <div class="space-y-3">
                        @forelse($sesiHariIni as $sesi)
                            @php /** @var \App\Models\SesiPresensi $sesi */ @endphp
                            <div class="bg-white rounded-2xl border border-gray-100 p-4 flex flex-wrap items-center justify-between gap-3 shadow-sm hover:shadow-md transition">
                                <div class="min-w-0">
                                    <p class="font-semibold text-slate-800 truncate">{{ $sesi->kelas?->nama ?? '-' }}</p>
                                    <p class="text-sm text-slate-500">{{ $sesi->kelas?->ringkasJadwal() ?? '-' }} · {{ $sesi->presensi_count }} tercatat</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    @if(!$sesi->isBuka())
                                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-200 text-slate-700">Ditutup</span>
                                    @elseif(!$sesi->bisaDipindai())
                                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">Kelas tidak aktif</span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">Dibuka</span>
                                    @endif
                                    @if($sesi->bisaDipindai())
                                        <a href="{{ route('guru.presensi.scan', $sesi->id_sesi) }}" class="h-11 px-4 inline-flex items-center rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold shadow-sm transition">Scan</a>
                                    @endif
                                    <a href="{{ route('guru.presensi.rekap', $sesi->id_sesi) }}" class="h-11 px-4 inline-flex items-center rounded-xl border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 font-medium shadow-sm transition">Rekap</a>
                                </div>
                            </div>
                        @empty
                            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5 text-slate-600 text-sm">
                                Tidak ada kelas yang aktif hari ini (di luar jadwal atau masa berlaku).
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- ============ RIWAYAT ============ --}}
                <div class="flex flex-wrap items-end justify-between gap-2 mb-3">
                    <div>
                        <h3 class="font-bold text-slate-800">Riwayat</h3>
                        <p class="text-sm text-slate-500">
                            {{ $rentang === 'bulan' ? '30 hari terakhir' : 'Minggu ini (Senin sampai kemarin)' }}
                        </p>
                    </div>
                    @if($rentang === 'minggu')
                        <a href="{{ route('guru.presensi.index', ['rentang' => 'bulan', 'hari' => $hari]) }}"
                           class="h-11 px-4 inline-flex items-center rounded-xl border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 font-medium shadow-sm transition">Tampilkan riwayat 1 bulan</a>
                    @else
                        <a href="{{ route('guru.presensi.index', ['hari' => $hari]) }}"
                           class="h-11 px-4 inline-flex items-center rounded-xl border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 font-medium shadow-sm transition">Kembali ke minggu ini</a>
                    @endif
                </div>

                <nav aria-label="Filter hari" class="flex flex-wrap gap-2 mb-4">
                    <a href="{{ route('guru.presensi.index', ['rentang' => $rentang === 'bulan' ? 'bulan' : null]) }}"
                       @if($hari === null) aria-current="page" @endif
                       class="h-10 px-4 inline-flex items-center rounded-full text-sm font-semibold border shadow-sm transition {{ $hari === null ? 'bg-slate-800 text-white border-slate-800' : 'bg-white text-slate-700 border-slate-300 hover:bg-slate-50' }}">Semua</a>
                    @foreach($namaHari as $angka => $nama)
                        <a href="{{ route('guru.presensi.index', ['rentang' => $rentang === 'bulan' ? 'bulan' : null, 'hari' => $angka]) }}"
                           @if($hari === $angka) aria-current="page" @endif
                           class="h-10 px-4 inline-flex items-center rounded-full text-sm font-semibold border shadow-sm transition {{ $hari === $angka ? 'bg-slate-800 text-white border-slate-800' : 'bg-white text-slate-700 border-slate-300 hover:bg-slate-50' }}">{{ $nama }}</a>
                    @endforeach
                </nav>

                <div class="space-y-5">
                    @forelse($riwayatPerTanggal as $tanggal => $sesiPerHari)
                        <section aria-label="{{ $tanggal }}">
                            <h4 class="text-sm font-bold text-slate-600 mb-2">{{ \Illuminate\Support\Carbon::parse($tanggal)->locale('id')->translatedFormat('l, d F Y') }}</h4>
                            <div class="space-y-2">
                                @foreach($sesiPerHari as $sesi)
                                    @php /** @var \App\Models\SesiPresensi $sesi */ @endphp
                                    <div class="bg-white rounded-2xl border border-gray-100 p-4 flex flex-wrap items-center justify-between gap-3 shadow-sm hover:shadow-md transition">
                                        <div class="min-w-0">
                                            <p class="font-semibold text-slate-800 truncate">{{ $sesi->kelas?->nama ?? '-' }}</p>
                                            <p class="text-sm text-slate-500">{{ $sesi->judul }} · {{ $sesi->presensi_count }} tercatat</p>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-200 text-slate-700">{{ $sesi->statusTampil() === 'ditutup' ? 'Ditutup' : 'Kedaluwarsa' }}</span>
                                            <a href="{{ route('guru.presensi.rekap', $sesi->id_sesi) }}" class="h-11 px-4 inline-flex items-center rounded-xl border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 font-medium shadow-sm transition">Rekap</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </section>
                    @empty
                        <div class="rounded-2xl border border-slate-200 bg-white p-5 text-slate-500 text-sm shadow-sm text-center">
                            Tidak ada riwayat{{ $hari ? ' pada hari ' . $namaHari[$hari] : '' }} {{ $rentang === 'bulan' ? 'dalam 30 hari terakhir' : 'minggu ini' }}.
                        </div>
                    @endforelse
                </div>
            @endif
        </div>

        {{-- ============ KOLOM KANAN: WIDGET KALENDER TEMA ARRAVA ============ --}}
        <div class="lg:col-span-5 xl:col-span-4 space-y-6 lg:sticky lg:top-24">
            
            <!-- CARD KALENDER ARRAVA -->
            <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden flex flex-col">
                <!-- Header Kalender dengan Gradien Arrava & Live Clock -->
                <div class="bg-gradient-to-br from-[#0875F9] via-[#0C55C8] to-[#082765] text-white p-5 relative overflow-hidden">
                    <!-- Dekorasi Lingkaran Halus -->
                    <div class="absolute -right-6 -bottom-6 w-28 h-28 bg-white/10 rounded-full blur-xl pointer-events-none"></div>
                    <div class="absolute right-3 top-3 opacity-15 pointer-events-none">
                        <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V9h14v11z"/>
                        </svg>
                    </div>

                    <div class="relative z-10">
                        <!-- Top Row: Badge & Jam Digital -->
                        <div class="flex items-center justify-between gap-2 mb-3">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-white/15 text-white backdrop-blur-md border border-white/20 shadow-2xs">
                                <span class="w-2 h-2 rounded-full bg-[#FFBE35] animate-pulse"></span>
                                <span>Kalender Presensi</span>
                            </span>
                            <span id="calendarClock" class="font-mono text-xs font-semibold text-white/90 bg-white/10 px-2.5 py-1 rounded-lg border border-white/10 backdrop-blur-xs">
                                --:-- WIB
                            </span>
                        </div>

                        <!-- Bulan, Tahun & Navigasi -->
                        <div class="flex items-center justify-between mt-2">
                            <div>
                                <h4 id="calendarMonthYear" class="text-xl font-extrabold tracking-tight text-white leading-tight">
                                    {{ now()->locale('id')->translatedFormat('F Y') }}
                                </h4>
                                <p id="calendarTodayLabel" class="text-xs text-blue-100/90 font-medium mt-0.5">
                                    {{ now()->locale('id')->translatedFormat('l, d F Y') }}
                                </p>
                            </div>

                            <div class="flex items-center gap-1 bg-white/15 p-1 rounded-xl backdrop-blur-md border border-white/20">
                                <button id="calPrevBtn" type="button" title="Bulan Sebelumnya"
                                        class="w-7 h-7 flex items-center justify-center rounded-lg text-white hover:bg-white/25 active:scale-95 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                                    </svg>
                                </button>
                                <button id="calTodayBtn" type="button" title="Kembali ke Hari Ini"
                                        class="px-2 h-7 text-[11px] font-bold text-white hover:bg-white/25 rounded-lg transition active:scale-95">
                                    Hari Ini
                                </button>
                                <button id="calNextBtn" type="button" title="Bulan Berikutnya"
                                        class="w-7 h-7 flex items-center justify-center rounded-lg text-white hover:bg-white/25 active:scale-95 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Body Kalender (Grid Tanggal) -->
                <div class="p-5">
                    <!-- Label Nama Hari -->
                    <div class="grid grid-cols-7 gap-1 text-center mb-2">
                        <span class="text-[11px] font-bold text-rose-500 py-1">Min</span>
                        <span class="text-[11px] font-bold text-slate-400 py-1">Sen</span>
                        <span class="text-[11px] font-bold text-slate-400 py-1">Sel</span>
                        <span class="text-[11px] font-bold text-slate-400 py-1">Rab</span>
                        <span class="text-[11px] font-bold text-slate-400 py-1">Kam</span>
                        <span class="text-[11px] font-bold text-slate-400 py-1">Jum</span>
                        <span class="text-[11px] font-bold text-slate-400 py-1">Sab</span>
                    </div>

                    <!-- Grid Tanggal Dinamis -->
                    <div id="calendarDaysGrid" class="grid grid-cols-7 gap-1 text-center">
                        <!-- Di-generate otomatis melalui JavaScript -->
                    </div>

                    <!-- Legenda Kalender -->
                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-400">
                        <div class="flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-blue-600 ring-2 ring-blue-100"></span>
                            <span>Hari Ini</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-[#FFBE35]"></span>
                            <span>Ada Sesi Presensi</span>
                        </div>
                    </div>
                </div>

                <!-- Panel Detail Tanggal yang Diklik -->
                <div id="calendarSelectedDetail" class="px-5 pb-5 pt-0">
                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 transition">
                        <div class="flex items-center justify-between mb-1.5">
                            <span id="detailDateTitle" class="text-xs font-bold text-slate-700">
                                {{ now()->locale('id')->translatedFormat('l, d F Y') }}
                            </span>
                            <span id="detailBadge" class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-blue-100 text-blue-700">
                                Hari Ini
                            </span>
                        </div>
                        <p id="detailDescription" class="text-xs text-slate-500 leading-relaxed">
                            @if($sesiHariIni->isNotEmpty())
                                Terdapat <b>{{ $sesiHariIni->count() }} kelas</b> aktif hari ini: {{ $sesiHariIni->map(fn($s) => $s->kelas?->nama ?? '-')->join(', ') }}.
                            @else
                                Tidak ada kelas aktif hari ini.
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- CARD AKTIVITAS & RINGKASAN HARI INI BERTEMA ARRAVA -->
            <div class="bg-gradient-to-br from-indigo-50/80 via-blue-50/50 to-white rounded-3xl border border-indigo-100/90 p-5 shadow-xs relative overflow-hidden">
                <div class="flex items-start justify-between gap-3 relative z-10">
                    <div>
                        <span class="inline-flex items-center gap-1 text-[11px] font-bold text-indigo-700 uppercase tracking-wider">
                            <svg class="w-3.5 h-3.5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            <span>Status Presensi</span>
                        </span>
                        <h5 class="text-base font-bold text-slate-800 mt-1">Aktivitas Hari Ini</h5>
                        <p class="text-xs text-slate-500 mt-0.5">Ringkasan cepat sesi presensi yang Anda ampu.</p>
                    </div>

                    <div class="w-11 h-11 rounded-2xl bg-white border border-indigo-100 shadow-xs flex items-center justify-center shrink-0">
                        <img src="{{ asset('assets/sidebar/sidebarQuizIcon.webp') }}" alt="Arrava Icon" class="w-7 h-7 object-contain">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-2 mt-4 pt-4 border-t border-indigo-100/60 relative z-10">
                    <div class="bg-white/90 backdrop-blur-xs rounded-2xl p-3 border border-indigo-50 shadow-2xs">
                        <span class="text-[11px] font-medium text-slate-400 block">Kelas Hari Ini</span>
                        <span class="text-lg font-extrabold text-blue-600 mt-0.5 block">{{ $sesiHariIni->count() }} Kelas</span>
                    </div>
                    <div class="bg-white/90 backdrop-blur-xs rounded-2xl p-3 border border-indigo-50 shadow-2xs">
                        <span class="text-[11px] font-medium text-slate-400 block">Siswa Hadir</span>
                        <span class="text-lg font-extrabold text-emerald-600 mt-0.5 block">{{ $sesiHariIni->sum('presensi_count') }} Siswa</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- SCRIPT KALENDER INTERAKTIF ARRAVA --}}
<script>
    (function() {
        // Data Sesi Presensi per Tanggal dari Controller
        const sessionData = @json($sessionSummaryPerDate);

        // State Tanggal
        const serverToday = new Date('{{ now()->format("Y-m-d\\TH:i:s") }}');
        let currentYear = serverToday.getFullYear();
        let currentMonth = serverToday.getMonth(); // 0 - 11
        let selectedDateStr = '{{ $hariIniStr }}';

        const monthNames = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];
        const dayNames = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        // Format dua digit helper
        function padZero(num) {
            return num < 10 ? '0' + num : num;
        }

        // Update Jam Digital
        function updateClock() {
            const now = new Date();
            const clockEl = document.getElementById('calendarClock');
            if (clockEl) {
                const h = padZero(now.getHours());
                const m = padZero(now.getMinutes());
                const s = padZero(now.getSeconds());
                clockEl.textContent = `${h}:${m}:${s} WIB`;
            }
        }
        setInterval(updateClock, 1000);
        updateClock();

        // Render Kalender Grid
        function renderCalendar() {
            const monthYearEl = document.getElementById('calendarMonthYear');
            const gridEl = document.getElementById('calendarDaysGrid');
            if (!monthYearEl || !gridEl) return;

            monthYearEl.textContent = `${monthNames[currentMonth]} ${currentYear}`;

            gridEl.innerHTML = '';

            const firstDayIndex = new Date(currentYear, currentMonth, 1).getDay(); // 0: Minggu
            const lastDate = new Date(currentYear, currentMonth + 1, 0).getDate();
            const prevMonthLastDate = new Date(currentYear, currentMonth, 0).getDate();

            // Tanggal dari bulan sebelumnya (dimmed)
            for (let i = firstDayIndex; i > 0; i--) {
                const dayNum = prevMonthLastDate - i + 1;
                const cell = document.createElement('div');
                cell.className = 'h-9 w-9 mx-auto flex items-center justify-center text-xs text-slate-300 font-medium select-none';
                cell.textContent = dayNum;
                gridEl.appendChild(cell);
            }

            // Tanggal bulan saat ini
            for (let day = 1; day <= lastDate; day++) {
                const dateKey = `${currentYear}-${padZero(currentMonth + 1)}-${padZero(day)}`;
                const isToday = (
                    day === serverToday.getDate() &&
                    currentMonth === serverToday.getMonth() &&
                    currentYear === serverToday.getFullYear()
                );
                const isSelected = (dateKey === selectedDateStr);
                const hasSession = !!sessionData[dateKey];

                const btn = document.createElement('button');
                btn.type = 'button';
                btn.setAttribute('data-date', dateKey);

                let baseClass = 'h-9 w-9 mx-auto rounded-xl flex flex-col items-center justify-center text-xs transition relative group focus:outline-none ';

                if (isSelected) {
                    baseClass += 'bg-gradient-to-tr from-[#0875F9] to-indigo-600 text-white font-extrabold shadow-md shadow-blue-500/30 ring-2 ring-blue-300 scale-105 z-10';
                } else if (isToday) {
                    baseClass += 'bg-blue-50 text-blue-700 font-bold border border-blue-200 hover:bg-blue-100 hover:scale-105';
                } else {
                    baseClass += 'text-slate-700 font-semibold hover:bg-indigo-50 hover:text-indigo-600';
                }

                btn.className = baseClass;
                btn.innerHTML = `<span>${day}</span>`;

                // Titik indikator jika ada sesi presensi pada tanggal tersebut
                if (hasSession) {
                    const dot = document.createElement('span');
                    if (isSelected) {
                        dot.className = 'w-1.5 h-1.5 rounded-full bg-[#FFBE35] ring-1 ring-white mt-0.5';
                    } else {
                        dot.className = 'w-1.5 h-1.5 rounded-full bg-[#FFBE35] mt-0.5';
                    }
                    btn.appendChild(dot);
                }

                btn.addEventListener('click', function() {
                    selectedDateStr = dateKey;
                    renderCalendar();
                    updateDetailPanel(dateKey, isToday);
                });

                gridEl.appendChild(btn);
            }
        }

        // Update Detail Panel Saat Tanggal Dipilih
        function updateDetailPanel(dateKey, isToday) {
            const titleEl = document.getElementById('detailDateTitle');
            const badgeEl = document.getElementById('detailBadge');
            const descEl = document.getElementById('detailDescription');
            if (!titleEl || !badgeEl || !descEl) return;

            const parts = dateKey.split('-');
            const d = new Date(parseInt(parts[0]), parseInt(parts[1]) - 1, parseInt(parts[2]));
            const dayName = dayNames[d.getDay()];
            const monthName = monthNames[d.getMonth()];

            titleEl.textContent = `${dayName}, ${padZero(d.getDate())} ${monthName} ${d.getFullYear()}`;

            if (isToday) {
                badgeEl.textContent = 'Hari Ini';
                badgeEl.className = 'text-[10px] font-bold px-2 py-0.5 rounded-full bg-blue-100 text-blue-700';
            } else if (d > serverToday) {
                badgeEl.textContent = 'Mendatang';
                badgeEl.className = 'text-[10px] font-bold px-2 py-0.5 rounded-full bg-slate-100 text-slate-600';
            } else {
                badgeEl.textContent = 'Riwayat';
                badgeEl.className = 'text-[10px] font-bold px-2 py-0.5 rounded-full bg-amber-100 text-amber-800';
            }

            const data = sessionData[dateKey];
            if (data && data.count > 0) {
                const kelasList = data.kelas.join(', ');
                descEl.innerHTML = `Terdapat <b>${data.count} sesi kelas</b> (${kelasList}) · <b>${data.presensi_count} siswa</b> tercatat hadir.`;
            } else {
                descEl.innerHTML = `Tidak ada catatan sesi presensi pada tanggal ini.`;
            }
        }

        // Navigasi Bulan
        document.getElementById('calPrevBtn')?.addEventListener('click', function() {
            currentMonth--;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            renderCalendar();
        });

        document.getElementById('calNextBtn')?.addEventListener('click', function() {
            currentMonth++;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            renderCalendar();
        });

        document.getElementById('calTodayBtn')?.addEventListener('click', function() {
            currentYear = serverToday.getFullYear();
            currentMonth = serverToday.getMonth();
            selectedDateStr = '{{ $hariIniStr }}';
            renderCalendar();
            updateDetailPanel(selectedDateStr, true);
        });

        // Inisialisasi awal
        renderCalendar();
    })();
</script>
@endsection
