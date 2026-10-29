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

            @if (session('success'))
                <div class="mt-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800 shadow-sm flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span>🎉</span>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900 font-bold">✕</button>
                </div>
            @endif

            @if (session('error'))
                <div class="mt-4 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-800 shadow-sm flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span>⚠️</span>
                        <span>{{ session('error') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-rose-600 hover:text-rose-900 font-bold">✕</button>
                </div>
            @endif

            {{-- PANEL PROGRES PENYELESAIAN MODUL (SYARAT GANDA) --}}
            @php
                $hasQuiz = $modul->hasQuizModul();
                $isMateriSelesai = (bool) ($progres->materi_selesai ?? false);
                $isQuizLulus = (bool) ($progres->quiz_lulus ?? false);
                $isTuntas = (bool) ($progres->is_tuntas ?? false);
                $kkm = (int) ($modul->kkm_quiz ?: 70);
                $poinReward = (int) ($modul->poin_modul ?: 50);
            @endphp
            <div class="mt-5 rounded-2xl border {{ $isTuntas ? 'border-emerald-200 bg-emerald-50/70' : 'border-slate-200/90 bg-white' }} p-5 shadow-sm transition">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pb-3 border-b {{ $isTuntas ? 'border-emerald-200' : 'border-slate-100' }}">
                    <div class="flex items-center gap-2">
                        <span class="flex h-8 w-8 items-center justify-center rounded-xl {{ $isTuntas ? 'bg-emerald-600 text-white' : 'bg-blue-100 text-blue-700' }} font-bold text-sm">
                            {{ $isTuntas ? '✓' : '🎯' }}
                        </span>
                        <div>
                            <h3 class="text-sm font-extrabold {{ $isTuntas ? 'text-emerald-950' : 'text-slate-900' }}">
                                {{ $isTuntas ? 'Modul Tuntas Sempurna!' : 'Syarat Penyelesaian Modul' }}
                            </h3>
                            <p class="text-xs {{ $isTuntas ? 'text-emerald-700' : 'text-slate-500' }}">
                                {{ $isTuntas ? 'Kamu telah menyelesaikan materi & lulus evaluasi kuis modul.' : 'Selesaikan 2 langkah berikut untuk memperoleh reward poin modul.' }}
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-1.5 self-start sm:self-center">
                        <span class="text-xs font-bold px-3 py-1 rounded-full {{ $isTuntas ? 'bg-emerald-600 text-white shadow-xs' : 'bg-amber-100 text-amber-900 border border-amber-200' }}">
                            🏆 +{{ $isTuntas ? ($progres->poin_didapat ?: $poinReward) : $poinReward }} EXP
                        </span>
                    </div>
                </div>

                {{-- Indikator 2 Langkah Penyelesaian --}}
                <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-3">
                    {{-- Langkah 1: Pelajari Materi --}}
                    <div class="rounded-xl p-3.5 border {{ $isMateriSelesai ? 'border-emerald-200 bg-white text-emerald-900' : 'border-slate-200 bg-slate-50 text-slate-700' }} flex items-center justify-between gap-3">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full text-xs font-bold {{ $isMateriSelesai ? 'bg-emerald-600 text-white' : 'bg-slate-200 text-slate-600' }}">
                                {{ $isMateriSelesai ? '✓' : '1' }}
                            </span>
                            <div class="min-w-0">
                                <p class="text-xs font-bold truncate">1. Pelajari Materi</p>
                                <span class="text-[11px] {{ $isMateriSelesai ? 'text-emerald-700 font-semibold' : 'text-slate-400' }}">
                                    {{ $isMateriSelesai ? 'Selesai dipelajari ✓' : 'Tonton / baca modul' }}
                                </span>
                            </div>
                        </div>
                        @if(!$isMateriSelesai)
                            <form action="{{ route('siswa.modul.selesai_materi', $modul->id_modul) }}" method="POST" class="shrink-0">
                                @csrf
                                <button type="submit" class="px-3 py-1.5 rounded-lg bg-blue-600 text-white font-bold text-xs hover:bg-blue-700 shadow-xs transition">
                                    Tandai Selesai
                                </button>
                            </form>
                        @else
                            <span class="shrink-0 inline-flex items-center gap-1 text-[11px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200">
                                Tuntas
                            </span>
                        @endif
                    </div>

                    {{-- Langkah 2: Kuis Evaluasi Modul --}}
                    <div class="rounded-xl p-3.5 border {{ $isQuizLulus ? 'border-emerald-200 bg-white text-emerald-900' : (($progres->quiz_selesai ?? false) ? 'border-amber-200 bg-white text-amber-900' : 'border-slate-200 bg-slate-50 text-slate-700') }} flex items-center justify-between gap-3">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full text-xs font-bold {{ $isQuizLulus ? 'bg-emerald-600 text-white' : (($progres->quiz_selesai ?? false) ? 'bg-amber-500 text-white' : 'bg-slate-200 text-slate-600') }}">
                                {{ $isQuizLulus ? '✓' : '2' }}
                            </span>
                            <div class="min-w-0">
                                <p class="text-xs font-bold truncate">2. Kuis Modul (KKM: {{ $kkm }})</p>
                                <span class="text-[11px] {{ $isQuizLulus ? 'text-emerald-700 font-semibold' : (($progres->quiz_selesai ?? false) ? 'text-amber-700 font-semibold' : 'text-slate-400') }}">
                                    @if(!$hasQuiz)
                                        Tanpa Kuis Evaluasi (Opsional)
                                    @elseif($isQuizLulus)
                                        Lulus KKM (Nilai: {{ $progres->nilai_quiz }}%)
                                    @elseif($progres->quiz_selesai ?? false)
                                        Remedial (Nilai: {{ $progres->nilai_quiz }}%)
                                    @else
                                        Belum Dikerjakan ({{ $modul->soalModul->count() }} Soal)
                                    @endif
                                </span>
                            </div>
                        </div>
                        @if($hasQuiz)
                            <button type="button" onclick="switchToTab('kuis')" class="shrink-0 px-3 py-1.5 rounded-lg {{ $isQuizLulus ? 'bg-slate-100 text-slate-700 hover:bg-slate-200' : 'bg-indigo-600 text-white hover:bg-indigo-700' }} font-bold text-xs shadow-xs transition">
                                {{ $isQuizLulus ? 'Lihat Kuis' : 'Kerjakan' }}
                            </button>
                        @else
                            <span class="shrink-0 text-[11px] text-slate-400 font-medium">Bebas Kuis</span>
                        @endif
                    </div>
                </div>
            </div>

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
                        @if($hasQuiz)
                            <button type="button" onclick="switchToTab('kuis')"
                               class="rounded-lg bg-indigo-600 px-4 py-2 text-[12px] font-bold text-white hover:bg-indigo-700 shadow-sm transition">
                                Kuis Modul ({{ $modul->soalModul->count() }} Soal) →
                            </button>
                        @endif
                    </div>
                </div>

                {{-- TABS --}}
                @include('siswa.partials.tabs-modul', ['activeTab' => 'overview', 'modul' => $modul, 'progres' => $progres])

                {{-- KONTEN OVERVIEW --}}
                <div id="tab-content-overview" class="pt-5 tab-content-panel">
                    <p class="max-w-[850px] text-[13px] leading-6 text-[#52617a]">
                        Pelajari materi <strong>{{ $modul->judul_modul }}</strong> ini dengan seksama. Kamu dapat berpindah antar materi sejenjang melalui menu di sebelah kiri, membaca ringkasan pada tab catatan, dan menyelesaikan kuis evaluasi modul untuk menguji pemahamanmu serta memperoleh reward EXP.
                    </p>

                    @if(!$isMateriSelesai)
                        <div class="mt-5 p-4 rounded-xl bg-blue-50/70 border border-blue-200/80 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                            <div class="text-xs text-blue-900">
                                <p class="font-bold">Sudah selesai menyimak materi ini?</p>
                                <p class="text-blue-700">Tandai materi selesai untuk melengkapi langkah pertama penyelesaian modul.</p>
                            </div>
                            <form action="{{ route('siswa.modul.selesai_materi', $modul->id_modul) }}" method="POST">
                                @csrf
                                <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-sm transition">
                                    <span>✓</span> Tandai Selesai Menonton/Membaca
                                </button>
                            </form>
                        </div>
                    @endif
                </div>

                {{-- KONTEN CATATAN (hidden default) --}}
                <div id="tab-content-catatan" class="pt-5 hidden tab-content-panel">
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

                {{-- KONTEN KUIS MODUL (hidden default) --}}
                <div id="tab-content-kuis" class="pt-5 hidden tab-content-panel">
                    @if($hasQuiz)
                        <div class="mb-6 p-4 rounded-xl bg-slate-50 border border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                            <div>
                                <h3 class="text-sm font-extrabold text-slate-800">Evaluasi Pemahaman Modul</h3>
                                <p class="text-xs text-slate-500 mt-0.5">
                                    Jawab {{ $modul->soalModul->count() }} soal di bawah ini dengan benar. Batas kelulusan KKM: <strong>{{ $kkm }}%</strong>.
                                </p>
                            </div>
                            <div class="flex items-center gap-2">
                                @if($isQuizLulus)
                                    <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-emerald-100 text-emerald-800 border border-emerald-300 font-extrabold text-xs">
                                        ✓ Lulus (Nilai: {{ $progres->nilai_quiz }}%)
                                    </span>
                                @elseif($progres->quiz_selesai ?? false)
                                    <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-amber-100 text-amber-800 border border-amber-300 font-extrabold text-xs">
                                        ⚠️ Nilai Terakhir: {{ $progres->nilai_quiz }}% (Coba Lagi)
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Form Kuis Modul Interaktif --}}
                        <form action="{{ route('siswa.modul.kuis_submit', $modul->id_modul) }}" method="POST" class="space-y-6">
                            @csrf
                            @foreach($modul->soalModul as $sIdx => $soal)
                                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-xs">
                                    <div class="flex items-center justify-between mb-3 pb-2 border-b border-slate-100 text-xs">
                                        <span class="font-extrabold text-indigo-700 bg-indigo-50 px-2.5 py-1 rounded-md">
                                            Soal #{{ $sIdx + 1 }} dari {{ $modul->soalModul->count() }}
                                        </span>
                                        <span class="font-bold text-slate-400">
                                            Bobot: +{{ $soal->poin ?: 10 }} Poin
                                        </span>
                                    </div>

                                    <h4 class="text-sm font-bold text-slate-900 leading-relaxed mb-4">
                                        {{ $soal->pertanyaan }}
                                    </h4>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                        @php
                                            $kahootPalette = [
                                                0 => ['border' => 'border-rose-200', 'bg' => 'hover:bg-rose-50', 'active' => 'peer-checked:bg-rose-50 peer-checked:border-rose-500 peer-checked:ring-2 peer-checked:ring-rose-200', 'badge' => 'bg-rose-500 text-white'],
                                                1 => ['border' => 'border-blue-200', 'bg' => 'hover:bg-blue-50', 'active' => 'peer-checked:bg-blue-50 peer-checked:border-blue-500 peer-checked:ring-2 peer-checked:ring-blue-200', 'badge' => 'bg-blue-600 text-white'],
                                                2 => ['border' => 'border-amber-200', 'bg' => 'hover:bg-amber-50', 'active' => 'peer-checked:bg-amber-50 peer-checked:border-amber-500 peer-checked:ring-2 peer-checked:ring-amber-200', 'badge' => 'bg-amber-500 text-white'],
                                                3 => ['border' => 'border-emerald-200', 'bg' => 'hover:bg-emerald-50', 'active' => 'peer-checked:bg-emerald-50 peer-checked:border-emerald-500 peer-checked:ring-2 peer-checked:ring-emerald-200', 'badge' => 'bg-emerald-600 text-white'],
                                            ];
                                        @endphp

                                        @foreach($soal->pilihan as $pIdx => $pilihan)
                                            @php $palette = $kahootPalette[$pIdx % 4]; @endphp
                                            <label class="relative flex items-center p-3 rounded-xl border {{ $palette['border'] }} {{ $palette['bg'] }} has-[:checked]:border-indigo-600 has-[:checked]:ring-2 has-[:checked]:ring-indigo-300 has-[:checked]:bg-indigo-50/60 cursor-pointer transition select-none">
                                                <input type="radio" name="jawaban[{{ $soal->id_soal }}]" value="{{ $pilihan->id_pilihan }}" required class="peer sr-only">
                                                <div class="flex items-center gap-3 w-full">
                                                    <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg text-xs font-black {{ $palette['badge'] }} shadow-xs">
                                                        {{ $pilihan->label ?: chr(65 + $pIdx) }}
                                                    </span>
                                                    <span class="text-xs font-semibold text-slate-800 leading-snug">
                                                        {{ $pilihan->teks_pilihan }}
                                                    </span>
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach

                            <div class="pt-3 flex items-center justify-end">
                                <button type="submit" class="px-6 py-3 rounded-xl bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 text-white font-extrabold text-sm shadow-md transition transform hover:-translate-y-0.5">
                                    🚀 Kumpulkan Jawaban Kuis Modul
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50/50 p-12 text-center text-sm text-slate-500">
                            <span class="text-3xl block mb-2">📖</span>
                            <p class="font-bold text-slate-700">Modul Ini Bebas Kuis Evaluasi</p>
                            <p class="text-xs text-slate-400 mt-1">
                                Anda hanya perlu menyelesaikan materi untuk menandai modul ini tuntas dan mengklaim poin.
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
</div>

@push('scripts')
<script>
    function switchToTab(tabName) {
        document.querySelectorAll('.tab-content-panel').forEach(p => p.classList.add('hidden'));
        const targetPanel = document.getElementById('tab-content-' + tabName);
        if (targetPanel) {
            targetPanel.classList.remove('hidden');
        }

        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('text-[#3180f7]');
            btn.classList.add('text-[#52617a]');
            const indicator = btn.querySelector('.tab-indicator');
            if (indicator) indicator.classList.add('hidden');
        });

        const activeBtn = document.querySelector('.tab-btn-' + tabName);
        if (activeBtn) {
            activeBtn.classList.remove('text-[#52617a]');
            activeBtn.classList.add('text-[#3180f7]');
            const indicator = activeBtn.querySelector('.tab-indicator');
            if (indicator) indicator.classList.remove('hidden');
        }
    }

    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const tab = btn.dataset.tab;
            if (tab) switchToTab(tab);
        });
    });
</script>
@endpush
@endsection
