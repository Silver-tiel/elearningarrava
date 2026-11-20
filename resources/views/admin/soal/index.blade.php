@extends('layouts.app')

@section('title', 'Bank Soal - Arrava')

@section('header')
    {{-- Header / Topbar Quiz & Bank Soal --}}
    <div class="flex items-center justify-between gap-4 w-full">
        <div class="min-w-0 hidden md:block">
            <h1 class="font-bold text-lg text-slate-800 leading-tight truncate">
                Bank Soal Pembelajaran
            </h1>
            <p class="text-xs text-slate-500 truncate">
                Koleksi dan repositori soal mandiri untuk kuis dan evaluasi
            </p>
        </div>

        <x-quiz-header-tabs />
    </div>
@endsection

@section('content')
    <main class="px-6 lg:px-8 py-8">
        {{-- Page heading --}}
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-7">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-sky-50 text-[#007FBE] border border-[#B2E7FC] text-xs font-extrabold mb-2">
                    <span>📚 Repositori Soal & Dungeon</span>
                </div>
                <h2 class="text-[24px] font-extrabold tracking-tight text-slate-900">
                    Bank Soal
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Kelola soal mandiri (Bank Soal) dan soal pada kuis. Anda dapat menyalin soal bank ke kuis atau menyalin soal kuis ke bank soal kapan saja.
                </p>
            </div>

            <div class="flex items-center gap-2.5">
                <a href="{{ route('soal.create') }}"
                    class="inline-flex items-center justify-center gap-2 bg-[#007FBE] hover:bg-[#00689E] text-white font-bold text-sm px-4 py-2.5 rounded-xl shadow-[0_3px_0_#005580] transition hover:-translate-y-0.5">
                    <span class="text-lg leading-none">+</span>
                    <span>Tambah Soal Baru</span>
                </a>
            </div>
        </div>

        {{-- Flash message --}}
        @if(session('success'))
            <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between shadow-xs">
                <div class="flex items-center gap-3">
                    <span class="text-xl">✓</span>
                    <span class="font-semibold text-sm">{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
                    ✕
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 flex items-center justify-between shadow-xs">
                <div class="flex items-center gap-3">
                    <span class="text-xl">⚠️</span>
                    <span class="font-semibold text-sm">{{ session('error') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700">
                    ✕
                </button>
            </div>
        @endif

        @php
            $currentSumber = request('sumber', 'all');
            $currentMapel = request('mapel_id', 'all');
            $currentJenis = request('jenis_soal', 'all');
            $currentTingkat = request('tingkat_soal', 'all');
            $currentJenjang = request('jenjang_id', 'all');
            $currentQuery = request('q', '');

            $isFiltered = $currentSumber !== 'all'
                || ($currentMapel !== 'all' && !empty($currentMapel))
                || $currentJenis !== 'all'
                || $currentTingkat !== 'all'
                || ($currentJenjang !== 'all' && !empty($currentJenjang))
                || $currentQuery !== '';

            // Filter Chips Sumber
            $sourceFilterChips = [
                ['value' => 'all', 'label' => 'Semua Sumber', 'active' => $currentSumber === 'all'],
                ['value' => 'bank', 'label' => '📚 Bank Soal Saja', 'active' => $currentSumber === 'bank'],
                ['value' => 'quiz', 'label' => '🎯 Terkait Kuis', 'active' => $currentSumber === 'quiz'],
            ];

            // Filter Chips Tipe Soal
            $soalFilterChips = [
                ['value' => 'all', 'label' => 'Semua Tipe', 'active' => $currentJenis === 'all'],
                ['value' => 'pilihan_ganda', 'label' => 'Pilihan Ganda', 'active' => $currentJenis === 'pilihan_ganda'],
                ['value' => 'benar_salah', 'label' => 'Benar/Salah', 'active' => $currentJenis === 'benar_salah'],
                ['value' => 'isian', 'label' => 'Isian Singkat', 'active' => $currentJenis === 'isian'],
                ['value' => 'bergambar', 'label' => '🖼️ Bergambar', 'active' => $currentJenis === 'bergambar'],
            ];

            // Filter Chips Tingkat Kesulitan
            $tingkatFilterChips = [
                ['value' => 'all', 'label' => 'Semua Tingkat', 'active' => $currentTingkat === 'all'],
                ['value' => 'mudah', 'label' => '🟢 Mudah', 'active' => $currentTingkat === 'mudah'],
                ['value' => 'sedang', 'label' => '🟡 Sedang', 'active' => $currentTingkat === 'sedang'],
                ['value' => 'sulit', 'label' => '🔴 Sulit', 'active' => $currentTingkat === 'sulit'],
            ];

            // Filter Chips Jenjang
            $jenjangChips = [
                ['value' => 'all', 'label' => 'Semua Jenjang', 'active' => $currentJenjang === 'all']
            ];
            if (isset($jenjangList)) {
                foreach ($jenjangList as $j) {
                    $jenjangChips[] = [
                        'value' => (string) $j->id_jenjang,
                        'label' => $j->nama_tipe ?? $j->nama_jenjang,
                        'active' => (string) $currentJenjang === (string) $j->id_jenjang,
                    ];
                }
            }

            $countDisplay = isset($totalFiltered) ? $totalFiltered : $soals->total();
        @endphp

        {{-- FORM FILTER & SEARCH GAYA SISWA ARRAVA --}}
        <form method="GET" action="{{ route('admin.soal') }}" id="soalFilterForm">
            {{-- Hidden inputs to store active filter chip values --}}
            <input type="hidden" name="sumber" id="filterInputSumber" value="{{ $currentSumber }}">
            <input type="hidden" name="jenis_soal" id="filterInputJenis" value="{{ $currentJenis }}">
            <input type="hidden" name="tingkat_soal" id="filterInputTingkat" value="{{ $currentTingkat }}">
            <input type="hidden" name="jenjang_id" id="filterInputJenjang" value="{{ $currentJenjang }}">

            <x-student-style-filter-bar
                class="mb-6"
                title="Filter & Pencarian Bank Soal"
                icon="🔍"
                count-id="soal-count-badge"
                :count-text="'Menampilkan ' . $soals->count() . ' dari ' . $countDisplay . ' soal'"
                search-id="soalSearchInput"
                search-name="q"
                search-value="{{ $currentQuery }}"
                search-placeholder="Cari pertanyaan, kode soal, mapel, atau kunci jawaban..."
                reset-id="soalResetBtn"
                reset-url="{{ route('admin.soal') }}"
                :show-reset="$isFiltered">

                {{-- Row Filter 1: Dropdown Mapel & Chips Sumber --}}
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 pt-1 border-t border-sky-100/60">
                    <div class="flex items-center gap-2">
                        <span class="text-[11px] font-black uppercase tracking-wider text-[#465673] shrink-0">Mapel:</span>
                        <select name="mapel_id" id="soalMapelSelect"
                            class="px-3 py-1.5 rounded-xl border border-[#DCEFFF] bg-white text-xs font-bold text-slate-700 focus:outline-none focus:border-[#007FBE] shadow-2xs cursor-pointer">
                            <option value="all" @selected($currentMapel === 'all' || empty($currentMapel))>-- Semua Mata Pelajaran --</option>
                            @if(isset($mapelList))
                                @foreach($mapelList as $mpl)
                                    <option value="{{ $mpl->id_mapel }}" @selected((string)$currentMapel === (string)$mpl->id_mapel)>
                                        {{ $mpl->nama_mapel }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <x-student-style-filter-chip-bar
                        id="soalSourceFilterChips"
                        label="Sumber"
                        :chips="$sourceFilterChips" />
                </div>

                {{-- Row Filter 2: Chips Tipe Soal & Tingkat Kesulitan --}}
                <div class="space-y-2 pt-1 border-t border-sky-100/60">
                    <x-student-style-filter-chip-bar
                        id="soalTypeFilterChips"
                        label="Tipe Soal"
                        :chips="$soalFilterChips" />

                    <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                        <x-student-style-filter-chip-bar
                            id="soalTingkatFilterChips"
                            label="Tingkat"
                            :chips="$tingkatFilterChips" />

                        @if(count($jenjangChips) > 1)
                            <x-student-style-filter-chip-bar
                                id="soalJenjangFilterChips"
                                label="Jenjang"
                                :chips="$jenjangChips" />
                        @endif
                    </div>
                </div>
            </x-student-style-filter-bar>
        </form>

        @if($soals->isEmpty())
            <div class="bg-white rounded-3xl border border-gray-200/80 p-12 text-center shadow-xs">
                <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-sky-50 text-[#007FBE] flex items-center justify-center text-3xl">
                    📝
                </div>
                <h3 class="text-lg font-extrabold text-gray-800">
                    {{ $isFiltered ? 'Tidak ada soal yang cocok dengan filter' : 'Belum Ada Soal di Bank Soal' }}
                </h3>
                <p class="text-sm text-gray-500 mt-1 max-w-md mx-auto">
                    {{ $isFiltered ? 'Silakan ubah filter atau kata kunci pencarian Anda untuk melihat pertanyaan lainnya.' : 'Tambahkan pertanyaan baru ke Bank Soal agar siap digunakan dalam kuis siswa maupun tantangan dungeon.' }}
                </p>
                <div class="mt-5 flex items-center justify-center gap-3">
                    @if($isFiltered)
                        <a href="{{ route('admin.soal') }}"
                            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-slate-100 text-slate-700 font-bold text-sm hover:bg-slate-200 transition">
                            <span>✕ Reset Semua Filter</span>
                        </a>
                    @endif
                    <a href="{{ route('soal.create') }}"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#007FBE] text-white font-bold text-sm hover:bg-[#00689E] transition">
                        <span>+ Tambah Soal Baru</span>
                    </a>
                </div>
            </div>
        @else
            {{-- Batch Actions Bar (Muncul saat ada checkbox dicentang) --}}
            <div id="batchActionBar" class="hidden mb-4 p-4 rounded-2xl bg-gradient-to-r from-sky-600 to-[#007FBE] text-white flex flex-wrap items-center justify-between gap-3 shadow-md">
                <div class="flex items-center gap-3">
                    <span class="text-xl">📥</span>
                    <div>
                        <p class="text-sm font-extrabold" id="batchCountText">0 soal dipilih</p>
                        <p class="text-xs text-sky-100">Pilih aksi untuk soal-soal terpilih</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <button type="button" id="openBatchCopyToBankBtn"
                        class="px-4 py-2 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white font-extrabold text-xs shadow transition cursor-pointer">
                        💾 Salin ke Bank Soal
                    </button>
                    <button type="button" id="openBatchAssignModalBtn"
                        class="px-4 py-2 rounded-xl bg-white text-[#007FBE] hover:bg-sky-50 font-extrabold text-xs shadow transition cursor-pointer">
                        ➕ Masukkan ke Kuis
                    </button>
                    <button type="button" id="clearBatchSelectionBtn"
                        class="px-3 py-2 rounded-xl bg-white/20 hover:bg-white/30 text-white font-bold text-xs transition cursor-pointer">
                        Batal
                    </button>
                </div>
            </div>

            <div id="soalCardsContainer" class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                @foreach ($soals as $soal)
                    @php
                        $isBank = is_null($soal->id_quiz);
                        $rawJenis = strtolower(trim((string) ($soal->jenisSoal?->nama_jenis ?? '')));
                        $idJenis = (int) ($soal->id_jenis_soal ?? 0);

                        if (str_contains($rawJenis, 'benar') || str_contains($rawJenis, 'true_false') || str_contains($rawJenis, 'salah') || $idJenis === 3) {
                            $jenisSlug = 'benar_salah';
                            $jenisLabel = 'Benar/Salah';
                            $jenisBadgeClass = 'bg-amber-50 text-amber-700 border-amber-200';
                        } elseif (str_contains($rawJenis, 'isian') || str_contains($rawJenis, 'essay') || $idJenis === 2) {
                            $jenisSlug = 'isian';
                            $jenisLabel = 'Isian Singkat';
                            $jenisBadgeClass = 'bg-purple-50 text-purple-700 border-purple-200';
                        } else {
                            $jenisSlug = 'pilihan_ganda';
                            $jenisLabel = 'Pilihan Ganda';
                            $jenisBadgeClass = 'bg-sky-50 text-[#007FBE] border-[#B2E7FC]';
                        }

                        $tingkatSlug = (!empty($soal->tingkat_soal)) ? strtolower(trim($soal->tingkat_soal)) : 'sedang';
                        $tingkatLabel = match ($tingkatSlug) {
                            'mudah' => '🟢 Mudah',
                            'sulit' => '🔴 Sulit',
                            default => '🟡 Sedang',
                        };

                        $hasImage = !empty($soal->foto_soal);
                        $mapelObj = $soal->mapel ?? $soal->quiz?->mapel;
                        $mapelId = (string) ($soal->id_mapel ?? $soal->quiz?->id_mapel ?? '');
                        $mapelLabel = $mapelObj?->nama_mapel ?? 'Semua Mapel';

                        $jenjangObj = $soal->jenjang ?? $soal->quiz?->jenjang;
                        $jenjangId = (string) ($soal->id_jenjang ?? $soal->quiz?->id_jenjang ?? '');
                        $jenjangLabel = $jenjangObj?->nama_tipe ?? $jenjangObj?->nama_jenjang ?? 'Umum';

                        $quizLabel = $soal->quiz?->judul ?? $soal->quiz?->judul_quiz ?? 'Bank Soal';
                        $penulisLabel = $soal->penulis?->nama ?? 'Admin';
                    @endphp

                    <article
                        class="soal-card bg-white rounded-2xl border-2 border-[#E6F1FC] p-5 shadow-xs hover:border-[#B2E7FC] transition flex flex-col justify-between gap-4">

                        <div class="space-y-3">
                            {{-- Top Header Row: Checkbox, Badges & Code --}}
                            <div class="flex items-start justify-between gap-2">
                                <div class="flex flex-wrap items-center gap-1.5 flex-1 min-w-0">
                                    {{-- Checkbox untuk batch assign/copy --}}
                                    <label class="inline-flex items-center mr-1 cursor-pointer" title="Pilih soal ini">
                                        <input type="checkbox"
                                            class="soal-select-checkbox rounded text-[#007FBE] focus:ring-0 w-4 h-4 cursor-pointer"
                                            value="{{ $soal->id_soal }}"
                                            data-is-bank="{{ $isBank ? '1' : '0' }}"
                                            data-question-title="{{ Str::limit($soal->pertanyaan, 40) }}">
                                    </label>

                                    {{-- Badge Sumber: Bank Soal vs Kuis --}}
                                    @if($isBank)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-extrabold bg-indigo-50 text-indigo-700 border border-indigo-200 shadow-2xs">
                                            📚 Bank Soal
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-extrabold bg-sky-50 text-[#007FBE] border border-[#B2E7FC] shadow-2xs"
                                            title="Terkait kuis: {{ $quizLabel }}">
                                            🎯 {{ Str::limit($quizLabel, 18) }}
                                        </span>
                                    @endif

                                    {{-- Jenis Soal --}}
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-extrabold border {{ $jenisBadgeClass }}">
                                        {{ $jenisLabel }}
                                    </span>

                                    {{-- Tingkat Kesulitan --}}
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-50 text-slate-700 border border-slate-200">
                                        {{ $tingkatLabel }}
                                    </span>

                                    {{-- Foto badge --}}
                                    @if($hasImage)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            🖼️ Foto
                                        </span>
                                    @endif
                                </div>

                                @if(!empty($soal->kode_soal))
                                    <span class="text-[11px] font-mono font-semibold text-slate-400 shrink-0">
                                        {{ $soal->kode_soal }}
                                    </span>
                                @endif
                            </div>

                            {{-- Sub Meta: Mapel, Jenjang, Skor, Timer --}}
                            <div class="text-xs font-semibold text-slate-500 flex flex-wrap items-center gap-2">
                                <span class="text-slate-800 font-bold">📖 {{ $mapelLabel }}</span>
                                <span class="text-slate-300">•</span>
                                <span>🎓 {{ $jenjangLabel }}</span>
                                @if(!is_null($soal->poin))
                                    <span class="text-slate-300">•</span>
                                    <span>{{ $soal->poin }} Poin</span>
                                @endif
                                @if(!is_null($soal->durasi_detik))
                                    <span class="text-slate-300">•</span>
                                    <span>{{ $soal->durasi_detik }}d</span>
                                @endif
                            </div>

                            {{-- Pertanyaan + Thumbnail --}}
                            <div class="flex items-start gap-3">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold text-slate-800 leading-relaxed break-words">
                                        {{ $soal->pertanyaan }}
                                    </p>
                                </div>

                                @if($hasImage)
                                    <img
                                        src="{{ asset('storage/' . $soal->foto_soal) }}"
                                        alt="Foto soal"
                                        class="w-20 h-16 rounded-xl object-cover border border-[#DCEFFF] shrink-0 bg-slate-50">
                                @endif
                            </div>
                        </div>

                        {{-- Footer: Jawaban Benar, Penulis & Aksi --}}
                        <div class="pt-3 border-t border-slate-100 flex flex-wrap items-center justify-between gap-3">
                            <div class="text-xs text-slate-600 min-w-0 flex-1">
                                <span class="font-semibold text-slate-400">Kunci:</span>
                                <span class="font-extrabold text-emerald-700 break-words">
                                    {{ $soal->jawaban_benar ?: '-' }}
                                </span>
                                <span class="text-slate-300 mx-1">|</span>
                                <span class="text-[11px] text-slate-400">Oleh: {{ $penulisLabel }}</span>
                            </div>

                            <div class="flex items-center gap-2 shrink-0">
                                {{-- Jika Soal Kuis: Tombol Salin ke Bank Soal --}}
                                @if(!$isBank)
                                    <form action="{{ route('soal.copy.to.bank') }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="soal_ids[]" value="{{ $soal->id_soal }}">
                                        <button type="submit"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 text-xs font-bold transition cursor-pointer"
                                            title="Salin soal kuis ini ke Bank Soal">
                                            <span>💾 Salin ke Bank</span>
                                        </button>
                                    </form>
                                @endif

                                {{-- Tombol Masukkan ke Kuis --}}
                                <button type="button"
                                    class="single-assign-btn inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-sky-50 hover:bg-sky-100 text-[#007FBE] border border-[#B2E7FC] text-xs font-bold transition cursor-pointer"
                                    data-id="{{ $soal->id_soal }}"
                                    data-title="{{ Str::limit($soal->pertanyaan, 50) }}"
                                    title="Salin soal ini ke kuis atau dungeon tujuan">
                                    <span>📥 Ke Kuis</span>
                                </button>

                                @can('update', $soal)
                                    <a href="{{ route('soal.edit', $soal->id_soal) }}"
                                        class="inline-flex items-center px-3 py-1.5 rounded-xl bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200 text-xs font-bold transition">
                                        Edit
                                    </a>
                                @endcan

                                @can('delete', $soal)
                                    <form action="{{ route('soal.destroy', $soal->id_soal) }}"
                                        method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus soal ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center px-3 py-1.5 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 text-xs font-bold transition cursor-pointer">
                                            Hapus
                                        </button>
                                    </form>
                                @endcan
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            {{-- Pagination Bar --}}
            <div class="mt-8">
                {{ $soals->links() }}
            </div>
        @endif
    </main>

    {{-- MODAL ASSIGN KE KUIS --}}
    <div id="assignQuizModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-xs">
        <div class="bg-white rounded-3xl border-2 border-[#DCEFFF] max-w-md w-full p-6 shadow-2xl space-y-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="text-2xl">📥</span>
                    <h3 class="text-base font-extrabold text-slate-900">Masukkan Soal ke Kuis</h3>
                </div>
                <button type="button" id="closeAssignModalBtn" class="text-slate-400 hover:text-slate-600 font-bold text-lg cursor-pointer">
                    ✕
                </button>
            </div>

            <p class="text-xs text-slate-500" id="assignModalDesc">
                Soal yang dipilih akan disalin ke kuis tujuan. Soal yang sudah ada di kuis tersebut akan otomatis dilewati.
            </p>

            <form action="{{ route('soal.assign') }}" method="POST" id="assignQuizForm">
                @csrf
                <div id="assignHiddenInputs"></div>

                <div class="mb-4">
                    <label for="assign_id_quiz" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Pilih Kuis / Dungeon Tujuan <span class="text-rose-500">*</span>
                    </label>
                    <select id="assign_id_quiz" name="id_quiz" required
                        class="w-full px-4 py-3 rounded-2xl border-2 border-slate-200 bg-white text-sm font-bold text-slate-800 focus:outline-none focus:border-[#007FBE]">
                        <option value="">-- Pilih Kuis Tujuan --</option>
                        @if(isset($quizList))
                            @foreach($quizList as $q)
                                @php $isDng = $q->isDungeon(); @endphp
                                <option value="{{ $q->id_quiz }}">
                                    {{ $q->judul }} {{ $isDng ? '🛡️ [Dungeon]' : '' }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="flex items-center justify-end gap-2.5 pt-2">
                    <button type="button" id="cancelAssignModalBtn"
                        class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-bold text-xs hover:bg-slate-50 transition cursor-pointer">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-5 py-2.5 rounded-xl bg-[#007FBE] hover:bg-[#00689E] text-white font-extrabold text-xs shadow-[0_3px_0_#005580] transition cursor-pointer">
                        Konfirmasi & Masukkan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Form tersembunyi untuk Batch Copy to Bank Soal --}}
    <form id="batchCopyForm" action="{{ route('soal.copy.to.bank') }}" method="POST" class="hidden">
        @csrf
        <div id="batchCopyHiddenInputs"></div>
    </form>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('soalFilterForm');
            const mapelSelect = document.getElementById('soalMapelSelect');
            const sourceChipBar = document.getElementById('soalSourceFilterChips');
            const typeChipBar = document.getElementById('soalTypeFilterChips');
            const tingkatChipBar = document.getElementById('soalTingkatFilterChips');
            const jenjangChipBar = document.getElementById('soalJenjangFilterChips');

            const inputSumber = document.getElementById('filterInputSumber');
            const inputJenis = document.getElementById('filterInputJenis');
            const inputTingkat = document.getElementById('filterInputTingkat');
            const inputJenjang = document.getElementById('filterInputJenjang');

            const batchActionBar = document.getElementById('batchActionBar');
            const batchCountText = document.getElementById('batchCountText');
            const openBatchAssignBtn = document.getElementById('openBatchAssignModalBtn');
            const openBatchCopyBtn = document.getElementById('openBatchCopyToBankBtn');
            const clearBatchBtn = document.getElementById('clearBatchSelectionBtn');
            const checkboxes = Array.from(document.querySelectorAll('.soal-select-checkbox'));

            const modal = document.getElementById('assignQuizModal');
            const closeModalBtn = document.getElementById('closeAssignModalBtn');
            const cancelModalBtn = document.getElementById('cancelAssignModalBtn');
            const assignHiddenInputs = document.getElementById('assignHiddenInputs');
            const assignModalDesc = document.getElementById('assignModalDesc');

            // 1. CHIP FILTER CLICK HANDLER (Submits form to filter instantly)
            function bindChipFilter(container, hiddenInput) {
                if (!container || !hiddenInput) return;
                container.addEventListener('click', function (e) {
                    const btn = e.target.closest('[data-value]');
                    if (!btn) return;
                    const val = btn.getAttribute('data-value') || 'all';
                    hiddenInput.value = val;
                    if (form) form.submit();
                });
            }

            bindChipFilter(sourceChipBar, inputSumber);
            bindChipFilter(typeChipBar, inputJenis);
            bindChipFilter(tingkatChipBar, inputTingkat);
            bindChipFilter(jenjangChipBar, inputJenjang);

            if (mapelSelect && form) {
                mapelSelect.addEventListener('change', function () {
                    form.submit();
                });
            }

            // 2. BATCH SELECTION LOGIC
            function updateBatchUI() {
                const checked = checkboxes.filter(cb => cb.checked);
                const count = checked.length;
                if (count > 0) {
                    batchActionBar.classList.remove('hidden');
                    batchCountText.textContent = `${count} soal dipilih`;
                } else {
                    batchActionBar.classList.add('hidden');
                }
            }

            checkboxes.forEach(cb => cb.addEventListener('change', updateBatchUI));

            if (clearBatchBtn) {
                clearBatchBtn.addEventListener('click', function () {
                    checkboxes.forEach(cb => cb.checked = false);
                    updateBatchUI();
                });
            }

            // Batch Copy to Bank Soal
            if (openBatchCopyBtn) {
                openBatchCopyBtn.addEventListener('click', function () {
                    const checkedIds = checkboxes.filter(cb => cb.checked).map(cb => cb.value);
                    if (!checkedIds.length) return;
                    if (!confirm(`Salin ${checkedIds.length} soal terpilih ke Bank Soal?`)) return;

                    const batchForm = document.getElementById('batchCopyForm');
                    const hiddenContainer = document.getElementById('batchCopyHiddenInputs');
                    hiddenContainer.innerHTML = '';
                    checkedIds.forEach(id => {
                        const inp = document.createElement('input');
                        inp.type = 'hidden';
                        inp.name = 'soal_ids[]';
                        inp.value = id;
                        hiddenContainer.appendChild(inp);
                    });
                    batchForm.submit();
                });
            }

            // 3. MODAL ASSIGN TO QUIZ LOGIC
            function openAssignModal(soalIds, titleText) {
                assignHiddenInputs.innerHTML = '';
                soalIds.forEach(id => {
                    const hidden = document.createElement('input');
                    hidden.type = 'hidden';
                    hidden.name = 'soal_ids[]';
                    hidden.value = id;
                    assignHiddenInputs.appendChild(hidden);
                });

                if (titleText) {
                    assignModalDesc.textContent = `${titleText} akan disalin ke kuis tujuan. Duplikasi akan dilewati otomatis.`;
                } else {
                    assignModalDesc.textContent = `${soalIds.length} soal akan disalin ke kuis tujuan. Duplikasi akan dilewati otomatis.`;
                }

                modal.classList.remove('hidden');
            }

            function closeAssignModal() {
                modal.classList.add('hidden');
            }

            if (openBatchAssignBtn) {
                openBatchAssignBtn.addEventListener('click', function () {
                    const checkedIds = checkboxes.filter(cb => cb.checked).map(cb => cb.value);
                    if (!checkedIds.length) return;
                    openAssignModal(checkedIds, `${checkedIds.length} soal terpilih`);
                });
            }

            document.querySelectorAll('.single-assign-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    const id = btn.getAttribute('data-id');
                    const title = btn.getAttribute('data-title');
                    openAssignModal([id], `Soal: "${title}"`);
                });
            });

            if (closeModalBtn) closeModalBtn.addEventListener('click', closeAssignModal);
            if (cancelModalBtn) cancelModalBtn.addEventListener('click', closeAssignModal);
            modal.addEventListener('click', function (e) {
                if (e.target === modal) closeAssignModal();
            });
        });
    </script>
@endpush
