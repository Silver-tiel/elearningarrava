@extends('layouts.siswa')
@php($active = 'materi-video')

@section('header')
    <div class="relative w-[420px] max-w-full">
        <svg class="absolute left-4 top-1/2 h-[17px] w-[17px] -translate-y-1/2 text-[#8a98ad]" viewBox="0 0 24 24"
            fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="11" cy="11" r="7" />
            <path d="m20 20-4-4" />
        </svg><input class="h-10 w-full rounded-lg bg-[#f5f8fc] pl-11 pr-4 text-sm outline-none"
            placeholder="Cari materi video...">
    </div>
@endsection

@section('content')
    <div class="px-8 py-8">
        <div class="mb-6">
            <h1 class="text-[24px] font-bold">Materi Video</h1>
            <p class="mt-1 text-[14px] text-[#687892]">Pilih materi video yang ingin kamu tonton.</p>
        </div>
        <div class="grid grid-cols-2 gap-4 xl:grid-cols-4">
            @forelse ($moduls as $modul)
                <a href="{{ route('siswa.materi-video.detail', $modul->id_modul) }}"
                    class="overflow-hidden rounded-xl border border-[#dfe6ef] bg-white transition hover:-translate-y-0.5 hover:shadow-md">
                    <div class="relative h-[120px] overflow-hidden bg-gradient-to-br from-[#eef6ff] to-white">
                        @if($modul->foto_modul)
                            <img src="{{ asset('storage/' . $modul->foto_modul) }}" class="h-full w-full object-cover">
                        @else
                            <div class="flex h-full items-center justify-center text-5xl">▶️</div>
                        @endif
                    </div>
                    <div class="p-4">
                        <span class="inline-flex rounded-md bg-[#edf5ff] px-2 py-1 text-[11px] font-medium text-[#3180f7]">
                            {{ $modul->jenjang->nama_jenjang ?? 'Umum' }}
                        </span>
                        <h2 class="mt-3 text-[16px] font-bold">{{ $modul->judul_modul }}</h2>
                        <div class="mt-4 flex items-center justify-between text-[11px] text-[#75839a]">
                            <span>{{ $modul->materiVideo()->count() }} video</span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full py-10 text-center text-[#687892]">Belum ada materi video tersedia.</div>
            @endforelse
        </div>
    </div>
@endsection
