
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anak Saya | Arrava E-Learning</title>

    {{-- Hapus link CDN ini jika Tailwind sudah dikompilasi oleh Vite --}}
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-[#f9f8ff] text-slate-800 antialiased">

<div class="min-h-screen">

    {{-- SIDEBAR --}}
    <aside class="fixed inset-y-0 left-0 z-30 hidden w-[220px] flex-col border-r border-slate-100 bg-white lg:flex">

        {{-- Brand --}}
        <div class="flex h-[72px] items-center gap-2.5 border-b border-slate-100 px-5">
            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#082f9f] text-white">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="m12 3 9 5-9 5-9-5 9-5Z"/>
                    <path d="M7 10v5c3 3 7 3 10 0v-5M21 8v6"/>
                </svg>
            </div>
            <div>
                <p class="text-[14px] font-bold tracking-tight text-[#082f9f]">Arrava E-Learning</p>
                <p class="text-[11px] text-slate-400">Portal Orang Tua</p>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto px-4 py-3">

            {{-- Profile chip --}}
            <div class="mb-3 flex items-center gap-2 rounded-lg bg-indigo-50 px-2 py-2">
                <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded bg-sky-400 text-xs font-bold text-white">
                    {{ mb_strtoupper(mb_substr($orangtua->nama ?? 'O', 0, 1)) }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="truncate text-xs font-semibold text-slate-800">{{ $orangtua->nama ?? 'Orang Tua' }}</p>
                    <p class="text-[10px] text-slate-400">Kelas {{ $orangtua->kelas ?? '-' }} • {{ $orangtua->asal_sekolah ?? 'SMP' }}</p>
                </div>
                <svg class="h-3.5 w-3.5 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="m7 10 5-5 5 5M7 14l5 5 5-5"/>
                </svg>
            </div>

            <nav class="space-y-0.5 text-[13px]">

                {{-- Dashboard --}}
                <a href="{{ route('orangtua.dashboard') }}"
                   class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-slate-500 hover:bg-slate-50 hover:text-slate-700">
                    <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="4" y="4" width="6" height="6" rx="1"/>
                        <rect x="14" y="4" width="6" height="6" rx="1"/>
                        <rect x="4" y="14" width="6" height="6" rx="1"/>
                        <rect x="14" y="14" width="6" height="6" rx="1"/>
                    </svg>
                    <span>Dashboard</span>
                </a>

                {{-- Anak Saya (aktif) --}}
                <a href="{{ route('orangtua.anak-saya') }}"
                   class="flex items-center gap-3 rounded-lg bg-[#2546b5] px-3 py-2.5 font-semibold text-white">
                    <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="10" cy="7" r="4"/>
                        <path d="M20 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                    <span>Anak Saya</span>
                </a>

                {{-- Separator Akademik --}}
                <div class="flex items-center gap-2 px-2 pb-1 pt-4 text-[10px] font-bold uppercase tracking-widest text-slate-400">
                    Akademik
                    <span class="h-px flex-1 bg-indigo-100"></span>
                </div>

                @php
                    $menuAkademik = [
                        ['label' => 'Perkembangan Nilai', 'svg' => '<path d="M3 17l4-8 4 5 4-3 4 6"/><path d="M3 17h18"/>'],
                        ['label' => 'Materi Pembelajaran', 'svg' => '<path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>'],
                        ['label' => 'Riwayat Kuis',       'svg' => '<path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>'],
                        ['label' => 'Pencapaian',          'svg' => '<path d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>'],
                        ['label' => 'Aktivitas Belajar',   'svg' => '<path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>'],
                    ];
                @endphp

                @foreach ($menuAkademik as $menu)
                    <a href="{{ route('orangtua.dashboard') }}"
                       class="flex items-center gap-3 rounded-lg px-3 py-2 text-slate-500 hover:bg-indigo-50 hover:text-[#1237b5]">
                        <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            {!! $menu['svg'] !!}
                        </svg>
                        <span>{{ $menu['label'] }}</span>
                    </a>
                @endforeach

                {{-- Separator Pengaturan --}}
                <div class="flex items-center gap-2 px-2 pb-1 pt-4 text-[10px] font-bold uppercase tracking-widest text-slate-400">
                    Pengaturan &amp; Akun
                    <span class="h-px flex-1 bg-indigo-100"></span>
                </div>

                <a href="#" class="flex items-center justify-between gap-3 rounded-lg px-3 py-2 text-slate-500 hover:bg-slate-50 hover:text-slate-700">
                    <span class="flex items-center gap-3">
                        <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        Notifikasi
                    </span>
                    <span class="flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-[10px] font-bold text-white">3</span>
                </a>

                <a href="#" class="flex items-center gap-3 rounded-lg px-3 py-2 text-slate-500 hover:bg-slate-50 hover:text-slate-700">
                    <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span>Pengaturan</span>
                </a>
            </nav>
        </div>

        {{-- Keluar --}}
        <div class="border-t border-slate-100 px-4 py-4">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                        class="flex items-center gap-3 text-sm font-semibold text-red-500 hover:text-red-700">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    {{-- KONTEN UTAMA --}}
    <main class="min-h-screen lg:ml-[220px]">

        {{-- HEADER --}}
        <header class="sticky top-0 z-20 flex h-[64px] items-center justify-between border-b border-slate-100 bg-white px-5 sm:px-8">
            <div class="text-xs text-slate-500 sm:text-[13px]">
                Portal Orang Tua
                <span class="mx-1 text-slate-300">›</span>
                <span class="font-semibold text-slate-800">Anak Saya</span>
            </div>

            <div class="flex items-center gap-3 sm:gap-4">
                <button type="button" aria-label="Notifikasi"
                        class="relative p-1.5 text-slate-500 hover:text-slate-700">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"/>
                        <path d="M10 21h4"/>
                    </svg>
                    <span class="absolute right-1 top-1 h-2 w-2 rounded-full bg-red-500"></span>
                </button>

                <div class="hidden h-7 w-px bg-slate-200 sm:block"></div>

                <div class="hidden text-right sm:block">
                    <p class="text-[13px] font-semibold text-slate-900">{{ $orangtua->nama ?? 'Orang Tua' }}</p>
                    <p class="mt-0.5 flex items-center justify-end gap-1 text-[11px] text-sky-700">
                        <svg class="h-3 w-3" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Wali Murid Terverifikasi
                    </p>
                </div>

                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-[#082f9f] text-white">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <circle cx="12" cy="8" r="4"/>
                        <path d="M5 21v-2a7 7 0 0 1 14 0v2"/>
                    </svg>
                </div>
            </div>
        </header>

        <div class="px-5 py-6 sm:px-8 sm:py-7">

            {{-- JUDUL --}}
            <div>
                <p class="text-[10px] font-bold uppercase tracking-widest text-[#082f9f]">
                    Portal Akademik Terpadu
                    <span class="text-sky-500">●</span>
                    <span class="font-normal normal-case tracking-normal text-slate-500">
                        Sistem Penjaminan Mutu Pembelajaran
                    </span>
                </p>

                <h1 class="mt-1.5 text-[32px] font-bold tracking-tight text-slate-900">
                    Anak Saya
                </h1>

                <p class="mt-1 max-w-2xl text-sm leading-6 text-slate-500">
                    Kelola dan pantau profil ananda yang terdaftar di Arrava E-Learning.
                    Akses rekapitulasi akademik, capaian belajar, dan riwayat aktivitas siswa secara terpadu.
                </p>
            </div>

            {{-- RINGKASAN DAN FILTER --}}
            <div class="mt-6 flex flex-col justify-between gap-4 xl:flex-row xl:items-center">

                <div class="flex flex-wrap items-center gap-2 text-xs text-slate-600">
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-indigo-50 px-3 py-1.5 font-semibold text-[#1237b5]">
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
                            class="w-full rounded-md border border-slate-200 bg-white px-4 py-2 text-xs text-slate-700 outline-none transition focus:border-blue-400 focus:ring-2 focus:ring-blue-100 sm:w-56">
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

                <div class="mt-7 rounded-xl border border-dashed border-indigo-200 bg-white px-6 py-16 text-center">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-indigo-50 text-[#1237b5]">
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

                <div class="mt-6 grid grid-cols-1 items-stretch gap-5 2xl:grid-cols-2">

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
                            $avatarClass = $index % 2 === 0
                                ? 'bg-[#082f9f] text-white'
                                : 'bg-teal-700 text-white';

                            $barClass = $index % 2 === 0 ? 'bg-[#082f9f]' : 'bg-teal-700';

                            // Label kurikulum berdasarkan nama jenjang (kolom: nama_tipe)
                            $namaJenjang = strtolower($siswa->jenjang->nama_tipe ?? '');
                            if (str_contains($namaJenjang, 'sd') || str_contains($namaJenjang, 'dasar')) {
                                $labelKurikulum = 'Ketuntasan Kurikulum Sekolah Dasar';
                            } elseif (str_contains($namaJenjang, 'sma') || str_contains($namaJenjang, 'ma') || str_contains($namaJenjang, 'atas')) {
                                $labelKurikulum = 'Ketuntasan Kurikulum Merdeka';
                            } else {
                                // SMP / default
                                $labelKurikulum = 'Ketuntasan Kurikulum Merdeka';
                            }

                            // Kolom metrik ke-3: card genap → PRESENSI/KUIS, card ganjil → POIN PEMBELAJARAN
                            $showPresensi = ($index % 2 === 0);
                        @endphp

                        <article class="flex min-w-0 flex-col overflow-hidden rounded-xl border border-slate-100 bg-white shadow-sm transition hover:shadow-md">

                            <div class="px-5 pt-5 sm:px-6 sm:pt-6">

                                {{-- IDENTITAS SISWA --}}
                                <div class="flex items-start gap-4">

                                    <div class="relative flex h-14 w-14 shrink-0 items-center justify-center rounded-lg text-xl font-bold {{ $avatarClass }}">
                                        {{ $inisial ?: 'S' }}
                                        <span class="absolute -bottom-1 -right-1 flex h-[18px] w-[18px] items-center justify-center rounded-full border-2 border-white bg-sky-600 text-[9px] font-bold text-white">
                                            ✓
                                        </span>
                                    </div>

                                    <div class="min-w-0 flex-1">
                                        <div class="flex flex-col justify-between gap-1.5 sm:flex-row sm:items-start">
                                            <h2 class="break-words text-[15px] font-semibold leading-6 text-slate-900">
                                                {{ $nama }}
                                            </h2>
                                            <span class="w-fit shrink-0 rounded-full bg-indigo-50 px-3 py-1 text-[10px] font-semibold text-[#1237b5]">
                                                Semester Ganjil
                                            </span>
                                        </div>

                                        <p class="mt-0.5 text-xs font-semibold text-sky-700">
                                            Kelas {{ $siswa->kelas ?? '-' }}
                                            <span class="mx-1 text-slate-300">•</span>
                                            NISN: {{ $siswa->nisn ?: '-' }}
                                            <span class="mx-1 text-slate-300">•</span>
                                        </p>

                                        <p class="mt-0.5 break-words text-xs text-slate-500">
                                            {{ $siswa->asal_sekolah ?: '-' }}
                                        </p>
                                    </div>
                                </div>

                                {{-- METRIK --}}
                                <div class="mt-4 grid grid-cols-3 gap-2 rounded-lg bg-[#f0f2ff] p-3 sm:gap-3 sm:p-4">

                                    {{-- Rata-rata Nilai --}}
                                    <div class="min-w-0">
                                        <p class="min-h-[28px] text-[9px] font-bold leading-4 tracking-wide text-slate-500 sm:text-[10px]">
                                            RATA-RATA NILAI
                                        </p>
                                        <p class="mt-0.5 text-2xl font-extrabold tracking-tight text-slate-900 sm:text-[28px]">
                                            {{ number_format($siswa->rata_rata_nilai, 1) }}
                                            <span class="text-xs font-semibold text-slate-400">/100</span>
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
                                            <p class="mt-0.5 text-[10px] font-semibold text-amber-500">
                                                ↘ {{ $siswa->kkm_selisih }} KKM
                                            </p>
                                        @endif
                                    </div>

                                    {{-- Progres Modul --}}
                                    <div class="min-w-0">
                                        <p class="min-h-[28px] text-[9px] font-bold leading-4 tracking-wide text-slate-500 sm:text-[10px]">
                                            PROGRES MODUL
                                        </p>
                                        <p class="mt-0.5 text-2xl font-extrabold tracking-tight text-slate-900 sm:text-[28px]">
                                            {{ $siswa->progres_modul }}%
                                        </p>
                                        <p class="mt-0.5 break-words text-[10px] text-slate-500">
                                            {{ $siswa->modul_selesai }} / {{ $siswa->total_modul }} Modul
                                        </p>
                                    </div>

                                    {{-- Kolom ke-3: berganti berdasarkan index --}}
                                    @if ($showPresensi)
                                        {{-- PRESENSI / KUIS --}}
                                        <div class="min-w-0">
                                            <p class="min-h-[28px] text-[9px] font-bold leading-4 tracking-wide text-slate-500 sm:text-[10px]">
                                                PRESENSI / KUIS
                                            </p>
                                            <p class="mt-0.5 text-2xl font-extrabold tracking-tight text-slate-900 sm:text-[28px]">
                                                {{ $siswa->presensi_persen }}%
                                            </p>
                                            <p class="mt-0.5 text-[10px] font-semibold text-sky-700">
                                                {{ $siswa->label_kehadiran }}
                                            </p>
                                        </div>
                                    @else
                                        {{-- POIN PEMBELAJARAN --}}
                                        <div class="min-w-0">
                                            <p class="min-h-[28px] text-[9px] font-bold leading-4 tracking-wide text-slate-500 sm:text-[10px]">
                                                POIN<br>PEMBELAJARAN
                                            </p>
                                            <p class="mt-0.5 break-words text-2xl font-extrabold tracking-tight text-slate-900 sm:text-[28px]">
                                                {{ number_format($poin) }}
                                                <span class="text-xs font-semibold text-slate-400">XP</span>
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
                                    <div class="mt-1.5 h-2 overflow-hidden rounded-full bg-indigo-100">
                                        <div class="h-full rounded-full transition-all duration-500 {{ $barClass }}"
                                             style="width: {{ $siswa->progres_modul }}%"></div>
                                    </div>
                                </div>

                                {{-- WALI KELAS & STATUS --}}
                                <div class="mb-5 mt-4 flex flex-col justify-between gap-2 text-[11px] sm:flex-row sm:items-center">
                                    <p class="flex items-center gap-1.5 leading-5 text-slate-600">
                                        <svg class="h-3.5 w-3.5 shrink-0 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <circle cx="12" cy="8" r="4"/>
                                            <path d="M5 21v-2a7 7 0 0 1 14 0v2"/>
                                        </svg>
                                        Wali Kelas:
                                        <span class="font-medium text-slate-800">
                                            {{ $index % 2 === 0 ? 'Bpk. Hendra Gunawan, S.Pd.' : 'Ibu Nurlaila, M.Pd.' }}
                                        </span>
                                    </p>

                                    <span class="inline-flex items-center gap-1.5 font-medium text-sky-700">
                                        <span class="h-2 w-2 rounded-full bg-sky-600"></span>
                                        Status: Terdaftar Aktif
                                    </span>
                                </div>
                            </div>

                            {{-- FOOTER KARTU --}}
                            <div class="mt-auto flex flex-col justify-between gap-3 border-t border-slate-100 bg-[#fafaff] px-5 py-3 sm:flex-row sm:items-center sm:px-6">
                                <p class="flex items-center gap-1.5 text-[10px] text-slate-500">
                                    <svg class="h-3.5 w-3.5 shrink-0 text-[#1237b5]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"/>
                                        <path d="M12 6v6l4 2"/>
                                    </svg>
                                    Aktivitas Terakhir: {{ $aktivitas }}
                                </p>

                                <a href="{{ route('orangtua.dashboard', ['siswa_id' => $siswa->id_user]) }}"
                                   class="inline-flex items-center justify-center gap-2 rounded bg-[#2546b5] px-4 py-2.5 text-xs font-semibold text-white transition hover:bg-[#1a3a9e] focus:outline-none focus:ring-2 focus:ring-blue-300">
                                    Lihat Perkembangan
                                    <span aria-hidden="true">→</span>
                                </a>
                            </div>
                        </article>

                    @endforeach
                </div>
            @endif

        </div>
    </main>
</div>

</body>
</html>
