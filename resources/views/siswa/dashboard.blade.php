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
<div class="px-4 py-6 sm:px-8 sm:py-8 space-y-6 max-w-7xl mx-auto">
    @if(session('error'))
        <div class="rounded-2xl bg-red-50 border border-red-200 px-4 py-3 text-sm font-semibold text-red-700 shadow-sm">
            {{ session('error') }}
        </div>
    @endif

    {{-- =======================================================================
         1. SAMUDRA HERO SECTION (Menimpa: Avatar, Nama, Bar EXP & Ikan Piksel)
         ======================================================================= --}}
    <x-samudra-hero
        :user="$user"
        :kuis-lulus="$kuisLulus ?? 0"
        :modul-count="$modulCount ?? 0"
        :quiz-count="$quizCount ?? 0"
    />

    {{-- =======================================================================
         2. KARTU STATISTIK UTAMA (Materi, Quiz, Peringkat & EXP)
         ======================================================================= --}}
    <div class="grid gap-5 md:grid-cols-2 lg:grid-cols-3">
        <!-- 1. Materi Tersedia -->
        <a href="{{ route('siswa.modul') }}"
           class="group relative rounded-[22px] border border-[#DCEFFF] bg-white p-5 shadow-[0_4px_0_#B2E7FC] transition-all duration-200 hover:-translate-y-1 hover:shadow-[0_6px_0_#B2E7FC] flex flex-col justify-between overflow-hidden">
            <div class="relative z-10 flex items-center justify-between">
                <span class="text-xs font-extrabold uppercase tracking-wider text-[#72839E]">Materi Tersedia</span>
                <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-[#DDF3FF] text-[#007FBE]">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 16.5 5c1.747 0 3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </span>
            </div>
            <p class="relative z-10 mt-3 text-3xl font-black text-[#12233F]">{{ $modulCount }}</p>
            <div class="relative z-10 mt-4 flex items-center justify-between">
                <span class="text-xs font-extrabold text-[#007FBE] group-hover:underline">Buka modul →</span>
            </div>

            <!-- Karakter Animasi Membaca Dokumen -->
            <div class="pointer-events-none absolute bottom-1 right-2 h-28 w-28">
                <img src="{{ asset('assets/foto_karakter/membacaDokumen/glasess_girl_readingl1.png') }}" 
                     alt="Materi Tersedia" 
                     style="image-rendering: pixelated;" 
                     class="h-full w-full object-contain transition-opacity duration-150 group-hover:opacity-0">
                <img src="{{ asset('assets/foto_karakter/membacaDokumen/glasess_girl_reading.gif') }}" 
                     alt="Materi Tersedia Animasi" 
                     style="image-rendering: pixelated;" 
                     class="absolute inset-0 h-full w-full object-contain opacity-0 transition-opacity duration-150 group-hover:opacity-100">
            </div>
        </a>

        <!-- 2. Quiz Tersedia -->
        <a href="{{ route('siswa.quiz') }}"
           class="group relative rounded-[22px] border border-[#DCEFFF] bg-white p-5 shadow-[0_4px_0_#B2E7FC] transition-all duration-200 hover:-translate-y-1 hover:shadow-[0_6px_0_#B2E7FC] flex flex-col justify-between overflow-hidden">
            <div class="relative z-10 flex items-center justify-between">
                <span class="text-xs font-extrabold uppercase tracking-wider text-[#72839E]">Quiz Tersedia</span>
                <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-[#DCFCE7] text-[#059669]">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </span>
            </div>
            <p class="relative z-10 mt-3 text-3xl font-black text-[#12233F]">{{ $quizCount }}</p>
            <div class="relative z-10 mt-4 flex items-center justify-between">
                <span class="text-xs font-extrabold text-[#059669] group-hover:underline">Buka quiz →</span>
            </div>

            <!-- Karakter Animasi Quiz Girl -->
            <div class="pointer-events-none absolute bottom-1 right-2 h-28 w-28">
                <img src="{{ asset('assets/foto_karakter/quiz/quizgirl1.png') }}" 
                     alt="Quiz Tersedia" 
                     style="image-rendering: pixelated;" 
                     class="h-full w-full object-contain transition-opacity duration-150 group-hover:opacity-0">
                <img src="{{ asset('assets/foto_karakter/quiz/quizgirl.gif') }}" 
                     alt="Quiz Tersedia Animasi" 
                     style="image-rendering: pixelated;" 
                     class="absolute inset-0 h-full w-full object-contain opacity-0 transition-opacity duration-150 group-hover:opacity-100">
            </div>
        </a>

        <!-- 3. Peringkat & EXP -->
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
        <div class="rounded-[22px] border border-[#DCEFFF] bg-white p-5 shadow-[0_4px_0_#B2E7FC] transition-all duration-200 hover:-translate-y-1 hover:shadow-[0_6px_0_#B2E7FC] flex flex-col justify-between md:col-span-2 lg:col-span-1">
            <div>
                <div class="flex items-center justify-between gap-2">
                    <span class="text-xs font-extrabold uppercase tracking-wider text-[#72839E]">Peringkat &amp; EXP</span>
                    <a href="{{ route('siswa.profil') }}" class="inline-flex items-center gap-1.5 rounded-full bg-[#FEF3C7] px-2.5 py-1 text-xs font-extrabold text-[#B45309] border border-[#FDE68A] hover:bg-amber-100 transition shadow-xs">
                        @if($rankInfo['current_badge_url'])
                            <img src="{{ $rankInfo['current_badge_url'] }}" alt="{{ $rankInfo['current_rank'] }}" class="h-3.5 w-3.5 object-contain">
                        @else
                            <span class="text-[#D97706]">★</span>
                        @endif
                        <span>{{ $rankInfo['current_rank'] }}</span>
                    </a>
                </div>

                <div class="mt-2.5 flex items-baseline gap-2">
                    <p class="text-3xl font-black text-[#12233F]">{{ number_format($rankInfo['current_points']) }}</p>
                    <span class="text-xs font-extrabold uppercase tracking-wider text-[#72839E]">EXP</span>
                </div>

                <!-- Status target rank -->
                <div class="mt-2 flex items-center justify-between text-xs text-[#465673] font-semibold">
                    <span>
                        @if($rankInfo['is_max'])
                            <span class="font-extrabold text-emerald-600">Tingkat Tertinggi 👑</span>
                        @else
                            Menuju <strong class="text-[#12233F]">{{ $rankInfo['next_rank'] }}</strong>
                        @endif
                    </span>
                    <span class="font-extrabold text-[#12233F]">
                        @if($rankInfo['is_max'])
                            100%
                        @else
                            {{ number_format($rankInfo['current_points']) }} / {{ number_format($rankInfo['next_points']) }}
                        @endif
                    </span>
                </div>

                <!-- EXP Bar dengan Icon Widget EXP -->
                <div class="mt-1.5 flex items-center gap-2">
                    <img src="{{ asset('assets/widget/exp.png') }}" 
                         alt="EXP" 
                         title="EXP Poin"
                         class="h-6 w-6 shrink-0 object-contain select-none"
                         style="image-rendering: pixelated;">

                    <div class="relative h-2.5 flex-1 overflow-hidden rounded-full bg-[#F0F6FF] ring-1 ring-[#DCEFFF]">
                        <div class="h-full rounded-full bg-gradient-to-r from-amber-400 via-orange-400 to-amber-500 transition-all duration-500"
                             style="width: {{ $rankInfo['percent'] }}%;">
                        </div>
                    </div>

                    <span class="shrink-0 text-xs font-extrabold text-amber-600 min-w-[34px] text-right">
                        {{ $rankInfo['percent'] }}%
                    </span>
                </div>
            </div>

            <div class="mt-3.5 flex items-center justify-between border-t border-[#F0F6FF] pt-2.5 text-xs text-[#72839E]">
                @if($rankInfo['is_max'])
                    <span class="text-emerald-600 font-bold">Hebat! Semua tingkat terbuka.</span>
                @else
                    <span>Sisa <strong class="text-[#12233F]">{{ number_format($rankInfo['points_needed']) }} EXP</strong> lagi</span>
                @endif
                <a href="{{ route('siswa.profil') }}" class="font-extrabold text-[#007FBE] hover:underline">Detail rank →</a>
            </div>
        </div>
    </div>

    {{-- =======================================================================
         3. SPLIT SECTION: MATERI MODUL & RIWAYAT BELAJAR (Khas Arrava Mobile)
         ======================================================================= --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        <!-- Kolom Kiri (7 Cols): Materi Modul Pembelajaran -->
        <div class="lg:col-span-7 space-y-4">
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
                                        {{ $isVideo ? 'Video' : ($modul->tipeModul->nama_tipe ?? 'Materi') }}
                                    </span>
                                    <span class="rounded-md bg-[#EFF6FF] px-2 py-0.5 text-[10px] font-bold text-[#007FBE]">
                                        {{ $modul->jenjang->nama_tipe ?? $modul->jenjang->nama_jenjang ?? 'Semua' }}
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
        <div class="lg:col-span-5 space-y-4">
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
                                    {{ $riwayat->quiz->judul ?? 'Kuis Pembelajaran' }}
                                </h4>
                                <p class="text-[11px] font-semibold text-[#72839E]">
                                    {{ $riwayat->waktu_dapat ? \Illuminate\Support\Carbon::parse($riwayat->waktu_dapat)->diffForHumans() : $riwayat->created_at->diffForHumans() }}
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

                <!-- Tips Belajar Singkat (Khas Arrava Mobile) -->
                <div class="rounded-[18px] bg-[#EFF6FF] border border-[#BFDBFE] p-4 flex items-start gap-3">
                    <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-xl bg-blue-100 text-[#007FBE]">
                        💡
                    </span>
                    <p class="text-xs font-semibold text-[#1E40AF] leading-relaxed">
                        Kerjakan modul dan latihan kuis secara berkala untuk memperkuat pemahamanmu serta menaikkan peringkat ke tingkat master!
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
