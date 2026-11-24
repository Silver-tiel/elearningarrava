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
<div class="p-4 sm:p-8 max-w-3xl">
    @include('guru.presensi._flash')

    <div class="mb-4">
        <h2 class="text-xl font-bold text-slate-800">Rekap: {{ $sesi->judul }}</h2>
        <p class="text-sm text-slate-500">{{ $sesi->kelas->nama }} · {{ $sesi->tanggal->format('d M Y') }} · @switch($sesi->statusTampil())
            @case('dibuka') Sesi dibuka @break
            @case('kedaluwarsa') Sesi kedaluwarsa @break
            @default Sesi ditutup
        @endswitch</p>
    </div>

    <div class="grid grid-cols-3 gap-2 text-center mb-6">
        <div class="rounded-xl bg-green-50 border border-green-200 p-3"><p class="text-2xl font-bold text-green-800">{{ $ringkasan['hadir'] }}</p><p class="text-xs text-green-800">Hadir</p></div>
        <div class="rounded-xl bg-amber-50 border border-amber-200 p-3"><p class="text-2xl font-bold text-amber-800">{{ $ringkasan['terlambat'] }}</p><p class="text-xs text-amber-800">Terlambat</p></div>
        <div class="rounded-xl bg-red-50 border border-red-200 p-3"><p class="text-2xl font-bold text-red-800">{{ $ringkasan['tidak_hadir'] }}</p><p class="text-xs text-red-800">Tidak hadir</p></div>
    </div>

    @if($sesi->bisaDipindai())
        <a href="{{ route('guru.presensi.scan', $sesi->id_sesi) }}" class="mb-4 inline-flex items-center h-12 px-5 rounded-xl bg-blue-600 text-white font-semibold">Lanjut scan</a>
    @endif

    <form method="POST" action="{{ route('guru.presensi.nilai', $sesi->id_sesi) }}">
        @csrf
        <div class="bg-white rounded-2xl border border-gray-100 overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-600 text-left">
                    <tr>
                        <th class="px-4 py-3">Siswa</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Waktu</th>
                        <th class="px-4 py-3">Nilai (0–100)</th>
                        <th class="px-4 py-3">Siswa Bintang</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($baris as $b)
                        <tr>
                            <td class="px-4 py-3 font-medium text-slate-800">{{ $b['nama'] }}</td>
                            <td class="px-4 py-3"><span class="inline-block px-2 py-1 rounded-full text-xs font-semibold {{ $badge[$b['status']][1] }}">{{ $badge[$b['status']][0] }}</span></td>
                            <td class="px-4 py-3 text-slate-600">{{ $b['waktu'] ?? '—' }}</td>
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
                                        class="w-28 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                        placeholder="0–100"
                                    >
                                @else
                                    <span class="text-slate-400">Tidak hadir</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @if($b['status'] === 'hadir' || $b['status'] === 'terlambat')
                                    <label class="inline-flex items-center gap-2 cursor-pointer">
                                        <input
                                            type="radio"
                                            name="bintang"
                                            value="{{ $b['id_siswa'] }}"
                                            @checked((int) $bintangTerpilih === (int) $b['id_siswa'])
                                            class="h-4 w-4 border-gray-300 text-amber-500 focus:ring-amber-500"
                                        >
                                        <span class="font-semibold text-amber-700" aria-label="Pilih sebagai siswa bintang">
                                            ⭐ {{ $b['nama'] }}
                                        </span>
                                    </label>
                                @else
                                    <span class="text-slate-400">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-8 text-center text-slate-500">Kelas ini belum memiliki siswa.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($baris->isNotEmpty())
            <button type="submit" class="mt-4 inline-flex items-center h-12 px-5 rounded-xl bg-blue-600 text-white font-semibold">
                Simpan nilai siswa hadir
            </button>
        @endif
    </form>
</div>
@endsection
