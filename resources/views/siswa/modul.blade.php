@extends('layouts.siswa')

@section('header')
<div class="relative w-full max-w-[420px]">
    <svg class="absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-[#8a98ad]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/>
    </svg>
    <input type="text" placeholder="Cari modul, soal, tutor, atau siswa..." class="h-10 w-full rounded-lg bg-[#f5f8fc] pl-11 pr-4 text-sm outline-none placeholder:text-[#9aa7b9] focus:ring-2 focus:ring-blue-100">
</div>
@endsection

@section('content')
<div class="px-8 py-8">
    <div class="mb-6">
        <h1 class="text-[24px] font-bold tracking-tight text-[#172033]">Belajar Asikk</h1>
    </div>

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
        @forelse($moduls as $modul)
            <div class="group overflow-hidden rounded-2xl border border-[#dfe6ef] bg-white p-5 transition hover:-translate-y-0.5 hover:shadow-md">
                <div class="flex gap-4">
                    <div class="h-[200px] w-[160px] shrink-0 overflow-hidden rounded-xl bg-[#eef2f7]">
                        @if($modul->foto_modul)
                            <img src="{{ asset('storage/'.$modul->foto_modul) }}" alt="{{ $modul->judul_modul }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                        @else
                            <div class="flex h-full items-center justify-center text-4xl">📚</div>
                        @endif
                    </div>
                    <div class="min-w-0 flex-1">
                        <span class="inline-flex rounded-md bg-[#eaf9f2] px-2 py-1 text-[11px] font-semibold text-[#20a978]">{{ $modul->tipeModul->nama_tipe ?? 'Pelajaran' }}</span>
                        <h2 class="mt-3 text-[16px] font-bold leading-snug text-[#172033]">{{ $modul->judul_modul }}</h2>
                        <p class="mt-1.5 line-clamp-2 text-[13px] leading-5 text-[#687892]">Materi pembelajaran digital untuk siswa {{ $modul->jenjang->nama_jenjang ?? '' }}.</p>
                        <div class="mt-4 flex items-center gap-5 text-xs text-[#65748b]">
                            <span class="flex items-center gap-1.5">▣ {{ $modul->jenjang->nama_jenjang ?? 'Semua kelas' }}</span>
                            <span class="flex items-center gap-1.5">▤ Materi</span>
                        </div>
                        <div class="mt-4 border-t border-[#e4e8ef] pt-3">
                            <p class="text-xs text-[#718098]">Materi tersedia untuk dipelajari</p>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full rounded-2xl border border-dashed border-[#cfd9e5] bg-white p-12 text-center text-sm text-[#7c899c]">Belum ada modul yang tersedia.</div>
        @endforelse
    </div>
</div>
@endsection
