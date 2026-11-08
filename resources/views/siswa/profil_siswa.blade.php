@extends('layouts.siswa')

@section('title', 'Profil Pengguna - Arrava')

@push('styles')
<style>
    #qr-svg svg { width: 100%; height: auto; display: block; }
    @media print {
        body * { visibility: hidden !important; }
        #kartu-qr, #kartu-qr * { visibility: visible !important; }
        #kartu-qr {
            position: absolute;
            left: 50% !important;
            top: 20px !important;
            transform: translateX(-50%) !important;
            width: 90mm !important;
            box-shadow: none !important;
            border: 1px solid #94a3b8 !important;
            background: #ffffff !important;
            border-radius: 16px !important;
            padding: 16px !important;
        }
        .no-print { display: none !important; }
    }
</style>
@endpush

@section('header')
    <div class="flex items-center justify-between gap-4">
        <h1 class="text-xl font-heading font-black text-[#082765]">Profil Pengguna 👤</h1>
        <div class="hidden w-full max-w-xs items-center gap-2 rounded-2xl border-2 border-[#DCEFFF] bg-[#F0F6FF] px-4 py-2 text-xs font-semibold text-[#72839E] md:flex shadow-[0_2px_0_#DCEFFF]">
            <svg class="h-4 w-4 shrink-0 text-[#72839E]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/>
            </svg>
            <span>Cari materi, tugas, atau kelas...</span>
        </div>
    </div>
@endsection

