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

        {{-- =======================================================================
             3. SECTION: MATERI MODUL PEMBELAJARAN (Khas Arrava 3D Cards)
             ======================================================================= --}}
        <div id="tourMateriModul" class="space-y-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-b from-[#EBF7FF] to-[#DDF3FF] border border-[#B2E7FC] text-[#007FBE] shadow-xs">
                        <span class="text-lg">📚</span>
                    </div>
                    <div>
                        <h2 class="text-base sm:text-lg font-heading font-black text-[#12233F] tracking-tight">Materi Modul Pembelajaran</h2>
                        <p class="text-xs text-[#72839E]">Lanjutkan materi belajar interaktif sesuai jenjang kamu.</p>
                    </div>
                </div>
                <a href="{{ route('siswa.modul') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white border border-[#DCEFFF] text-xs font-black text-[#007FBE] hover:bg-[#F0F6FF] hover:border-[#007FBE] shadow-xs transition">
                    <span>Lihat Semua Materi</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @forelse($moduls ?? [] as $index => $modul)
                    @php
                        /** @var \App\Models\Modul $modul */
                        $isVideo = ($modul->id_tipemodul == 1 || !empty($modul->youtube_id));
                        $targetUrl = route('siswa.modul.materi', $modul->id_modul);
                    @endphp
                    <div class="group flex flex-col justify-between rounded-[22px] border-2 border-[#DCEFFF] bg-white p-4 shadow-[0_4px_0_#B2E7FC] transition-all duration-200 hover:-translate-y-1 hover:border-[#007FBE] hover:shadow-[0_6px_0_#007FBE]">
                        <!-- Banner Cover / Thumbnail Media -->
                        <div class="relative h-36 sm:h-40 w-full overflow-hidden rounded-2xl bg-gradient-to-br from-[#E0F2FE] via-[#BAE6FD] to-[#7DD3FC] border border-[#B2E7FC]">
                            @if($modul->foto_modul && Storage::disk('public')->exists($modul->foto_modul))
                                <img src="{{ asset('storage/' . $modul->foto_modul) }}" alt="{{ $modul->judul_modul }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                            @elseif($modul->youtube_id)
                                <img src="https://img.youtube.com/vi/{{ $modul->youtube_id }}/hqdefault.jpg" alt="{{ $modul->judul_modul }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                                <div class="absolute inset-0 bg-black/25 flex items-center justify-center transition group-hover:bg-black/35">
                                    <div class="flex h-11 w-11 items-center justify-center rounded-full bg-red-600 text-white shadow-lg text-sm font-black pl-0.5 border-2 border-white transition-transform group-hover:scale-110">
                                        ▶
                                    </div>
                                </div>
                            @else
                                <div class="flex h-full w-full flex-col items-center justify-center bg-gradient-to-br from-[#E0F2FE] to-[#DDF3FF] text-[#007FBE] select-none p-4">
                                    <span class="text-4xl transition-transform duration-200 group-hover:scale-110">{{ $isVideo ? '🎬' : '📖' }}</span>
                                    <span class="mt-1 text-[11px] font-black text-[#007FBE]/80 uppercase tracking-wider">{{ $isVideo ? 'Video Pembelajaran' : 'Dokumen Pelajaran' }}</span>
                                </div>
                            @endif

                            {{-- Floating Badges over banner --}}
                            <div class="absolute top-2.5 left-2.5 right-2.5 flex items-center justify-between gap-2 pointer-events-none">
                                <span class="inline-flex items-center gap-1 rounded-full px-2.5 py-1 text-[10px] font-black shadow-xs backdrop-blur-md {{ $isVideo ? 'bg-red-500/95 text-white' : 'bg-[#007FBE]/95 text-white' }}">
                                    <span>{{ $isVideo ? '🎬' : '📄' }}</span>
                                    <span>{{ $isVideo ? 'Video' : ($modul->tipeModul?->nama_tipe ?? 'Dokumen') }}</span>
                                </span>
                                <span class="inline-flex items-center gap-1 rounded-full bg-white/95 px-2.5 py-1 text-[10px] font-black text-[#082765] shadow-xs border border-[#DCEFFF]">
                                    <span>🎓</span> {{ $modul->jenjang?->nama_tipe ?? $modul->jenjang?->nama_jenjang ?? 'Semua' }}
                                </span>
                            </div>
                        </div>

                        <!-- Detail & Deskripsi -->
                        <div class="flex-1 flex flex-col justify-between pt-3.5">
                            <div>
                                @if($modul->mapel)
                                    <div class="inline-flex items-center gap-1 rounded-md bg-[#EEF2FF] px-2 py-0.5 text-[10px] font-extrabold text-[#4F46E5] border border-[#E0E7FF] mb-1.5">
                                        <span>📘</span> {{ $modul->mapel->nama_mapel }}
                                    </div>
                                @else
                                    <div class="inline-flex items-center gap-1 rounded-md bg-[#F1F5F9] px-2 py-0.5 text-[10px] font-extrabold text-[#64748B] border border-[#E2E8F0] mb-1.5">
                                        <span>📖</span> Pelajaran Umum
                                    </div>
                                @endif

                                <h3 class="text-sm sm:text-base font-heading font-black text-[#082765] leading-snug line-clamp-2 group-hover:text-[#007FBE] transition" title="{{ $modul->judul_modul }}">
                                    {{ $modul->judul_modul }}
                                </h3>

                                <p class="mt-1 text-xs text-[#72839E] line-clamp-2 leading-relaxed">
                                    {{ $modul->deskripsi ? strip_tags($modul->deskripsi) : 'Pelajari materi interaktif ini untuk meningkatkan pemahaman dan raih poin EXP belajar.' }}
                                </p>
                            </div>

                            <!-- Footer: Keterangan Format & Tombol Aksi 3D -->
                            <div class="mt-4 pt-3 border-t border-[#F0F6FF] flex items-center justify-between gap-2">
                                <span class="text-[11px] font-bold text-[#72839E] flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $isVideo ? 'bg-red-500' : 'bg-[#007FBE]' }}"></span>
                                    <span>{{ $isVideo ? 'Media Video' : 'Modul Belajar' }}</span>
                                </span>

                                <a href="{{ $targetUrl }}"
                                   class="inline-flex items-center gap-1.5 px-3.5 py-1.5 text-xs font-black rounded-xl text-white transition-all shadow-[0_3px_0_#005580] hover:bg-[#00679A] active:translate-y-0.5 active:shadow-none bg-[#007FBE]">
                                    <span>{{ $isVideo ? 'Tonton Video' : 'Pelajari Materi' }}</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full rounded-[22px] border-2 border-dashed border-[#DCEFFF] bg-white p-8 text-center shadow-xs">
                        <span class="text-3xl">📚</span>
                        <p class="mt-2 text-xs sm:text-sm font-bold text-[#12233F]">Belum ada modul materi tersedia untuk jenjang Anda.</p>
                        <p class="text-xs text-[#72839E] mt-0.5">Guru akan segera menambahkan materi pembelajaran terbaru untukmu!</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- =======================================================================
             4. SECTION: RIWAYAT BELAJAR & KUIS (Container 3D Khusus Arrava)
             ======================================================================= --}}
        <div id="tourRiwayatKuis" class="rounded-[22px] border-2 border-[#DCEFFF] bg-white p-5 sm:p-6 shadow-[0_4px_0_#B2E7FC] space-y-4">
            <div class="flex flex-wrap items-center justify-between gap-3 pb-3 border-b border-[#F0F6FF]">
                <div class="flex items-center gap-2.5">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-b from-[#FFFBEB] to-[#FEF3C7] border border-[#FDE68A] text-[#D97706] shadow-xs">
                        <span class="text-lg">⏱️</span>
                    </div>
                    <div>
                        <h2 class="text-base sm:text-lg font-heading font-black text-[#12233F] tracking-tight">Riwayat Belajar &amp; Kuis</h2>
                        <p class="text-xs text-[#72839E]">Aktivitas pengerjaan kuis terbaru yang telah kamu selesaikan.</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    @if(count($riwayatKuis ?? []) > 0)
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-[#F0F6FF] border border-[#DCEFFF] text-xs font-black text-[#007FBE]">
                            {{ count($riwayatKuis) }} Aktivitas
                        </span>
                    @endif
                    <a href="{{ route('siswa.quiz') }}" class="inline-flex items-center gap-1 text-xs font-extrabold text-[#007FBE] hover:underline ml-1">
                        <span>Buka Semua Kuis</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>

            @if(count($riwayatKuis ?? []) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3.5">
                    @foreach($riwayatKuis as $riwayat)
                        @php
                            /** @var \App\Models\HasilQuizModul $riwayat */
                            $isLulus = (bool) ($riwayat->is_lulus ?? false);
                            $nilai = (int) ($riwayat->total_poin ?? 0) > 0
                                ? round(($riwayat->poin_didapat / $riwayat->total_poin) * 100)
                                : 0;
                        @endphp
                        <div class="rounded-2xl border-2 border-[#DCEFFF] bg-[#F8FAFC] p-3.5 hover:bg-white hover:border-[#007FBE] hover:shadow-[0_3px_0_#B2E7FC] transition-all flex items-center justify-between gap-3 group">
                            <div class="flex items-center gap-3 min-w-0">
                                <!-- Badge Skor -->
                                <div class="flex h-12 w-12 shrink-0 flex-col items-center justify-center rounded-2xl border {{ $isLulus ? 'border-[#BBF7D0] bg-[#DCFCE7] text-[#059669]' : 'border-[#FDE68A] bg-[#FEF3C7] text-[#D97706]' }}">
                                    <span class="text-xs font-black leading-none">{{ $nilai }}%</span>
                                    <span class="text-[9px] font-bold uppercase tracking-tighter mt-0.5 leading-none">{{ $isLulus ? 'Lulus' : 'Remedi' }}</span>
                                </div>

                                <div class="min-w-0">
                                    <h4 class="text-xs sm:text-sm font-extrabold text-[#12233F] truncate group-hover:text-[#007FBE] transition" title="{{ $riwayat->quiz?->judul ?? 'Kuis Pembelajaran' }}">
                                        {{ $riwayat->quiz?->judul ?? 'Kuis Pembelajaran' }}
                                    </h4>
                                    <div class="mt-0.5 flex items-center gap-2 text-[11px] font-semibold text-[#72839E]">
                                        <span>{{ $riwayat->waktu_dapat ? \Illuminate\Support\Carbon::parse($riwayat->waktu_dapat)->diffForHumans() : ($riwayat->created_at?->diffForHumans() ?? '-') }}</span>
                                        <span>•</span>
                                        <span class="font-bold {{ $isLulus ? 'text-[#059669]' : 'text-[#D97706]' }}">{{ $riwayat->poin_didapat ?? 0 }}/{{ $riwayat->total_poin ?? 0 }} XP</span>
                                    </div>
                                </div>
                            </div>

                            @if($riwayat->id_quiz)
                                <a href="{{ route('siswa.quiz.detail', $riwayat->id_quiz) }}"
                                   class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-white border border-[#DCEFFF] text-[#72839E] shadow-xs group-hover:border-[#007FBE] group-hover:text-[#007FBE] group-hover:scale-105 transition"
                                   title="Buka Kuis">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="rounded-2xl border-2 border-dashed border-[#DCEFFF] bg-[#F8FAFC] p-8 text-center">
                    <span class="text-3xl">🎯</span>
                    <p class="mt-2 text-xs sm:text-sm font-bold text-[#12233F]">Belum ada riwayat pengerjaan kuis.</p>
                    <p class="text-xs text-[#72839E] mt-0.5">Kerjakan kuis seru untuk mengumpulkan EXP dan naikkan peringkatmu!</p>
                    <a href="{{ route('siswa.quiz') }}" class="mt-3 inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-[#007FBE] text-white text-xs font-black shadow-[0_3px_0_#005580] hover:bg-[#00679A] transition">
                        <span>Mulai Kuis Sekarang</span>
                        <span>→</span>
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
