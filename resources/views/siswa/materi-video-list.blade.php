@extends('layouts.siswa')

@section('header')
<div class="relative w-full max-w-[420px]">
    <svg class="absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-[#8a98ad]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/>
    </svg>
    <input type="text" placeholder="Cari materi video..." class="h-10 w-full rounded-lg bg-[#f5f8fc] pl-11 pr-4 text-sm text-[#526078] outline-none placeholder:text-[#9aa7b9] focus:ring-2 focus:ring-blue-100">
</div>
@endsection

@section('content')
<div class="px-8 py-8">
    <div class="mb-6">
        <h1 class="text-[24px] font-bold tracking-tight text-[#172033]">Materi Video</h1>
        <p class="mt-1 text-sm text-[#687892]">Tonton video pembelajaran untuk memahami materi lebih dalam.</p>
    </div>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">
        @forelse($moduls as $modul)
            <a href="{{ route('siswa.materi-video.detail', $modul->id_modul) }}"
               class="group overflow-hidden rounded-2xl border border-[#dfe6ef] bg-white transition hover:-translate-y-0.5 hover:shadow-md">
                <div class="relative h-44 overflow-hidden bg-[#eef2f7]">
                    @if($modul->foto_modul)
                        <img src="{{ asset('storage/'.$modul->foto_modul) }}" alt="{{ $modul->judul_modul }}"
                             class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                    @else
                        <div class="flex h-full items-center justify-center text-5xl">🎬</div>
                    @endif
                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                        <div class="flex h-14 w-14 items-center justify-center rounded-full bg-white/90 text-[#3180f7] shadow-lg text-2xl">▷</div>
                    </div>
                </div>
                <div class="p-5">
                    <span class="inline-flex rounded-md bg-[#eaf9f2] px-2 py-1 text-[11px] font-semibold text-[#20a978]">
                        {{ $modul->tipeModul->nama_tipe ?? 'Video' }}
                    </span>
                    <h2 class="mt-3 text-[16px] font-bold leading-snug text-[#172033]">{{ $modul->judul_modul }}</h2>
                    <p class="mt-1.5 text-[13px] text-[#687892]">{{ $modul->jenjang->nama_jenjang ?? 'Semua jenjang' }}</p>
                </div>
            </a>
        @empty
            <div class="col-span-full rounded-2xl border border-dashed border-[#cfd9e5] bg-white p-12 text-center text-sm text-[#7c899c]">
                Belum ada materi video yang tersedia.
            </div>
        @endforelse
    </div>
</div>
@endsection
