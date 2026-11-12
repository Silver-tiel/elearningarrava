@extends('layouts.app')

@section('header')
    <h1 class="text-lg font-bold text-gray-900">Bank Soal</h1>

    <div class="flex items-center gap-4">
        <a href="{{ route('admin.quiz') }}"
            class="inline-flex items-center gap-1.5 text-xs font-semibold text-gray-600 bg-gray-50 hover:bg-gray-100 px-3 py-1.5 rounded-lg border border-gray-200 transition">
            <span>← Kelola Kuis</span>
        </a>
    </div>
@endsection

@section('content')
    <main class="px-6 lg:px-8 py-8">
        {{-- Page heading --}}
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-7">
            <div>
                <h2 class="text-[24px] font-extrabold tracking-tight text-slate-900">
                    Daftar Soal
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Kelola seluruh bank soal pilihan ganda, benar/salah, isian singkat, dan soal bergambar.
                </p>
            </div>

            <a href="{{ route('soal.create') }}"
                class="inline-flex items-center justify-center gap-2 bg-[#007FBE] hover:bg-[#00689E] text-white font-bold text-sm px-4 py-2.5 rounded-xl shadow-[0_3px_0_#005580] transition hover:-translate-y-0.5">
                <span class="text-lg leading-none">+</span>
                <span>Tambah Soal</span>
            </a>
        </div>

        {{-- Flash message --}}
        @if(session('success'))
            <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <span class="text-xl">✓</span>
                    <span class="font-semibold text-sm">{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
                    ✕
                </button>
            </div>
        @endif

        @php
            $soalCollection = isset($soals) ? collect($soals) : collect();
            $totalSoalCount = $soalCollection->count();

            $soalFilterChips = [
                ['value' => 'all', 'label' => 'Semua', 'active' => true],
                ['value' => 'pilihan_ganda', 'label' => 'Pilihan Ganda', 'active' => false],
                ['value' => 'benar_salah', 'label' => 'Benar/Salah', 'active' => false],
                ['value' => 'isian', 'label' => 'Isian', 'active' => false],
                ['value' => 'bergambar', 'label' => 'Bergambar', 'active' => false],
            ];
        @endphp

        {{-- Filter & Search Gaya Siswa --}}
        <x-student-style-filter-bar
            class="mb-6"
            title="Filter Bank Soal"
            icon="📝"
            count-id="soal-count-badge"
            :count-text="'Menampilkan ' . $totalSoalCount . ' dari ' . $totalSoalCount . ' soal'"
            search-id="soalSearchInput"
            search-name="q"
            search-placeholder="Cari pertanyaan, jawaban benar, kode soal, atau judul kuis..."
            reset-id="soalResetBtn"
            :show-reset="false">

            <x-student-style-filter-chip-bar
                id="soalTypeFilterChips"
                label="Tipe Soal"
                :chips="$soalFilterChips" />
        </x-student-style-filter-bar>

        @if($soalCollection->isEmpty())
            <div class="bg-white rounded-3xl border border-gray-200/80 p-12 text-center shadow-sm">
                <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-sky-50 text-[#007FBE] flex items-center justify-center text-3xl">
                    📝
                </div>
                <h3 class="text-lg font-extrabold text-gray-800">Belum Ada Soal</h3>
                <p class="text-sm text-gray-500 mt-1 max-w-md mx-auto">
                    Tambahkan pertanyaan baru ke bank soal untuk digunakan dalam kuis siswa.
                </p>
                <a href="{{ route('soal.create') }}"
                    class="inline-flex items-center gap-2 mt-5 px-5 py-2.5 rounded-xl bg-[#007FBE] text-white font-bold text-sm hover:bg-[#00689E] transition">
                    <span>+ Tambah Soal Pertama</span>
                </a>
            </div>
        @else
            <div id="soalCardsContainer" class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                @foreach ($soalCollection as $soal)
                    @php
                        $rawJenis = strtolower(trim((string) ($soal->jenisSoal?->nama_jenis ?? '')));
                        $idJenis = (int) ($soal->id_jenis_soal ?? 0);

                        if (str_contains($rawJenis, 'benar') || str_contains($rawJenis, 'true_false') || str_contains($rawJenis, 'salah') || $idJenis === 3) {
                            $jenisSlug = 'benar_salah';
                            $jenisLabel = 'Benar/Salah';
                            $jenisBadgeClass = 'bg-amber-50 text-amber-700 border-amber-200';
                        } elseif (str_contains($rawJenis, 'isian') || str_contains($rawJenis, 'essay') || $idJenis === 2) {
                            $jenisSlug = 'isian';
                            $jenisLabel = 'Isian';
                            $jenisBadgeClass = 'bg-purple-50 text-purple-700 border-purple-200';
                        } else {
                            $jenisSlug = 'pilihan_ganda';
                            $jenisLabel = 'Pilihan Ganda';
                            $jenisBadgeClass = 'bg-sky-50 text-[#007FBE] border-[#B2E7FC]';
                        }

                        $hasImage = !empty($soal->foto_soal);
                        $jenjangLabel = $soal->jenjang?->nama_tipe ?? $soal->jenjang?->nama_jenjang ?? 'Umum';
                        $quizLabel = $soal->quiz?->judul ?? $soal->quiz?->judul_quiz ?? ($soal->id_quiz ? 'Kuis #' . $soal->id_quiz : 'Tanpa Kuis');
                        $searchText = strtolower(trim(implode(' ', array_filter([
                            $soal->pertanyaan ?? '',
                            $soal->jawaban_benar ?? '',
                            $soal->kode_soal ?? '',
                            $quizLabel,
                            $jenjangLabel,
                            $jenisLabel,
                            (string) ($soal->id_quiz ?? ''),
                        ]))));
                    @endphp

                    <article
                        class="soal-card bg-white rounded-2xl border-2 border-[#E6F1FC] p-5 shadow-xs hover:border-[#B2E7FC] transition flex flex-col justify-between gap-4"
                        data-type="{{ $jenisSlug }}"
                        data-has-image="{{ $hasImage ? '1' : '0' }}"
                        data-search="{{ e($searchText) }}">

                        <div class="space-y-3">
                            {{-- Badges --}}
                            <div class="flex flex-wrap items-center justify-between gap-2">
                                <div class="flex flex-wrap items-center gap-1.5">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-extrabold border {{ $jenisBadgeClass }}">
                                        {{ $jenisLabel }}
                                    </span>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-[#F0F6FF] text-[#465673] border border-[#DCEFFF]">
                                        {{ $jenjangLabel }}
                                    </span>
                                    @if($hasImage)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            🖼️ Bergambar
                                        </span>
                                    @endif
                                </div>

                                @if(!empty($soal->kode_soal))
                                    <span class="text-[11px] font-mono font-semibold text-slate-400">
                                        {{ $soal->kode_soal }}
                                    </span>
                                @endif
                            </div>

                            {{-- Quiz origin --}}
                            <div class="text-xs font-semibold text-slate-500 flex flex-wrap items-center gap-2">
                                <span class="text-[#007FBE] font-bold">{{ $quizLabel }}</span>
                                @if(!is_null($soal->poin))
                                    <span class="text-slate-300">•</span>
                                    <span>{{ $soal->poin }} Poin</span>
                                @endif
                                @if(!is_null($soal->durasi_detik))
                                    <span class="text-slate-300">•</span>
                                    <span>{{ $soal->durasi_detik }} detik</span>
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

                        {{-- Footer: Jawaban Benar & Aksi --}}
                        <div class="pt-3 border-t border-slate-100 flex flex-wrap items-center justify-between gap-3">
                            <div class="text-xs text-slate-600 min-w-0 flex-1">
                                <span class="font-semibold text-slate-400">Jawaban Benar:</span>
                                <span class="font-extrabold text-emerald-700 break-words">
                                    {{ $soal->jawaban_benar ?: '-' }}
                                </span>
                            </div>

                            <div class="flex items-center gap-2 shrink-0">
                                <a href="{{ route('soal.edit', $soal->id_soal) }}"
                                    class="inline-flex items-center px-3 py-1.5 rounded-xl bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200 text-xs font-bold transition">
                                    Edit
                                </a>

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
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            {{-- Empty search state --}}
            <div id="soalNoResults" class="hidden bg-white rounded-3xl border border-gray-200/80 p-10 text-center shadow-sm mt-4">
                <p class="text-base font-extrabold text-slate-800">Tidak ada soal yang cocok dengan filter.</p>
                <p class="text-xs text-slate-500 mt-1">Coba ubah kata kunci pencarian atau pilih tipe soal lainnya.</p>
                <button type="button" id="soalEmptyResetBtn"
                    class="mt-4 inline-flex items-center gap-1.5 px-4 py-2 rounded-full bg-[#007FBE] text-white text-xs font-extrabold hover:bg-[#00689E] transition cursor-pointer">
                    Reset Filter
                </button>
            </div>
        @endif
    </main>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('soalSearchInput');
            const searchClearBtn = document.getElementById('soalSearchInputClear');
            const chipBar = document.getElementById('soalTypeFilterChips');
            const resetBtn = document.getElementById('soalResetBtn');
            const emptyResetBtn = document.getElementById('soalEmptyResetBtn');
            const countBadge = document.getElementById('soal-count-badge');
            const cardsContainer = document.getElementById('soalCardsContainer');
            const noResultsEl = document.getElementById('soalNoResults');
            const cards = Array.from(document.querySelectorAll('.soal-card'));
            const totalCards = cards.length;
            const filterHelper = window.ArravaStudentFilter;

            if (!cards.length) return;

            let activeType = 'all';

            function applySoalFilter() {
                const keyword = (searchInput ? searchInput.value : '').trim().toLowerCase();
                let visibleCount = 0;

                cards.forEach(card => {
                    const cardType = card.getAttribute('data-type') || '';
                    const hasImage = card.getAttribute('data-has-image') === '1';
                    const haystack = card.getAttribute('data-search') || '';

                    const matchesType = activeType === 'all'
                        ? true
                        : (activeType === 'bergambar' ? hasImage : cardType === activeType);

                    const matchesSearch = !keyword || haystack.includes(keyword);
                    const isVisible = matchesType && matchesSearch;

                    card.classList.toggle('hidden', !isVisible);
                    if (isVisible) visibleCount++;
                });

                if (countBadge) {
                    countBadge.textContent = `Menampilkan ${visibleCount} dari ${totalCards} soal`;
                }

                const isFiltered = activeType !== 'all' || keyword !== '';
                if (resetBtn) {
                    resetBtn.classList.toggle('hidden', !isFiltered);
                    resetBtn.classList.toggle('inline-flex', isFiltered);
                }

                if (cardsContainer) {
                    cardsContainer.classList.toggle('hidden', visibleCount === 0);
                }
                if (noResultsEl) {
                    noResultsEl.classList.toggle('hidden', visibleCount > 0);
                }
            }

            function resetSoalFilter() {
                activeType = 'all';
                if (searchInput) {
                    searchInput.value = '';
                }
                if (searchClearBtn) {
                    searchClearBtn.classList.add('hidden');
                    searchClearBtn.classList.remove('inline-flex');
                }
                if (chipBar && filterHelper) {
                    filterHelper.setActiveChip(chipBar, 'all');
                }
                applySoalFilter();
            }

            if (chipBar) {
                chipBar.addEventListener('click', function (event) {
                    const btn = event.target.closest('[data-value]');
                    if (!btn) return;
                    activeType = btn.getAttribute('data-value') || 'all';
                    if (filterHelper) {
                        filterHelper.setActiveChip(chipBar, activeType);
                    }
                    applySoalFilter();
                });
            }

            if (filterHelper) {
                filterHelper.bindSearchClear(searchInput, searchClearBtn, applySoalFilter);
            } else if (searchInput) {
                searchInput.addEventListener('input', applySoalFilter);
            }

            if (resetBtn) {
                resetBtn.addEventListener('click', resetSoalFilter);
            }
            if (emptyResetBtn) {
                emptyResetBtn.addEventListener('click', resetSoalFilter);
            }
        });
    </script>
@endpush