@section('content')
    <div class="min-h-full bg-[#F0F6FF] px-4 py-6 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-7xl">
            @if (session('success'))
                <div role="status" class="mb-5 rounded-2xl border-2 border-emerald-300 bg-emerald-50 px-4 py-3 text-sm font-bold text-emerald-800 shadow-[0_3px_0_#a7f3d0]">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div role="alert" class="mb-5 rounded-2xl border-2 border-red-300 bg-red-50 px-4 py-3 text-sm text-red-700 shadow-[0_3px_0_#fecaca]">
                    <p class="font-black">Profil belum dapat disimpan:</p>
                    <ul class="mt-1 list-inside list-disc font-semibold">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid items-start gap-6 xl:grid-cols-12">
                <div class="space-y-6 xl:col-span-7">
                    <section class="rounded-2xl sm:rounded-3xl border-2 border-[#DCEFFF] bg-white p-5 sm:p-6 shadow-[0_4px_0_#B2E7FC]">
                        <div class="flex flex-col gap-5 sm:flex-row sm:items-center">
                            <div class="h-20 w-20 shrink-0">
                                @if ($user->foto_profil && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->foto_profil))
                                    <img
                                        src="{{ \Illuminate\Support\Facades\Storage::url($user->foto_profil) }}"
                                        alt="Foto profil {{ $user->nama }}"
                                        class="h-20 w-20 rounded-2xl object-cover ring-4 ring-[#DDF3FF] shadow-sm"
                                    >
                                @else
                                    <div class="flex h-20 w-20 items-center justify-center rounded-2xl bg-[#DDF3FF] text-2xl font-black text-[#007FBE] ring-4 ring-[#DDF3FF] shadow-sm">
                                        {{ strtoupper(substr($user->username ?? 'U', 0, 1)) }}
                                    </div>
                                @endif
                            </div>

                            <div class="min-w-0 flex-1">
                                <h2 class="truncate text-xl font-heading font-black text-[#082765]">{{ $user->username ?: 'Username belum diatur' }}</h2>
                                <p class="mt-0.5 break-all text-sm font-semibold text-[#465673]">
                                    {{ $user->email }}
                                    <span class="px-1 text-[#B2E7FC]">•</span>
                                    {{ $user->jenjang->nama_tipe ?? 'Siswa Terdaftar' }}
                                </p>
                                <div class="mt-3 flex flex-wrap items-center gap-2.5">
                                    <span class="rounded-full bg-[#DDF3FF] px-3 py-1 text-xs font-bold text-[#007FBE] border border-[#B2E7FC]">Siswa</span>
                                    @php
                                        $rankInfo = $user->rank_tier;
                                    @endphp
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-3 py-1 text-xs font-black text-amber-800 border-2 border-amber-200 shadow-xs">
                                        @if($rankInfo['current_badge_url'])
                                            <img src="{{ $rankInfo['current_badge_url'] }}" alt="{{ $rankInfo['current_rank'] }}" class="h-3.5 w-3.5 object-contain">
                                        @else
                                            <span class="text-amber-500">★</span>
                                        @endif
                                        <span>Rank: {{ $rankInfo['current_rank'] }}</span>
                                    </span>
                                    <button
                                        type="button"
                                        data-open-profile-modal
                                        class="text-xs font-bold text-[#007FBE] underline underline-offset-2 hover:text-[#00679A] transition"
                                    >
                                        Edit Profil Saya
                                    </button>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="rounded-2xl sm:rounded-3xl border-2 border-[#DCEFFF] bg-white p-5 sm:p-6 shadow-[0_4px_0_#B2E7FC]">
                        <div class="mb-5 flex items-center justify-between gap-3">
                            <div>
                                <h2 class="text-base font-heading font-black text-[#082765]">Data Pribadi &amp; Sekolah</h2>
                                <p class="mt-0.5 text-xs font-semibold text-[#465673]">Informasi yang tersimpan pada akun Anda.</p>
                            </div>
                            <button
                                type="button"
                                data-open-profile-modal
                                class="shrink-0 rounded-xl border-2 border-[#B2E7FC] bg-white px-3.5 py-1.5 text-xs font-bold text-[#007FBE] shadow-[0_2px_0_#B2E7FC] hover:bg-[#F0F6FF] transition"
                            >
                                Edit Profil
                            </button>
                        </div>

                        <dl class="grid gap-4 sm:grid-cols-2">
                            <div class="rounded-xl bg-[#F0F6FF] p-3 border border-[#DCEFFF]">
                                <dt class="text-xs font-bold text-[#72839E]">Nama Lengkap</dt>
                                <dd class="mt-0.5 text-sm font-black text-[#082765]">{{ $user->nama ?: 'Belum diisi' }}</dd>
                            </div>
                            <div class="rounded-xl bg-[#F0F6FF] p-3 border border-[#DCEFFF]">
                                <dt class="text-xs font-bold text-[#72839E]">Email</dt>
                                <dd class="mt-0.5 break-all text-sm font-black text-[#082765]">{{ $user->email }}</dd>
                            </div>
                            <div class="rounded-xl bg-[#F0F6FF] p-3 border border-[#DCEFFF]">
                                <dt class="text-xs font-bold text-[#72839E]">Nomor Induk Siswa Nasional (NISN)</dt>
                                <dd class="mt-0.5 text-sm font-black text-[#082765]">{{ $user->nisn ?: 'Belum diisi' }}</dd>
                            </div>
                            <div class="rounded-xl bg-[#F0F6FF] p-3 border border-[#DCEFFF]">
                                <dt class="text-xs font-bold text-[#72839E]">Jenjang Akademik</dt>
                                <dd class="mt-0.5 text-sm font-black text-[#082765]">{{ $user->jenjang->nama_tipe ?? 'Belum diisi' }}</dd>
                            </div>
                            <div class="rounded-xl bg-[#F0F6FF] p-3 border border-[#DCEFFF]">
                                <dt class="text-xs font-bold text-[#72839E]">Asal Sekolah</dt>
                                <dd class="mt-0.5 text-sm font-black text-[#082765]">{{ $user->asal_sekolah ?: 'Belum diisi' }}</dd>
                            </div>
                            <div class="rounded-xl bg-[#F0F6FF] p-3 border border-[#DCEFFF]">
                                <dt class="text-xs font-bold text-[#72839E]">Nomor Handphone</dt>
                                <dd class="mt-0.5 text-sm font-black text-[#082765]">{{ $user->nomor_hp ?: 'Belum diisi' }}</dd>
                            </div>
                        </dl>
                    </section>

                    <!-- Kartu Presensi QR Siswa -->
                    <section id="kartu-qr" class="rounded-2xl sm:rounded-3xl border-2 border-[#DCEFFF] bg-white p-5 sm:p-6 shadow-[0_4px_0_#B2E7FC] scroll-mt-6">
                        <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between border-b border-[#DCEFFF] pb-4">
                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="rounded-full bg-[#DDF3FF] px-2.5 py-0.5 text-xs font-bold text-[#007FBE] border border-[#B2E7FC]">Presensi Siswa</span>
                                    <span class="text-xs font-semibold text-[#72839E]">Bimbel Arrava</span>
                                </div>
                                <h2 class="mt-1 text-base font-heading font-black text-[#082765]">QR Presensi Saya 📲</h2>
                                <p class="mt-0.5 text-xs font-semibold text-[#465673]">Tunjukkan kode QR ini kepada guru saat absensi kelas.</p>
                            </div>
                            <div class="no-print hidden sm:flex items-center gap-2 shrink-0">
                                <button id="btn-unduh-qr" type="button" class="inline-flex items-center gap-1.5 rounded-xl bg-[#007FBE] hover:bg-[#00679A] px-3.5 py-2 text-xs font-black text-white shadow-[0_3px_0_#005580] active:translate-y-0.5 active:shadow-none transition cursor-pointer">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                    <span>Unduh PNG</span>
                                </button>
                                <button id="btn-cetak-qr" type="button" class="inline-flex items-center gap-1.5 rounded-xl border-2 border-[#B2E7FC] bg-white px-3.5 py-2 text-xs font-bold text-[#007FBE] shadow-[0_2px_0_#B2E7FC] hover:bg-[#F0F6FF] transition cursor-pointer">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                    </svg>
                                    <span>Cetak</span>
                                </button>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row items-center gap-6 rounded-2xl bg-[#F0F6FF] p-5 border-2 border-[#DCEFFF]">
                            <div class="w-full max-w-[200px] shrink-0 bg-white p-3 rounded-2xl border-2 border-[#DCEFFF] shadow-[0_3px_0_#DCEFFF] flex items-center justify-center">
                                @if(!empty($qrSvg))
                                    <div id="qr-svg" class="w-full" role="img" aria-label="QR presensi milik {{ $user->nama }}">
                                        {!! $qrSvg !!}
                                    </div>
                                @else
                                    <div class="p-6 text-center text-xs font-semibold text-[#72839E]">QR belum tersedia</div>
                                @endif
                            </div>
                            <div class="flex-1 text-center sm:text-left min-w-0">
                                <h3 class="text-base font-heading font-black text-[#082765] truncate">{{ $user->nama }}</h3>
                                <p class="text-xs font-bold text-[#465673] mt-0.5">NISN: <span class="font-extrabold text-[#007FBE]">{{ $user->nisn ?: '—' }}</span></p>
                                
                                <div class="mt-3">
                                    <span class="text-[11px] font-bold text-[#72839E] uppercase tracking-wider">Kelas Terdaftar:</span>
                                    @if(isset($kelasList) && $kelasList->isNotEmpty())
                                        <div class="mt-1 flex flex-wrap gap-1.5 justify-center sm:justify-start">
                                            @foreach($kelasList as $kelasNama)
                                                <span class="inline-block rounded-xl bg-[#DDF3FF] border border-[#B2E7FC] px-2.5 py-1 text-xs font-bold text-[#007FBE]">{{ $kelasNama }}</span>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-xs text-[#72839E] italic mt-0.5">Belum terdaftar di kelas manapun.</p>
                                    @endif
                                </div>

                                <div class="mt-4 flex items-center justify-center sm:justify-start gap-1.5 text-xs font-semibold text-[#465673]">
                                    <svg class="h-3.5 w-3.5 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                    <span>QR token aman &amp; otomatis tersinkron</span>
                                </div>
                            </div>
                        </div>

                        <div class="no-print mt-4 grid grid-cols-2 gap-2.5 sm:hidden">
                            <button id="btn-unduh-qr-mobile" type="button" class="flex items-center justify-center gap-1.5 rounded-xl bg-[#007FBE] px-3 py-2.5 text-xs font-black text-white shadow-[0_3px_0_#005580] active:translate-y-0.5 active:shadow-none transition">
                                <span>Unduh PNG</span>
                            </button>
                            <button id="btn-cetak-qr-mobile" type="button" class="flex items-center justify-center gap-1.5 rounded-xl border-2 border-[#B2E7FC] bg-white px-3 py-2.5 text-xs font-bold text-[#007FBE] shadow-[0_2px_0_#B2E7FC] hover:bg-[#F0F6FF] transition">
                                <span>Cetak</span>
                            </button>
                        </div>
                        <p id="pesan-unduh-qr" class="no-print mt-2 text-xs text-red-600 hidden" role="alert">Gagal membuat berkas gambar. Silakan gunakan tombol cetak.</p>
                    </section>
                </div>

                <div class="space-y-6 xl:col-span-5">
                    <!-- Status Peringkat & Progres EXP -->
                    <section class="rounded-2xl sm:rounded-3xl border-2 border-[#DCEFFF] bg-white p-5 sm:p-6 shadow-[0_4px_0_#B2E7FC]">
                        <div class="flex items-center justify-between gap-3 border-b border-[#DCEFFF] pb-4">
                            <div>
                                <span class="text-xs font-bold uppercase tracking-wider text-[#72839E]">Tingkat Kemampuan</span>
                                <h2 class="text-base font-heading font-black text-[#082765]">Peringkat &amp; EXP Belajar ⭐</h2>
                            </div>
                            <div class="flex items-center gap-2">
                                <button type="button"
                                        onclick="window.showRankUpModal({ new_rank: '{{ $rankInfo['current_rank'] }}', old_rank: '{{ $rankInfo['current_rank'] === 'Pemula' ? '' : 'Pemula' }}', badge_url: '{{ $rankInfo['current_badge_url'] }}', poin: {{ (int) ($user->total_poin ?? 0) }} })"
                                        title="Putar animasi pencapaian rank"
                                        class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 hover:bg-amber-100 px-3 py-1 text-xs font-black text-amber-800 border-2 border-amber-200 shadow-xs transition cursor-pointer">
                                    <span>✦</span>
                                    <span>Animasi Rank</span>
                                </button>
                            </div>
                        </div>

                        <!-- Hero Rank Saat Ini -->
                        <div class="mt-4 flex items-center gap-4 rounded-2xl bg-[#F0F6FF] p-4 border-2 border-[#DCEFFF]">
                            @if($rankInfo['current_badge_url'])
                                <img src="{{ $rankInfo['current_badge_url'] }}" 
                                     alt="{{ $rankInfo['current_rank'] }}" 
                                     class="h-14 w-14 shrink-0 rounded-2xl object-contain bg-white p-1.5 shadow-sm ring-2 ring-[#B2E7FC]">
                            @else
                                <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-amber-100 text-amber-700 shadow-sm font-black text-2xl">
                                    ★
                                </div>
                            @endif
                            <div class="min-w-0 flex-1">
                                <span class="text-xs font-bold text-amber-800">Peringkat Saat Ini</span>
                                <h3 class="truncate text-lg font-heading font-black text-[#082765]">{{ $rankInfo['current_rank'] }}</h3>
                                <p class="text-xs font-bold text-[#465673]">
                                    Total Akumulasi: <span class="text-[#007FBE] font-black">{{ number_format($rankInfo['current_points']) }} EXP</span>
                                </p>
                            </div>
                        </div>

                        <!-- Bar Progress EXP dengan Widget Icon -->
                        <div class="mt-4">
                            <div class="flex items-center justify-between text-xs font-bold mb-1.5">
                                <span class="text-[#465673]">
                                    @if($rankInfo['is_max'])
                                        <span class="font-black text-emerald-600">Peringkat Tertinggi (MAX TIER) 👑</span>
                                    @else
                                        Menuju <strong class="text-[#082765]">{{ $rankInfo['next_rank'] }}</strong>
                                    @endif
                                </span>
                                <span class="font-black text-[#082765]">
                                    @if($rankInfo['is_max'])
                                        MAX ({{ number_format($rankInfo['current_points']) }} EXP)
                                    @else
                                        {{ number_format($rankInfo['current_points']) }} / {{ number_format($rankInfo['next_points']) }} EXP
                                    @endif
                                </span>
                            </div>

                            <!-- Baris EXP Bar dengan Icon Widget EXP di sebelahnya -->
                            <div class="flex items-center gap-2.5">
                                <img src="{{ asset('assets/widget/exp.png') }}" 
                                     alt="EXP" 
                                     title="EXP Widget"
                                     class="h-7 w-7 shrink-0 object-contain select-none"
                                     style="image-rendering: pixelated;">

                                <!-- Track Progress Bar -->
                                <div class="relative h-3.5 flex-1 overflow-hidden rounded-full bg-[#DDF3FF] border border-[#B2E7FC]">
                                    <div class="h-full rounded-full bg-gradient-to-r from-amber-400 via-orange-400 to-amber-500 transition-all duration-500 shadow-sm"
                                         style="width: {{ $rankInfo['percent'] }}%;">
                                    </div>
                                </div>

                                <!-- Persentase -->
                                <span class="shrink-0 text-xs font-black text-amber-600 min-w-[36px] text-right">
                                    {{ $rankInfo['percent'] }}%
                                </span>
                            </div>

                            <div class="mt-2 flex items-center justify-between text-xs font-semibold text-[#72839E]">
                                @if($rankInfo['is_max'])
                                    <span class="text-emerald-600 font-bold">Luar biasa! Kamu sudah membuka semua tanda penghargaan.</span>
                                @else
                                    <span>Kurang <strong class="text-[#007FBE]">{{ number_format($rankInfo['points_needed']) }} EXP</strong> lagi</span>
                                    <span>{{ $rankInfo['percent'] }}% menuju pangkat baru</span>
                                @endif
                            </div>
                        </div>
                    </section>

                    <section class="rounded-2xl sm:rounded-3xl border-2 border-[#DCEFFF] bg-white p-5 sm:p-6 shadow-[0_4px_0_#B2E7FC]">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <h2 class="text-base font-heading font-black text-[#082765]">Perkembangan Pengerjaan Kuis 📈</h2>
                                <p class="mt-0.5 text-xs font-semibold text-[#465673]">Jumlah kuis yang dikerjakan setiap hari.</p>
                            </div>
                            <button type="button" data-open-quiz-history class="inline-flex shrink-0 items-center gap-2 rounded-xl border-2 border-[#B2E7FC] bg-white px-3.5 py-1.5 text-xs font-bold text-[#007FBE] shadow-[0_2px_0_#B2E7FC] hover:bg-[#F0F6FF] transition">
                                <span class="hidden sm:inline">Lihat selengkapnya</span>
                                <span class="sm:hidden">Riwayat</span>
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path d="M5 12h14m-7-7 7 7-7 7"/>
                                </svg>
                            </button>
                        </div>

                        @if ($scoreTrend->isNotEmpty())
                            @php
                                $chartWidth = 600;
                                $chartLeft = 52;
                                $chartRight = 20;
                                $chartTop = 26;
                                $chartBottom = 190;
                                $plotWidth = $chartWidth - $chartLeft - $chartRight;
                                $plotHeight = $chartBottom - $chartTop;
                                $maxAttempts = max(1, (int) $scoreTrend->max('jumlah_pengerjaan'));
                                $tickStep = max(1, (int) ceil($maxAttempts / 5));
                                $yTicks = range(0, $maxAttempts, $tickStep);
                                if (end($yTicks) !== $maxAttempts) {
                                    $yTicks[] = $maxAttempts;
                                }
                            @endphp
                            <div class="mt-5 w-full" role="region" aria-label="Grafik jumlah kuis yang dikerjakan per tanggal">
                                <svg
                                    class="block h-auto w-full"
                                    viewBox="0 0 {{ $chartWidth }} 250"
                                    role="img"
                                    aria-label="Grafik jumlah pengerjaan kuis per hari"
                                >
                                    @foreach ($yTicks as $tick)
                                        @php $y = $chartBottom - ($tick / $maxAttempts * $plotHeight); @endphp
                                        <line x1="{{ $chartLeft }}" y1="{{ $y }}" x2="{{ $chartWidth - $chartRight }}" y2="{{ $y }}" stroke="#DCEFFF" stroke-dasharray="{{ $tick === 0 ? '0' : '3 4' }}"/>
                                        <text x="{{ $chartLeft - 8 }}" y="{{ $y + 4 }}" text-anchor="end" fill="#72839E" font-size="11" font-weight="600">{{ $tick }}</text>
                                    @endforeach
                                    <text x="14" y="{{ $chartTop + ($plotHeight / 2) }}" transform="rotate(-90 14 {{ $chartTop + ($plotHeight / 2) }})" text-anchor="middle" fill="#465673" font-size="11" font-weight="700">Jumlah pengerjaan</text>

                                    @foreach ($scoreTrend as $index => $point)
                                        @php
                                            $x = $chartLeft + ($scoreTrend->count() === 1 ? $plotWidth / 2 : $index / ($scoreTrend->count() - 1) * $plotWidth);
                                            $y = $chartBottom - ($point['jumlah_pengerjaan'] / $maxAttempts * $plotHeight);
                                            $previous = $index > 0 ? $scoreTrend[$index - 1] : null;
                                            $previousX = $index > 0
                                                ? $chartLeft + ($scoreTrend->count() === 1 ? $plotWidth / 2 : ($index - 1) / ($scoreTrend->count() - 1) * $plotWidth)
                                                : null;
                                            $previousY = $previous
                                                ? $chartBottom - ($previous['jumlah_pengerjaan'] / $maxAttempts * $plotHeight)
                                                : null;
                                        @endphp
                                        @if ($y !== null && $previousY !== null)
                                            <line x1="{{ $previousX }}" y1="{{ $previousY }}" x2="{{ $x }}" y2="{{ $y }}" stroke="#007FBE" stroke-width="3.5" stroke-linecap="round"/>
                                        @endif
                                        <circle cx="{{ $x }}" cy="{{ $y }}" r="5.5" fill="#007FBE" stroke="white" stroke-width="2.5">
                                            <title>{{ $point['detail'] }}: {{ $point['jumlah_pengerjaan'] }} pengerjaan</title>
                                        </circle>
                                        <text x="{{ $x }}" y="{{ $y - 11 }}" text-anchor="middle" fill="#082765" font-size="11" font-weight="800">{{ $point['jumlah_pengerjaan'] }}</text>
                                        @if ($scoreTrend->count() <= 7 || $index % max(1, (int) ceil($scoreTrend->count() / 6)) === 0 || $index === $scoreTrend->count() - 1)
                                            <text x="{{ $x }}" y="218" text-anchor="middle" fill="#465673" font-size="11" font-weight="600">{{ $point['tanggal'] }}</text>
                                        @endif
                                    @endforeach
                                    <text x="{{ $chartLeft + ($plotWidth / 2) }}" y="244" text-anchor="middle" fill="#72839E" font-size="11" font-weight="700">Tanggal</text>
                                </svg>
                            </div>
                            <p class="mt-2 text-xs font-semibold text-[#72839E]">Beberapa kuis yang dikerjakan pada tanggal yang sama dihitung sebagai satu titik.</p>
                        @else
                            <p class="mt-5 rounded-2xl bg-[#F0F6FF] border border-[#DCEFFF] px-4 py-8 text-center text-sm font-semibold text-[#72839E]">
                                Data pengerjaan akan tampil setelah Anda menyelesaikan kuis.
                            </p>
                        @endif

                        <div class="mt-4 flex flex-col gap-3 border-t border-[#DCEFFF] pt-4 sm:flex-row sm:items-center sm:justify-between">
                            <div class="grid flex-1 gap-3 text-sm sm:grid-cols-2">
                                <div class="flex items-center justify-between gap-4 bg-[#F0F6FF] p-2.5 rounded-xl border border-[#DCEFFF]">
                                    <span class="text-xs font-bold text-[#72839E]">Kuis diselesaikan</span>
                                    <span class="font-black text-[#082765]">{{ $scoreSummary->kuis_lulus ?? $scoreSummary->jumlah_kuis }}</span>
                                </div>
                                <div class="flex items-center justify-between gap-4 bg-[#F0F6FF] p-2.5 rounded-xl border border-[#DCEFFF]">
                                    <span class="text-xs font-bold text-[#72839E]">Total poin (EXP)</span>
                                    <span class="font-black text-[#007FBE]">{{ number_format($user->total_poin ?? 0) }} EXP</span>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="rounded-2xl sm:rounded-3xl border-2 border-[#DCEFFF] bg-white p-5 sm:p-6 shadow-[0_4px_0_#B2E7FC]">
                        <div class="flex items-center justify-between gap-3">
                            <h2 class="text-base font-heading font-black text-[#082765]">Tanda Penghargaan Milikmu 🏆</h2>
                            <span class="rounded-full bg-[#DDF3FF] border border-[#B2E7FC] px-2.5 py-0.5 text-xs font-bold text-[#007FBE]">{{ $achievements->count() }}</span>
                        </div>

                        @if ($achievements->isNotEmpty())
                            <ul class="mt-4 grid gap-3 sm:grid-cols-2">
                                @foreach ($achievements as $achievement)
                                    <li class="flex min-w-0 items-center gap-3 rounded-2xl bg-[#F0F6FF] border border-[#DCEFFF] p-3 transition hover:border-[#007FBE] hover:shadow-[0_3px_0_#B2E7FC]">
                                        @php
                                            $gambarAch = $achievement->achievement?->gambar_achivement;
                                        @endphp
                                        @if ($gambarAch && \Illuminate\Support\Facades\Storage::disk('public')->exists($gambarAch))
                                            <img src="{{ \Illuminate\Support\Facades\Storage::url($gambarAch) }}"
                                                 alt="{{ $achievement->nama }}"
                                                 class="h-10 w-10 shrink-0 rounded-xl object-cover ring-2 ring-[#B2E7FC] shadow-sm bg-white">
                                        @else
                                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-amber-100 text-amber-600 shadow-sm" aria-hidden="true">
                                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="m12 3 2.8 5.7 6.2.9-4.5 4.4 1.1 6.2-5.6-3-5.6 3 1.1-6.2L3 9.6l6.2-.9L12 3z"/>
                                                </svg>
                                            </span>
                                        @endif
                                        <div class="min-w-0">
                                            <p class="truncate text-xs font-black text-[#082765]">{{ $achievement->nama }}</p>
                                            <p class="mt-0.5 text-[11px] font-semibold text-[#72839E]">Diraih: {{ $achievement->waktu_pencapaian?->format('d M Y') }}</p>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="mt-4 rounded-2xl bg-[#F0F6FF] border border-[#DCEFFF] px-4 py-5 text-center text-sm font-semibold text-[#72839E]">
                                Belum ada penghargaan. Terus belajar untuk meraih pencapaian pertamamu!
                            </p>
                        @endif
                    </section>
                </div>
            </div>
        </div>
    </div>

    <dialog
        id="quiz-history-modal"
        aria-labelledby="quiz-history-title"
        class="m-auto max-h-[85vh] w-[calc(100%-2rem)] max-w-3xl overflow-hidden rounded-3xl p-0 shadow-2xl backdrop:bg-slate-900/60 border-2 border-[#DCEFFF]"
    >
        <div class="flex items-start justify-between gap-4 border-b-2 border-[#DCEFFF] bg-[#F0F6FF] px-6 py-4">
            <div>
                <h2 id="quiz-history-title" class="text-lg font-heading font-black text-[#082765]">Riwayat Nilai Kuis 📝</h2>
                <p class="mt-0.5 text-xs font-semibold text-[#465673]">Semua nilai kuis yang pernah kamu kerjakan.</p>
            </div>
            <button type="button" data-close-quiz-history aria-label="Tutup riwayat nilai" class="rounded-xl p-2 text-[#72839E] transition hover:bg-white hover:text-[#082765]">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path d="m6 6 12 12M18 6 6 18"/>
                </svg>
            </button>
        </div>

        <div class="max-h-[calc(85vh-5rem)] overflow-y-auto px-6 py-5 bg-white">
            @if ($quizResults->isEmpty())
                <p class="rounded-2xl bg-[#F0F6FF] border border-[#DCEFFF] px-4 py-8 text-center text-sm font-semibold text-[#72839E]">
                    Belum ada riwayat nilai kuis.
                </p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[520px] text-sm">
                        <thead>
                            <tr class="border-b-2 border-[#DCEFFF]">
                                <th class="pb-3 pr-4 text-left text-xs font-bold uppercase tracking-wider text-[#72839E]">Tanggal</th>
                                <th class="pb-3 pr-4 text-left text-xs font-bold uppercase tracking-wider text-[#72839E]">Nama kuis</th>
                                <th class="pb-3 pr-4 text-right text-xs font-bold uppercase tracking-wider text-[#72839E]">Nilai</th>
                                <th class="pb-3 text-right text-xs font-bold uppercase tracking-wider text-[#72839E]">Poin</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#DCEFFF]">
                            @foreach ($quizResults->reverse() as $hasil)
                                <tr>
                                    <td class="py-3.5 pr-4 text-xs font-semibold text-[#465673]">
                                        {{ \Illuminate\Support\Carbon::parse($hasil->waktu_dapat)->translatedFormat('d M Y, H:i') }}
                                    </td>
                                    <td class="py-3.5 pr-4 font-bold text-[#082765]">{{ $hasil->quiz?->judul ?? 'Kuis' }}</td>
                                    <td class="py-3.5 pr-4 text-right font-black text-[#007FBE]">
                                        {{ $hasil->nilai !== null ? number_format($hasil->nilai, 1) . '%' : '—' }}
                                    </td>
                                    <td class="py-3.5 text-right font-bold text-[#465673]">
                                        {{ $hasil->poin_didapat }}/{{ $hasil->total_poin }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </dialog>

    <dialog
        id="profile-edit-modal"
        aria-labelledby="profile-modal-title"
        data-open-on-load="{{ $errors->any() ? 'true' : 'false' }}"
        class="m-auto max-h-[90vh] w-[calc(100%-2rem)] max-w-2xl overflow-y-auto rounded-3xl p-0 shadow-2xl backdrop:bg-slate-900/60 border-2 border-[#DCEFFF]"
    >
        <div class="sticky top-0 z-10 flex items-start justify-between border-b-2 border-[#DCEFFF] bg-[#F0F6FF] px-6 py-4">
            <div>
                <h2 id="profile-modal-title" class="text-lg font-heading font-black text-[#082765]">Edit Profil ✏️</h2>
                <p class="mt-0.5 text-xs font-semibold text-[#465673]">Perbarui data pribadi dan sekolah Anda.</p>
            </div>
            <button type="button" data-close-profile-modal aria-label="Tutup popup" class="rounded-xl p-2 text-[#72839E] hover:bg-white hover:text-[#082765]">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path d="m6 6 12 12M18 6 6 18"/>
                </svg>
            </button>
        </div>

        <form action="{{ route('siswa.profil.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4 bg-white px-6 py-6">
            @csrf
            @method('PUT')

            <div>
                <label for="foto_profil" class="mb-1.5 block text-xs font-bold text-[#465673]">Foto Profil</label>
                <input
                    id="foto_profil"
                    name="foto_profil"
                    type="file"
                    accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                    class="block w-full rounded-xl border-2 border-[#DCEFFF] bg-[#F0F6FF] text-sm text-[#465673] file:mr-4 file:border-0 file:bg-[#DDF3FF] file:px-4 file:py-2.5 file:text-xs file:font-bold file:text-[#007FBE] hover:file:bg-[#B2E7FC]"
                >
                <p class="mt-1 text-xs font-semibold text-[#72839E]">JPG, PNG, atau WebP. Maksimal 2 MB.</p>
                @error('foto_profil')<p class="mt-1 text-xs font-bold text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="username" class="mb-1.5 block text-xs font-bold text-[#465673]">Username</label>
                <input
                    id="username"
                    name="username"
                    type="text"
                    value="{{ old('username', $user->username) }}"
                    autocomplete="username"
                    required
                    maxlength="50"
                    placeholder="Masukkan username"
                    class="h-11 w-full rounded-xl border-2 border-[#DCEFFF] bg-[#F0F6FF] px-3.5 text-sm font-semibold text-[#12233F] outline-none transition focus:border-[#007FBE] focus:bg-white focus:ring-4 focus:ring-[#DDF3FF]"
                >
                @error('username')<p class="mt-1 text-xs font-bold text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="nama" class="mb-1.5 block text-xs font-bold text-[#465673]">Nama Lengkap</label>
                <input
                    id="nama"
                    type="text"
                    value="{{ $user->nama }}"
                    readonly
                    aria-describedby="nama-readonly-note"
                    class="h-11 w-full cursor-not-allowed rounded-xl border-2 border-[#DCEFFF] bg-slate-100 px-3.5 text-sm font-bold text-[#72839E]"
                >
                <p id="nama-readonly-note" class="mt-1 text-xs font-semibold text-[#72839E]">Nama terikat ke akun dan tidak dapat diubah.</p>
            </div>

            <div>
                <label for="email" class="mb-1.5 block text-xs font-bold text-[#465673]">Email</label>
                <input
                    id="email"
                    type="email"
                    value="{{ $user->email }}"
                    readonly
                    aria-describedby="email-readonly-note"
                    class="h-11 w-full cursor-not-allowed rounded-xl border-2 border-[#DCEFFF] bg-slate-100 px-3.5 text-sm font-bold text-[#72839E]"
                >
                <p id="email-readonly-note" class="mt-1 text-xs font-semibold text-[#72839E]">Email terikat ke akun dan tidak dapat diubah.</p>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label for="nisn" class="mb-1.5 block text-xs font-bold text-[#465673]">Nomor Induk Siswa Nasional (NISN)</label>
                    <input
                        id="nisn"
                        type="text"
                        value="{{ $user->nisn }}"
                        readonly
                        aria-describedby="nisn-readonly-note"
                        class="h-11 w-full cursor-not-allowed rounded-xl border-2 border-[#DCEFFF] bg-slate-100 px-3.5 text-sm font-bold text-[#72839E]"
                    >
                    <p id="nisn-readonly-note" class="mt-1 text-xs font-semibold text-[#72839E]">NISN terikat ke data siswa dan tidak dapat diubah.</p>
                </div>

                <div>
                    <label for="id_jenjang" class="mb-1.5 block text-xs font-bold text-[#465673]">Jenjang Akademik</label>
                    <input
                        id="id_jenjang"
                        type="text"
                        value="{{ $user->jenjang->nama_tipe ?? 'Belum ditentukan' }}"
                        readonly
                        aria-describedby="jenjang-readonly-note"
                        class="h-11 w-full cursor-not-allowed rounded-xl border-2 border-[#DCEFFF] bg-slate-100 px-3.5 text-sm font-bold text-[#72839E]"
                    >
                    <p id="jenjang-readonly-note" class="mt-1 text-xs font-semibold text-[#72839E]">Jenjang akademik dikelola oleh pihak sekolah/sistem.</p>
                </div>
            </div>

            <div>
                <label for="nomor_hp" class="mb-1.5 block text-xs font-bold text-[#465673]">Nomor Handphone</label>
                <input
                    id="nomor_hp"
                    name="nomor_hp"
                    type="tel"
                    inputmode="tel"
                    value="{{ old('nomor_hp', $user->nomor_hp) }}"
                    maxlength="20"
                    class="h-11 w-full rounded-xl border-2 border-[#DCEFFF] bg-[#F0F6FF] px-3.5 text-sm font-semibold text-[#12233F] outline-none transition focus:border-[#007FBE] focus:bg-white focus:ring-4 focus:ring-[#DDF3FF]"
                >
                @error('nomor_hp')<p class="mt-1 text-xs font-bold text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="flex justify-end gap-3 border-t-2 border-[#DCEFFF] pt-4">
                <button type="button" data-close-profile-modal class="rounded-xl border-2 border-[#B2E7FC] bg-white px-4 py-2.5 text-sm font-bold text-[#007FBE] shadow-[0_2px_0_#B2E7FC] hover:bg-[#F0F6FF] transition">
                    Batal
                </button>
                <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-[#007FBE] hover:bg-[#00679A] px-5 py-2.5 text-sm font-black text-white shadow-[0_3px_0_#005580] active:translate-y-0.5 active:shadow-none transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </dialog>
@endsection

@push('scripts')
    <script>
        const profileEditModal = document.getElementById('profile-edit-modal');
        const quizHistoryModal = document.getElementById('quiz-history-modal');

        document.querySelectorAll('[data-open-profile-modal]').forEach((button) => {
            button.addEventListener('click', () => profileEditModal.showModal());
        });

        document.querySelectorAll('[data-open-quiz-history]').forEach((button) => {
            button.addEventListener('click', () => quizHistoryModal.showModal());
        });

        document.querySelectorAll('[data-close-profile-modal]').forEach((button) => {
            button.addEventListener('click', () => profileEditModal.close());
        });

        document.querySelectorAll('[data-close-quiz-history]').forEach((button) => {
            button.addEventListener('click', () => quizHistoryModal.close());
        });

        profileEditModal.addEventListener('click', (event) => {
            if (event.target === profileEditModal) profileEditModal.close();
        });

        quizHistoryModal.addEventListener('click', (event) => {
            if (event.target === quizHistoryModal) quizHistoryModal.close();
        });

        if (profileEditModal.dataset.openOnLoad === 'true') profileEditModal.showModal();

        // Download & Print QR Presensi
        (function () {
            var namaFile = 'qr-presensi-{{ \Illuminate\Support\Str::slug($user->nama) ?: 'siswa' }}.png';

            function cetakQr() {
                window.print();
            }

            function unduhQr() {
                var svg = document.querySelector('#qr-svg svg');
                var pesan = document.getElementById('pesan-unduh-qr');
                if (pesan) pesan.classList.add('hidden');
                if (!svg) {
                    if (pesan) pesan.classList.remove('hidden');
                    return;
                }

                svg.setAttribute('xmlns', 'http://www.w3.org/2000/svg');
                var xml = new XMLSerializer().serializeToString(svg);
                var img = new Image();
                img.onload = function () {
                    var ukuran = 900, pad = 50;
                    var canvas = document.createElement('canvas');
                    canvas.width = ukuran;
                    canvas.height = ukuran;
                    var ctx = canvas.getContext('2d');
                    ctx.fillStyle = '#ffffff';
                    ctx.fillRect(0, 0, ukuran, ukuran);
                    ctx.imageSmoothingEnabled = false;
                    ctx.drawImage(img, pad, pad, ukuran - pad * 2, ukuran - pad * 2);
                    canvas.toBlob(function (blob) {
                        if (!blob) {
                            if (pesan) pesan.classList.remove('hidden');
                            return;
                        }
                        var a = document.createElement('a');
                        a.href = URL.createObjectURL(blob);
                        a.download = namaFile;
                        document.body.appendChild(a);
                        a.click();
                        a.remove();
                        setTimeout(function () { URL.revokeObjectURL(a.href); }, 1000);
                    }, 'image/png');
                };
                img.onerror = function () {
                    if (pesan) pesan.classList.remove('hidden');
                };
                img.src = 'data:image/svg+xml;charset=utf-8,' + encodeURIComponent(xml);
            }

            var btnCetak = document.getElementById('btn-cetak-qr');
            var btnCetakMobile = document.getElementById('btn-cetak-qr-mobile');
            var btnUnduh = document.getElementById('btn-unduh-qr');
            var btnUnduhMobile = document.getElementById('btn-unduh-qr-mobile');

            if (btnCetak) btnCetak.addEventListener('click', cetakQr);
            if (btnCetakMobile) btnCetakMobile.addEventListener('click', cetakQr);
            if (btnUnduh) btnUnduh.addEventListener('click', unduhQr);
            if (btnUnduhMobile) btnUnduhMobile.addEventListener('click', unduhQr);
        })();
    </script>
@endpush