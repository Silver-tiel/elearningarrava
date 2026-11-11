@extends('layouts.siswa')

@section('header')
<div class="relative w-full max-w-[420px]">
    <svg class="absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-[#72839E]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/>
    </svg>
    <input type="text"
           placeholder="Cari modul, latihan, kuis, atau tutor..."
           class="h-10 w-full rounded-2xl bg-[#F0F6FF] border border-[#DCEFFF] pl-11 pr-4 text-sm text-[#12233F] outline-none placeholder:text-[#72839E] focus:bg-white focus:border-[#007FBE] focus:ring-2 focus:ring-[#DDF3FF] transition">
</div>
@endsection

@section('header-right')
    {{-- Notifikasi Presensi khusus Dashboard Siswa --}}
    <x-notifikasi-presensi :notifikasi="$notifikasiPresensi ?? []" :user-id="$user->id_user ?? 0" role="siswa" />
@endsection

@section('content')
@php
    /**
     * @var \App\Models\User $user
     * @var int $modulCount
     * @var int $quizCount
     * @var int $kuisLulus
     * @var \Illuminate\Database\Eloquent\Collection<int, \App\Models\Modul>|array $moduls
     * @var \Illuminate\Database\Eloquent\Collection<int, \App\Models\HasilQuizModul>|array $riwayatKuis
     * @var array $notifikasiPresensi
     */
