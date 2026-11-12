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

        {{-- Filter & Search Card (Gaya Choice Chip Siswa) --}}
        @php
            $initialStatusMode = 'Semua';
            if (request('status') === 'published') {
                $initialStatusMode = 'Terbit';
            } elseif (request('status') === 'draft') {
                $initialStatusMode = 'Draft';
            } elseif (request('status') === 'kadaluarsa') {
                $initialStatusMode = 'Kedaluwarsa';
            } elseif (strtolower((string) request('mode')) === 'wayground') {
                $initialStatusMode = 'Wayground';
            } elseif (in_array(strtolower((string) request('mode')), ['biasa', 'klasik'], true)) {
                $initialStatusMode = 'Klasik';
            }

            $initialJenjangLabel = 'Semua Jenjang';
            if (request()->filled('jenjang')) {
                if (strtolower((string) request('jenjang')) === 'umum') {
                    $initialJenjangLabel = 'Umum';
                } else {
                    $matchedQuizJenjang = ($jenjangList ?? collect())->firstWhere('id_jenjang', request('jenjang'));
                    if ($matchedQuizJenjang) {
                        $initialJenjangLabel = $matchedQuizJenjang->nama_tipe;
                    }
                }
            }

            $initialTingkatLabel = 'Semua Tingkat';
            if (request()->filled('tingkat')) {
                $matchedTingkat = ($tingkatQuizList ?? collect())->firstWhere('id_tingkatquiz', request('tingkat'));
                if ($matchedTingkat) {
                    $initialTingkatLabel = $matchedTingkat->nama_tingkat;
                }
            }

            $initialMapelLabel = 'Semua Mapel';
            if (request()->filled('mapel')) {
                $matchedMapel = ($mapelList ?? collect())->firstWhere('id_mapel', request('mapel'));
                if ($matchedMapel) {
                    $initialMapelLabel = $matchedMapel->nama_mapel;
                }
            }

            $initialSort = request('sort', 'terbaru') === 'terlama' ? 'terlama' : 'terbaru';
            $hasServerQuizFilter = request()->filled('status')
                || request()->filled('mode')
                || request()->filled('jenjang')
                || request()->filled('tingkat')
                || request()->filled('mapel');
        @endphp

        <div class="mb-6">
            <x-student-style-filter-bar
                title="Semua Kuis"
                icon="🚀"
                searchId="searchInput"
                searchName="q"
                searchValue="{{ request('q') }}"
                searchPlaceholder="Cari judul, token, mapel, atau jenjang..."
                resetId="quizResetBtn"
                resetUrl="{{ route('admin.quiz') }}"
                :showReset="$hasServerQuizFilter || $initialSort !== 'terbaru'">

                <x-slot:headerActions>
                    <button type="button" id="quizSortToggleBtn"
                        data-sort="{{ $initialSort }}"
                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white border border-[#DCEFFF] hover:border-[#007FBE] hover:bg-[#F0F6FF] text-[11px] font-extrabold text-[#007FBE] transition shadow-xs cursor-pointer">
                        <span id="quizSortIcon">{{ $initialSort === 'terlama' ? '↑' : '↓' }}</span>
                        <span id="quizSortLabel">{{ $initialSort === 'terlama' ? 'Terlama' : 'Terbaru' }}</span>
                    </button>

                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-white border border-[#DCEFFF] text-[11px] font-extrabold text-[#465673] shadow-xs">
                        Total:&nbsp;<span id="total-count">{{ $quizzes->count() }}</span>&nbsp;Kuis
                    </span>
                </x-slot:headerActions>

                {{-- Chip Status & Mode --}}
                <x-student-style-filter-chip-bar
                    id="quiz-status-mode-chips"
                    label="Status & Mode"
                    chipClass="quiz-status-mode-chip"
                    dataAttr="data-status-mode"
                    :chips="[
                        ['value' => 'Semua', 'label' => 'Semua', 'active' => $initialStatusMode === 'Semua'],
                        ['value' => 'Terbit', 'label' => 'Terbit', 'active' => $initialStatusMode === 'Terbit'],
                        ['value' => 'Draft', 'label' => 'Draft', 'active' => $initialStatusMode === 'Draft'],
                        ['value' => 'Kedaluwarsa', 'label' => 'Kedaluwarsa', 'active' => $initialStatusMode === 'Kedaluwarsa'],
                        ['value' => 'Wayground', 'label' => 'Wayground', 'active' => $initialStatusMode === 'Wayground'],
                        ['value' => 'Klasik', 'label' => 'Klasik', 'active' => $initialStatusMode === 'Klasik'],
                    ]" />

                {{-- Chip Jenjang --}}
                <x-student-style-filter-chip-bar
                    id="quiz-jenjang-chips"
                    label="Jenjang"
                    chipClass="quiz-jenjang-chip"
                    dataAttr="data-jenjang"
                    :chips="[
                        ['value' => 'Semua Jenjang', 'label' => 'Semua Jenjang', 'active' => $initialJenjangLabel === 'Semua Jenjang'],
                        ['value' => 'SD', 'label' => 'SD', 'active' => strcasecmp($initialJenjangLabel, 'SD') === 0],
                        ['value' => 'SMP', 'label' => 'SMP', 'active' => strcasecmp($initialJenjangLabel, 'SMP') === 0],
                        ['value' => 'SMA', 'label' => 'SMA', 'active' => strcasecmp($initialJenjangLabel, 'SMA') === 0],
                        ['value' => 'Umum', 'label' => 'Umum', 'active' => strcasecmp($initialJenjangLabel, 'Umum') === 0],
                    ]" />

                {{-- Chip Kesulitan --}}
                @php
                    $quizTingkatChips = [
                        ['value' => 'Semua Tingkat', 'label' => 'Semua Tingkat', 'active' => $initialTingkatLabel === 'Semua Tingkat'],
                    ];
                    foreach (($tingkatQuizList ?? collect()) as $tItem) {
                        $quizTingkatChips[] = [
                            'value' => $tItem->nama_tingkat,
                            'label' => $tItem->nama_tingkat,
                            'active' => strcasecmp($initialTingkatLabel, $tItem->nama_tingkat) === 0,
                        ];
                    }
                    if (count($quizTingkatChips) === 1) {
                        foreach (['Mudah', 'Sedang', 'Sulit'] as $fallbackLevel) {
                            $quizTingkatChips[] = [
                                'value' => $fallbackLevel,
                                'label' => $fallbackLevel,
                                'active' => strcasecmp($initialTingkatLabel, $fallbackLevel) === 0,
                            ];
                        }
                    }
                @endphp
                <x-student-style-filter-chip-bar
                    id="quiz-tingkat-chips"
                    label="Kesulitan"
                    chipClass="quiz-tingkat-chip"
                    dataAttr="data-tingkat"
                    :chips="$quizTingkatChips" />

                {{-- Chip Mata Pelajaran (Mapel) --}}
                @if(isset($mapelList) && $mapelList->isNotEmpty())
                    @php
                        $quizMapelChips = [
                            ['value' => 'Semua Mapel', 'label' => 'Semua Mapel', 'active' => $initialMapelLabel === 'Semua Mapel'],
                        ];
                        foreach ($mapelList as $mItem) {
                            $quizMapelChips[] = [
                                'value' => $mItem->nama_mapel,
                                'label' => $mItem->nama_mapel,
                                'active' => strcasecmp($initialMapelLabel, $mItem->nama_mapel) === 0,
                            ];
                        }
                    @endphp
                    <x-student-style-filter-chip-bar
                        id="quiz-mapel-chips"
                        label="Mapel"
                        chipClass="quiz-mapel-chip"
                        dataAttr="data-mapel"
                        :chips="$quizMapelChips" />
                @endif
            </x-student-style-filter-bar>
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
                        $quizStatusKey = $isDraft ? 'draft' : ($expired ? 'kedaluwarsa' : 'terbit');
                        $quizModeKey = strtolower((string) ($quiz->mode_pengerjaan ?? 'wayground')) === 'biasa' ? 'klasik' : 'wayground';
                        $quizJenjangLabel = $quiz->jenjang->nama_tipe ?? 'Umum';
                        $quizTingkatLabel = ($quiz->tingkatQuiz ?? $quiz->tingkat)?->nama_tingkat ?? '';
                        $quizPembuatNama = $quiz->pembuat?->nama ?? 'Admin';
                    @endphp
                    <div class="quiz-card bg-white rounded-2xl border border-gray-100 shadow-xs hover:shadow-md transition-all duration-200 overflow-hidden flex flex-col group"
                        data-judul="{{ strtolower($quiz->judul) }}" data-token="{{ strtolower($quiz->token ?? '') }}"
                        data-jenjang="{{ strtolower($quizJenjangLabel) }}"
                        data-mapel="{{ strtolower($quiz->mapel->nama_mapel ?? '') }}"
                        data-pembuat="{{ strtolower($quizPembuatNama) }}"
                        data-status="{{ $quizStatusKey }}"
                        data-mode="{{ $quizModeKey }}"
                        data-tingkat="{{ strtolower($quizTingkatLabel) }}"
                        data-id="{{ (int) $quiz->id_quiz }}"
                        data-created="{{ $quiz->created_at?->timestamp ?? (int) $quiz->id_quiz }}">

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
                                <div class="flex flex-wrap items-center justify-center gap-1.5 mt-1">
                                    <span
                                        class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-50 text-blue-700">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                        {{ $quiz->soal_count ?? 0 }} Soal
                                    </span>
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-bold {{ $quizModeKey === 'klasik' ? 'bg-amber-50 text-amber-700 border border-amber-200' : 'bg-sky-50 text-[#007FBE] border border-[#DCEFFF]' }}">
                                        {{ $quizModeKey === 'klasik' ? 'Klasik' : 'Wayground' }}
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
                                    <span class="text-slate-400 font-medium">Pengajar</span>
                                    <span class="text-slate-700 font-semibold truncate max-w-[65%]">{{ $quizPembuatNama }}</span>
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
            <div id="noResults" class="hidden bg-white rounded-2xl border-2 border-[#DCEFFF] p-12 text-center shadow-xs">
                <svg class="w-12 h-12 text-[#007FBE]/40 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <p class="text-base font-bold text-[#082765]">Kuis tidak ditemukan</p>
                <p class="text-xs font-semibold text-[#465673] mt-1">Coba ubah kata kunci pencarian atau filter chip yang dipilih.</p>
                <button type="button" onclick="resetQuizFilters()"
                    class="mt-4 inline-flex items-center gap-1.5 rounded-full bg-[#007FBE] hover:bg-[#00679A] px-4 py-2 text-xs font-extrabold text-white shadow-[0_2px_0_#005580] transition cursor-pointer">
                    Reset Filter
                </button>
            </div>
        @endif
    </main>

    <script>
        let activeStatusMode = @json($initialStatusMode);
        let activeQuizJenjang = @json($initialJenjangLabel);
        let activeQuizTingkat = @json($initialTingkatLabel);
        let activeQuizMapel = @json($initialMapelLabel);
        let activeQuizSort = @json($initialSort);
        const hasServerQuizFilter = @json($hasServerQuizFilter);
        const quizResetUrl = @json(route('admin.quiz'));

        function sortQuizCards() {
            const grid = document.getElementById('quizGrid');
            if (!grid) return;
            const cards = Array.from(grid.querySelectorAll('.quiz-card'));
            if (cards.length < 2) return;

            cards.sort((a, b) => {
                const createdA = parseInt(a.dataset.created || '0', 10);
                const createdB = parseInt(b.dataset.created || '0', 10);
                const idA = parseInt(a.dataset.id || '0', 10);
                const idB = parseInt(b.dataset.id || '0', 10);
                const diff = createdA !== createdB ? createdA - createdB : idA - idB;
                return activeQuizSort === 'terlama' ? diff : -diff;
            });

            cards.forEach(card => grid.appendChild(card));
        }

        function filterCards() {
            const filterHelper = window.ArravaStudentFilter;
            const searchInput = document.getElementById('searchInput');
            const query = (searchInput?.value || '').toLowerCase().trim();
            const cards = document.querySelectorAll('.quiz-card');
            let visibleCount = 0;

            cards.forEach(card => {
                const judul = card.getAttribute('data-judul') || '';
                const token = card.getAttribute('data-token') || '';
                const jenjang = card.getAttribute('data-jenjang') || '';
                const mapel = card.getAttribute('data-mapel') || '';
                const pembuat = card.getAttribute('data-pembuat') || '';
                const status = card.getAttribute('data-status') || '';
                const mode = card.getAttribute('data-mode') || '';
                const tingkat = card.getAttribute('data-tingkat') || '';

                const matchQuery = query === ''
                    || judul.includes(query)
                    || token.includes(query)
                    || jenjang.includes(query)
                    || mapel.includes(query)
                    || pembuat.includes(query);

                let matchStatusMode = true;
                const sm = activeStatusMode.toLowerCase();
                if (sm === 'terbit') matchStatusMode = status === 'terbit';
                else if (sm === 'draft') matchStatusMode = status === 'draft';
                else if (sm === 'kedaluwarsa') matchStatusMode = status === 'kedaluwarsa';
                else if (sm === 'wayground') matchStatusMode = mode === 'wayground';
                else if (sm === 'klasik') matchStatusMode = mode === 'klasik';

                const matchJenjang = filterHelper
                    ? filterHelper.matchesJenjangFilter(jenjang, activeQuizJenjang)
                    : true;

                const tk = activeQuizTingkat.toLowerCase();
                const matchTingkat = tk === 'semua tingkat' || tingkat === tk;

                const mp = activeQuizMapel.toLowerCase();
                const matchMapel = mp === 'semua mapel' || mapel === mp;

                if (matchQuery && matchStatusMode && matchJenjang && matchTingkat && matchMapel) {
                    card.style.display = 'flex';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            const noResults = document.getElementById('noResults');
            if (noResults) {
                noResults.classList.toggle('hidden', !(visibleCount === 0 && cards.length > 0));
            }

            const countEl = document.getElementById('total-count');
            if (countEl) {
                countEl.textContent = visibleCount;
            }

            const resetBtn = document.getElementById('quizResetBtn');
            const isDirty = query !== ''
                || activeStatusMode !== 'Semua'
                || activeQuizJenjang !== 'Semua Jenjang'
                || activeQuizTingkat !== 'Semua Tingkat'
                || activeQuizMapel !== 'Semua Mapel'
                || activeQuizSort !== 'terbaru'
                || hasServerQuizFilter;
            if (resetBtn) {
                resetBtn.classList.toggle('hidden', !isDirty);
                resetBtn.classList.toggle('inline-flex', isDirty);
            }
        }

        function resetQuizFilters() {
            if (hasServerQuizFilter) {
                window.location.href = quizResetUrl;
                return;
            }
            const filterHelper = window.ArravaStudentFilter;
            const searchInput = document.getElementById('searchInput');
            const searchClear = document.getElementById('searchInputClear');

            activeStatusMode = 'Semua';
            activeQuizJenjang = 'Semua Jenjang';
            activeQuizTingkat = 'Semua Tingkat';
            activeQuizMapel = 'Semua Mapel';
            activeQuizSort = 'terbaru';

            if (searchInput) searchInput.value = '';
            if (searchClear) {
                searchClear.classList.add('hidden');
                searchClear.classList.remove('inline-flex');
            }
            if (filterHelper) {
                filterHelper.setActiveChip(document.getElementById('quiz-status-mode-chips'), activeStatusMode, 'data-status-mode');
                filterHelper.setActiveChip(document.getElementById('quiz-jenjang-chips'), activeQuizJenjang, 'data-jenjang');
                filterHelper.setActiveChip(document.getElementById('quiz-tingkat-chips'), activeQuizTingkat, 'data-tingkat');
                filterHelper.setActiveChip(document.getElementById('quiz-mapel-chips'), activeQuizMapel, 'data-mapel');
            }
            updateSortButtonUi();
            sortQuizCards();
            filterCards();
        }

        function updateSortButtonUi() {
            const sortBtn = document.getElementById('quizSortToggleBtn');
            const sortIcon = document.getElementById('quizSortIcon');
            const sortLabel = document.getElementById('quizSortLabel');
            if (sortBtn) sortBtn.setAttribute('data-sort', activeQuizSort);
            if (sortIcon) sortIcon.textContent = activeQuizSort === 'terlama' ? '↑' : '↓';
            if (sortLabel) sortLabel.textContent = activeQuizSort === 'terlama' ? 'Terlama' : 'Terbaru';
        }

        document.addEventListener('DOMContentLoaded', () => {
            const filterHelper = window.ArravaStudentFilter;
            const searchInput = document.getElementById('searchInput');
            const searchClear = document.getElementById('searchInputClear');
            const statusContainer = document.getElementById('quiz-status-mode-chips');
            const jenjangContainer = document.getElementById('quiz-jenjang-chips');
            const tingkatContainer = document.getElementById('quiz-tingkat-chips');
            const mapelContainer = document.getElementById('quiz-mapel-chips');
            const sortBtn = document.getElementById('quizSortToggleBtn');
            const resetBtn = document.getElementById('quizResetBtn');

            if (filterHelper) {
                filterHelper.bindSearchClear(searchInput, searchClear, filterCards);
            }

            if (statusContainer) {
                statusContainer.addEventListener('click', (e) => {
                    const btn = e.target.closest('[data-status-mode]');
                    if (!btn) return;
                    if (hasServerQuizFilter) {
                        window.location.href = quizResetUrl;
                        return;
                    }
                    activeStatusMode = btn.getAttribute('data-status-mode') || 'Semua';
                    if (filterHelper) {
                        filterHelper.setActiveChip(statusContainer, activeStatusMode, 'data-status-mode');
                    }
                    filterCards();
                });
            }

            if (jenjangContainer) {
                jenjangContainer.addEventListener('click', (e) => {
                    const btn = e.target.closest('[data-jenjang]');
                    if (!btn) return;
                    if (hasServerQuizFilter) {
                        window.location.href = quizResetUrl;
                        return;
                    }
                    activeQuizJenjang = btn.getAttribute('data-jenjang') || 'Semua Jenjang';
                    if (filterHelper) {
                        filterHelper.setActiveChip(jenjangContainer, activeQuizJenjang, 'data-jenjang');
                    }
                    filterCards();
                });
            }

            if (tingkatContainer) {
                tingkatContainer.addEventListener('click', (e) => {
                    const btn = e.target.closest('[data-tingkat]');
                    if (!btn) return;
                    if (hasServerQuizFilter) {
                        window.location.href = quizResetUrl;
                        return;
                    }
                    activeQuizTingkat = btn.getAttribute('data-tingkat') || 'Semua Tingkat';
                    if (filterHelper) {
                        filterHelper.setActiveChip(tingkatContainer, activeQuizTingkat, 'data-tingkat');
                    }
                    filterCards();
                });
            }

            if (mapelContainer) {
                mapelContainer.addEventListener('click', (e) => {
                    const btn = e.target.closest('[data-mapel]');
                    if (!btn) return;
                    if (hasServerQuizFilter) {
                        window.location.href = quizResetUrl;
                        return;
                    }
                    activeQuizMapel = btn.getAttribute('data-mapel') || 'Semua Mapel';
                    if (filterHelper) {
                        filterHelper.setActiveChip(mapelContainer, activeQuizMapel, 'data-mapel');
                    }
                    filterCards();
                });
            }

            if (sortBtn) {
                sortBtn.addEventListener('click', () => {
                    activeQuizSort = activeQuizSort === 'terbaru' ? 'terlama' : 'terbaru';
                    updateSortButtonUi();
                    sortQuizCards();
                    filterCards();
                });
            }

            if (resetBtn) {
                resetBtn.addEventListener('click', resetQuizFilters);
            }
        });
    </script>
@endsection