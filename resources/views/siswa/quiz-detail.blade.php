@extends('layouts.siswa')

@section('title', 'Detail: ' . $quiz->judul . ' — Arrava E-Learning')

@section('header')
<div class="flex items-center gap-2 text-sm text-[#687892]">
    <a href="{{ route('siswa.quiz') }}" class="hover:text-[#172033] transition flex items-center gap-1 font-medium">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Daftar Quiz
    </a>
    <span>/</span>
    <span class="text-[#172033] font-semibold truncate max-w-[240px]">{{ $quiz->judul }}</span>
</div>
@endsection

@section('content')
@php
    $expired = $quiz->sudahKadaluarsa();
    $totalSoalCount = $totalSoal ?? $quiz->soal->count();
    $totalPoinCount = $totalPoin ?? $quiz->soal->sum('poin');
    $playCount = $quiz->hasil ? $quiz->hasil->count() : 0;
    $pesertaCount = $quiz->hasil ? $quiz->hasil->unique('id_user')->count() : 0;
    $durasiTeks = $quiz->durasi_total_menit ? ($quiz->durasi_total_menit . ' menit') : 'Fleksibel';
@endphp

<div class="max-w-5xl mx-auto px-4 sm:px-6 py-6 space-y-6">

    @if(isset($errors) && $errors->has('quiz'))
        <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-700 shadow-sm flex items-center gap-2">
            <span>⚠️</span>
            <span>{{ $errors->first('quiz') }}</span>
        </div>
    @endif

    @if(isset($errors) && $errors->has('token'))
        <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-700 shadow-sm flex items-center gap-2">
            <span>🔒</span>
            <span>{{ $errors->first('token') }}</span>
        </div>
    @endif

    {{-- KARTU HEADER DETAIL KUIS (KAHOOT STYLE) --}}
    <div class="bg-white rounded-2xl border border-slate-200/90 p-5 sm:p-7 shadow-sm">
        <div class="flex flex-col md:flex-row items-start gap-6">
            {{-- Cover Thumbnail di Kiri --}}
            <div class="relative shrink-0 w-full md:w-72 aspect-video rounded-xl overflow-hidden shadow-md bg-slate-100 border border-slate-200/80">
                <img src="{{ $quiz->cover_url }}" alt="{{ $quiz->judul }}" class="w-full h-full object-cover">

                @if($expired && !$quiz->perluToken())
                    <div class="absolute inset-0 z-10 pointer-events-none select-none flex items-center justify-center bg-black/40 backdrop-blur-[0.5px]">
                        <img src="{{ asset('assets/widget/expiredQuiz.webp') }}"
                             alt="Kuis Kadaluarsa"
                             class="w-full h-full object-cover [image-rendering:pixelated] opacity-90 drop-shadow-md">
                    </div>
                @endif

                @if(isset($hasilSiswa) && $hasilSiswa->is_lulus && $hasilSiswa->poin_didapat > 0)
                    <div class="absolute top-2 right-2 z-10 pointer-events-none select-none">
                        <img src="{{ asset('assets/widget/quizBerhasilStempel.webp') }}"
                             alt="Stempel Selesai"
                             class="w-16 h-16 sm:w-20 sm:h-20 object-contain drop-shadow-2xl transform -rotate-12">
                    </div>
                @endif
            </div>

            {{-- Informasi Kuis di Kanan --}}
            <div class="flex-1 min-w-0 flex flex-col justify-between self-stretch">
                <div>
                    {{-- Badge / Kategori Kahoot Style --}}
                    <div class="flex flex-wrap items-center gap-2 mb-2">
                        <div class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-600 bg-slate-100 px-2.5 py-1 rounded-md">
                            <svg class="w-3.5 h-3.5 text-slate-500" fill="currentColor" viewBox="0 0 20 20">
                                <rect x="2" y="2" width="6" height="6" rx="1.5"/>
                                <rect x="12" y="2" width="6" height="6" rx="1.5"/>
                                <rect x="2" y="12" width="6" height="6" rx="1.5"/>
                                <rect x="12" y="12" width="6" height="6" rx="1.5"/>
                            </svg>
                            <span>{{ $quiz->tingkatQuiz->nama_tingkat ?? 'Kuis Interaktif' }}</span>
                        </div>

                        @if($quiz->perluToken())
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-bold bg-purple-50 text-purple-700 border border-purple-200">
                                Terbuka
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                Terbuka
                            </span>
                        @endif

                        @if(isset($hasilSiswa) && $hasilSiswa->is_lulus && $hasilSiswa->poin_didapat > 0)
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-black bg-amber-100 text-amber-900 border border-amber-300">
                               Selesai (+{{ $hasilSiswa->poin_didapat }} Poin)
                            </span>
                        @endif
                    </div>

                    {{-- Judul Kuis --}}
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight leading-snug mb-2.5">
                        {{ $quiz->judul }}
                    </h1>

                    {{-- Deskripsi dengan Tampilkan lebih banyak --}}
                    <div class="text-sm text-slate-600 leading-relaxed" id="desc-wrapper">
                        @php
                            $deskripsi = trim($quiz->deskripsi ?: 'Kuis interaktif ini dirancang untuk menguji pemahaman materi yang sudah dipelajari. Periksa rincian pertanyaan dan ketentuan sebelum mulai mengerjakan.');
                            $isLong = mb_strlen($deskripsi) > 170;
                        @endphp

                        @if($isLong)
                            <span id="desc-short" class="line-clamp-2">{{ $deskripsi }}</span>
                            <span id="desc-full" class="hidden">{{ $deskripsi }}</span>
                            <button type="button" id="desc-toggle-btn" onclick="toggleDescription()" class="text-slate-500 hover:text-blue-600 font-bold text-xs underline mt-1 inline-block transition">
                                Tampilkan lebih banyak
                            </button>
                        @else
                            <span>{{ $deskripsi }}</span>
                        @endif
                    </div>
                </div>

                {{-- Baris Meta Info (Kali dimainkan, Peserta, Durasi, Poin) --}}
                <div class="mt-5 pt-3.5 border-t border-slate-100 flex flex-wrap items-center gap-x-5 gap-y-2 text-xs font-semibold text-slate-500">
                    <div class="flex items-center gap-1.5" title="Jumlah kuis dimainkan">
                        <svg class="w-3.5 h-3.5 text-slate-600 fill-current" viewBox="0 0 20 20"><path d="M4.5 3.5v13l11-6.5-11-6.5z"/></svg>
                        <span><strong>{{ $playCount }}</strong> kali dimainkan</span>
                    </div>

                    <div class="flex items-center gap-1.5" title="Jumlah peserta">
                        <svg class="w-3.5 h-3.5 text-slate-600 fill-current" viewBox="0 0 20 20"><path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/></svg>
                        <span><strong>{{ $pesertaCount }}</strong> peserta</span>
                    </div>

                    <div class="flex items-center gap-1.5" title="Estimasi durasi kuis">
                        <svg class="w-3.5 h-3.5 text-slate-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                        <span><strong>{{ $durasiTeks }}</strong></span>
                    </div>

                    <div class="flex items-center gap-1.5 text-indigo-600 font-bold" title="Total poin kuis">
                        <span>🏆</span>
                        <span><strong>{{ $totalPoinCount }}</strong> Poin</span>
                    </div>

                    @if($quiz->waktu_kadaluarsa)
                        <div class="flex items-center gap-1.5 {{ $expired ? 'text-rose-600 font-bold' : 'text-slate-500' }}">
                            <span>⏳</span>
                            <span>Batas: {{ $quiz->waktu_kadaluarsa->translatedFormat('d M Y, H:i') }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- BANNER AKSI / PEMBERITAHUAN (TEMA BIRU) --}}
    <div class="rounded-xl bg-gradient-to-r from-[#0B4FB3] via-[#1368CE] to-[#0A3D8F] text-white px-5 py-4 shadow-md flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white/20 text-white font-bold border border-white/40">
                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
            </div>
            <p class="text-xs sm:text-sm font-medium text-white/95 leading-snug">
                @if($expired)
                    Batas waktu pengerjaan kuis ini telah berakhir. Hubungi pengajar jika membutuhkan sesi susulan.
                @elseif($quiz->perluToken())
                    Kuis ini dilindungi token akses. Pastikan Anda sudah menerima token dari pengajar sebelum memulai.
                @else
                    Kuis ini siap dikerjakan dengan {{ $totalSoalCount }} pertanyaan. Uji pemahaman Anda dan raih poin tertinggi!
                @endif
            </p>
        </div>

        <div class="shrink-0 flex items-center justify-end">
            @if($expired)
                <button type="button" disabled class="px-5 py-2.5 rounded-lg bg-white/20 text-white/70 font-bold text-sm cursor-not-allowed">
                    Waktu Berakhir
                </button>
            @elseif($quiz->soal->isEmpty())
                <button type="button" disabled class="px-5 py-2.5 rounded-lg bg-white/20 text-white/70 font-bold text-sm cursor-not-allowed">
                    Belum Ada Soal
                </button>
            @elseif($quiz->perluToken())
                <button type="button" onclick="openTokenModal()" class="px-6 py-2.5 rounded-lg bg-white text-[#0B4FB3] hover:bg-blue-50 hover:text-[#1368CE] font-extrabold text-sm tracking-wide shadow-md transition transform hover:-translate-y-0.5 active:translate-y-0">
                    Mulai Kerjakan
                </button>
            @else
                <form action="{{ route('siswa.quiz.mulai', $quiz->id_quiz) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" data-quiz-start class="px-6 py-2.5 rounded-lg bg-white text-[#0B4FB3] hover:bg-blue-50 hover:text-[#1368CE] font-extrabold text-sm tracking-wide shadow-md transition transform hover:-translate-y-0.5 active:translate-y-0">
                        Mulai Kerjakan
                    </button>
                </form>
            @endif
        </div>
    </div>

    {{-- RIWAYAT PENYELESAIAN SISWA (JIKA SUDAH PERNAH SELESAI & DAPAT POIN) --}}
    @if(isset($hasilSiswa) && $hasilSiswa->is_lulus && $hasilSiswa->poin_didapat > 0)
        <div class="p-4 rounded-xl bg-gradient-to-r from-blue-50 to-indigo-50/70 border border-blue-200 shadow-sm flex items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-[#0B4FB3] to-[#1368CE] text-white shadow-md text-lg">
                    🏆
                </div>
                <div>
                    <h3 class="text-sm font-extrabold text-[#0B4FB3]">Anda Telah Menyelesaikan Kuis Ini</h3>
                    <p class="text-xs text-slate-600 mt-0.5 font-medium">
                        Skor perolehan terbaik: <strong class="text-blue-700 font-black">{{ $hasilSiswa->poin_didapat }} Poin</strong>
                        @if($hasilSiswa->waktu_dapat)
                            <span> • {{ \Carbon\Carbon::parse($hasilSiswa->waktu_dapat)->translatedFormat('d M Y, H:i') }}</span>
                        @endif
                        . Anda tetap dapat mengulang kuis untuk melatih pemahaman.
                    </p>
                </div>
            </div>
            <img src="{{ asset('assets/widget/quizBerhasilStempel.webp') }}"
                 alt="Stempel Selesai"
                 class="w-14 h-14 object-contain shrink-0 hidden sm:block transform -rotate-6 drop-shadow">
        </div>
    @endif

    {{-- KARTU PETUNJUK PENGERJAAN (CLEAN ACCORDION) --}}
    <details class="group bg-white rounded-xl border border-slate-200/90 p-4 shadow-sm transition">
        <summary class="flex items-center justify-between cursor-pointer font-bold text-xs sm:text-sm text-slate-700 select-none">
            <span class="flex items-center gap-2">
                <span>📖</span> Petunjuk & Aturan Pengerjaan
            </span>
            <span class="text-slate-400 group-open:rotate-180 transition-transform duration-200">▼</span>
        </summary>
        <div class="pt-3 border-t border-slate-100 mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed space-y-2">
            <div class="flex items-start gap-2">
                <span class="font-bold text-blue-600">•</span>
                <span>Pastikan koneksi internet stabil sebelum menekan tombol Mulai Kerjakan.</span>
            </div>
            <div class="flex items-start gap-2">
                <span class="font-bold text-blue-600">•</span>
                <span>Setiap soal memiliki batas waktu dan bobot poin tertentu. Kerjakan dengan fokus dan teliti.</span>
            </div>
            @if($quiz->perluToken())
                <div class="flex items-start gap-2">
                    <span class="font-bold text-purple-600">•</span>
                    <span>Kuis ini dilindungi token. Pastikan Anda memasukkan kode token yang valid dari pengajar.</span>
                </div>
            @endif
        </div>
    </details>

    {{-- BAGIAN DAFTAR PERTANYAAN (KAHOOT STYLE - TANPA GAMBAR DI SOAL) --}}
    <div class="space-y-3 pt-2">
        <div class="flex items-center justify-between">
            <h2 class="text-base sm:text-lg font-black text-slate-800 tracking-tight">
                Pertanyaan ({{ $totalSoalCount }})
            </h2>

            <div class="flex items-center gap-2">
                <button type="button" id="toggle-all-btn" onclick="toggleAllAnswers()" class="flex items-center gap-1.5 text-xs font-bold text-slate-600 hover:text-slate-900 transition bg-white px-3 py-1.5 rounded-lg border border-slate-200 shadow-sm">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <span id="toggle-all-label">Tampilkan jawaban</span>
                </button>
            </div>
        </div>

        @if(($quiz->opsi_preview ?? 'lengkap') === 'tipe_saja')
            {{-- Mode Tipe Saja (Rincian pertanyaan disembunyikan pengajar) --}}
            <div class="bg-white rounded-xl border border-slate-200/90 p-5 shadow-sm space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <p class="text-xs font-bold text-slate-600">Distribusi Format Pertanyaan</p>
                    <span class="text-xs font-extrabold px-2.5 py-1 rounded bg-blue-50 text-blue-700 border border-blue-100">
                        {{ $quiz->soal->groupBy(fn($s) => $s->jenisSoal->nama_jenis ?? 'Pilihan Ganda')->count() }} Tipe Soal
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @foreach($quiz->soal->groupBy(fn($s) => $s->jenisSoal->nama_jenis ?? 'Pilihan Ganda') as $namaJenis => $items)
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-700">{{ $namaJenis }}</span>
                            <span class="text-xs font-extrabold text-blue-600 bg-blue-50 px-2 py-0.5 rounded border border-blue-100">{{ $items->count() }} Soal</span>
                        </div>
                    @endforeach
                </div>

                <div class="p-3 rounded-lg bg-amber-50 border border-amber-200 text-xs text-amber-900 flex items-center gap-2">
                    <span>🔒</span>
                    <span>Pertanyaan spesifik dirahasiakan oleh pengajar dan akan ditampilkan langsung begitu Anda menekan tombol <strong>Mulai Kerjakan</strong>.</span>
                </div>
            </div>
        @else
            {{-- Mode Lengkap: Tampilkan baris soal ala Kahoot (layout bersih tanpa gambar soal) --}}
            <div class="space-y-2.5">
                @forelse($quiz->soal as $idx => $s)
                    @php
                        $namaJenis = $s->jenisSoal->nama_jenis ?? 'Kuis';
                        $pertanyaanTeks = trim(strip_tags($s->pertanyaan)) ?: ('Pertanyaan #' . ($idx + 1));
                    @endphp
                    <div class="bg-white rounded-xl border border-slate-200/90 shadow-sm overflow-hidden transition hover:border-slate-300 question-row" data-soal-id="{{ $s->id_soal }}">
                        {{-- Baris Utama Soal --}}
                        <div class="p-4 sm:p-5 flex items-start justify-between gap-4 cursor-pointer select-none" onclick="toggleSingleQuestion('{{ $s->id_soal }}')">
                            <div class="flex-1 min-w-0">
                                {{-- Label Tipe Soal (Slide, Kuis, Benar atau salah, dll) --}}
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="text-[11px] font-semibold tracking-wide text-slate-400 capitalize">
                                        {{ $namaJenis }}
                                    </span>
                                </div>

                                {{-- Teks Pertanyaan --}}
                                <h3 class="text-sm sm:text-[15px] font-bold text-slate-900 leading-snug">
                                    {{ $pertanyaanTeks }}
                                </h3>
                            </div>

                            {{-- Poin, Durasi & Chevron Expand --}}
                            <div class="shrink-0 flex items-center gap-2 pt-0.5">
                                <span class="text-xs font-bold px-2 py-0.5 rounded bg-slate-100 text-slate-600">
                                    +{{ $s->poin ?? 10 }} poin
                                </span>
                                @if($s->durasi_detik)
                                    <span class="hidden sm:inline-flex text-xs font-medium text-slate-400">
                                        ⏱️ {{ $s->durasi_detik }} dtk
                                    </span>
                                @endif
                                <div class="w-7 h-7 flex items-center justify-center rounded-lg text-slate-400 hover:text-slate-700 transition">
                                    <svg id="chevron-{{ $s->id_soal }}" class="w-4 h-4 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        {{-- Area Pilihan Jawaban (Collapsible) --}}
                        <div id="answer-box-{{ $s->id_soal }}" class="hidden px-4 sm:px-5 pb-4 pt-2 border-t border-slate-100 bg-slate-50/70 answer-container">
                            @if($s->pilihanSoal && $s->pilihanSoal->isNotEmpty())
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                                    @php
                                        $kahootColors = [
                                            0 => ['badge' => 'bg-[#E21B3C] text-white', 'symbol' => '▲'],
                                            1 => ['badge' => 'bg-[#1368CE] text-white', 'symbol' => '◆'],
                                            2 => ['badge' => 'bg-[#D89E00] text-white', 'symbol' => '●'],
                                            3 => ['badge' => 'bg-[#26890C] text-white', 'symbol' => '■'],
                                        ];
                                    @endphp
                                    @foreach($s->pilihanSoal as $pIdx => $p)
                                        @php
                                            $c = $kahootColors[$pIdx % 4];
                                            $isCorrect = !empty($p->is_correct);
                                        @endphp
                                        <div class="p-2.5 rounded-lg bg-white border border-slate-200/90 shadow-sm flex items-center justify-between gap-2 text-xs">
                                            <div class="flex items-center gap-2 min-w-0">
                                                <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded text-[10px] font-bold {{ $c['badge'] }}">
                                                    {{ $c['symbol'] }}
                                                </span>
                                                <span class="font-bold text-slate-700 mr-0.5">{{ $p->label ?: chr(65 + $pIdx) }}.</span>
                                                <span class="truncate font-medium text-slate-800">{{ $p->teks_pilihan }}</span>
                                            </div>
                                            @if($isCorrect)
                                                <span class="shrink-0 flex items-center gap-1 text-[11px] font-extrabold text-emerald-700 bg-emerald-50 px-1.5 py-0.5 rounded border border-emerald-200">
                                                    ✓ Kunci
                                                </span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="py-1 text-xs text-slate-500 italic">
                                    Pertanyaan ini bertipe isian / teks terbuka.
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center bg-white rounded-xl border border-slate-200 text-slate-400 text-xs font-medium">
                        Belum ada pertanyaan pada kuis ini.
                    </div>
                @endforelse
            </div>
        @endif
    </div>

    {{-- NAVIGASI BAWAH --}}
    <div class="flex items-center justify-between pt-2">
        <a href="{{ route('siswa.quiz') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:text-slate-900 hover:bg-white font-bold text-xs transition shadow-sm">
            ← Kembali ke Daftar Quiz
        </a>
    </div>

