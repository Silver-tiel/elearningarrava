@extends('layouts.app')

@section('header')
    <h1 class="text-base sm:text-lg font-heading font-black text-[#082765]">Ringkasan Aktivitas Belajar</h1>

    <div class="flex items-center gap-3">
        <!-- Switch Bahasa -->
        <button class="flex items-center gap-1.5 text-xs font-bold text-[#465673] bg-white px-3 py-1.5 rounded-xl border border-[#DCEFFF] shadow-[0_2px_0_#DCEFFF] hover:border-[#007FBE] transition">
            <span>ID</span>
            <svg class="w-3.5 h-3.5 text-[#72839E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>
    </div>
@endsection

@section('content')
@php
    /**
     * @var int $siswaCount
     * @var int $guruCount
     * @var int $modulCount
     * @var int $quizCount
     * @var int $achievementCount
     * @var \Illuminate\Database\Eloquent\Collection<int, \App\Models\User>|array $siswaTerbaru
     * @var \Illuminate\Database\Eloquent\Collection<int, \App\Models\Modul>|array $modulTerbaru
     */
@endphp
<div class="p-4 sm:p-6 lg:p-8 space-y-6 max-w-7xl mx-auto">

    <!-- GREETING SECTION -->
    <div class="rounded-2xl sm:rounded-3xl bg-gradient-to-r from-[#007FBE] via-[#0095DE] to-[#38BDF8] p-6 sm:p-7 text-white shadow-[0_6px_0_#005580] relative overflow-hidden">
        <div class="absolute -right-8 -bottom-10 w-44 h-44 rounded-full bg-white/10 blur-xl pointer-events-none"></div>
        <div class="relative z-10">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/20 backdrop-blur-md text-xs font-black text-white border border-white/25 mb-2.5">
                <span>🛡️</span> Portal Administrator Arrava
            </span>
            <h2 class="text-xl sm:text-2xl lg:text-3xl font-heading font-black leading-tight">
                Selamat datang kembali, {{ Auth::user()->nama ?? 'Admin' }}! 👋
            </h2>
            <p class="text-xs sm:text-sm text-white/90 mt-1.5 max-w-xl font-medium">
                Berikut adalah ringkasan perkembangan belajar, data pengguna, modul, dan statistik kuis platform hari ini.
            </p>
        </div>
    </div>

    <!-- STATS CARDS (3D SAMUDRA STYLE) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">

        <!-- Card 1: Total Siswa -->
        <div class="bg-white p-5 rounded-2xl sm:rounded-3xl border-2 border-[#DCEFFF] shadow-[0_4px_0_#B2E7FC] hover:shadow-[0_6px_0_#007FBE] hover:border-[#007FBE] hover:-translate-y-1 transition-all duration-200 flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <div class="w-11 h-11 rounded-2xl bg-[#DDF3FF] text-[#007FBE] border border-[#B2E7FC] flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                </div>
                <span class="text-[10px] font-black uppercase tracking-wider text-[#007FBE] bg-[#DDF3FF] px-2.5 py-0.5 rounded-full border border-[#B2E7FC]">Siswa</span>
            </div>
            <div class="mt-4">
                <p class="text-xs font-bold text-[#72839E]">Total Siswa</p>
                <h3 class="text-2xl sm:text-3xl font-heading font-black text-[#082765] mt-0.5">{{ number_format($siswaCount ?? 0) }}</h3>
            </div>
        </div>

        <!-- Card 2: Total Guru -->
        <div class="bg-white p-5 rounded-2xl sm:rounded-3xl border-2 border-[#DCEFFF] shadow-[0_4px_0_#B2E7FC] hover:shadow-[0_6px_0_#007FBE] hover:border-[#007FBE] hover:-translate-y-1 transition-all duration-200 flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <div class="w-11 h-11 rounded-2xl bg-[#EEF2FF] text-[#4F46E5] border border-[#C7D2FE] flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <span class="text-[10px] font-black uppercase tracking-wider text-[#4F46E5] bg-[#EEF2FF] px-2.5 py-0.5 rounded-full border border-[#C7D2FE]">Guru</span>
            </div>
            <div class="mt-4">
                <p class="text-xs font-bold text-[#72839E]">Total Guru</p>
                <h3 class="text-2xl sm:text-3xl font-heading font-black text-[#082765] mt-0.5">{{ number_format($guruCount ?? 0) }}</h3>
            </div>
        </div>

        <!-- Card 3: Total Modul -->
        <div class="bg-white p-5 rounded-2xl sm:rounded-3xl border-2 border-[#DCEFFF] shadow-[0_4px_0_#B2E7FC] hover:shadow-[0_6px_0_#007FBE] hover:border-[#007FBE] hover:-translate-y-1 transition-all duration-200 flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <div class="w-11 h-11 rounded-2xl bg-[#DCFCE7] text-[#059669] border border-[#BBF7D0] flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                        </path>
                    </svg>
                </div>
                <span class="text-[10px] font-black uppercase tracking-wider text-[#059669] bg-[#DCFCE7] px-2.5 py-0.5 rounded-full border border-[#BBF7D0]">Modul</span>
            </div>
            <div class="mt-4">
                <p class="text-xs font-bold text-[#72839E]">Total Modul</p>
                <h3 class="text-2xl sm:text-3xl font-heading font-black text-[#082765] mt-0.5">{{ number_format($modulCount ?? 0) }}</h3>
            </div>
        </div>

        <!-- Card 4: Total Quiz -->
        <div class="bg-white p-5 rounded-2xl sm:rounded-3xl border-2 border-[#DCEFFF] shadow-[0_4px_0_#B2E7FC] hover:shadow-[0_6px_0_#007FBE] hover:border-[#007FBE] hover:-translate-y-1 transition-all duration-200 flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <div class="w-11 h-11 rounded-2xl bg-[#FEF3C7] text-[#D97706] border border-[#FDE68A] flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                </div>
                <span class="text-[10px] font-black uppercase tracking-wider text-[#D97706] bg-[#FEF3C7] px-2.5 py-0.5 rounded-full border border-[#FDE68A]">Kuis</span>
            </div>
            <div class="mt-4">
                <p class="text-xs font-bold text-[#72839E]">Total Quiz</p>
                <h3 class="text-2xl sm:text-3xl font-heading font-black text-[#082765] mt-0.5">{{ number_format($quizCount ?? 0) }}</h3>
            </div>
        </div>

        <!-- Card 5: Total Penghargaan -->
        <a href="{{ route('admin.achievement') }}" class="bg-white p-5 rounded-2xl sm:rounded-3xl border-2 border-[#DCEFFF] shadow-[0_4px_0_#B2E7FC] hover:shadow-[0_6px_0_#E11D48] hover:border-[#E11D48] hover:-translate-y-1 transition-all duration-200 flex flex-col justify-between group">
            <div class="flex items-center justify-between">
                <div class="w-11 h-11 rounded-2xl bg-[#FFE4E6] text-[#E11D48] border border-[#FECDD3] flex items-center justify-center group-hover:scale-105 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                    </svg>
                </div>
                <span class="text-[10px] font-black uppercase tracking-wider text-[#E11D48] bg-[#FFE4E6] px-2.5 py-0.5 rounded-full border border-[#FECDD3] group-hover:bg-[#E11D48] group-hover:text-white transition">Kelola →</span>
            </div>
            <div class="mt-4">
                <p class="text-xs font-bold text-[#72839E]">Penghargaan</p>
                <h3 class="text-2xl sm:text-3xl font-heading font-black text-[#082765] mt-0.5">{{ number_format($achievementCount ?? 0) }}</h3>
            </div>
        </a>

    </div>

    <!-- MIDDLE SECTION: SISWA TERBARU & MODUL TERBARU -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- List Siswa Terbaru -->
        <div class="bg-white p-6 rounded-2xl sm:rounded-3xl border-2 border-[#DCEFFF] shadow-[0_4px_0_#B2E7FC]">
            <div class="flex items-center justify-between mb-5 pb-3 border-b border-[#DCEFFF]">
                <h3 class="font-heading font-black text-[#082765] text-base flex items-center gap-2">
                    <span>👥</span> Siswa Pendaftaran Terbaru
                </h3>
                <a href="{{ route('admin.daftar_siswa') }}" class="text-xs font-black text-[#007FBE] hover:text-[#00679A] hover:underline">Lihat Semua →</a>
            </div>

            <div class="space-y-3.5">
                @forelse($siswaTerbaru ?? [] as $siswa)
                    @php /** @var \App\Models\User $siswa */ @endphp
                    <div class="flex items-center justify-between p-3 rounded-2xl bg-[#F0F6FF]/60 border border-[#DCEFFF] hover:border-[#007FBE] hover:bg-[#F0F6FF] transition">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-10 h-10 rounded-2xl bg-[#DDF3FF] text-[#007FBE] font-black border border-[#B2E7FC] flex items-center justify-center shrink-0 text-sm">
                                {{ strtoupper(substr($siswa->nama ?? 'S', 0, 1)) }}
                            </div>
                            <div class="min-w-0">
                                <h4 class="text-xs sm:text-sm font-black text-[#082765] leading-tight truncate">{{ $siswa->nama }}</h4>
                                <p class="text-[11px] font-bold text-[#72839E] mt-0.5 truncate">{{ $siswa->email ?? 'Siswa' }}</p>
                            </div>
                        </div>
                        <span class="text-[11px] font-bold text-[#72839E] shrink-0 ml-2 px-2.5 py-0.5 rounded-lg bg-white border border-[#DCEFFF]">{{ $siswa->created_at ? $siswa->created_at->diffForHumans() : '-' }}</span>
                    </div>
                @empty
                    <p class="text-xs font-bold text-[#72839E] text-center py-6">Belum ada data siswa.</p>
                @endforelse
            </div>
        </div>

        <!-- List Modul Terbaru / Aktif -->
        <div class="bg-white p-6 rounded-2xl sm:rounded-3xl border-2 border-[#DCEFFF] shadow-[0_4px_0_#B2E7FC]">
            <div class="flex items-center justify-between mb-5 pb-3 border-b border-[#DCEFFF]">
                <h3 class="font-heading font-black text-[#082765] text-base flex items-center gap-2">
                    <span>📚</span> Modul Terbaru
                </h3>
                <a href="{{ route('admin.modul') }}" class="text-xs font-black text-[#007FBE] hover:text-[#00679A] hover:underline">Kelola Modul →</a>
            </div>

            <div class="space-y-3.5">
                @forelse($modulTerbaru ?? [] as $modul)
                    @php /** @var \App\Models\Modul $modul */ @endphp
                    <div class="flex items-center gap-3 p-3 rounded-2xl bg-[#F0F6FF]/60 border border-[#DCEFFF] hover:border-[#007FBE] hover:bg-[#F0F6FF] transition">
                        <div class="w-12 h-12 rounded-xl overflow-hidden bg-[#DDF3FF] flex items-center justify-center shrink-0 border border-[#B2E7FC] relative">
                            @if($modul->foto_modul && Storage::disk('public')->exists($modul->foto_modul))
                                <img src="{{ Storage::url($modul->foto_modul) }}" alt="{{ $modul->judul_modul }}" class="w-full h-full object-cover">
                            @elseif($modul->youtube_id)
                                <img src="https://img.youtube.com/vi/{{ $modul->youtube_id }}/hqdefault.jpg" alt="{{ $modul->judul_modul }}" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black/25 flex items-center justify-center">
                                    <div class="w-5 h-5 rounded-full bg-red-600 text-white flex items-center justify-center text-[9px] font-black pl-0.5 border border-white">▶</div>
                                </div>
                            @else
                                <div class="w-full h-full bg-[#DDF3FF] text-[#007FBE] flex items-center justify-center text-lg select-none">
                                    📖
                                </div>
                            @endif
                        </div>
                        <div class="min-w-0 flex-1">
                            <h4 class="text-xs sm:text-sm font-black text-[#082765] leading-tight truncate">{{ $modul->judul_modul }}</h4>
                            <p class="text-[11px] font-bold text-[#72839E] mt-0.5 truncate">{{ $modul->jenjang?->nama_jenjang ?? $modul->jenjang?->nama_tipe ?? 'Semua Jenjang' }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-xs font-bold text-[#72839E] text-center py-6">Belum ada modul tersedia.</p>
                @endforelse
            </div>
        </div>

    </div>

</div>
@endsection