@endphp
<div class="px-4 py-6 sm:px-8 sm:py-8 space-y-6 max-w-7xl mx-auto">
    @if(session('error'))
        <div class="rounded-2xl bg-red-50 border border-red-200 px-4 py-3 text-sm font-semibold text-red-700 shadow-sm">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div role="status" class="rounded-2xl bg-emerald-50 border border-emerald-200 px-4 py-3 text-sm font-semibold text-emerald-800 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    @php
        $queryHero = request()->query('hero');
        $activeHeroTheme = isset($user) && method_exists($user, 'resolvedHeroTheme')
            ? $user->resolvedHeroTheme(is_string($queryHero) ? $queryHero : null)
            : (in_array($queryHero, ['samudra', 'galaksi'], true) ? $queryHero : 'samudra');
    @endphp

    {{-- =======================================================================
         1. HERO SECTION (Mengikuti pilihan tema profil user atau preview ?hero=)
         ======================================================================= --}}
    @if($activeHeroTheme === 'galaksi')
        <x-galaksi-hero
            :user="$user"
            :kuis-lulus="$kuisLulus ?? 0"
            :modul-count="$modulCount ?? 0"
            :quiz-count="$quizCount ?? 0"
        />
    @else
        <x-samudra-hero
            :user="$user"
            :kuis-lulus="$kuisLulus ?? 0"
            :modul-count="$modulCount ?? 0"
            :quiz-count="$quizCount ?? 0"
        />
    @endif

    {{-- =======================================================================
         2. KARTU STATISTIK & MENU APLIKASI (Pintasan Materi, Quiz & Peringkat)
         ======================================================================= --}}
    @php
        $rankInfo = $user ? $user->rank_tier : [
            'current_rank' => 'Pemula',
            'current_badge_url' => null,
            'next_rank' => null,
            'next_badge_url' => null,
            'current_points' => 0,
            'next_points' => null,
            'points_needed' => 0,
            'percent' => 0,
            'is_max' => false,
        ];
    @endphp

    <!-- 1. Menu Pintasan Aplikasi (Materi, Quiz, Presensi, Peringkat) -->
    <div id="tourMenuPintasan" class="rounded-[22px] border-2 border-[#DCEFFF] bg-white p-5 sm:p-6 shadow-[0_4px_0_#B2E7FC]">
            <div class="flex items-center justify-between mb-3 pb-2.5 border-b border-[#F0F6FF]">
                <div class="flex items-center gap-2">
                    <span class="text-xs font-black uppercase tracking-wider text-[#72839E]">Menu Pintasan Belajar</span>
                </div>
                <span class="inline-flex items-center gap-1 text-[11px] font-bold text-[#007FBE] bg-[#DDF3FF] px-2.5 py-0.5 rounded-full border border-[#B2E7FC]">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#007FBE] animate-pulse"></span>
                    <span>Akses Cepat</span>
                </span>
            </div>

            <div class="grid grid-cols-4 gap-2 sm:gap-4 py-2 justify-items-center">
                <!-- 1. Materi Modul -->
                <a href="{{ route('siswa.modul') }}"
                   class="group flex flex-col items-center text-center transition-all">
                    <div class="relative flex h-16 w-16 sm:h-20 sm:w-20 items-center justify-center rounded-full bg-gradient-to-b from-[#EBF7FF] to-[#DDF3FF] border-2 border-[#B2E7FC] shadow-[0_4px_0_#007FBE] transition-all duration-200 group-hover:-translate-y-1 group-hover:shadow-[0_6px_0_#007FBE] group-hover:border-[#007FBE] group-active:translate-y-0.5 group-active:shadow-none">
                        <!-- Pixel Character Membaca -->
                        <div class="relative h-10 w-10 sm:h-12 sm:w-12 flex items-center justify-center overflow-hidden">
                            <img src="{{ asset('assets/foto_karakter/membacaDokumen/glasess_girl_readingl1.png') }}" 
                                 alt="Materi Tersedia" 
                                 style="image-rendering: pixelated;" 
                                 class="h-full w-full object-contain transition-opacity duration-150 group-hover:opacity-0">
                            <img src="{{ asset('assets/foto_karakter/membacaDokumen/glasess_girl_reading.gif') }}" 
                                 alt="Materi Tersedia Animasi" 
                                 style="image-rendering: pixelated;" 
                                 class="absolute inset-0 h-full w-full object-contain opacity-0 transition-opacity duration-150 group-hover:opacity-100">
                        </div>
                        <!-- Notification Badge -->
                        <span class="absolute -top-1 -right-1 flex h-6 min-w-[24px] px-1.5 items-center justify-center rounded-full bg-[#007FBE] text-white text-[11px] font-black shadow-sm border-2 border-white">
                            {{ $modulCount }}
                        </span>
                    </div>
                    <span class="mt-2.5 text-xs sm:text-sm font-black text-[#082765] group-hover:text-[#007FBE] transition">Materi</span>
                    <span class="text-[11px] font-bold text-[#72839E]">{{ $modulCount }} Modul</span>
                </a>

                <!-- 2. Quiz Latihan -->
                <a href="{{ route('siswa.quiz') }}"
                   class="group flex flex-col items-center text-center transition-all">
                    <div class="relative flex h-16 w-16 sm:h-20 sm:w-20 items-center justify-center rounded-full bg-gradient-to-b from-[#F0FDF4] to-[#DCFCE7] border-2 border-[#BBF7D0] shadow-[0_4px_0_#059669] transition-all duration-200 group-hover:-translate-y-1 group-hover:shadow-[0_6px_0_#059669] group-hover:border-[#059669] group-active:translate-y-0.5 group-active:shadow-none">
                        <!-- Pixel Character Quiz Girl -->
                        <div class="relative h-10 w-10 sm:h-12 sm:w-12 flex items-center justify-center overflow-hidden">
                            <img src="{{ asset('assets/foto_karakter/quiz/quizgirl1.png') }}" 
                                 alt="Kuis Tersedia" 
                                 style="image-rendering: pixelated;" 
                                 class="h-full w-full object-contain transition-opacity duration-150 group-hover:opacity-0">
                            <img src="{{ asset('assets/foto_karakter/quiz/quizgirl.gif') }}" 
                                 alt="Kuis Tersedia Animasi" 
                                 style="image-rendering: pixelated;" 
                                 class="absolute inset-0 h-full w-full object-contain opacity-0 transition-opacity duration-150 group-hover:opacity-100">
                        </div>
                        <!-- Notification Badge -->
                        <span class="absolute -top-1 -right-1 flex h-6 min-w-[24px] px-1.5 items-center justify-center rounded-full bg-[#059669] text-white text-[11px] font-black shadow-sm border-2 border-white">
                            {{ $quizCount }}
                        </span>
                    </div>
                    <span class="mt-2.5 text-xs sm:text-sm font-black text-[#082765] group-hover:text-[#059669] transition">Kuis</span>
                    <span class="text-[11px] font-bold text-[#72839E]">{{ $quizCount }} Kuis</span>
                </a>

                <!-- 3. Presensi QR -->
                <a href="{{ route('siswa.profil') }}"
                   class="group flex flex-col items-center text-center transition-all">
                    <div class="relative flex h-16 w-16 sm:h-20 sm:w-20 items-center justify-center rounded-full bg-gradient-to-b from-[#FFFBEB] to-[#FEF3C7] border-2 border-[#FDE68A] shadow-[0_4px_0_#D97706] transition-all duration-200 group-hover:-translate-y-1 group-hover:shadow-[0_6px_0_#D97706] group-hover:border-[#D97706] group-active:translate-y-0.5 group-active:shadow-none">
                        <svg class="h-6 w-6 sm:h-7 sm:w-7 text-[#D97706] transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                        </svg>
                    </div>
                    <span class="mt-2.5 text-xs sm:text-sm font-black text-[#082765] group-hover:text-[#D97706] transition">Presensi</span>
                    <span class="text-[11px] font-bold text-[#72839E]">QR Code</span>
                </a>

                <!-- 4. Peringkat / Leaderboard -->
                <a href="{{ route('siswa.leaderboard') }}"
                   class="group flex flex-col items-center text-center transition-all">
                    <div class="relative flex h-16 w-16 sm:h-20 sm:w-20 items-center justify-center rounded-full bg-gradient-to-b from-[#F3E8FF] to-[#EDE9FE] border-2 border-[#DDD6FE] shadow-[0_4px_0_#7C3AED] transition-all duration-200 group-hover:-translate-y-1 group-hover:shadow-[0_6px_0_#7C3AED] group-hover:border-[#7C3AED] group-active:translate-y-0.5 group-active:shadow-none">
                        <span class="text-2xl sm:text-3xl select-none transition-transform duration-200 group-hover:scale-110">🏆</span>
                    </div>
                    <span class="mt-2.5 text-xs sm:text-sm font-black text-[#082765] group-hover:text-[#7C3AED] transition">Peringkat</span>
                    <span class="text-[11px] font-bold text-[#72839E]">{{ $rankInfo['current_rank'] }}</span>
                </a>
            </div>
        </div>
    </div>    {{-- =======================================================================
         3. SPLIT SECTION: MATERI MODUL & RIWAYAT BELAJAR (Khas Arrava Mobile)
         ======================================================================= --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        <!-- Kolom Kiri (7 Cols): Materi Modul Pembelajaran -->
        <div id="tourMateriModul" class="lg:col-span-7 space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-base sm:text-lg font-black text-[#12233F] tracking-tight">Materi Modul Pembelajaran</h2>
                    <p class="text-xs text-[#72839E]">Lanjutkan materi belajar sesuai jenjang kamu.</p>
                </div>
                <a href="{{ route('siswa.modul') }}" class="inline-flex items-center gap-1 text-xs font-extrabold text-[#007FBE] hover:underline">
                    <span>Lihat Semua</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

            <div class="grid gap-3.5 sm:grid-cols-2">
                @forelse($moduls ?? [] as $index => $modul)
                    @php
                        /** @var \App\Models\Modul $modul */
                        $isVideo = ($modul->id_tipemodul == 1 || $modul->youtube_id);
                        $targetUrl = route('siswa.modul.materi', $modul->id_modul);
                        $colorOptions = [
                            ['bg' => 'bg-[#DDF3FF]', 'text' => 'text-[#007FBE]'],
                            ['bg' => 'bg-[#EEF2FF]', 'text' => 'text-[#4F46E5]'],
                            ['bg' => 'bg-[#DCFCE7]', 'text' => 'text-[#059669]'],
                            ['bg' => 'bg-[#FEF3C7]', 'text' => 'text-[#D97706]'],
                        ];
                        $col = $colorOptions[$index % count($colorOptions)];
                    @endphp
                    <a href="{{ $targetUrl }}"
                       class="group rounded-[20px] bg-white border border-[#DCEFFF] p-4 shadow-[0_3px_0_#B2E7FC] transition-all duration-200 hover:-translate-y-0.5 hover:shadow-[0_5px_0_#B2E7FC] flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3.5 min-w-0">
                            <!-- Icon Box -->
                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl {{ $col['bg'] }} {{ $col['text'] }} transition group-hover:scale-105">
                                @if($isVideo)
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                @else
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 16.5 5c1.747 0 3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                @endif
                            </div>

                            <div class="min-w-0">
                                <h3 class="text-xs sm:text-sm font-extrabold text-[#12233F] leading-snug line-clamp-2 group-hover:text-[#007FBE] transition">
                                    {{ $modul->judul_modul }}
                                </h3>
                                <div class="mt-1 flex items-center gap-1.5 flex-wrap">
                                    <span class="rounded-md bg-[#F1F5F9] px-2 py-0.5 text-[10px] font-bold text-[#64748B]">
                                        {{ $isVideo ? 'Video' : ($modul->tipeModul?->nama_tipe ?? 'Materi') }}
                                    </span>
                                    <span class="rounded-md bg-[#EFF6FF] px-2 py-0.5 text-[10px] font-bold text-[#007FBE]">
                                        {{ $modul->jenjang?->nama_tipe ?? $modul->jenjang?->nama_jenjang ?? 'Semua' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <svg class="w-4 h-4 text-[#94A3B8] shrink-0 group-hover:text-[#007FBE] group-hover:translate-x-0.5 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                @empty
                    <div class="col-span-full rounded-[20px] border border-dashed border-[#DCEFFF] bg-white p-8 text-center">
                        <p class="text-xs font-semibold text-[#72839E]">Belum ada modul materi tersedia untuk jenjang Anda.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Kolom Kanan (5 Cols): Riwayat Belajar & Kuis + Tips Belajar -->
        <div id="tourRiwayatKuis" class="lg:col-span-5 space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-base sm:text-lg font-black text-[#12233F] tracking-tight">Riwayat Belajar &amp; Kuis</h2>
                    <p class="text-xs text-[#72839E]">Aktivitas pengerjaan kuis terbaru kamu.</p>
                </div>
                @if(count($riwayatKuis ?? []) > 0)
                    <span class="text-xs font-bold text-[#72839E]">{{ count($riwayatKuis) }} aktivitas</span>
                @endif
            </div>

            <div class="space-y-3">
                @forelse($riwayatKuis ?? [] as $riwayat)
                    @php
                        /** @var \App\Models\HasilQuizModul $riwayat */
                        $isLulus = (bool) ($riwayat->is_lulus ?? false);
                        $nilai = (int) ($riwayat->total_poin ?? 0) > 0
                            ? round(($riwayat->poin_didapat / $riwayat->total_poin) * 100)
                            : 0;
                    @endphp
                    <div class="rounded-[18px] bg-white border border-[#DCEFFF] p-3.5 shadow-[0_3px_0_#B2E7FC] flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3 min-w-0">
                            <!-- Icon Status -->
                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl {{ $isLulus ? 'bg-[#DCFCE7] text-[#059669]' : 'bg-[#FEF3C7] text-[#D97706]' }}">
                                @if($isLulus)
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                    </svg>
                                @else
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                @endif
                            </div>

                            <div class="min-w-0">
                                <h4 class="text-xs sm:text-sm font-extrabold text-[#12233F] truncate">
                                    {{ $riwayat->quiz?->judul ?? 'Kuis Pembelajaran' }}
                                </h4>
                                <p class="text-[11px] font-semibold text-[#72839E]">
                                    {{ $riwayat->waktu_dapat ? \Illuminate\Support\Carbon::parse($riwayat->waktu_dapat)->diffForHumans() : ($riwayat->created_at?->diffForHumans() ?? '-') }}
                                </p>
                            </div>
                        </div>

                        <!-- Badge Skor -->
                        <div class="text-right shrink-0">
                            <span class="inline-block text-xs font-black {{ $isLulus ? 'text-[#059669]' : 'text-[#D97706]' }}">
                                {{ $nilai }}%
                            </span>
                            <p class="text-[10px] font-bold text-[#72839E]">
                                {{ $isLulus ? 'Lulus' : 'Belum Lulus' }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="rounded-[18px] bg-white border border-dashed border-[#DCEFFF] p-6 text-center">
                        <p class="text-xs font-semibold text-[#72839E]">Belum ada riwayat pengerjaan kuis.</p>
                        <p class="text-[11px] text-[#94A3B8] mt-1">Kerjakan kuis untuk mengumpulkan EXP dan melihat skormu di sini!</p>
                    </div>
                @endforelse


            </div>
        </div>
    </div>
</div>
@endsection