</div>

{{-- MODAL INPUT TOKEN (JIKA PERLU TOKEN) --}}
@if($quiz->perluToken())
    <div id="token-modal" class="{{ (isset($errors) && $errors->has('token')) ? 'flex' : 'hidden' }} fixed inset-0 z-50 items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-100 transform transition-all animate-in fade-in zoom-in-95">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-purple-100 text-purple-700 font-bold">
                        🔒
                    </div>
                    <div>
                        <h3 class="text-base font-extrabold text-slate-900">Masukkan Token Kuis</h3>
                        <p class="text-xs text-slate-500">Kuis ini memerlukan token akses dari pengajar.</p>
                    </div>
                </div>
                <button type="button" onclick="closeTokenModal()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg">
                    ✕
                </button>
            </div>

            <form action="{{ route('siswa.quiz.mulai', $quiz->id_quiz) }}" method="POST" class="mt-4 space-y-4">
                @csrf
                <div>
                    <input type="text"
                           name="token"
                           id="token-input"
                           value="{{ old('token') }}"
                           required
                           autofocus
                           placeholder="KETIKKAN TOKEN DISINI..."
                           class="w-full uppercase font-mono tracking-widest text-center text-lg sm:text-xl font-black py-3 px-4 rounded-xl border-2 {{ (isset($errors) && $errors->has('token')) ? 'border-rose-400 bg-rose-50 text-rose-900 focus:ring-rose-400' : 'border-purple-300 bg-purple-50/30 text-purple-950 focus:border-purple-600 focus:bg-white' }} outline-none transition shadow-sm placeholder:text-slate-300 placeholder:font-sans placeholder:tracking-normal placeholder:text-sm">

                    @if(isset($errors) && $errors->has('token'))
                        <p class="mt-2 text-xs font-bold text-rose-600 flex items-center gap-1 justify-center">
                            <span>❌</span> {{ $errors->first('token') }}
                        </p>
                    @endif
                </div>

                <div class="flex items-center justify-end gap-2 pt-2">
                    <button type="button" onclick="closeTokenModal()" class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-bold text-xs hover:bg-slate-50 transition">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-extrabold text-xs shadow-md transition">
                        Mulai Kerjakan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endif

