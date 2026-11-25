@extends('layouts.orangtua')
@include('components.page-loader')

@section('title', 'Absensi Anak - Portal Orang Tua')
@section('breadcrumb', 'Absensi')

@section('content')
<div class="px-4 sm:px-6 py-6 max-w-[1400px] mx-auto space-y-6">

    {{-- Header --}}
    <div>
        <h1 class="text-2xl font-bold text-slate-800">
            📋 Absensi Anak
        </h1>
        <p class="mt-1 text-sm text-slate-500">
            Pantau riwayat kehadiran dan presensi anak Anda di kelas.
        </p>
    </div>

    @if ($siswaList->isNotEmpty())

    {{-- Pemilihan Siswa & Filter Bulan --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <form action="{{ route('orangtua.absensi') }}" method="GET">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-end">
                {{-- Pilih Siswa --}}
                <div class="flex-1 sm:max-w-md">
                    <label for="siswa_id" class="mb-2 block text-sm font-semibold text-slate-700">
                        Pilih Siswa
                    </label>
                    <select name="siswa_id" id="siswa_id"
                        class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-700 focus:border-[#007FBE] focus:outline-none focus:ring-2 focus:ring-[#DDF3FF]">
                        @foreach ($siswaList as $item)
                        <option value="{{ $item->id_user }}"
                            {{ (int) $siswa->id_user === (int) $item->id_user ? 'selected' : '' }}>
                            {{ $item->nama }}
                            @if ($item->jenjang)
                            — {{ $item->jenjang->nama_jenjang }}
                            @endif
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- Filter Bulan --}}
                <div class="sm:max-w-xs">
                    <label for="bulan" class="mb-2 block text-sm font-semibold text-slate-700">
                        Filter Bulan
                    </label>
                    <select name="bulan" id="bulan"
                        class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-700 focus:border-[#007FBE] focus:outline-none focus:ring-2 focus:ring-[#DDF3FF]">
                        <option value="">Semua Bulan</option>
                        @foreach ($bulanList as $bln)
                        @php
                            $carbonBulan = \Carbon\Carbon::createFromFormat('Y-m', $bln);
                        @endphp
                        <option value="{{ $bln }}" {{ $filterBulan === $bln ? 'selected' : '' }}>
                            {{ $carbonBulan->locale('id')->translatedFormat('F Y') }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit"
                    class="rounded-xl bg-[#007FBE] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#00628E] shadow-[0_3px_0_#00628E] active:shadow-none active:translate-y-[3px]">
                    Tampilkan
                </button>
            </div>
        </form>
    </div>

    {{-- Info Siswa --}}
    <div class="flex flex-col gap-3 rounded-2xl border border-[#DCEFFF] bg-[#DDF3FF]/50 p-5 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="text-sm text-[#007FBE] font-bold">Riwayat kehadiran siswa</p>
            <h2 class="mt-1 text-lg font-bold text-[#082765]">
                {{ $siswa->nama }}
            </h2>
            <p class="mt-1 text-sm text-[#465673]">
                {{ $siswa->jenjang->nama_jenjang ?? 'Jenjang belum tersedia' }}
            </p>
        </div>

        @if ($filterBulan)
        <div class="rounded-xl bg-white px-4 py-3 border border-[#DCEFFF]">
            <p class="text-xs text-[#72839E]">Periode</p>
            <p class="mt-1 text-sm font-bold text-[#082765]">
                {{ \Carbon\Carbon::createFromFormat('Y-m', $filterBulan)->locale('id')->translatedFormat('F Y') }}
            </p>
        </div>
        @endif
    </div>

    {{-- Statistik Cards --}}
    <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-5">

        {{-- Total Presensi Kelas --}}
        <div class="stat-card rounded-2xl border-2 border-[#DCEFFF] bg-white p-4 shadow-[0_4px_0_#B2E7FC] hover:shadow-[0_6px_0_#007FBE] hover:border-[#007FBE] hover:-translate-y-1 transition-all duration-200">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#DDF3FF] text-[#007FBE]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
            <p class="mt-3 text-2xl font-black text-[#082765]">{{ $stats['total_presensi'] }}</p>
            <p class="text-xs font-bold text-[#72839E]">Total Presensi</p>
        </div>

        {{-- Hadir Tepat Waktu --}}
        <div class="stat-card rounded-2xl border-2 border-[#DCEFFF] bg-white p-4 shadow-[0_4px_0_#B2E7FC] hover:shadow-[0_6px_0_#007FBE] hover:border-[#007FBE] hover:-translate-y-1 transition-all duration-200">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <p class="mt-3 text-2xl font-black text-emerald-700">{{ $stats['total_hadir'] }}</p>
            <p class="text-xs font-bold text-emerald-600/70">Hadir</p>
        </div>

        {{-- Terlambat --}}
        <div class="stat-card rounded-2xl border-2 border-[#DCEFFF] bg-white p-4 shadow-[0_4px_0_#B2E7FC] hover:shadow-[0_6px_0_#007FBE] hover:border-[#007FBE] hover:-translate-y-1 transition-all duration-200">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-50 text-amber-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <p class="mt-3 text-2xl font-black text-amber-700">{{ $stats['total_terlambat'] }}</p>
            <p class="text-xs font-bold text-amber-600/70">Terlambat</p>
        </div>

        {{-- Absensi Harian
        <div class="stat-card rounded-2xl border border-indigo-100 bg-white p-4 shadow-sm">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <p class="mt-3 text-2xl font-black text-indigo-700">{{ $stats['total_absensi'] }}</p>
            <p class="text-xs font-bold text-indigo-600/70">Absensi Login</p>
        </div> --}}

        {{-- Persentase Hadir --}}
        <div class="stat-card rounded-2xl border-2 border-[#DCEFFF] bg-white p-4 shadow-[0_4px_0_#B2E7FC] hover:shadow-[0_6px_0_#007FBE] hover:border-[#007FBE] hover:-translate-y-1 transition-all duration-200">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#DDF3FF] text-[#007FBE]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
            </div>
            <p class="mt-3 text-2xl font-black text-[#007FBE]">{{ $stats['persen_hadir'] }}%</p>
            <p class="text-xs font-bold text-[#72839E]">% Tepat Waktu</p>
        </div>

        {{-- Streak Kehadiran --}}
        <div class="stat-card rounded-2xl border-2 border-[#DCEFFF] bg-white p-4 shadow-[0_4px_0_#B2E7FC] hover:shadow-[0_6px_0_#007FBE] hover:border-[#007FBE] hover:-translate-y-1 transition-all duration-200">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-orange-50 text-orange-600">
                <span class="text-lg">🔥</span>
            </div>
            <p class="mt-3 text-2xl font-black text-orange-700">{{ $stats['streak'] }}</p>
            <p class="text-xs font-bold text-orange-600/70">Streak Hadir</p>
        </div>

    </div>

    {{-- Visualisasi Persentase Kehadiran --}}
    @if ($stats['total_presensi'] > 0)
    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <h3 class="font-bold text-slate-800 mb-4">Ringkasan Kehadiran</h3>
        <div class="flex flex-col sm:flex-row gap-4 items-center">
            {{-- Bar visual --}}
            <div class="flex-1 w-full">
                <div class="flex h-8 w-full overflow-hidden rounded-xl bg-slate-100">
                    @if ($stats['total_hadir'] > 0)
                    <div class="flex items-center justify-center bg-emerald-500 text-white text-xs font-bold transition-all duration-500"
                        style="width: {{ ($stats['total_hadir'] / $stats['total_presensi']) * 100 }}%">
                        @if (($stats['total_hadir'] / $stats['total_presensi']) * 100 > 10)
                        {{ round(($stats['total_hadir'] / $stats['total_presensi']) * 100, 1) }}%
                        @endif
                    </div>
                    @endif
                    @if ($stats['total_terlambat'] > 0)
                    <div class="flex items-center justify-center bg-amber-400 text-white text-xs font-bold transition-all duration-500"
                        style="width: {{ ($stats['total_terlambat'] / $stats['total_presensi']) * 100 }}%">
                        @if (($stats['total_terlambat'] / $stats['total_presensi']) * 100 > 10)
                        {{ round(($stats['total_terlambat'] / $stats['total_presensi']) * 100, 1) }}%
                        @endif
                    </div>
                    @endif
                </div>
                <div class="flex gap-4 mt-3">
                    <div class="flex items-center gap-1.5 text-xs text-slate-600">
                        <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span> Hadir
                    </div>
                    <div class="flex items-center gap-1.5 text-xs text-slate-600">
                        <span class="h-2.5 w-2.5 rounded-full bg-amber-400"></span> Terlambat
                    </div>
                </div>
            </div>

            {{-- Angka ringkas --}}
            <div class="flex gap-6 shrink-0">
                <div class="text-center">
                    <p class="text-2xl font-black text-emerald-600">{{ $stats['total_hadir'] }}</p>
                    <p class="text-xs text-slate-500">Hadir</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-black text-amber-500">{{ $stats['total_terlambat'] }}</p>
                    <p class="text-xs text-slate-500">Terlambat</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-black text-[#007FBE]">{{ $stats['total_presensi'] }}</p>
                    <p class="text-xs text-slate-500">Total</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- ================================================================ --}}
    {{-- TABEL PRESENSI KELAS (dari scan QR)                              --}}
    {{-- ================================================================ --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-100 px-5 py-4">
            <h2 class="font-bold text-slate-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-[#007FBE]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
                Riwayat Presensi Kelas
            </h2>
            <p class="mt-1 text-sm text-slate-500">
                Data kehadiran di kelas berdasarkan scan QR presensi.
            </p>
        </div>

        @if ($presensiPaginated->isNotEmpty())

        {{-- Desktop table --}}
        <div class="hidden sm:block overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-5 py-3 font-semibold">Tanggal</th>
                        <th class="px-5 py-3 font-semibold">Kelas</th>
                        <th class="px-5 py-3 font-semibold">Sesi</th>
                        <th class="px-5 py-3 font-semibold">Waktu Scan</th>
                        <th class="px-5 py-3 font-semibold text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($presensiPaginated as $item)
                    @php
                        $isHadir = $item->status === 'hadir';
                        $statusClass = $isHadir
                            ? 'bg-emerald-50 text-emerald-700 ring-emerald-600/20'
                            : 'bg-amber-50 text-amber-700 ring-amber-600/20';
                        $statusLabel = $isHadir ? 'Hadir' : 'Terlambat';
                    @endphp
                    <tr class="hover:bg-slate-50/60 transition">
                        <td class="px-5 py-4 font-medium text-slate-800">
                            {{ $item->sesi?->tanggal ? $item->sesi->tanggal->locale('id')->translatedFormat('l, d M Y') : '-' }}
                        </td>
                        <td class="px-5 py-4 text-slate-600">
                            {{ $item->sesi?->kelas?->nama ?? '-' }}
                        </td>
                        <td class="px-5 py-4 text-slate-600">
                            {{ $item->sesi?->judul ?? '-' }}
                            @if ($item->sesi?->pertemuan_ke)
                            <span class="text-xs text-slate-400 ml-1">(Pertemuan {{ $item->sesi->pertemuan_ke }})</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-slate-600">
                            {{ $item->waktu_scan ? $item->waktu_scan->format('H:i') : '-' }}
                        </td>
                        <td class="px-5 py-4 text-center">
                            <span class="inline-flex items-center gap-1 rounded-full px-2.5 py-1 text-xs font-semibold ring-1 ring-inset {{ $statusClass }}">
                                @if ($isHadir)
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                @else
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3"/></svg>
                                @endif
                                {{ $statusLabel }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Mobile cards --}}
        <div class="sm:hidden divide-y divide-slate-100">
            @foreach ($presensiPaginated as $item)
            @php
                $isHadir = $item->status === 'hadir';
                $statusClass = $isHadir
                    ? 'bg-emerald-50 text-emerald-700'
                    : 'bg-amber-50 text-amber-700';
                $statusLabel = $isHadir ? 'Hadir' : 'Terlambat';
                $borderClass = $isHadir ? 'border-l-emerald-500' : 'border-l-amber-400';
            @endphp
            <div class="px-4 py-4 border-l-4 {{ $borderClass }}">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="font-semibold text-slate-800 text-sm">
                            {{ $item->sesi?->tanggal ? $item->sesi->tanggal->locale('id')->translatedFormat('l, d M Y') : '-' }}
                        </p>
                        <p class="text-xs text-slate-500 mt-0.5">
                            {{ $item->sesi?->kelas?->nama ?? '-' }}
                            · {{ $item->sesi?->judul ?? '-' }}
                        </p>
                        <p class="text-xs text-slate-400 mt-1">
                            Scan: {{ $item->waktu_scan ? $item->waktu_scan->format('H:i') : '-' }}
                        </p>
                    </div>
                    <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $statusClass }}">
                        {{ $statusLabel }}
                    </span>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="flex flex-col gap-3 border-t border-slate-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
            <p class="text-sm text-slate-500">
                Menampilkan {{ $presensiPaginated->firstItem() ?? 0 }}
                sampai {{ $presensiPaginated->lastItem() ?? 0 }}
                dari {{ $presensiPaginated->total() }} presensi.
            </p>
            <div>
                {{ $presensiPaginated->links() }}
            </div>
        </div>

        @else

        <div class="px-5 py-14 text-center">
            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100">
                <svg class="h-7 w-7 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
            <h3 class="mt-4 font-semibold text-slate-800">Belum Ada Data Presensi Kelas</h3>
            <p class="mx-auto mt-2 max-w-sm text-sm text-slate-500">
                Belum ada riwayat presensi kelas yang tercatat untuk siswa ini
                @if ($filterBulan)
                pada bulan {{ \Carbon\Carbon::createFromFormat('Y-m', $filterBulan)->locale('id')->translatedFormat('F Y') }}.
                @else
                .
                @endif
            </p>
        </div>

        @endif
    </div>

    {{-- ================================================================ --}}
    {{-- TABEL ABSENSI LOGIN HARIAN                                        --}}
    {{-- ================================================================ --}}
    @if ($absensi->isNotEmpty())
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-100 px-5 py-4">
            <h2 class="font-bold text-slate-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Riwayat Absensi Harian
            </h2>
            <p class="mt-1 text-sm text-slate-500">
                Catatan login/absensi harian siswa di platform e-learning.
            </p>
        </div>

        <div class="divide-y divide-slate-100">
            @foreach ($absensi as $item)
            <div class="flex items-center gap-3 px-5 py-4">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="font-semibold text-slate-800 text-sm">
                        {{ \Carbon\Carbon::parse($item->waktu_absensi)->locale('id')->translatedFormat('l, d F Y') }}
                    </p>
                    <p class="text-xs text-slate-500 mt-0.5">
                        Login pukul {{ \Carbon\Carbon::parse($item->waktu_absensi)->format('H:i') }} WIB
                    </p>
                </div>
                <span class="rounded-full bg-indigo-50 px-3 py-1.5 text-xs font-semibold text-indigo-700">
                    Tercatat
                </span>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    @else

    {{-- Belum ada siswa terhubung --}}
    <div class="rounded-2xl border border-slate-200 bg-white px-5 py-14 text-center shadow-sm">
        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-[#DDF3FF]">
            <svg class="h-8 w-8 text-[#007FBE]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
        </div>
        <h2 class="mt-4 text-lg font-bold text-slate-800">
            Belum Ada Siswa Terhubung
        </h2>
        <p class="mx-auto mt-2 max-w-md text-sm text-slate-500">
            Data absensi belum dapat ditampilkan karena akun orang tua
            belum terhubung dengan akun siswa.
        </p>
    </div>

    @endif

</div>
@endsection

