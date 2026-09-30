@extends('layouts.siswa')

@section('header')
    <h1 class="text-[18px] font-extrabold text-[#172033]">{{ $modul->judul_modul }}</h1>
@endsection

@section('content')
@php
    $embedUrl = $selectedVideo->youtube_embed_url ?? null;
    if (!$embedUrl) {
        $embedUrl = $modul->youtube_embed_url;
    }
@endphp

<div class="px-8 py-6">
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-[340px_minmax(0,1fr)]">

        {{-- SIDEBAR: Daftar Materi --}}
        @include('siswa.partials.daftar-materi', ['selectedVideo' => $selectedVideo])

        {{-- MAIN CONTENT --}}
        <section class="min-w-0">

            {{-- Video Player --}}
            <div class="relative aspect-video max-h-[440px] w-full overflow-hidden rounded-2xl bg-black shadow-lg border border-[#dce4ed] flex items-center justify-center">
                @if($embedUrl)
                    <iframe src="{{ $embedUrl }}?rel=0&enablejsapi=1"
                            class="w-full h-full" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                @elseif($selectedVideo && $selectedVideo->file_video && Storage::disk('public')->exists($selectedVideo->file_video))
                    <video src="{{ Storage::url($selectedVideo->file_video) }}" controls class="w-full h-full object-contain"></video>
                @elseif($modul->file_materi && Storage::disk('public')->exists($modul->file_materi))
                    <video src="{{ Storage::url($modul->file_materi) }}" controls class="w-full h-full object-contain"></video>
                @else
                    <div class="text-center p-8 text-slate-400">
                        <svg class="mx-auto h-16 w-16 text-slate-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-base font-semibold text-slate-200">Video Belum Tersedia</p>
                    </div>
                @endif
            </div>

            {{-- Judul & Meta --}}
            <div class="mt-5 flex flex-wrap items-start justify-between gap-4">
                <div>
                    <h1 class="text-[22px] font-extrabold text-[#172033]">
                        {{ $selectedVideo->judul ?? $modul->judul_modul }}
                    </h1>
                    <p class="mt-1 text-[12px] text-[#687892]">
                        {{ $modul->tipeModul->nama_tipe ?? 'Video' }}
                        • {{ $modul->jenjang->nama_tipe ?? '' }}
                        • {{ $modul->materiVideo->count() }} materi
                    </p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('siswa.modul') }}"
                       class="rounded-lg border border-[#dce4ed] bg-white px-4 py-2 text-[12px] font-semibold text-[#52617a] hover:bg-gray-50">
                        Kembali
                    </a>
                    @if($modul->id_quiz)
                        <a href="{{ route('siswa.quiz.kerjakan', $modul->id_quiz) }}"
                           class="rounded-lg bg-emerald-600 px-4 py-2 text-[12px] font-bold text-white hover:bg-emerald-700">
                            Lanjut ke Kuis →
                        </a>
                    @endif
                </div>
            </div>

            {{-- TABS --}}
            @include('siswa.partials.tabs-modul', ['activeTab' => 'overview'])

            {{-- KONTEN OVERVIEW --}}
            <div id="tab-content-overview" class="pt-4">
                <p class="max-w-[850px] text-[13px] leading-6 text-[#52617a]">
                    {{ $selectedVideo->deskripsi ?? 'Pelajari materi ini dengan seksama. Kamu dapat berpindah antar video di daftar materi di sebelah kiri.' }}
                </p>
            </div>

            {{-- KONTEN CATATAN (hidden default) --}}
            <div id="tab-content-catatan" class="pt-4 hidden">
                @forelse($modul->catatan as $item)
                    <article class="mb-4 rounded-2xl border border-[#e4eaf1] bg-white p-5">
                        <h2 class="text-[15px] font-extrabold text-[#172033]">{{ $item->judul }}</h2>
                        <p class="mt-2 text-[13px] leading-6 text-[#52617a] whitespace-pre-line">{{ $item->isi }}</p>
                    </article>
                @empty
                    <div class="rounded-2xl border border-dashed border-[#cfd9e5] bg-white p-12 text-center text-sm text-[#7c899c]">
                        Belum ada catatan untuk modul ini.
                    </div>
                @endforelse
            </div>
        </section>
    </div>
</div>

@push('scripts')
<script>
    // Toggle Catatan tanpa reload
    const btnCatatan = document.querySelector('.tab-catatan');
    if (btnCatatan) {
        btnCatatan.addEventListener('click', () => {
            document.getElementById('tab-content-overview').classList.add('hidden');
            document.getElementById('tab-content-catatan').classList.remove('hidden');

            // Update active state pada tab
            document.querySelectorAll('.tab-catatan, a[href*="/materi"]').forEach(el => {
                el.classList.remove('text-[#3180f7]');
                el.classList.add('text-[#52617a]');
            });
            btnCatatan.classList.remove('text-[#52617a]');
            btnCatatan.classList.add('text-[#3180f7]');
        });
    }
</script>
@endpush
@endsection
