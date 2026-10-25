@extends('layouts.siswa')

@section('title', 'Daftar Quiz — Arrava E-Learning')

@section('header')
    <div class="relative w-full max-w-[420px]">
        <svg class="absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-[#8a98ad]" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2">
            <circle cx="11" cy="11" r="7" />
            <path d="m20 20-4-4" />
        </svg>
        <input type="text" id="quiz-search-input" placeholder="Cari quiz atau materi..."
            class="h-10 w-full rounded-lg bg-[#f5f8fc] pl-11 pr-4 text-sm outline-none placeholder:text-[#9aa7b9] focus:ring-2 focus:ring-blue-100">
    </div>
@endsection

@section('content')
    <div class="px-4 sm:px-8 py-8 max-w-7xl mx-auto space-y-6">

        {{-- Error messages --}}
        @if(isset($errors) && $errors->has('quiz'))
            <div
                class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-700 shadow-sm flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span>⚠️</span>
                    <span>{{ $errors->first('quiz') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()"
                    class="text-rose-500 hover:text-rose-800 font-bold">✕</button>
            </div>
        @endif

        @if(isset($errors) && $errors->has('token'))
            <div
                class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-700 shadow-sm flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span>🔒</span>
                    <span>{{ $errors->first('token') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()"
                    class="text-rose-500 hover:text-rose-800 font-bold">✕</button>
            </div>
        @endif

        @if(session('quiz_result'))
            @php $result = session('quiz_result'); @endphp
            <div class="relative overflow-hidden rounded-2xl border border-emerald-200 bg-emerald-50 p-5 shadow-sm">
                @if(($result['poin_didapat'] ?? 0) > 0)
                    <div class="absolute -top-3 -right-3 z-10 pointer-events-none select-none hidden sm:block">
                        <img src="{{ asset('assets/widget/quizBerhasilStempel.webp') }}" alt="Stempel Berhasil"
                            class="w-28 h-28 object-contain drop-shadow-xl transform -rotate-12">
                    </div>
                @endif
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.12em] text-emerald-700">Hasil Submit Quiz</p>
                        <h2 class="mt-1 text-xl font-bold text-emerald-900">
                            {{ $result['is_lulus'] ? 'Selamat, kamu lulus! 🎉' : 'Tetap semangat, coba lagi ya! 💪' }}</h2>
                    </div>
                    <span
                        class="rounded-full bg-emerald-600 px-3 py-1 text-xs font-bold text-white shadow-sm">{{ $result['is_lulus'] ? 'Lulus' : 'Belum lulus' }}</span>
                </div>

                <div class="mt-4 grid gap-3 sm:grid-cols-3">
                    <div class="rounded-xl bg-white px-4 py-3 shadow-sm border border-emerald-100">
                        <div class="text-[11px] uppercase tracking-[0.08em] font-semibold text-slate-500">Poin Didapat</div>
                        <div class="mt-1 text-2xl font-black text-indigo-600">{{ $result['poin_didapat'] }}</div>
                    </div>
                    <div class="rounded-xl bg-white px-4 py-3 shadow-sm border border-emerald-100">
                        <div class="text-[11px] uppercase tracking-[0.08em] font-semibold text-slate-500">Jawaban Benar</div>
                        <div class="mt-1 text-2xl font-black text-emerald-600">{{ $result['benar'] }} <span
                                class="text-sm font-normal text-slate-400">/ {{ $result['total_soal'] }} Soal</span></div>
                    </div>
                    <div class="rounded-xl bg-white px-4 py-3 shadow-sm border border-emerald-100">
                        <div class="text-[11px] uppercase tracking-[0.08em] font-semibold text-slate-500">Status Kelulusan</div>
                        <div class="mt-1 text-lg font-bold {{ $result['is_lulus'] ? 'text-emerald-600' : 'text-amber-600' }}">
                            {{ $result['is_lulus'] ? 'Lulus Sempurna' : 'Perlu Evaluasi' }}
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <div>
                <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-[#172033]">Daftar Quiz</h1>
                <p class="mt-1 text-sm text-[#687892]">Pilih kuis untuk melihat pratinjau materi, aturan pengerjaan, dan
                    mulai berlatih.</p>
            </div>
        </div>

        {{-- Filter Bar --}}
        <form method="GET" action="{{ route('siswa.quiz') }}"
            class="grid gap-3 rounded-2xl border border-[#dfe6ef] bg-white p-4 sm:grid-cols-[minmax(0,1fr)_minmax(0,1fr)_auto_auto] sm:items-end shadow-sm">
            <div>
                <label for="filter-tingkat" class="mb-1.5 block text-xs font-semibold text-[#52627a]">Tingkat
                    Kesulitan</label>
                <select id="filter-tingkat" name="tingkat"
                    class="h-10 w-full rounded-xl border border-[#d5deea] bg-white px-3 text-sm text-[#172033] focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                    <option value="">Semua tingkat</option>
                    @foreach($tingkatQuizList as $tingkat)
                        <option value="{{ $tingkat->id_tingkatquiz }}" @selected(request('tingkat') == $tingkat->id_tingkatquiz)>
                            {{ $tingkat->nama_tingkat }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="filter-sort" class="mb-1.5 block text-xs font-semibold text-[#52627a]">Urutkan</label>
                <select id="filter-sort" name="sort"
                    class="h-10 w-full rounded-xl border border-[#d5deea] bg-white px-3 text-sm text-[#172033] focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                    <option value="terbaru" @selected(request('sort') == 'terbaru')>Terbaru</option>
                    <option value="terlama" @selected(request('sort') == 'terlama')>Terlama</option>
                </select>
            </div>
            <button type="submit"
                class="h-10 rounded-xl bg-[#3180f7] hover:bg-[#246bd4] px-5 text-sm font-bold text-white transition shadow-sm">Terapkan</button>
            <a href="{{ route('siswa.quiz') }}"
                class="inline-flex h-10 items-center justify-center rounded-xl border border-[#d5deea] px-4 text-sm font-semibold text-[#52627a] transition hover:bg-[#f5f8fc]">Reset</a>
        </form>

        {{-- Grid Quiz Cards --}}
        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3" id="quiz-cards-grid">
            @forelse($quizzes as $quiz)
                @php
                    $expired = $quiz->sudahKadaluarsa();
                    $soalCount = $quiz->soal_count ?? $quiz->soal->count();
                    $totalPoin = $quiz->soal->sum('poin');
                    $tingkatNama = $quiz->tingkatQuiz->nama_tingkat ?? 'Umum';
                    $tingkatColor = match (strtolower($tingkatNama)) {
                        'mudah' => 'bg-emerald-500/90 text-white',
                        'sedang' => 'bg-amber-500/90 text-white',
                        'sulit' => 'bg-rose-500/90 text-white',
                        default => 'bg-slate-700/90 text-white',
                    };

                    // Cek apakah siswa berhasil menyelesaikan kuis dan mendapatkan poin
                    $hasilSiswa = $quiz->hasil->sortByDesc('poin_didapat')->first();
                    $sudahSelesaiDanDapatPoin = $quiz->hasil->contains(fn($h) => (int) $h->poin_didapat > 0);
                    $poinDidapatTertinggi = $hasilSiswa ? (int) $hasilSiswa->poin_didapat : 0;

                    $soalList = $quiz->soal->map(function ($s, $idx) {
                        return [
                            'nomor' => $idx + 1,
                            'pertanyaan' => Str::limit(trim(strip_tags($s->pertanyaan)), 120),
                            'jenis' => $s->jenisSoal->nama_jenis ?? 'Pilihan Ganda',
                            'poin' => (int) ($s->poin ?? 10),
                            'durasi' => $s->durasi_detik ? ($s->durasi_detik . ' detik') : null,
                        ];
                    })->values()->toArray();

                    $tipeSoalSummary = $quiz->soal->groupBy(function ($s) {
                        return $s->jenisSoal->nama_jenis ?? 'Pilihan Ganda';
                    })->map(function ($group, $namaJenis) {
                        return [
                            'nama' => $namaJenis,
                            'count' => $group->count(),
                        ];
                    })->values()->toArray();

                    $modalData = [
                        'id_quiz' => $quiz->id_quiz,
                        'judul' => $quiz->judul,
                        'deskripsi' => $quiz->deskripsi ?: 'Kuis ini berisi serangkaian soal latihan interaktif untuk menguji pemahaman Anda. Pastikan koneksi stabil sebelum memulai!',
                        'tingkat' => $quiz->tingkatQuiz->nama_tingkat ?? 'Umum',
                        'durasi' => $quiz->durasi_total_menit ? ($quiz->durasi_total_menit . ' Menit') : 'Fleksibel',
                        'soal_count' => $soalCount,
                        'total_poin' => $totalPoin,
                        'waktu_kadaluarsa' => $quiz->waktu_kadaluarsa ? $quiz->waktu_kadaluarsa->translatedFormat('d M Y, H:i') : null,
                        'is_expired' => $expired,
                        'perlu_token' => $quiz->perluToken(),
                        'foto_url' => $quiz->cover_url,
                        'mulai_url' => route('siswa.quiz.mulai', $quiz->id_quiz),
                        'detail_url' => route('siswa.quiz.detail', $quiz->id_quiz),
                        'opsi_preview' => $quiz->opsi_preview ?? 'lengkap',
                        'soal_list' => $soalList,
                        'tipe_soal_summary' => $tipeSoalSummary,
                        'sudah_selesai' => $sudahSelesaiDanDapatPoin,
                        'poin_didapat_tertinggi' => $poinDidapatTertinggi,
                    ];
                @endphp
                <div class="quiz-card-item hover-frame group relative flex flex-col justify-between rounded-2xl sm:rounded-3xl border border-slate-200 bg-white transition-all duration-300 {{ ($expired && !$quiz->perluToken()) ? 'cursor-not-allowed opacity-75 grayscale' : 'hover:-translate-y-1.5 hover:shadow-xl hover:border-blue-400/60' }}"
                    data-title="{{ strtolower($quiz->judul) }}">

                    <div>
                        {{-- Cover / Thumbnail Area --}}
                        <div class="relative h-44 sm:h-48 w-full overflow-hidden rounded-t-2xl sm:rounded-t-3xl bg-slate-900">
                            <img src="{{ $quiz->cover_url }}" alt="{{ $quiz->judul }}"
                                class="h-full w-full object-cover transition-transform duration-500 ease-out group-hover:scale-105">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/20 to-black/30"></div>

                            {{-- Overlay Rantai Expired Quiz (Hanya untuk kuis yang expired dan bukan kuis bertoken) --}}
                            @if($expired && !$quiz->perluToken())
                                <div class="absolute inset-0 z-10 pointer-events-none select-none flex items-center justify-center bg-black/40 backdrop-blur-[0.5px]">
                                    <img src="{{ asset('assets/widget/expiredQuiz.webp') }}"
                                         alt="Kuis Kadaluarsa"
                                         class="w-full h-full object-cover [image-rendering:pixelated] opacity-90 drop-shadow-md">
                                </div>
                            @endif

                            {{-- Badges on Cover --}}

                            {{-- Top Left: Token Badge --}}
                            @if($quiz->perluToken())
                                <div class="absolute top-3 left-3 z-10">
                                    <span
                                        class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-black bg-purple-950/85 backdrop-blur-md text-purple-200 border border-purple-400/40 shadow-md">
                                        🔒 Token
                                    </span>
                                </div>
                            @endif

                            {{-- Top Right: Stempel Quiz Berhasil Diselesaikan --}}
                            @if($sudahSelesaiDanDapatPoin)
                                <div class="absolute top-2 right-2 z-10 pointer-events-none select-none">
                                    <img src="{{ asset('assets/widget/quizBerhasilStempel.webp') }}" alt="Stempel Selesai"
                                        class="w-20 h-20 sm:w-24 sm:h-24 object-contain drop-shadow-lg transform -rotate-12 transition-transform duration-300 group-hover:scale-105 group-hover:-rotate-6">
                                </div>
                            @endif

                            {{-- Bottom Right on Cover: Tingkat Kesulitan --}}
                            <div class="absolute bottom-3 right-3 z-10">
                                <span
                                    class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-md text-[10px] font-extrabold uppercase tracking-wider backdrop-blur-md shadow-sm {{ $tingkatColor }}">
                                    ● {{ $tingkatNama }}
                                </span>
                            </div>
                        </div>

                        {{-- Card Body --}}
                        <div class="p-5">
                            <h2 class="text-base sm:text-[17px] font-black text-slate-900 group-hover:text-blue-600 transition-colors line-clamp-2 leading-snug"
                                title="{{ $quiz->judul }}">
                                {{ $quiz->judul }}
                            </h2>

                            <p class="mt-2 text-xs text-slate-500 line-clamp-2 leading-relaxed">
                                {{ $quiz->deskripsi ?: 'Kuis interaktif untuk menguji pemahaman materi. Uji kemampuanmu dan dapatkan skor terbaik!' }}
                            </p>

                            {{-- Ringkasan Soal di dalam Quiz --}}
                            @if($quiz->soal->isNotEmpty())
                                <div class="mt-3 flex flex-wrap items-center gap-1.5">
                                    <span class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400">Tipe
                                        Soal:</span>
                                    @foreach($quiz->soal->pluck('jenisSoal.nama_jenis')->filter()->unique() as $namaJenis)
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-100">
                                            ✓ {{ $namaJenis }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif

                            {{-- Mini Stats Bar --}}
                            <div
                                class="mt-4 grid grid-cols-3 gap-2 rounded-2xl bg-slate-50/90 p-2.5 border border-slate-100 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Soal</span>
                                    <span class="text-xs font-black text-slate-800 flex items-center gap-0.5 mt-0.5">
                                        <span>📝</span> {{ $soalCount }}
                                    </span>
                                </div>
                                <div class="flex flex-col items-center justify-center border-x border-slate-200/60 px-1">
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Durasi</span>
                                    <span
                                        class="text-xs font-black text-slate-800 flex items-center gap-0.5 mt-0.5 truncate max-w-full">
                                        <span>⏱️</span>
                                        {{ $quiz->durasi_total_menit ? ($quiz->durasi_total_menit . ' mnt') : 'Fleksibel' }}
                                    </span>
                                </div>
                                <div class="flex flex-col items-center justify-center">
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Poin</span>
                                    <span class="text-xs font-black text-indigo-600 flex items-center gap-0.5 mt-0.5">
                                        <span>🏆</span> {{ $totalPoin }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Card Bottom Action --}}
                    <div class="px-5 pb-5 pt-0">
                        <div class="flex items-center justify-between border-t border-slate-100 pt-3.5">
                            @if($expired)
                                <span class="inline-flex items-center gap-1.5 text-xs font-bold text-rose-600">
                                    <span class="h-2 w-2 rounded-full bg-rose-500"></span>
                                    Kadaluarsa
                                </span>
                                <button type="button" disabled
                                    class="cursor-not-allowed rounded-xl bg-slate-100 px-3.5 py-2 text-xs font-bold text-slate-400">
                                    Waktu Berakhir
                                </button>
                            @else
                                <span class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-600">
                                    <span class="relative flex h-2 w-2">
                                        <span
                                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                                    </span>
                                    Tersedia
                                </span>

                                <div class="flex items-center gap-1.5">
                                    <a href="{{ route('siswa.quiz.detail', $quiz->id_quiz) }}"
                                        class="rounded-xl border border-slate-200 bg-white hover:bg-slate-50 hover:border-slate-300 px-3 py-2 text-xs font-bold text-slate-700 transition shadow-2xs"
                                        title="Lihat halaman preview kuis">
                                        Detail
                                    </a>
                                    <button type="button" data-quiz-start onclick='openQuizPreviewModal(@json($modalData))'
                                        class="inline-flex items-center gap-1.5 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-black text-xs px-4 py-2 transition shadow-sm hover:shadow hover:scale-[1.02]">
                                        <span>Kerjakan</span>
                                        <span>→</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div
                    class="col-span-full rounded-2xl border border-dashed border-[#cfd9e5] bg-white p-12 text-center text-sm text-[#7c899c]">
                    Tidak ada quiz yang sesuai dengan filter ini.
                </div>
            @endforelse
        </div>
    </div>

    {{-- ==================== MODAL PREVIEW QUIZ ==================== --}}
    <div id="quizPreviewModal"
        class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div
            class="relative w-full max-w-xl rounded-3xl bg-white shadow-2xl border border-slate-100 overflow-hidden transform transition-all animate-in fade-in zoom-in duration-200">

            {{-- Modal Header Banner --}}
            <div class="relative overflow-hidden bg-gradient-to-r from-[#0B4FB3] via-[#1368CE] to-[#46178F] text-white">
                <div id="modal-cover-bg"
                    class="absolute inset-0 bg-cover bg-center opacity-25 pointer-events-none transition-all duration-300">
                </div>

                {{-- Overlay Rantai Expired di Modal --}}
                <div id="modal-expired-chains" class="hidden absolute inset-0 z-10 pointer-events-none select-none flex items-center justify-center bg-black/40">
                    <img src="{{ asset('assets/widget/expiredQuiz.webp') }}" alt="Kuis Kadaluarsa"
                        class="w-full h-full object-cover [image-rendering:pixelated] opacity-90 drop-shadow-lg">
                </div>

                {{-- Stempel Quiz Berhasil di Modal --}}
                <div id="modal-stamp-wrapper" class="hidden absolute top-2 right-14 z-10 pointer-events-none select-none">
                    <img src="{{ asset('assets/widget/quizBerhasilStempel.webp') }}" alt="Stempel Selesai"
                        class="w-20 h-20 sm:w-24 sm:h-24 object-contain drop-shadow-2xl transform -rotate-12">
                </div>

                <div class="relative z-10 p-6">
                    <button type="button" onclick="closeQuizPreviewModal()"
                        class="absolute top-4 right-4 h-8 w-8 rounded-full bg-white/20 hover:bg-white/30 text-white flex items-center justify-center transition"
                        title="Tutup">
                        ✕
                    </button>

                    <div class="flex flex-wrap items-center gap-2 mb-2">
                        <span id="modal-tingkat"
                            class="text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-white/20 text-white backdrop-blur">Tingkat</span>
                        <span id="modal-token-badge"
                            class="hidden text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-purple-200 text-purple-950">🔒
                            Butuh Token</span>
                    </div>

                    <h2 id="modal-judul" class="text-xl sm:text-2xl font-black text-white leading-tight">
                        Judul Kuis
                    </h2>
                </div>
            </div>

            {{-- Modal Body --}}
            <div class="p-6 space-y-5 max-h-[70vh] overflow-y-auto">

                {{-- Selesai Banner di Modal --}}
                <div id="modal-selesai-banner"
                    class="hidden p-3.5 rounded-2xl bg-emerald-50 border border-emerald-200 text-xs text-emerald-900 font-semibold flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <span class="text-xl">🏆</span>
                        <div>
                            <span class="font-extrabold block text-emerald-950">Kuis Berhasil Diselesaikan!</span>
                            <span class="text-[11px] text-emerald-700 font-medium">Anda telah mendapatkan poin dari kuis
                                ini. Tetap dapat dikerjakan kembali untuk berlatih.</span>
                        </div>
                    </div>
                    <span id="modal-selesai-poin"
                        class="font-black px-2.5 py-1 rounded-lg bg-emerald-600 text-white text-xs shadow-sm shrink-0">
                        +0 Poin
                    </span>
                </div>

                {{-- Deskripsi Box --}}
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                    <div
                        class="text-[11px] font-extrabold uppercase tracking-wider text-slate-400 mb-1 flex items-center gap-1.5">
                        <span>📝</span> Deskripsi & Gambaran Quiz
                    </div>
                    <p id="modal-deskripsi" class="text-sm text-slate-700 leading-relaxed font-medium">
                        Deskripsi kuis...
                    </p>
                </div>

                {{-- Quick Stats 4 Grid --}}
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                    <div class="p-3 rounded-xl bg-blue-50 border border-blue-100">
                        <span class="text-[10px] font-bold text-blue-700 uppercase tracking-wider block">📋 Total
                            Soal</span>
                        <span id="modal-soal-count" class="text-lg font-black text-blue-950">0 Soal</span>
                    </div>
                    <div class="p-3 rounded-xl bg-indigo-50 border border-indigo-100">
                        <span class="text-[10px] font-bold text-indigo-700 uppercase tracking-wider block">⏱️ Waktu
                            Kuis</span>
                        <span id="modal-durasi" class="text-lg font-black text-indigo-950 leading-tight">Fleksibel</span>
                    </div>
                    <div class="p-3 rounded-xl bg-purple-50 border border-purple-100 col-span-2 sm:col-span-1">
                        <span class="text-[10px] font-bold text-purple-700 uppercase tracking-wider block">🏆 Maks
                            Poin</span>
                        <span id="modal-total-poin" class="text-lg font-black text-purple-950">100 Poin</span>
                    </div>
                </div>

                {{-- Daftar Soal atau Tipe Soal yang Ada di Dalam Quiz --}}
                <div class="p-4 rounded-2xl bg-white border border-slate-200 shadow-sm space-y-3">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-2.5">
                        <div id="modal-soal-list-title"
                            class="text-[11px] font-extrabold uppercase tracking-wider text-slate-700 flex items-center gap-1.5">
                            <span>📋</span> Daftar Soal yang Ada di Dalam Quiz
                        </div>
                        <span id="modal-soal-list-count"
                            class="text-[11px] font-black px-2.5 py-0.5 rounded-full bg-blue-50 text-blue-700 border border-blue-100">
                            0 Soal
                        </span>
                    </div>
                    <div id="modal-soal-list-container" class="space-y-2 max-h-56 overflow-y-auto pr-1">
                        {{-- Diisi secara dinamis oleh JavaScript --}}
                    </div>
                </div>

                {{-- Petunjuk Singkat --}}
                <div class="text-xs text-slate-500 space-y-1.5 bg-amber-50/70 p-3.5 rounded-xl border border-amber-200">
                    <div class="font-bold text-amber-900 flex items-center gap-1.5 mb-1">
                        <span>💡</span> Penting untuk Diingat:
                    </div>
                    <p>• Timer akan langsung berjalan saat kuis dimulai.</p>
                    <p>• Jawaban yang telah dipilih akan dinilai otomatis setelah seluruh soal selesai.</p>
                </div>

                {{-- Form Submit Mulai Quiz --}}
                <form id="modal-form-mulai" method="POST" action="">
                    @csrf

                    {{-- Input Token (Kondisional jika quiz butuh token) --}}
                    <div id="modal-token-wrapper"
                        class="hidden mb-4 p-4 rounded-2xl bg-purple-50 border-2 border-purple-200 space-y-2">
                        <label for="modal-input-token"
                            class="block text-xs font-extrabold text-purple-950 flex items-center justify-between">
                            <span class="flex items-center gap-1.5">
                                <span>🔑</span> Masukkan Token Kuis <span class="text-red-500">*</span>
                            </span>
                            <span class="text-[10px] font-normal text-purple-700">Dapatkan dari Guru</span>
                        </label>

                        <input type="text" name="token" id="modal-input-token" placeholder="CONTOH: KUIS123"
                            class="w-full uppercase font-mono tracking-widest text-center text-lg font-black py-2.5 px-3 rounded-xl border-2 border-purple-300 bg-white text-purple-950 focus:border-purple-600 focus:ring-2 focus:ring-purple-200 outline-none transition placeholder:text-purple-300 placeholder:font-sans placeholder:tracking-normal placeholder:text-xs">
                        <p class="text-[11px] text-purple-700 leading-tight">Kuis ini dilindungi token. Anda harus
                            memasukkan kode yang benar untuk memulai.</p>
                    </div>

                    {{-- Modal Action Buttons --}}
                    <div class="flex items-center justify-between gap-3 pt-2">
                        <button type="button" onclick="closeQuizPreviewModal()"
                            class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-bold text-xs hover:bg-slate-100 transition">
                            Batal
                        </button>

                        <div class="flex items-center gap-2">
                            <a id="modal-detail-link" href="#"
                                class="px-3 py-2.5 rounded-xl border border-slate-300 text-slate-700 font-bold text-xs hover:bg-slate-50 transition">
                                Halaman Penuh
                            </a>
                            <button type="submit" data-quiz-start
                                class="inline-flex items-center gap-1.5 px-6 py-2.5 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-black text-xs shadow-md shadow-blue-500/25 transition transform hover:scale-[1.02]">
                                <span>Mulai Kerjakan</span>
                                <span>🚀</span>
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Live Search Filter for Quiz Cards
            const searchInput = document.getElementById('quiz-search-input');
            if (searchInput) {
                searchInput.addEventListener('input', function () {
                    const query = this.value.toLowerCase().trim();
                    const cards = document.querySelectorAll('.quiz-card-item');
                    cards.forEach(card => {
                        const title = card.getAttribute('data-title') || '';
                        card.style.display = title.includes(query) ? '' : 'none';
                    });
                });
            }

            // Modal Control Functions
            const modalEl = document.getElementById('quizPreviewModal');
            const modalJudul = document.getElementById('modal-judul');
            const modalJenjang = document.getElementById('modal-jenjang');
            const modalTingkat = document.getElementById('modal-tingkat');
            const modalModeBadge = document.getElementById('modal-mode-badge');
            const modalTokenBadge = document.getElementById('modal-token-badge');
            const modalDeskripsi = document.getElementById('modal-deskripsi');
            const modalSoalCount = document.getElementById('modal-soal-count');
            const modalDurasi = document.getElementById('modal-durasi');
            const modalTotalPoin = document.getElementById('modal-total-poin');
            const modalForm = document.getElementById('modal-form-mulai');
            const modalTokenWrapper = document.getElementById('modal-token-wrapper');
            const modalInputToken = document.getElementById('modal-input-token');
            const modalDetailLink = document.getElementById('modal-detail-link');
            const modalCoverBg = document.getElementById('modal-cover-bg');

            function openQuizPreviewModal(data) {
                if (!data) return;

                modalJudul.textContent = data.judul;
                if (modalJenjang) modalJenjang.textContent = data.jenjang;
                modalTingkat.textContent = data.tingkat;
                if (modalModeBadge) modalModeBadge.style.display = 'none';
                modalDeskripsi.textContent = data.deskripsi;
                modalSoalCount.textContent = `${data.soal_count} Soal`;
                modalDurasi.textContent = data.durasi;
                modalTotalPoin.textContent = `${data.total_poin} Poin`;

                // Render Daftar Soal atau Tipe Soal yang Ada di Dalam Quiz
                const soalContainer = document.getElementById('modal-soal-list-container');
                const soalListCount = document.getElementById('modal-soal-list-count');
                const soalListTitle = document.getElementById('modal-soal-list-title');

                const isTipeSaja = data.opsi_preview === 'tipe_saja';

                if (soalListTitle) {
                    soalListTitle.innerHTML = isTipeSaja
                        ? '<span>🏷️</span> Tipe Soal yang Ada di Dalam Quiz'
                        : '<span>📋</span> Daftar Soal yang Ada di Dalam Quiz';
                }

                if (soalListCount) {
                    if (isTipeSaja) {
                        const countJenis = (data.tipe_soal_summary && data.tipe_soal_summary.length) || 0;
                        soalListCount.textContent = `${countJenis} Format Soal`;
                    } else {
                        soalListCount.textContent = `${data.soal_count || 0} Pertanyaan`;
                    }
                }

                if (soalContainer) {
                    soalContainer.innerHTML = '';

                    if (isTipeSaja) {
                        // Tampilan Hanya Tipe Soal
                        if (data.tipe_soal_summary && data.tipe_soal_summary.length > 0) {
                            const grid = document.createElement('div');
                            grid.className = 'grid grid-cols-1 sm:grid-cols-2 gap-2 mb-2';
                            data.tipe_soal_summary.forEach(t => {
                                const card = document.createElement('div');
                                card.className = 'p-2.5 rounded-xl bg-slate-50 border border-slate-200/80 flex items-center justify-between';
                                card.innerHTML = `
                                    <div class="flex items-center gap-2 min-w-0">
                                        <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg bg-blue-100 text-blue-700 text-xs font-bold">✓</span>
                                        <span class="text-xs font-bold text-slate-800 truncate">${t.nama}</span>
                                    </div>
                                    <span class="text-[11px] font-black px-2 py-0.5 rounded-md bg-blue-50 text-blue-700 border border-blue-100 shrink-0">${t.count} Soal</span>
                                `;
                                grid.appendChild(card);
                            });
                            soalContainer.appendChild(grid);

                            const note = document.createElement('div');
                            note.className = 'p-2.5 rounded-xl bg-amber-50 border border-amber-200/80 text-[11px] text-amber-900 flex items-center gap-2';
                            note.innerHTML = '<span></span><span>Detail pertanyaan kuis ini dirahasiakan dan akan ditampilkan setelah Anda memulai kuis.</span>';
                            soalContainer.appendChild(note);
                        } else {
                            soalContainer.innerHTML = '<p class="text-xs text-slate-400 italic py-2 text-center">Belum ada rincian soal untuk kuis ini.</p>';
                        }
                    } else {
                        // Tampilan Preview Soal Lengkap
                        if (data.soal_list && data.soal_list.length > 0) {
                            data.soal_list.forEach(s => {
                                const row = document.createElement('div');
                                row.className = 'p-2.5 rounded-xl bg-slate-50 border border-slate-200/70 hover:border-blue-300 transition-all flex items-start justify-between gap-3';
                                row.innerHTML = `
                                    <div class="flex items-start gap-2.5 min-w-0">
                                        <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-blue-600 text-white text-[10px] font-black mt-0.5">
                                            ${s.nomor}
                                        </span>
                                        <div class="min-w-0">
                                            <p class="text-xs font-bold text-slate-800 line-clamp-2 leading-snug">
                                                ${s.pertanyaan || ('Pertanyaan #' + s.nomor)}
                                            </p>
                                            <div class="mt-1 flex items-center gap-2 text-[10px] text-slate-500">
                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded font-semibold bg-blue-50 text-blue-700 border border-blue-100">
                                                    🏷️ ${s.jenis || 'Pilihan Ganda'}
                                                </span>
                                                ${s.durasi ? `<span>⏱️ ${s.durasi}</span>` : ''}
                                            </div>
                                        </div>
                                    </div>
                                    <span class="shrink-0 text-[10px] font-black px-2 py-0.5 rounded-md bg-indigo-50 text-indigo-700 border border-indigo-100">
                                        +${s.poin || 10} Poin
                                    </span>
                                `;
                                soalContainer.appendChild(row);
                            });
                        } else {
                            soalContainer.innerHTML = '<p class="text-xs text-slate-400 italic py-2 text-center">Belum ada rincian soal untuk kuis ini.</p>';
                        }
                    }
                }

                modalForm.action = data.mulai_url;
                modalDetailLink.href = data.detail_url;

                if (modalCoverBg) {
                    if (data.foto_url) {
                        modalCoverBg.style.backgroundImage = `url('${data.foto_url}')`;
                        modalCoverBg.classList.remove('hidden');
                    } else {
                        modalCoverBg.style.backgroundImage = '';
                        modalCoverBg.classList.add('hidden');
                    }
                }

                if (data.perlu_token) {
                    modalTokenBadge.classList.remove('hidden');
                    modalTokenWrapper.classList.remove('hidden');
                    modalInputToken.required = true;
                    modalInputToken.value = '';
                    setTimeout(() => modalInputToken.focus(), 150);
                } else {
                    modalTokenBadge.classList.add('hidden');
                    modalTokenWrapper.classList.add('hidden');
                    modalInputToken.required = false;
                    modalInputToken.value = '';
                }

                // Tampilkan overlay rantai expired jika kuis kadaluarsa dan bukan bertoken
                const modalExpiredChains = document.getElementById('modal-expired-chains');
                if (modalExpiredChains) {
                    if (data.is_expired && !data.perlu_token) {
                        modalExpiredChains.classList.remove('hidden');
                    } else {
                        modalExpiredChains.classList.add('hidden');
                    }
                }

                // Tampilkan stempel dan banner jika siswa sudah pernah menyelesaikan kuis & dapat poin
                const modalStampWrapper = document.getElementById('modal-stamp-wrapper');
                const modalSelesaiBanner = document.getElementById('modal-selesai-banner');
                const modalSelesaiPoin = document.getElementById('modal-selesai-poin');

                if (data.sudah_selesai) {
                    if (modalStampWrapper) modalStampWrapper.classList.remove('hidden');
                    if (modalSelesaiBanner) modalSelesaiBanner.classList.remove('hidden');
                    if (modalSelesaiPoin) modalSelesaiPoin.textContent = `+${data.poin_didapat_tertinggi || 0} Poin`;
                } else {
                    if (modalStampWrapper) modalStampWrapper.classList.add('hidden');
                    if (modalSelesaiBanner) modalSelesaiBanner.classList.add('hidden');
                }

                modalEl.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }

            function closeQuizPreviewModal() {
                modalEl.classList.add('hidden');
                document.body.style.overflow = '';
            }

            // Close on backdrop click
            if (modalEl) {
                modalEl.addEventListener('click', function (e) {
                    if (e.target === modalEl) {
                        closeQuizPreviewModal();
                    }
                });
            }

            // Close on ESC key
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && !modalEl.classList.contains('hidden')) {
                    closeQuizPreviewModal();
                }
            });

            // If there is an old id_quiz or token error from validation, re-open modal or alert
            @if(old('token') || (isset($errors) && $errors->has('token')))
                @php
                    $targetQuizId = old('id_quiz') ?? (isset($errors) ? $errors->first('id_quiz') : null);
                @endphp
                    // Modal will stay ready
            @endif
        </script>
    @endpush
@endsection
