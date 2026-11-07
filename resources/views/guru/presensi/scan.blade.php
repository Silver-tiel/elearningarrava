@extends('layouts.app')

@section('header')
<a href="{{ route('guru.presensi.index') }}" class="text-sm text-blue-600 font-medium">← Presensi</a>
@endsection

@section('content')
@php
    $labelRiwayat = [
        'hadir' => 'Hadir', 'terlambat' => 'Terlambat', 'duplikat' => 'Sudah tercatat',
        'tidak_valid' => 'QR tidak valid', 'bukan_anggota' => 'Bukan anggota kelas',
        'tidak_aktif' => 'Akun nonaktif', 'sesi_ditutup' => 'Sesi ditutup', 'kedaluwarsa' => 'Sesi kedaluwarsa', 'kelas_nonaktif' => 'Kelas tidak aktif',
    ];
@endphp

<div id="scan-app"
     data-url="{{ route('guru.presensi.proses', $sesi->id_sesi) }}"
     data-csrf="{{ csrf_token() }}"
     data-buka="{{ $sesi->isBuka() ? '1' : '0' }}"
     class="p-4 sm:p-8 max-w-2xl mx-auto space-y-4 pb-20">

    <div>
        <h2 class="text-xl font-bold text-slate-800">{{ $sesi->judul }}</h2>
        <p class="text-sm text-slate-500">{{ $sesi->kelas->nama }} · {{ $sesi->tanggal->format('d M Y') }}</p>
    </div>

    @if(!$sesi->isBuka())
        <div role="alert" class="rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-amber-900">
            Sesi ini sudah ditutup. <a class="underline font-medium" href="{{ route('guru.presensi.rekap', $sesi->id_sesi) }}">Lihat rekap</a>.
        </div>
    @endif

    {{-- Ringkasan --}}
    <div class="grid grid-cols-3 gap-2 text-center" aria-live="polite">
        <div class="rounded-xl bg-green-50 border border-green-200 p-3"><p class="text-2xl font-bold text-green-800" id="n-hadir">{{ $ringkasan['hadir'] }}</p><p class="text-xs text-green-800">Hadir</p></div>
        <div class="rounded-xl bg-amber-50 border border-amber-200 p-3"><p class="text-2xl font-bold text-amber-800" id="n-terlambat">{{ $ringkasan['terlambat'] }}</p><p class="text-xs text-amber-800">Terlambat</p></div>
        <div class="rounded-xl bg-slate-50 border border-slate-200 p-3"><p class="text-2xl font-bold text-slate-700" id="n-belum">{{ $ringkasan['tidak_hadir'] }}</p><p class="text-xs text-slate-700">Belum</p></div>
    </div>

    {{-- Kamera --}}
    <div class="relative rounded-2xl overflow-hidden bg-slate-900 aspect-square sm:aspect-[4/3]">
        <video id="kamera" class="absolute inset-0 w-full h-full object-cover" playsinline muted></video>
        <div id="kamera-kosong" class="absolute inset-0 flex items-center justify-center p-6 text-center text-slate-300">
            Tekan <b class="mx-1">Mulai Scan</b> untuk mengaktifkan kamera.
        </div>
    </div>

    <div class="grid grid-cols-2 gap-3">
        <button id="btn-mulai" type="button" @disabled(!$sesi->isBuka()) class="h-14 rounded-xl bg-blue-600 text-white text-lg font-bold hover:bg-blue-700 disabled:opacity-50">Mulai Scan</button>
        <button id="btn-stop" type="button" disabled class="h-14 rounded-xl bg-slate-200 text-slate-800 text-lg font-bold disabled:opacity-50">Berhenti</button>
    </div>

    {{-- Hasil terakhir --}}
    <div id="hasil" role="status" aria-live="assertive" class="hidden rounded-2xl border-2 p-4">
        <p id="hasil-judul" class="text-lg font-bold"></p>
        <p id="hasil-detail" class="text-base"></p>
    </div>

    {{-- Input manual (fallback) --}}
    <form id="form-manual" class="bg-white rounded-2xl border border-gray-100 p-4" autocomplete="off">
        <label for="token-manual" class="block text-sm font-medium text-slate-700 mb-1">Input token manual</label>
        <p class="text-xs text-slate-500 mb-2">Gunakan jika kamera tidak tersedia. Ketik atau tempel kode QR siswa.</p>
        <div class="flex gap-2">
            <input id="token-manual" type="text" maxlength="80" inputmode="text" autocapitalize="off" spellcheck="false"
                   class="flex-1 h-14 rounded-xl border border-slate-300 px-4 text-base" placeholder="ARV1.…">
            <button type="submit" class="h-14 px-6 rounded-xl bg-slate-800 text-white font-bold">Kirim</button>
        </div>
    </form>

    {{-- Riwayat --}}
    <section aria-labelledby="judul-riwayat" class="bg-white rounded-2xl border border-gray-100 p-4 sm:p-5 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <h3 id="judul-riwayat" class="font-bold text-slate-800">Riwayat scan terbaru</h3>
            <span class="text-xs text-slate-400">Maks. 10 scan terakhir</span>
        </div>
        <ul id="riwayat" class="space-y-2">
            @foreach($riwayat as $r)
                <li class="flex items-center justify-between rounded-xl bg-slate-50 border border-slate-200/70 px-4 py-3 text-sm">
                    <span class="font-medium text-slate-800">{{ $r['nama'] ?? 'QR tidak dikenal' }}</span>
                    <span class="text-slate-500">{{ $labelRiwayat[$r['hasil']] ?? $r['hasil'] }} · {{ $r['waktu'] }}</span>
                </li>
            @endforeach
        </ul>
        <p id="riwayat-kosong" class="text-sm text-slate-400 text-center py-4 rounded-xl bg-slate-50 border border-dashed border-slate-200 {{ $riwayat->isEmpty() ? '' : 'hidden' }}">Belum ada pemindaian pada sesi ini.</p>
    </section>

    {{-- Panel Aksi Sesi Presensi --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-4 sm:p-5 shadow-sm space-y-3">
        @if($sesi->isBuka())
            <form method="POST" action="{{ route('guru.presensi.tutup', $sesi->id_sesi) }}" onsubmit="return confirm('Tutup sesi presensi ini?')">
                @csrf
                <button type="submit" class="w-full h-12 rounded-xl bg-slate-800 hover:bg-slate-900 text-white font-semibold transition shadow-sm flex items-center justify-center gap-2">
                    <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Tutup sesi &amp; lihat rekap</span>
                </button>
            </form>
        @endif

        <a href="{{ route('guru.presensi.rekap', $sesi->id_sesi) }}" class="w-full h-11 inline-flex items-center justify-center gap-2 rounded-xl border border-blue-200 bg-blue-50/80 hover:bg-blue-100 text-blue-700 font-semibold text-sm transition">
            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <span>Lihat rekap sesi</span>
        </a>
    </div>
</div>

@if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite('resources/js/presensi-scan.js')
@else
    <script>
        // Aset Vite belum dibangun: kamera tidak aktif, input manual tetap bisa dipakai.
        window.__scanFallbackMsg = 'Kamera belum tersedia (jalankan npm run build). Gunakan input token manual.';
    </script>
@endif
@endsection
