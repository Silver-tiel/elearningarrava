@extends('layouts.orangtua')

@section('title', 'Perkembangan Nilai - Portal Orang Tua')
@section('breadcrumb', 'Perkembangan Nilai')

@section('content')
<div class="px-4 sm:px-6 py-6 max-w-[1400px] mx-auto">

    {{-- =====================================================================
    |  HEADER + SELECTOR SISWA
    ====================================================================== --}}
    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-[22px] font-bold text-slate-900 leading-tight">Perkembangan Nilai</h1>
            <p class="text-sm text-slate-500 mt-0.5 max-w-xl">
                Pantau tren capaian evaluasi belajar, riwayat nilai kuis harian, formatif, dan
                analisis ketuntasan KKM ananda secara berkala.
            </p>
        </div>

        @if($siswa)
        {{-- Selector Siswa --}}
        <form method="GET" action="{{ route('orangtua.perkembangan-nilai') }}" id="siswaForm">
            <input type="hidden" name="rentang" value="{{ $rentangAktif }}">
            <input type="hidden" name="mapel"   value="{{ $mapelAktif }}">
            <input type="hidden" name="status"  value="{{ $statusAktif }}">
            <div class="flex items-center gap-2 bg-white border border-slate-200 rounded-xl px-3 py-2 shadow-sm min-w-[260px]">
                <div class="w-8 h-8 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold text-sm shrink-0">
                    {{ strtoupper(substr($siswa->nama, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider leading-none mb-0.5">Siswa Terpilih</p>
                    <select name="siswa_id" onchange="document.getElementById('siswaForm').submit()"
                            class="w-full text-sm font-semibold text-slate-800 border-0 bg-transparent p-0 focus:ring-0 cursor-pointer">
                        @foreach($siswaList as $s)
                            <option value="{{ $s->id_user }}" {{ $s->id_user == $siswa->id_user ? 'selected' : '' }}>
                                {{ $s->nama }} (Kelas {{ $s->kelas ?? '-' }})
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
    <div class="bg-white rounded-2xl border border-dashed border-slate-200 p-12 text-center">
        <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
        </svg>
        <h3 class="text-base font-semibold text-slate-700 mb-1">Belum ada siswa yang dihubungkan</h3>
        <p class="text-sm text-slate-400">Hubungi administrator untuk menautkan akun orang tua dengan akun siswa.</p>
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
                <div class="w-7 h-7 rounded-lg bg-indigo-50 flex items-center justify-center">
                    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
            </div>
            <div class="flex items-baseline gap-1">
                <p class="text-[32px] font-extrabold text-slate-900 leading-none">{{ number_format($stats['avg_nilai'], 1) }}</p>
                <span class="text-sm text-slate-400 font-medium">/ 100</span>
            </div>
            <div class="mt-2 flex flex-wrap items-center gap-2">
                @if($stats['di_atas_kkm'])
                <span class="text-[11px] font-semibold text-emerald-600">
                    +{{ $stats['selisih_kkm'] }} di atas KKM
                </span>
                @else
                <span class="text-[11px] font-semibold text-red-500">
                    {{ $stats['selisih_kkm'] }} di bawah KKM
                </span>
                @endif
                <span class="text-[11px] text-slate-400">Semester Ganjil</span>
            </div>
        </div>

        {{-- Nilai Tertinggi --}}
        <div class="stat-card bg-white rounded-xl border border-slate-100 p-4 relative overflow-hidden">
            <div class="flex items-start justify-between mb-2">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Nilai Tertinggi</p>
                <div class="w-7 h-7 rounded-lg bg-amber-50 flex items-center justify-center">
                    <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                    </svg>
                </div>
            </div>
            <div class="flex items-baseline gap-1">
                <p class="text-[32px] font-extrabold text-slate-900 leading-none">{{ number_format($stats['max_nilai'], 1) }}</p>
                <span class="text-sm text-slate-400 font-medium">/ 100</span>
            </div>
            <p class="mt-2 text-[11px] text-slate-400 truncate">{{ $stats['judul_tertinggi'] }}</p>
        </div>

        {{-- Nilai Terbaru --}}
        <div class="stat-card bg-white rounded-xl border border-slate-100 p-4 relative overflow-hidden">
            <div class="flex items-start justify-between mb-2">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Nilai Terbaru</p>
                <div class="w-7 h-7 rounded-lg bg-sky-50 flex items-center justify-center">
                    <svg class="w-4 h-4 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <div class="flex items-baseline gap-1">
                <p class="text-[32px] font-extrabold text-slate-900 leading-none">{{ number_format($stats['nilai_terbaru'], 1) }}</p>
                <span class="text-sm text-slate-400 font-medium">/ 100</span>
            </div>
            <p class="mt-2 text-[11px] text-slate-400 truncate">{{ $stats['judul_terbaru'] }} – {{ $stats['waktu_terbaru'] }}</p>
        </div>

        {{-- Tingkat Ketuntasan --}}
        <div class="stat-card bg-white rounded-xl border border-slate-100 p-4 relative overflow-hidden">
            <div class="flex items-start justify-between mb-2">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Tingkat Ketuntasan</p>
                <div class="w-7 h-7 rounded-lg bg-emerald-50 flex items-center justify-center">
                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <div class="flex items-baseline gap-1.5">
                <p class="text-[32px] font-extrabold text-slate-900 leading-none">{{ $stats['ketuntasan'] }}%</p>
                <span class="text-sm text-slate-400 font-medium">{{ $stats['kuis_lulus'] }}/{{ $stats['total_kuis'] }} Kuis</span>
            </div>
            @if($stats['total_kuis'] > 0)
                @if($stats['ketuntasan'] >= 90)
                <p class="mt-2 text-[11px] font-semibold text-emerald-600">Sangat Baik – Target: >90%</p>
                @elseif($stats['ketuntasan'] >= 75)
                <p class="mt-2 text-[11px] font-semibold text-sky-600">Baik – Target: >90%</p>
                @else
                <p class="mt-2 text-[11px] font-semibold text-red-500">Perlu Perhatian – Target: >90%</p>
                @endif
            @else
            <p class="mt-2 text-[11px] text-slate-400">Belum ada data</p>
            @endif
        </div>
    </div>

    {{-- =====================================================================
    |  FILTER BAR
    ====================================================================== --}}
    <div class="bg-white rounded-xl border border-slate-100 p-4 mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">

        {{-- Tabs rentang waktu --}}
        <div class="flex items-center gap-1">
            @foreach([['7','7 Hari'],['30','30 Hari'],['90','90 Hari'],['semua','Semua Data']] as [$val, $label])
            <a href="{{ route('orangtua.perkembangan-nilai', array_merge(request()->except('rentang'), ['siswa_id' => $siswa->id_user, 'rentang' => $val])) }}"
               class="px-3 py-1.5 rounded-lg text-xs font-semibold transition
                      {{ $rentangAktif === $val ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700' }}">
                {{ $label }}
            </a>
            @endforeach
        </div>

        {{-- Filter kanan --}}
        <div class="flex items-center gap-2">
            <form method="GET" action="{{ route('orangtua.perkembangan-nilai') }}" id="filterForm" class="flex items-center gap-2">
                <input type="hidden" name="siswa_id" value="{{ $siswa->id_user }}">
                <input type="hidden" name="rentang"  value="{{ $rentangAktif }}">

                <select name="mapel" onchange="document.getElementById('filterForm').submit()"
                        class="rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs text-slate-700 outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100">
                    <option value="">Semua Mata Pelajaran</option>
                    @foreach($mataPelajaranList as $mp)
                        <option value="{{ $mp }}" {{ $mapelAktif === $mp ? 'selected' : '' }}>{{ $mp }}</option>
                    @endforeach
                </select>

                <select name="status" onchange="document.getElementById('filterForm').submit()"
                        class="rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs text-slate-700 outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100">
                    <option value="">Semua Status</option>
                    <option value="lulus"    {{ $statusAktif === 'lulus'    ? 'selected' : '' }}>Tuntas</option>
                    <option value="remedial" {{ $statusAktif === 'remedial' ? 'selected' : '' }}>Remedial</option>
                </select>

                <a href="{{ route('orangtua.perkembangan-nilai', ['siswa_id' => $siswa->id_user]) }}"
                   title="Reset Filter"
                   class="flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 text-slate-400 hover:bg-slate-50 hover:text-slate-600 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                </a>
            </form>
        </div>
    </div>

    {{-- =====================================================================
    |  GRAFIK TREN NILAI
    ====================================================================== --}}
    <div class="bg-white rounded-xl border border-slate-100 p-5 mb-6">
        <div class="flex flex-wrap items-start justify-between gap-3 mb-4">
            <div>
                <h2 class="text-[15px] font-bold text-slate-900">Tren Evaluasi Nilai dari Waktu ke Waktu</h2>
                <p class="text-xs text-slate-400 mt-0.5">
                    Fluktuasi capaian belajar kuis berkala dibandingkan target KKM dan rata-rata kelas
                </p>
            </div>
            {{-- Legend --}}
            <div class="flex flex-wrap items-center gap-4 text-xs">
                <span class="flex items-center gap-1.5">
                    <span class="w-3 h-3 rounded-full bg-indigo-500 inline-block"></span>
                    <span class="text-slate-600">Nilai Siswa</span>
                </span>
                <span class="flex items-center gap-1.5">
                    <span class="inline-block w-6 h-0.5 bg-red-400" style="border-top: 2px dashed #f87171;"></span>
                    <span class="text-slate-600">Batas KKM ({{ $stats['kkm'] }}.0)</span>
                </span>
                <span class="flex items-center gap-1.5">
                    <span class="w-3 h-3 rounded-full bg-slate-300 inline-block"></span>
                    <span class="text-slate-400">Rata-rata Kelas</span>
                </span>
            </div>
        </div>

        @if(count($chartData) === 0)
        <div class="flex flex-col items-center justify-center h-44 text-slate-300">
            <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            <p class="text-sm">Belum ada data nilai pada periode ini</p>
        </div>
        @else
        <div class="relative" style="height:220px;" id="chartWrapper">
            <canvas id="nilaiChart" class="w-full h-full"></canvas>
        </div>
        {{-- Label sumbu X --}}
        <div class="flex justify-between mt-2 px-8">
            @foreach($chartData as $item)
            <span class="text-[10px] text-slate-400 text-center" style="flex: 1;">{{ $item['label'] }}</span>
            @endforeach
        </div>
        @endif
    </div>

    {{-- =====================================================================
    |  TABEL RIWAYAT NILAI
    ====================================================================== --}}
    <div class="bg-white rounded-xl border border-slate-100 p-5">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-[15px] font-bold text-slate-900">Riwayat Nilai Kuis</h2>
                <p class="text-xs text-slate-400 mt-0.5">Detail setiap kuis yang telah dikerjakan.</p>
            </div>
            <span class="text-xs text-slate-400">{{ $hasilList->count() }} Entri</span>
        </div>

        @if($hasilList->isEmpty())
        <div class="flex flex-col items-center justify-center py-10 text-slate-300">
            <p class="text-sm">Belum ada data pada filter yang dipilih</p>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-100">
                        <th class="text-left text-[11px] font-semibold uppercase tracking-wider text-slate-400 pb-2 pr-4">Tanggal</th>
                        <th class="text-left text-[11px] font-semibold uppercase tracking-wider text-slate-400 pb-2 pr-4">Judul Kuis</th>
                        <th class="text-left text-[11px] font-semibold uppercase tracking-wider text-slate-400 pb-2 pr-4">Tipe</th>
                        <th class="text-right text-[11px] font-semibold uppercase tracking-wider text-slate-400 pb-2 pr-4">Nilai</th>
                        <th class="text-right text-[11px] font-semibold uppercase tracking-wider text-slate-400 pb-2 pr-4">Poin</th>
                        <th class="text-center text-[11px] font-semibold uppercase tracking-wider text-slate-400 pb-2">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($hasilList as $h)
                    @php
                        $tgl   = \Carbon\Carbon::parse($h->waktu_dapat)->translatedFormat('D, d M Y · H:i');
                        $badge = $h->is_lulus
                            ? 'bg-emerald-50 text-emerald-700'
                            : 'bg-red-50 text-red-700';
                    @endphp
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="py-3 pr-4">
                            <p class="text-[12px] text-slate-500">{{ $tgl }}</p>
                        </td>
                        <td class="py-3 pr-4 max-w-[200px]">
                            <p class="text-[13px] font-medium text-slate-800 truncate">{{ $h->quiz?->judul ?? '-' }}</p>
                        </td>
                        <td class="py-3 pr-4">
                            <p class="text-[12px] text-slate-400">{{ $h->quiz?->tipeQuiz?->nama_tipe ?? '-' }}</p>
                        </td>
                        <td class="py-3 pr-4 text-right">
                            <p class="font-bold text-slate-900 text-[15px]">{{ number_format($h->nilai, 1) }}</p>
                        </td>
                        <td class="py-3 pr-4 text-right">
                            <p class="text-[12px] text-slate-400">{{ $h->poin_didapat }}/{{ $h->total_poin }}</p>
                        </td>
                        <td class="py-3 text-center">
                            <span class="inline-block px-2.5 py-0.5 rounded-full text-[11px] font-semibold {{ $badge }}">
                                {{ $h->is_lulus ? 'Tuntas' : 'Remedial' }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

    @endif {{-- end @if($siswa) --}}

</div>
@endsection

@push('scripts')
@if($siswa && count($chartData ?? []) > 0)
<script>
(function () {
    const canvas = document.getElementById('nilaiChart');
    if (!canvas) return;

    const rawData  = @json(array_column($chartData, 'nilai'));
    const labels   = @json(array_column($chartData, 'label'));
    const kkm      = {{ $stats['kkm'] }};
    const avgKelas = {{ $stats['avg_kelas'] }};

    const dpr    = window.devicePixelRatio || 1;
    const parent = canvas.parentElement;
    const w      = parent.clientWidth;
    const h      = parent.clientHeight || 220;

    canvas.width  = w * dpr;
    canvas.height = h * dpr;
    canvas.style.width  = w + 'px';
    canvas.style.height = h + 'px';

    const ctx = canvas.getContext('2d');
    ctx.scale(dpr, dpr);

    const padL = 36, padR = 24, padT = 20, padB = 16;
    const innerW = w - padL - padR;
    const innerH = h - padT - padB;
    const n = rawData.length;

    function xOf(i)   { return padL + (i / Math.max(n - 1, 1)) * innerW; }
    function yOf(val) { return padT + (1 - val / 100) * innerH; }

    // Grid lines
    [0, 25, 50, 75, 100].forEach(g => {
        const yy = yOf(g);
        ctx.beginPath();
        ctx.strokeStyle = '#f1f5f9';
        ctx.lineWidth   = 1;
        ctx.moveTo(padL, yy);
        ctx.lineTo(w - padR, yy);
        ctx.stroke();
        ctx.fillStyle = '#94a3b8';
        ctx.font      = '9px Inter, sans-serif';
        ctx.textAlign = 'right';
        ctx.fillText(g, padL - 5, yy + 3);
    });

    // KKM dashed line
    const kkmY = yOf(kkm);
    ctx.setLineDash([6, 4]);
    ctx.strokeStyle = '#f87171';
    ctx.lineWidth   = 1.5;
    ctx.beginPath();
    ctx.moveTo(padL, kkmY);
    ctx.lineTo(w - padR, kkmY);
    ctx.stroke();
    ctx.setLineDash([]);
    ctx.fillStyle = '#f87171';
    ctx.font      = '9px Inter, sans-serif';
    ctx.textAlign = 'left';
    ctx.fillText('KKM (' + kkm + ')', padL + 4, kkmY - 3);

    // Rata-rata kelas line
    if (avgKelas > 0) {
        const avgY = yOf(avgKelas);
        ctx.strokeStyle = '#cbd5e1';
        ctx.lineWidth   = 1;
        ctx.beginPath();
        ctx.moveTo(padL, avgY);
        ctx.lineTo(w - padR, avgY);
        ctx.stroke();
    }

    if (n === 0) return;

    // Fill gradient
    const grad = ctx.createLinearGradient(0, padT, 0, padT + innerH);
    grad.addColorStop(0,   'rgba(99,102,241,0.15)');
    grad.addColorStop(1,   'rgba(99,102,241,0.01)');

    ctx.beginPath();
    ctx.moveTo(xOf(0), yOf(rawData[0]));
    rawData.forEach((v, i) => { if (i > 0) ctx.lineTo(xOf(i), yOf(v)); });
    ctx.lineTo(xOf(n - 1), padT + innerH);
    ctx.lineTo(xOf(0),     padT + innerH);
    ctx.closePath();
    ctx.fillStyle = grad;
    ctx.fill();

    // Line
    ctx.beginPath();
    ctx.strokeStyle = '#6366f1';
    ctx.lineWidth   = 2.5;
    ctx.lineJoin    = 'round';
    ctx.moveTo(xOf(0), yOf(rawData[0]));
    rawData.forEach((v, i) => { if (i > 0) ctx.lineTo(xOf(i), yOf(v)); });
    ctx.stroke();

    // Points
    rawData.forEach((v, i) => {
        const x = xOf(i), y = yOf(v);
        ctx.beginPath();
        ctx.arc(x, y, 4.5, 0, Math.PI * 2);
        ctx.fillStyle   = v < kkm ? '#f87171' : '#6366f1';
        ctx.fill();
        ctx.strokeStyle = '#fff';
        ctx.lineWidth   = 1.5;
        ctx.stroke();

        ctx.fillStyle = '#334155';
        ctx.font      = 'bold 9px Inter, sans-serif';
        ctx.textAlign = 'center';
        ctx.fillText(v, x, y - 8);
    });
})();
</script>
@endif
@endpush
