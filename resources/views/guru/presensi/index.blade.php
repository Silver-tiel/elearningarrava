@extends('layouts.app')

@section('header')
<h1 class="text-lg font-bold text-slate-800">Presensi</h1>
@endsection

@section('content')
<div class="p-4 sm:p-8 max-w-4xl">
    @include('guru.presensi._flash')

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
        <h3 class="font-bold text-slate-800 mb-1">Kelas hari ini</h3>
        <p class="text-sm text-slate-500 mb-3">{{ now()->locale('id')->translatedFormat('l, d F Y') }}</p>
        <div class="space-y-3 mb-10">
            @forelse($sesiHariIni as $sesi)
                <div class="bg-white rounded-2xl border border-gray-100 p-4 flex flex-wrap items-center justify-between gap-3">
                    <div class="min-w-0">
                        <p class="font-semibold text-slate-800 truncate">{{ $sesi->kelas->nama }}</p>
                        <p class="text-sm text-slate-500">{{ $sesi->kelas->ringkasJadwal() }} · {{ $sesi->presensi_count }} tercatat</p>
                    </div>
                    <div class="flex items-center gap-2">
                        @if(!$sesi->isBuka())
                            <span class="px-2 py-1 rounded-full text-xs font-semibold bg-slate-200 text-slate-700">Ditutup</span>
                        @elseif(!$sesi->bisaDipindai())
                            <span class="px-2 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">Kelas tidak aktif</span>
                        @else
                            <span class="px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">Dibuka</span>
                        @endif
                        @if($sesi->bisaDipindai())
                            <a href="{{ route('guru.presensi.scan', $sesi->id_sesi) }}" class="h-11 px-4 inline-flex items-center rounded-xl bg-blue-600 text-white font-semibold">Scan</a>
                        @endif
                        <a href="{{ route('guru.presensi.rekap', $sesi->id_sesi) }}" class="h-11 px-4 inline-flex items-center rounded-xl border border-slate-300 text-slate-700 font-medium">Rekap</a>
                    </div>
                </div>
            @empty
                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5 text-slate-600 text-sm">
                    Tidak ada kelas yang aktif hari ini (di luar jadwal atau masa berlaku).
                </div>
            @endforelse
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
                   class="h-11 px-4 inline-flex items-center rounded-xl border border-slate-300 text-slate-700 font-medium hover:bg-slate-50">Tampilkan riwayat 1 bulan</a>
            @else
                <a href="{{ route('guru.presensi.index', ['hari' => $hari]) }}"
                   class="h-11 px-4 inline-flex items-center rounded-xl border border-slate-300 text-slate-700 font-medium hover:bg-slate-50">Kembali ke minggu ini</a>
            @endif
        </div>

        <nav aria-label="Filter hari" class="flex flex-wrap gap-2 mb-4">
            <a href="{{ route('guru.presensi.index', ['rentang' => $rentang === 'bulan' ? 'bulan' : null]) }}"
               @if($hari === null) aria-current="page" @endif
               class="h-10 px-4 inline-flex items-center rounded-full text-sm font-semibold border {{ $hari === null ? 'bg-slate-800 text-white border-slate-800' : 'bg-white text-slate-700 border-slate-300 hover:bg-slate-50' }}">Semua</a>
            @foreach($namaHari as $angka => $nama)
                <a href="{{ route('guru.presensi.index', ['rentang' => $rentang === 'bulan' ? 'bulan' : null, 'hari' => $angka]) }}"
                   @if($hari === $angka) aria-current="page" @endif
                   class="h-10 px-4 inline-flex items-center rounded-full text-sm font-semibold border {{ $hari === $angka ? 'bg-slate-800 text-white border-slate-800' : 'bg-white text-slate-700 border-slate-300 hover:bg-slate-50' }}">{{ $nama }}</a>
            @endforeach
        </nav>

        <div class="space-y-5">
            @forelse($riwayatPerTanggal as $tanggal => $sesiPerHari)
                <section aria-label="{{ $tanggal }}">
                    <h4 class="text-sm font-bold text-slate-600 mb-2">{{ \Illuminate\Support\Carbon::parse($tanggal)->locale('id')->translatedFormat('l, d F Y') }}</h4>
                    <div class="space-y-2">
                        @foreach($sesiPerHari as $sesi)
                            <div class="bg-white rounded-2xl border border-gray-100 p-4 flex flex-wrap items-center justify-between gap-3">
                                <div class="min-w-0">
                                    <p class="font-semibold text-slate-800 truncate">{{ $sesi->kelas->nama }}</p>
                                    <p class="text-sm text-slate-500">{{ $sesi->judul }} · {{ $sesi->presensi_count }} tercatat</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold bg-slate-200 text-slate-700">{{ $sesi->statusTampil() === 'ditutup' ? 'Ditutup' : 'Kedaluwarsa' }}</span>
                                    <a href="{{ route('guru.presensi.rekap', $sesi->id_sesi) }}" class="h-11 px-4 inline-flex items-center rounded-xl border border-slate-300 text-slate-700 font-medium">Rekap</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @empty
                <p class="text-sm text-slate-500">
                    Tidak ada riwayat{{ $hari ? ' pada hari ' . $namaHari[$hari] : '' }} {{ $rentang === 'bulan' ? 'dalam 30 hari terakhir' : 'minggu ini' }}.
                </p>
            @endforelse
        </div>
    @endif
</div>
@endsection
