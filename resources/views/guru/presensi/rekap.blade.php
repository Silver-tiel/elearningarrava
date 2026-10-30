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
@endphp
<div class="p-4 sm:p-8 max-w-3xl">
    @include('guru.presensi._flash')

    <div class="mb-4">
        <h2 class="text-xl font-bold text-slate-800">Rekap: {{ $sesi->judul }}</h2>
        <p class="text-sm text-slate-500">{{ $sesi->kelas->nama }} · {{ $sesi->tanggal->format('d M Y') }} · {{ $sesi->isBuka() ? 'Sesi dibuka' : 'Sesi ditutup' }}</p>
    </div>

    <div class="grid grid-cols-3 gap-2 text-center mb-6">
        <div class="rounded-xl bg-green-50 border border-green-200 p-3"><p class="text-2xl font-bold text-green-800">{{ $ringkasan['hadir'] }}</p><p class="text-xs text-green-800">Hadir</p></div>
        <div class="rounded-xl bg-amber-50 border border-amber-200 p-3"><p class="text-2xl font-bold text-amber-800">{{ $ringkasan['terlambat'] }}</p><p class="text-xs text-amber-800">Terlambat</p></div>
        <div class="rounded-xl bg-red-50 border border-red-200 p-3"><p class="text-2xl font-bold text-red-800">{{ $ringkasan['tidak_hadir'] }}</p><p class="text-xs text-red-800">Tidak hadir</p></div>
    </div>

    @if($sesi->isBuka())
        <a href="{{ route('guru.presensi.scan', $sesi->id_sesi) }}" class="mb-4 inline-flex items-center h-12 px-5 rounded-xl bg-blue-600 text-white font-semibold">Lanjut scan</a>
    @endif

    <div class="bg-white rounded-2xl border border-gray-100 overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-600 text-left">
                <tr><th class="px-4 py-3">Siswa</th><th class="px-4 py-3">Status</th><th class="px-4 py-3">Waktu</th></tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($baris as $b)
                    <tr>
                        <td class="px-4 py-3 font-medium text-slate-800">{{ $b['nama'] }}</td>
                        <td class="px-4 py-3"><span class="inline-block px-2 py-1 rounded-full text-xs font-semibold {{ $badge[$b['status']][1] }}">{{ $badge[$b['status']][0] }}</span></td>
                        <td class="px-4 py-3 text-slate-600">{{ $b['waktu'] ?? '—' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="px-4 py-8 text-center text-slate-500">Kelas ini belum memiliki siswa.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
