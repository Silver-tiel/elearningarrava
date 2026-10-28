@extends('layouts.orangtua')
@include('components.page-loader')

@section('title', 'Dashboard - Portal Orang Tua')
@section('breadcrumb', 'Ringkasan Belajar')

@section('content')
<div class="mx-auto max-w-[1400px] space-y-6 px-4 py-6 sm:px-6">

    @if(!$siswa)
    <div class="rounded-2xl border border-slate-200 bg-white px-6 py-14 text-center">
        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-indigo-50">
            <svg class="h-7 w-7 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </div>
        <h2 class="mt-4 font-bold text-slate-800">Belum Ada Siswa Terhubung</h2>
        <p class="mx-auto mt-2 max-w-md text-sm text-slate-500">
            Silakan hubungi administrator untuk menghubungkan akun orang tua dengan akun siswa.
        </p>
    </div>
    @else

    {{-- Header dan informasi siswa --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Ringkasan Belajar</h1>
            <p class="mt-1 text-sm text-slate-500">
                Pantau hasil quiz dan aktivitas belajar anak dari satu halaman.
            </p>
        </div>

        <div class="flex items-center gap-3 rounded-xl border border-slate-200 bg-white p-3">
            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-indigo-50 font-bold text-indigo-600">
                {{ strtoupper(substr($siswa->nama, 0, 1)) }}
            </div>

            <div class="min-w-0 flex-1">
                <p class="truncate text-sm font-semibold text-slate-800">
                    {{ $siswa->nama }}
                </p>
                <p class="text-xs text-slate-500">
                    {{ $siswa->jenjang->nama_jenjang ?? $siswa->jenjang->nama_tipe ?? 'Jenjang belum tersedia' }}
                </p>
            </div>

            @if($siswaList->count() > 1)
            <form method="GET" action="{{ route('orangtua.dashboard') }}">
                <select
                    name="siswa_id"
                    onchange="this.form.submit()"
                    aria-label="Pilih siswa"
                    class="max-w-28 rounded-lg border border-slate-200 bg-white px-2 py-2 text-xs text-slate-600 focus:border-indigo-500 focus:outline-none">
                    @foreach($siswaList as $s)
                    <option value="{{ $s->id_user }}"
                        {{ (int) $s->id_user === (int) $siswa->id_user ? 'selected' : '' }}>
                        {{ $s->nama }}
                    </option>
                    @endforeach
                </select>
            </form>
            @endif
        </div>
    </div>

    {{-- Ringkasan akademik --}}
    <section>
        <h2 class="mb-3 text-base font-bold text-slate-800">Ringkasan Akademik</h2>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">

            <div class="rounded-2xl border border-slate-200 bg-white p-5">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-50">
                        <svg class="h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M9 5h-2a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <p class="text-sm font-medium text-slate-500">Quiz Dikerjakan</p>
                </div>

                <p class="mt-4 text-3xl font-bold text-slate-800">
                    {{ $stats['total_quiz_dikerjakan'] }}
                    <span class="text-base font-medium text-slate-400">
                        / {{ $stats['total_quiz_tersedia'] }}
                    </span>
                </p>
                <p class="mt-1 text-xs text-slate-500">Dari quiz yang tersedia</p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-5">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50">
                        <svg class="h-5 w-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <p class="text-sm font-medium text-slate-500">Materi Selesai</p>
                </div>

                <p class="mt-4 text-3xl font-bold text-slate-800">
                    {{ $stats['modul_selesai'] }}
                    <span class="text-base font-medium text-slate-400">
                        / {{ $stats['total_modul'] }}
                    </span>
                </p>
                <p class="mt-1 text-xs text-slate-500">Modul pembelajaran</p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-5">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50">
                        <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="text-sm font-medium text-slate-500">Rata-rata Nilai</p>
                </div>

                <p class="mt-4 text-3xl font-bold text-slate-800">
                    {{ number_format($stats['avg_nilai'], 1, ',', '.') }}
                    <span class="text-base font-medium text-slate-400">/ 100</span>
                </p>
                <p class="mt-1 text-xs text-slate-500">
                    {{ $stats['total_quiz_dikerjakan'] > 0 ? 'Berdasarkan hasil quiz' : 'Belum ada hasil quiz' }}
                </p>
            </div>

        </div>
    </section>

    {{-- Aktivitas belajar terbaru --}}
    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white">
        <div class="flex flex-col gap-3 border-b border-slate-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-bold text-slate-800">Aktivitas Belajar Terbaru</h2>
                <p class="mt-1 text-sm text-slate-500">
                    Riwayat pengerjaan quiz anak.
                </p>
            </div>

            <a href="{{ route('orangtua.riwayat-quiz') }}"
                class="inline-flex items-center justify-center gap-2 self-start rounded-lg border border-indigo-200 px-3 py-2 text-sm font-semibold text-indigo-600 transition hover:bg-indigo-50 sm:self-center">
                Lihat Semua Riwayat
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M5 12h14m-6-6l6 6-6 6" />
                </svg>
            </a>
        </div>

        @if($aktivitas->isEmpty())
        <div class="px-5 py-12 text-center">
            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-slate-50">
                <svg class="h-6 w-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M9 5h-2a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2" />
                </svg>
            </div>
            <p class="mt-3 text-sm font-semibold text-slate-700">Belum Ada Aktivitas</p>
            <p class="mt-1 text-sm text-slate-500">
                Aktivitas belajar akan muncul setelah anak mengerjakan quiz.
            </p>
        </div>
        @else
        <div class="divide-y divide-slate-100">
            @foreach($aktivitas->take(5) as $item)
            @php
            $waktu = $item['waktu'] instanceof \Carbon\Carbon
            ? $item['waktu']
            : \Carbon\Carbon::parse($item['waktu']);

            $lulus = $item['status'] === 'Tuntas';
            $remedial = $item['status'] === 'Remedial';
            @endphp

            <div class="flex flex-col gap-3 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex min-w-0 items-start gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl
                                    {{ $lulus ? 'bg-emerald-50' : ($remedial ? 'bg-rose-50' : 'bg-slate-50') }}">
                        <svg class="h-5 w-5 {{ $lulus ? 'text-emerald-600' : ($remedial ? 'text-rose-600' : 'text-slate-500') }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M9 5h-2a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2" />
                        </svg>
                    </div>

                    <div class="min-w-0">
                        <p class="truncate text-sm font-semibold text-slate-800">
                            {{ $item['judul_quiz'] }}
                        </p>
                        <p class="mt-1 text-xs text-slate-500">
                            {{ $item['tipe'] }} · {{ $waktu->translatedFormat('d M Y, H:i') }}
                        </p>
                    </div>
                </div>

                <div class="flex items-center justify-between gap-4 sm:justify-end">
                    <div class="text-left sm:text-right">
                        <p class="text-sm font-bold text-slate-800">
                            {{ number_format($item['nilai'], 1, ',', '.') }}
                        </p>
                        <p class="text-xs text-slate-500">
                            {{ $item['poin_didapat'] }} / {{ $item['total_poin'] }} poin
                        </p>
                    </div>

                    <span class="inline-flex shrink-0 rounded-full px-3 py-1 text-xs font-semibold
                                    {{ $lulus ? 'bg-emerald-50 text-emerald-700' : ($remedial ? 'bg-rose-50 text-rose-700' : 'bg-blue-50 text-blue-700') }}">
                        {{ $item['status'] }}
                    </span>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </section>

    {{-- Informasi tambahan --}}
    @php
    $perluPerhatian = $aktivitas->contains(function ($item) {
    return $item['status'] === 'Remedial';
    });
    @endphp

    <section class="rounded-2xl border p-5
            {{ $perluPerhatian ? 'border-amber-200 bg-amber-50/60' : 'border-slate-200 bg-white' }}">
        <div class="flex items-start gap-3">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl
                    {{ $perluPerhatian ? 'bg-amber-100' : 'bg-indigo-50' }}">
                <svg class="h-5 w-5 {{ $perluPerhatian ? 'text-amber-700' : 'text-indigo-600' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M12 9v4m0 4h.01M10.3 3.9L2.5 17.4A1.8 1.8 0 004.1 20h15.8a1.8 1.8 0 001.6-2.6L13.7 3.9a1.9 1.9 0 00-3.4 0z" />
                </svg>
            </div>

            <div>
                <h2 class="font-bold text-slate-800">
                    {{ $perluPerhatian ? 'Perlu Perhatian' : 'Pendampingan Belajar' }}
                </h2>

                <p class="mt-1 text-sm leading-relaxed text-slate-600">
                    @if($perluPerhatian)
                    Ada hasil quiz berstatus remedial pada aktivitas terbaru.
                    Orang tua dapat mendampingi anak mengulang materi dan meninjau hasil quiz.
                    @else
                    Dampingi anak belajar secara rutin dan tinjau hasil quiznya untuk mengetahui
                    materi yang masih perlu dipelajari kembali.
                    @endif
                </p>

                <a href="{{ route('orangtua.riwayat-quiz') }}"
                    class="mt-3 inline-flex items-center gap-1 text-sm font-semibold text-indigo-600 hover:text-indigo-800">
                    Buka Riwayat Quiz
                    <span aria-hidden="true">→</span>
                </a>
            </div>
        </div>
    </section>

    @endif
</div>
@endsection