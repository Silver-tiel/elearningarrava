@extends('layouts.siswa')

@section('header')
<h1 class="text-[20px] font-bold text-[#172033]">{{ $modul->jenjang->nama_jenjang ?? 'Materi Video' }}</h1>
@endsection

@section('content')
@php
    // Tentukan video yang sedang aktif
    $activeVideo = null;
    $embedUrl = null;

    if ($modul->materiVideo && $modul->materiVideo->count() > 0) {
        $activeVideo = $modul->materiVideo->where('id_materi', request('v'))->first() ?? $modul->materiVideo->first();
        $embedUrl = $activeVideo->youtube_embed_url ?? null;
    }
    
    // Jika tidak ada di daftar materiVideo atau belum embed, ambil dari modul langsung
    if (!$embedUrl) {
        $embedUrl = $modul->youtube_embed_url;
    }
@endphp

<div class="h-[calc(100vh-72px)] p-8">
    <div class="grid h-full grid-cols-[340px_minmax(0,1fr)] gap-6">
        <section class="overflow-hidden rounded-2xl border border-[#dce4ed] bg-white flex flex-col">
            <div class="px-5 pb-3 pt-5 border-b border-gray-100 flex items-center justify-between">
                <h2 class="text-[16px] font-bold text-[#172033]">Daftar Materi Video</h2>
                <span class="text-xs bg-blue-50 text-blue-600 px-2 py-0.5 rounded-full font-semibold">{{ $modul->materiVideo->count() ?: 1 }} Video</span>
            </div>
            <div class="space-y-1 p-3 overflow-y-auto flex-1">
                @forelse($modul->materiVideo as $index => $item)
                    <a href="{{ route('siswa.materi-video.detail', ['id_modul' => $modul->id_modul, 'v' => $item->id_materi]) }}"
                       class="flex w-full items-center gap-3 rounded-xl px-3 py-3 text-left transition {{ ($activeVideo && $activeVideo->id_materi == $item->id_materi) ? 'bg-[#edf5ff] text-[#3180f7] font-semibold' : 'text-[#52617a] hover:bg-[#f7f9fc]' }}">
                        @if($item->status == 'draft')
                            <span class="text-[#9aacc4]">♙</span>
                        @else
                            <span class="text-xs">▶</span>
                        @endif
                        <span class="flex-1 text-[13px] truncate">{{ sprintf('%02d', $index+1) }}. {{ $item->judul }}</span>
                        <span class="text-xs text-[#8797ae] shrink-0">{{ $item->durasi ?? 'Video' }}</span>
                    </a>
                @empty
                    @if($modul->youtube_embed_url)
                        <div class="p-3 text-xs text-[#3180f7] bg-blue-50 rounded-xl font-medium flex items-center gap-2">
                            <span>▶</span> Memutar video utama modul
                        </div>
                    @else
                        <div class="px-3 py-6 text-center text-sm text-[#8797ae]">Belum ada video terdaftar.</div>
                    @endif
                @endforelse
            </div>
        </section>

        <section class="min-w-0 flex flex-col overflow-y-auto">
            {{-- Dynamic Video Player (YouTube & Local Video) --}}
            <div class="relative aspect-video max-h-[460px] w-full overflow-hidden rounded-2xl bg-black shadow-lg border border-[#dce4ed] flex items-center justify-center">
                @if($embedUrl)
                    <iframe 
                        src="{{ $embedUrl }}?rel=0&enablejsapi=1" 
                        class="w-full h-full" 
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                        referrerpolicy="strict-origin-when-cross-origin"
                        allowfullscreen>
                    </iframe>
                @elseif($activeVideo && $activeVideo->file_video && Storage::disk('public')->exists($activeVideo->file_video))
                    <video src="{{ Storage::url($activeVideo->file_video) }}" controls class="w-full h-full object-contain"></video>
                @elseif($modul->file_materi && Storage::disk('public')->exists($modul->file_materi))
                    <video src="{{ Storage::url($modul->file_materi) }}" controls class="w-full h-full object-contain"></video>
                @else
                    <div class="text-center p-8 text-slate-400">
                        <svg class="mx-auto h-16 w-16 text-slate-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-base font-semibold text-slate-200">Video Belum Tersedia</p>
                        <p class="text-xs text-slate-400 mt-1">Tautan YouTube atau berkas video belum ditambahkan untuk materi ini.</p>
                    </div>
                @endif
            </div>

            <div class="mt-6 flex items-start justify-between gap-5">
                <div>
                    <h1 class="text-[22px] font-bold text-[#172033]">{{ $activeVideo->judul ?? $modul->judul_modul }}</h1>
                    <p class="mt-1 text-[13px] text-[#687892]">{{ $modul->tipeModul->nama_tipe ?? 'Video' }} • {{ $modul->jenjang->nama_tipe ?? '' }}</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('siswa.modul') }}" class="rounded-lg border border-[#dce4ed] bg-white px-4 py-2 text-[13px] font-medium text-[#52617a] hover:bg-gray-50 transition">Kembali ke Modul</a>
                    @if($modul->id_quiz)
                        <a href="{{ route('siswa.quiz.kerjakan', $modul->id_quiz) }}" class="rounded-lg bg-emerald-600 px-4 py-2 text-[13px] font-semibold text-white hover:bg-emerald-700 shadow-sm transition flex items-center gap-1.5">
                            <span>Lanjut ke Kuis</span> &rarr;
                        </a>
                    @endif
                </div>
            </div>

            @if(!empty($activeVideo->deskripsi))
                <p class="max-w-[850px] pt-4 text-[14px] leading-6 text-[#52617a]">
                    {{ $activeVideo->deskripsi }}
                </p>
            @endif
        </section>
    </div>
</div>
@endsection
