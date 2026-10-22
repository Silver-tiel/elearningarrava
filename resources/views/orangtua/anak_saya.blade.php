@extends('layouts.orangtua')
@include('components.page-loader')

@section('title', 'Anak Saya - Portal Orang Tua')
@section('breadcrumb', 'Anak Saya')

@section('content')
<div class="px-4 sm:px-6 py-6 max-w-[1400px] mx-auto">

    {{-- JUDUL --}}
    <div class="mb-6">
        <p class="text-[10px] font-bold uppercase tracking-widest text-[#082f9f]">
            Portal Akademik Terpadu
            <span class="text-sky-500">●</span>
            <span class="font-normal normal-case tracking-normal text-slate-400">
                Sistem Penjaminan Mutu Pembelajaran
            </span>
        </p>

        <h1 class="mt-1.5 text-[28px] font-bold tracking-tight text-slate-900">
            Anak Saya
        </h1>

        <p class="mt-1 max-w-2xl text-sm leading-6 text-slate-500">
            Kelola dan pantau profil ananda yang terdaftar di Arrava E-Learning.
            Akses rekapitulasi akademik, capaian belajar, dan riwayat aktivitas siswa secara terpadu.
        </p>
    </div>

    {{-- RINGKASAN DAN FILTER --}}
    <div class="mb-6 flex flex-col justify-between gap-4 xl:flex-row xl:items-center">

        <div class="flex flex-wrap items-center gap-2 text-xs text-slate-600">
            <span class="inline-flex items-center gap-1.5 rounded-full bg-indigo-50 px-3 py-1.5 font-semibold text-indigo-700">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
                    <circle cx="9" cy="7" r="3"/>
                    <circle cx="17" cy="8" r="2.5"/>
                    <path d="M3 19v-2a6 6 0 0 1 12 0v2H3ZM15 13a5 5 0 0 1 6 5v1h-4v-2a8 8 0 0 0-2-4Z"/>
                </svg>
                {{ $siswaList->count() }} Siswa Aktif
            </span>

            <span class="text-slate-300">●</span>
            <span class="text-slate-500">Tahun Ajaran Aktif</span>
            <span class="font-semibold text-slate-700">2024/2025</span>
        </div>

        <form method="GET" action="{{ route('orangtua.anak-saya') }}">
            <select name="jenjang" onchange="this.form.submit()"
                    class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2 text-xs text-slate-700 outline-none transition focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 sm:w-56">
                <option value="">Semua Jenjang Pendidikan</option>

                @foreach ($jenjangList as $jenjang)
                    <option value="{{ $jenjang->id_jenjang }}"
                        @selected((string) $jenjangAktif === (string) $jenjang->id_jenjang)>
                        {{ $jenjang->nama_tipe }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>

    {{-- KARTU ANAK --}}
    @if ($siswaList->isEmpty())

        <div class="rounded-xl border border-dashed border-indigo-200 bg-white px-6 py-16 text-center">
            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-indigo-50 text-indigo-600">
                <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
            </div>
            <h2 class="mt-4 text-base font-semibold text-slate-900">Belum ada data anak</h2>
            <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">
                Pastikan akun siswa telah dihubungkan dengan akun orang tua
                melalui data relasi orangtua_siswa.
            </p>
        </div>

    @else

        <div class="grid grid-cols-1 items-stretch gap-5 2xl:grid-cols-2">

            @foreach ($siswaList as $index => $siswa)

                @php
                    $nama    = $siswa->nama ?? 'Siswa';
                    $inisial = collect(explode(' ', trim($nama)))
                        ->filter()
                        ->take(2)
                        ->map(fn ($k) => mb_strtoupper(mb_substr($k, 0, 1)))
                        ->implode('');

                    $poin = (int) ($siswa->total_poin ?? 0);

                    $aktivitas = $siswa->aktivitas_terakhir
                        ? \Illuminate\Support\Carbon::parse($siswa->aktivitas_terakhir)
                            ->translatedFormat('d M Y, H:i') . ' WIB'
                        : 'Belum ada aktivitas';

                    // Warna avatar bergantian
                    $avatarClass = $index % 2 === 0 ? 'bg-indigo-600 text-white' : 'bg-teal-700 text-white';
                    $barClass    = $index % 2 === 0 ? 'bg-indigo-600'            : 'bg-teal-700';

                    // Label kurikulum berdasarkan nama jenjang (kolom: nama_tipe)
                    $namaJenjang = strtolower($siswa->jenjang->nama_tipe ?? '');
                    if (str_contains($namaJenjang, 'sd') || str_contains($namaJenjang, 'dasar')) {
                        $labelKurikulum = 'Ketuntasan Kurikulum Sekolah Dasar';
                    } elseif (str_contains($namaJenjang, 'sma') || str_contains($namaJenjang, 'atas')) {
                        $labelKurikulum = 'Ketuntasan Kurikulum Merdeka';
                    } else {
                        $labelKurikulum = 'Ketuntasan Kurikulum Merdeka';
                    }

                    // Kolom metrik ke-3: card genap → PRESENSI/KUIS, card ganjil → POIN PEMBELAJARAN
                    $showPresensi = ($index % 2 === 0);
                @endphp

                <article class="stat-card flex min-w-0 flex-col overflow-hidden rounded-xl border border-slate-100 bg-white shadow-sm">

                    <div class="px-5 pt-5 sm:px-6 sm:pt-6">

                        {{-- IDENTITAS SISWA --}}
                        <div class="flex items-start gap-4">

                            <div class="relative flex h-14 w-14 shrink-0 items-center justify-center rounded-xl text-xl font-bold {{ $avatarClass }}">
                                {{ $inisial ?: 'S' }}
                                <span class="absolute -bottom-1 -right-1 flex h-[18px] w-[18px] items-center justify-center rounded-full border-2 border-white bg-sky-600 text-[9px] font-bold text-white">✓</span>
                            </div>

                            <div class="min-w-0 flex-1">
                                <div class="flex flex-col justify-between gap-1.5 sm:flex-row sm:items-start">
                                    <h2 class="break-words text-[15px] font-semibold leading-6 text-slate-900">{{ $nama }}</h2>
                                    <span class="w-fit shrink-0 rounded-full bg-indigo-100 px-3 py-1 text-[10px] font-semibold text-indigo-700">
                                        Semester Ganjil
                                    </span>
                                </div>

                                <p class="mt-0.5 text-xs font-semibold text-sky-700">
                                    Kelas {{ $siswa->kelas ?? '-' }}
                                    <span class="mx-1 text-slate-300">•</span>
                                    NISN: {{ $siswa->nisn ?: '-' }}
                                    <span class="mx-1 text-slate-300">•</span>
                                </p>

                                <p class="mt-0.5 break-words text-xs text-slate-400">
                                    {{ $siswa->asal_sekolah ?: '-' }}
                                </p>
                            </div>
                        </div>

                        {{-- METRIK --}}
                        <div class="mt-4 grid grid-cols-3 gap-2 rounded-xl bg-slate-50 border border-slate-100 p-3 sm:gap-3 sm:p-4">

                            {{-- Rata-rata Nilai --}}
                            <div class="min-w-0">
                                <p class="min-h-[28px] text-[9px] font-bold leading-4 uppercase tracking-wide text-slate-400 sm:text-[10px]">
                                    Rata-Rata Nilai
                                </p>
                                <p class="mt-0.5 text-2xl font-extrabold tracking-tight text-slate-900 sm:text-[28px]">
                                    {{ number_format($siswa->rata_rata_nilai, 1) }}
                                    <span class="text-[11px] font-semibold text-slate-400">/100</span>
                                </p>
                                @if ($siswa->di_atas_target)
                                    <p class="mt-0.5 text-[10px] font-semibold text-emerald-600">
                                        @if ($showPresensi)
                                            ↗ +{{ $siswa->kkm_selisih }} KKM
                                        @else
                                            ☆ Di Atas Target
                                        @endif
                                    </p>
                                @else
                                    <p class="mt-0.5 text-[10px] font-semibold text-red-500">
                                        ↘ {{ $siswa->kkm_selisih }} KKM
                                    </p>
                                @endif
                            </div>

                            {{-- Progres Modul --}}
                            <div class="min-w-0">
                                <p class="min-h-[28px] text-[9px] font-bold leading-4 uppercase tracking-wide text-slate-400 sm:text-[10px]">
                                    Progres Modul
                                </p>
                                <p class="mt-0.5 text-2xl font-extrabold tracking-tight text-slate-900 sm:text-[28px]">
                                    {{ $siswa->progres_modul }}%
                                </p>
                                <p class="mt-0.5 break-words text-[10px] text-slate-400">
                                    {{ $siswa->modul_selesai }} / {{ $siswa->total_modul }} Modul
                                </p>
                            </div>

                            {{-- Kolom ke-3 bergantian --}}
                            @if ($showPresensi)
                                <div class="min-w-0">
                                    <p class="min-h-[28px] text-[9px] font-bold leading-4 uppercase tracking-wide text-slate-400 sm:text-[10px]">
                                        Presensi / Kuis
                                    </p>
                                    <p class="mt-0.5 text-2xl font-extrabold tracking-tight text-slate-900 sm:text-[28px]">
                                        {{ $siswa->presensi_persen }}%
                                    </p>
                                    <p class="mt-0.5 text-[10px] font-semibold text-sky-700">
                                        {{ $siswa->label_kehadiran }}
                                    </p>
                                </div>
                            @else
                                <div class="min-w-0">
                                    <p class="min-h-[28px] text-[9px] font-bold leading-4 uppercase tracking-wide text-slate-400 sm:text-[10px]">
                                        Poin<br>Pembelajaran
                                    </p>
                                    <p class="mt-0.5 break-words text-2xl font-extrabold tracking-tight text-slate-900 sm:text-[28px]">
                                        {{ number_format($poin) }}
                                        <span class="text-[11px] font-semibold text-amber-600">XP</span>
                                    </p>
                                    <p class="mt-0.5 text-[10px] font-semibold text-sky-700">
                                        {{ $siswa->jumlah_lencana }} Lencana
                                    </p>
                                </div>
                            @endif
                        </div>

                        {{-- PROGRES BAR --}}
                        <div class="mt-4">
                            <div class="flex flex-wrap items-start justify-between gap-1 text-[10px] font-semibold text-slate-600">
                                <span>{{ $labelKurikulum }}</span>
                                <span>{{ $siswa->modul_selesai }} dari {{ $siswa->total_modul }} Capaian Pembelajaran</span>
                            </div>
                            <div class="mt-1.5 h-1.5 overflow-hidden rounded-full bg-slate-100">
                                <div class="progress-bar h-full rounded-full {{ $barClass }}"
                                     style="width: {{ $siswa->progres_modul }}%"></div>
                            </div>
                        </div>

                        {{-- WALI KELAS & STATUS --}}
                        <div class="mb-5 mt-4 flex flex-col justify-between gap-2 text-[11px] sm:flex-row sm:items-center">
                            <p class="flex items-center gap-1.5 text-slate-500">
                                <svg class="h-3.5 w-3.5 shrink-0 text-slate-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="8" r="4"/>
                                    <path d="M5 21v-2a7 7 0 0 1 14 0v2"/>
                                </svg>
                                Wali Kelas:
                                <span class="font-semibold text-slate-700">
                                    {{ $index % 2 === 0 ? 'Bpk. Hendra Gunawan, S.Pd.' : 'Ibu Nurlaila, M.Pd.' }}
                                </span>
                            </p>

                            <span class="inline-flex items-center gap-1.5 font-semibold text-sky-700">
                                <span class="h-2 w-2 rounded-full bg-sky-600"></span>
                                Status: Terdaftar Aktif
                            </span>
                        </div>
                    </div>

                    {{-- FOOTER KARTU --}}
                    <div class="mt-auto flex flex-col justify-between gap-3 border-t border-slate-100 bg-slate-50/60 px-5 py-3 sm:flex-row sm:items-center sm:px-6">
                        <p class="flex items-center gap-1.5 text-[10px] text-slate-400">
                            <svg class="h-3.5 w-3.5 shrink-0 text-indigo-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"/>
                                <path d="M12 6v6l4 2"/>
                            </svg>
                            Aktivitas Terakhir: {{ $aktivitas }}
                        </p>

                        <a href="{{ route('orangtua.dashboard', ['siswa_id' => $siswa->id_user]) }}"
                           class="inline-flex items-center justify-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-xs font-semibold text-white transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-300">
                            Lihat Perkembangan
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>
                </article>

            @endforeach
        </div>
    @endif

</div>
@endsection
