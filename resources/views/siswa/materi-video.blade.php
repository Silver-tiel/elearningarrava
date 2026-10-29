@extends('layouts.siswa')

@section('header')
    <h1 class="text-[18px] font-extrabold text-[#172033]">{{ $modul->judul_modul }}</h1>
@endsection

@section('content')
<div class="px-8 py-6">
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-[340px_minmax(0,1fr)]">

        {{-- SIDEBAR: Daftar Materi Sejenjang --}}
        @include('siswa.partials.daftar-materi')

        {{-- MAIN CONTENT --}}
        <section class="min-w-0">

            {{-- VIEWER CONTAINER (Kondisional Video vs PDF vs Tautan) --}}
            @if($modul->is_video)
                {{-- Pemutar Video --}}
                <div class="relative aspect-video max-h-[460px] w-full overflow-hidden rounded-2xl bg-black shadow-lg border border-[#dce4ed] flex items-center justify-center">
                    @if($modul->youtube_embed_url)
                        <iframe src="{{ $modul->youtube_embed_url }}?rel=0&enablejsapi=1"
                                class="w-full h-full" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
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

            @elseif($modul->is_pdf)
                {{-- Custom Viewer Dokumen PDF (Slide per Halaman, Non-scrollable, Next/Prev Center, Zoom & Fullscreen) --}}
                @if($modul->file_materi && Storage::disk('public')->exists($modul->file_materi))
                    <x-custom-pdf-viewer 
                        :url="Storage::url($modul->file_materi)" 
                        :title="$modul->judul_modul" 
                        height="h-[600px]" />
                @else
                    <div class="w-full rounded-2xl border border-[#dce4ed] bg-white p-12 text-center text-slate-400 shadow-sm">
                        <svg class="mx-auto h-12 w-12 text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p class="text-sm font-semibold">Berkas PDF belum tersedia atau belum diunggah.</p>
                    </div>
                @endif

            @elseif($modul->is_link)
                {{-- Tautan Materi Eksternal --}}
                <div class="w-full rounded-2xl border border-[#dce4ed] bg-gradient-to-br from-blue-50 to-indigo-50 p-10 text-center shadow-sm">
                    <div class="w-14 h-14 bg-blue-600 text-white rounded-2xl flex items-center justify-center mx-auto mb-4 text-2xl shadow">
                        🔗
                    </div>
                    <h2 class="text-lg font-bold text-[#172033] mb-2">Materi Melalui Tautan Eksternal</h2>
                    <p class="text-xs text-slate-500 max-w-md mx-auto mb-5">Materi pembelajaran ini tersedia pada situs eksternal atau tautan rujukan berikut.</p>
                    <a href="{{ $modul->file_materi }}" target="_blank"
                       class="inline-flex items-center gap-2 px-6 py-2.5 bg-blue-600 text-white text-xs font-bold rounded-xl hover:bg-blue-700 transition shadow">
                        Buka Tautan Materi &rarr;
                    </a>
                </div>

            @else
                {{-- Konten Artikel / Teks Standar --}}
                <div class="w-full rounded-2xl border border-[#dce4ed] bg-white p-8 shadow-sm">
                    <h2 class="text-lg font-bold text-[#172033] mb-3">{{ $modul->judul_modul }}</h2>
                    <p class="text-sm text-[#52617a] leading-relaxed">
                        Materi pembelajaran digital untuk siswa {{ $modul->jenjang->nama_tipe ?? '' }}. Silakan pelajari catatan ringkasan atau lanjutkan langsung ke kuis evaluasi.
                    </p>
                </div>
            @endif

            {{-- Card Detail & Konten Modul --}}
            <div class="mt-6 rounded-2xl border border-slate-200/90 bg-white p-6 shadow-sm">
                {{-- Judul & Meta --}}
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div>
                        <h1 class="text-[22px] font-extrabold text-[#172033]">
                            {{ $modul->judul_modul }}
                        </h1>
                        <p class="mt-1 text-[12px] text-[#687892]">
                            <span class="font-semibold text-[#172033]">{{ $modul->tipeModul->nama_tipe ?? ($modul->is_video ? 'Video' : 'Dokumen') }}</span>
                            • {{ $modul->jenjang->nama_tipe ?? 'Semua Jenjang' }}
                            • {{ $modul->is_video ? 'Video Pembelajaran' : ($modul->is_pdf ? 'Bahan Bacaan PDF' : 'Materi Pembelajaran') }}
                        </p>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('siswa.modul') }}"
                           class="rounded-lg border border-[#dce4ed] bg-white px-4 py-2 text-[12px] font-semibold text-[#52617a] hover:bg-slate-50 transition shadow-xs">
                            Kembali
                        </a>
                        @if($modul->id_quiz)
                            <a href="{{ route('siswa.quiz.detail', $modul->id_quiz) }}"
                               class="rounded-lg bg-emerald-600 px-4 py-2 text-[12px] font-bold text-white hover:bg-emerald-700 shadow-sm transition">
                                Lanjut ke Kuis →
                            </a>
                        @endif
                    </div>
                </div>

                {{-- TABS --}}
                @include('siswa.partials.tabs-modul', ['activeTab' => 'overview'])

                {{-- KONTEN OVERVIEW --}}
                <div id="tab-content-overview" class="pt-5">
                    <p class="max-w-[850px] text-[13px] leading-6 text-[#52617a]">
                        Pelajari materi <strong>{{ $modul->judul_modul }}</strong> ini dengan seksama. Kamu dapat berpindah antar materi sejenjang melalui menu di sebelah kiri, membaca ringkasan pada tab catatan, atau menyelesaikan kuis setelah selesai mempelajari materi.
                    </p>
                </div>

                {{-- KONTEN CATATAN (hidden default) --}}
                <div id="tab-content-catatan" class="pt-5 hidden">
                    @forelse($modul->catatan as $item)
                        <article class="mb-4 rounded-xl border border-slate-200 bg-slate-50/70 p-5 shadow-xs">
                            <h2 class="text-[15px] font-extrabold text-[#172033]">{{ $item->judul }}</h2>
                            <p class="mt-2 text-[13px] leading-6 text-[#52617a] whitespace-pre-line">{{ $item->isi }}</p>
                        </article>
                    @empty
                        <div class="rounded-xl border border-dashed border-slate-200 bg-slate-50/50 p-10 text-center text-sm text-[#7c899c]">
                            Belum ada catatan untuk modul ini.
                        </div>
                    @endforelse
                </div>
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
