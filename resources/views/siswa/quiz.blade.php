@extends('layouts.siswa')

@section('title', 'Daftar Quiz — Arrava E-Learning')

@section('header')
<div class="relative w-full max-w-[420px]">
    <svg class="absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-[#8a98ad]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/></svg>
    <input type="text" id="quiz-search-input" placeholder="Cari quiz atau materi..." class="h-10 w-full rounded-lg bg-[#f5f8fc] pl-11 pr-4 text-sm outline-none placeholder:text-[#9aa7b9] focus:ring-2 focus:ring-blue-100">
</div>
@endsection

@section('content')
<div class="px-4 sm:px-8 py-8 max-w-7xl mx-auto space-y-6">

    {{-- Error messages --}}
    @if(isset($errors) && $errors->has('quiz'))
        <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-700 shadow-sm flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span>⚠️</span>
                <span>{{ $errors->first('quiz') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-800 font-bold">✕</button>
        </div>
    @endif

    @if(isset($errors) && $errors->has('token'))
        <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-700 shadow-sm flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span>🔒</span>
                <span>{{ $errors->first('token') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-800 font-bold">✕</button>
        </div>
    @endif

    @if(session('quiz_result'))
        @php $result = session('quiz_result'); @endphp
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-5 shadow-sm">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-emerald-700">Hasil Submit Quiz</p>
                    <h2 class="mt-1 text-xl font-bold text-emerald-900">{{ $result['is_lulus'] ? 'Selamat, kamu lulus! 🎉' : 'Tetap semangat, coba lagi ya! 💪' }}</h2>
                </div>
                <span class="rounded-full bg-emerald-600 px-3 py-1 text-xs font-bold text-white shadow-sm">{{ $result['is_lulus'] ? 'Lulus' : 'Belum lulus' }}</span>
            </div>

            <div class="mt-4 grid gap-3 sm:grid-cols-3">
                <div class="rounded-xl bg-white px-4 py-3 shadow-sm border border-emerald-100">
                    <div class="text-[11px] uppercase tracking-[0.08em] font-semibold text-slate-500">Poin Didapat</div>
                    <div class="mt-1 text-2xl font-black text-indigo-600">{{ $result['poin_didapat'] }}</div>
                </div>
                <div class="rounded-xl bg-white px-4 py-3 shadow-sm border border-emerald-100">
                    <div class="text-[11px] uppercase tracking-[0.08em] font-semibold text-slate-500">Jawaban Benar</div>
                    <div class="mt-1 text-2xl font-black text-emerald-600">{{ $result['benar'] }} <span class="text-sm font-normal text-slate-400">/ {{ $result['total_soal'] }} Soal</span></div>
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
            <p class="mt-1 text-sm text-[#687892]">Pilih kuis untuk melihat pratinjau materi, aturan pengerjaan, dan mulai berlatih.</p>
        </div>
    </div>

    {{-- Filter Bar --}}
    <form method="GET" action="{{ route('siswa.quiz') }}" class="grid gap-3 rounded-2xl border border-[#dfe6ef] bg-white p-4 sm:grid-cols-[minmax(0,1fr)_minmax(0,1fr)_auto_auto] sm:items-end shadow-sm">
        <div>
            <label for="filter-tingkat" class="mb-1.5 block text-xs font-semibold text-[#52627a]">Tingkat Kesulitan</label>
            <select id="filter-tingkat" name="tingkat" class="h-10 w-full rounded-xl border border-[#d5deea] bg-white px-3 text-sm text-[#172033] focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                <option value="">Semua tingkat</option>
                @foreach($tingkatQuizList as $tingkat)
                    <option value="{{ $tingkat->id_tingkatquiz }}" @selected(request('tingkat') == $tingkat->id_tingkatquiz)>{{ $tingkat->nama_tingkat }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="filter-sort" class="mb-1.5 block text-xs font-semibold text-[#52627a]">Urutkan</label>
            <select id="filter-sort" name="sort" class="h-10 w-full rounded-xl border border-[#d5deea] bg-white px-3 text-sm text-[#172033] focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                <option value="terbaru" @selected(request('sort') == 'terbaru')>Terbaru</option>
                <option value="terlama" @selected(request('sort') == 'terlama')>Terlama</option>
            </select>
        </div>
        <button type="submit" class="h-10 rounded-xl bg-[#3180f7] hover:bg-[#246bd4] px-5 text-sm font-bold text-white transition shadow-sm">Terapkan</button>
        <a href="{{ route('siswa.quiz') }}" class="inline-flex h-10 items-center justify-center rounded-xl border border-[#d5deea] px-4 text-sm font-semibold text-[#52627a] transition hover:bg-[#f5f8fc]">Reset</a>
    </form>

    {{-- Grid Quiz Cards --}}
    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3" id="quiz-cards-grid">
        @forelse($quizzes as $quiz)
            @php
                $expired = $quiz->sudahKadaluarsa();
                $isWayground = ($quiz->mode_pengerjaan ?? 'wayground') === 'wayground';
                $soalCount = $quiz->soal_count ?? $quiz->soal->count();
                $totalPoin = $quiz->soal->sum('poin');
                $tingkatNama = $quiz->tingkatQuiz->nama_tingkat ?? 'Umum';
                $tingkatColor = match(strtolower($tingkatNama)) {
                    'mudah' => 'bg-emerald-500/90 text-white',
                    'sedang' => 'bg-amber-500/90 text-white',
                    'sulit' => 'bg-rose-500/90 text-white',
                    default => 'bg-slate-700/90 text-white',
                };
                $modalData = [
                    'id_quiz' => $quiz->id_quiz,
                    'judul' => $quiz->judul,
                    'deskripsi' => $quiz->deskripsi ?: 'Kuis ini berisi serangkaian soal latihan interaktif untuk menguji pemahaman Anda. Pastikan koneksi stabil sebelum memulai!',
                    'jenjang' => $quiz->jenjang->nama_tipe ?? 'Semua jenjang',
                    'tingkat' => $quiz->tingkatQuiz->nama_tingkat ?? 'Umum',
                    'mode' => $isWayground ? 'Wayground (Waktu per Soal)' : 'Kuis Biasa (Waktu Total)',
                    'is_wayground' => $isWayground,
                    'durasi' => $isWayground ? 'Sesuai timer per soal' : (($quiz->durasi_total_menit ?? 30) . ' Menit'),
                    'soal_count' => $soalCount,
                    'total_poin' => $totalPoin,
                    'waktu_kadaluarsa' => $quiz->waktu_kadaluarsa ? $quiz->waktu_kadaluarsa->translatedFormat('d M Y, H:i') : null,
                    'is_expired' => $expired,
                    'perlu_token' => $quiz->perluToken(),
                    'foto_url' => $quiz->foto_quiz ? asset('storage/' . $quiz->foto_quiz) : null,
                    'mulai_url' => route('siswa.quiz.mulai', $quiz->id_quiz),
                    'detail_url' => route('siswa.quiz.detail', $quiz->id_quiz),
                ];
            @endphp
            <div class="quiz-card-item group relative flex flex-col justify-between overflow-hidden rounded-2xl sm:rounded-3xl border border-slate-200 bg-white transition-all duration-300 {{ $expired ? 'cursor-not-allowed opacity-65 grayscale' : 'hover:-translate-y-1.5 hover:shadow-xl hover:border-blue-400/60' }}"
                 data-title="{{ strtolower($quiz->judul) }}">

                <div>
                    {{-- Cover / Thumbnail Area --}}
                    <div class="relative h-44 sm:h-48 w-full overflow-hidden bg-slate-900">
                        @if($quiz->foto_quiz)
                            <img src="{{ asset('storage/' . $quiz->foto_quiz) }}"
                                 alt="{{ $quiz->judul }}"
                                 class="h-full w-full object-cover transition-transform duration-500 ease-out group-hover:scale-105">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/20 to-black/30"></div>
                        @else
                            {{-- Modern sleek fallback gradient with subtle pattern --}}
                            <div class="h-full w-full bg-gradient-to-tr from-[#0F172A] via-[#1E293B] to-[#1E3A8A] relative overflow-hidden flex items-center justify-center">
                                <div class="absolute -right-8 -bottom-8 h-36 w-36 rounded-full bg-blue-500/20 blur-2xl pointer-events-none"></div>
                                <div class="absolute -left-6 -top-6 h-28 w-28 rounded-full bg-indigo-500/20 blur-xl pointer-events-none"></div>
                                
                                {{-- Subtle watermark badge --}}
                                <div class="text-white/20 text-6xl select-none font-black transform -rotate-12 transition-transform duration-500 group-hover:scale-110 group-hover:rotate-0">
                                    {{ $isWayground ? '⚡' : '🎯' }}
                                </div>
                            </div>
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-transparent to-black/20"></div>
                        @endif

                        {{-- Badges on Cover --}}
                        {{-- Top Left: Jenjang Badge --}}
                        <div class="absolute top-3 left-3 z-10">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-black bg-white/95 backdrop-blur-md text-slate-800 shadow-md border border-white/40">
                                🎓 {{ $quiz->jenjang->nama_tipe ?? 'Semua Jenjang' }}
                            </span>
                        </div>

                        {{-- Top Right: Token & Mode Badge --}}
                        <div class="absolute top-3 right-3 z-10 flex items-center gap-1.5">
                            @if($quiz->perluToken())
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-black bg-purple-950/85 backdrop-blur-md text-purple-200 border border-purple-400/40 shadow-md">
                                    🔒 Token
                                </span>
                            @endif

                            @if($isWayground)
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-black bg-amber-400/95 backdrop-blur-md text-slate-950 shadow-md uppercase tracking-wider">
                                    ⚡ Wayground
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-black bg-blue-500/95 backdrop-blur-md text-white shadow-md">
                                    ⏱️ Biasa
                                </span>
                            @endif
                        </div>

                        {{-- Bottom Right on Cover: Tingkat Kesulitan --}}
                        <div class="absolute bottom-3 right-3 z-10">
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-md text-[10px] font-extrabold uppercase tracking-wider backdrop-blur-md shadow-sm {{ $tingkatColor }}">
                                ● {{ $tingkatNama }}
                            </span>
                        </div>
                    </div>

                    {{-- Card Body --}}
                    <div class="p-5">
                        <h2 class="text-base sm:text-[17px] font-black text-slate-900 group-hover:text-blue-600 transition-colors line-clamp-2 leading-snug" title="{{ $quiz->judul }}">
                            {{ $quiz->judul }}
                        </h2>

                        <p class="mt-2 text-xs text-slate-500 line-clamp-2 leading-relaxed">
                            {{ $quiz->deskripsi ?: 'Kuis interaktif untuk menguji pemahaman materi. Uji kemampuanmu dan dapatkan skor terbaik!' }}
                        </p>

                        {{-- Mini Stats Bar --}}
                        <div class="mt-4 grid grid-cols-3 gap-2 rounded-2xl bg-slate-50/90 p-2.5 border border-slate-100 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Soal</span>
                                <span class="text-xs font-black text-slate-800 flex items-center gap-0.5 mt-0.5">
                                    <span>📝</span> {{ $soalCount }}
                                </span>
                            </div>
                            <div class="flex flex-col items-center justify-center border-x border-slate-200/60 px-1">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Durasi</span>
                                <span class="text-xs font-black text-slate-800 flex items-center gap-0.5 mt-0.5 truncate max-w-full">
                                    <span>⏱️</span> {{ $isWayground ? 'Waktu/Soal' : (($quiz->durasi_total_menit ?? 30) . ' mnt') }}
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
                            <button type="button" disabled class="cursor-not-allowed rounded-xl bg-slate-100 px-3.5 py-2 text-xs font-bold text-slate-400">
                                Waktu Berakhir
                            </button>
                        @else
                            <span class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-600">
                                <span class="relative flex h-2 w-2">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                                </span>
                                Tersedia
                            </span>

                            <div class="flex items-center gap-1.5">
                                <a href="{{ route('siswa.quiz.detail', $quiz->id_quiz) }}"
                                   class="rounded-xl border border-slate-200 bg-white hover:bg-slate-50 hover:border-slate-300 px-3 py-2 text-xs font-bold text-slate-700 transition shadow-2xs"
                                   title="Lihat halaman preview kuis">
                                    ℹ️ Detail
                                </a>
                                <button type="button"
                                        onclick='openQuizPreviewModal(@json($modalData))'
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
            <div class="col-span-full rounded-2xl border border-dashed border-[#cfd9e5] bg-white p-12 text-center text-sm text-[#7c899c]">
                Tidak ada quiz yang sesuai dengan filter ini.
            </div>
        @endforelse
    </div>
</div>

{{-- ==================== MODAL PREVIEW QUIZ ==================== --}}
<div id="quizPreviewModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="relative w-full max-w-xl rounded-3xl bg-white shadow-2xl border border-slate-100 overflow-hidden transform transition-all animate-in fade-in zoom-in duration-200">

        {{-- Modal Header Banner --}}
        <div class="relative overflow-hidden bg-gradient-to-r from-[#0B4FB3] via-[#1368CE] to-[#46178F] text-white">
            <div id="modal-cover-bg" class="absolute inset-0 bg-cover bg-center opacity-25 pointer-events-none transition-all duration-300"></div>
            <div class="relative z-10 p-6">
                <button type="button" onclick="closeQuizPreviewModal()"
                        class="absolute top-4 right-4 h-8 w-8 rounded-full bg-white/20 hover:bg-white/30 text-white flex items-center justify-center transition"
                        title="Tutup">
                    ✕
                </button>

                <div class="flex flex-wrap items-center gap-2 mb-2">
                    <span id="modal-jenjang" class="text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-white/20 text-white backdrop-blur">Jenjang</span>
                    <span id="modal-tingkat" class="text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-white/20 text-white backdrop-blur">Tingkat</span>
                    <span id="modal-mode-badge" class="text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-amber-300 text-slate-900">Mode</span>
                    <span id="modal-token-badge" class="hidden text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-purple-200 text-purple-950">🔒 Butuh Token</span>
                </div>

                <h2 id="modal-judul" class="text-xl sm:text-2xl font-black text-white leading-tight">
                    Judul Kuis
                </h2>
            </div>
        </div>

        {{-- Modal Body --}}
        <div class="p-6 space-y-5 max-h-[70vh] overflow-y-auto">

            {{-- Deskripsi Box --}}
            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                <div class="text-[11px] font-extrabold uppercase tracking-wider text-slate-400 mb-1 flex items-center gap-1.5">
                    <span>📝</span> Deskripsi & Gambaran Quiz
                </div>
                <p id="modal-deskripsi" class="text-sm text-slate-700 leading-relaxed font-medium">
                    Deskripsi kuis...
                </p>
            </div>

            {{-- Quick Stats 4 Grid --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                <div class="p-3 rounded-xl bg-blue-50 border border-blue-100">
                    <span class="text-[10px] font-bold text-blue-700 uppercase tracking-wider block">📋 Total Soal</span>
                    <span id="modal-soal-count" class="text-lg font-black text-blue-950">0 Soal</span>
                </div>
                <div class="p-3 rounded-xl bg-indigo-50 border border-indigo-100">
                    <span class="text-[10px] font-bold text-indigo-700 uppercase tracking-wider block">⏱️ Waktu Kuis</span>
                    <span id="modal-durasi" class="text-lg font-black text-indigo-950 leading-tight">20 Detik/Soal</span>
                </div>
                <div class="p-3 rounded-xl bg-purple-50 border border-purple-100 col-span-2 sm:col-span-1">
                    <span class="text-[10px] font-bold text-purple-700 uppercase tracking-wider block">🏆 Maks Poin</span>
                    <span id="modal-total-poin" class="text-lg font-black text-purple-950">100 Poin</span>
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
                <div id="modal-token-wrapper" class="hidden mb-4 p-4 rounded-2xl bg-purple-50 border-2 border-purple-200 space-y-2">
                    <label for="modal-input-token" class="block text-xs font-extrabold text-purple-950 flex items-center justify-between">
                        <span class="flex items-center gap-1.5">
                            <span>🔑</span> Masukkan Token Kuis <span class="text-red-500">*</span>
                        </span>
                        <span class="text-[10px] font-normal text-purple-700">Dapatkan dari Guru</span>
                    </label>

                    <input type="text"
                           name="token"
                           id="modal-input-token"
                           placeholder="CONTOH: KUIS123"
                           class="w-full uppercase font-mono tracking-widest text-center text-lg font-black py-2.5 px-3 rounded-xl border-2 border-purple-300 bg-white text-purple-950 focus:border-purple-600 focus:ring-2 focus:ring-purple-200 outline-none transition placeholder:text-purple-300 placeholder:font-sans placeholder:tracking-normal placeholder:text-xs">
                    <p class="text-[11px] text-purple-700 leading-tight">Kuis ini dilindungi token. Anda harus memasukkan kode yang benar untuk memulai.</p>
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
                        <button type="submit"
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
        searchInput.addEventListener('input', function() {
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
        modalJenjang.textContent = data.jenjang;
        modalTingkat.textContent = data.tingkat;
        modalModeBadge.textContent = data.is_wayground ? 'Wayground' : 'Kuis Biasa';
        modalDeskripsi.textContent = data.deskripsi;
        modalSoalCount.textContent = `${data.soal_count} Soal`;
        modalDurasi.textContent = data.durasi;
        modalTotalPoin.textContent = `${data.total_poin} Poin`;

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

        modalEl.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeQuizPreviewModal() {
        modalEl.classList.add('hidden');
        document.body.style.overflow = '';
    }

    // Close on backdrop click
    if (modalEl) {
        modalEl.addEventListener('click', function(e) {
            if (e.target === modalEl) {
                closeQuizPreviewModal();
            }
        });
    }

    // Close on ESC key
    document.addEventListener('keydown', function(e) {
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