<script>
    // Toggle Deskripsi (Tampilkan lebih banyak / lebih sedikit)
    function toggleDescription() {
        const shortEl = document.getElementById('desc-short');
        const fullEl = document.getElementById('desc-full');
        const btn = document.getElementById('desc-toggle-btn');
        if (!shortEl || !fullEl || !btn) return;

        if (fullEl.classList.contains('hidden')) {
            fullEl.classList.remove('hidden');
            shortEl.classList.add('hidden');
            btn.textContent = 'Tampilkan lebih sedikit';
        } else {
            fullEl.classList.add('hidden');
            shortEl.classList.remove('hidden');
            btn.textContent = 'Tampilkan lebih banyak';
        }
    }

    // Toggle 1 Pertanyaan (Expand/Collapse pilihan jawaban)
    function toggleSingleQuestion(id) {
        const box = document.getElementById('answer-box-' + id);
        const chevron = document.getElementById('chevron-' + id);
        if (!box) return;

        const isHidden = box.classList.contains('hidden');
        if (isHidden) {
            box.classList.remove('hidden');
            if (chevron) chevron.classList.add('rotate-180');
        } else {
            box.classList.add('hidden');
            if (chevron) chevron.classList.remove('rotate-180');
        }
    }

    // Toggle Semua Jawaban (Expand/Collapse All)
    let allExpanded = false;
    function toggleAllAnswers() {
        allExpanded = !allExpanded;
        const boxes = document.querySelectorAll('.answer-container');
        const chevrons = document.querySelectorAll('[id^="chevron-"]');
        const label = document.getElementById('toggle-all-label');

        boxes.forEach(box => {
            if (allExpanded) {
                box.classList.remove('hidden');
            } else {
                box.classList.add('hidden');
            }
        });

        chevrons.forEach(ch => {
            if (allExpanded) {
                ch.classList.add('rotate-180');
            } else {
                ch.classList.remove('rotate-180');
            }
        });

        if (label) {
            label.textContent = allExpanded ? 'Sembunyikan jawaban' : 'Tampilkan jawaban';
        }
    }

    // Modal Token
    function openTokenModal() {
        const modal = document.getElementById('token-modal');
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            const input = document.getElementById('token-input');
            if (input) setTimeout(() => input.focus(), 100);
        }
    }

    function closeTokenModal() {
        const modal = document.getElementById('token-modal');
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    }
</script>
@endsection
