@extends('layouts.siswa')

@section('header')
<div class="relative w-full max-w-[420px]">
    <svg class="absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-[#8a98ad]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/>
    </svg>
    <input type="text" placeholder="Cari modul, soal, tutor, atau siswa..." class="h-10 w-full rounded-lg bg-[#f5f8fc] pl-11 pr-4 text-sm text-[#526078] outline-none placeholder:text-[#9aa7b9] focus:ring-2 focus:ring-blue-100">
</div>
@endsection

@section('content')
<div class="px-4 py-6 sm:px-8 sm:py-8">
    @if(session('error'))
        <div class="mb-5 rounded-xl bg-red-50 px-4 py-3 text-sm text-red-700">{{ session('error') }}</div>
    @endif
    <div class="mb-7">
        <p class="text-sm font-medium text-[#3180f7]">Dashboard Siswa</p>
        <h1 class="mt-1 text-[28px] font-bold tracking-tight text-[#172033]">Halo, {{ $user->nama }} 👋</h1>
        <p class="mt-1.5 text-sm text-[#687892]">Lanjutkan belajar dan kerjakan quiz yang tersedia.</p>
    </div>

    <div class="grid gap-5 lg:grid-cols-3">
        <a href="{{ route('siswa.modul') }}" class="hover-frame group relative rounded-2xl border border-[#dfe6ef] bg-white p-5 transition hover:-translate-y-0.5 hover:shadow-md">
            <div class="relative z-10 flex items-center justify-between">
                <span class="text-sm text-[#77859a]">Materi Tersedia</span>
            </div>
            <p class="relative z-10 mt-3 text-3xl font-bold text-[#172033]">{{ $modulCount }}</p>
            <div class="relative z-10 mt-4 flex items-end justify-between">
                <p class="text-sm font-semibold text-[#3180f7]">Buka modul →</p>
            </div>

            <!-- Karakter Animasi Diperbesar di Tengah -->
            <div class="pointer-events-none absolute bottom-1 right-2 h-28 w-28">
                <!-- PNG diam saat normal -->
                <img src="{{ asset('assets/foto_karakter/membacaDokumen/glasess_girl_readingl1.png') }}" 
                     alt="Materi Tersedia" 
                     style="image-rendering: pixelated;" 
                     class="h-full w-full object-contain transition-opacity duration-150 group-hover:opacity-0">
                
                <!-- GIF bergerak saat di-hover -->
                <img src="{{ asset('assets/foto_karakter/membacaDokumen/glasess_girl_reading.gif') }}" 
                     alt="Materi Tersedia Animasi" 
                     style="image-rendering: pixelated;" 
                     class="absolute inset-0 h-full w-full object-contain opacity-0 transition-opacity duration-150 group-hover:opacity-100">
            </div>
        </a>

        <a href="{{ route('siswa.quiz') }}" class="hover-frame group relative rounded-2xl border border-[#dfe6ef] bg-white p-5 transition hover:-translate-y-0.5 hover:shadow-md">
            <div class="relative z-10 flex items-center justify-between">
                <span class="text-sm text-[#77859a]">Quiz Tersedia</span>
            </div>
            <p class="relative z-10 mt-3 text-3xl font-bold text-[#172033]">{{ $quizCount }}</p>
            <p class="mt-4 text-sm font-semibold text-[#3180f7]">Buka quiz →</p>

            <!-- Karakter Animasi Diperbesar di Pojok Kanan Bawah -->   
            <div class="pointer-events-none absolute bottom-1 right-2 h-28 w-28">
                <!-- 1. Gambar Diam (PNG) -->
                <img src="{{ asset('assets/foto_karakter/quiz/quizgirl1.png') }}" 
                    alt="Quiz Tersedia" 
                    style="image-rendering: pixelated;" 
                    class="h-full w-full object-contain transition-opacity duration-150 group-hover:opacity-0">
                
                <!-- 2. Gambar Bergerak (GIF) -->
                <img src="{{ asset('assets/foto_karakter/quiz/quizgirl.gif') }}" 
                    alt="Quiz Tersedia Animasi" 
                    style="image-rendering: pixelated;" 
                    class="absolute inset-0 h-full w-full object-contain opacity-0 transition-opacity duration-150 group-hover:opacity-100">
            </div>
        </a>

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
        <div class="hover-frame flex flex-col justify-between rounded-2xl border border-[#dfe6ef] bg-white p-5 transition hover:-translate-y-0.5 hover:shadow-md">
            <div>
                <div class="flex items-center justify-between gap-2">
                    <span class="text-sm text-[#77859a]">Peringkat &amp; EXP</span>
                    <a href="{{ route('siswa.profil') }}" class="inline-flex items-center gap-1.5 rounded-lg bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-700 hover:bg-amber-100/70 transition border border-amber-200/60">
                        @if($rankInfo['current_badge_url'])
                            <img src="{{ $rankInfo['current_badge_url'] }}" alt="{{ $rankInfo['current_rank'] }}" class="h-3.5 w-3.5 object-contain">
                        @else
                            <span class="text-amber-500">★</span>
                        @endif
                        <span>{{ $rankInfo['current_rank'] }}</span>
                    </a>
                </div>

                <div class="mt-2.5 flex items-baseline gap-2">
                    <p class="text-3xl font-bold text-[#172033]">{{ number_format($rankInfo['current_points']) }}</p>
                    <span class="text-xs font-semibold uppercase tracking-wider text-[#8b98aa]">EXP</span>
                </div>

                <!-- Status target rank -->
                <div class="mt-2 flex items-center justify-between text-xs text-[#77859a]">
                    <span>
                        @if($rankInfo['is_max'])
                            <span class="font-semibold text-emerald-600">Tingkat Tertinggi (MAX) 👑</span>
                        @else
                            Menuju <strong class="text-[#172033]">{{ $rankInfo['next_rank'] }}</strong>
                        @endif
                    </span>
                    <span class="font-bold text-[#172033]">
                        @if($rankInfo['is_max'])
                            100%
                        @else
                            {{ number_format($rankInfo['current_points']) }} / {{ number_format($rankInfo['next_points']) }}
                        @endif
                    </span>
                </div>

                <!-- EXP Bar dengan Icon Widget EXP di sebelahnya -->
                <div class="mt-1.5 flex items-center gap-2">
                    <!-- Icon Widget EXP dari folder asset -->
                    <img src="{{ asset('assets/widget/exp.png') }}" 
                         alt="EXP" 
                         title="EXP Poin"
                         class="h-6 w-6 shrink-0 object-contain select-none"
                         style="image-rendering: pixelated;">

                    <!-- Track Progress Bar -->
                    <div class="relative h-2.5 flex-1 overflow-hidden rounded-full bg-slate-100 ring-1 ring-slate-200/70">
                        <div class="h-full rounded-full bg-gradient-to-r from-amber-400 via-orange-400 to-amber-500 transition-all duration-500"
                             style="width: {{ $rankInfo['percent'] }}%;">
                        </div>
                    </div>

                    <!-- Persentase EXP -->
                    <span class="shrink-0 text-xs font-bold text-amber-600 min-w-[34px] text-right">
                        {{ $rankInfo['percent'] }}%
                    </span>
                </div>
            </div>

            <div class="mt-3.5 flex items-center justify-between border-t border-slate-100 pt-2.5 text-xs text-[#8b98aa]">
                @if($rankInfo['is_max'])
                    <span class="text-emerald-600">Hebat! Semua tingkat terbuka.</span>
                @else
                    <span>Sisa <strong class="text-slate-700">{{ number_format($rankInfo['points_needed']) }} EXP</strong> lagi</span>
                @endif
                <a href="{{ route('siswa.profil') }}" class="font-semibold text-[#3180f7] hover:underline">Detail rank →</a>
            </div>
        </div>
    </div>

    <div class="mt-8 flex items-center justify-between">
        <div>
            <h2 class="text-[19px] font-bold text-[#172033]">Lanjutkan Belajar</h2>
            <p class="mt-1 text-sm text-[#718098]">Pilih materi yang ingin kamu lanjutkan.</p>
        </div>
        <a href="{{ route('siswa.modul') }}" class="text-sm font-semibold text-[#3180f7]">Lihat Semua</a>
    </div>

    <div class="mt-4 grid gap-5 md:grid-cols-2 xl:grid-cols-4">
        @forelse($moduls ?? [] as $modul)
    @php
        $isVideo = ($modul->id_tipemodul == 1 || $modul->youtube_id);
        $targetUrl = route('siswa.modul.materi', $modul->id_modul);
    @endphp
            <a href="{{ $targetUrl }}" class="hover-frame group block rounded-2xl border border-[#dfe6ef] bg-white transition hover:-translate-y-0.5 hover:shadow-md">
                <div class="relative h-36 bg-[#eef3f8] overflow-hidden rounded-t-2xl">
                    @if($modul->foto_modul && Storage::disk('public')->exists($modul->foto_modul))
                        <img src="{{ asset('storage/'.$modul->foto_modul) }}" alt="{{ $modul->judul_modul }}" class="h-full w-full object-cover">
                    @elseif($modul->youtube_id)
                        <img src="https://img.youtube.com/vi/{{ $modul->youtube_id }}/hqdefault.jpg" alt="{{ $modul->judul_modul }}" class="h-full w-full object-cover">
                        <div class="absolute inset-0 bg-black/20 flex items-center justify-center">
                            <div class="w-10 h-10 rounded-full bg-red-600 text-white flex items-center justify-center shadow text-sm font-bold pl-0.5">▶</div>
                        </div>
                    @else
                        <div class="flex h-full items-center justify-center text-4xl">{{ $isVideo ? '🎬' : '📚' }}</div>
                    @endif
                </div>
                <div class="p-4">
                    <span class="rounded-md {{ $isVideo ? 'bg-red-50 text-red-600' : 'bg-[#eef6ff] text-[#3180f7]' }} px-2 py-1 text-[11px] font-semibold">
                        {{ $isVideo ? 'Video' : ($modul->tipeModul->nama_tipe ?? 'Materi') }}
                    </span>
                    <h3 class="mt-3 line-clamp-2 text-[15px] font-bold text-[#172033]">{{ $modul->judul_modul }}</h3>
                    <p class="mt-1 text-xs text-[#718098]">{{ $modul->jenjang->nama_tipe ?? $modul->jenjang->nama_jenjang ?? 'Semua jenjang' }}</p>
                </div>
            </a>
        @empty
            <div class="col-span-full rounded-2xl border border-dashed border-[#cfd9e5] bg-white p-10 text-center text-sm text-[#7c899c]">Belum ada materi.</div>
        @endforelse
    </div>
</div>
@endsection
