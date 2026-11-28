@extends('layouts.app')

@section('header')
<h1 class="text-lg font-bold text-slate-800">Pelaporan Harian</h1>
@endsection

@section('content')
<div class="mx-auto max-w-6xl p-4 sm:p-6 lg:p-8">
    @include('guru.presensi._flash')

    <div class="mb-6">
        <h2 class="text-2xl font-black text-[#082765]">Pelaporan Harian Guru</h2>
        <p class="mt-1 text-sm text-[#72839E]">Lengkapi laporan berdasarkan sesi presensi yang Anda ampu. Data kelas, jenjang, hari, dan tanggal mengikuti pengaturan kelas serta sesi presensi.</p>
    </div>
    @include('guru.laporan-harian._list', ['laporanSesi' => $sesi])
</div>
@endsection
