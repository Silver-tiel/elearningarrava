@extends('layouts.app')

@section('header')
<a href="{{ route('guru.presensi.index') }}" class="text-sm text-blue-600 font-medium">← Presensi</a>
@endsection

@section('content')
@php
    $badge = [
        'hadir' => ['Hadir', 'bg-green-100 text-green-800'],
        'terlambat' => ['Terlambat', 'bg-amber-100 text-amber-800'],
        'tidak_hadir' => ['Tidak hadir', 'bg-red-100 text-red-800'],
    ];
    $bintangTerpilih = old('bintang');
    if ($bintangTerpilih === null) {
        $bintang = $baris->first(fn ($barisSiswa) => $barisSiswa['is_bintang']);
        $bintangTerpilih = $bintang['id_siswa'] ?? null;
    }
@endphp
<div class="mx-auto max-w-5xl p-4 sm:p-6 lg:p-8">
    @include('guru.presensi._flash')

    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="mb-1 text-sm font-semibold text-sky-700">Rekap presensi</p>
            <h2 class="text-2xl font-bold tracking-tight text-slate-800">{{ $sesi->judul }}</h2>
            <p class="mt-1 text-sm text-slate-500">{{ $sesi->kelas->nama }} <span class="px-1 text-slate-300">·</span> {{ $sesi->tanggal->format('d M Y') }}</p>
        </div>
        <span class="inline-flex w-fit items-center rounded-full border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-600">
            @switch($sesi->statusTampil())
                @case('dibuka') Sesi dibuka @break
                @case('kedaluwarsa') Sesi kedaluwarsa @break
                @default Sesi ditutup
            @endswitch
        </span>
    </div>

    <div class="mb-6 grid grid-cols-1 gap-3 sm:grid-cols-3">
        <div class="rounded-xl border border-green-200 bg-white p-4">
            <p class="text-sm font-medium text-slate-500">Hadir</p>
            <p class="mt-1 text-2xl font-bold text-green-700">{{ $ringkasan['hadir'] }}</p>
        </div>
        <div class="rounded-xl border border-amber-200 bg-white p-4">
            <p class="text-sm font-medium text-slate-500">Terlambat</p>
            <p class="mt-1 text-2xl font-bold text-amber-700">{{ $ringkasan['terlambat'] }}</p>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-4">
            <p class="text-sm font-medium text-slate-500">Tidak hadir</p>
            <p class="mt-1 text-2xl font-bold text-slate-700">{{ $ringkasan['tidak_hadir'] }}</p>
        </div>
    </div>

    @if($sesi->bisaDipindai())
        <a href="{{ route('guru.presensi.scan', $sesi->id_sesi) }}" class="mb-5 inline-flex h-10 items-center rounded-lg bg-sky-700 px-4 text-sm font-semibold text-white transition hover:bg-sky-800 focus:outline-none focus:ring-2 focus:ring-sky-600 focus:ring-offset-2">Lanjut scan</a>
    @endif

    <form method="POST" action="{{ route('guru.presensi.nilai', $sesi->id_sesi) }}">
        @csrf
        <section class="overflow-hidden rounded-xl border border-slate-200 bg-white">
            <div class="border-b border-slate-200 px-4 py-4 sm:px-5">
                <h3 class="font-bold text-slate-800">Nilai dan siswa bintang</h3>
                <p class="mt-1 text-sm text-slate-500">Nilai hanya dapat diisi untuk siswa yang hadir atau terlambat.</p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[700px] text-sm">
                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-4 py-3.5">Siswa</th>
                        <th class="px-4 py-3.5">Status</th>
                        <th class="px-4 py-3.5">Waktu</th>
                        <th class="px-4 py-3.5">Nilai <span class="font-normal normal-case tracking-normal">(0–100)</span></th>
                        <th class="px-4 py-3.5">Siswa bintang</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($baris as $b)
                        <tr class="transition-colors hover:bg-slate-50/70">
                            <td class="px-4 py-3.5 font-semibold text-slate-800">{{ $b['nama'] }}</td>
                            <td class="px-4 py-3.5"><span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $badge[$b['status']][1] }}">{{ $badge[$b['status']][0] }}</span></td>
                            <td class="px-4 py-3.5 text-slate-500">{{ $b['waktu'] ?? '—' }}</td>
                            <td class="px-4 py-3">
                                @if($b['status'] === 'hadir' || $b['status'] === 'terlambat')
                                    <input
                                        type="number"
                                        name="nilai[{{ $b['id_siswa'] }}]"
                                        value="{{ old('nilai.' . $b['id_siswa'], $b['nilai']) }}"
                                        min="0"
                                        max="100"
                                        step="0.01"
                                        inputmode="decimal"
                                        class="w-28 rounded-lg border-slate-300 px-3 py-2 text-sm text-slate-800 focus:border-sky-600 focus:ring-sky-600"
                                        placeholder="0–100"
                                        aria-label="Nilai {{ $b['nama'] }}"
                                    >
                                @else
                                    <span class="text-slate-400">—</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @if($b['status'] === 'hadir' || $b['status'] === 'terlambat')
                                    <label class="inline-flex cursor-pointer items-center gap-2 rounded-lg px-2 py-1.5 text-slate-600 transition hover:bg-amber-50 hover:text-amber-800">
                                        <input
                                            type="radio"
                                            name="bintang"
                                            value="{{ $b['id_siswa'] }}"
                                            @checked((int) $bintangTerpilih === (int) $b['id_siswa'])
                                            class="h-4 w-4 border-slate-300 text-amber-500 focus:ring-amber-500"
                                        >
                                        <span>Pilih bintang</span>
                                    </label>
                                @else
                                    <span class="px-2 text-slate-400">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-10 text-center text-slate-500">Kelas ini belum memiliki siswa.</td></tr>
                    @endforelse
                </tbody>
                </table>
            </div>
            @if($baris->isNotEmpty())
                <div class="flex flex-col gap-3 border-t border-slate-200 bg-slate-50/60 px-4 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-5">
                    <p class="text-xs text-slate-500">Pilihan siswa bintang tersimpan bersama nilai sesi ini.</p>
                    <button type="submit" class="inline-flex h-10 items-center justify-center rounded-lg bg-sky-700 px-4 text-sm font-semibold text-white transition hover:bg-sky-800 focus:outline-none focus:ring-2 focus:ring-sky-600 focus:ring-offset-2">
                        Simpan perubahan
                    </button>
                </div>
            @endif
        </section>
    </form>
</div>
@endsection
