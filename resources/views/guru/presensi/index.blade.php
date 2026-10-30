@extends('layouts.app')

@section('header')
<h1 class="text-lg font-bold text-slate-800">Presensi</h1>
@endsection

@section('content')
<div class="p-4 sm:p-8 max-w-4xl">
    @include('guru.presensi._flash')

    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-800">Presensi</h2>
        <p class="text-sm text-slate-500 mt-1">Pilih kelas dan pertemuan, lalu pindai QR siswa dari kamera HP.</p>
    </div>

    @if($kelasList->isEmpty())
        <div class="rounded-2xl border border-amber-200 bg-amber-50 p-5 text-amber-900">
            Anda belum ditugaskan ke kelas mana pun. Hubungi admin untuk penugasan kelas.
        </div>
    @else
        <form method="POST" action="{{ route('guru.presensi.sesi.store') }}" class="bg-white rounded-2xl border border-gray-100 p-4 sm:p-6 grid gap-4 sm:grid-cols-2 mb-8">
            @csrf
            <div class="sm:col-span-2">
                <label for="id_kelas" class="block text-sm font-medium text-slate-700 mb-1">Kelas</label>
                <select id="id_kelas" name="id_kelas" required class="w-full h-14 rounded-xl border border-slate-300 px-4 text-base bg-white">
                    <option value="">— Pilih kelas —</option>
                    @foreach($kelasList as $k)
                        <option value="{{ $k->id_kelas }}" @selected(old('id_kelas') == $k->id_kelas)>{{ $k->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="sm:col-span-2">
                <label for="judul" class="block text-sm font-medium text-slate-700 mb-1">Judul pertemuan</label>
                <input id="judul" name="judul" required maxlength="150" value="{{ old('judul') }}" placeholder="Contoh: Pertemuan 3 – Persamaan Linear"
                       class="w-full h-14 rounded-xl border border-slate-300 px-4 text-base">
            </div>
            <div>
                <label for="pertemuan_ke" class="block text-sm font-medium text-slate-700 mb-1">Pertemuan ke- (opsional)</label>
                <input id="pertemuan_ke" name="pertemuan_ke" type="number" min="1" max="999" inputmode="numeric" value="{{ old('pertemuan_ke') }}"
                       class="w-full h-14 rounded-xl border border-slate-300 px-4 text-base">
            </div>
            <div>
                <label for="tanggal" class="block text-sm font-medium text-slate-700 mb-1">Tanggal</label>
                <input id="tanggal" name="tanggal" type="date" required value="{{ old('tanggal', now()->toDateString()) }}"
                       class="w-full h-14 rounded-xl border border-slate-300 px-4 text-base">
            </div>
            <div class="sm:col-span-2">
                <label for="jam_batas" class="block text-sm font-medium text-slate-700 mb-1">Batas tepat waktu (opsional)</label>
                <input id="jam_batas" name="jam_batas" type="time" value="{{ old('jam_batas') }}"
                       class="w-full h-14 rounded-xl border border-slate-300 px-4 text-base">
                <p class="text-xs text-slate-500 mt-1">Siswa yang dipindai setelah jam ini dicatat "terlambat". Kosongkan jika tidak ada batas.</p>
            </div>
            <div class="sm:col-span-2">
                <button type="submit" class="w-full h-14 rounded-xl bg-blue-600 text-white text-lg font-bold hover:bg-blue-700">Buat Sesi &amp; Mulai Scan</button>
            </div>
        </form>

        <h3 class="font-bold text-slate-800 mb-3">Sesi terbaru</h3>
        <div class="space-y-3">
            @forelse($sesiList as $sesi)
                <div class="bg-white rounded-2xl border border-gray-100 p-4 flex flex-wrap items-center justify-between gap-3">
                    <div class="min-w-0">
                        <p class="font-semibold text-slate-800 truncate">{{ $sesi->judul }}</p>
                        <p class="text-sm text-slate-500">{{ $sesi->kelas->nama }} · {{ $sesi->tanggal->format('d M Y') }} · {{ $sesi->presensi_count }} tercatat</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $sesi->isBuka() ? 'bg-green-100 text-green-800' : 'bg-slate-200 text-slate-700' }}">{{ $sesi->isBuka() ? 'Dibuka' : 'Ditutup' }}</span>
                        @if($sesi->isBuka())
                            <a href="{{ route('guru.presensi.scan', $sesi->id_sesi) }}" class="h-11 px-4 inline-flex items-center rounded-xl bg-blue-600 text-white font-semibold">Scan</a>
                        @endif
                        <a href="{{ route('guru.presensi.rekap', $sesi->id_sesi) }}" class="h-11 px-4 inline-flex items-center rounded-xl border border-slate-300 text-slate-700 font-medium">Rekap</a>
                    </div>
                </div>
            @empty
                <p class="text-sm text-slate-500">Belum ada sesi presensi.</p>
            @endforelse
        </div>
    @endif
</div>
@endsection
