@extends('layouts.app')

@section('header')
    {{-- Header / Topbar Quiz --}}
    <div class="flex items-center gap-3 min-w-0">

        <div class="min-w-0">

            <h1 class="font-bold text-lg text-slate-800 leading-tight truncate">
                Kelola Kuis Pembelajaran
            </h1>

            <p class="text-xs text-slate-500 truncate">
                Daftar kuis interaktif yang tersedia di platform
            </p>
        </div>
    </div>
@endsection
@section('content')
    <main class="px-6 lg:px-8 py-8">

        {{-- Flash Message --}}
        @if (session('success'))
            <div
                class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <span class="text-2xl">
                        🎉
                    </span>
                    <span class="font-semibold text-sm">
                        {{ session('success') }}
                    </span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
                    ✕
                </button>
            </div>
        @endif
        @if (isset($errors) && $errors->any())
            <div role="alert" aria-live="assertive"
                class="mb-6 rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm font-semibold text-rose-700">
                <div>Kuis tidak dapat diproses:</div>
                <ul class="mt-1 list-inside list-disc space-y-0.5">
                    @foreach ($errors->all() as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Hero Banner --}}
        <div
            class="bg-gradient-to-r from-[#46178F] via-[#1368CE] to-[#0B4FB3] rounded-3xl p-6 sm:p-8 text-white shadow-xl mb-8 relative overflow-hidden">
            {{-- Background Decoration --}}
            <div class="absolute -right-10 -bottom-10 opacity-20 pointer-events-none">
                <svg class="w-72 h-72 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2L2 19h20L12 2z" />
                </svg>
            </div>

            <div class="relative z-10 max-w-2xl">
                <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight mb-2">
                    Buat Pengalaman Belajar Seru untuk Siswa
                </h2>

                <p class="text-white/80 text-sm mb-6">
                    Tambahkan soal pilihan ganda warna-warni,
                    timer detik, serta kunci jawaban langsung
                    dalam satu tampilan visual yang intuitif.
                </p>

                <a href="{{ route('admin.quiz.create') }}"
                    class="inline-flex items-center gap-2 bg-yellow-400 hover:bg-yellow-300 text-slate-900 font-extrabold text-sm px-5 py-3 rounded-xl shadow-lg transition transform hover:scale-105">

                    <span>
                        ⚡ Buka Editor Kuis Baru
                    </span>
                </a>
            </div>
        </div>

        {{-- Filter & Search Card --}}
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs mb-6">
            <div
                class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-4 pb-4 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <h3 class="font-bold text-slate-800 text-base">
                        Semua Kuis
                    </h3>
                    <span
                        class="text-xs font-semibold px-3 py-1 rounded-full bg-indigo-50 text-indigo-700 border border-indigo-100">
                        Total: <span id="total-count">{{ $quizzes->count() }}</span> Kuis
                    </span>
                </div>

                {{-- Realtime Search Input --}}
                <div class="relative w-full sm:w-72">
                    <svg class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" id="searchInput" oninput="filterCards()"
                        placeholder="Cari judul, token, atau jenjang..."
                        class="w-full pl-10 pr-4 py-2 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-slate-50/50">
                </div>
            </div>

            <form method="GET" action="{{ route('admin.quiz') }}" class="flex flex-col sm:flex-row sm:items-end gap-3">
                <div class="flex-1">
                    <label for="filter-jenjang" class="mb-1 block text-xs font-semibold text-slate-500">Jenjang</label>
                    <select id="filter-jenjang" name="jenjang"
                        class="h-9 w-full rounded-lg border border-slate-200 bg-white px-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                        <option value="">Semua jenjang</option>
                        @foreach($jenjangList as $jenjang)
                            <option value="{{ $jenjang->id_jenjang }}" @selected(request('jenjang') == $jenjang->id_jenjang)>
                                {{ $jenjang->nama_tipe }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-1">
                    <label for="filter-mapel" class="mb-1 block text-xs font-semibold text-slate-500">Mata Pelajaran</label>
                    <select id="filter-mapel" name="mapel"
                        class="h-9 w-full rounded-lg border border-slate-200 bg-white px-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                        <option value="">Semua mapel</option>
                        @if(isset($mapelList))
                            @foreach($mapelList as $m)
                                <option value="{{ $m->id_mapel }}" @selected(request('mapel') == $m->id_mapel)>
                                    {{ $m->nama_mapel }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="flex-1">
                    <label for="filter-tingkat" class="mb-1 block text-xs font-semibold text-slate-500">Kesulitan</label>
                    <select id="filter-tingkat" name="tingkat"
                        class="h-9 w-full rounded-lg border border-slate-200 bg-white px-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                        <option value="">Semua tingkat</option>
                        @foreach($tingkatQuizList as $tingkat)
                            <option value="{{ $tingkat->id_tingkatquiz }}"
                                @selected(request('tingkat') == $tingkat->id_tingkatquiz)>{{ $tingkat->nama_tingkat }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-1">
                    <label for="filter-status" class="mb-1 block text-xs font-semibold text-slate-500">Status</label>
                    <select id="filter-status" name="status"
                        class="h-9 w-full rounded-lg border border-slate-200 bg-white px-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                        <option value="">Semua status</option>
                        <option value="published" @selected(request('status') == 'published')>Publikasi (Tersedia)</option>
                        <option value="draft" @selected(request('status') == 'draft')>Draf (Draft)</option>
                        <option value="kadaluarsa" @selected(request('status') == 'kadaluarsa')>Kedaluwarsa</option>
                    </select>
                </div>
                <div class="flex-1">
                    <label for="filter-sort" class="mb-1 block text-xs font-semibold text-slate-500">Urutkan</label>
                    <select id="filter-sort" name="sort"
                        class="h-9 w-full rounded-lg border border-slate-200 bg-white px-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                        <option value="terbaru" @selected(request('sort') == 'terbaru')>Terbaru</option>
                        <option value="terlama" @selected(request('sort') == 'terlama')>Terlama</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit"
                        class="h-9 rounded-lg bg-indigo-600 px-4 text-sm font-semibold text-white transition hover:bg-indigo-700">Terapkan</button>
                    <a href="{{ route('admin.quiz') }}"
                        class="inline-flex h-9 items-center justify-center rounded-lg border border-slate-200 px-4 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">Reset</a>
                </div>
            </form>
        </div>

        {{-- Jika Belum Ada Kuis --}}
        @if ($quizzes->isEmpty())
            <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center shadow-xs">
                <div
                    class="w-16 h-16 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
                    🧩
                </div>

                <h4 class="font-bold text-slate-700 text-base mb-1">
                    Belum Ada Kuis
                </h4>

                <p class="text-slate-400 text-sm max-w-sm mx-auto mb-6">
                    Mulai buat kuis pembelajaran interaktif pertama Anda sekarang!
                </p>

                <a href="{{ route('admin.quiz.create') }}"
                    class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm px-5 py-2.5 rounded-xl transition shadow-sm hover:shadow">
                    + Buat Kuis Sekarang
                </a>
            </div>

            {{-- Tampilan Grid Card Quiz Mirip Card Guru --}}
        @else
            <div id="quizGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach ($quizzes as $quiz)
                    @php
                        $isDraft = $quiz->isDraft();
                        $expired = $quiz->sudahKadaluarsa();
                        $status = $isDraft ? 'Draft' : ($expired ? 'Kadaluarsa' : ($quiz->proggressQuiz ?: 'Tersedia'));
                    @endphp
                    <div class="quiz-card bg-white rounded-2xl border border-gray-100 shadow-xs hover:shadow-md transition-all duration-200 overflow-hidden flex flex-col group"
                        data-judul="{{ strtolower($quiz->judul) }}" data-token="{{ strtolower($quiz->token ?? '') }}"
                        data-jenjang="{{ strtolower($quiz->jenjang->nama_tipe ?? '') }}"
                        data-mapel="{{ strtolower($quiz->mapel->nama_mapel ?? '') }}">

                        <!-- BANNER ATAS DENGAN STATUS & JENJANG -->
                        <div
                            class="h-24 bg-gradient-to-r from-blue-600 via-indigo-600 to-indigo-700 relative p-3.5 flex justify-between items-start">
                            <span
                                class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-white/20 text-white backdrop-blur-xs">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 14l9-5-9-5-9 5 9 5z" />
                                </svg>
                                <span>{{ $quiz->jenjang->nama_tipe ?? 'Semua jenjang' }}</span>
                            </span>

                            @if($isDraft)
                                <span
                                    class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-500/90 text-white shadow-2xs">
                                    <span>Draft</span>
                                </span>
                            @elseif($expired)
                                <span title="Kadaluarsa"
                                    class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-rose-500/90 text-white shadow-2xs">
                                    <span>Kedaluwarsa</span>
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-500/90 text-white shadow-2xs">
                                    <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                                    <span>Tersedia</span>
                                </span>
                            @endif
                        </div>

                        <!-- FOTO / COVER QUIZ (CARD PHOTO OVERLAPPING) -->
                        <div class="relative px-5 pt-0 pb-2">
                            <div class="-mt-12 flex justify-center">
                                <div
                                    class="w-24 h-24 rounded-2xl ring-4 ring-white shadow-md bg-white overflow-hidden flex items-center justify-center shrink-0">
                                    <img src="{{ $quiz->cover_url }}" alt="{{ $quiz->judul }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                </div>
                            </div>

                            <!-- IDENTITAS QUIZ -->
                            <div class="text-center mt-3">
                                <h3 class="text-base font-bold text-slate-800 group-hover:text-indigo-600 transition line-clamp-1"
                                    title="{{ $quiz->judul }}">
                                    {{ $quiz->judul }}
                                </h3>
                                <div class="flex items-center justify-center gap-1.5 mt-1">
                                    <span
                                        class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-50 text-blue-700">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                        {{ $quiz->soal_count ?? 0 }} Soal
                                    </span>
                                    @if($quiz->mapel)
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-100">
                                            {{ $quiz->mapel->nama_mapel }}
                                        </span>
                                    @endif
                                    @if($quiz->tingkatQuiz ?? $quiz->tingkat)
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-600">
                                            {{ ($quiz->tingkatQuiz ?? $quiz->tingkat)->nama_tingkat }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- DETAIL INFO (ID, TOKEN, BATAS WAKTU) -->
                            <div class="mt-4 space-y-1.5">
                                <div
                                    class="bg-slate-50 rounded-xl px-3 py-2 text-xs flex items-center justify-between border border-slate-100">
                                    <span class="text-slate-400 font-medium">ID Kuis</span>
                                    <span class="text-slate-700 font-mono font-semibold">#{{ $quiz->id_quiz }}</span>
                                </div>

                                <div
                                    class="bg-slate-50 rounded-xl px-3 py-2 text-xs flex items-center justify-between border border-slate-100">
                                    <span class="text-slate-400 font-medium">Token Masuk</span>
                                    @if($quiz->token)
                                        <span
                                            class="inline-flex items-center gap-1 font-mono font-bold text-purple-700 bg-purple-50 px-2 py-0.5 rounded-md border border-purple-200 text-[11px]"
                                            title="Token Masuk Kuis">
                                            🔑 {{ $quiz->token }}
                                        </span>
                                    @else
                                        <span class="text-slate-400 italic">Tanpa token</span>
                                    @endif
                                </div>

                                <div
                                    class="bg-slate-50 rounded-xl px-3 py-2 text-xs flex items-center justify-between border border-slate-100">
                                    <span class="text-slate-400 font-medium">Batas Waktu</span>
                                    @if($quiz->waktu_kadaluarsa)
                                        <span class="text-slate-700 font-semibold {{ $expired ? 'text-rose-600' : '' }}"
                                            title="{{ $quiz->waktu_kadaluarsa->format('d M Y H:i') }}">
                                            {{ $quiz->waktu_kadaluarsa->format('d M Y') }}
                                        </span>
                                    @else
                                        <span class="text-slate-400 italic">Tanpa batas waktu</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- FOOTER AKSI TOMBOL -->
                        <div class="mt-auto px-4 py-3 bg-slate-50/70 border-t border-slate-100 flex items-center gap-2">
                            <!-- PRATINJAU -->
                            <a href="{{ route('admin.quiz.preview', $quiz->id_quiz) }}" target="_blank" title="Pratinjau Kuis"
                                class="py-2 px-3 text-xs font-semibold rounded-xl bg-white border border-slate-200 text-slate-700 hover:bg-slate-100 transition flex items-center justify-center gap-1.5 shadow-2xs">
                                <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <span>Pratinjau</span>
                            </a>

                            <!-- EDIT -->
                            <a href="{{ route('admin.quiz.edit', $quiz->id_quiz) }}"
                                class="flex-1 py-2 px-3 text-xs font-semibold rounded-xl bg-white border border-indigo-200 text-indigo-700 hover:bg-indigo-50 hover:border-indigo-300 transition flex items-center justify-center gap-1.5 shadow-2xs">
                                <svg class="w-3.5 h-3.5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                <span>Edit</span>
                            </a>

                            <!-- HAPUS -->
                            <form action="{{ route('admin.quiz.destroy', $quiz->id_quiz) }}" method="POST"
                                onsubmit="return confirm('Hapus kuis {{ addslashes($quiz->judul) }} beserta seluruh soalnya?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Hapus Kuis"
                                    class="py-2 px-3 text-xs font-semibold rounded-xl bg-white border border-rose-200 text-rose-600 hover:bg-rose-50 hover:border-rose-300 transition flex items-center justify-center shadow-2xs">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- State Kosong Saat Pencarian Tidak Ditemukan --}}
            <div id="noResults" class="hidden bg-white rounded-2xl border border-gray-100 p-12 text-center shadow-xs">
                <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <p class="text-base font-bold text-slate-700">Kuis tidak ditemukan</p>
                <p class="text-xs text-slate-400 mt-1">Coba gunakan kata kunci pencarian yang lain.</p>
            </div>
        @endif
    </main>

    <script>
        function filterCards() {
            const query = document.getElementById('searchInput').value.toLowerCase().trim();
            const cards = document.querySelectorAll('.quiz-card');
            let visibleCount = 0;

            cards.forEach(card => {
                const judul = card.getAttribute('data-judul') || '';
                const token = card.getAttribute('data-token') || '';
                const jenjang = card.getAttribute('data-jenjang') || '';
                const mapel = card.getAttribute('data-mapel') || '';

                if (judul.includes(query) || token.includes(query) || jenjang.includes(query) || mapel.includes(query)) {
                    card.style.display = 'flex';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            const noResults = document.getElementById('noResults');
            if (noResults) {
                if (visibleCount === 0 && cards.length > 0) {
                    noResults.classList.remove('hidden');
                } else {
                    noResults.classList.add('hidden');
                }
            }

            const countEl = document.getElementById('total-count');
            if (countEl) {
                countEl.textContent = visibleCount;
            }
        }
    </script>
@endsection