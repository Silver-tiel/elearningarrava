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
<div class="px-8 py-8">
    @if(session('error'))
        <div class="mb-5 rounded-xl bg-red-50 px-4 py-3 text-sm text-red-700">{{ session('error') }}</div>
    @endif

    <div class="mb-7">
        <p class="text-sm font-medium text-[#3180f7]">Dashboard Siswa</p>
        <h1 class="mt-1 text-[28px] font-bold tracking-tight text-[#172033]">Halo, {{ $user->nama }} 👋</h1>
        <p class="mt-1.5 text-sm text-[#687892]">Lanjutkan belajar dan kerjakan quiz yang tersedia.</p>
    </div>

    <div class="grid gap-5 lg:grid-cols-3">
        <a href="{{ route('siswa.modul') }}" class="rounded-2xl border border-[#dfe6ef] bg-white p-5 transition hover:-translate-y-0.5 hover:shadow-md">
            <div class="flex items-center justify-between">
                <span class="text-sm text-[#77859a]">Materi Tersedia</span>
                <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#edf5ff] text-[#3180f7]">📚</span>
            </div>
            <p class="mt-3 text-3xl font-bold text-[#172033]">{{ $modulCount }}</p>
            <p class="mt-4 text-sm font-semibold text-[#3180f7]">Buka modul →</p>
        </a>

        <a href="{{ route('siswa.quiz') }}" class="rounded-2xl border border-[#dfe6ef] bg-white p-5 transition hover:-translate-y-0.5 hover:shadow-md">
            <div class="flex items-center justify-between">
                <span class="text-sm text-[#77859a]">Quiz Tersedia</span>
                <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#edf5ff] text-[#3180f7]">✎</span>
            </div>
            <p class="mt-3 text-3xl font-bold text-[#172033]">{{ $quizCount }}</p>
            <p class="mt-4 text-sm font-semibold text-[#3180f7]">Buka quiz →</p>
        </a>

        <div class="rounded-2xl border border-[#dfe6ef] bg-white p-5">
            <div class="flex items-center justify-between">
                <span class="text-sm text-[#77859a]">Poin Saya</span>
                <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#edf5ff] text-[#3180f7]">★</span>
            </div>
            <p class="mt-3 text-3xl font-bold text-[#172033]">{{ $user->total_poin ?? 0 }}</p>
            <p class="mt-4 text-sm text-[#8b98aa]">Terus belajar untuk menambah poin.</p>
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
            <a href="{{ $targetUrl }}" class="overflow-hidden rounded-2xl border border-[#dfe6ef] bg-white transition hover:-translate-y-0.5 hover:shadow-md">
                <div class="relative h-36 bg-[#eef3f8] overflow-hidden">
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
